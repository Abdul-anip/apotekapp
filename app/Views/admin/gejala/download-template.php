<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Template Excel - Import Gejala</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Arial, sans-serif;
            background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            max-width: 800px;
            width: 100%;
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #0d9488 0%, #14b8a6 100%);
            color: white;
            padding: 40px;
            text-align: center;
        }

        .header h1 {
            font-size: 2rem;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .header p {
            opacity: 0.9;
            font-size: 1.1rem;
        }

        .content {
            padding: 40px;
        }

        .info-card {
            background: #f0fdfa;
            border: 2px solid #0d9488;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 30px;
        }

        .info-card h3 {
            color: #0d9488;
            font-size: 1.3rem;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .info-list {
            list-style: none;
            padding-left: 0;
        }

        .info-list li {
            padding: 8px 0;
            color: #374151;
            display: flex;
            align-items: start;
            gap: 10px;
        }

        .info-list li:before {
            content: "✓";
            color: #0d9488;
            font-weight: bold;
            font-size: 1.2rem;
        }

        .preview-table {
            background: white;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 30px;
            overflow-x: auto;
        }

        .preview-table h3 {
            color: #1f2937;
            margin-bottom: 15px;
            font-size: 1.2rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.95rem;
        }

        table thead {
            background: #0d9488;
            color: white;
        }

        table th, table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #e5e7eb;
        }

        table tbody tr:nth-child(even) {
            background: #f9fafb;
        }

        table tbody tr:hover {
            background: #f0fdfa;
        }

        .button-group {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .btn {
            flex: 1;
            min-width: 200px;
            padding: 18px 30px;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-decoration: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #0d9488 0%, #14b8a6 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(13, 148, 136, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(13, 148, 136, 0.5);
        }

        .btn-secondary {
            background: #f3f4f6;
            color: #374151;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .btn-secondary:hover {
            background: #e5e7eb;
            transform: translateY(-2px);
        }

        .icon {
            width: 24px;
            height: 24px;
        }

        .warning {
            background: #fef3c7;
            border: 2px solid #f59e0b;
            border-radius: 12px;
            padding: 20px;
            margin-top: 25px;
            color: #92400e;
        }

        .warning h4 {
            color: #b45309;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .warning ul {
            margin-left: 25px;
            margin-top: 10px;
        }

        .warning li {
            margin: 5px 0;
        }

        @media (max-width: 640px) {
            .header {
                padding: 25px;
            }

            .header h1 {
                font-size: 1.5rem;
            }

            .content {
                padding: 25px;
            }

            .btn {
                min-width: 100%;
            }

            table {
                font-size: 0.85rem;
            }

            table th, table td {
                padding: 8px;
            }
        }

        .success-message {
            display: none;
            background: #d1fae5;
            border: 2px solid #10b981;
            color: #065f46;
            padding: 15px;
            border-radius: 12px;
            margin-top: 20px;
            text-align: center;
            font-weight: 600;
        }

        .success-message.show {
            display: block;
            animation: slideIn 0.5s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📋 Template Import Gejala</h1>
            <p>Template Excel untuk Import Data Gejala - TASYA FARMA</p>
        </div>

        <div class="content">
            <div class="info-card">
                <h3>
                    <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Format Template
                </h3>
                <ul class="info-list">
                    <li><strong>Kolom A:</strong> Kode Gejala (Format: G001, G002, G003, dst)</li>
                    <li><strong>Kolom B:</strong> Nama Gejala (Deskripsi lengkap gejala)</li>
                    <li>File berformat .xlsx atau .xls</li>
                    <li>Maksimal ukuran file: 2MB</li>
                    <li>Kode gejala harus unik (tidak boleh duplikat)</li>
                </ul>
            </div>

            <div class="preview-table">
                <h3>Preview Data Template:</h3>
                <table id="previewTable">
                    <thead>
                        <tr>
                            <th>Kode Gejala</th>
                            <th>Nama Gejala</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>G001</td>
                            <td>Demam tinggi (>38°C)</td>
                        </tr>
                        <tr>
                            <td>G002</td>
                            <td>Batuk kering</td>
                        </tr>
                        <tr>
                            <td>G003</td>
                            <td>Batuk berdahak</td>
                        </tr>
                        <tr>
                            <td>G004</td>
                            <td>Pilek/hidung tersumbat</td>
                        </tr>
                        <tr>
                            <td>G005</td>
                            <td>Sakit kepala</td>
                        </tr>
                        <tr>
                            <td>G006</td>
                            <td>Nyeri tenggorokan</td>
                        </tr>
                        <tr>
                            <td>G007</td>
                            <td>Mual/muntah</td>
                        </tr>
                        <tr>
                            <td>G008</td>
                            <td>Diare</td>
                        </tr>
                        <tr>
                            <td>G009</td>
                            <td>Nyeri perut</td>
                        </tr>
                        <tr>
                            <td>G010</td>
                            <td>Pusing/vertigo</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="button-group">
                <button class="btn btn-primary" onclick="downloadTemplate()">
                    <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Download Template Excel
                </button>
                <button class="btn btn-secondary" onclick="downloadTemplateWithMoreData()">
                    <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Download dengan Data Lengkap (50 Gejala)
                </button>
            </div>

            <div id="successMessage" class="success-message">
                ✅ Template berhasil didownload! Silakan isi data dan upload ke sistem.
            </div>

            <div class="warning">
                <h4>
                    <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    Perhatian
                </h4>
                <ul>
                    <li>Jangan mengubah format header (baris pertama)</li>
                    <li>Pastikan setiap kode gejala unik dan tidak ada yang duplikat</li>
                    <li>Gunakan format kode yang konsisten (contoh: G001, G002, dst)</li>
                    <li>Kolom Nama Gejala tidak boleh kosong</li>
                    <li>Simpan file dalam format .xlsx sebelum upload</li>
                </ul>
            </div>
        </div>
    </div>

    <script>
        // Data gejala lengkap (50 items)
        const gejalaLengkap = [
            { kode: "G001", nama: "Demam tinggi (>38°C)" },
            { kode: "G002", nama: "Batuk kering" },
            { kode: "G003", nama: "Batuk berdahak" },
            { kode: "G004", nama: "Pilek/hidung tersumbat" },
            { kode: "G005", nama: "Sakit kepala" },
            { kode: "G006", nama: "Nyeri tenggorokan" },
            { kode: "G007", nama: "Mual/muntah" },
            { kode: "G008", nama: "Diare" },
            { kode: "G009", nama: "Nyeri perut" },
            { kode: "G010", nama: "Pusing/vertigo" },
            { kode: "G011", nama: "Lemas/letih" },
            { kode: "G012", nama: "Nyeri otot/pegal-pegal" },
            { kode: "G013", nama: "Sesak napas" },
            { kode: "G014", nama: "Nyeri dada" },
            { kode: "G015", nama: "Kehilangan nafsu makan" },
            { kode: "G016", nama: "Muntah darah" },
            { kode: "G017", nama: "BAB berdarah" },
            { kode: "G018", nama: "Kesulitan menelan" },
            { kode: "G019", nama: "Suara serak" },
            { kode: "G020", nama: "Mata merah/berair" },
            { kode: "G021", nama: "Gatal-gatal pada kulit" },
            { kode: "G022", nama: "Ruam kulit" },
            { kode: "G023", nama: "Pembengkakan" },
            { kode: "G024", nama: "Nyeri sendi" },
            { kode: "G025", nama: "Kram perut" },
            { kode: "G026", nama: "Sembelit/konstipasi" },
            { kode: "G027", nama: "Sering buang air kecil" },
            { kode: "G028", nama: "Nyeri saat buang air kecil" },
            { kode: "G029", nama: "Urine keruh/berbau" },
            { kode: "G030", nama: "Menggigil" },
            { kode: "G031", nama: "Berkeringat berlebihan" },
            { kode: "G032", nama: "Insomnia/sulit tidur" },
            { kode: "G033", nama: "Gelisah/cemas" },
            { kode: "G034", nama: "Jantung berdebar" },
            { kode: "G035", nama: "Tekanan darah tinggi" },
            { kode: "G036", nama: "Tekanan darah rendah" },
            { kode: "G037", nama: "Pingsan/hampir pingsan" },
            { kode: "G038", nama: "Kehilangan kesadaran" },
            { kode: "G039", nama: "Kejang" },
            { kode: "G040", nama: "Tremor/gemetar" },
            { kode: "G041", nama: "Kesemutan" },
            { kode: "G042", nama: "Mati rasa" },
            { kode: "G043", nama: "Penglihatan kabur" },
            { kode: "G044", nama: "Telinga berdenging" },
            { kode: "G045", nama: "Gangguan pendengaran" },
            { kode: "G046", nama: "Mimisan" },
            { kode: "G047", nama: "Gusi berdarah" },
            { kode: "G048", nama: "Berat badan turun drastis" },
            { kode: "G049", nama: "Pembengkakan kelenjar getah bening" },
            { kode: "G050", nama: "Kesulitan berkonsentrasi" }
        ];

        function downloadTemplate() {
            // Data template dasar (10 items)
            const data = [
                { kode: "G001", nama: "Demam tinggi (>38°C)" },
                { kode: "G002", nama: "Batuk kering" },
                { kode: "G003", nama: "Batuk berdahak" },
                { kode: "G004", nama: "Pilek/hidung tersumbat" },
                { kode: "G005", nama: "Sakit kepala" },
                { kode: "G006", nama: "Nyeri tenggorokan" },
                { kode: "G007", nama: "Mual/muntah" },
                { kode: "G008", nama: "Diare" },
                { kode: "G009", nama: "Nyeri perut" },
                { kode: "G010", nama: "Pusing/vertigo" }
            ];

            generateExcel(data, "Template_Import_Gejala.xlsx");
        }

        function downloadTemplateWithMoreData() {
            generateExcel(gejalaLengkap, "Template_Import_Gejala_Lengkap_50_Data.xlsx");
        }

        function generateExcel(data, filename) {
            // Buat workbook baru
            const wb = XLSX.utils.book_new();
            
            // Convert data ke format array
            const wsData = [
                ["Kode Gejala", "Nama Gejala"], // Header
                ...data.map(item => [item.kode, item.nama])
            ];
            
            // Buat worksheet
            const ws = XLSX.utils.aoa_to_sheet(wsData);
            
            // Set column width
            ws['!cols'] = [
                { wch: 15 },  // Kolom A (Kode Gejala)
                { wch: 50 }   // Kolom B (Nama Gejala)
            ];
            
            // Style header (row pertama)
            const headerStyle = {
                font: { bold: true, color: { rgb: "FFFFFF" } },
                fill: { fgColor: { rgb: "0d9488" } },
                alignment: { horizontal: "center", vertical: "center" }
            };
            
            // Tambahkan worksheet ke workbook
            XLSX.utils.book_append_sheet(wb, ws, "Data Gejala");
            
            // Download file
            XLSX.writeFile(wb, filename);
            
            // Tampilkan pesan sukses
            const successMsg = document.getElementById('successMessage');
            successMsg.classList.add('show');
            setTimeout(() => {
                successMsg.classList.remove('show');
            }, 3000);
        }
    </script>
</body>
</html>