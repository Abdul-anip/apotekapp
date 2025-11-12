<?php

namespace App\Controllers;

use App\Models\ObatModel;
use CodeIgniter\Controller;

class Penjualan extends Controller
{
    protected $obat;
    protected $session;

    public function __construct()
    {
        $this->obat = new ObatModel();
        $this->session = session();
    }

    // 🟢 Halaman utama penjualan
    public function index()
    {
        $data = [
            'title' => 'Penjualan Obat',
            'obat'  => $this->obat->findAll(),
            'cart'  => $this->session->get('cart') ?? []
        ];

        return view('penjualan/index', $data);
    }

    // 🟢 Tambah obat ke keranjang berdasarkan ID dari URL
    public function add($id_obat)
    {
        $obat = $this->obat->find($id_obat);
        if (!$obat) {
            return redirect()->to('/penjualan')->with('error', 'Obat tidak ditemukan.');
        }

        $cart = $this->session->get('cart') ?? [];

        // Jika obat sudah ada di keranjang, tambahkan jumlah
        if (isset($cart[$id_obat])) {
            $cart[$id_obat]['jumlah']++;
            $cart[$id_obat]['subtotal'] = $cart[$id_obat]['jumlah'] * $obat['harga_jual'];
        } else {
            $cart[$id_obat] = [
                'id_obat'    => $obat['id_obat'],
                'nama_obat'  => $obat['nama_obat'],
                'harga_jual' => $obat['harga_jual'],
                'jumlah'     => 1,
                'subtotal'   => $obat['harga_jual'],
            ];
        }

        $this->session->set('cart', $cart);
        return redirect()->to('/penjualan')->with('success', 'Obat berhasil ditambahkan ke keranjang.');
    }

    // 🟢 Hapus item dari keranjang
    public function remove($id_obat)
    {
        $cart = $this->session->get('cart') ?? [];
        unset($cart[$id_obat]);
        $this->session->set('cart', $cart);

        return redirect()->to('/penjualan')->with('success', 'Obat berhasil dihapus dari keranjang.');
    }

    // 🟢 Lanjut ke transaksi
    public function checkout()
    {
        return redirect()->to('/transaksi');
    }
}
