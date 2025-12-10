?>

<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800"><?= $title ?></h1>
        <p class="text-sm text-gray-600 mt-1">Analytics dan statistik knowledge base</p>
    </div>

    <!-- Main Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <!-- Total Penyakit -->
        <div class="bg-gradient-to-br from-teal-500 to-teal-600 text-white p-6 rounded-lg shadow-lg hover:shadow-xl transition">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <p class="text-sm opacity-90">Total Penyakit</p>
                    <p class="text-4xl font-bold mt-1"><?= $stats['total_penyakit'] ?></p>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            </div>
            <p class="text-xs opacity-80"><?= $stats['penyakit_dengan_aturan'] ?> dengan aturan</p>
        </div>

        <!-- Total Gejala -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white p-6 rounded-lg shadow-lg hover:shadow-xl transition">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <p class="text-sm opacity-90">Total Gejala</p>
                    <p class="text-4xl font-bold mt-1"><?= $stats['total_gejala'] ?></p>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
            </div>
            <p class="text-xs opacity-80"><?= $stats['gejala_terpakai'] ?> terpakai</p>
        </div>

        <!-- Total Aturan -->
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 text-white p-6 rounded-lg shadow-lg hover:shadow-xl transition">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <p class="text-sm opacity-90">Total Aturan</p>
                    <p class="text-4xl font-bold mt-1"><?= $stats['total_aturan'] ?></p>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                    </svg>
                </div>
            </div>
            <p class="text-xs opacity-80">Avg CF: <?= $stats['avg_cf'] ?></p>
        </div>

        <!-- Coverage -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 text-white p-6 rounded-lg shadow-lg hover:shadow-xl transition">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <p class="text-sm opacity-90">Coverage</p>
                    <p class="text-4xl font-bold mt-1"><?= $stats['coverage'] ?>%</p>
                </div>
                <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 00-2-2m0 0h2a2 2 0 012 2v0a2 2 0 01-2 2h-2a2 2 0 01-2-2v0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-xs opacity-80"><?= $stats['total_konsultasi'] ?> konsultasi</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Top Penyakit -->
        <div class="bg-white rounded-lg shadow-lg">
            <div class="p-5 border-b bg-gradient-to-r from-teal-50 to-blue-50">
                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                    Top 10 Penyakit Terdiagnosa
                </h3>
            </div>
            <div class="p-5 max-h-96 overflow-y-auto">
                <?php if (empty($top_penyakit)): ?>
                    <p class="text-center text-gray-500 py-8">Belum ada data konsultasi</p>
                <?php else: ?>
                    <?php foreach ($top_penyakit as $index => $p): ?>
                    <div class="flex items-center gap-3 mb-3 p-3 bg-gray-50 rounded-lg hover:bg-teal-50 transition">
                        <div class="flex-shrink-0 w-8 h-8 bg-teal-100 rounded-full flex items-center justify-center font-bold text-teal-700">
                            <?= $index + 1 ?>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-gray-800"><?= esc($p['nama_penyakit']) ?></p>
                        </div>
                        <div class="text-right">
                            <span class="bg-teal-600 text-white px-3 py-1 rounded-full text-sm font-bold">
                                <?= $p['jumlah'] ?>x
                            </span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Top Gejala -->
        <div class="bg-white rounded-lg shadow-lg">
            <div class="p-5 border-b bg-gradient-to-r from-blue-50 to-purple-50">
                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 00-2-2m0 0h2a2 2 0 012 2v0a2 2 0 01-2 2h-2a2 2 0 01-2-2v0z"/>
                    </svg>
                    Gejala Paling Sering Dipilih
                </h3>
            </div>
            <div class="p-5 max-h-96 overflow-y-auto">
                <?php if (empty($top_gejala)): ?>
                    <p class="text-center text-gray-500 py-8">Belum ada data gejala</p>
                <?php else: ?>
                    <?php foreach ($top_gejala as $index => $g): ?>
                    <div class="flex items-center gap-3 mb-3 p-3 bg-gray-50 rounded-lg hover:bg-blue-50 transition">
                        <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center font-bold text-blue-700">
                            <?= $index + 1 ?>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-gray-800"><?= esc($g['nama_gejala']) ?></p>
                            <p class="text-xs text-gray-500"><?= esc($g['kode_gejala']) ?></p>
                        </div>
                        <div>
                            <span class="bg-blue-600 text-white px-3 py-1 rounded-full text-sm font-bold">
                                <?= $g['frekuensi'] ?>x
                            </span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Warnings & Alerts -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Penyakit Tanpa Aturan -->
        <?php if (!empty($penyakit_tanpa_aturan)): ?>
        <div class="bg-orange-50 border-2 border-orange-400 rounded-lg p-5">
            <h4 class="font-bold text-orange-800 mb-3 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                Penyakit Tanpa Aturan
            </h4>
            <div class="space-y-2">
                <?php foreach ($penyakit_tanpa_aturan as $p): ?>
                <a href="/admin/aturan/bulk-create/<?= $p['id'] ?>" 
                   class="block p-2 bg-white rounded hover:bg-orange-100 transition text-sm">
                    <span class="font-semibold text-gray-800"><?= esc($p['nama_penyakit']) ?></span>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Gejala Tidak Terpakai -->
        <?php if (!empty($gejala_tidak_terpakai)): ?>
        <div class="bg-yellow-50 border-2 border-yellow-400 rounded-lg p-5">
            <h4 class="font-bold text-yellow-800 mb-3 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Gejala Tidak Terpakai
            </h4>
            <div class="space-y-2">
                <?php foreach ($gejala_tidak_terpakai as $g): ?>
                <div class="block p-2 bg-white rounded text-sm">
                    <span class="font-semibold text-gray-800"><?= esc($g['nama_gejala']) ?></span>
                    <p class="text-xs text-gray-500"><?= esc($g['kode_gejala']) ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Aturan CF Rendah -->
        <?php if (!empty($aturan_cf_rendah)): ?>
        <div class="bg-red-50 border-2 border-red-400 rounded-lg p-5">
            <h4 class="font-bold text-red-800 mb-3 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/>
                </svg>
                Aturan CF Rendah (<0.3)
            </h4>
            <div class="space-y-2">
                <?php foreach ($aturan_cf_rendah as $a): ?>
                <a href="/admin/aturan/edit/<?= $a['id'] ?>" 
                   class="block p-2 bg-white rounded hover:bg-red-100 transition text-sm">
                    <span class="font-semibold text-gray-800"><?= esc($a['nama_penyakit']) ?></span>
                    <p class="text-xs text-gray-600">→ <?= esc($a['nama_gejala']) ?></p>
                    <p class="text-xs text-red-600 font-bold">CF: <?= $a['cf_pakar'] ?></p>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h3 class="font-bold text-gray-800 mb-4">Quick Actions</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="/admin/penyakit" class="flex flex-col items-center p-4 bg-teal-50 rounded-lg hover:bg-teal-100 transition">
                <svg class="w-8 h-8 text-teal-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span class="text-sm font-semibold text-gray-700">Kelola Penyakit</span>
            </a>
            <a href="/admin/gejala" class="flex flex-col items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                <svg class="w-8 h-8 text-blue-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <span class="text-sm font-semibold text-gray-700">Kelola Gejala</span>
            </a>
            <a href="/admin/aturan" class="flex flex-col items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition">
                <svg class="w-8 h-8 text-purple-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                </svg>
                <span class="text-sm font-semibold text-gray-700">Kelola Aturan</span>
            </a>
            <a href="/konsultasi/riwayat" class="flex flex-col items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition">
                <svg class="w-8 h-8 text-green-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="text-sm font-semibold text-gray-700">Riwayat Konsultasi</span>
            </a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>