<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Puskomedia Helpdesk - Buat Laporan</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
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
    .file-input {
      position: relative;
      display: inline-block;
      cursor: pointer;
      width: 100%;
    }
    .file-input input[type="file"] {
      position: absolute;
      opacity: 0;
      width: 100%;
      height: 100%;
      cursor: pointer;
    }
    .file-input-label {
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1rem;
      border: 2px dashed #cbd5e1;
      border-radius: 0.5rem;
      background-color: #f8fafc;
      transition: all 0.3s ease;
      cursor: pointer;
    }
    .file-input-label:hover {
      border-color: #475569;
      background-color: #f1f5f9;
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
          <a href="{{ route('dashboard.customer') }}" class="p-2 rounded-lg hover:bg-slate-100 transition-colors focus:outline-none focus:ring-2 focus:ring-slate-300">
            <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
          </a>
          
          <!-- Logo and Brand -->
          <div class="flex items-center space-x-3">
            <img src="{{ asset('img/logo.jpg') }}" alt="Logo Puskomedia" class="w-8 h-8 rounded-lg" />
            <div class="hidden sm:block">
              <h1 class="text-lg font-semibold text-slate-800">Buat Laporan</h1>
            </div>
          </div>
        </div>

        <!-- Right Section -->
        <div class="flex items-center space-x-3">
          <!-- User Info -->
          <div class="hidden sm:block text-right">
            <p class="text-sm font-medium text-slate-800">{{ auth()->user()->nama_lengkap }}</p>
            <p class="text-xs text-slate-500">Customer</p>
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
  <div class="flex-1 px-6 py-8">
    <div class="max-w-4xl mx-auto">
      <!-- Create Report Card -->
      <div class="bg-white rounded-2xl card-shadow p-8">
        <div class="text-center mb-8">
          <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
          </div>
          <h2 class="text-2xl font-bold text-slate-800 mb-2">Buat Laporan Baru</h2>
          <p class="text-slate-600">Laporkan kendala yang Anda alami untuk mendapatkan bantuan</p>
        </div>

        <!-- Success Message -->
        @if(session('success'))
          <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6" role="alert">
            <div class="flex">
              <svg class="w-5 h-5 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
              </svg>
              <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
          </div>
        @endif

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

        <!-- Create Form -->
        <form action="{{ route('customer.laporan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
          @csrf

          <!-- Kategori -->
          <div>
            <label for="kategori_id" class="block text-sm font-medium text-slate-700 mb-2">Kategori Laporan</label>
            <select 
              name="kategori_id" 
              id="kategori_id"
              class="w-full px-4 py-3 border border-slate-300 rounded-lg input-focus transition-all duration-200"
              required
            >
              <option value="">Pilih kategori laporan</option>
              @foreach($kategoris as $kategori)
                <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                  {{ $kategori->nama }}
                </option>
              @endforeach
            </select>
            @error('kategori_id')
              <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
            @enderror
          </div>

          <!-- URL Situs -->
          <div>
            <label for="url_situs" class="block text-sm font-medium text-slate-700 mb-2">URL Situs</label>
            <input 
              type="url" 
              name="url_situs" 
              id="url_situs"
              value="{{ old('url_situs') }}"
              placeholder="https://example.com" 
              class="w-full px-4 py-3 border border-slate-300 rounded-lg input-focus transition-all duration-200" 
              required
            >
            @error('url_situs')
              <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
            @enderror
          </div>

          <!-- Kendala -->
          <div>
            <label for="kendala" class="block text-sm font-medium text-slate-700 mb-2">Deskripsi Kendala</label>
            <textarea 
              name="kendala" 
              id="kendala"
              rows="5" 
              placeholder="Jelaskan kendala yang Anda alami secara detail..." 
              class="w-full px-4 py-3 border border-slate-300 rounded-lg input-focus transition-all duration-200 resize-none" 
              required
            >{{ old('kendala') }}</textarea>
            @error('kendala')
              <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
            @enderror
          </div>

          <!-- Lampiran -->
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Lampiran (Opsional)</label>
            <div class="file-input">
              <input type="file" name="lampiran" id="lampiran" accept="image/*,video/*" onchange="previewFile(this)">
              <label for="lampiran" class="file-input-label">
                <div class="text-center">
                  <svg class="w-8 h-8 text-slate-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                  </svg>
                  <p class="text-sm text-slate-600 font-medium">Klik untuk upload file</p>
                  <p class="text-xs text-slate-500 mt-1">Gambar atau video (max 10MB)</p>
                </div>
              </label>
            </div>
            <div id="file-preview" class="mt-3 hidden">
              <div class="flex items-center space-x-3 p-3 bg-slate-50 rounded-lg">
                <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <span id="file-name" class="text-sm text-slate-700"></span>
                <button type="button" onclick="removeFile()" class="ml-auto text-red-500 hover:text-red-700">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                  </svg>
                </button>
              </div>
            </div>
            @error('lampiran')
              <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
            @enderror
          </div>

          <!-- Submit Button -->
          <div class="pt-6">
            <button 
              type="submit" 
              class="w-full bg-slate-800 hover:bg-slate-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-300 transform hover:-translate-y-0.5 hover:shadow-lg"
            >
              <span class="flex items-center justify-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                </svg>
                <span>Kirim Laporan</span>
              </span>
            </button>
          </div>
        </form>

        <!-- Back to Dashboard -->
        <div class="text-center mt-6">
          <a href="{{ route('dashboard.customer') }}" class="text-slate-600 hover:text-slate-800 text-sm font-medium transition-colors flex items-center justify-center space-x-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span>Kembali ke Dashboard</span>
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="bg-slate-800 text-white">
    <div class="max-w-7xl mx-auto px-6 py-8">
      <div class="text-center">
        <div class="flex items-center justify-center space-x-3 mb-4">
          <img src="{{ asset('img/logo.jpg') }}" alt="Logo Puskomedia" class="w-8 h-8 rounded-lg" />
          <span class="text-lg font-semibold">Puskomedia Helpdesk</span>
        </div>
        <p class="text-slate-400 text-sm">&copy; 2025 Puskomedia. All rights reserved.</p>
      </div>
    </div>
  </footer>

  <script>
    function previewFile(input) {
      const file = input.files[0];
      const preview = document.getElementById('file-preview');
      const fileName = document.getElementById('file-name');
      
      if (file) {
        fileName.textContent = file.name;
        preview.classList.remove('hidden');
      } else {
        preview.classList.add('hidden');
      }
    }

    function removeFile() {
      const input = document.getElementById('lampiran');
      const preview = document.getElementById('file-preview');
      
      input.value = '';
      preview.classList.add('hidden');
    }
  </script>

</body>
</html>