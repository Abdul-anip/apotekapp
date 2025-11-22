<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="max-w-7xl mx-auto">

    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Laporan Transaksi</h1>
            <p class="text-gray-500 mt-1">Riwayat semua transaksi penjualan</p>
        </div>
        <button onclick="printLaporan()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
            Cetak Laporan
        </button>
    </div>

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


    <!-- Filter -->
    <div class="bg-white rounded-xl shadow p-4 mb-6">
        <div class="flex flex-wrap gap-4 items-center">
            <input type="date" id="filterTanggal" class="border rounded-lg px-3 py-2 text-sm" onchange="filterTable()">
            <input type="text" id="searchInput" placeholder="Cari kode transaksi..." class="border rounded-lg px-3 py-2 text-sm w-64" onkeyup="filterTable()">
            <button onclick="resetFilter()" class="bg-yellow-600 text-white px-2 py-1 font-sans rounded-lg hover:bg-yellow-700 flex items-center gap-2">Reset Filter</button>
        </div>
    </div>


<table id="laporanTable" class="min-w-full bg-white shadow rounded">
    <thead class="bg-gray-100">
        <tr>
            <th class="py-2 px-4 border">Kode Transaksi</th>
            <th class="py-2 px-4 border">Id Transaksi</th>
            <th class="py-2 px-4 border">Total Belanja</th>
            <th class="py-2 px-4 border">🟢 Keuntungan</th>
            <th class="py-2 px-4 border">Bayar</th>
            <th class="py-2 px-4 border">Kembalian</th>
            <th class="py-2 px-4 border">Barang Dibeli</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($laporan as $row): ?>
            <tr class="text-center">
                <td class="py-2 px-4 border"><?= $row['kode_transaksi'] ?></td>
                <td class="py-2 px-4 border"><?= $row['id_transaksi'] ?></td>
                <td class="py-2 px-4 border">Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>
                <td class="py-2 px-4 border">
                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full font-semibold">
                        Rp <?= number_format($row['keuntungan'], 0, ',', '.') ?>
                    </span>
                </td>
                <td class="py-2 px-4 border">Rp <?= number_format($row['bayar'], 0, ',', '.') ?></td>
                <td class="py-2 px-4 border">Rp <?= number_format($row['kembalian'], 0, ',', '.') ?></td>
                <td class="py-2 px-4 border">
                    <ul class="text-left">
                        <?php foreach ($row['items'] as $item): ?>
                            <li class="text-sm">
                                <?= $item['nama_obat'] ?> -
                                <?= $item['jumlah'] ?> ×
                                Rp <?= number_format($item['harga_jual'], 0, ',', '.') ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function showItems(items) {
    let html = '<div class="space-y-3">';
    items.forEach(item => {
        html += `
            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                <div>
                    <p class="font-medium text-gray-800">${item.nama_obat}</p>
                    <p class="text-sm text-gray-500">${item.jumlah} x Rp ${Number(item.harga_jual).toLocaleString('id-ID')}</p>
                </div>
                <p class="font-bold text-teal-600">Rp ${Number(item.subtotal).toLocaleString('id-ID')}</p>
            </div>
        `;
    });
    html += '</div>';
    document.getElementById('itemsContent').innerHTML = html;
    document.getElementById('itemsModal').classList.remove('hidden');
    document.getElementById('itemsModal').classList.add('flex');
}

function closeModal() {
    document.getElementById('itemsModal').classList.add('hidden');
    document.getElementById('itemsModal').classList.remove('flex');
}

function filterTable() {
    const tanggal = document.getElementById('filterTanggal').value;
    const search = document.getElementById('searchInput').value.toLowerCase();
    const rows = document.querySelectorAll('#laporanTable tbody tr');
    
    rows.forEach(row => {
        const rowTanggal = row.dataset.tanggal;
        const rowText = row.textContent.toLowerCase();
        const matchTanggal = !tanggal || rowTanggal === tanggal;
        const matchSearch = rowText.includes(search);
        row.style.display = matchTanggal && matchSearch ? '' : 'none';
    });
}

function resetFilter() {
    document.getElementById('filterTanggal').value = '';
    document.getElementById('searchInput').value = '';
    filterTable();
}

function printLaporan() {
    window.print();
}
</script>


<?= $this->endSection() ?>