<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="max-w-5xl mx-auto">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800"><?= $title ?></h1>
            <p class="text-sm text-gray-600 mt-1">Tambahkan beberapa gejala sekaligus untuk penyakit ini</p>
        </div>
        <a href="/admin/aturan" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    <!-- Penyakit Info Card -->
    <div class="bg-gradient-to-r from-teal-500 to-teal-600 text-white rounded-lg p-6 mb-6 shadow-lg">
        <div class="flex items-start gap-4">
            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-bold mb-1"><?= esc($penyakit['nama_penyakit']) ?></h2>
                <p class="text-sm opacity-90"><?= esc($penyakit['kode_penyakit']) ?></p>
                <?php if (!empty($penyakit['deskripsi'])): ?>
                    <p class="text-sm opacity-80 mt-2"><?= esc($penyakit['deskripsi']) ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php if (empty($gejala)): ?>
        <!-- Tidak ada gejala tersedia -->
        <div class="bg-white rounded-lg shadow-lg p-12 text-center">
            <svg class="w-20 h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <h3 class="text-xl font-bold text-gray-700 mb-2">Semua Gejala Sudah Ditambahkan!</h3>
            <p class="text-gray-600 mb-6">Semua gejala yang tersedia sudah memiliki aturan untuk penyakit ini.</p>
            <div class="flex gap-3 justify-center">
                <a href="/admin/aturan" class="bg-teal-600 text-white px-6 py-2 rounded-lg hover:bg-teal-700 transition">
                    Lihat Aturan
                </a>
                <a href="/admin/gejala/create" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                    Tambah Gejala Baru
                </a>
            </div>
        </div>
    <?php else: ?>
        <!-- Form Bulk Create -->
        <form action="/admin/aturan/bulk-store" method="post" id="formBulkCreate">
            <?= csrf_field() ?>
            <input type="hidden" name="id_penyakit" value="<?= $penyakit['id'] ?>">

            <!-- Info Card -->
            <div class="bg-blue-50 border-2 border-blue-300 rounded-lg p-4 mb-6">
                <div class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <h4 class="font-semibold text-blue-800 mb-1">Panduan Pengisian CF (Certainty Factor)</h4>
                        <ul class="text-sm text-blue-700 space-y-1">
                            <li>• <strong>0.8 - 1.0:</strong> Gejala sangat khas/pasti terjadi pada penyakit ini</li>
                            <li>• <strong>0.5 - 0.79:</strong> Gejala sering muncul</li>
                            <li>• <strong>0.1 - 0.49:</strong> Gejala jarang/kadang muncul</li>
                            <li>• Geser slider atau isi nilai CF untuk setiap gejala yang relevan</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Search & Filter -->
            <div class="bg-white rounded-lg shadow-sm p-4 mb-5">
                <div class="flex gap-3 items-center">
                    <input type="text" id="searchGejala" placeholder="🔍 Cari gejala..." 
                           class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <button type="button" onclick="selectAll()" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition text-sm">
                        Pilih Semua
                    </button>
                    <button type="button" onclick="deselectAll()" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition text-sm">
                        Batal Pilih
                    </button>
                </div>
            </div>

            <!-- Gejala List dengan CF Slider -->
            <div class="bg-white rounded-lg shadow-lg">
                <div class="p-4 bg-gray-50 border-b">
                    <h3 class="font-bold text-gray-800">Pilih Gejala & Tentukan CF Pakar</h3>
                    <p class="text-sm text-gray-600 mt-1">Total: <?= count($gejala) ?> gejala tersedia</p>
                </div>

                <div class="divide-y max-h-[600px] overflow-y-auto">
                    <?php foreach ($gejala as $g): ?>
                    <div class="p-4 hover:bg-gray-50 transition gejala-item" data-nama="<?= strtolower($g['nama_gejala']) ?>">
                        <div class="flex items-start gap-4">
                            <!-- Checkbox -->
                            <div class="pt-1">
                                <input type="checkbox" name="gejala_id[]" value="<?= $g['id'] ?>" 
                                       id="gejala_<?= $g['id'] ?>"
                                       class="w-5 h-5 text-teal-600 rounded focus:ring-teal-500 gejala-checkbox"
                                       onchange="toggleCFInput(<?= $g['id'] ?>)">
                            </div>

                            <!-- Gejala Info -->
                            <label for="gejala_<?= $g['id'] ?>" class="flex-1 cursor-pointer">
                                <div class="font-semibold text-gray-800"><?= esc($g['nama_gejala']) ?></div>
                                <div class="text-xs text-gray-500 mt-1"><?= esc($g['kode_gejala']) ?></div>
                            </label>

                            <!-- CF Input (Hidden by default) -->
                            <div class="w-72" id="cf_container_<?= $g['id'] ?>" style="display: none;">
                                <div class="flex items-center gap-3">
                                    <div class="flex-1">
                                        <input type="range" name="cf_pakar[]" 
                                               id="cf_slider_<?= $g['id'] ?>"
                                               min="0" max="1" step="0.05" value="0.7"
                                               class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer slider"
                                               oninput="updateCFValue(<?= $g['id'] ?>)">
                                        <div class="flex justify-between text-xs text-gray-500 mt-1">
                                            <span>0.0</span>
                                            <span>0.5</span>
                                            <span>1.0</span>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <input type="number" id="cf_value_<?= $g['id'] ?>" 
                                               step="0.05" min="0" max="1" value="0.7"
                                               class="w-16 px-2 py-1 border border-gray-300 rounded text-center font-bold text-sm"
                                               oninput="syncCFSlider(<?= $g['id'] ?>)">
                                        <div class="text-xs text-gray-500 mt-1">CF</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Summary -->
            <div class="mt-6 bg-gradient-to-r from-green-50 to-blue-50 border-2 border-green-300 rounded-lg p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="font-bold text-gray-800">Gejala Dipilih:</h4>
                        <p class="text-sm text-gray-600 mt-1">Anda telah memilih <span id="selected_count" class="font-bold text-green-700">0</span> gejala</p>
                    </div>
                    <div class="flex gap-3">
                        <a href="/admin/aturan" class="bg-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-400 transition font-semibold">
                            Batal
                        </a>
                        <button type="submit" id="btnSubmit" disabled
                                class="bg-teal-600 text-white px-6 py-3 rounded-lg hover:bg-teal-700 transition font-semibold disabled:bg-gray-400 disabled:cursor-not-allowed">
                            Simpan Aturan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    <?php endif; ?>
