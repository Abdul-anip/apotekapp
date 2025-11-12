<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<h1 class="text-3xl font-bold mb-6"><?= $title ?></h1>

<div class="grid grid-cols-3 gap-4">
    <div class="bg-white p-4 rounded shadow">
        <p class="text-gray-500">Total Obat</p>
        <p class="text-2xl font-bold">120</p>
    </div>
    <div class="bg-white p-4 rounded shadow">
        <p class="text-gray-500">Transaksi Hari Ini</p>
        <p class="text-2xl font-bold">34</p>
    </div>
    <div class="bg-white p-4 rounded shadow">
        <p class="text-gray-500">Stok Menipis</p>
        <p class="text-2xl font-bold">12</p>
    </div>
</div>

<?= $this->endSection() ?>
