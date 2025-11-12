<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<h1 class="text-3xl font-bold mb-4"><?= $title ?></h1>

<a href="/kategori/create" class="bg-teal-600 text-white px-4 py-2 rounded hover:bg-teal-700 mb-4 inline-block">Tambah Kategori</a>

<table class="min-w-full bg-white shadow rounded">
    <thead class="bg-gray-100">
        <tr>
            <th class="py-2 px-4 border">Nama Kategori</th>
            <th class="py-2 px-4 border">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($kategori as $o): ?>
        <tr class="text-center">
            <td class="py-2 px-4 border"><?= $o['nama_kategori'] ?></td>
            <td class="py-2 px-4 border">
                <a href="/kategori/edit/<?= $o['id'] ?>" class="bg-yellow-500 px-2 py-1 rounded text-white hover:bg-yellow-600">Edit</a>
                <a href="/kategori/delete/<?= $o['id'] ?>" class="bg-red-500 px-2 py-1 rounded text-white hover:bg-red-600"
                   onclick="return confirm('Yakin ingin hapus?')">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>