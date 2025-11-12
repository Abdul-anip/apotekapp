<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<h1 class="text-3xl font-bold mb-4"><?= $title ?></h1>

<a href="/obat/create" class="bg-teal-600 text-white px-4 py-2 rounded hover:bg-teal-700 mb-4 inline-block">Tambah Obat</a>
<a href="/kategori" class="bg-teal-600 text-white px-4 py-2 rounded hover:bg-teal-700 mb-4 inline-block">Kategori</a>

<table class="min-w-full bg-white shadow rounded">
    <thead class="bg-gray-100">
        <tr>
            <th class="py-2 px-4 border">Nama Obat</th>
            <th class="py-2 px-4 border">Kategori</th>
            <th class="py-2 px-4 border">Harga Beli</th>
            <th class="py-2 px-4 border">Harga Jual</th>
            <th class="py-2 px-4 border">Stok</th>
            <th class="py-2 px-4 border">Kadaluarsa</th>
            <th class="py-2 px-4 border">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($obat as $o): ?>
        <tr class="text-center">
            <td class="py-2 px-4 border"><?= $o['nama_obat'] ?></td>
            <td><?= $o['nama_kategori'] ?: 'Tidak ada' ?></td>
            <td class="py-2 px-4 border"><?= $o['harga_beli'] ?></td>
            <td class="py-2 px-4 border"><?= $o['harga_jual'] ?></td>
            <td class="py-2 px-4 border"><?= $o['stok'] ?></td>
            <td class="py-2 px-4 border"><?= $o['tanggal_kadaluarsa'] ?></td>
            <td class="py-2 px-4 border">
                <a href="/obat/edit/<?= $o['id_obat'] ?>" class="bg-yellow-500 px-2 py-1 rounded text-white hover:bg-yellow-600">Edit</a>
                <a href="/obat/delete/<?= $o['id_obat'] ?>" class="bg-red-500 px-2 py-1 rounded text-white hover:bg-red-600"
                   onclick="return confirm('Yakin ingin hapus?')">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>
