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
        $this->session->remove('cart');
        return redirect()->to('/penjualan')->with('success', 'Transaksi berhasil disimpan!');
    }

    public function remove($id_obat)
    {
        $cart = $this->session->get('cart') ?? [];
        unset($cart[$id_obat]);
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

    public function proses()
    {
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            $cart = $this->session->get('cart') ?? [];
            $bayar = $this->request->getPost('bayar');
            
            log_message('debug', '=== TRANSAKSI PROSES START ===');
            log_message('debug', 'Cart: ' . json_encode($cart));
            log_message('debug', 'Bayar (raw): ' . $bayar);
            
            if (empty($cart)) {
                log_message('error', 'Cart kosong');
                return redirect()->back()->with('error', 'Keranjang kosong!');
            }

            if (empty($bayar) || !is_numeric($bayar) || $bayar <= 0) {
                log_message('error', 'Bayar tidak valid: ' . $bayar);
                return redirect()->back()->with('error', 'Jumlah bayar tidak valid!');
            }

            $bayar = (float) $bayar;
            $total = 0;
            $total_keuntungan = 0; // 🟢 TAMBAHAN: Hitung keuntungan

            // Hitung total dan keuntungan
            foreach ($cart as $item) {
                $total += $item['subtotal'];
                
                // 🟢 Ambil harga beli untuk hitung keuntungan
                $obat = $this->obat->find($item['id_obat']);
                if ($obat) {
                    $harga_beli_total = $obat['harga_beli'] * $item['jumlah'];
                    $harga_jual_total = $item['subtotal'];
                    $keuntungan_item = $harga_jual_total - $harga_beli_total;
                    $total_keuntungan += $keuntungan_item;
                }
            }

            if ($bayar < $total) {
                return redirect()->back()->with('error', 'Uang bayar kurang! Total: Rp ' . number_format($total, 0, ',', '.'));
            }

            $kembalian = $bayar - $total;

            $transaksiModel = new \App\Models\TransaksiModel();
            $detailModel = new \App\Models\TransaksiDetailModel();
            $laporanModel = new \App\Models\LaporanTransaksiModel();
            $obatModel = new \App\Models\ObatModel();
            
            // Cek stok
            foreach ($cart as $item) {
                $obat = $obatModel->find($item['id_obat']);
                if (!$obat) {
                    $db->transRollback();
                    return redirect()->back()->with('error', 'Obat dengan ID ' . $item['id_obat'] . ' tidak ditemukan!');
                }
                if ($obat['stok'] < $item['jumlah']) {
                    $db->transRollback();
                    return redirect()->back()->with('error', 'Stok ' . $obat['nama_obat'] . ' tidak mencukupi! Stok tersedia: ' . $obat['stok']);
                }
            }

            // Simpan transaksi
            $transaksiData = [
                'tanggal_transaksi' => date('Y-m-d H:i:s'),
                'total'       => $total,
                'uang_dibayar'      => $bayar,
                'uang_kembalian'    => $kembalian,
            ];
            
            if (!$transaksiModel->insert($transaksiData)) {
                $errors = $transaksiModel->errors();
                log_message('error', 'Insert transaksi gagal: ' . json_encode($errors));
                $db->transRollback();
                return redirect()->back()->with('error', 'Gagal menyimpan transaksi: ' . implode(', ', $errors));
            }
            
            $transaksi_id = $transaksiModel->getInsertID();

            // Simpan detail + kurangi stok
            foreach ($cart as $item) {
                $detailData = [
                    'id_transaksi' => $transaksi_id,
                    'id_obat'      => $item['id_obat'],
                    'jumlah'       => $item['jumlah'],
                    'harga'        => $item['harga_jual'],
                    'subtotal'     => $item['subtotal'],
                ];
                
                if (!$detailModel->insert($detailData)) {
                    $db->transRollback();
                    return redirect()->back()->with('error', 'Gagal menyimpan detail transaksi!');
                }

                $obat = $obatModel->find($item['id_obat']);
                if ($obat) {
                    $stokBaru = max(0, $obat['stok'] - $item['jumlah']);
                    if (!$obatModel->update($item['id_obat'], ['stok' => $stokBaru])) {
                        $db->transRollback();
                        return redirect()->back()->with('error', 'Gagal mengupdate stok obat!');
                    }
                }
            }

            $kode_transaksi = 'TRX-' . date('YmdHis');

            $nama_lengkap = $this->session->get('nama_lengkap');
            $role_user    = $this->session->get('role');

            $nama_kasir_dan_role = $nama_lengkap . ' (' . ucfirst($role_user) . ')';

            // 🟢 Simpan laporan dengan keuntungan
            $laporanData = [
                'kode_transaksi' => $kode_transaksi,
                'id_transaksi'   => $transaksi_id,
                'total_harga'    => $total,
                'keuntungan'     => $total_keuntungan, // 🟢 TAMBAHAN
                'bayar'          => $bayar,
                'kembalian'      => $kembalian,
                'items'          => json_encode(array_values($cart)),
                'tanggal'        => date('Y-m-d H:i:s'),
                'nama_kasir'     => $nama_kasir_dan_role,
            ];

            if (!$laporanModel->insert($laporanData)) {
                $db->transRollback();
                return redirect()->back()->with('error', 'Gagal menyimpan laporan transaksi!');
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                return redirect()->back()->with('error', 'Transaksi gagal! Silakan coba lagi.');
            }

            // app/Controllers/Transaksi.php
// ...
            $laporan_id = $laporanModel->getInsertID(); // Ambil ID dari tabel laporan_transaksi

            $this->session->remove('cart');

            // 💡 MODIFIKASI: Menggunakan flashdata untuk menyimpan ID laporan yang baru
            return redirect()->to('/transaksi')
                ->with('success_transaction', 'Transaksi berhasil!') // Pesan sukses utama
                ->with('laporan_id', $laporan_id); // ID untuk dicetak struk
// ...

        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', 'Error transaksi: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}