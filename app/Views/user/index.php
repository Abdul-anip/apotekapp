<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="max-w-7xl mx-auto">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800"><?= $title ?></h1>
            <p class="text-sm text-gray-600 mt-1">Kelola akun pengguna sistem</p>
        </div>
        <button onclick="openModalTambah()" class="bg-teal-600 text-white px-4 py-2 rounded-lg hover:bg-teal-700 transition shadow-md flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah User
        </button>
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

    <!-- Search Bar -->
    <div class="bg-white rounded-lg shadow-sm p-4 mb-5">
        <input type="text" id="searchUser" placeholder="🔍 Cari username atau nama..." 
               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gradient-to-r from-teal-600 to-teal-700 text-white">
                <tr>
                    <th class="py-3 px-4 text-left w-16">No</th>
                    <th class="py-3 px-4 text-left">Username</th>
                    <th class="py-3 px-4 text-left">Nama Lengkap</th>
                    <th class="py-3 px-4 text-center">Role</th>
                    <th class="py-3 px-4 text-center">Status</th>
                    <th class="py-3 px-4 text-center w-64">Aksi</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                <?php if (empty($users)): ?>
                    <tr>
                        <td colspan="6" class="py-12 text-center">
                            <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <p class="text-gray-500">Belum ada user</p>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1; foreach($users as $u): ?>
                    <tr class="border-b hover:bg-gray-50 transition user-row" 
                        data-username="<?= strtolower($u['username']) ?>"
                        data-nama="<?= strtolower($u['nama_lengkap']) ?>">
                        <td class="py-3 px-4 text-gray-600"><?= $no++ ?></td>
                        <td class="py-3 px-4">
                            <span class="font-semibold text-gray-800"><?= esc($u['username']) ?></span>
                        </td>
                        <td class="py-3 px-4 text-gray-700">
                            <?= esc($u['nama_lengkap']) ?>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <?php if ($u['role'] === 'pemilik'): ?>
                                <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-sm font-semibold">
                                    👑 Pemilik
                                </span>
                            <?php else: ?>
                                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-semibold">
                                    👨‍💼 Kasir
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <?php if ($u['is_active']): ?>
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">
                                    ✓ Aktif
                                </span>
                            <?php else: ?>
                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-semibold">
                                    ✗ Nonaktif
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <div class="flex gap-2 justify-center">
                                <button onclick='openModalEdit(<?= json_encode($u) ?>)' 
                                        class="bg-yellow-500 text-white px-3 py-1.5 rounded-lg hover:bg-yellow-600 transition text-sm">
                                    Edit
                                </button>
                                
                                <?php if ($u['id'] != session()->get('user_id')): ?>
                                    <button onclick="toggleStatus(<?= $u['id'] ?>, '<?= esc($u['username']) ?>', <?= $u['is_active'] ?>)" 
                                            class="<?= $u['is_active'] ? 'bg-orange-500 hover:bg-orange-600' : 'bg-green-500 hover:bg-green-600' ?> text-white px-3 py-1.5 rounded-lg transition text-sm">
                                        <?= $u['is_active'] ? 'Nonaktifkan' : 'Aktifkan' ?>
                                    </button>
                                    
                                    <button onclick="confirmDelete(<?= $u['id'] ?>, '<?= esc($u['username']) ?>')" 
                                            class="bg-red-500 text-white px-3 py-1.5 rounded-lg hover:bg-red-600 transition text-sm">
                                        Hapus
                                    </button>
                                <?php else: ?>
                                    <span class="text-gray-400 text-xs italic px-3 py-1.5">Akun Anda</span>
                                <?php endif; ?>
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
                <h4 class="font-semibold text-blue-800">Informasi</h4>
                <ul class="text-sm text-blue-700 mt-2 space-y-1">
                    <li>• <strong>Pemilik:</strong> Memiliki akses penuh ke semua fitur sistem</li>
                    <li>• <strong>Kasir:</strong> Hanya dapat mengakses transaksi, penjualan, dan data obat</li>
                    <li>• Anda tidak dapat menghapus atau menonaktifkan akun sendiri</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah User -->
