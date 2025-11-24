<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="max-w-7xl mx-auto">

    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Laporan Transaksi</h1>
            <p class="text-gray-500 mt-1">Riwayat semua transaksi penjualan</p>
        </div>
        
        <!-- 🟢 Tombol Cetak & Filter -->
        <div class="flex gap-3">
            <button onclick="toggleFilterPeriode()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                Filter Periode
            </button>
            
            <a href="/laporan/cetakSemua" target="_blank" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Cetak Semua
            </a>
        </div>
    </div>

    <!-- 🟢 Form Filter Periode (Hidden by default) -->
    <div id="filterPeriode" class="hidden bg-white rounded-lg shadow-sm p-4 mb-5">
        <form action="/laporan/cetakPeriode" method="get" target="_blank" class="flex gap-4 items-end">
            <div class="flex-1">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="flex-1">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Akhir</label>
                <input type="date" name="tanggal_akhir" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 font-semibold">
                Cetak Periode
            </button>
            <button type="button" onclick="toggleFilterPeriode()" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 font-semibold">
                Batal
            </button>
        </form>
    </div>

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-4">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <!-- 🟢 Summary Card -->
    <div class="grid grid-cols-3 gap-4 mb-6">
        <?php 
        $total_penjualan = array_sum(array_column($laporan, 'total_harga'));
        $total_keuntungan = array_sum(array_column($laporan, 'keuntungan'));
        ?>
        <div class="bg-white p-6 rounded-lg shadow">
            <p class="text-gray-500 text-sm">Total Transaksi</p>
            <p class="text-2xl font-bold text-teal-700"><?= count($laporan) ?></p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <p class="text-gray-500 text-sm">Total Penjualan</p>
            <p class="text-2xl font-bold text-green-700">Rp <?= number_format($total_penjualan, 0, ',', '.') ?></p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <p class="text-gray-500 text-sm">Total Keuntungan</p>
            <p class="text-2xl font-bold text-green-600">Rp <?= number_format($total_keuntungan, 0, ',', '.') ?></p>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="bg-white rounded-lg shadow-sm p-4 mb-5">
        <input type="text" id="searchInput" placeholder="🔍 Cari kode transaksi..." 
               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"
               onkeyup="filterTable()">
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table id="laporanTable" class="min-w-full">
            <thead class="bg-gradient-to-r from-teal-600 to-teal-700 text-white">
                <tr>
                    <th class="py-3 px-4 text-left">Kode Laporan</th>
                    <th class="py-3 px-4 text-left">Tanggal</th>
                    <th class="py-3 px-4 text-right">Total Belanja</th>
                    <th class="py-3 px-4 text-right">Keuntungan</th>
                    <th class="py-3 px-4 text-center">Item</th>
                    <th class="py-3 px-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($laporan)): ?>
                    <tr>
                        <td colspan="6" class="py-12 text-center">
                            <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <p class="text-gray-500">Belum ada transaksi</p>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($laporan as $row): ?>
                    <tr class="border-b hover:bg-gray-50 transition" data-kode="<?= strtolower($row['kode_transaksi']) ?>">
                        <td class="py-3 px-4">
                            <span class="font-bold text-teal-600"><?= $row['kode_transaksi'] ?></span>
                        </td>
                        <td class="py-3 px-4 text-gray-600">
                            <?= date('d M Y, H:i', strtotime($row['tanggal'])) ?>
                        </td>
                        <td class="py-3 px-4 text-right">
                            <span class="font-bold text-gray-800">Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></span>
                        </td>
                        <td class="py-3 px-4 text-right">
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full font-semibold text-sm">
                                Rp <?= number_format($row['keuntungan'], 0, ',', '.') ?>
                            </span>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-semibold">
                                <?= count($row['items']) ?> item
                            </span>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <div class="flex gap-2 justify-center">
                                <button onclick='showDetail(<?= json_encode($row) ?>)' 
                                        class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 text-sm">
                                    Detail
                                </button>
                                <a href="/laporan/cetakStruk/<?= $row['id'] ?>" target="_blank"
                                   class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 text-sm">
                                    Cetak
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Detail -->
<div id="modalDetail" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto">
        <div class="bg-teal-600 text-white p-4 rounded-t-lg flex justify-between items-center">
            <h3 class="text-xl font-bold" id="modalTitle">Detail Transaksi</h3>
            <button onclick="closeModal()" class="text-white hover:text-gray-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="p-6" id="modalContent"></div>
    </div>
</div>

<script>
function toggleFilterPeriode() {
    const filter = document.getElementById('filterPeriode');
    filter.classList.toggle('hidden');
}

function showDetail(data) {
    const modal = document.getElementById('modalDetail');
    const title = document.getElementById('modalTitle');
    const content = document.getElementById('modalContent');
    
    title.textContent = 'Detail Transaksi ' + data.kode_transaksi;
    
    let html = `
        <div class="space-y-4">
            <div class="grid grid-cols-2 gap-4 bg-gray-50 p-4 rounded-lg">
                <div>
                    <p class="text-sm text-gray-500">Tanggal</p>
                    <p class="font-semibold">${new Date(data.tanggal).toLocaleDateString('id-ID', {day: '2-digit', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit'})}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Harga</p>
                    <p class="font-semibold text-green-700">Rp ${Number(data.total_harga).toLocaleString('id-ID')}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Uang Dibayar</p>
                    <p class="font-semibold">Rp ${Number(data.bayar).toLocaleString('id-ID')}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Kembalian</p>
                    <p class="font-semibold">Rp ${Number(data.kembalian).toLocaleString('id-ID')}</p>
                </div>
            </div>
            
            <div>
                <h4 class="font-bold text-gray-800 mb-3">Daftar Barang</h4>
                <div class="space-y-2">
    `;
    
    data.items.forEach(item => {
        html += `
            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                <div>
                    <p class="font-semibold text-gray-800">${item.nama_obat}</p>
                    <p class="text-sm text-gray-500">${item.jumlah} × Rp ${Number(item.harga_jual).toLocaleString('id-ID')}</p>
                </div>
                <p class="font-bold text-teal-600">Rp ${Number(item.subtotal).toLocaleString('id-ID')}</p>
            </div>
        `;
    });
    
    html += `
                </div>
            </div>
            
            <div class="bg-green-50 p-4 rounded-lg border-2 border-green-500">
                <div class="flex justify-between items-center">
                    <span class="font-bold text-gray-800">Keuntungan:</span>
                    <span class="text-2xl font-bold text-green-700">Rp ${Number(data.keuntungan).toLocaleString('id-ID')}</span>
                </div>
            </div>
        </div>
    `;
    
    content.innerHTML = html;
    modal.classList.remove('hidden');
}

function closeModal() {
    document.getElementById('modalDetail').classList.add('hidden');
}

function filterTable() {
    const search = document.getElementById('searchInput').value.toLowerCase();
    const rows = document.querySelectorAll('#laporanTable tbody tr');
    
    rows.forEach(row => {
        const kode = row.dataset.kode || '';
        row.style.display = kode.includes(search) ? '' : 'none';
    });
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