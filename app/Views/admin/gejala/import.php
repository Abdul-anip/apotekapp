<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800"><?= $title ?></h1>
            <p class="text-sm text-gray-600 mt-1">Upload file Excel untuk import data gejala</p>
        </div>
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

    <!-- Panduan -->
    <div class="bg-blue-50 border-2 border-blue-300 rounded-lg p-5 mb-6">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <h4 class="font-bold text-blue-800 mb-2">Panduan Import Data</h4>
                <ol class="text-sm text-blue-700 space-y-1 list-decimal list-inside">
                    <li>Download template Excel terlebih dahulu</li>
                    <li>Isi data gejala sesuai format:
                        <ul class="ml-6 mt-1 list-disc list-inside">
                            <li><strong>Kolom A:</strong> Kode Gejala (contoh: G001, G002)</li>
                            <li><strong>Kolom B:</strong> Nama Gejala (contoh: Demam tinggi)</li>
                        </ul>
                    </li>
                    <li>Pastikan tidak ada kode gejala yang duplikat</li>
                    <li>Simpan file dalam format .xlsx atau .xls</li>
                    <li>Upload file dan klik "Import Data"</li>
                </ol>
            </div>
        </div>
    </div>

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
            <a href="<?= base_url('admin/gejala/download-template') ?>" 
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
        
        <form action="<?= base_url('admin/gejala/process-import') ?>" method="post" enctype="multipart/form-data" id="formImport">
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
                        <p class="text-sm text-gray-500 mt-1">Format: .xlsx, .xls (Maksimal 2MB)</p>
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

            <div class="bg-yellow-50 border border-yellow-300 rounded-lg p-4 mb-6">
                <div class="flex items-start gap-2">
                    <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <div class="text-sm text-yellow-700">
                        <p class="font-semibold">⚠️ Perhatian:</p>
                        <ul class="list-disc list-inside mt-1">
                            <li>Data dengan kode gejala yang sudah ada akan dilewati</li>
                            <li>Pastikan format data sesuai dengan template</li>
                            <li>Proses import tidak dapat dibatalkan setelah berhasil</li>
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
                <a href="<?= base_url('admin/gejala') ?>" 
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

// Validasi form sebelum submit
document.getElementById('formImport')?.addEventListener('submit', function(e) {
    const fileInput = document.getElementById('file_excel');
    
    if (!fileInput.files || fileInput.files.length === 0) {
        e.preventDefault();
        alert('❌ Pilih file Excel terlebih dahulu!');
        return false;
    }
    
    const file = fileInput.files[0];
    const fileSize = file.size / 1024 / 1024; // Convert to MB
    
    if (fileSize > 2) {
        e.preventDefault();
        alert('❌ Ukuran file maksimal 2MB!');
        return false;
    }
    
    const ext = file.name.split('.').pop().toLowerCase();
    if (ext !== 'xlsx' && ext !== 'xls') {
        e.preventDefault();
        alert('❌ Format file harus .xlsx atau .xls!');
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