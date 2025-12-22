<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\GejalaModel;

class Gejala extends BaseController
{
    protected $gejalaModel;
    protected $session;

    public function __construct()
    {
        $this->gejalaModel = new GejalaModel();
        $this->session = session();
        
        if ($this->session->get('role') !== 'pemilik') {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Halaman tidak ditemukan');
        }
    }

    public function index()
    {
        $db = \Config\Database::connect();
        
        // Get gejala dengan jumlah aturan
        $gejala = $db->table('gejala')
            ->select('gejala.*, COUNT(aturan.id) as jumlah_aturan')
            ->join('aturan', 'aturan.id_gejala = gejala.id', 'left')
            ->groupBy('gejala.id')
            ->orderBy('gejala.kode_gejala', 'ASC')
            ->get()
            ->getResultArray();

        // Statistik
        $totalGejala = $this->gejalaModel->countAll();
        $gejalaDigunakan = $db->table('gejala')
            ->select('COUNT(DISTINCT gejala.id) as total')
            ->join('aturan', 'aturan.id_gejala = gejala.id')
            ->get()
            ->getRow()
            ->total ?? 0;

        $data = [
            'title'  => 'Manajemen Gejala',
            'gejala' => $gejala,
            'stats'  => [
                'total'      => $totalGejala,
                'digunakan'  => $gejalaDigunakan,
                'tidak_digunakan' => $totalGejala - $gejalaDigunakan
            ]
        ];

        return view('admin/gejala/index', $data);
    }

    public function create()
    {
        // Generate kode otomatis
        $lastGejala = $this->gejalaModel->orderBy('id', 'DESC')->first();
        $kodeOtomatis = 'G001';
        
        if ($lastGejala) {
            $lastKode = $lastGejala['kode_gejala'];
            $number = (int)substr($lastKode, 1);
            $newNumber = $number + 1;
            $kodeOtomatis = 'G' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
        }

        $data = [
            'title'         => 'Tambah Gejala Baru',
            'kode_otomatis' => $kodeOtomatis
        ];

        return view('admin/gejala/create', $data);
    }

    public function store()
    {
        $rules = [
            'kode_gejala' => 'required|min_length[3]|max_length[10]|is_unique[gejala.kode_gejala]',
            'nama_gejala' => 'required|min_length[3]|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'kode_gejala' => strtoupper($this->request->getPost('kode_gejala')),
            'nama_gejala' => $this->request->getPost('nama_gejala'),
            'created_at'  => date('Y-m-d H:i:s')
        ];

        if ($this->gejalaModel->insert($data)) {
            return redirect()->to('/admin/gejala')->with('success', 'Gejala berhasil ditambahkan!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan gejala!');
        }
    }

    public function edit($id)
    {
        $gejala = $this->gejalaModel->find($id);
        
        if (!$gejala) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Gejala tidak ditemukan');
        }

        $data = [
            'title'  => 'Edit Gejala',
            'gejala' => $gejala
        ];

