@extends('layouts.app')

@section('title', 'Kelola Logo')

@section('content')
<!-- Loading Overlay -->
<div id="loadingOverlay" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
  <div class="bg-white rounded-lg p-8 max-w-md mx-4 text-center shadow-2xl">
    <!-- Spinner -->
    <div class="animate-spin rounded-full h-16 w-16 border-4 border-blue-200 border-t-blue-600 mx-auto mb-6"></div>
    
    <!-- Title -->
    <h3 class="text-xl font-semibold text-gray-900 mb-2">Mengupload Logo...</h3>
    <p class="text-gray-600 mb-6">Mohon tunggu sebentar, logo sedang diproses</p>
    
    <!-- Progress Bar -->
    <div class="w-full bg-gray-200 rounded-full h-2 mb-4">
      <div id="progressBar" class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
    </div>
    
    <!-- Progress Text -->
    <p id="progressText" class="text-sm text-gray-500">Memulai upload...</p>
    
    <!-- Steps -->
    <div class="mt-6 space-y-2 text-sm text-gray-600">
      <div id="step1" class="flex items-center justify-center gap-2">
        <div class="w-2 h-2 bg-blue-600 rounded-full"></div>
        <span>Menyiapkan file...</span>
      </div>
      <div id="step2" class="flex items-center justify-center gap-2 opacity-50">
        <div class="w-2 h-2 bg-gray-300 rounded-full"></div>
        <span>Mengupload ke server...</span>
      </div>
      <div id="step3" class="flex items-center justify-center gap-2 opacity-50">
        <div class="w-2 h-2 bg-gray-300 rounded-full"></div>
        <span>Menyimpan ke database...</span>
      </div>
    </div>
  </div>
</div>
<div class="min-h-screen bg-gray-50 py-8">
  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">🎨 Kelola Logo</h1>
          <p class="mt-2 text-gray-600">Atur logo yang ditampilkan di halaman login</p>
        </div>
        <a href="{{ route('superadmin.dashboard') }}" 
           class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium text-gray-700 transition-colors">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
          </svg>
          Kembali ke Dashboard
        </a>
      </div>
    </div>

    <!-- Current Logo Display -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
      <h2 class="text-xl font-semibold text-gray-900 mb-4">Logo Saat Ini</h2>
      
      @if($currentLogo)
        <div class="flex items-center space-x-6">
          <div class="flex-shrink-0">
            <img src="{{ asset('storage/' . $currentLogo) }}" 
                 alt="Current Logo" 
                 class="h-20 w-auto object-contain rounded-lg border border-gray-200">
          </div>
          <div class="flex-1">
            <p class="text-sm text-gray-600 mb-2">Logo saat ini:</p>
            <p class="text-sm font-medium text-gray-900">{{ basename($currentLogo) }}</p>
            <p class="text-xs text-gray-500 mt-1">Terakhir diupdate: {{ \Carbon\Carbon::parse(\App\Models\SystemSetting::where('key', 'login_logo')->first()->updated_at ?? now())->format('d/m/Y H:i') }}</p>
          </div>
          <div class="flex-shrink-0">
            <form action="{{ route('superadmin.logo.destroy') }}" method="POST" class="inline">
              @csrf
              @method('DELETE')
              <button type="submit" 
                      onclick="return confirm('Apakah Anda yakin ingin menghapus logo ini?')"
                      class="inline-flex items-center gap-2 px-3 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
                Hapus Logo
              </button>
            </form>
          </div>
        </div>
      @else
        <div class="text-center py-8">
          <div class="mx-auto h-20 w-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
            <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
          </div>
          <p class="text-gray-500">Belum ada logo yang diupload</p>
        </div>
      @endif
    </div>

    <!-- Upload Form -->
    <div class="bg-white rounded-xl shadow-lg p-6">
      <h2 class="text-xl font-semibold text-gray-900 mb-4">Upload Logo Baru</h2>
      
      <form action="{{ route('superadmin.logo.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6" 
            x-data="{ uploading: false }"
            @submit="uploading = true; showLoading()">
        @csrf
        @method('PUT')
        
        <div>
          <label for="logo" class="block text-sm font-medium text-gray-700 mb-2">
            Pilih File Logo
          </label>
          <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition-colors" 
               x-data="{ files: null }" 
               @dragover.prevent 
               @drop.prevent="files = $event.dataTransfer.files; $refs.fileInput.files = files">
            <div class="space-y-1 text-center">
              <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
              <div class="flex text-sm text-gray-600">
                <label for="logo" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                  <span>Upload file</span>
                  <input id="logo" 
                         name="logo" 
                         type="file" 
                         class="sr-only" 
                         accept="image/*"
                         x-ref="fileInput"
                         @change="files = $event.target.files"
                         required>
                </label>
                <p class="pl-1">atau drag and drop</p>
              </div>
              <p class="text-xs text-gray-500">PNG, JPG, GIF, SVG hingga 2MB</p>
            </div>
          </div>
          
          @error('logo')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <!-- Preview -->
        <div x-show="files && files.length > 0" x-transition class="mt-4">
          <label class="block text-sm font-medium text-gray-700 mb-2">Preview:</label>
          <div class="border border-gray-200 rounded-lg p-4">
            <img x-ref="preview" class="h-20 w-auto object-contain mx-auto" />
          </div>
        </div>

        <div class="flex items-center justify-between pt-4">
          <div class="text-sm text-gray-500">
            <p>• Format yang didukung: JPEG, PNG, JPG, GIF, SVG</p>
            <p>• Ukuran maksimal: 2MB</p>
            <p>• Logo akan ditampilkan di halaman login</p>
          </div>
          
          <div class="flex space-x-3">
            <button type="button" 
                    onclick="window.history.back()"
                    class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
              Batal
            </button>
            <button type="submit" 
                    :disabled="uploading"
                    :class="uploading ? 'opacity-50 cursor-not-allowed' : 'hover:bg-blue-700'"
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg transition-colors flex items-center gap-2">
              <div x-show="uploading" class="animate-spin rounded-full h-4 w-4 border-b-2 border-white"></div>
              <span x-text="uploading ? 'Mengupload...' : 'Upload Logo'"></span>
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
// Loading functions
function showLoading() {
  document.getElementById('loadingOverlay').classList.remove('hidden');
  startProgress();
}

