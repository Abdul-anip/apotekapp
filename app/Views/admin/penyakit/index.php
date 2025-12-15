<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800"><?= $title ?></h1>
            <p class="text-sm text-gray-600 mt-1">Kelola daftar penyakit dalam sistem pakar</p>
        </div>
        <button onclick="openModalTambah()" class="bg-teal-600 text-white px-4 py-2 rounded-lg hover:bg-teal-700 transition shadow-md flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Penyakit
        </button>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-4 flex items-center flash-alert">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-4 flex items-center flash-alert">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-4 flash-alert">
            <p class="font-bold mb-2">Terjadi kesalahan:</p>
            <ul class="list-disc list-inside">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
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
    </div>

    <div class="bg-white rounded-lg shadow-sm p-4 mb-5">
        <input type="text" id="searchPenyakit" placeholder="🔍 Cari kode atau nama penyakit..." 
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gradient-to-r from-teal-600 to-teal-700 text-white">
                <tr>
                    <th class="py-3 px-4 text-left w-16">No</th>
                    <th class="py-3 px-4 text-left">Kode</th>
                    <th class="py-3 px-4 text-left">Nama Penyakit</th>
                    <th class="py-3 px-4 text-center">Jumlah Aturan</th>
                    <th class="py-3 px-4 text-center">Obat</th>
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
                            <div class="font-semibold text-gray-800"><?= esc($p['nama_penyakit']) ?></div>
                            <?php if (!empty($p['deskripsi'])): ?>
                                <p class="text-sm text-gray-500 line-clamp-1"><?= esc(substr($p['deskripsi'], 0, 60)) ?>...</p>
                            <?php endif; ?>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <?php if ($p['jumlah_aturan'] > 0): ?>
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">
                                    <?= $p['jumlah_aturan'] ?> aturan
                                </span>
                            <?php else: ?>
                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-semibold">
                                    0 aturan
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <?php
                            $db = \Config\Database::connect();
                            $countObat = $db->table('rekomendasi_obat')->where('id_penyakit', $p['id'])->countAllResults();
                            ?>
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-semibold">
                                <?= $countObat ?> obat
                            </span>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <div class="flex gap-2 justify-center">
                                <a href="/admin/penyakit/detail/<?= $p['id'] ?>" 
                                    class="bg-blue-500 text-white px-3 py-1.5 rounded-lg hover:bg-blue-600 transition text-sm">
                                    Detail
                                </a>
                                <a href="/admin/penyakit/edit/<?= $p['id'] ?>" 
                                    class="bg-yellow-500 text-white px-3 py-1.5 rounded-lg hover:bg-yellow-600 transition text-sm">
                                    Edit
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

    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <h4 class="font-semibold text-blue-800">Informasi</h4>
                <ul class="text-sm text-blue-700 mt-2 space-y-1">
                    <li>• Setiap penyakit harus memiliki minimal 1 aturan (knowledge base)</li>
                    <li>• Aturan menghubungkan penyakit dengan gejala menggunakan Certainty Factor (CF)</li>
                    <li>• Rekomendasi obat dapat ditambahkan untuk setiap penyakit</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div id="modalTambah" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl max-h-[90vh] overflow-y-auto">
        <div class="bg-gradient-to-r from-teal-600 to-teal-700 text-white p-4 rounded-t-lg flex justify-between items-center sticky top-0">
            <h3 class="text-xl font-bold">Tambah Penyakit Baru</h3>
            <button type="button" onclick="closeModalTambah()" class="text-white hover:text-gray-200 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form action="/admin/penyakit/store" method="post" class="p-6">
            <?= csrf_field() ?>
            
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <h4 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Informasi Penyakit
                </h4>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2" for="nama_penyakit">
                            Kode Penyakit <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="kode_penyakit" value="<?= $kodeOtomatis ?>" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 uppercase bg-gray-100"
                                readonly>
                        <p class="text-xs text-gray-500 mt-1">*Kode otomatis sudah di-generate</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2" for="nama_penyakit">
                            Nama Penyakit <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_penyakit" id="nama_penyakit" required
                                placeholder="Contoh: Flu/Influenza"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2" for="deskripsi">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" rows="3"
                                  placeholder="Deskripsi lengkap tentang penyakit ini..."
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"></textarea>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="font-bold text-gray-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        Rekomendasi Obat
                    </h4>
                    <button type="button" onclick="addObatRow()" 
                            class="bg-blue-600 text-white px-3 py-1.5 rounded-lg hover:bg-blue-700 transition text-sm flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah
                    </button>
                </div>

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-4">
                    <p class="text-sm text-blue-700">
                        💡 <strong>Tips:</strong> Tambahkan obat yang direkomendasikan untuk penyakit ini. 
                        Prioritas 1 = obat utama, prioritas 2+ = alternatif.
                    </p>
                </div>

                <div id="obatContainer" class="space-y-3">
                    </div>

                <div id="emptyState" class="text-center py-6 text-gray-500">
                    <svg class="w-12 h-12 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <p class="text-sm">Belum ada obat ditambahkan</p>
                    <button type="button" onclick="addObatRow()" class="text-blue-600 hover:text-blue-700 text-sm font-semibold mt-2">
                        + Tambah Obat Pertama
                    </button>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit" 
                        class="flex-1 bg-teal-600 text-white py-3 rounded-lg hover:bg-teal-700 transition font-bold flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Penyakit
                </button>
                <button type="button" onclick="closeModalTambah()" 
                        class="bg-gray-300 text-gray-700 px-8 py-3 rounded-lg hover:bg-gray-400 transition font-bold">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
