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
}