function hideLoading() {
  document.getElementById('loadingOverlay').classList.add('hidden');
  resetProgress();
}

function startProgress() {
  const progressBar = document.getElementById('progressBar');
  const progressText = document.getElementById('progressText');
  const step1 = document.getElementById('step1');
  const step2 = document.getElementById('step2');
  const step3 = document.getElementById('step3');
  
  // Reset progress
  progressBar.style.width = '0%';
  progressText.textContent = 'Memulai upload...';
  
  // Step 1: Preparing file
  setTimeout(() => {
    progressBar.style.width = '30%';
    progressText.textContent = 'Menyiapkan file...';
    step1.classList.remove('opacity-50');
    step1.querySelector('div').classList.remove('bg-gray-300');
    step1.querySelector('div').classList.add('bg-blue-600');
  }, 500);
  
  // Step 2: Uploading to server
  setTimeout(() => {
    progressBar.style.width = '60%';
    progressText.textContent = 'Mengupload ke server...';
    step2.classList.remove('opacity-50');
    step2.querySelector('div').classList.remove('bg-gray-300');
    step2.querySelector('div').classList.add('bg-blue-600');
  }, 1500);
  
  // Step 3: Saving to database
  setTimeout(() => {
    progressBar.style.width = '90%';
    progressText.textContent = 'Menyimpan ke database...';
    step3.classList.remove('opacity-50');
    step3.querySelector('div').classList.remove('bg-gray-300');
    step3.querySelector('div').classList.add('bg-blue-600');
  }, 2500);
  
  // Complete
  setTimeout(() => {
    progressBar.style.width = '100%';
    progressText.textContent = 'Selesai!';
  }, 3500);
}

function resetProgress() {
  const progressBar = document.getElementById('progressBar');
  const progressText = document.getElementById('progressText');
  const step1 = document.getElementById('step1');
  const step2 = document.getElementById('step2');
  const step3 = document.getElementById('step3');
  
  progressBar.style.width = '0%';
  progressText.textContent = 'Memulai upload...';
  
  // Reset steps
  [step1, step2, step3].forEach(step => {
    step.classList.add('opacity-50');
    const dot = step.querySelector('div');
    dot.classList.remove('bg-blue-600');
    dot.classList.add('bg-gray-300');
  });
  
  step1.classList.remove('opacity-50');
  step1.querySelector('div').classList.remove('bg-gray-300');
  step1.querySelector('div').classList.add('bg-blue-600');
}

// Auto-hide loading after 5 seconds (fallback)
setTimeout(() => {
  hideLoading();
}, 5000);

document.addEventListener('alpine:init', () => {
  Alpine.data('logoUpload', () => ({
    files: null,
    init() {
      this.$watch('files', (files) => {
        if (files && files.length > 0) {
          const file = files[0];
          const reader = new FileReader();
          reader.onload = (e) => {
            this.$refs.preview.src = e.target.result;
          };
          reader.readAsDataURL(file);
        }
      });
    }
  }));
});

// Show success message after upload
@if(session('success'))
  document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
      icon: 'success',
      title: 'Berhasil!',
      text: '{{ session('success') }}',
      timer: 3000,
      showConfirmButton: false
    });
  });
@endif

// Show error message if any
@if(session('error'))
  document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
      icon: 'error',
      title: 'Gagal!',
      text: '{{ session('error') }}',
      confirmButtonText: 'OK'
    });
  });
@endif
</script>
@endsection
