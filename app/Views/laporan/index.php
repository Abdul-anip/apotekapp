<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="max-w-7xl mx-auto">

<h1 class="text-3xl font-bold mb-4">Laporan Transaksi</h1>

<table class="min-w-full bg-white shadow rounded">
    <thead class="bg-gray-100">
        <tr>
            <th class="py-2 px-4 border">Kode Transaksi</th>
            <th class="py-2 px-4 border">Total Belanja</th>
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
                <td class="py-2 px-4 border">Rp <?= number_format($row['bayar'], 0, ',', '.') ?></td>
                <td class="py-2 px-4 border">Rp <?= number_format($row['kembalian'], 0, ',', '.') ?></td>
                <td class="py-2 px-4 border">
                    <ul class="text-center">
                        <?php foreach ($row['items'] as $item): ?>
                            <li>
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
