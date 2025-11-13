<?php

namespace App\Controllers;

use App\Models\ObatModel;
use CodeIgniter\Controller;

class Transaksi extends Controller
{
    protected $obat;
    protected $session;

    public function __construct()
    {
        $this->obat = new ObatModel();
        $this->session = session();
    }

    public function index()
    {
        $cart = $this->session->get('cart') ?? [];

        $total = array_sum(array_column($cart, 'subtotal'));
        $total_qty = array_sum(array_column($cart, 'jumlah'));

        $data = [
            'title' => 'Transaksi Penjualan',
            'cart' => $cart,
            'total' => $total,
            'total_qty' => $total_qty,
            'today' => date('Y-m-d'),
        ];

        return view('transaksi/index', $data);
    }

    public function bayar()
    {
        // contoh sederhana
        $this->session->remove('cart');
        return redirect()->to('/penjualan')->with('success', 'Transaksi berhasil disimpan!');
    }

    public function remove($id_obat)
    {
        $cart = $this->session->get('cart') ?? [];
        unset($cart[$id_obat]); // hapus item dari session cart
        $this->session->set('cart', $cart);
        return redirect()->to('/transaksi')->with('success', 'Obat dihapus dari keranjang.');
    }   

public function updateQuantity()
{
    $id = $this->request->getPost('id_obat');
    $jumlah = (int)$this->request->getPost('jumlah');
    $cart = $this->session->get('cart') ?? [];

    if (isset($cart[$id])) {
        $cart[$id]['jumlah'] = $jumlah;
        $cart[$id]['subtotal'] = $jumlah * $cart[$id]['harga_jual'];
        $this->session->set('cart', $cart);

        $total = array_sum(array_column($cart, 'subtotal'));

        return $this->response->setJSON([
            'success' => true,
            'subtotal' => number_format($cart[$id]['subtotal'], 0, ',', '.'),
            'total' => number_format($total, 0, ',', '.')
        ]);
    }

    return $this->response->setJSON(['success' => false]);
}


public function hitungKembalian()
{
    $bayar = (float) $this->request->getPost('bayar');
    $total = (float) $this->request->getPost('total');
    $kembalian = $bayar - $total;
    return $this->response->setJSON(['kembalian' => max(0, $kembalian)]);
}


//TRNSAKSI
public function proses()
{
    $cart = session()->get('cart') ?? [];
    $bayar = $this->request->getPost('bayar');
    $total = 0;

    if (empty($cart)) {
        return redirect()->back()->with('error', 'Keranjang kosong!');
    }

    // Hitung total
    foreach ($cart as $item) {
        $total += $item['subtotal'];
    }

    $kembalian = $bayar - $total;

    $transaksiModel = new \App\Models\TransaksiModel();
    $detailModel = new \App\Models\TransaksiDetailModel();
    $laporanModel = new \App\Models\LaporanTransaksiModel();
    $obatModel = new \App\Models\ObatModel();

    // Simpan transaksi
    $transaksiData = [
        'tanggal_transaksi' => date('Y-m-d H:i:s'),
        'total_harga'       => $total,
        'uang_dibayar'      => $bayar,
        'uang_kembalian'    => $kembalian,
    ];
    $transaksiModel->insert($transaksiData);
    $transaksi_id = $transaksiModel->getInsertID();

    // Simpan detail + kurangi stok
    foreach ($cart as $item) {
        $detailModel->insert([
            'id_transaksi' => $transaksi_id,
            'id_obat'      => $item['id_obat'],
            'jumlah'       => $item['jumlah'],
            'harga'        => $item['harga_jual'],
            'subtotal'     => $item['subtotal'],
        ]);

        // Kurangi stok
        $obat = $obatModel->find($item['id_obat']);
        if ($obat) {
            $obatModel->update($item['id_obat'], [
                'stok' => max(0, $obat['stok'] - $item['jumlah'])
            ]);
        }
    }

    // Simpan ke laporan
    $laporanModel->insert([
        'id_transaksi'     => $transaksi_id,
        'total_harga'      => $total,
        'uang_dibayar'     => $bayar,
        'uang_kembalian'   => $kembalian,
        'tanggal_transaksi'=> date('Y-m-d H:i:s'),
    ]);

    // Bersihkan cart
    session()->remove('cart');

    return redirect()->to('/transaksi')->with('success', 'Transaksi berhasil disimpan!');
}




}
