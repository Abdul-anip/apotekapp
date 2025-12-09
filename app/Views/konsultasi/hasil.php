<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="max-w-6xl mx-auto">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800"><?= $title ?></h1>
            <p class="text-sm text-gray-600 mt-1">Hasil diagnosa berdasarkan gejala yang dipilih</p>
        </div>
        <div class="flex gap-3">
            <a href="/konsultasi" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Konsultasi Lagi
            </a>
            <button onclick="window.print()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Cetak
            </button>
        </div>
    </div>

    <!-- Card Gejala yang Dipilih -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            Gejala yang Dipilih
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
            <?php foreach ($gejala_dipilih as $gejala): ?>
                <div class="flex items-center gap-3 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                    <svg class="w-5 h-5 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <div>
                        <p class="font-semibold text-gray-800"><?= esc($gejala['nama_gejala']) ?></p>
                        <p class="text-xs text-gray-500"><?= esc($gejala['kode_gejala']) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Hasil Diagnosa -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Hasil Diagnosa
        </h2>

        <?php if (empty($hasil_diagnosa)): ?>
            <div class="text-center py-8">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-gray-500">Tidak ada penyakit yang cocok dengan gejala yang dipilih</p>
            </div>
        <?php else: ?>
            <div class="space-y-4">
                <?php foreach ($hasil_diagnosa as $index => $penyakit): 
                    // Tentukan warna badge berdasarkan peringkat
                    $badgeColors = [
                        0 => 'bg-green-500 text-white',
                        1 => 'bg-blue-500 text-white',
                        2 => 'bg-yellow-500 text-white'
                    ];
                    $badgeColor = $badgeColors[$index] ?? 'bg-gray-500 text-white';
                    
                    // Tentukan border color berdasarkan CF
                    if ($penyakit['cf_hasil'] >= 0.8) {
                        $borderColor = 'border-green-500';
                        $bgColor = 'bg-green-50';
                    } elseif ($penyakit['cf_hasil'] >= 0.6) {
                        $borderColor = 'border-blue-500';
                        $bgColor = 'bg-blue-50';
                    } elseif ($penyakit['cf_hasil'] >= 0.4) {
                        $borderColor = 'border-yellow-500';
                        $bgColor = 'bg-yellow-50';
                    } else {
                        $borderColor = 'border-gray-500';
                        $bgColor = 'bg-gray-50';
                    }
                ?>
                <div class="border-2 <?= $borderColor ?> <?= $bgColor ?> rounded-lg p-5 hover:shadow-md transition">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex items-center gap-3">
                            <span class="<?= $badgeColor ?> w-10 h-10 rounded-full flex items-center justify-center font-bold text-lg">
                                <?= $index + 1 ?>
                            </span>
                            <div>
                                <h3 class="text-xl font-bold text-gray-800"><?= esc($penyakit['nama_penyakit']) ?></h3>
                                <p class="text-sm text-gray-500"><?= esc($penyakit['kode_penyakit']) ?></p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-600 font-semibold">Tingkat Kepercayaan</p>
                            <p class="text-3xl font-bold text-gray-800"><?= number_format($penyakit['persentase'], 2) ?>%</p>
                            <p class="text-xs text-gray-500">CF: <?= number_format($penyakit['cf_hasil'], 4) ?></p>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div class="mb-4">
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="h-3 rounded-full transition-all duration-500 <?= $penyakit['cf_hasil'] >= 0.8 ? 'bg-green-500' : ($penyakit['cf_hasil'] >= 0.6 ? 'bg-blue-500' : ($penyakit['cf_hasil'] >= 0.4 ? 'bg-yellow-500' : 'bg-gray-500')) ?>" 
                                 style="width: <?= $penyakit['persentase'] ?>%"></div>
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <?php if (!empty($penyakit['deskripsi'])): ?>
                    <div class="bg-white rounded-lg p-4 mb-4 border border-gray-200">
                        <h4 class="font-semibold text-gray-700 mb-2">Deskripsi:</h4>
                        <p class="text-gray-600 text-sm"><?= esc($penyakit['deskripsi']) ?></p>
                    </div>
                    <?php endif; ?>

                    <!-- Rekomendasi (hanya untuk penyakit peringkat 1) -->
                    <?php if ($index === 0): ?>
                    <div class="bg-white rounded-lg p-4 border border-green-300">
                        <div class="flex items-center gap-2 mb-3">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            <h4 class="font-bold text-green-700">Diagnosa Utama</h4>
                        </div>
                        <p class="text-sm text-gray-600">
                            Berdasarkan gejala yang Anda pilih, kemungkinan besar Anda mengalami 
                            <strong><?= esc($penyakit['nama_penyakit']) ?></strong> 
                            dengan tingkat kepercayaan <strong><?= number_format($penyakit['persentase'], 2) ?>%</strong>.
                        </p>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Rekomendasi Obat -->
    <?php if (!empty($rekomendasi_obat)): ?>
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
            <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
            </svg>
            Rekomendasi Obat
        </h2>

        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
            <div class="flex items-start gap-2">
                <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-sm text-blue-700">
                    <strong>Catatan:</strong> Rekomendasi obat ini berdasarkan diagnosa sistem. 
                    Konsultasikan dengan apoteker atau dokter untuk penggunaan yang tepat.
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <?php foreach ($rekomendasi_obat as $obat): ?>
            <div class="border-2 border-teal-200 rounded-lg p-4 hover:shadow-md transition bg-teal-50">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex-1">
                        <h3 class="font-bold text-gray-800 mb-1"><?= esc($obat['nama_obat']) ?></h3>
                        <p class="text-sm text-gray-600"><?= esc($obat['merk']) ?></p>
                        <span class="inline-block bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded mt-2">
                            <?= esc($obat['nama_kategori']) ?>
                        </span>
                    </div>
                    <div class="text-right ml-3">
                        <span class="bg-teal-600 text-white px-3 py-1 rounded-full text-xs font-bold">
                            Prioritas <?= $obat['prioritas'] ?>
                        </span>
                    </div>
                </div>

                <div class="bg-white rounded p-3 mb-3">
                    <p class="text-sm text-gray-700">
                        <strong>Harga:</strong> 
                        <span class="text-teal-700 font-bold">Rp <?= number_format($obat['harga_jual'], 0, ',', '.') ?></span>
                    </p>
                    <p class="text-sm text-gray-700">
                        <strong>Stok:</strong> 
                        <span class="<?= $obat['stok'] < 10 ? 'text-red-600' : 'text-green-600' ?> font-semibold">
                            <?= $obat['stok'] ?> unit
                        </span>
                    </p>
                </div>

                <?php if (!empty($obat['dosis_saran'])): ?>
                <div class="bg-yellow-50 border border-yellow-200 rounded p-3 mb-3">
                    <p class="text-xs text-yellow-800">
                        <strong>💊 Dosis:</strong> <?= esc($obat['dosis_saran']) ?>
                    </p>
                </div>
                <?php endif; ?>

                <!-- Tombol Aksi -->
                <div class="flex gap-2">
                    <?php if ($obat['stok'] > 0): ?>
                        <a href="/penjualan/add/<?= $obat['id_obat'] ?>" 
                           class="flex-1 bg-teal-600 text-white px-4 py-2 rounded-lg hover:bg-teal-700 transition text-sm font-semibold text-center">
                            + Tambah ke Keranjang
                        </a>
                    <?php else: ?>
                        <button disabled class="flex-1 bg-gray-300 text-gray-600 px-4 py-2 rounded-lg text-sm font-semibold cursor-not-allowed">
                            Stok Habis
                        </button>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Tombol Lanjut ke Penjualan -->
        <div class="mt-6 text-center">
            <a href="/penjualan" class="inline-flex items-center gap-2 bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition font-bold text-lg shadow-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                Lanjut ke Penjualan
            </a>
        </div>
    </div>
    <?php else: ?>
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Rekomendasi Obat</h2>
        <div class="text-center py-8">
            <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
            </svg>
            <p class="text-gray-500">Tidak ada rekomendasi obat untuk diagnosa ini</p>
        </div>
    </div>
    <?php endif; ?>

    <!-- Disclaimer -->
    <div class="bg-red-50 border-2 border-red-300 rounded-lg p-5">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <div>
                <h4 class="font-bold text-red-800 mb-2">⚠️ Disclaimer Penting</h4>
                <ul class="text-sm text-red-700 space-y-1">
                    <li>• Hasil diagnosa ini bersifat <strong>informatif</strong> dan bukan pengganti konsultasi medis profesional</li>
                    <li>• Untuk diagnosis akurat dan pengobatan yang tepat, <strong>konsultasikan dengan dokter atau apoteker</strong></li>
                    <li>• Jangan menggunakan obat tanpa resep atau anjuran tenaga kesehatan</li>
                    <li>• Segera hubungi dokter jika gejala memburuk atau tidak membaik</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .no-print {
        display: none !important;
    }
    
    body {
        print-color-adjust: exact;
        -webkit-print-color-adjust: exact;
    }
}
</style>

<?= $this->endSection() ?>