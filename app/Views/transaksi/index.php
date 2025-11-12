<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="grid grid-cols-2 gap-4">
    <!-- Kiri: Detail Transaksi -->
    <div class="border border-green-500 rounded p-4 bg-white">
        <div class="flex justify-between items-center bg-green-700 text-white p-2 rounded mb-4">
            <span>Total</span>
            <span class="text-xl font-bold">Rp <?= number_format($total, 0, ',', '.') ?></span>
        </div>

        <!-- Harga dan Diskon -->
        <div class="mb-3">
            <label class="block font-semibold text-gray-700">HARGA</label>
            <p class="text-red-600 font-bold">Rp <?= number_format($total, 0, ',', '.') ?></p>
        </div>

        <div class="mb-3">
            <label>Diskon (%)</label>
            <input type="number" class="border rounded w-16 text-center" value="0">
            <input type="text" class="border rounded w-24 text-right" value="0">
        </div>

        <!-- Total dan Qty -->
        <div class="mb-3">
            <label class="block font-semibold text-gray-700">TOTAL <?= $total_qty ?> QTY</label>
            <p class="text-red-600 font-bold">Rp <?= number_format($total, 0, ',', '.') ?></p>
        </div>

        <!-- Form Pembayaran -->
        <form action="/transaksi/bayar" method="post">
            <div class="space-y-3">
                <div>
                    <label>Bayar</label>
                    <input type="number" class="w-full border rounded p-2" placeholder="tidak harus diisi">
                </div>

                <div>
                    <label>Kembali</label>
                    <input type="text" class="w-full border rounded p-2 bg-cyan-100" readonly>
                </div>

                <div>
                    <label>Nama Pembeli</label>
                    <input type="text" class="w-full border rounded p-2" placeholder="tidak harus diisi">
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <input type="date" class="border rounded p-2" value="<?= $today ?>">
                    <select class="border rounded p-2">
                        <option>Bukan Pelanggan</option>
                        <option>Pelanggan Tetap</option>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <select class="border rounded p-2">
                        <option>Lunas</option>
                        <option>Belum Lunas</option>
                    </select>
                    <select class="border rounded p-2">
                        <option>Cash</option>
                        <option>Transfer</option>
                        <option>QRIS</option>
                    </select>
                </div>

                <div>
                    <label>Keterangan</label>
                    <textarea class="w-full border rounded p-2" rows="3"></textarea>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                        BAYAR
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Kanan: Keranjang -->
    <div class="border border-green-500 rounded p-4 bg-white">
        <div class="flex items-center gap-2 mb-4">
            <input type="text" class="w-full border rounded p-2" placeholder="Barcode">
            <button class="bg-gray-100 border px-3 py-2 rounded">
                🔄
            </button>
        </div>

        <div class="space-y-4 overflow-y-auto h-[70vh]">
            <?php if(!empty($cart)): ?>
                <?php foreach($cart as $item): ?>
                <div class="border rounded-lg p-3 flex justify-between items-center">
                    <div>
                        <div class="text-gray-700 font-semibold"><?= $item['nama_obat'] ?></div>
                        <div class="text-sm text-gray-500">
                            Rp <?= number_format($item['harga_jual'], 0, ',', '.') ?> x <?= $item['jumlah'] ?>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="font-bold text-gray-800">Rp <?= number_format($item['subtotal'], 0, ',', '.') ?></div>
                        <div class="flex justify-end items-center gap-2 mt-1">
                            <button class="bg-gray-200 px-2 rounded">-</button>
                            <span><?= $item['jumlah'] ?></span>
                            <button class="bg-gray-200 px-2 rounded">+</button>
                            <a href="/penjualan/remove/<?= $item['id_obat'] ?>" class="text-red-500">🗑️</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center text-gray-400">Keranjang masih kosong</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
