<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800"><?= $title ?></h1>
            <p class="text-sm text-gray-600 mt-1">Kelola daftar gejala dalam sistem</p>
        </div>
        <div class="flex gap-3">
            <a href="<?= base_url('admin/gejala/import') ?>" 
            class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition shadow-md flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                </svg>
                Import Excel
            </a>
            <button onclick="openModalTambah()" class="bg-teal-600 text-white px-4 py-2 rounded-lg hover:bg-teal-700 transition shadow-md flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Gejala
            </button>
        </div>
    </div>

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white p-5 rounded-lg shadow hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Gejala</p>
                    <p class="text-3xl font-bold text-teal-700 mt-2"><?= $stats['total'] ?></p>
                </div>
                <div class="bg-teal-100 p-3 rounded-full">
                    <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-lg shadow hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Digunakan</p>
                    <p class="text-3xl font-bold text-green-700 mt-2"><?= $stats['digunakan'] ?></p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-lg shadow hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Tidak Digunakan</p>
                    <p class="text-3xl font-bold text-orange-700 mt-2"><?= $stats['tidak_digunakan'] ?></p>
                </div>
                <div class="bg-orange-100 p-3 rounded-full">
                    <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="bg-white rounded-lg shadow-sm p-4 mb-5">
        <input type="text" id="searchGejala" placeholder="🔍 Cari kode atau nama gejala..." 
               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gradient-to-r from-teal-600 to-teal-700 text-white">
                <tr>
                    <th class="py-3 px-4 text-left w-16">No</th>
                    <th class="py-3 px-4 text-left">Kode</th>
                    <th class="py-3 px-4 text-left">Nama Gejala</th>
                    <th class="py-3 px-4 text-center">Status</th>
                    <th class="py-3 px-4 text-center">Jumlah Aturan</th>
                    <th class="py-3 px-4 text-center w-48">Aksi</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                <?php if (empty($gejala)): ?>
                    <tr>
                        <td colspan="6" class="py-12 text-center">
                            <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <p class="text-gray-500 text-lg font-medium">Belum ada gejala</p>
                            <button onclick="openModalTambah()" class="inline-block mt-4 bg-teal-600 text-white px-6 py-2 rounded-lg hover:bg-teal-700 transition">
                                Tambah Gejala Pertama
                            </button>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1; foreach($gejala as $g): ?>
                    <tr class="border-b hover:bg-gray-50 transition gejala-row" 
                        data-kode="<?= strtolower($g['kode_gejala']) ?>"
                        data-nama="<?= strtolower($g['nama_gejala']) ?>">
                        <td class="py-3 px-4 text-gray-600"><?= $no++ ?></td>
                        <td class="py-3 px-4">
                            <span class="font-bold text-teal-600"><?= esc($g['kode_gejala']) ?></span>
                        </td>
                        <td class="py-3 px-4">
                            <span class="font-semibold text-gray-800"><?= esc($g['nama_gejala']) ?></span>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <?php if ($g['jumlah_aturan'] > 0): ?>
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">
                                    ✓ Terpakai
                                </span>
                            <?php else: ?>
                                <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-bold">
                                    Belum Digunakan
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-semibold">
                                <?= $g['jumlah_aturan'] ?> aturan
                            </span>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <div class="flex gap-2 justify-center">
                                <button onclick='openModalEdit(<?= json_encode($g) ?>)' 
                                        class="bg-yellow-500 text-white px-3 py-1.5 rounded-lg hover:bg-yellow-600 transition text-sm">
                                    Edit
                                </button>
                                <button onclick="confirmDelete(<?= $g['id'] ?>, '<?= esc($g['nama_gejala']) ?>', <?= $g['jumlah_aturan'] ?>)" 
                                        class="bg-red-500 text-white px-3 py-1.5 rounded-lg hover:bg-red-600 transition text-sm">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah -->
