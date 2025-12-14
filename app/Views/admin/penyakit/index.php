<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800"><?= $title ?></h1>
            <p class="text-sm text-gray-600 mt-1">Tambahkan penyakit dan obat yang direkomendasikan</p>
        </div>
        <a href="/admin/penyakit" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    <!-- Flash Errors -->
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-4">
            <ul class="list-disc list-inside">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="/admin/penyakit/store" method="post" class="space-y-6">
        <?= csrf_field() ?>

        <!-- Card: Informasi Penyakit -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Informasi Penyakit
            </h2>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kode Penyakit *</label>
                    <input type="text" name="kode_penyakit" value="<?= $kodeOtomatis ?>" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 uppercase">
                    <p class="text-xs text-gray-500 mt-1">*Kode otomatis sudah di-generate</p>
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
                              placeholder="Deskripsi lengkap tentang penyakit ini..."
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"></textarea>
                </div>
            </div>
        </div>

        <!-- Card: Rekomendasi Obat -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                    <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    Rekomendasi Obat
                </h2>
                <button type="button" onclick="addObatRow()" 
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Obat
                </button>
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-4">
                <p class="text-sm text-blue-700">
                    💡 <strong>Tips:</strong> Pilih obat yang akan direkomendasikan untuk penyakit ini. 
                    Prioritas 1 = obat utama, prioritas 2+ = obat alternatif.
                </p>
            </div>

            <div id="obatContainer" class="space-y-3">
                <!-- Row akan ditambahkan di sini via JavaScript -->
            </div>

            <div id="emptyState" class="text-center py-8 text-gray-500">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                </svg>
                <p>Belum ada obat yang ditambahkan</p>
                <p class="text-sm mt-1">Klik tombol "Tambah Obat" untuk menambahkan rekomendasi</p>
            </div>
        </div>

        <!-- Button Submit -->
        <div class="flex gap-3">
            <button type="submit" 
                    class="flex-1 bg-teal-600 text-white py-3 rounded-lg hover:bg-teal-700 transition font-bold flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Simpan Penyakit
            </button>
            <a href="/admin/penyakit" 
               class="bg-gray-300 text-gray-700 px-8 py-3 rounded-lg hover:bg-gray-400 transition font-bold text-center">
                Batal
            </a>
        </div>
    </form>
</div>

<script>
let obatRowIndex = 0;

const obatList = <?= json_encode($obat_list) ?>;

function addObatRow() {
    const container = document.getElementById('obatContainer');
    const emptyState = document.getElementById('emptyState');
    
    obatRowIndex++;
    
    const row = document.createElement('div');
    row.className = 'border-2 border-gray-200 rounded-lg p-4 hover:border-teal-300 transition obat-row';
    row.id = 'obat-row-' + obatRowIndex;
    
    row.innerHTML = `
        <div class="flex items-start gap-3">
            <div class="flex-1 space-y-3">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Pilih Obat *</label>
                        <select name="obat_ids[]" required 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 text-sm">
                            <option value="">-- Pilih Obat --</option>
                            ${obatList.map(o => `
                                <option value="${o.id_obat}">
                                    ${o.nama_obat} (${o.merk}) - Stok: ${o.stok}
                                </option>
                            `).join('')}
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
                    class="text-red-500 hover:text-red-700 p-2">
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
    row.remove();
    
    const container = document.getElementById('obatContainer');
    const emptyState = document.getElementById('emptyState');
    
    if (container.children.length === 0) {
        emptyState.style.display = 'block';
    }
    
    updatePriorities();
}

function updatePriorities() {
    const priorityInputs = document.querySelectorAll('input[name="priorities[]"]');
    priorityInputs.forEach((input, index) => {
        input.value = index + 1;
    });
}

// Auto-add satu row saat load
document.addEventListener('DOMContentLoaded', function() {
    addObatRow();
});
</script>

<?= $this->endSection() ?>