<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-teal-700 mb-1"><?= $title ?></h1>
            <p class="text-sm text-gray-600">Review dan proses pembayaran</p>
        </div>
        <a href="/penjualan" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition shadow-md flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali Belanja
        </a>
    </div>

    <!-- Toast Notification -->
    <?php if (session()->getFlashdata('error')): ?>
        <div id="toast-error" class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-4 flex items-start animate-slide-in">
            <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            <div class="flex-1">
                <strong class="font-bold">Error!</strong>
                <p class="text-sm"><?= session()->getFlashdata('error') ?></p>
            </div>
            <button onclick="this.parentElement.remove()" class="ml-4">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
            </button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
        <div id="toast-success" class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-4 flex items-start animate-slide-in">
            <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <div class="flex-1">
                <strong class="font-bold">Berhasil!</strong>
                <p class="text-sm"><?= session()->getFlashdata('success') ?></p>
            </div>
            <button onclick="this.parentElement.remove()" class="ml-4">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
            </button>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- KIRI: Detail Keranjang -->
        <div class="bg-white border-2 border-teal-500 rounded-xl p-5 shadow-lg">
            <div class="flex items-center justify-between mb-4 pb-3 border-b-2 border-teal-500">
                <h2 class="text-xl font-bold text-gray-800">Keranjang Belanja</h2>
                <span class="bg-teal-100 text-teal-700 px-3 py-1 rounded-full text-sm font-bold">
                    <?= count($cart) ?> Item
                </span>
            </div>

            <div class="space-y-3 overflow-y-auto max-h-[60vh] pr-2">
                <?php if (!empty($cart)): ?>
                    <?php foreach ($cart as $item): ?>
                        <div class="border-2 border-gray-200 rounded-lg p-4 hover:shadow-md hover:border-teal-300 transition cart-item" data-id="<?= $item['id_obat'] ?>">
                            <div class="flex justify-between items-start mb-3">
                                <div class="flex-1">
                                    <h3 class="font-bold text-gray-800"><?= esc($item['nama_obat']) ?></h3>
                                    <p class="text-sm text-gray-500">
                                        Rp <?= number_format($item['harga_jual'], 0, ',', '.') ?> × 
                                        <span class="jumlah-text font-semibold"><?= $item['jumlah'] ?></span>
                                    </p>
                                </div>
                                <button onclick="confirmRemove(<?= $item['id_obat'] ?>, '<?= esc($item['nama_obat']) ?>')" 
                                        class="text-red-500 hover:text-red-700 ml-2">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <button type="button" class="bg-gray-200 hover:bg-gray-300 px-3 py-1 rounded font-bold btn-minus" data-id="<?= $item['id_obat'] ?>">−</button>
                                    <span id="jumlah-<?= $item['id_obat'] ?>" class="font-bold text-lg w-10 text-center"><?= $item['jumlah'] ?></span>
                                    <button type="button" class="bg-gray-200 hover:bg-gray-300 px-3 py-1 rounded font-bold btn-plus" data-id="<?= $item['id_obat'] ?>">+</button>
                                </div>
                                <div class="font-bold text-green-700 text-lg subtotal-text">
                                    Rp <?= number_format($item['subtotal'], 0, ',', '.') ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center py-12">
                        <svg class="w-20 h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <p class="text-gray-400 text-lg font-medium">Keranjang masih kosong</p>
                        <a href="/penjualan" class="inline-block mt-4 bg-teal-600 text-white px-6 py-2 rounded-lg hover:bg-teal-700 transition">
                            Mulai Belanja
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- KANAN: Form Pembayaran -->
        <div class="bg-white border-2 border-green-500 rounded-xl p-5 shadow-lg flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4 pb-3 border-b-2 border-green-500">
                    <h2 class="text-xl font-bold text-gray-800">Pembayaran</h2>
                    <span class="text-sm text-gray-500"><?= date('d M Y') ?></span>
                </div>

                <form action="/transaksi/proses" method="post" id="formBayar" class="space-y-4">
                    <?= csrf_field() ?>
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Jumlah Bayar *</label>
                        <div class="relative">
                            <span class="absolute left-3 top-3 text-gray-500 font-semibold">Rp</span>
                            <input id="bayar-display" type="text" 
                                   class="w-full pl-10 pr-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-green-500 text-lg font-semibold"
                                   placeholder="0" autocomplete="off" autofocus>
                            <input type="hidden" id="bayar-real" name="bayar" value="">
                        </div>
                    </div>

                    <!-- Summary -->
                    <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 font-medium">Total Item:</span>
                            <span class="font-bold text-gray-800 total-qty"><?= $total_qty ?> Item</span>
                        </div>
                        <div class="flex justify-between items-center border-t pt-3">
                            <span class="text-gray-700 font-bold text-lg">Total Belanja:</span>
                            <span class="text-red-600 font-bold text-2xl total-text" data-total="<?= $total ?>">
                                Rp <?= number_format($total, 0, ',', '.') ?>
                            </span>
                        </div>
                    </div>

                    <!-- Kembalian Display -->
                    <div class="bg-gradient-to-r from-cyan-50 to-blue-50 border-2 border-cyan-300 rounded-lg p-5 text-center">
                        <span class="text-sm font-semibold text-gray-700 block mb-1">KEMBALIAN</span>
                        <div class="text-4xl font-bold text-green-700 kembali-total">Rp 0</div>
                    </div>

                    <!-- Button Bayar -->
                    <button type="submit" id="btnBayar"
                            class="w-full bg-gradient-to-r from-green-600 to-green-700 text-white py-4 rounded-lg hover:from-green-700 hover:to-green-800 transition font-bold text-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        PROSES PEMBAYARAN
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes slide-in {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

.animate-slide-in {
    animation: slide-in 0.3s ease-out;
}
</style>

<script>
// Confirm Remove Item
function confirmRemove(id, nama) {
    if (confirm(`Hapus "${nama}" dari keranjang?`)) {
        window.location.href = '/transaksi/remove/' + id;
    }
}

// Update Quantity (sama seperti sebelumnya)
document.querySelectorAll('.cart-item').forEach(item => {
    const id = item.dataset.id;
    const minus = item.querySelector('.btn-minus');
    const plus = item.querySelector('.btn-plus');
    const jumlahEl = item.querySelector(`#jumlah-${id}`);
    const jumlahText = item.querySelector('.jumlah-text');
    const subtotalText = item.querySelector('.subtotal-text');

    const updateServer = (jumlah) => {
        fetch('/transaksi/updateQuantity', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `id_obat=${id}&jumlah=${jumlah}`
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                jumlahEl.textContent = jumlah;
                jumlahText.textContent = jumlah;
                subtotalText.textContent = 'Rp ' + data.subtotal;
                
                const totalEl = document.querySelector('.total-text');
                totalEl.textContent = 'Rp ' + data.total;
                totalEl.dataset.total = data.total.replace(/\./g, '');
                
                hitungKembalian();
            }
        })
        .catch(err => console.error('Error:', err));
    };

    plus?.addEventListener('click', () => {
        let jumlah = parseInt(jumlahEl.textContent);
        jumlah++;
        updateServer(jumlah);
    });

    minus?.addEventListener('click', () => {
        let jumlah = parseInt(jumlahEl.textContent);
        if (jumlah > 1) {
            jumlah--;
            updateServer(jumlah);
        }
    });
});

