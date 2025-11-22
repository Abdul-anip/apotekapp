<?php
namespace App\Controllers;

use App\Models\KategoriModel;
use App\Models\ObatModel;

class Obat extends BaseController
{
    protected $obat;
    protected $kategori;

    public function __construct()
    {
        $this->obat = new ObatModel();
        $this->kategori = new KategoriModel();
    }

    public function index()
    {
        $data['title'] = "Data Obat";
        $data['obat'] = $this->obat
            ->select('obat.*, kategori.nama_kategori')
            ->join('kategori', 'kategori.id = obat.category_id', 'left')
            ->findAll();
        $data['kategori'] = $this->kategori->findAll();
        
        return view('obat/index', $data);
    }

    public function store()
    {
        $this->obat->save([
            'nama_obat' => $this->request->getPost('nama_obat'),
            'category_id' => $this->request->getPost('category_id'),
            'harga_beli' => $this->request->getPost('harga_beli'),
            'harga_jual' => $this->request->getPost('harga_jual'),
            'stok' => $this->request->getPost('stok'),
            'tanggal_kadaluarsa' => $this->request->getPost('tanggal_kadaluarsa'),
        ]);

        return redirect()->to('/obat')->with('success', 'Obat berhasil ditambahkan!');
    }

    public function update($id)
    {
        $this->obat->update($id, [
            'nama_obat' => $this->request->getPost('nama_obat'),
            'category_id' => $this->request->getPost('category_id'),
            'harga_beli' => $this->request->getPost('harga_beli'),
            'harga_jual' => $this->request->getPost('harga_jual'),
            'stok' => $this->request->getPost('stok'),
            'tanggal_kadaluarsa' => $this->request->getPost('tanggal_kadaluarsa'),
        ]);

        return redirect()->to('/obat')->with('success', 'Obat berhasil diperbarui!');
    }

    public function delete($id)
    {
        $this->obat->delete($id);
        return redirect()->to('/obat')->with('success', 'Obat berhasil dihapus!');
    }
}