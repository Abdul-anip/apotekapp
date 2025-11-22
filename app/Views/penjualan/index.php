<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-teal-700 mb-1"><?= $title ?></h1>
            <p class="text-sm text-gray-600">Pilih obat untuk ditambahkan ke keranjang</p>
        </div>
        <a href="/transaksi" class="bg-green-600 text-white px-5 py-2.5 rounded-lg hover:bg-green-700 transition shadow-md flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            Keranjang
            <?php if(!empty($cart)): ?>
                <span class="bg-red-500 text-white px-2 py-1 rounded-full text-xs font-bold">
                    <?= count($cart) ?>
                </span>
            <?php endif; ?>
        </a>
    </div>

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <!-- Search Bar -->
    <div class="bg-white rounded-lg shadow-sm p-4 mb-5">
        <input type="text" id="searchObat" placeholder="🔍 Cari obat..." 
               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
    </div>

    <!-- Grid Obat -->
    <?php if(empty($obat)): ?>
        <div class="text-center py-12 bg-white rounded-lg shadow">
            <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
            </svg>
            <h3 class="text-lg font-semibold text-gray-600 mb-1">Tidak ada obat tersedia</h3>
            <p class="text-sm text-gray-500">Silakan tambahkan obat terlebih dahulu</p>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
            <?php foreach($obat as $o): ?>
            <div class="bg-white rounded-lg shadow hover:shadow-xl transform transition-all duration-300 hover:-translate-y-2 group border border-gray-100 obat-card" 
                 data-nama="<?= strtolower($o['nama_obat']) ?>">
                
                <!-- Badge Stok -->
                <?php if($o['stok'] < 10): ?>
                    <div class="absolute top-2 right-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full font-bold z-10">
                        Stok Rendah!
                    </div>
                <?php endif; ?>

                <!-- Card Content -->
                <div class="p-4">
                    <!-- Nama Obat -->
                    <h2 class="text-sm font-bold text-gray-800 mb-2 line-clamp-2 h-10">
                        <?= esc($o['nama_obat']) ?>
                    </h2>
                    
                    <!-- Stok Badge -->
                    <div class="flex items-center justify-between mb-2 pb-2 border-b border-gray-100">
                        <span class="text-xs text-gray-500">Stok:</span>
                        <span class="<?= $o['stok'] < 10 ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' ?> px-2 py-0.5 rounded-full text-xs font-semibold">
                            <?= $o['stok'] ?>
                        </span>
                    </div>
                    
                    <!-- Harga -->
                    <div class="mb-3">
                        <span class="text-xl font-bold text-teal-700 block">
                            Rp <?= number_format($o['harga_jual'], 0, ',', '.') ?>
                        </span>
                    </div>
                    
                    <!-- Button Tambah -->
                    <?php if($o['stok'] > 0): ?>
                        <button onclick="tambahKeKeranjang(<?= $o['id_obat'] ?>, '<?= esc($o['nama_obat']) ?>')"
                                class="w-full bg-teal-600 text-white px-3 py-2 rounded-lg hover:bg-teal-700 transition-colors text-sm font-medium flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Tambah
                        </button>
                    <?php else: ?>
                        <button disabled class="w-full bg-gray-300 text-gray-600 px-3 py-2 rounded-lg text-sm font-medium cursor-not-allowed">
                            Stok Habis
                        </button>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<script>
// Fungsi Tambah ke Keranjang dengan Konfirmasi
function tambahKeKeranjang(id, nama) {
    if (confirm(`Tambahkan "${nama}" ke keranjang?`)) {
        window.location.href = '/penjualan/add/' + id;
    }
}

// Search Obat
document.getElementById('searchObat')?.addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const cards = document.querySelectorAll('.obat-card');
    
    cards.forEach(card => {
        const nama = card.dataset.nama;
        card.style.display = nama.includes(searchTerm) ? 'block' : 'none';
    });
});
</script>

<?= $this->endSection() ?>