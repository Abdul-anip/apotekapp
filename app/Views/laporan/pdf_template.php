<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #0d9488;
            padding-bottom: 15px;
        }
        
        .header h1 {
            color: #0d9488;
            font-size: 24px;
            margin-bottom: 5px;
        }
        
        .header p {
            color: #666;
            font-size: 14px;
        }
        
        .info-box {
            background: #f0fdfa;
            border: 2px solid #0d9488;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        
        .info-box table {
            width: 100%;
        }
        
        .info-box td {
            padding: 5px;
        }
        
        .info-box td:first-child {
            font-weight: bold;
            width: 40%;
        }
        
        .summary {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        
        .summary-card {
            flex: 1;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            padding: 15px;
            margin: 0 5px;
            text-align: center;
            border-radius: 5px;
        }
        
        .summary-card h3 {
            color: #666;
            font-size: 11px;
            margin-bottom: 8px;
        }
        
        .summary-card p {
            font-size: 18px;
            font-weight: bold;
            color: #0d9488;
        }
        
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        table.data-table thead {
            background: #0d9488;
            color: white;
        }
        
        table.data-table th,
        table.data-table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        
        table.data-table th {
            font-weight: bold;
            font-size: 11px;
        }
        
        table.data-table tbody tr:nth-child(even) {
            background: #f9fafb;
        }
        
        table.data-table tbody tr:hover {
            background: #f0fdfa;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #e5e7eb;
            text-align: center;
            color: #666;
            font-size: 10px;
        }
        
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
        }
        
        .badge-success {
            background: #dcfce7;
            color: #166534;
        }
        
        .badge-info {
            background: #dbeafe;
            color: #1e40af;
        }
        
        .items-detail {
            font-size: 10px;
            color: #666;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>TASYA FARMA</h1>
        <p>Sistem Point of Sale Apotek</p>
        <p style="font-size: 12px; margin-top: 5px;"><?= $title ?></p>
    </div>
    
    <!-- Info Box -->
    <div class="info-box">
        <table>
            <tr>
                <td>Periode Laporan:</td>
                <td><strong><?= $periode ?></strong></td>
            </tr>
            <tr>
                <td>Tanggal Cetak:</td>
                <td><strong><?= date('d F Y, H:i') ?> WIB</strong></td>
            </tr>
        </table>
    </div>
    
    <!-- Summary Cards -->
    <div class="summary">
        <div class="summary-card">
            <h3>TOTAL TRANSAKSI</h3>
            <p><?= $total_transaksi ?></p>
        </div>
        <div class="summary-card">
            <h3>TOTAL PENJUALAN</h3>
            <p>Rp <?= number_format($total_penjualan, 0, ',', '.') ?></p>
        </div>
        <div class="summary-card">
            <h3>TOTAL KEUNTUNGAN</h3>
            <p style="color: #16a34a;">Rp <?= number_format($total_keuntungan, 0, ',', '.') ?></p>
        </div>
    </div>
    
    <!-- Data Table -->
    <?php if (empty($laporan)): ?>
        <p style="text-align: center; padding: 40px; color: #999;">Tidak ada data transaksi untuk periode ini.</p>
    <?php else: ?>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 20%;">Kode Transaksi</th>
                <th style="width: 20%;">Kasir</th>
                <th style="width: 15%;">Tanggal</th>
                <th style="width: 15%;" class="text-right">Total</th>
                <th style="width: 15%;" class="text-right">Keuntungan</th>
                <th style="width: 10%;" class="text-center">Item</th>
                <th style="width: 20%;">Detail Barang</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($laporan as $row): ?>
            <tr>
                <td class="text-center"><?= $no++ ?></td>
                <td><?= esc($row['kode_transaksi']) ?></td>
                <td><?= esc($row['nama_kasir']) ?></td>
                <td><?= date('d/m/Y H:i', strtotime($row['tanggal'])) ?></td>
                <td class="text-right"><strong>Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></strong></td>
                <td class="text-right">
                    <span class="badge badge-success">Rp <?= number_format($row['keuntungan'], 0, ',', '.') ?></span>
                </td>
                <td class="text-center">
                    <span class="badge badge-info"><?= count($row['items']) ?> item</span>
                </td>
                <td>
                    <div class="items-detail">
                        <?php foreach ($row['items'] as $item): ?>
                            • <?= esc($item['nama_obat']) ?> (<?= $item['jumlah'] ?>x)<br>
                        <?php endforeach; ?>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        
        <tfoot>
            <tr style="background: #f0fdfa; font-weight: bold;">
                
                <td colspan="4" class="text-right">TOTAL:</td>
                <td class="text-right">Rp <?= number_format($total_penjualan, 0, ',', '.') ?></td>
                <td class="text-right" style="color: #16a34a;">Rp <?= number_format($total_keuntungan, 0, ',', '.') ?></td>

                <?php
                $totalItems = array_reduce($laporan, function($carry, $item) {
                    return $carry + count($item['items']);
                }, 0);
                ?>
                <td class="text-center"><?= $totalItems ?></td>

            </tr>
        </tfoot>
    </table>
    <?php endif; ?>
    
    <!-- Footer -->
    <div class="footer">
        <p><strong>TASYA FARMA</strong></p>
        <p>Sistem POS Apotek - Dicetak pada <?= date('d F Y, H:i') ?> WIB</p>
        <p style="margin-top: 10px;">Dokumen ini dicetak secara otomatis dan sah tanpa tanda tangan</p>
    </div>
</body>
</html>