<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<h1 class="text-3xl font-bold mb-4"><?= $title ?></h1>

<form action="/obat/update/<?= $obat['id_obat'] ?>" method="post" class="bg-white p-6 rounded shadow max-w-lg">
    <label class="block mb-2">Nama Obat</label>
    <input type="text" name="nama_obat" value="<?= $obat['nama_obat'] ?>" class="w-full mb-4 border rounded px-3 py-2">

    <select name="category_id" class="border px-3 py-2 rounded w-full">
        <option value="">-- Pilih Kategori --</option>
        <?php foreach ($kategori as $k): ?>
            <option value="<?= $k['id'] ?>" 
                <?= $k['id'] == $obat['category_id'] ? 'selected' : '' ?>>
                <?= $k['nama_kategori'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label class="block mb-2">Harga Beli</label>
    <input type="number" name="harga_beli" value="<?= $obat['harga_beli'] ?>" class="w-full mb-4 border rounded px-3 py-2">

    <label class="block mb-2">Harga Jual</label>
    <input type="number" name="harga_jual" value="<?= $obat['harga_jual'] ?>" class="w-full mb-4 border rounded px-3 py-2">

    <label class="block mb-2">Stok</label>
    <input type="number" name="stok" value="<?= $obat['stok'] ?>" class="w-full mb-4 border rounded px-3 py-2">

    <label class="block mb-2">Tanggal Kadaluarsa</label>
    <input type="date" name="tanggal_kadaluarsa" value="<?= $obat['tanggal_kadaluarsa'] ?>" class="w-full mb-4 border rounded px-3 py-2">

    <button type="submit" class="bg-teal-600 text-white px-4 py-2 rounded hover:bg-teal-700">Update</button>
</form>

<?= $this->endSection() ?>
