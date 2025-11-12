<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<h1 class="text-3xl font-bold mb-4"><?= $title ?></h1>

<table class="min-w-full bg-white shadow rounded">
    <thead class="bg-gray-100">
        <tr class="text-center">
            <th class="py-2 px-4 border">ID Transaksi</th>
            <th class="py-2 px-4 border">Tanggal</th>
            <th class="py-2 px-4 border">Total</th>
            <th class="py-2 px-4 border">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if(empty($transaksi)): ?>
            <tr><td colspan="4" class="text-center py-4">Belum ada transaksi</td></tr>
        <?php else: ?>
            <?php foreach($transaksi as $t): ?>
            <tr class="text-center">
                <td class="py-2 px-4 border"><?= $t['id_transaksi'] ?></td>
                <td class="py-2 px-4 border"><?= $t['tanggal'] ?></td>
                <td class="py-2 px-4 border">Rp <?= $t['total'] ?></td>
                <td class="py-2 px-4 border">
                    <a href="/laporan/detail/<?= $t['id_transaksi'] ?>" class="bg-teal-600 px-2 py-1 rounded text-white hover:bg-teal-700">Detail</a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<?= $this->endSection() ?>
