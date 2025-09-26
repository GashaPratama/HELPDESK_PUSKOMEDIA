<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Puskomedia Helpdesk - Login</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        .gradient-bg { background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); }
        .card-shadow { box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-2px); box-shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); }
        .input-focus:focus { 
            outline: none; 
            border-color: #475569; 
            box-shadow: 0 0 0 3px rgba(71, 85, 105, 0.1); 
        }
    </style>

    <?php if(session('error')): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Login!',
                    confirmButtonColor: '#475569',
                    timer: 1500,
                    showConfirmButton: false
                });
            });
        </script>
    <?php endif; ?>
</head>
<body class="min-h-screen gradient-bg font-sans">
    
    <!-- Header -->
    <header class="bg-white/80 backdrop-blur-sm border-b border-slate-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex items-center space-x-3">
                <?php
                    try {
                        $logo = \App\Models\SystemSetting::where('key', 'login_logo')->first();
                        $logo = $logo ? $logo->value : null;
                    } catch (\Exception $e) {
                        $logo = null;
                    }
                ?>
                <?php if($logo): ?>
                    <img src="<?php echo e(asset('storage/' . $logo)); ?>" alt="Logo Puskomedia" class="w-16 h-16 rounded-lg object-contain border border-gray-200 shadow-sm" />
                <?php else: ?>
                    <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center border border-gray-200 shadow-sm">
                        <span class="text-white font-bold text-lg">P</span>
                    </div>
                <?php endif; ?>
                <h1 class="text-xl font-semibold text-slate-800">Puskomedia Helpdesk</h1>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="flex-1 flex items-center justify-center px-6 py-12">
        <div class="w-full max-w-md">
            <!-- Login Card -->
            <div class="bg-white rounded-2xl card-shadow p-8">
                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-slate-800 mb-2">Selamat Datang</h2>
                    <p class="text-slate-600">Silakan masuk ke akun Anda</p>
                </div>

                <!-- Login Form -->
                <form method="POST" action="<?php echo e(route('login')); ?>" class="space-y-6">
                    <?php echo csrf_field(); ?>
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                        <input 
                            type="email" 
                            name="email" 
                            id="email"
                            placeholder="Masukkan email Anda" 
                            class="w-full px-4 py-3 border border-slate-300 rounded-lg input-focus transition-all duration-200" 
                            required
                        >
                    </div>
                    
                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700 mb-2">Password</label>
                        <input 
                            type="password" 
                            name="password" 
                            id="password"
                            placeholder="Minimal 8 karakter" 
                            class="w-full px-4 py-3 border border-slate-300 rounded-lg input-focus transition-all duration-200" 
                            required
                        >
                    </div>
                    
                    <button 
                        type="submit" 
                        class="w-full bg-slate-800 hover:bg-slate-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-300 transform hover:-translate-y-0.5 hover:shadow-lg"
                    >
                        Masuk
                    </button>
                </form>

                <!-- Register Link -->
                <div class="text-center mt-6">
                    <p class="text-slate-600 text-sm">
                        Belum punya akun?
                        <a href="<?php echo e(route('register')); ?>" class="text-slate-800 hover:text-slate-600 font-medium transition-colors">
                            Buat sekarang
                        </a>
                    </p>
                </div>
            </div>

            <!-- Back to Home -->
            <div class="text-center mt-6">
                <a href="/" class="text-slate-600 hover:text-slate-800 text-sm font-medium transition-colors flex items-center justify-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span>Kembali ke Beranda</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-slate-800 text-white">
        <div class="max-w-7xl mx-auto px-6 py-8">
            <div class="text-center">
                <div class="flex items-center justify-center space-x-3 mb-4">
                    <img src="<?php echo e(asset('img/logo.jpg')); ?>" alt="Logo Puskomedia" class="w-8 h-8 rounded-lg" />
                    <span class="text-lg font-semibold">Puskomedia Helpdesk</span>
                </div>
                <p class="text-slate-400 text-sm">&copy; 2025 Puskomedia. All rights reserved.</p>
            </div>
        </div>
    </footer>

<script>
// Success notifications
<?php if(session('success')): ?>
  document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
      icon: 'success',
      title: 'Berhasil!',
      text: '<?php echo e(session('success')); ?>',
      timer: 3000,
      showConfirmButton: false,
      toast: true,
      position: 'top-end'
    });
  });
<?php endif; ?>

// Error notifications
<?php if(session('error')): ?>
  document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
      icon: 'error',
      title: 'Gagal!',
      text: '<?php echo e(session('error')); ?>',
      confirmButtonText: 'OK'
    });
  });
<?php endif; ?>

// Warning notifications
<?php if(session('warning')): ?>
  document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
      icon: 'warning',
      title: 'Peringatan!',
      text: '<?php echo e(session('warning')); ?>',
      confirmButtonText: 'OK'
    });
  });
<?php endif; ?>

// Info notifications
<?php if(session('info')): ?>
  document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
      icon: 'info',
      title: 'Informasi',
      text: '<?php echo e(session('info')); ?>',
      timer: 3000,
      showConfirmButton: false,
      toast: true,
      position: 'top-end'
    });
  });
<?php endif; ?>
</script>

</body>
</html>
<?php /**PATH D:\Tugas\HELPDESK_PUSKOMEDIA\resources\views/login.blade.php ENDPATH**/ ?>