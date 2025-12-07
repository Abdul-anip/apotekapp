<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800"><?= $title ?></h1>
            <p class="text-sm text-gray-600 mt-1">Pilih gejala yang dialami pelanggan untuk mendapatkan rekomendasi obat</p>
        </div>
        <a href="/konsultasi/riwayat" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Riwayat
        </a>
    </div>

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-4">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <!-- Info Card -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <h4 class="font-semibold text-blue-800">Panduan Konsultasi</h4>
                <ol class="text-sm text-blue-700 mt-2 space-y-1 list-decimal list-inside">
                    <li>Pilih <strong>minimal 1 gejala</strong> yang dialami pelanggan</li>
                    <li>Semakin banyak gejala yang dipilih, semakin akurat diagnosa</li>
                    <li>Sistem akan memberikan rekomendasi obat berdasarkan gejala</li>
                    <li>Hasil konsultasi akan tersimpan di riwayat</li>
                </ol>
            </div>
        </div>
    </div>

    <!-- Form Konsultasi -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <form action="/konsultasi/proses" method="post">
            <?= csrf_field() ?>
            
            <div class="mb-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Pilih Gejala yang Dialami
                </h3>

                <!-- Search Gejala -->
                <input type="text" id="searchGejala" placeholder="🔍 Cari gejala..." 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg mb-4 focus:outline-none focus:ring-2 focus:ring-teal-500">

                <!-- Grid Gejala Checkbox -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3" id="gejalaList">
                    <?php foreach ($gejala_list as $gejala): ?>
                        <label class="gejala-item flex items-start gap-3 p-3 border-2 border-gray-200 rounded-lg hover:border-teal-500 hover:bg-teal-50 cursor-pointer transition"
                               data-nama="<?= strtolower($gejala['nama_gejala']) ?>">
                            <input type="checkbox" name="gejala[]" value="<?= $gejala['id'] ?>" 
                                   class="w-5 h-5 mt-0.5 text-teal-600 rounded focus:ring-teal-500">
                            <div>
                                <span class="font-semibold text-gray-800"><?= esc($gejala['nama_gejala']) ?></span>
                                <p class="text-xs text-gray-500 mt-1"><?= esc($gejala['kode_gejala']) ?></p>
                            </div>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Summary Dipilih -->
            <div id="summary" class="hidden mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                <h4 class="font-bold text-green-800 mb-2">Gejala Terpilih:</h4>
                <div id="selectedList" class="flex flex-wrap gap-2"></div>
            </div>

            <!-- Button Submit -->
            <div class="flex gap-3">
                <button type="submit" id="btnDiagnosa"
                        class="flex-1 bg-teal-600 text-white py-3 rounded-lg hover:bg-teal-700 font-bold flex items-center justify-center gap-2 disabled:bg-gray-400 disabled:cursor-not-allowed">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Proses Diagnosa
                </button>
                <a href="/penjualan" class="bg-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-400 font-bold flex items-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
// Search functionality
document.getElementById('searchGejala')?.addEventListener('input', function(e) {
    const search = e.target.value.toLowerCase();
    const items = document.querySelectorAll('.gejala-item');
    
    items.forEach(item => {
        const nama = item.dataset.nama;
        item.style.display = nama.includes(search) ? '' : 'none';
    });
});

// Update summary saat checkbox diubah
const checkboxes = document.querySelectorAll('input[type="checkbox"][name="gejala[]"]');
const summary = document.getElementById('summary');
const selectedList = document.getElementById('selectedList');
const btnDiagnosa = document.getElementById('btnDiagnosa');

function updateSummary() {
    const checked = Array.from(checkboxes).filter(cb => cb.checked);
    
    if (checked.length > 0) {
        summary.classList.remove('hidden');
        btnDiagnosa.disabled = false;
        
        selectedList.innerHTML = checked.map(cb => {
            const label = cb.closest('.gejala-item').querySelector('span').textContent;
            return `<span class="bg-green-200 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">${label}</span>`;
        }).join('');
    } else {
        summary.classList.add('hidden');
        btnDiagnosa.disabled = true;
    }
}

checkboxes.forEach(cb => cb.addEventListener('change', updateSummary));
updateSummary(); // Initial check
</script>

<?= $this->endSection() ?>