<div id="modalTambah" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-lg mx-4">
        <div class="bg-gradient-to-r from-teal-600 to-teal-700 text-white p-4 rounded-t-lg flex justify-between items-center">
            <h3 class="text-xl font-bold">Tambah Gejala Baru</h3>
            <button onclick="closeModalTambah()" class="text-white hover:text-gray-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form action="/admin/gejala/store" method="post" class="p-6">
            <?= csrf_field() ?>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kode Gejala *</label>
                    <input type="text" name="kode_gejala" id="tambah_kode" required
                           placeholder="G001, G002, ..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 uppercase">
                    <p class="text-xs text-gray-500 mt-1">*Kode otomatis akan disarankan</p>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Gejala *</label>
                    <input type="text" name="nama_gejala" required
                           placeholder="Contoh: Demam tinggi (>38°C)"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                </div>
            </div>
            <div class="flex gap-3 mt-6">
                <button type="submit" class="flex-1 bg-teal-600 text-white py-2 rounded-lg hover:bg-teal-700 transition font-semibold">
                    Simpan
                </button>
                <button type="button" onclick="closeModalTambah()" class="flex-1 bg-gray-300 text-gray-700 py-2 rounded-lg hover:bg-gray-400 transition font-semibold">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div id="modalEdit" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-lg mx-4">
        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white p-4 rounded-t-lg flex justify-between items-center">
            <h3 class="text-xl font-bold">Edit Gejala</h3>
            <button onclick="closeModalEdit()" class="text-white hover:text-gray-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form id="formEdit" method="post" class="p-6">
            <?= csrf_field() ?>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kode Gejala *</label>
                    <input type="text" name="kode_gejala" id="edit_kode" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 uppercase">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Gejala *</label>
                    <input type="text" name="nama_gejala" id="edit_nama" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                </div>
            </div>
            <div class="flex gap-3 mt-6">
                <button type="submit" class="flex-1 bg-yellow-500 text-white py-2 rounded-lg hover:bg-yellow-600 transition font-semibold">
                    Update
                </button>
                <button type="button" onclick="closeModalEdit()" class="flex-1 bg-gray-300 text-gray-700 py-2 rounded-lg hover:bg-gray-400 transition font-semibold">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>


<!-- Modal Konfirmasi Hapus -->
<div id="modalHapus" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-sm mx-4 transform transition-all">
        <div class="p-6 text-center">
            <div class="bg-red-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Hapus Gejala?</h3>
            <p id="hapus_deskripsi" class="text-gray-600 mb-6"></p>
            <div class="flex gap-3">
                <button onclick="closeModalHapus()" class="flex-1 bg-gray-300 text-gray-700 py-2 rounded-lg hover:bg-gray-400 transition font-semibold">
                    Batal
                </button>
                <a id="hapus_link" href="#" class="flex-1 bg-red-500 text-white py-2 rounded-lg hover:bg-red-600 transition font-semibold text-center">
                    Ya, Hapus
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function openModalTambah() {
    fetch('/admin/gejala/generate-kode')
        .then(res => res.json())
        .then(data => {
            document.getElementById('tambah_kode').value = data.kode;
        })
        .catch(() => {
            document.getElementById('tambah_kode').value = 'G001';
        });
    document.getElementById('modalTambah').classList.remove('hidden');
}

function closeModalTambah() {
    document.getElementById('modalTambah').classList.add('hidden');
}

function openModalEdit(gejala) {
    document.getElementById('edit_kode').value = gejala.kode_gejala;
    document.getElementById('edit_nama').value = gejala.nama_gejala;
    document.getElementById('formEdit').action = '/admin/gejala/update/' + gejala.id;
    document.getElementById('modalEdit').classList.remove('hidden');
}

function closeModalEdit() {
    document.getElementById('modalEdit').classList.add('hidden');
}

function confirmDelete(id, nama, jumlahAturan) {
    const desc = document.getElementById('hapus_deskripsi');
    if (jumlahAturan > 0) {
        desc.innerHTML = `Apakah Anda yakin ingin menghapus gejala "<span class="font-semibold text-red-600">${nama}</span>"?<br><br><span class="text-red-600 font-bold">⚠️ PERHATIAN:</span> Gejala ini digunakan dalam <strong>${jumlahAturan} aturan</strong>!<br>Semua aturan terkait akan ikut terhapus.`;
    } else {
        desc.innerHTML = `Apakah Anda yakin ingin menghapus gejala "<span class="font-semibold text-red-600">${nama}</span>"?`;
    }
    
    document.getElementById('hapus_link').href = '/admin/gejala/delete/' + id;
    document.getElementById('modalHapus').classList.remove('hidden');
}

function closeModalHapus() {
    document.getElementById('modalHapus').classList.add('hidden');
}

// Search
document.getElementById('searchGejala')?.addEventListener('input', function(e) {
    const search = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('.gejala-row');
    
    rows.forEach(row => {
        const kode = row.dataset.kode;
        const nama = row.dataset.nama;
        row.style.display = (kode.includes(search) || nama.includes(search)) ? '' : 'none';
    });
});

// Close modal on ESC
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        closeModalTambah();
        closeModalEdit();
        closeModalHapus();
    }
});

document.getElementById('modalHapus')?.addEventListener('click', (e) => {
    if (e.target === e.currentTarget) closeModalHapus();
});
</script>

<?= $this->endSection() ?>