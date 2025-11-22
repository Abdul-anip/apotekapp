<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="max-w-7xl mx-auto">

<h1 class="text-3xl font-bold mb-4">Laporan Transaksi</h1>

<!-- 🟢 Summary Card -->
<div class="grid grid-cols-3 gap-4 mb-6">
    <?php 
    $total_penjualan = array_sum(array_column($laporan, 'total_harga'));
    $total_keuntungan = array_sum(array_column($laporan, 'keuntungan'));
    ?>
    <div class="bg-white p-6 rounded-lg shadow">
        <p class="text-gray-500 text-sm">Total Transaksi</p>
        <p class="text-2xl font-bold text-teal-700"><?= count($laporan) ?></p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow">
        <p class="text-gray-500 text-sm">Total Penjualan</p>
        <p class="text-2xl font-bold text-green-700">Rp <?= number_format($total_penjualan, 0, ',', '.') ?></p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow">
        <p class="text-gray-500 text-sm">Total Keuntungan</p>
        <p class="text-2xl font-bold text-green-600">Rp <?= number_format($total_keuntungan, 0, ',', '.') ?></p>
    </div>
</div>

<table class="min-w-full bg-white shadow rounded">
    <thead class="bg-gray-100">
        <tr>
            <th class="py-2 px-4 border">Kode Transaksi</th>
            <th class="py-2 px-4 border">Total Belanja</th>
            <th class="py-2 px-4 border">🟢 Keuntungan</th>
            <th class="py-2 px-4 border">Bayar</th>
            <th class="py-2 px-4 border">Kembalian</th>
            <th class="py-2 px-4 border">Barang Dibeli</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($laporan as $row): ?>
            <tr class="text-center">
                <td class="py-2 px-4 border"><?= $row['kode_transaksi'] ?></td>
                <td class="py-2 px-4 border">Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>
                <td class="py-2 px-4 border">
                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full font-semibold">
                        Rp <?= number_format($row['keuntungan'], 0, ',', '.') ?>
                    </span>
                </td>
                <td class="py-2 px-4 border">Rp <?= number_format($row['bayar'], 0, ',', '.') ?></td>
                <td class="py-2 px-4 border">Rp <?= number_format($row['kembalian'], 0, ',', '.') ?></td>
                <td class="py-2 px-4 border">
                    <ul class="text-left">
                        <?php foreach ($row['items'] as $item): ?>
                            <li class="text-sm">
                                <?= $item['nama_obat'] ?> -
                                <?= $item['jumlah'] ?> ×
                                Rp <?= number_format($item['harga_jual'], 0, ',', '.') ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</div>

<?= $this->endSection() ?>