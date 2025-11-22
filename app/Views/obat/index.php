<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="max-w-7xl mx-auto">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800"><?= $title ?></h1>
            <p class="text-sm text-gray-600 mt-1">Kelola data obat dan stok apotek</p>
        </div>
        <div class="flex gap-3">
            <button onclick="openModalTambah()" class="bg-teal-600 text-white px-4 py-2 rounded-lg hover:bg-teal-700 transition shadow-md flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Obat
            </button>
            <a href="/kategori" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition shadow-md flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
                Kategori
            </a>
        </div>
    </div>

    <!-- Filter & Search -->
    <div class="bg-white rounded-lg shadow-sm p-4 mb-5">
        <div class="flex gap-4 flex-wrap">
            <input type="text" id="searchObat" placeholder="🔍 Cari nama barang..." 
                   class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
            <select id="filterKategori" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                <option value="">Semua Kategori</option>
                <?php foreach($kategori as $k): ?>
                    <option value="<?= $k['nama_kategori'] ?>"><?= $k['nama_kategori'] ?></option>
                <?php endforeach; ?>
            </select>
            <select id="filterKadaluarsa" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                <option value="">Semua Status</option>
                <option value="expired">Sudah Kadaluarsa</option>
                <option value="soon">Akan Kadaluarsa (30 hari)</option>
                <option value="safe">Aman</option>
            </select>
        </div>
    </div>

    <!-- 🔴 Legend -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-5">
        <h4 class="font-semibold text-blue-800 mb-2">🔖 Keterangan Status:</h4>
        <div class="flex flex-wrap gap-4 text-sm">
            <div class="flex items-center gap-2">
                <span class="w-4 h-4 bg-red-600 rounded"></span>
                <span class="text-gray-700">Sudah Kadaluarsa</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-4 h-4 bg-orange-500 rounded"></span>
                <span class="text-gray-700">Akan Kadaluarsa (&lt; 30 hari)</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-4 h-4 bg-yellow-500 rounded"></span>
                <span class="text-gray-700">Perhatian (&lt; 60 hari)</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-4 h-4 bg-green-500 rounded"></span>
                <span class="text-gray-700">Aman</span>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gradient-to-r from-teal-600 to-teal-700 text-white">
                <tr>
                    <th class="py-3 px-4 text-left">Nama Barang</th>
                    <th class="py-3 px-4 text-left">Merk</th>
                    <th class="py-3 px-4 text-left">Kategori</th>
                    <th class="py-3 px-4 text-right">Harga Beli</th>
                    <th class="py-3 px-4 text-right">Harga Jual</th>
                    <th class="py-3 px-4 text-center">Stok</th>
                    <th class="py-3 px-4 text-center">Kadaluarsa</th>
                    <th class="py-3 px-4 text-center">Status</th>
                    <th class="py-3 px-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                <?php 
                $today = time();
                foreach($obat as $o): 
                    $tglED = strtotime($o['tanggal_kadaluarsa']);
                    $diffDays = ceil(($tglED - $today) / (60 * 60 * 24));
                    
                    // Tentukan status kadaluarsa
                    if ($diffDays < 0) {
                        $statusClass = 'bg-red-600 text-white';
                        $statusText = 'KADALUARSA';
                        $statusFilter = 'expired';
                    } elseif ($diffDays <= 30) {
                        $statusClass = 'bg-orange-500 text-white';
                        $statusText = $diffDays . ' hari lagi';
                        $statusFilter = 'soon';
                    } elseif ($diffDays <= 60) {
                        $statusClass = 'bg-yellow-500 text-white';
                        $statusText = $diffDays . ' hari lagi';
                        $statusFilter = 'safe';
                    } else {
                        $statusClass = 'bg-green-500 text-white';
                        $statusText = 'Aman';
                        $statusFilter = 'safe';
                    }
                ?>
                <tr class="border-b hover:bg-gray-50 transition obat-row" 
                    data-nama="<?= strtolower($o['nama_obat']) ?>"
                    data-kategori="<?= $o['nama_kategori'] ?: '' ?>"
                    data-status="<?= $statusFilter ?>">
                    <td class="py-3 px-4">
                        <div class="font-semibold text-gray-800"><?= esc($o['nama_obat']) ?></div>
                    </td>
                    <td class="py-3 px-4">
                        <div class="font-semibold text-gray-800"><?= esc($o['merk']) ?></div>
                    </td>
                    <td class="py-3 px-4">
                        <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm">
                            <?= esc($o['nama_kategori'] ?: 'Tidak ada') ?>
                        </span>
                    </td>
                    <td class="py-3 px-4 text-right text-gray-700">
                        Rp <?= number_format($o['harga_beli'], 0, ',', '.') ?>
                    </td>
                    <td class="py-3 px-4 text-right font-semibold text-green-700">
                        Rp <?= number_format($o['harga_jual'], 0, ',', '.') ?>
                    </td>
                    <td class="py-3 px-4 text-center">
                        <span class="<?= $o['stok'] < 10 ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' ?> px-3 py-1 rounded-full font-semibold">
                            <?= $o['stok'] ?>
                        </span>
                    </td>
                    <td class="py-3 px-4 text-center text-sm">
                        <div class="<?= $diffDays < 0 ? 'text-red-700 font-bold' : 'text-gray-600' ?>">
                            <?= date('d M Y', strtotime($o['tanggal_kadaluarsa'])) ?>
                        </div>
                    </td>
                    <td class="py-3 px-4 text-center">
                        <span class="<?= $statusClass ?> px-3 py-1 rounded-full text-xs font-bold">
                            <?= $statusText ?>
                        </span>
                    </td>
                    <td class="py-3 px-4 text-center">
                        <div class="flex gap-2 justify-center">
                            <button onclick='openModalEdit(<?= json_encode($o) ?>)' 
                                    class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 transition text-sm">
                                Edit
                            </button>
                            <button onclick="confirmDelete(<?= $o['id_obat'] ?>, '<?= esc($o['nama_obat']) ?>')" 
                                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition text-sm">
                                Hapus
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah & Edit (sama seperti sebelumnya) -->
<!-- ... (gunakan modal yang sudah ada) ... -->

