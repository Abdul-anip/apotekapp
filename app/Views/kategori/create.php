<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<h1 class="text-3xl font-bold mb-4"><?= $title ?></h1>

<form action="/kategori/store" method="post" class="bg-white shadow-md rounded p-6">
    <div class="mb-4">
        <label for="nama_kategori" class="block text-gray-700 font-semibold mb-2">Nama Kategori</label>
        <input type="text" name="nama_kategori" id="nama_kategori" required
               class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-500">
    </div>

    <button type="submit" class="bg-teal-600 text-white px-4 py-2 rounded hover:bg-teal-700">Simpan</button>
    <a href="/kategori" class="ml-2 text-gray-600 hover:underline">Batal</a>
</form>

<?= $this->endSection() ?>
