<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Puskomedia Helpdesk - Edit Foto Profil</title>
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
      padding: 12px 24px;
      border: 2px dashed #cbd5e1;
      border-radius: 8px;
      background-color: #f8fafc;
      color: #64748b;
      font-weight: 500;
      transition: all 0.3s ease;
      cursor: pointer;
    }
    .file-input-label:hover {
      border-color: #475569;
      background-color: #f1f5f9;
      color: #475569;
    }
  </style>
</head>
<body class="min-h-screen gradient-bg font-sans">

  <!-- Header -->
  <header class="bg-white/80 backdrop-blur-sm border-b border-slate-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-6 py-4">
      <div class="flex items-center justify-between">
        <div class="flex items-center space-x-3">
          <img src="{{ asset('img/logo.jpg') }}" alt="Logo Puskomedia" class="w-10 h-10 rounded-lg" />
          <h1 class="text-xl font-semibold text-slate-800">Puskomedia Helpdesk</h1>
        </div>
        <a href="{{ route('dashboard.customer') }}" class="text-slate-600 hover:text-slate-800 text-sm font-medium transition-colors flex items-center space-x-2">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
          </svg>
          <span>Kembali ke Dashboard</span>
        </a>
      </div>
    </div>
  </header>

  <!-- Main Content -->
  <div class="flex-1 flex items-center justify-center px-6 py-12">
    <div class="w-full max-w-md">
      <!-- Edit Photo Card -->
      <div class="bg-white rounded-2xl card-shadow p-8">
        <div class="text-center mb-8">
          <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
          </div>
          <h2 class="text-2xl font-bold text-slate-800 mb-2">Edit Foto Profil</h2>
          <p class="text-slate-600">Ubah foto profil Anda</p>
        </div>

        <!-- Success Message -->
        @if (session('success'))
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

        <!-- Current Photo -->
        <div class="text-center mb-8">
          <label class="block text-sm font-medium text-slate-700 mb-4">Foto Saat Ini</label>
          <div class="w-32 h-32 mx-auto rounded-full overflow-hidden border-4 border-slate-200 shadow-lg">
            <img src="{{ auth()->user()->foto_profil ? asset('storage/' . auth()->user()->foto_profil) : asset('images/profile.png') }}"
                 class="w-full h-full object-cover" alt="Foto Profil">
          </div>
        </div>

        <!-- Upload Form -->
        <form action="{{ route('customer.update-foto') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
          @csrf

          <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Upload Foto Baru</label>
            <div class="file-input">
              <input type="file" name="foto_profil" id="foto_profil" accept="image/jpeg,image/png,image/jpg" required class="input-focus">
              <label for="foto_profil" class="file-input-label">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
                <span>Pilih Foto</span>
              </label>
            </div>
            @error('foto_profil')
              <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
            @enderror
            <p class="text-xs text-slate-500 mt-2">Format: JPG, PNG, JPEG. Maksimal 2MB</p>
          </div>

          <button 
            type="submit" 
            class="w-full bg-slate-800 hover:bg-slate-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-300 transform hover:-translate-y-0.5 hover:shadow-lg"
          >
            Simpan Foto
          </button>
        </form>

        <!-- Back to Profile -->
        <div class="text-center mt-6">
          <a href="{{ route('dashboard.customer') }}" class="text-slate-600 hover:text-slate-800 text-sm font-medium transition-colors flex items-center justify-center space-x-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span>Kembali ke Profil</span>
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
    // Preview image when file is selected
    document.getElementById('foto_profil').addEventListener('change', function(e) {
      const file = e.target.files[0];
      if (file) {
        // Validate file type
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!allowedTypes.includes(file.type)) {
          alert('Format file tidak didukung. Gunakan JPG, PNG, atau JPEG.');
          e.target.value = '';
          return;
        }
        
        // Validate file size (2MB = 2 * 1024 * 1024 bytes)
        if (file.size > 2 * 1024 * 1024) {
          alert('Ukuran file terlalu besar. Maksimal 2MB.');
          e.target.value = '';
          return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
          // Update the current photo preview
          const img = document.querySelector('img[alt="Foto Profil"]');
          img.src = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    });
  </script>

</body>
</html>
