<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-teal-700 mb-1"><?= $title ?></h1>
        </div>
        <a href="/penjualan" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition shadow-md flex items-center gap-2 text-sm">
            Penjualan
        </a>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 p-4">
        <!-- ===================== KIRI: RINGKASAN TOTAL ===================== -->
        <div class="bg-white border border-green-500 rounded-xl p-4 flex flex-col justify-between shadow-sm">
            <div class="space-y-3 overflow-y-auto h-[60vh] pr-2">
                <?php if (!empty($cart)): ?>
                    <?php foreach ($cart as $item): ?>
                        <div class="border rounded-lg p-3 flex justify-between items-center hover:shadow-md transition cart-item" data-id="<?= $item['id_obat'] ?>">
                            <div>
                                <div class="text-gray-800 font-semibold"><?= esc($item['nama_obat']) ?></div>
                                <div class="text-sm text-gray-500">
                                    Rp <?= number_format($item['harga_jual'], 0, ',', '.') ?> × 
                                    <span class="jumlah-text"><?= $item['jumlah'] ?></span>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="font-bold text-green-700 subtotal-text">
                                    Rp <?= number_format($item['subtotal'], 0, ',', '.') ?>
                                </div>
                                <div class="flex justify-end items-center gap-2 mt-2">
                                    <button type="button" class="bg-gray-200 hover:bg-gray-300 px-2 rounded text-sm btn-minus" data-id="<?= $item['id_obat'] ?>">-</button>
                                    <span id="jumlah-<?= $item['id_obat'] ?>" class="font-semibold"><?= $item['jumlah'] ?></span>
                                    <button type="button" class="bg-gray-200 hover:bg-gray-300 px-2 rounded text-sm btn-plus" data-id="<?= $item['id_obat'] ?>">+</button>
                                    <a href="/transaksi/remove/<?= $item['id_obat'] ?>" class="text-red-500 hover:text-red-700" onclick="return confirm('Hapus item ini?')">🗑️</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center text-gray-400 py-8">🛒 Keranjang masih kosong</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- ===================== KANAN: FORM PEMBAYARAN ===================== -->
        <div class="bg-white border border-green-500 rounded-xl p-4 shadow-sm flex flex-col justify-between">
            <form action="/transaksi/proses" method="post" id="formBayar" class="flex flex-col gap-3">
                <?= csrf_field() ?>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Bayar</label>
                    <input id="bayar-display" type="text" 
                        class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-green-500"
                        placeholder="Isi nominal uang pelanggan"
                        autocomplete="off">
                    <!-- Hidden input untuk nilai sebenarnya tanpa format -->
                    <input type="hidden" id="bayar-real" name="bayar" value="">
                </div>

                <div class="space-y-3">
                    <div class="flex justify-between items-center border-t pt-3">
                        <span class="font-semibold text-gray-700 total-qty">
                            Total <?= $total_qty ?> Qty
                        </span>
                        <span class="text-red-600 font-bold text-lg total-text" data-total="<?= $total ?>">
                            Rp <?= number_format($total, 0, ',', '.') ?>
                        </span>
                    </div>
                </div>

                <!-- Kembalian Display -->
                <div class="text-black rounded-lg p-5 mb-4 text-center bg-cyan-50 border border-cyan-300">
                    <span class="text-lg font-semibold block text-gray-700 mb-1">KEMBALIAN</span>
                    <div class="text-3xl font-bold text-green-700 kembali-total">Rp 0</div>
                </div>

                <div class="flex justify-between items-center pt-4">
                    <button type="submit" id="btnBayar"
                        class="bg-teal-600 text-white px-4 py-2 rounded hover:bg-teal-700 mb-4 inline-block w-full font-semibold">
                        BAYAR
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ===================== SCRIPT UNIFIED ===================== -->
<script>
document.addEventListener("DOMContentLoaded", () => {
    // ============ UPDATE QUANTITY ============
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
                    
                    // Update total
                    const totalEl = document.querySelector('.total-text');
                    totalEl.textContent = 'Rp ' + data.total;
                    totalEl.dataset.total = data.total.replace(/\./g, ''); // simpan nilai numerik
                    
                    // Recalculate kembalian
                    hitungKembalian();
                }
            })
            .catch(err => console.error('Error updating quantity:', err));
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

    // ============ INPUT BAYAR & KEMBALIAN ============
    const inputBayarDisplay = document.getElementById('bayar-display');
    const inputBayarReal = document.getElementById('bayar-real');
    const kembaliDisplay = document.querySelector('.kembali-total');
    const totalEl = document.querySelector('.total-text');
    
    // Format rupiah
    function formatRupiah(angka) {
        return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    // Parse rupiah ke number
    function parseRupiah(str) {
        return parseFloat(str.replace(/\./g, "").replace(/,/g, "")) || 0;
    }

    // Hitung kembalian
    function hitungKembalian() {
        const totalHarga = parseFloat(totalEl.dataset.total) || 0;
        const bayar = parseRupiah(inputBayarDisplay.value);
        const kembalian = bayar - totalHarga;
        const hasil = kembalian > 0 ? kembalian : 0;

        kembaliDisplay.textContent = 'Rp ' + hasil.toLocaleString('id-ID');
        inputBayarReal.value = bayar; // simpan nilai asli tanpa format
    }

    // Event input bayar
    if (inputBayarDisplay) {
        inputBayarDisplay.addEventListener('input', (e) => {
            let nilai = e.target.value.replace(/\D/g, ""); // hanya angka
            e.target.value = formatRupiah(nilai);
            hitungKembalian();
        });
    }

    // ============ FORM VALIDATION ============
    const formBayar = document.getElementById('formBayar');
    if (formBayar) {
        formBayar.addEventListener('submit', (e) => {
            const bayar = parseFloat(inputBayarReal.value) || 0;
            const total = parseFloat(totalEl.dataset.total) || 0;

            if (bayar <= 0) {
                e.preventDefault();
                alert('Harap isi jumlah bayar!');
                inputBayarDisplay.focus();
                return false;
            }

            if (bayar < total) {
                e.preventDefault();
                alert('Uang bayar kurang! Total: Rp ' + total.toLocaleString('id-ID'));
                inputBayarDisplay.focus();
                return false;
            }

            // Konfirmasi
            if (!confirm('Proses transaksi dengan total Rp ' + total.toLocaleString('id-ID') + '?')) {
                e.preventDefault();
                return false;
            }
        });
    }
});
</script>

<?= $this->endSection() ?>