<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Struk - <?= $transaksi['kode_transaksi'] ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            padding: 20px;
            max-width: 300px;
            margin: 0 auto;
        }
        
        .struk {
            border: 2px dashed #000;
            padding: 15px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 1px dashed #000;
            padding-bottom: 10px;
        }
        
        .header h1 {
            font-size: 18px;
            margin-bottom: 5px;
        }
        
        .header p {
            font-size: 10px;
            margin: 2px 0;
        }
        
        .info {
            margin-bottom: 15px;
            font-size: 11px;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            margin: 3px 0;
        }
        
        .items {
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
            padding: 10px 0;
            margin: 10px 0;
        }
        
        .item {
            margin-bottom: 8px;
        }
        
        .item-name {
            font-weight: bold;
            margin-bottom: 2px;
        }
        
        .item-detail {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
        }
        
        .totals {
            margin-top: 10px;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            margin: 5px 0;
            font-size: 11px;
        }
        
        .total-row.grand {
            font-size: 14px;
            font-weight: bold;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            padding: 8px 0;
            margin: 8px 0;
        }
        
        .footer {
            text-align: center;
            margin-top: 15px;
            padding-top: 10px;
            border-top: 1px dashed #000;
            font-size: 10px;
        }
        
        .footer p {
            margin: 3px 0;
        }
        
        @media print {
            body {
                padding: 0;
            }
            
            .struk {
                border: none;
            }
            
            .no-print {
                display: none;
            }
        }
        
        .btn-print {
            background: #0d9488;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 15px;
            width: 100%;
            font-size: 14px;
            font-weight: bold;
        }
        
        .btn-print:hover {
            background: #0f766e;
        }
    </style>
</head>
<body>
    <button class="btn-print no-print" onclick="window.print()">🖨️ CETAK STRUK</button>
    
    <div class="struk">
        <!-- Header -->
        <div class="header">
            <h1>🏥 TASYA FARMA</h1>
            <p>Sistem POS Apotek</p>
            <p>Jl. Raya Mungka</p>
            <p>Telp: 0823-8628-1621</p>
        </div>
        
        <!-- Info Transaksi -->
        <div class="info">
            <div class="info-row">
                <span>No.Transaksi:</span>
                <strong><?= $transaksi['kode_transaksi'] ?></strong>
            </div>
            <div class="info-row">
                <span>Tanggal:</span>
                <span><?= date('d/m/Y H:i', strtotime($transaksi['tanggal'])) ?></span>
            </div>
            <div class="info-row">
                <span>Kasir:</span>
                <span><?= session()->get('username') ?></span>
            </div>
        </div>
        
        <!-- Items -->
        <div class="items">
            <?php foreach ($transaksi['items'] as $item): ?>
            <div class="item">
                <div class="item-name"><?= esc($item['nama_obat']) ?></div>
                <div class="item-detail">
                    <span><?= $item['jumlah'] ?> x Rp <?= number_format($item['harga_jual'], 0, ',', '.') ?></span>
                    <strong>Rp <?= number_format($item['subtotal'], 0, ',', '.') ?></strong>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Totals -->
        <div class="totals">
            <div class="total-row">
                <span>Subtotal:</span>
                <span>Rp <?= number_format($transaksi['total_harga'], 0, ',', '.') ?></span>
            </div>
            
            <div class="total-row grand">
                <span>TOTAL:</span>
                <span>Rp <?= number_format($transaksi['total_harga'], 0, ',', '.') ?></span>
            </div>
            
            <div class="total-row">
                <span>Bayar:</span>
                <span>Rp <?= number_format($transaksi['bayar'], 0, ',', '.') ?></span>
            </div>
            
            <div class="total-row">
                <span>Kembalian:</span>
                <strong>Rp <?= number_format($transaksi['kembalian'], 0, ',', '.') ?></strong>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <p>*** TERIMA KASIH ***</p>
            <p>Semoga Lekas Sembuh</p>
            <p>Barang yang sudah dibeli</p>
            <p>tidak dapat dikembalikan</p>
            <p style="margin-top: 10px;">Dicetak: <?= date('d/m/Y H:i') ?></p>
        </div>
    </div>
    
    <script>
        // Auto print saat halaman dimuat (optional)
        // window.onload = () => window.print();
    </script>
</body>
</html>