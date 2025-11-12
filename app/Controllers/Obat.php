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

    // List semua obat
    public function index()
    {
        $data['title'] = "Data Obat";

        // Ambil data obat + join ke kategori
        $data['obat'] = $this->obat
            ->select('obat.*, kategori.nama_kategori')
            ->join('kategori', 'kategori.id = obat.category_id', 'left')
            ->findAll();

        return view('obat/index', $data);
    }


    // Form tambah obat
    public function create()
    {
        $data['title'] = "Tambah Obat";
        $data['kategori'] = $this->kategori->findAll();
        return view('obat/create', $data);
    }

    // Simpan data baru
    public function store()
    {
        $this->obat->save([
            'nama_obat' => $this->request->getPost('nama_obat'),
            'category_id' => $this->request->getPost('category_id'), // <- ganti
            'harga_beli' => $this->request->getPost('harga_beli'),
            'harga_jual' => $this->request->getPost('harga_jual'),
            'stok' => $this->request->getPost('stok'),
            'tanggal_kadaluarsa' => $this->request->getPost('tanggal_kadaluarsa'),
        ]);

        return redirect()->to('/obat');
    }

    // Form edit
    public function edit($id)
    {
        $data['title'] = "Edit Obat";
        $data['obat'] = $this->obat->find($id);
        $data['kategori'] = $this->kategori->findAll();
        return view('obat/edit', $data);
    }

    // Update data
    public function update($id)
{
    $this->obat->update($id, [
        'nama_obat' => $this->request->getPost('nama_obat'),
        'category_id' => $this->request->getPost('category_id'), // <- ganti
        'harga_beli' => $this->request->getPost('harga_beli'),
        'harga_jual' => $this->request->getPost('harga_jual'),
        'stok' => $this->request->getPost('stok'),
        'tanggal_kadaluarsa' => $this->request->getPost('tanggal_kadaluarsa'),
    ]);

    return redirect()->to('/obat');
}


    // Hapus data
    public function delete($id)
    {
        $this->obat->delete($id);
        return redirect()->to('/obat');
    }

    
}
