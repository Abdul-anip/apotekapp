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
        $rules = [
            'nama_obat' => 'required',
            'merk' => 'required',
            'category_id' => 'required',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'stok' => 'required|integer',
            'tanggal_kadaluarsa' => 'required|valid_date'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->obat->save([
            'nama_obat' => $this->request->getPost('nama_obat'),
            'merk' => $this->request->getPost('merk'),
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
        $rules = [
            'nama_obat' => 'required',
            'merk' => 'required',
            'category_id' => 'required',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'stok' => 'required|integer',
            'tanggal_kadaluarsa' => 'required|valid_date'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->obat->update($id, [
            'nama_obat' => $this->request->getPost('nama_obat'),
            'merk' => $this->request->getPost('merk'),
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

    public function importExcel()
    {
        $data['title'] = "Import Data Obat";
        return view('obat/import', $data);
    }

    public function downloadTemplate()
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $headers = ['Nama Obat', 'Merk', 'Kategori', 'Harga Beli', 'Harga Jual', 'Stok', 'Tanggal Kadaluarsa (YYYY-MM-DD)'];
        $column = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($column . '1', $header);
            $column++;
        }

        // Style header
        $styleArray = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '0d9488']]
        ];
        $sheet->getStyle('A1:G1')->applyFromArray($styleArray);

        // Contoh Data
        $sheet->setCellValue('A2', 'Paramex');
        $sheet->setCellValue('B2', 'Konimex');
        $sheet->setCellValue('C2', 'Obat Bebas');
        $sheet->setCellValue('D2', '2000');
        $sheet->setCellValue('E2', '3000');
        $sheet->setCellValue('F2', '100');
        $sheet->setCellValue('G2', date('Y-m-d', strtotime('+1 year')));

        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Template_Import_Obat.xlsx"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        exit;
    }

    public function processImport()
    {
        $rules = [
            'file_excel' => [
                'rules' => 'uploaded[file_excel]|ext_in[file_excel,xlsx,xls]|max_size[file_excel,5120]',
                'errors' => [
                    'uploaded' => 'File harus diupload',
                    'ext_in' => 'File harus berformat .xlsx atau .xls',
                    'max_size' => 'Ukuran file maksimal 5MB'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $file = $this->request->getFile('file_excel');
        $newName = $file->getRandomName();
        $file->move(WRITEPATH . 'uploads', $newName);
        $filepath = WRITEPATH . 'uploads/' . $newName;

        try {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filepath);
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();

            $inserted = 0;
            $skipped = 0;
            $errors = [];

            // Pre-load semua kategori untuk lookup (Name -> ID)
            $categories = $this->kategori->findAll();
            $categoryMap = [];
            foreach ($categories as $cat) {
                // Key: Nama Kategori lowercase
                $categoryMap[strtolower(trim($cat['nama_kategori']))] = $cat['id']; 
            }

            for ($i = 1; $i < count($rows); $i++) {
                $row = $rows[$i];
                // Skip empty rows
                if (empty($row[0])) continue;

                $namaObat = trim($row[0] ?? '');
                $merk = trim($row[1] ?? '');
                $kategoriNama = trim($row[2] ?? '');
                $hargaBeli = $row[3] ?? 0;
                $hargaJual = $row[4] ?? 0;
                $stok = $row[5] ?? 0;
                $tglExp = $row[6] ?? '';

                // Validasi dasar
                if (empty($namaObat) || !is_numeric($hargaBeli)) {
                    $errors[] = "Baris " . ($i+1) . ": Nama obat kosong atau harga tidak valid.";
                    $skipped++;
                    continue;
                }

                // Lookup Kategori ID
                $categoryId = null;
                if (!empty($kategoriNama)) {
                     $catKey = strtolower($kategoriNama);
                     if (isset($categoryMap[$catKey])) {
                         $categoryId = $categoryMap[$catKey];
                     } else {
                         // Auto-create Category if not exists
                         try {
                             $this->kategori->insert(['nama_kategori' => $kategoriNama]);
                             $newId = $this->kategori->getInsertID();
                             
                             if ($newId) {
                                 $categoryId = $newId;
                                 $categoryMap[$catKey] = $newId; // Update local map
                             } else {
                                 $errors[] = "Baris " . ($i+1) . ": Gagal input kategori '$kategoriNama'.";
                                 $skipped++;
                                 continue;
                             }
                         } catch (\Exception $e) {
                             $errors[] = "Baris " . ($i+1) . ": Error buat kategori '$kategoriNama'.";
                             $skipped++;
                             continue;
                         }
                     }
                } else {
                    // Assign to 'Uncategorized' or just insert with null?
                    // Let's create a default category 'Umum' if input is empty
                    $catKey = 'umum';
                    if (isset($categoryMap[$catKey])) {
                        $categoryId = $categoryMap[$catKey];
                    } else {
                        $this->kategori->insert(['nama_kategori' => 'Umum']);
                        $categoryId = $this->kategori->getInsertID();
                        $categoryMap[$catKey] = $categoryId;
                    }
                }
                
                // Format Tanggal Excel (kadang integer)
                if (is_numeric($tglExp)) {
                    $tglExp = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($tglExp)->format('Y-m-d');
                }

                $this->obat->save([
                    'nama_obat' => $namaObat,
                    'merk' => $merk,
                    'category_id' => $categoryId,
                    'harga_beli' => $hargaBeli,
                    'harga_jual' => $hargaJual,
                    'stok' => $stok,
                    'tanggal_kadaluarsa' => $tglExp
                ]);
                
                $inserted++;
            }

            @unlink($filepath);

            $msg = "Import Selesai! $inserted data berhasil ditambahkan.";
            if ($skipped > 0) $msg .= " ($skipped data dilewati, cek detail error).";

            if (!empty($errors)) {
                return redirect()->to('/obat')->with('success', $msg)->with('import_errors', $errors);
            }

            return redirect()->to('/obat')->with('success', $msg);

        } catch (\Exception $e) {
            @unlink($filepath);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}