<div id="modalTambah" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4">
        <div class="bg-gradient-to-r from-teal-600 to-teal-700 text-white p-4 rounded-t-lg flex justify-between items-center">
            <h3 class="text-xl font-bold">Tambah User Baru</h3>
            <button onclick="closeModalTambah()" class="text-white hover:text-gray-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form action="/user/store" method="post" class="p-6">
            <?= csrf_field() ?>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Username *</label>
                    <input type="text" name="username" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Password *</label>
                    <input type="password" name="password" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap *</label>
                    <input type="text" name="nama_lengkap" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Role *</label>
                    <select name="role" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                        <option value="">-- Pilih Role --</option>
                        <option value="pemilik">Pemilik</option>
                        <option value="kasir">Kasir</option>
                    </select>
                </div>
            </div>
            <div class="flex gap-3 mt-6">
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

<!-- Modal Edit User -->
<div id="modalEdit" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4">
        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white p-4 rounded-t-lg flex justify-between items-center">
            <h3 class="text-xl font-bold">Edit User</h3>
            <button onclick="closeModalEdit()" class="text-white hover:text-gray-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form id="formEdit" method="post" class="p-6">
            <?= csrf_field() ?>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Username *</label>
                    <input type="text" name="username" id="edit_username" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Password Baru</label>
                    <input type="password" name="password" id="edit_password" placeholder="Kosongkan jika tidak ingin mengubah"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    <p class="text-xs text-gray-500 mt-1">*Kosongkan jika tidak ingin mengubah password</p>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap *</label>
                    <input type="text" name="nama_lengkap" id="edit_nama_lengkap" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Role *</label>
                    <select name="role" id="edit_role" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                        <option value="pemilik">Pemilik</option>
                        <option value="kasir">Kasir</option>
                    </select>
                </div>
                <div>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="is_active" id="edit_is_active" class="w-4 h-4 text-teal-600">
                        <span class="text-sm font-semibold text-gray-700">Aktif</span>
                    </label>
                </div>
            </div>
            <div class="flex gap-3 mt-6">
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

<!-- Modal Konfirmasi Hapus -->
<div id="modalHapus" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-sm mx-4 transform transition-all">
        <div class="p-6 text-center">
            <div class="bg-red-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Hapus User?</h3>
            <p class="text-gray-600 mb-6">Apakah Anda yakin ingin menghapus user "<span id="hapus_nama" class="font-semibold text-red-600"></span>"?</p>
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

// Modal Edit
function openModalEdit(user) {
    document.getElementById('edit_username').value = user.username;
    document.getElementById('edit_password').value = '';
    document.getElementById('edit_nama_lengkap').value = user.nama_lengkap;
    document.getElementById('edit_role').value = user.role;
    document.getElementById('edit_is_active').checked = user.is_active == 1;
    document.getElementById('formEdit').action = '/user/update/' + user.id;
    document.getElementById('modalEdit').classList.remove('hidden');
}

function closeModalEdit() {
    document.getElementById('modalEdit').classList.add('hidden');
}

// Toggle Status
function toggleStatus(id, username, isActive) {
    const action = isActive ? 'menonaktifkan' : 'mengaktifkan';
    if (confirm(`Apakah Anda yakin ingin ${action} user "${username}"?`)) {
        window.location.href = '/user/toggleStatus/' + id;
    }
}

// Delete
function confirmDelete(id, username) {
    document.getElementById('hapus_nama').textContent = username;
    document.getElementById('hapus_link').href = '/user/delete/' + id;
    document.getElementById('modalHapus').classList.remove('hidden');
}

function closeModalHapus() {
    document.getElementById('modalHapus').classList.add('hidden');
}

// Search
document.getElementById('searchUser')?.addEventListener('input', function(e) {
    const search = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('.user-row');
    
    rows.forEach(row => {
        const username = row.dataset.username;
        const nama = row.dataset.nama;
        row.style.display = (username.includes(search) || nama.includes(search)) ? '' : 'none';
    });
});

// Close modal on ESC
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        closeModalTambah();
        closeModalEdit();
        closeModalHapus();
    }
});

// Close modal when clicking outside
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