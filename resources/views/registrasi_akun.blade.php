<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Puskomedia Helpdesk - Registrasi Akun</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
</head>
<body class="min-h-screen gradient-bg font-sans">
    <!-- Header -->
    <header class="bg-white/80 backdrop-blur-sm border-b border-slate-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex items-center space-x-3">
                <img src="{{ asset('img/logo.jpg') }}" alt="Logo Puskomedia" class="w-10 h-10 rounded-lg" />
                <h1 class="text-xl font-semibold text-slate-800">Puskomedia Helpdesk</h1>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="flex-1 flex items-center justify-center px-6 py-12">
        <div class="w-full max-w-2xl">
            <!-- Registration Card -->
            <div class="bg-white rounded-2xl card-shadow p-8">
                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-slate-800 mb-2">Buat Akun Baru</h2>
                    <p class="text-slate-600">Isi data diri Anda untuk memulai</p>
                </div>

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6" role="alert">
                        <div class="flex">
                            <svg class="w-5 h-5 text-red-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <ul class="text-sm">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Registration Form -->
                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf
                    
                    <!-- Personal Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="nama_lengkap" class="block text-sm font-medium text-slate-700 mb-2">Nama Lengkap</label>
                            <input 
                                type="text" 
                                name="nama_lengkap" 
                                id="nama_lengkap"
                                placeholder="Masukkan nama lengkap Anda" 
                                required 
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg input-focus transition-all duration-200" 
                                value="{{ old('nama_lengkap') }}"
                            >
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                            <input 
                                type="email" 
                                name="email" 
                                id="email"
                                placeholder="Masukkan email Anda" 
                                required 
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg input-focus transition-all duration-200" 
                                value="{{ old('email') }}"
                            >
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="no_telpon" class="block text-sm font-medium text-slate-700 mb-2">Nomor Telepon</label>
                            <input 
                                type="text" 
                                name="no_telpon" 
                                id="no_telpon"
                                placeholder="Masukkan nomor telepon" 
                                required 
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg input-focus transition-all duration-200" 
                                inputmode="numeric" 
                                oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                value="{{ old('no_telpon') }}"
                            >
                        </div>
                        
                        <div>
                            <label for="tanggal_lahir" class="block text-sm font-medium text-slate-700 mb-2">Tanggal Lahir</label>
                            <input 
                                type="date" 
                                name="tanggal_lahir" 
                                id="tanggal_lahir"
                                required 
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg input-focus transition-all duration-200" 
                                value="{{ old('tanggal_lahir') }}"
                            >
                        </div>
                    </div>

                    <div>
                        <label for="jenis_kelamin" class="block text-sm font-medium text-slate-700 mb-2">Jenis Kelamin</label>
                        <select 
                            name="jenis_kelamin" 
                            id="jenis_kelamin"
                            required 
                            class="w-full px-4 py-3 border border-slate-300 rounded-lg input-focus transition-all duration-200"
                        >
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <!-- Password Section -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="password" class="block text-sm font-medium text-slate-700 mb-2">Kata Sandi</label>
                            <input 
                                type="password" 
                                name="password" 
                                id="password"
                                placeholder="Minimal 8 karakter" 
                                minlength="8" 
                                required 
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg input-focus transition-all duration-200"
                            >
                        </div>
                        
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-2">Konfirmasi Kata Sandi</label>
                            <input 
                                type="password" 
                                name="password_confirmation" 
                                id="password_confirmation"
                                placeholder="Ulangi kata sandi" 
                                minlength="8" 
                                required 
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg input-focus transition-all duration-200"
                            >
                        </div>
                    </div>
                    
                    <button 
                        type="submit" 
                        class="w-full bg-slate-800 hover:bg-slate-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-300 transform hover:-translate-y-0.5 hover:shadow-lg"
                    >
                        Daftar Sekarang
                    </button>
                </form>

                <!-- Login Link -->
                <div class="text-center mt-6">
                    <p class="text-slate-600 text-sm">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="text-slate-800 hover:text-slate-600 font-medium transition-colors">
                            Masuk di sini
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
</body>
</html>