// Format Rupiah & Hitung Kembalian
const inputBayarDisplay = document.getElementById('bayar-display');
const inputBayarReal = document.getElementById('bayar-real');
const kembaliDisplay = document.querySelector('.kembali-total');
const totalEl = document.querySelector('.total-text');

function formatRupiah(angka) {
    return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function parseRupiah(str) {
    return parseFloat(str.replace(/\./g, "").replace(/,/g, "")) || 0;
}

function hitungKembalian() {
    const totalHarga = parseFloat(totalEl.dataset.total) || 0;
    const bayar = parseRupiah(inputBayarDisplay.value);
    const kembalian = bayar - totalHarga;
    const hasil = kembalian > 0 ? kembalian : 0;

    kembaliDisplay.textContent = 'Rp ' + hasil.toLocaleString('id-ID');
    inputBayarReal.value = bayar;
}

if (inputBayarDisplay) {
    inputBayarDisplay.addEventListener('input', (e) => {
        let nilai = e.target.value.replace(/\D/g, "");
        e.target.value = formatRupiah(nilai);
        hitungKembalian();
    });
}

// Form Validation
const formBayar = document.getElementById('formBayar');
if (formBayar) {
    formBayar.addEventListener('submit', (e) => {
        const bayar = parseFloat(inputBayarReal.value) || 0;
        const total = parseFloat(totalEl.dataset.total) || 0;

        if (bayar <= 0) {
            e.preventDefault();
            alert('❌ Harap isi jumlah bayar!');
            inputBayarDisplay.focus();
            return false;
        }

        if (bayar < total) {
            e.preventDefault();
            alert('❌ Uang bayar kurang!\nTotal: Rp ' + total.toLocaleString('id-ID') + '\nBayar: Rp ' + bayar.toLocaleString('id-ID'));
            inputBayarDisplay.focus();
            return false;
        }

        if (!confirm('✅ Proses transaksi dengan total Rp ' + total.toLocaleString('id-ID') + '?')) {
            e.preventDefault();
            return false;
        }
    });
}

// Auto-hide toast after 5 seconds
setTimeout(() => {
    document.getElementById('toast-error')?.remove();
    document.getElementById('toast-success')?.remove();
}, 5000);
</script>

<?= $this->endSection() ?>