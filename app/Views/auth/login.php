<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - POS Apotek TASYA FARMA</title>
    <link href="<?= base_url('css/output.css') ?>" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-teal-50 via-white to-teal-100 min-h-screen flex items-center justify-center p-4">
    
    <!-- Background Decoration -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-teal-400 rounded-full opacity-20 blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-blue-400 rounded-full opacity-20 blur-3xl"></div>
    </div>

    <div class="relative w-full max-w-md">
        <!-- Logo & Header -->
        <div class="text-center mb-8">
            <div class="bg-gradient-to-r from-teal-600 to-teal-700 w-20 h-20 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-2xl transform hover:scale-110 transition-transform">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
            </div>
            <h1 class="text-3xl font-black text-gray-800 mb-2">TASYA FARMA</h1>
            <p class="text-gray-600 text-sm">Point of Sale System</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white rounded-3xl shadow-2xl p-8 backdrop-blur-sm border border-gray-100">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Selamat Datang</h2>
            <p class="text-gray-600 text-sm mb-6">Silakan login untuk melanjutkan</p>

            <!-- Flash Messages -->
            <?php if (session()->getFlashdata('error')): ?>
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6 flex items-start">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <div class="flex-1">
                        <p class="font-semibold text-sm"><?= session()->getFlashdata('error') ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6 flex items-start">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <div class="flex-1">
                        <p class="font-semibold text-sm"><?= session()->getFlashdata('success') ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Login Form -->
            <form action="/auth/login" method="post" class="space-y-5">
                <?= csrf_field() ?>

                <!-- Username -->
                <div>
                    <label for="username" class="block text-sm font-semibold text-gray-700 mb-2">
                        Username
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <input type="text" id="username" name="username" required
                               value="<?= old('username') ?>"
                               class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all"
                               placeholder="Masukkan username">
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                        Password
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <input type="password" id="password" name="password" required
                               class="w-full pl-12 pr-12 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all"
                               placeholder="Masukkan password">
                        <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-4 flex items-center">
                            <svg id="eye-icon" class="w-5 h-5 text-gray-400 hover:text-gray-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-gradient-to-r from-teal-600 to-teal-700 text-white py-3 rounded-xl font-bold text-base hover:from-teal-700 hover:to-teal-800 focus:outline-none focus:ring-4 focus:ring-teal-300 transform hover:scale-[1.02] transition-all shadow-lg hover:shadow-xl">
                    <span class="flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        Masuk
                    </span>
                </button>
            </form>

            <!-- Default Credentials Info -->
            <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-xl">
                <p class="text-xs font-semibold text-blue-800 mb-2">🔐 Default Login:</p>
                <div class="space-y-1 text-xs text-blue-700">
                    <p><strong>Pemilik:</strong> username: <code class="bg-blue-100 px-2 py-0.5 rounded">pemilik</code> | password: <code class="bg-blue-100 px-2 py-0.5 rounded">pemilik123</code></p>
                    <p><strong>Kasir:</strong> username: <code class="bg-blue-100 px-2 py-0.5 rounded">kasir</code> | password: <code class="bg-blue-100 px-2 py-0.5 rounded">kasir123</code></p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-6 text-sm text-gray-600">
            <p>&copy; <?= date('Y') ?> TASYA FARMA. All rights reserved.</p>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                `;
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                `;
            }
        }

        // Auto-hide flash messages after 5 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('[class*="bg-red-50"], [class*="bg-green-50"]');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    </script>
</body>
</html>