<header class="bg-gray-900 shadow-lg">
  <nav aria-label="Global" class="mx-auto flex max-w-7xl items-center justify-between p-6 lg:px-8">
    <div class="flex lg:flex-1">
      <a href="<?= base_url('/') ?>" class="-m-1.5 p-1.5 flex items-center gap-2">
        <div class="bg-teal-600 p-2 rounded-lg">
          <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
          </svg>
        </div>
        <span class="font-bold text-white text-lg">TASYA FARMA</span>
      </a>
    </div>

    <!-- Mobile Button -->
    <div class="flex lg:hidden">
      <button type="button" command="show-modal" commandfor="mobile-menu"
        class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-400">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="size-6">
          <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
      </button>
    </div>

    <!-- Desktop Menu -->
    <div class="hidden lg:flex lg:gap-x-8 text-white items-center">
      <a href="<?= base_url('/') ?>" class="hover:text-teal-400 transition font-medium">Dashboard</a>
      <a href="<?= base_url('transaksi') ?>" class="hover:text-teal-400 transition font-medium">Transaksi</a>
      <a href="<?= base_url('penjualan') ?>" class="hover:text-teal-400 transition font-medium">Penjualan</a>
      
      <!-- 🔴 Laporan & User - Hanya untuk Pemilik -->
      <?php if (session()->get('role') === 'pemilik'): ?>
        <a href="<?= base_url('laporan') ?>" class="hover:text-teal-400 transition font-medium">Laporan</a>
        <a href="<?= base_url('user') ?>" class="hover:text-teal-400 transition font-medium">User</a>
      <?php endif; ?>

      <!-- Dropdown Menu -->
      <div class="relative group">
        <button popovertarget="desktop-menu-product" class="flex items-center gap-x-1 text-sm/6 font-semibold text-white hover:text-teal-400 transition">
          Master Data
          <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="size-5 flex-none">
            <path d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" fill-rule="evenodd" />
          </svg>
        </button>

        <el-popover id="desktop-menu-product" anchor="bottom" popover class="w-screen max-w-xs overflow-hidden rounded-2xl bg-gray-800 shadow-2xl transition">
          <div class="p-2">
            <a href="<?= base_url('kategori') ?>" class="group relative flex items-center gap-x-4 rounded-xl p-3 text-sm hover:bg-gray-700 transition">
              <div class="flex size-10 flex-none items-center justify-center rounded-lg bg-gray-700 group-hover:bg-teal-600 transition">
                <svg class="size-5 text-gray-300 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
              </div>
              <div class="flex-auto">
                <span class="block font-semibold text-white">Kategori</span>
                <p class="mt-1 text-gray-400 text-xs">Kelola kategori obat</p>
              </div>
            </a>
          </div>

          <?php if (session()->get('role') === 'pemilik'): ?>
          <div class="p-2">
            <a href="<?= base_url('obat') ?>" class="group relative flex items-center gap-x-4 rounded-xl p-3 text-sm hover:bg-gray-700 transition">
              <div class="flex size-10 flex-none items-center justify-center rounded-lg bg-gray-700 group-hover:bg-teal-600 transition">
                <svg class="w-5 h-5 text-gray-300 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
              </div>
              <div class="flex-auto">
                <span class="block font-semibold text-white">Data Obat</span>
                <p class="mt-1 text-gray-400 text-xs">Kelola Data Obat</p>
              </div>
            </a>
          </div>
          <?php endif; ?>
        </el-popover>
      </div>

      <!-- User Info & Logout -->
      <div class="ml-4 flex items-center gap-3 border-l border-gray-700 pl-4">
        <div class="text-right">
          <p class="text-sm font-semibold text-white"><?= session()->get('nama_lengkap') ?></p>
          <p class="text-xs text-gray-400">
            <?= session()->get('role') === 'pemilik' ? '👑 Pemilik' : '👨‍💼 Kasir' ?>
          </p>
        </div>
        <a href="<?= base_url('auth/logout') ?>" 
           onclick="return confirm('Yakin ingin logout?')"
           class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-semibold text-sm transition flex items-center gap-2">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
          </svg>
          Logout
        </a>
      </div>
    </div>
  </nav>

  <!-- MOBILE MENU -->
  <el-dialog>
    <dialog id="mobile-menu" class="backdrop:bg-transparent lg:hidden">
      <div tabindex="0" class="fixed inset-0 focus:outline-none">
        <el-dialog-panel class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-gray-900 p-6 sm:max-w-sm border-l border-gray-800">

          <div class="flex items-center justify-between mb-6">
            <a href="<?= base_url('/') ?>" class="-m-1.5 p-1.5 flex items-center gap-2">
              <div class="bg-teal-600 p-2 rounded-lg">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
              </div>
              <span class="font-bold text-white">TASYA FARMA</span>
            </a>
            <button type="button" command="close" commandfor="mobile-menu" class="-m-2.5 rounded-md p-2.5 text-gray-400">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="size-6">
                <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
            </button>
          </div>

          <!-- User Info Mobile -->
          <div class="bg-gray-800 rounded-xl p-4 mb-6 border border-gray-700">
            <p class="text-white font-semibold"><?= session()->get('nama_lengkap') ?></p>
            <p class="text-sm text-gray-400 mt-1">
              <?= session()->get('role') === 'pemilik' ? '👑 Pemilik' : '👨‍💼 Kasir' ?>
            </p>
          </div>

          <div class="flow-root">
            <div class="-my-6 divide-y divide-gray-800">
              <div class="space-y-2 py-6">
                <a href="<?= base_url('/') ?>" class="block rounded-lg px-3 py-2 text-base font-semibold text-white hover:bg-gray-800">Dashboard</a>
                <a href="<?= base_url('obat') ?>" class="block rounded-lg px-3 py-2 text-base font-semibold text-white hover:bg-gray-800">Data Obat</a>
                <a href="<?= base_url('kategori') ?>" class="block rounded-lg px-3 py-2 text-base font-semibold text-white hover:bg-gray-800">Kategori</a>
                <a href="<?= base_url('transaksi') ?>" class="block rounded-lg px-3 py-2 text-base font-semibold text-white hover:bg-gray-800">Transaksi</a>
                <a href="<?= base_url('penjualan') ?>" class="block rounded-lg px-3 py-2 text-base font-semibold text-white hover:bg-gray-800">Penjualan</a>
                
                <?php if (session()->get('role') === 'pemilik'): ?>
                  <a href="<?= base_url('laporan') ?>" class="block rounded-lg px-3 py-2 text-base font-semibold text-white hover:bg-gray-800">Laporan</a>
                  <a href="<?= base_url('user') ?>" class="block rounded-lg px-3 py-2 text-base font-semibold text-white hover:bg-gray-800">🟢 User Management</a>
                <?php endif; ?>
              </div>
              
              <div class="py-6">
                <a href="<?= base_url('auth/logout') ?>" 
                   onclick="return confirm('Yakin ingin logout?')"
                   class="block rounded-lg px-3 py-2.5 text-base font-semibold bg-red-600 hover:bg-red-700 text-white text-center">
                  Logout
                </a>
              </div>
            </div>
          </div>

        </el-dialog-panel>
      </div>
    </dialog>
  </el-dialog>
</header>