        return view('admin/gejala/edit', $data);
    }

    public function update($id)
    {
        $gejala = $this->gejalaModel->find($id);
        
        if (!$gejala) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Gejala tidak ditemukan');
        }

        $rules = [
            'kode_gejala' => "required|min_length[3]|max_length[10]|is_unique[gejala.kode_gejala,id,{$id}]",
            'nama_gejala' => 'required|min_length[3]|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'kode_gejala' => strtoupper($this->request->getPost('kode_gejala')),
            'nama_gejala' => $this->request->getPost('nama_gejala'),
            'updated_at'  => date('Y-m-d H:i:s')
        ];

        if ($this->gejalaModel->update($id, $data)) {
            return redirect()->to('/admin/gejala')->with('success', 'Gejala berhasil diperbarui!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui gejala!');
        }
    }

    public function delete($id)
    {
        $gejala = $this->gejalaModel->find($id);
        
        if (!$gejala) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Gejala tidak ditemukan');
        }

        // Cek apakah gejala digunakan dalam aturan
        $db = \Config\Database::connect();
        $countAturan = $db->table('aturan')->where('id_gejala', $id)->countAllResults();

        if ($countAturan > 0) {
            // Hapus aturan terkait terlebih dahulu
            $db->transStart();
            $db->table('aturan')->where('id_gejala', $id)->delete();
            $this->gejalaModel->delete($id);
            $db->transComplete();

            if ($db->transStatus() === false) {
                return redirect()->to('/admin/gejala')->with('error', 'Gagal menghapus gejala!');
            }

            return redirect()->to('/admin/gejala')->with('success', "Gejala dan {$countAturan} aturan terkait berhasil dihapus!");
        } else {
            if ($this->gejalaModel->delete($id)) {
                return redirect()->to('/admin/gejala')->with('success', 'Gejala berhasil dihapus!');
            } else {
                return redirect()->to('/admin/gejala')->with('error', 'Gagal menghapus gejala!');
            }
        }
    }

    public function generateKode()
    {
        $lastGejala = $this->gejalaModel->orderBy('id', 'DESC')->first();
        $kodeOtomatis = 'G001';
        
        if ($lastGejala) {
            $lastKode = $lastGejala['kode_gejala'];
            $number = (int)substr($lastKode, 1);
            $newNumber = $number + 1;
            $kodeOtomatis = 'G' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
        }

        return $this->response->setJSON(['kode' => $kodeOtomatis]);
    }

    public function importExcel()
    {
        $data = [
            'title' => 'Import Gejala dari Excel'
        ];
        
        return view('admin/gejala/import', $data);
    }

    public function processImport()
    {
        // Validasi file
        $rules = [
            'file_excel' => [
                'rules' => 'uploaded[file_excel]|ext_in[file_excel,xlsx,xls]|max_size[file_excel,2048]',
                'errors' => [
                    'uploaded' => 'File harus diupload',
                    'ext_in' => 'File harus berformat .xlsx atau .xls',
                    'max_size' => 'Ukuran file maksimal 2MB'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $file = $this->request->getFile('file_excel');
        
        if (!$file->isValid()) {
            return redirect()->back()->with('error', 'File tidak valid!');
        }

        // Pindahkan file ke folder temporary
        $newName = $file->getRandomName();
        $file->move(WRITEPATH . 'uploads', $newName);
        $filepath = WRITEPATH . 'uploads/' . $newName;

        try {
            // Load library PhpSpreadsheet
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filepath);
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();

            $db = \Config\Database::connect();
            
            // OPTIMASI: Ambil semua kode gejala yang ada di DB sekaligus
            // untuk menghindari query berulang di dalam loop (N+1 Problem)
            $existingData = $this->gejalaModel->select('kode_gejala')->findAll();
            $existingCodes = array_column($existingData, 'kode_gejala');
            // Normalisasi ke uppercase untuk perbandingan
            $existingCodes = array_map('strtoupper', $existingCodes);

            // Tracking kode yang baru di-insert di sesi import ini
            // untuk mencegah duplikasi antar-baris di file Excel yang sama
            $codesInCurrentFile = [];

            $db->transStart();

            $inserted = 0;
            $skipped = 0;
            $errors = [];

            // Skip header row (index 0)
            for ($i = 1; $i < count($rows); $i++) {
                $row = $rows[$i];
                $rowNumber = $i + 1; // Baris Excel (1-based)
                
                // Skip row kosong (jika kode dan nama kosong)
                if (empty($row[0]) && empty($row[1])) {
                    continue;
                }

                $kodeGejala = strtoupper(trim($row[0] ?? ''));
                $namaGejala = trim($row[1] ?? '');

                // 1. Validasi Kelengkapan Data
                if (empty($kodeGejala) || empty($namaGejala)) {
                    $errors[] = "Baris {$rowNumber}: Kode atau nama gejala kosong";
                    $skipped++;
                    continue;
                }

                // 2. Validasi Format Kode (Hanya Huruf dan Angka)
                if (!preg_match('/^[A-Z0-9]+$/', $kodeGejala)) {
                    $errors[] = "Baris {$rowNumber}: Kode '{$kodeGejala}' mengandung karakter tidak valid (gunakan huruf & angka, tanpa spasi)";
                    $skipped++;
                    continue;
                }

                // 3. Cek Duplikasi di Database (Memory Check)
                if (in_array($kodeGejala, $existingCodes)) {
                    $errors[] = "Baris {$rowNumber}: Kode '{$kodeGejala}' sudah ada di database";
                    $skipped++;
                    continue;
                }

                // 4. Cek Duplikasi Internal File Excel
                if (in_array($kodeGejala, $codesInCurrentFile)) {
                    $errors[] = "Baris {$rowNumber}: Kode '{$kodeGejala}' duplikat (ganda) di dalam file Excel ini";
                    $skipped++;
                    continue;
                }

                // Insert data
                $data = [
                    'kode_gejala' => $kodeGejala,
                    'nama_gejala' => $namaGejala,
                    'created_at'  => date('Y-m-d H:i:s')
                ];

                if ($this->gejalaModel->insert($data)) {
                    $inserted++;
                    // Update tracking arrays
                    $existingCodes[] = $kodeGejala;
                    $codesInCurrentFile[] = $kodeGejala;
                } else {
                    $errors[] = "Baris {$rowNumber}: Gagal menyimpan data database";
                    $skipped++;
                }
            }

            $db->transComplete();

            // Hapus file temporary
            @unlink($filepath);

            if ($db->transStatus() === false) {
                return redirect()->back()->with('error', 'Gagal melakukan transaksi database. Tidak ada data yang disimpan.');
            }

            $message = "Import selesai! <b>{$inserted}</b> data sukses, <b>{$skipped}</b> data dilewati/gagal.";
            
            if (!empty($errors)) {
                $this->session->setFlashdata('import_errors', $errors);
            }

            return redirect()->to('/admin/gejala')->with('success', $message);

        } catch (\Exception $e) {
            // Hapus file temporary jika ada error exception
            if (file_exists($filepath)) {
                @unlink($filepath);
            }
            
            return redirect()->back()->with('error', 'System Error: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $sheet->setCellValue('A1', 'Kode Gejala');
        $sheet->setCellValue('B1', 'Nama Gejala');

        // Style header
        $styleArray = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '0d9488']
            ]
        ];
        $sheet->getStyle('A1:B1')->applyFromArray($styleArray);

        // Contoh data
        $sheet->setCellValue('A2', 'G001');
        $sheet->setCellValue('B2', 'Demam tinggi (>38°C)');
        $sheet->setCellValue('A3', 'G002');
        $sheet->setCellValue('B3', 'Batuk kering');
        $sheet->setCellValue('A3', 'G003');
        $sheet->setCellValue('B3', 'Batuk berdahak');

        // Auto size columns
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);

        // Output file
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Template_Import_Gejala.xlsx"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        exit;
    }
}