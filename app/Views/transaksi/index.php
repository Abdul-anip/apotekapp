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
                                    <button class="bg-gray-200 hover:bg-gray-300 px-2 rounded text-sm btn-minus" data-id="<?= $item['id_obat'] ?>">-</button>
                                    <span id="jumlah-<?= $item['id_obat'] ?>" class="font-semibold"><?= $item['jumlah'] ?></span>
                                    <button class="bg-gray-200 hover:bg-gray-300 px-2 rounded text-sm btn-plus" data-id="<?= $item['id_obat'] ?>">+</button>
                                    <a href="/transaksi/remove/<?= $item['id_obat'] ?>" class="text-red-500 hover:text-red-700">🗑️</a>
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
        

        <form action="/transaksi/proses" method="post" class="flex flex-col gap-3">
            <div>
                <label class="block text-sm font-semibold text-gray-700">Bayar</label>
                <input id="bayar" name="bayar" type="text"
                    class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-green-500"
                    placeholder="Isi nominal uang pelanggan">
            </div>

            <div class="space-y-3">
                <div class="flex justify-between items-center border-t pt-3">
                    <span class="font-semibold text-gray-700 total-qty">
                        Total <?= $total_qty ?> Qty
                    </span>
                    <span class="text-red-600 font-bold text-lg total-text">
                        Rp <?= number_format($total, 0, ',', '.') ?>
                    </span>
                </div>
            </div>

            <!-- ===== Bagian bawah sekarang menampilkan KEMBALIAN ===== -->
            <div class="text-black rounded-lg p-5 mb-4 text-center bg-cyan-50 border border-cyan-300">
                <span class="text-lg font-semibold block text-gray-700 mb-1">KEMBALIAN</span>
                <div class="text-3xl font-bold text-green-700 kembali-total">Rp 0</div>
                <input type="hidden" name="kembali" id="kembali-input" value="0">
            </div>

            <div class="flex justify-between items-center pt-4">
                <button type="submit"
                    class="bg-teal-600 text-white px-4 py-2 rounded hover:bg-teal-700 mb-4 inline-block">
                    BAYAR
                </button>
            </div>
        </form>
    </div>



    </div>
</div>

<!-- ===================== SCRIPT AJAX ===================== -->
<script>
document.addEventListener("DOMContentLoaded", () => {
    const csrfToken = '<?= csrf_hash() ?>';

    document.querySelectorAll('.cart-item').forEach(item => {
        const id = item.dataset.id;
        const minus = item.querySelector('.btn-minus');
        const plus = item.querySelector('.btn-plus');
        const jumlahEl = item.querySelector(`#jumlah-${id}`); // span di tombol
        const jumlahText = item.querySelector('.jumlah-text'); // span di kiri
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
                    // Update semua tampilan yang relevan
                    jumlahEl.textContent = jumlah;
                    jumlahText.textContent = jumlah; // update di bagian kiri
                    subtotalText.textContent = 'Rp ' + data.subtotal.toLocaleString('id-ID');
                    document.querySelector('.total-text').textContent = 'Rp ' + data.total.toLocaleString('id-ID');
                    document.querySelector('.grand-total').textContent = 'Rp ' + data.total.toLocaleString('id-ID');
                    document.querySelector('.total-harga').textContent = 'Rp ' + data.total.toLocaleString('id-ID');
                }
            })
            .catch(err => console.error(err));
        };

        plus.addEventListener('click', () => {
            let jumlah = parseInt(jumlahEl.textContent);
            jumlah++;
            updateServer(jumlah);
        });

        minus.addEventListener('click', () => {
            let jumlah = parseInt(jumlahEl.textContent);
            if (jumlah > 1) {
                jumlah--;
                updateServer(jumlah);
            }
        });
    });
});
</script>


<script>
document.addEventListener("DOMContentLoaded", () => {
    const inputBayar = document.querySelector('input[name="bayar"]');
    const kembaliDisplay = document.querySelector('.kembali-total');
    const kembaliHidden = document.querySelector('#kembali-input');
    const totalHarga = <?= $total ?>;

    if (inputBayar) {
        inputBayar.addEventListener('input', () => {
            const bayar = parseFloat(inputBayar.value) || 0;
            const kembalian = bayar - totalHarga;
            const hasil = kembalian > 0 ? kembalian : 0;

            // update tampilan besar
            kembaliDisplay.textContent = 'Rp ' + hasil.toLocaleString('id-ID');
            // simpan ke input hidden (untuk dikirim ke server saat "Bayar")
            kembaliHidden.value = hasil;
        });
    }
});
</script>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const inputBayar = document.getElementById('bayar');
    const kembaliDisplay = document.querySelector('.kembali-total');
    const kembaliHidden = document.querySelector('#kembali-input');
    const totalHarga = <?= $total ?>; // total harga dari PHP

    // Fungsi bantu untuk format angka ke format ribuan (5.000)
    function formatRupiah(angka) {
        return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    // Fungsi bantu untuk hapus titik dari input
    function parseRupiah(str) {
        return parseFloat(str.replace(/\./g, "")) || 0;
    }

    inputBayar.addEventListener("input", (e) => {
        let nilai = e.target.value.replace(/\D/g, ""); // hanya angka
        e.target.value = formatRupiah(nilai); // tampilkan dengan titik

        const bayar = parseRupiah(e.target.value);
        const kembalian = bayar - totalHarga;
        const hasil = kembalian > 0 ? kembalian : 0;

        // tampilkan hasil kembalian
        kembaliDisplay.textContent = 'Rp ' + hasil.toLocaleString('id-ID');
        kembaliHidden.value = hasil;
    });
});
</script>






<?= $this->endSection() ?>
