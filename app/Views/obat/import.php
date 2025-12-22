<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800"><?= $title ?></h1>
            <p class="text-sm text-gray-600 mt-1">Upload file Excel untuk import data obat</p>
        </div>
        <a href="<?= base_url('obat') ?>" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-4">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-4">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-4">
            <p class="font-bold mb-2">Terjadi kesalahan:</p>
            <ul class="list-disc list-inside">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('import_errors')): ?>
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded-lg mb-4">
            <p class="font-bold mb-2">⚠️ Peringatan Import:</p>
            <ul class="list-disc list-inside max-h-48 overflow-y-auto">
                <?php foreach (session()->getFlashdata('import_errors') as $error): ?>
                    <li class="text-sm"><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Download Template -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="bg-green-100 p-4 rounded-lg">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 text-lg">Template Excel</h3>
                    <p class="text-sm text-gray-600">Download template untuk format data yang benar</p>
                </div>
            </div>
            <a href="<?= base_url('obat/download-template') ?>" 
               class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition font-semibold flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Download Template
            </a>
        </div>
    </div>

    <!-- Form Upload -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h3 class="font-bold text-gray-800 text-lg mb-4">Upload File Excel</h3>
        
        <form action="<?= base_url('obat/process-import') ?>" method="post" enctype="multipart/form-data" id="formImport">
            <?= csrf_field() ?>
            
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Pilih File Excel <span class="text-red-500">*</span>
                </label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-teal-500 transition">
                    <input type="file" name="file_excel" id="file_excel" accept=".xlsx,.xls" required
                           class="hidden" onchange="updateFileName()">
                    <label for="file_excel" class="cursor-pointer">
                        <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        <p class="text-gray-600 font-semibold">Klik untuk memilih file</p>
                        <p class="text-sm text-gray-500 mt-1">Format: .xlsx, .xls (Maksimal 5MB)</p>
                    </label>
                </div>
                <div id="fileName" class="mt-3 hidden">
                    <div class="flex items-center gap-2 bg-gray-100 px-4 py-2 rounded-lg">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-sm font-semibold text-gray-700" id="fileNameText"></span>
                        <button type="button" onclick="clearFile()" class="ml-auto text-red-500 hover:text-red-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="bg-blue-50 border border-blue-300 rounded-lg p-4 mb-6">
                <div class="flex items-start gap-2">
                    <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="text-sm text-blue-700">
                        <p class="font-semibold">ℹ️ Catatan Penting:</p>
                        <ul class="list-disc list-inside mt-1">
                            <li>Pastikan nama kategori di Excel <strong>sama persis</strong> dengan yang ada di sistem (Master Data > Kategori).</li>
                            <li>Jika kategori tidak ditemukan, data tersebut akan dilewati.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit" id="btnSubmit"
                        class="flex-1 bg-teal-600 text-white py-3 rounded-lg hover:bg-teal-700 transition font-bold flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                    </svg>
                    Import Data
                </button>
                <a href="<?= base_url('obat') ?>" 
                   class="bg-gray-300 text-gray-700 px-8 py-3 rounded-lg hover:bg-gray-400 transition font-bold text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function updateFileName() {
    const input = document.getElementById('file_excel');
    const fileNameDiv = document.getElementById('fileName');
    const fileNameText = document.getElementById('fileNameText');
    
    if (input.files.length > 0) {
        fileNameText.textContent = input.files[0].name;
        fileNameDiv.classList.remove('hidden');
    }
}

function clearFile() {
    const input = document.getElementById('file_excel');
    const fileNameDiv = document.getElementById('fileName');
    
    input.value = '';
    fileNameDiv.classList.add('hidden');
}

document.getElementById('formImport')?.addEventListener('submit', function(e) {
    const fileInput = document.getElementById('file_excel');
    
    if (!fileInput.files || fileInput.files.length === 0) {
        e.preventDefault();
        alert('❌ Pilih file Excel terlebih dahulu!');
        return false;
    }
    
    // Show loading
    const btnSubmit = document.getElementById('btnSubmit');
    btnSubmit.disabled = true;
    btnSubmit.innerHTML = `
        <svg class="animate-spin w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
        </svg>
        Sedang mengimport...
    `;
    
    return true;
});
</script>

<?= $this->endSection() ?>
