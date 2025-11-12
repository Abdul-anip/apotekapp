<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="max-w-7xl mx-auto">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-teal-700 mb-1"><?= $title ?></h1>
            <p class="text-sm text-gray-600">Pilih obat yang ingin ditambahkan ke keranjang</p>
        </div>
        <a href="/transaksi" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition shadow-md flex items-center gap-2 text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            Keranjang
        </a>
    </div>

    <!-- Filter/Search Section -->
    <div class="bg-white rounded-lg shadow-sm p-3 mb-5">
        <input type="text" id="searchObat" placeholder="Cari obat..." 
               class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
    </div>

    <!-- Grid card obat - Lebih compact -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
        <?php foreach($obat as $o): ?>
        <div class="bg-white rounded-lg shadow hover:shadow-lg transition-all duration-300 overflow-hidden group border border-gray-100">
            <!-- Icon/Image Placeholder - Lebih kecil -->
            <div class="bg-gradient-to-br from-teal-500 to-teal-600 h-20 flex items-center justify-center group-hover:from-teal-600 group-hover:to-teal-700 transition-colors">
                
            </div>
            
            <!-- Card Content - Lebih compact -->
            <div class="p-3">
                <h2 class="text-sm font-bold text-gray-800 mb-2 line-clamp-2 h-10">
                    <?= $o['nama_obat'] ?>
                </h2>
                
                <!-- Stok -->
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs text-gray-500">Stok:</span>
                    <span class="<?= $o['stok'] < 10 ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' ?> px-2 py-0.5 rounded-full text-xs font-semibold">
                        <?= $o['stok'] ?>
                    </span>
                </div>
                
                <!-- Harga -->
                <div class="mb-3 pt-2 border-t border-gray-100">
                    <span class="text-lg font-bold text-teal-700 block">
                        Rp <?= number_format($o['harga_jual'], 0, ',', '.') ?>
                    </span>
                </div>
                
                <!-- Button - Lebih kecil -->
                <a href="/penjualan/add/<?= $o['id_obat'] ?>"
                   class="block w-full bg-teal-600 text-white text-center px-3 py-2 rounded-lg hover:bg-teal-700 transition-colors text-sm font-medium">
                    + Tambah
                </a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Empty State -->
    <?php if(empty($obat)): ?>
    <div class="text-center py-12">
        <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
        </svg>
        <h3 class="text-lg font-semibold text-gray-600 mb-1">Tidak ada obat tersedia</h3>
        <p class="text-sm text-gray-500">Silakan tambahkan obat terlebih dahulu</p>
    </div>
    <?php endif; ?>
</div>

<!-- Script untuk fitur search -->
<script>
document.getElementById('searchObat')?.addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const cards = document.querySelectorAll('.grid > div');
    
    cards.forEach(card => {
        const text = card.textContent.toLowerCase();
        card.style.display = text.includes(searchTerm) ? 'block' : 'none';
    });
});
</script>

<?= $this->endSection() ?>