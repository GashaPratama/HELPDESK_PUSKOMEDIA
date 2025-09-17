<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Puskomedia Helpdesk - Edit Kategori</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <header class="bg-white/90 backdrop-blur-sm border-b border-slate-200 shadow-sm sticky top-0 z-40">
        <div class="w-full px-4 sm:px-6">
            <div class="flex items-center justify-between h-16">
                <!-- Left Section -->
                <div class="flex items-center space-x-4">
                    <a href="{{ route('superadmin.kategori.index') }}" class="p-2 rounded-lg hover:bg-slate-100 transition-colors focus:outline-none focus:ring-2 focus:ring-slate-300">
                        <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </a>
                    
                    <!-- Logo and Brand -->
                    <div class="flex items-center space-x-3">
                        <img src="{{ asset('img/logo.jpg') }}" alt="Logo Puskomedia" class="w-8 h-8 rounded-lg" />
                        <div class="hidden sm:block">
                            <h1 class="text-lg font-semibold text-slate-800">Edit Kategori</h1>
                        </div>
                    </div>
                </div>

                <!-- Right Section -->
                <div class="flex items-center space-x-3">
                    <!-- User Info -->
                    <div class="hidden sm:block text-right">
                        <p class="text-sm font-medium text-slate-800">{{ auth()->user()->nama_lengkap }}</p>
                        <p class="text-xs text-slate-500">Superadmin</p>
                    </div>
                    
                    <!-- Logout Button -->
                    <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Yakin ingin logout?');">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-red-500 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            <span class="hidden sm:inline">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="flex-1 flex items-center justify-center px-6 py-12">
        <div class="w-full max-w-md">
            <!-- Edit Category Card -->
            <div class="bg-white rounded-2xl card-shadow p-8">
                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-slate-800 mb-2">Edit Kategori</h2>
                    <p class="text-slate-600">Ubah informasi kategori</p>
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

                <!-- Edit Form -->
                <form method="POST" action="{{ route('superadmin.kategori.update', $kategori) }}" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label for="nama" class="block text-sm font-medium text-slate-700 mb-2">Nama Kategori</label>
                        <input 
                            type="text" 
                            id="nama" 
                            name="nama" 
                            value="{{ old('nama', $kategori->nama) }}"
                            placeholder="Masukkan nama kategori" 
                            class="w-full px-4 py-3 border border-slate-300 rounded-lg input-focus transition-all duration-200" 
                            required
                        >
                    </div>
                    
                    <button 
                        type="submit" 
                        class="w-full bg-slate-800 hover:bg-slate-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-300 transform hover:-translate-y-0.5 hover:shadow-lg"
                    >
                        <span class="flex items-center justify-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Simpan Perubahan</span>
                        </span>
                    </button>
                </form>

                <!-- Back to Categories -->
                <div class="text-center mt-6">
                    <a href="{{ route('superadmin.kategori.index') }}" class="text-slate-600 hover:text-slate-800 text-sm font-medium transition-colors flex items-center justify-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span>Kembali ke Daftar Kategori</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-slate-800 text-white mt-16">
        <div class="max-w-7xl mx-auto px-6 py-12">
            <div class="text-center">
                <div class="flex items-center justify-center space-x-3 mb-6">
                    <img src="{{ asset('img/logo.jpg') }}" alt="Logo Puskomedia" class="w-10 h-10 rounded-lg shadow-lg" />
                    <div>
                        <h3 class="text-xl font-bold text-white">Puskomedia Helpdesk</h3>
                        <p class="text-slate-300 text-sm">Sistem Manajemen Laporan</p>
                    </div>
                </div>
                
                <div class="border-t border-slate-700 pt-6">
                    <p class="text-slate-400 text-sm">
                        &copy; 2025 Puskomedia. All rights reserved. | 
                        <span class="text-slate-500">Powered by Laravel & Tailwind CSS</span>
                    </p>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
