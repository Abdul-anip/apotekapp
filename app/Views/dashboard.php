<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="max-w-7xl mx-auto">
    <h1 class="text-3xl font-bold mb-6"><?= $title ?></h1>

    <!-- 🟢 Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <!-- Total Obat -->
        <div class="bg-white p-6 rounded-lg shadow hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Obat</p>
                    <p class="text-3xl font-bold text-teal-700 mt-2"><?= $totalObat ?></p>
                </div>
                <div class="bg-teal-100 p-3 rounded-full">
                    <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Transaksi Hari Ini -->
        <div class="bg-white p-6 rounded-lg shadow hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Transaksi Hari Ini</p>
                    <p class="text-3xl font-bold text-blue-700 mt-2"><?= $transaksiHariIni ?></p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Penjualan Hari Ini -->
        <div class="bg-white p-6 rounded-lg shadow hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Penjualan Hari Ini</p>
                    <p class="text-2xl font-bold text-green-700 mt-2">Rp <?= number_format($totalPenjualanHariIni, 0, ',', '.') ?></p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Keuntungan Hari Ini -->
        <div class="bg-white p-6 rounded-lg shadow hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Keuntungan Hari Ini</p>
                    <p class="text-2xl font-bold text-yellow-600 mt-2">Rp <?= number_format($totalKeuntunganHariIni, 0, ',', '.') ?></p>
                </div>
                <div class="bg-yellow-100 p-3 rounded-full">
                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- 🔴 Alert Cards untuk Kadaluarsa -->
    <?php if ($obatSudahKadaluarsa > 0 || $obatAkanKadaluarsa > 0): ?>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <!-- Obat Sudah Kadaluarsa -->
        <?php if ($obatSudahKadaluarsa > 0): ?>
        <div class="bg-red-50 border-2 border-red-400 rounded-lg p-4 flex items-start">
            <div class="bg-red-500 p-2 rounded-full mr-3">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-bold text-red-800 mb-1">Obat Kadaluarsa!</h3>
                <p class="text-red-700 text-sm">
                    <span class="font-bold text-2xl"><?= $obatSudahKadaluarsa ?></span> obat sudah melewati tanggal kadaluarsa
                </p>
                <button onclick="toggleDetail('expired')" class="mt-2 text-red-600 hover:text-red-800 text-sm font-semibold underline">
                    Lihat Detail →
                </button>
            </div>
        </div>
        <?php endif; ?>

        
    </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- 🟢 Stok Menipis -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-800">Stok Menipis</h2>
                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-semibold">
                    <?= $stokMenipis ?> Item
                </span>
            </div>
            
            <?php if (!empty($obatStokMenipis)): ?>
                <div class="space-y-3">
                    <?php foreach ($obatStokMenipis as $obat): ?>
                        <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg border border-red-100">
                            <div>
                                <p class="font-semibold text-gray-800"><?= esc($obat['nama_obat']) ?></p>
                                <p class="text-sm text-gray-500"><?= esc($obat['nama_kategori'] ?? 'Tidak ada kategori') ?></p>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-bold text-red-600">Stok: <?= $obat['stok'] ?></p>
                                <p class="text-xs text-gray-500">Min: 10</p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <a href="/obat" class="block mt-4 text-center text-teal-600 hover:text-teal-700 font-medium text-sm">
                    Lihat Semua Obat →
                </a>
            <?php else: ?>
                <div class="text-center py-8">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-gray-500">Semua stok obat aman! 🎉</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- 🔴 Obat Akan Kadaluarsa (30 Hari) -->
        <div class="bg-white rounded-lg shadow p-6" id="upcoming-section" style="display: none;">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-800">Akan Kadaluarsa (30 Hari)</h2>
                <button onclick="toggleDetail('upcoming')" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <?php if (!empty($obatKadaluarsaDetail)): ?>
                <div class="space-y-3">
                    <?php foreach ($obatKadaluarsaDetail as $obat): 
                        $tglED = strtotime($obat['tanggal_kadaluarsa']);
                        $today = time();
                        $diffDays = ceil(($tglED - $today) / (60 * 60 * 24));
                    ?>
                        <div class="flex items-center justify-between p-3 bg-orange-50 rounded-lg border border-orange-100">
                            <div class="flex-1">
                                <p class="font-semibold text-gray-800"><?= esc($obat['nama_obat']) ?></p>
                                <p class="text-sm text-gray-500"><?= esc($obat['nama_kategori'] ?? 'Tidak ada kategori') ?></p>
                                <p class="text-xs text-gray-500 mt-1">Stok: <?= $obat['stok'] ?> unit</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-orange-600">
                                    <?= date('d M Y', strtotime($obat['tanggal_kadaluarsa'])) ?>
                                </p>
                                <p class="text-xs text-orange-700 font-semibold mt-1">
                                    <?= $diffDays ?> hari lagi
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-8">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-gray-500">Tidak ada obat yang akan kadaluarsa dalam 30 hari</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- 🔴 Obat Sudah Kadaluarsa -->
        <div class="bg-white rounded-lg shadow p-6" id="expired-section" style="display: none;">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-800">Sudah Kadaluarsa</h2>
                <button onclick="toggleDetail('expired')" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <?php if (!empty($obatSudahKadaluarsaDetail)): ?>
                <div class="space-y-3">
                    <?php foreach ($obatSudahKadaluarsaDetail as $obat): 
                        $tglED = strtotime($obat['tanggal_kadaluarsa']);
                        $today = time();
                        $diffDays = floor(($today - $tglED) / (60 * 60 * 24));
                    ?>
                        <div class="flex items-center justify-between p-3 bg-red-100 rounded-lg border border-red-200">
                            <div class="flex-1">
                                <p class="font-semibold text-gray-800"><?= esc($obat['nama_obat']) ?></p>
                                <p class="text-sm text-gray-500"><?= esc($obat['nama_kategori'] ?? 'Tidak ada kategori') ?></p>
                                <p class="text-xs text-gray-500 mt-1">Stok: <?= $obat['stok'] ?> unit</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-red-700">
                                    <?= date('d M Y', strtotime($obat['tanggal_kadaluarsa'])) ?>
                                </p>
                                <p class="text-xs text-red-600 font-semibold mt-1">
                                    <?= $diffDays ?> hari lalu
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="mt-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                    <p class="text-sm text-red-700 font-semibold">
                        ⚠️ Segera keluarkan obat kadaluarsa dari stok!
                    </p>
                </div>
            <?php else: ?>
                <div class="text-center py-8">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-gray-500">Tidak ada obat yang sudah kadaluarsa</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- 🟢 Transaksi Terbaru Hari Ini -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Transaksi Terbaru Hari Ini</h2>
            
            <?php if (!empty($transaksiTerbaru)): ?>
                <div class="space-y-3">
                    <?php foreach ($transaksiTerbaru as $trx): ?>
                        <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-bold text-teal-600"><?= esc($trx['kode_transaksi']) ?></span>
                                <span class="text-xs text-gray-500"><?= date('H:i', strtotime($trx['tanggal'])) ?></span>
                            </div>
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-lg font-bold text-gray-800">Rp <?= number_format($trx['total_harga'], 0, ',', '.') ?></p>
                                    <p class="text-xs text-green-600">Untung: Rp <?= number_format($trx['keuntungan'], 0, ',', '.') ?></p>
                                </div>
                                <div class="text-right text-sm text-gray-600">
                                    <?= count($trx['items']) ?> item
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <a href="/laporan" class="block mt-4 text-center text-teal-600 hover:text-teal-700 font-medium text-sm">
                    Lihat Semua Laporan →
                </a>
            <?php else: ?>
                <div class="text-center py-8">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <p class="text-gray-500">Belum ada transaksi hari ini</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- 🟢 Quick Actions -->
    <div class="mt-6 bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Quick Actions</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="/penjualan" class="flex flex-col items-center justify-center p-4 bg-teal-50 rounded-lg hover:bg-teal-100 transition">
                <svg class="w-8 h-8 text-teal-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <span class="text-sm font-semibold text-gray-700">Penjualan</span>
            </a>
            
            <a href="/obat/create" class="flex flex-col items-center justify-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                <svg class="w-8 h-8 text-blue-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span class="text-sm font-semibold text-gray-700">Tambah Obat</span>
            </a>
            
            <a href="/laporan" class="flex flex-col items-center justify-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition">
                <svg class="w-8 h-8 text-green-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span class="text-sm font-semibold text-gray-700">Laporan</span>
            </a>
            
            <a href="/obat" class="flex flex-col items-center justify-center p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition">
                <svg class="w-8 h-8 text-yellow-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                <span class="text-sm font-semibold text-gray-700">Kelola Obat</span>
            </a>
        </div>
    </div>
</div>

<script>
function toggleDetail(type) {
    const upcomingSection = document.getElementById('upcoming-section');
    const expiredSection = document.getElementById('expired-section');
    
    if (type === 'upcoming') {
        if (upcomingSection.style.display === 'none') {
            upcomingSection.style.display = 'block';
        } else {
            upcomingSection.style.display = 'none';
        }
    } else if (type === 'expired') {
        if (expiredSection.style.display === 'none') {
            expiredSection.style.display = 'block';
        } else {
            expiredSection.style.display = 'none';
        }
    }
}
</script>

<?= $this->endSection() ?>