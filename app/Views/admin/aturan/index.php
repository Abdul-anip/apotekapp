<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800"><?= $title ?></h1>
            <p class="text-sm text-gray-600 mt-1">Kelola aturan knowledge base sistem pakar</p>
        </div>
        <div class="flex gap-3">
            <button onclick="openModalTambah()" class="bg-teal-600 text-white px-4 py-2 rounded-lg hover:bg-teal-700 transition shadow-md flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Aturan
            </button>
        </div>
    </div>

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-5 rounded-lg shadow hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Aturan</p>
                    <p class="text-3xl font-bold text-teal-700 mt-2"><?= $stats['total_aturan'] ?></p>
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
                    <p class="text-gray-500 text-sm">Penyakit</p>
                    <p class="text-3xl font-bold text-blue-700 mt-2"><?= $stats['total_penyakit'] ?></p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-lg shadow hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Gejala</p>
                    <p class="text-3xl font-bold text-purple-700 mt-2"><?= $stats['total_gejala'] ?></p>
                </div>
                <div class="bg-purple-100 p-3 rounded-full">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-lg shadow hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Coverage</p>
                    <p class="text-3xl font-bold text-green-700 mt-2"><?= $stats['coverage'] ?>%</p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Warning: Penyakit Tanpa Aturan -->
    <?php if (!empty($penyakit_tanpa_aturan)): ?>
    <div class="bg-orange-50 border-2 border-orange-400 rounded-lg p-4 mb-6">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-orange-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <div class="flex-1">
                <h3 class="text-lg font-bold text-orange-800 mb-2">⚠️ Penyakit Tanpa Aturan</h3>
                <p class="text-sm text-orange-700 mb-3"><?= count($penyakit_tanpa_aturan) ?> penyakit belum memiliki aturan knowledge base:</p>
                <div class="flex flex-wrap gap-2">
                    <?php foreach ($penyakit_tanpa_aturan as $p): ?>
                    <a href="/admin/aturan/bulk-create/<?= $p['id'] ?>" 
                       class="bg-orange-200 hover:bg-orange-300 text-orange-800 px-3 py-1 rounded-full text-sm font-semibold transition">
                        <?= esc($p['nama_penyakit']) ?> ➕
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Filter & Search -->
    <div class="bg-white rounded-lg shadow-sm p-4 mb-5">
        <div class="flex gap-4 flex-wrap">
            <input type="text" id="searchAturan" placeholder="🔍 Cari penyakit atau gejala..." 
                   class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
            <select id="filterCF" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                <option value="">Semua CF</option>
                <option value="high">CF Tinggi (≥0.8)</option>
                <option value="medium">CF Sedang (0.5-0.79)</option>
                <option value="low">CF Rendah (<0.5)</option>
            </select>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gradient-to-r from-teal-600 to-teal-700 text-white">
                <tr>
                    <th class="py-3 px-4 text-left w-16">No</th>
                    <th class="py-3 px-4 text-left">Penyakit</th>
                    <th class="py-3 px-4 text-left">Gejala</th>
                    <th class="py-3 px-4 text-center">CF Pakar</th>
                    <th class="py-3 px-4 text-center">Level</th>
                    <th class="py-3 px-4 text-center w-48">Aksi</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                <?php if (empty($aturan)): ?>
                    <tr>
                        <td colspan="6" class="py-12 text-center">
                            <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <p class="text-gray-500 text-lg font-medium">Belum ada aturan</p>
                            <button onclick="openModalTambah()" class="inline-block mt-4 bg-teal-600 text-white px-6 py-2 rounded-lg hover:bg-teal-700 transition">
                                Tambah Aturan Pertama
                            </button>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php 
                    $no = 1; 
                    $currentPenyakit = null;
                    foreach($aturan as $a): 
                        $cf = (float)$a['cf_pakar'];
                        if ($cf >= 0.8) {
                            $levelClass = 'bg-green-100 text-green-700';
                            $levelText = 'Tinggi';
                            $cfLevel = 'high';
                        } elseif ($cf >= 0.5) {
                            $levelClass = 'bg-blue-100 text-blue-700';
                            $levelText = 'Sedang';
                            $cfLevel = 'medium';
                        } else {
                            $levelClass = 'bg-yellow-100 text-yellow-700';
                            $levelText = 'Rendah';
                            $cfLevel = 'low';
                        }
                        
                        $showPenyakit = $currentPenyakit != $a['id_penyakit'];
                        $currentPenyakit = $a['id_penyakit'];
                    ?>
                    <tr class="border-b hover:bg-gray-50 transition aturan-row" 
                        data-penyakit="<?= strtolower($a['nama_penyakit']) ?>"
                        data-gejala="<?= strtolower($a['nama_gejala']) ?>"
                        data-cf-level="<?= $cfLevel ?>">
                        <td class="py-3 px-4 text-gray-600"><?= $no++ ?></td>
                        <td class="py-3 px-4">
                            <?php if ($showPenyakit): ?>
                                <div class="font-bold text-gray-800"><?= esc($a['nama_penyakit']) ?></div>
                                <div class="text-xs text-gray-500"><?= esc($a['kode_penyakit']) ?></div>
                            <?php else: ?>
                                <div class="text-gray-400 text-sm">↳ (lanjutan)</div>
                            <?php endif; ?>
                        </td>
                        <td class="py-3 px-4">
                            <div class="font-semibold text-gray-800"><?= esc($a['nama_gejala']) ?></div>
                            <div class="text-xs text-gray-500"><?= esc($a['kode_gejala']) ?></div>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <div class="flex-1 bg-gray-200 rounded-full h-2 max-w-[100px]">
                                    <div class="h-2 rounded-full <?= $cf >= 0.8 ? 'bg-green-500' : ($cf >= 0.5 ? 'bg-blue-500' : 'bg-yellow-500') ?>" 
                                         style="width: <?= $cf * 100 ?>%"></div>
                                </div>
                                <span class="font-bold text-gray-800"><?= number_format($cf, 2) ?></span>
                            </div>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <span class="<?= $levelClass ?> px-3 py-1 rounded-full text-xs font-bold">
                                <?= $levelText ?>
                            </span>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <div class="flex gap-2 justify-center">
                                <button onclick='openModalEdit(<?= json_encode($a) ?>)' 
                                   class="bg-yellow-500 text-white px-3 py-1.5 rounded-lg hover:bg-yellow-600 transition text-sm">
                                    Edit
                                </button>
                                <button onclick="confirmDelete(<?= $a['id'] ?>, '<?= esc($a['nama_penyakit']) ?>', '<?= esc($a['nama_gejala']) ?>')" 
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

    <!-- Info Card -->
    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <h4 class="font-semibold text-blue-800">Panduan CF (Certainty Factor)</h4>
                <ul class="text-sm text-blue-700 mt-2 space-y-1">
                    <li>• <strong>0.8 - 1.0:</strong> Gejala sangat kuat/pasti (misalnya gejala khas)</li>
                    <li>• <strong>0.5 - 0.79:</strong> Gejala cukup kuat/biasa muncul</li>
                    <li>• <strong>0.1 - 0.49:</strong> Gejala lemah/jarang muncul</li>
                    <li>• <strong>Coverage:</strong> Persentase penyakit yang sudah memiliki aturan</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Aturan -->