</div>

<style>
/* Custom slider styles */
input[type="range"].slider::-webkit-slider-thumb {
    appearance: none;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #0d9488;
    cursor: pointer;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

input[type="range"].slider::-moz-range-thumb {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #0d9488;
    cursor: pointer;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

input[type="range"].slider::-webkit-slider-track {
    background: #e5e7eb;
    height: 8px;
    border-radius: 4px;
}
</style>

<script>
// Toggle CF Input visibility
function toggleCFInput(id) {
    const checkbox = document.getElementById('gejala_' + id);
    const container = document.getElementById('cf_container_' + id);
    
    if (checkbox.checked) {
        container.style.display = 'block';
    } else {
        container.style.display = 'none';
    }
    
    updateSelectedCount();
}

// Update CF value from slider
function updateCFValue(id) {
    const slider = document.getElementById('cf_slider_' + id);
    const valueInput = document.getElementById('cf_value_' + id);
    valueInput.value = parseFloat(slider.value).toFixed(2);
}

// Sync slider from CF value input
function syncCFSlider(id) {
    const valueInput = document.getElementById('cf_value_' + id);
    const slider = document.getElementById('cf_slider_' + id);
    let value = parseFloat(valueInput.value);
    
    if (value < 0) value = 0;
    if (value > 1) value = 1;
    
    valueInput.value = value.toFixed(2);
    slider.value = value;
}

// Update selected count
function updateSelectedCount() {
    const checkboxes = document.querySelectorAll('.gejala-checkbox:checked');
    const count = checkboxes.length;
    document.getElementById('selected_count').textContent = count;
    document.getElementById('btnSubmit').disabled = count === 0;
}

// Select All
function selectAll() {
    document.querySelectorAll('.gejala-checkbox').forEach(cb => {
        cb.checked = true;
        toggleCFInput(cb.value);
    });
}

// Deselect All
function deselectAll() {
    document.querySelectorAll('.gejala-checkbox').forEach(cb => {
        cb.checked = false;
        toggleCFInput(cb.value);
    });
}

// Search
document.getElementById('searchGejala')?.addEventListener('input', function(e) {
    const search = e.target.value.toLowerCase();
    document.querySelectorAll('.gejala-item').forEach(item => {
        const nama = item.dataset.nama;
        item.style.display = nama.includes(search) ? '' : 'none';
    });
});

// Form validation
document.getElementById('formBulkCreate')?.addEventListener('submit', function(e) {
    const checkboxes = document.querySelectorAll('.gejala-checkbox:checked');
    
    if (checkboxes.length === 0) {
        e.preventDefault();
        alert('❌ Pilih minimal 1 gejala!');
        return false;
    }
    
    // Validasi CF untuk setiap gejala yang dipilih
    let invalid = false;
    checkboxes.forEach(cb => {
        const cfValue = parseFloat(document.getElementById('cf_value_' + cb.value).value);
        if (cfValue <= 0 || cfValue > 1) {
            invalid = true;
        }
    });
    
    if (invalid) {
        e.preventDefault();
        alert('❌ CF Pakar harus antara 0.01 - 1.0 untuk semua gejala yang dipilih!');
        return false;
    }
    
    if (!confirm(`✅ Simpan ${checkboxes.length} aturan untuk penyakit <?= esc($penyakit['nama_penyakit']) ?>?`)) {
        e.preventDefault();
        return false;
    }
});
</script>

<?= $this->endSection() ?>