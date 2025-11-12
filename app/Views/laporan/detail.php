<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<h1 class="text-3xl font-bold mb-4"><?= $title ?> #<?= $transaksi['id_transaksi'] ?></h1>
<p class="mb-4">Tanggal: <?= $transaksi['tanggal'] ?></p>

<table class="min-w-full bg-white shadow rounded">
    <thead class="bg-gray-100">
        <tr class="text-center">
            <th class="py-2 px-4 border">Nama Obat</th>
            <th class="py-2 px-4 border">Harga</th>
            <th class="py-2 px-4 border">Jumlah</th>
            <th class="py-2 px-4 border">Subtotal</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($detail as $d): ?>
        <tr class="text-center">
            <td class="py-2 px-4 border"><?= $d['nama_obat'] ?></td>
            <td class="py-2 px-4 border">Rp <?= $d['harga_jual'] ?></td>
            <td class="py-2 px-4 border"><?= $d['jumlah'] ?></td>
            <td class="py-2 px-4 border">Rp <?= $d['subtotal'] ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<p class="mt-4 font-bold text-right text-lg">Total: Rp <?= $transaksi['total'] ?></p>
<a href="/laporan" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">Kembali</a>

<?= $this->endSection() ?>