<div id="modalTambah" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto">
        <div class="bg-gradient-to-r from-teal-600 to-teal-700 text-white p-4 rounded-t-lg flex justify-between items-center sticky top-0">
            <h3 class="text-xl font-bold">Tambah Aturan Baru</h3>
            <button onclick="closeModalTambah()" class="text-white hover:text-gray-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form action="/admin/aturan/store" method="post" class="p-6">
            <?= csrf_field() ?>
            
            <!-- Pilih Penyakit -->
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Penyakit *</label>
                <select name="id_penyakit" id="tambah_penyakit" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <option value="">-- Pilih Penyakit --</option>
                    <?php 
                    $db = \Config\Database::connect();
                    $penyakitList = $db->table('penyakit')->orderBy('nama_penyakit', 'ASC')->get()->getResultArray();
                    foreach ($penyakitList as $p): 
                    ?>
                        <option value="<?= $p['id'] ?>">
                            [<?= esc($p['kode_penyakit']) ?>] <?= esc($p['nama_penyakit']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Pilih Gejala -->
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Gejala *</label>
                <select name="id_gejala" id="tambah_gejala" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <option value="">-- Pilih Gejala --</option>
                    <?php 
                    $gejalaList = $db->table('gejala')->orderBy('kode_gejala', 'ASC')->get()->getResultArray();
                    foreach ($gejalaList as $g): 
                    ?>
                        <option value="<?= $g['id'] ?>">
                            [<?= esc($g['kode_gejala']) ?>] <?= esc($g['nama_gejala']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- CF Pakar Slider -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">CF Pakar *</label>
                <div class="bg-gray-50 border border-gray-300 rounded-lg p-4">
                    <div class="text-center mb-3">
                        <span class="text-4xl font-bold text-teal-600" id="tambah_cf_display">0.70</span>
                    </div>
                    <input type="range" name="cf_pakar" id="tambah_cf_slider" 
                           min="0.01" max="1.00" step="0.01" value="0.70"
                           class="w-full h-3 bg-gray-200 rounded-lg appearance-none cursor-pointer slider-teal"
                           oninput="updateTambahCF()">
                    <div class="flex justify-between text-xs text-gray-600 mt-2">
                        <span>0.01</span>
                        <span>0.50</span>
                        <span>1.00</span>
                    </div>
                    <div class="mt-3 grid grid-cols-3 gap-2 text-xs text-center">
                        <div class="bg-yellow-100 p-2 rounded">0.01-0.49 Jarang</div>
                        <div class="bg-blue-100 p-2 rounded">0.50-0.79 Sering</div>
                        <div class="bg-green-100 p-2 rounded">0.80-1.00 Sangat Khas</div>
                    </div>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-teal-600 text-white py-2 rounded-lg hover:bg-teal-700 transition font-semibold">
                    Simpan
                </button>
                <button type="button" onclick="closeModalTambah()" class="flex-1 bg-gray-300 text-gray-700 py-2 rounded-lg hover:bg-gray-400 transition font-semibold">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Aturan -->
<div id="modalEdit" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto">
        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white p-4 rounded-t-lg flex justify-between items-center sticky top-0">
            <h3 class="text-xl font-bold">Edit Aturan</h3>
            <button onclick="closeModalEdit()" class="text-white hover:text-gray-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form id="formEdit" method="post" class="p-6">
            <?= csrf_field() ?>
            
            <!-- Pilih Penyakit -->
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Penyakit *</label>
                <select name="id_penyakit" id="edit_penyakit" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    <option value="">-- Pilih Penyakit --</option>
                    <?php foreach ($penyakitList as $p): ?>
                        <option value="<?= $p['id'] ?>">
                            [<?= esc($p['kode_penyakit']) ?>] <?= esc($p['nama_penyakit']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Pilih Gejala -->
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Gejala *</label>
                <select name="id_gejala" id="edit_gejala" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    <option value="">-- Pilih Gejala --</option>
                    <?php foreach ($gejalaList as $g): ?>
                        <option value="<?= $g['id'] ?>">
                            [<?= esc($g['kode_gejala']) ?>] <?= esc($g['nama_gejala']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- CF Pakar Slider -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">CF Pakar *</label>
                <div class="bg-gray-50 border border-gray-300 rounded-lg p-4">
                    <div class="text-center mb-3">
                        <span class="text-4xl font-bold text-yellow-600" id="edit_cf_display">0.70</span>
                    </div>
                    <input type="range" name="cf_pakar" id="edit_cf_slider" 
                           min="0.01" max="1.00" step="0.01" value="0.70"
                           class="w-full h-3 bg-gray-200 rounded-lg appearance-none cursor-pointer slider-yellow"
                           oninput="updateEditCF()">
                    <div class="flex justify-between text-xs text-gray-600 mt-2">
                        <span>0.01</span>
                        <span>0.50</span>
                        <span>1.00</span>
                    </div>
                    <div class="mt-3 grid grid-cols-3 gap-2 text-xs text-center">
                        <div class="bg-yellow-100 p-2 rounded">0.01-0.49 Jarang</div>
                        <div class="bg-blue-100 p-2 rounded">0.50-0.79 Sering</div>
                        <div class="bg-green-100 p-2 rounded">0.80-1.00 Sangat Khas</div>
                    </div>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-yellow-500 text-white py-2 rounded-lg hover:bg-yellow-600 transition font-semibold">
                    Update
                </button>
                <button type="button" onclick="closeModalEdit()" class="flex-1 bg-gray-300 text-gray-700 py-2 rounded-lg hover:bg-gray-400 transition font-semibold">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<style>
/* Slider Teal */
input[type="range"].slider-teal::-webkit-slider-thumb {
    appearance: none;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #0d9488;
    cursor: pointer;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}
input[type="range"].slider-teal::-moz-range-thumb {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #0d9488;
    cursor: pointer;
}

/* Slider Yellow */
input[type="range"].slider-yellow::-webkit-slider-thumb {
    appearance: none;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #eab308;
    cursor: pointer;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}
input[type="range"].slider-yellow::-moz-range-thumb {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #eab308;
    cursor: pointer;
}
</style>


<!-- Modal Konfirmasi Hapus -->
<div id="modalHapus" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-sm mx-4 transform transition-all">
        <div class="p-6 text-center">
            <div class="bg-red-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Hapus Aturan?</h3>
            <p id="hapus_deskripsi" class="text-gray-600 mb-6"></p>
            <div class="flex gap-3">
                <button onclick="closeModalHapus()" class="flex-1 bg-gray-300 text-gray-700 py-2 rounded-lg hover:bg-gray-400 transition font-semibold">
                    Batal
                </button>
                <a id="hapus_link" href="#" class="flex-1 bg-red-500 text-white py-2 rounded-lg hover:bg-red-600 transition font-semibold text-center">
                    Ya, Hapus
                </a>
            </div>
        </div>
    </div>
</div>

<script>
// Modal Tambah
function openModalTambah() {
    document.getElementById('modalTambah').classList.remove('hidden');
}

function closeModalTambah() {
    document.getElementById('modalTambah').classList.add('hidden');
}

function updateTambahCF() {
    const slider = document.getElementById('tambah_cf_slider');
    const display = document.getElementById('tambah_cf_display');
    display.textContent = parseFloat(slider.value).toFixed(2);
}

// Modal Edit
function openModalEdit(aturan) {
    document.getElementById('edit_penyakit').value = aturan.id_penyakit;
    document.getElementById('edit_gejala').value = aturan.id_gejala;
    document.getElementById('edit_cf_slider').value = aturan.cf_pakar;
    document.getElementById('edit_cf_display').textContent = parseFloat(aturan.cf_pakar).toFixed(2);
    document.getElementById('formEdit').action = '/admin/aturan/update/' + aturan.id;
    document.getElementById('modalEdit').classList.remove('hidden');
}

function closeModalEdit() {
    document.getElementById('modalEdit').classList.add('hidden');
}

function updateEditCF() {
    const slider = document.getElementById('edit_cf_slider');
    const display = document.getElementById('edit_cf_display');
    display.textContent = parseFloat(slider.value).toFixed(2);
}

// Delete
function confirmDelete(id, penyakit, gejala) {
    document.getElementById('hapus_deskripsi').innerHTML = `Apakah Anda yakin ingin menghapus aturan:<br><strong>${penyakit} → ${gejala}</strong>?`;
    document.getElementById('hapus_link').href = '/admin/aturan/delete/' + id;
    document.getElementById('modalHapus').classList.remove('hidden');
}

function closeModalHapus() {
    document.getElementById('modalHapus').classList.add('hidden');
}

// Search & Filter
document.getElementById('searchAturan')?.addEventListener('input', filterTable);
document.getElementById('filterCF')?.addEventListener('change', filterTable);

function filterTable() {
    const search = document.getElementById('searchAturan').value.toLowerCase();
    const cfFilter = document.getElementById('filterCF').value;
    const rows = document.querySelectorAll('.aturan-row');
    
    rows.forEach(row => {
        const penyakit = row.dataset.penyakit;
        const gejala = row.dataset.gejala;
        const cfLevel = row.dataset.cfLevel;
        
        const matchSearch = penyakit.includes(search) || gejala.includes(search);
        const matchCF = !cfFilter || cfLevel === cfFilter;
        
        row.style.display = matchSearch && matchCF ? '' : 'none';
    });
}

// Close on ESC
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        closeModalTambah();
        closeModalEdit();
        closeModalHapus();
    }
});

// Close when clicking outside
document.getElementById('modalTambah')?.addEventListener('click', (e) => {
    if (e.target === e.currentTarget) closeModalTambah();
});
document.getElementById('modalEdit')?.addEventListener('click', (e) => {
    if (e.target === e.currentTarget) closeModalEdit();
});
document.getElementById('modalHapus')?.addEventListener('click', (e) => {
    if (e.target === e.currentTarget) closeModalHapus();
});
</script>

<?= $this->endSection() ?>