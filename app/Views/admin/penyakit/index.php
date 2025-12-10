<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800"><?= $title ?></h1>
            <p class="text-sm text-gray-600 mt-1">Kelola daftar penyakit dalam sistem</p>
        </div>
        <button onclick="openModalTambah()" class="bg-teal-600 text-white px-4 py-2 rounded-lg hover:bg-teal-700 transition shadow-md flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Penyakit
        </button>
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

    <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-5 rounded-lg shadow hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Penyakit</p>
                    <p class="text-3xl font-bold text-teal-700 mt-2"><?= $stats['total'] ?></p>
                </div>
                <div class="bg-teal-100 p-3 rounded-full">
                    <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-lg shadow hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Dengan Aturan</p>
                    <p class="text-3xl font-bold text-green-700 mt-2"><?= $stats['dengan_aturan'] ?></p>
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
                    <p class="text-gray-500 text-sm">Tanpa Aturan</p>
                    <p class="text-3xl font-bold text-orange-700 mt-2"><?= $stats['tanpa_aturan'] ?></p>
                </div>
                <div class="bg-orange-100 p-3 rounded-full">
                    <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-lg shadow hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Rata-rata Aturan</p>
                    <p class="text-3xl font-bold text-blue-700 mt-2"><?= $stats['avg_aturan_per_penyakit'] ?></p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="bg-white rounded-lg shadow-sm p-4 mb-5">
        <input type="text" id="searchPenyakit" placeholder="🔍 Cari kode atau nama penyakit..." 
               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gradient-to-r from-teal-600 to-teal-700 text-white">
                <tr>
                    <th class="py-3 px-4 text-left w-16">No</th>
                    <th class="py-3 px-4 text-left">Kode</th>
                    <th class="py-3 px-4 text-left">Nama Penyakit</th>
                    <th class="py-3 px-4 text-left">Deskripsi</th>
                    <th class="py-3 px-4 text-center">Jumlah Aturan</th>
                    <th class="py-3 px-4 text-center w-64">Aksi</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                <?php if (empty($penyakit)): ?>
                    <tr>
                        <td colspan="6" class="py-12 text-center">
                            <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <p class="text-gray-500 text-lg font-medium">Belum ada penyakit</p>
                            <button onclick="openModalTambah()" class="inline-block mt-4 bg-teal-600 text-white px-6 py-2 rounded-lg hover:bg-teal-700 transition">
                                Tambah Penyakit Pertama
                            </button>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1; foreach($penyakit as $p): ?>
                    <tr class="border-b hover:bg-gray-50 transition penyakit-row" 
                        data-kode="<?= strtolower($p['kode_penyakit']) ?>"
                        data-nama="<?= strtolower($p['nama_penyakit']) ?>">
                        <td class="py-3 px-4 text-gray-600"><?= $no++ ?></td>
                        <td class="py-3 px-4">
                            <span class="font-bold text-teal-600"><?= esc($p['kode_penyakit']) ?></span>
                        </td>
                        <td class="py-3 px-4">
                            <span class="font-semibold text-gray-800"><?= esc($p['nama_penyakit']) ?></span>
                        </td>
                        <td class="py-3 px-4 text-gray-600 text-sm">
                            <?= esc(substr($p['deskripsi'] ?? '-', 0, 100)) . (strlen($p['deskripsi'] ?? '') > 100 ? '...' : '') ?>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <?php if ($p['jumlah_aturan'] > 0): ?>
                                <a href="/admin/penyakit/detail/<?= $p['id'] ?>" 
                                   class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold hover:bg-green-200 transition">
                                    <?= $p['jumlah_aturan'] ?> aturan
                                </a>
                            <?php else: ?>
                                <a href="/admin/aturan/bulk-create/<?= $p['id'] ?>" 
                                   class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-sm font-semibold hover:bg-orange-200 transition">
                                    + Tambah Aturan
                                </a>
                            <?php endif; ?>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <div class="flex gap-2 justify-center">
                                <button onclick='openModalEdit(<?= json_encode($p) ?>)' 
                                        class="bg-yellow-500 text-white px-3 py-1.5 rounded-lg hover:bg-yellow-600 transition text-sm">
                                    Edit
                                </button>
                                <a href="/admin/penyakit/detail/<?= $p['id'] ?>" 
                                   class="bg-blue-500 text-white px-3 py-1.5 rounded-lg hover:bg-blue-600 transition text-sm">
                                    Detail
                                </a>
                                <button onclick="confirmDelete(<?= $p['id'] ?>, '<?= esc($p['nama_penyakit']) ?>', <?= $p['jumlah_aturan'] ?>)" 
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
    <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl mx-4">
        <div class="bg-gradient-to-r from-teal-600 to-teal-700 text-white p-4 rounded-t-lg flex justify-between items-center">
            <h3 class="text-xl font-bold">Tambah Penyakit Baru</h3>
            <button onclick="closeModalTambah()" class="text-white hover:text-gray-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form action="/admin/penyakit/store" method="post" class="p-6">
            <?= csrf_field() ?>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kode Penyakit *</label>
                    <input type="text" name="kode_penyakit" id="tambah_kode" required
                           placeholder="P001, P002, ..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 uppercase">
                    <p class="text-xs text-gray-500 mt-1">*Kode otomatis akan disarankan</p>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Penyakit *</label>
                    <input type="text" name="nama_penyakit" required
                           placeholder="Contoh: Flu/Influenza"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                    <textarea name="deskripsi" rows="4"
                              placeholder="Deskripsi penyakit (opsional)"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"></textarea>
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
    <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl mx-4">
        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white p-4 rounded-t-lg flex justify-between items-center">
            <h3 class="text-xl font-bold">Edit Penyakit</h3>
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
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kode Penyakit *</label>
                    <input type="text" name="kode_penyakit" id="edit_kode" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 uppercase">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Penyakit *</label>
                    <input type="text" name="nama_penyakit" id="edit_nama" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                    <textarea name="deskripsi" id="edit_deskripsi" rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500"></textarea>
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

<script>
// Generate kode otomatis saat modal tambah dibuka
function openModalTambah() {
    fetch('/admin/penyakit/generate-kode')
        .then(res => res.json())
        .then(data => {
            document.getElementById('tambah_kode').value = data.kode;
        })
        .catch(() => {
            document.getElementById('tambah_kode').value = 'P001';
        });
    document.getElementById('modalTambah').classList.remove('hidden');
}

function closeModalTambah() {
    document.getElementById('modalTambah').classList.add('hidden');
}

function openModalEdit(penyakit) {
    document.getElementById('edit_kode').value = penyakit.kode_penyakit;
    document.getElementById('edit_nama').value = penyakit.nama_penyakit;
    document.getElementById('edit_deskripsi').value = penyakit.deskripsi || '';
    document.getElementById('formEdit').action = '/admin/penyakit/update/' + penyakit.id;
    document.getElementById('modalEdit').classList.remove('hidden');
}

function closeModalEdit() {
    document.getElementById('modalEdit').classList.add('hidden');
}

function confirmDelete(id, nama, jumlahAturan) {
    let message = `Hapus penyakit "${nama}"?`;
    if (jumlahAturan > 0) {
        message += `\n\n⚠️ PERHATIAN: Penyakit ini memiliki ${jumlahAturan} aturan!\nSemua aturan terkait akan ikut terhapus.`;
    }
    
    if (confirm(message)) {
        window.location.href = '/admin/penyakit/delete/' + id;
    }
}

// Search
document.getElementById('searchPenyakit')?.addEventListener('input', function(e) {
    const search = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('.penyakit-row');
    
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
    }
});
</script>

<?= $this->endSection() ?>