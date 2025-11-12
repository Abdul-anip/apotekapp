<header class="bg-gray-900">
  <nav aria-label="Global" class="mx-auto flex max-w-7xl items-center justify-between p-6 lg:px-8">
    <div class="flex lg:flex-1">
      <a href="<?= base_url('/') ?>" class="-m-1.5 p-1.5 flex items-center gap-2">
        <span class="font-bold text-white">TASYA FARMA</span>
      </a>
    </div>

    <!-- Mobile Button -->
    <div class="flex lg:hidden">
      <button type="button" command="show-modal" commandfor="mobile-menu"
        class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-400">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
          class="size-6">
          <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" stroke-linecap="round"
            stroke-linejoin="round" />
        </svg>
      </button>
    </div>

    <!-- Desktop Menu -->
    <div class="hidden lg:flex lg:gap-x-12 text-white">
      <a href="<?= base_url('/') ?>">Dashboard</a>
      <a href="<?= base_url('obat') ?>">Data Obat</a>
      <a href="<?= base_url('transaksi') ?>">Transaksi</a>
      <a href="<?= base_url('penjualan') ?>">Penjualan</a>
      <a href="<?= base_url('laporan') ?>">Laporan</a>

      <el-popover-group class="hidden lg:flex lg:gap-x-12">
      <div class="relative">
        <button popovertarget="desktop-menu-product" class="flex items-center gap-x-1 text-sm/6 font-semibold text-white">
          Product
          <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="size-5 flex-none text-gray-500">
            <path d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" fill-rule="evenodd" />
          </svg>
        </button>

        <el-popover id="desktop-menu-product" anchor="bottom" popover class="w-screen max-w-md overflow-hidden rounded-3xl bg-gray-800 outline-1 -outline-offset-1 outline-white/10 transition transition-discrete [--anchor-gap:--spacing(3)] backdrop:bg-transparent open:block data-closed:translate-y-1 data-closed:opacity-0 data-enter:duration-200 data-enter:ease-out data-leave:duration-150 data-leave:ease-in">
          <div class="p-4">
            <div class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm/6 hover:bg-white/5">
              <div class="flex size-11 flex-none items-center justify-center rounded-lg bg-gray-700/50 group-hover:bg-gray-700">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6 text-gray-400 group-hover:text-white">
                  <path d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </div>
              <div class="flex-auto">
                <a href="#" class="block font-semibold text-white">
                  Kategori
                  <span class="absolute inset-0"></span>
                </a>
                <p class="mt-1 text-gray-400">Build strategic funnels that will convert</p>
              </div>
            </div>
          </div>
        </el-popover>

    </div>
  </nav>

  <!-- MOBILE MENU -->
  <el-dialog>
    <dialog id="mobile-menu" class="backdrop:bg-transparent lg:hidden">
      <div tabindex="0" class="fixed inset-0 focus:outline-none">
        <el-dialog-panel
          class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-gray-900 p-6 sm:max-w-sm sm:ring-1 sm:ring-gray-100/10">

          <div class="flex items-center justify-between">
            <a href="<?= base_url('/') ?>" class="-m-1.5 p-1.5 flex items-center gap-2">
              <img src="https://cdn-icons-png.flaticon.com/512/3004/3004036.png" class="h-8 w-auto" />
              <span class="font-bold text-white">ApotekApp</span>
            </a>
            <button type="button" command="close" commandfor="mobile-menu"
              class="-m-2.5 rounded-md p-2.5 text-gray-400">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="1.5" class="size-6">
                <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round"
                  stroke-linejoin="round" />
              </svg>
            </button>
          </div>

          <div class="mt-6 flow-root">
            <div class="-my-6 divide-y divide-white/10">
              <div class="space-y-2 py-6">
                <a href="<?= base_url('/') ?>" class="block rounded-lg px-3 py-2 text-base font-semibold text-white hover:bg-white/5">Dashboard</a>
                <a href="<?= base_url('obat') ?>" class="block rounded-lg px-3 py-2 text-base font-semibold text-white hover:bg-white/5">Data Obat</a>
                <a href="<?= base_url('kategori') ?>" class="block rounded-lg px-3 py-2 text-base font-semibold text-white hover:bg-white/5">Kategori</a>
                <a href="<?= base_url('supplier') ?>" class="block rounded-lg px-3 py-2 text-base font-semibold text-white hover:bg-white/5">Supplier</a>
                <a href="<?= base_url('transaksi') ?>" class="block rounded-lg px-3 py-2 text-base font-semibold text-white hover:bg-white/5">Transaksi</a>
                <a href="<?= base_url('laporan') ?>" class="block rounded-lg px-3 py-2 text-base font-semibold text-white hover:bg-white/5">Laporan</a>
              </div>
              <div class="py-6">
                <a href="<?= base_url('logout') ?>" class="block rounded-lg px-3 py-2.5 text-base font-semibold text-white hover:bg-white/5">Logout</a>
              </div>
            </div>
          </div>

        </el-dialog-panel>
      </div>
    </dialog>
  </el-dialog>
</header>