<script>
// Modal Functions (sama seperti sebelumnya)
function openModalTambah() {
    document.getElementById('modalTambah').classList.remove('hidden');
}

function closeModalTambah() {
    document.getElementById('modalTambah').classList.add('hidden');
}

function openModalEdit(obat) {
    document.getElementById('edit_nama_obat').value = obat.nama_obat;
    document.getElementById('edit_merk').value = obat.merk;
    document.getElementById('edit_category_id').value = obat.category_id;
    document.getElementById('edit_harga_beli').value = obat.harga_beli;
    document.getElementById('edit_harga_jual').value = obat.harga_jual;
    document.getElementById('edit_stok').value = obat.stok;
    document.getElementById('edit_tanggal_kadaluarsa').value = obat.tanggal_kadaluarsa;
    document.getElementById('formEdit').action = '/obat/update/' + obat.id_obat;
    document.getElementById('modalEdit').classList.remove('hidden');
}

function closeModalEdit() {
    document.getElementById('modalEdit').classList.add('hidden');
}

function confirmDelete(id, nama) {
    if (confirm(`Apakah Anda yakin ingin menghapus obat "${nama}"?`)) {
        window.location.href = '/obat/delete/' + id;
    }
}

// Search & Filter dengan Status Kadaluarsa
document.getElementById('searchObat')?.addEventListener('input', filterTable);
document.getElementById('filterKategori')?.addEventListener('change', filterTable);
document.getElementById('filterKadaluarsa')?.addEventListener('change', filterTable);

function filterTable() {
    const search = document.getElementById('searchObat').value.toLowerCase();
    const kategori = document.getElementById('filterKategori').value.toLowerCase();
    const status = document.getElementById('filterKadaluarsa').value;
    const rows = document.querySelectorAll('.obat-row');
    
    rows.forEach(row => {
        const nama = row.dataset.nama;
        const kat = row.dataset.kategori.toLowerCase();
        const rowStatus = row.dataset.status;
        
        const matchSearch = nama.includes(search);
        const matchKategori = !kategori || kat.includes(kategori);
        const matchStatus = !status || rowStatus === status;
        
        row.style.display = matchSearch && matchKategori && matchStatus ? '' : 'none';
    });
}

// Close modal on ESC key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        closeModalTambah();
        closeModalEdit();
    }
});
</script>

<?= $this->endSection() ?>