let obatRowIndex = 0;
const obatList = <?= json_encode($obat_list ?? []) ?>;

function openModalTambah() {
    document.getElementById('modalTambah').classList.remove('hidden');
}

function closeModalTambah() {
    document.getElementById('modalTambah').classList.add('hidden');
    document.querySelector('#modalTambah form').reset();
    document.getElementById('obatContainer').innerHTML = '';
    document.getElementById('emptyState').style.display = 'block';
    obatRowIndex = 0;
}

function addObatRow() {
    const container = document.getElementById('obatContainer');
    const emptyState = document.getElementById('emptyState');
    
    obatRowIndex++;
    
    const row = document.createElement('div');
    row.className = 'border-2 border-gray-200 rounded-lg p-4 hover:border-teal-300 transition obat-row';
    row.id = 'obat-row-' + obatRowIndex;
    
    const selectOptions = obatList.map(o => `
        <option value="${o.id_obat}">
            ${o.nama_obat} (${o.merk}) - Stok: ${o.stok}
        </option>
    `).join('');
    
    row.innerHTML = `
        <div class="flex items-start gap-3">
            <div class="flex-1 space-y-3">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Pilih Obat *</label>
                        <select name="obat_ids[]" required 
                                 class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 text-sm">
                            <option value="">-- Pilih Obat --</option>
                            ${selectOptions}
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Prioritas *</label>
                        <input type="number" name="priorities[]" value="${obatRowIndex}" min="1" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 text-sm">
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Dosis/Saran Penggunaan</label>
                    <input type="text" name="dosages[]" 
                            placeholder="Contoh: 3x sehari 1 tablet setelah makan"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 text-sm">
                </div>
            </div>
            
            <button type="button" onclick="removeObatRow(${obatRowIndex})" 
                    class="text-red-500 hover:text-red-700 p-2 mt-6 flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </button>
        </div>
    `;
    
    container.appendChild(row);
    emptyState.style.display = 'none';
    updatePriorities();
}

function removeObatRow(index) {
    const row = document.getElementById('obat-row-' + index);
    if (row) {
        row.remove();
    }
    
    const container = document.getElementById('obatContainer');
    const emptyState = document.getElementById('emptyState');
    
    if (container.children.length === 0) {
        emptyState.style.display = 'block';
    }
    
    updatePriorities();
}

function updatePriorities() {
    const priorityInputs = document.querySelectorAll('#obatContainer input[name="priorities[]"]');
    priorityInputs.forEach((input, index) => {
        input.value = index + 1;
        const row = input.closest('.obat-row');
        if (row) {
            row.id = 'obat-row-' + (index + 1); 
            const removeButton = row.querySelector('button[onclick^="removeObatRow"]');
            if(removeButton) {
                removeButton.setAttribute('onclick', `removeObatRow(${index + 1})`);
            }
        }
    });
    obatRowIndex = priorityInputs.length; 
}


// Delete Function
function confirmDelete(id, nama, jumlahAturan) {
    let message = `Anda yakin ingin menghapus penyakit "${nama}"?`;
    if (jumlahAturan > 0) {
        message += `\n\n⚠️ PERHATIAN: Penyakit ini memiliki ${jumlahAturan} aturan!\nSemua aturan dan rekomendasi obat terkait akan ikut terhapus.`;
    }
    
    if (confirm(message)) {
        window.location.href = '/admin/penyakit/delete/' + id;
    }
}

document.getElementById('searchPenyakit')?.addEventListener('input', function(e) {
    const search = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('.penyakit-row');
    
    let visibleCount = 0;
    rows.forEach(row => {
        const kode = row.dataset.kode;
        const nama = row.dataset.nama;
        const isVisible = (kode.includes(search) || nama.includes(search));
        row.style.display = isVisible ? '' : 'none';
        if (isVisible) {
            visibleCount++;
        }
    });
});

document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        closeModalTambah();
    }
});

document.getElementById('modalTambah')?.addEventListener('click', (e) => {
    if (e.target === e.currentTarget) {
        closeModalTambah();
    }
});

setTimeout(() => {
    const alerts = document.querySelectorAll('.flash-alert');
    alerts.forEach(alert => {
        alert.style.transition = 'opacity 0.5s ease-out, transform 0.5s ease-out';
        alert.style.opacity = '0';
        alert.style.transform = 'translateY(-10px)';
        
        setTimeout(() => {
            alert.remove();
        }, 500);
    });
}, 5000); 

</script>

<?= $this->endSection() ?>