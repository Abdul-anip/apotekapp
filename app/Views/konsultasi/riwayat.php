<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800"><?= $title ?></h1>
            <p class="text-sm text-gray-600 mt-1">Riwayat konsultasi gejala pelanggan</p>
        </div>
        <a href="/konsultasi" class="bg-teal-600 text-white px-4 py-2 rounded-lg hover:bg-teal-700 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Konsultasi Baru
        </a>
    </div>

    <!-- Search Bar -->
    <div class="bg-white rounded-lg shadow-sm p-4 mb-5">
        <input type="text" id="searchRiwayat" placeholder="🔍 Cari berdasarkan kasir atau kode..." 
               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
    </div>

    <!-- Table Riwayat -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <?php if (empty($riwayat)): ?>
            <div class="text-center py-12">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-gray-500 text-lg font-medium">Belum ada riwayat konsultasi</p>
                <a href="/konsultasi" class="inline-block mt-4 bg-teal-600 text-white px-6 py-2 rounded-lg hover:bg-teal-700 transition">
                    Mulai Konsultasi
                </a>
            </div>
        <?php else: ?>
            <table class="min-w-full">
                <thead class="bg-gradient-to-r from-teal-600 to-teal-700 text-white">
                    <tr>
                        <th class="py-3 px-4 text-left w-16">No</th>
                        <th class="py-3 px-4 text-left">Kode Konsultasi</th>
                        <th class="py-3 px-4 text-left">Kasir</th>
                        <th class="py-3 px-4 text-left">Tanggal</th>
                        <th class="py-3 px-4 text-center">Gejala</th>
                        <th class="py-3 px-4 text-center">Diagnosa</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <?php $no = 1; foreach ($riwayat as $row): ?>
                    <tr class="border-b hover:bg-gray-50 transition riwayat-row" 
                        data-kode="<?= strtolower($row['kode_konsultasi']) ?>"
                        data-kasir="<?= strtolower($row['nama_lengkap']) ?>">
                        <td class="py-3 px-4 text-gray-600"><?= $no++ ?></td>
                        <td class="py-3 px-4">
                            <span class="font-semibold text-teal-600"><?= esc($row['kode_konsultasi']) ?></span>
                        </td>
                        <td class="py-3 px-4 text-gray-700">
                            <?= esc($row['nama_lengkap']) ?>
                        </td>
                        <td class="py-3 px-4 text-gray-600 text-sm">
                            <?= date('d M Y, H:i', strtotime($row['tanggal_konsultasi'])) ?>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-semibold">
                                <?= count($row['gejala_input']) ?> Gejala
                            </span>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">
                                <?= count($row['hasil_diagnosa']) ?> Penyakit
                            </span>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <button onclick='showDetail(<?= json_encode($row, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)' 
                                    class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition text-sm">
                                Detail
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<!-- Modal Detail -->
<div id="modalDetail" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl mx-4 max-h-[90vh] overflow-y-auto">
        <div class="bg-teal-600 text-white p-4 rounded-t-lg flex justify-between items-center sticky top-0">
            <h3 class="text-xl font-bold" id="modalTitle">Detail Konsultasi</h3>
            <button onclick="closeModal()" class="text-white hover:text-gray-200 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="p-6" id="modalContent"></div>
    </div>
</div>

<script>
// Search functionality
document.getElementById('searchRiwayat')?.addEventListener('input', function(e) {
    const search = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('.riwayat-row');
    
    rows.forEach(row => {
        const kode = row.dataset.kode;
        const kasir = row.dataset.kasir;
        row.style.display = (kode.includes(search) || kasir.includes(search)) ? '' : 'none';
    });
});

// Show Detail Modal
function showDetail(data) {
    const modal = document.getElementById('modalDetail');
    const title = document.getElementById('modalTitle');
    const content = document.getElementById('modalContent');
    
    title.textContent = 'Detail Konsultasi ' + data.kode_konsultasi;
    
    let html = `
        <!-- Info Konsultasi -->
        <div class="bg-gray-50 rounded-lg p-4 mb-6">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500">Kode Konsultasi</p>
                    <p class="font-semibold text-gray-800">${data.kode_konsultasi}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Tanggal</p>
                    <p class="font-semibold text-gray-800">${new Date(data.tanggal_konsultasi).toLocaleDateString('id-ID', {
                        day: '2-digit',
                        month: 'long',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    })}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Kasir</p>
                    <p class="font-semibold text-gray-800">${data.nama_lengkap}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Gejala</p>
                    <p class="font-semibold text-gray-800">${data.gejala_input.length} Gejala</p>
                </div>
            </div>
        </div>

        <!-- Hasil Diagnosa -->
        <div class="mb-6">
            <h4 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Hasil Diagnosa
            </h4>
            <div class="space-y-3">
    `;
    
    data.hasil_diagnosa.forEach((penyakit, index) => {
        const badgeColors = ['bg-green-500', 'bg-blue-500', 'bg-yellow-500'];
        const badgeColor = badgeColors[index] || 'bg-gray-500';
        
        html += `
            <div class="border-2 border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="${badgeColor} text-white w-8 h-8 rounded-full flex items-center justify-center font-bold">
                            ${index + 1}
                        </span>
                        <div>
                            <h5 class="font-bold text-gray-800">${penyakit.nama_penyakit}</h5>
                            <p class="text-sm text-gray-500">${penyakit.kode_penyakit}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-2xl font-bold text-gray-800">${penyakit.persentase.toFixed(2)}%</p>
                        <p class="text-xs text-gray-500">CF: ${penyakit.cf_hasil.toFixed(4)}</p>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="h-2 rounded-full ${penyakit.cf_hasil >= 0.8 ? 'bg-green-500' : (penyakit.cf_hasil >= 0.6 ? 'bg-blue-500' : 'bg-yellow-500')}" 
                             style="width: ${penyakit.persentase}%"></div>
                    </div>
                </div>
            </div>
        `;
    });
    
    html += `
            </div>
        </div>

        <!-- Obat Direkomendasikan -->
        <div>
            <h4 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
                <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                Obat Direkomendasikan
            </h4>
    `;
    
    if (data.obat_direkomendasikan && data.obat_direkomendasikan.length > 0) {
        html += `
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                <p class="text-sm text-blue-700">
                    <strong>Total:</strong> ${data.obat_direkomendasikan.length} obat direkomendasikan
                </p>
            </div>
        `;
    } else {
        html += `
            <div class="text-center py-4 text-gray-500 text-sm">
                Tidak ada obat yang direkomendasikan
            </div>
        `;
    }
    
    html += `</div>`;
    
    content.innerHTML = html;
    modal.classList.remove('hidden');
}

function closeModal() {
    document.getElementById('modalDetail').classList.add('hidden');
}

// Close modal on ESC
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeModal();
});

// Close modal when clicking outside
document.getElementById('modalDetail')?.addEventListener('click', (e) => {
    if (e.target === e.currentTarget) closeModal();
});
</script>

<?= $this->endSection() ?>