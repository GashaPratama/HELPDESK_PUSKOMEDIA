@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-8">
  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <!-- Header -->
    <div class="mb-8">
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">✏️ Edit Profil</h1>
          <p class="mt-2 text-gray-600">Kelola informasi pribadi dan keamanan akun Anda</p>
        </div>
        <a href="{{ $backUrl }}" 
           class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium text-gray-700 transition-colors">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
          </svg>
          Kembali
        </a>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      
      <!-- Profile Photo Section -->
      <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-lg p-6">
          <h2 class="text-xl font-semibold text-gray-900 mb-4">Foto Profil</h2>
          
          <div class="text-center">
            @if($user->foto_profil)
              <img src="{{ asset('storage/' . $user->foto_profil) }}" 
                   alt="Foto Profil" 
                   class="w-32 h-32 rounded-full mx-auto mb-4 object-cover border-4 border-gray-200">
            @else
              <div class="w-32 h-32 rounded-full mx-auto mb-4 bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center border-4 border-gray-200">
                <span class="text-white font-bold text-4xl">{{ substr($user->nama_lengkap, 0, 1) }}</span>
              </div>
            @endif
            
            <p class="text-sm text-gray-600 mb-4">
              @if($user->foto_profil)
                Foto profil saat ini
              @else
                Belum ada foto profil
              @endif
            </p>
            
            @if($user->foto_profil)
              <form action="{{ route('profile.delete-photo') }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        onclick="return confirm('Apakah Anda yakin ingin menghapus foto profil?')"
                        class="text-red-600 hover:text-red-800 text-sm font-medium">
                  Hapus Foto
                </button>
              </form>
            @endif
          </div>
        </div>
      </div>

      <!-- Profile Information Section -->
      <div class="lg:col-span-2">
        
        <!-- Personal Information Form -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
          <h2 class="text-xl font-semibold text-gray-900 mb-4">Informasi Pribadi</h2>
          
          <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Nama Lengkap -->
              <div class="md:col-span-2">
                <label for="nama_lengkap" class="block text-sm font-medium text-gray-700 mb-2">
                  Nama Lengkap <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="nama_lengkap" 
                       name="nama_lengkap" 
                       value="{{ old('nama_lengkap', $user->nama_lengkap) }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('nama_lengkap') border-red-500 @enderror"
                       placeholder="Masukkan nama lengkap">
                @error('nama_lengkap')
                  <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>

              <!-- Email -->
              <div class="md:col-span-2">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                  Email <span class="text-red-500">*</span>
                </label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="{{ old('email', $user->email) }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('email') border-red-500 @enderror"
                       placeholder="Masukkan email">
                @error('email')
                  <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>

              <!-- No Telepon -->
              <div>
                <label for="no_telpon" class="block text-sm font-medium text-gray-700 mb-2">
                  Nomor Telepon
                </label>
                <input type="text" 
                       id="no_telpon" 
                       name="no_telpon" 
                       value="{{ old('no_telpon', $user->no_telpon) }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('no_telpon') border-red-500 @enderror"
                       placeholder="Masukkan nomor telepon">
                @error('no_telpon')
                  <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>

              <!-- Jenis Kelamin -->
              <div>
                <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-2">
                  Jenis Kelamin
                </label>
                <select id="jenis_kelamin" 
                        name="jenis_kelamin"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('jenis_kelamin') border-red-500 @enderror">
                  <option value="">Pilih jenis kelamin</option>
                  <option value="Laki-laki" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                  <option value="Perempuan" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin')
                  <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>

              <!-- Tanggal Lahir -->
              <div>
                <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-2">
                  Tanggal Lahir
                </label>
                <input type="date" 
                       id="tanggal_lahir" 
                       name="tanggal_lahir" 
                       value="{{ old('tanggal_lahir', $user->tanggal_lahir) }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('tanggal_lahir') border-red-500 @enderror">
                @error('tanggal_lahir')
                  <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>

              <!-- Upload Foto -->
              <div>
                <label for="foto_profil" class="block text-sm font-medium text-gray-700 mb-2">
                  Upload Foto Profil
                </label>
                <input type="file" 
                       id="foto_profil" 
                       name="foto_profil" 
                       accept="image/*"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('foto_profil') border-red-500 @enderror">
                <p class="mt-1 text-xs text-gray-500">Format: JPEG, PNG, JPG, GIF. Maksimal 2MB</p>
                @error('foto_profil')
                  <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>
            </div>

            <!-- Alamat -->
            <div>
              <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">
                Alamat
              </label>
              <textarea id="alamat" 
                        name="alamat" 
                        rows="3"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('alamat') border-red-500 @enderror"
                        placeholder="Masukkan alamat lengkap">{{ old('alamat', $user->alamat) }}</textarea>
              @error('alamat')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end space-x-3">
              <a href="{{ $backUrl }}" 
                 class="px-4 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors font-medium">
                Batal
              </a>
              <button type="submit" 
                      class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                Simpan Perubahan
              </button>
            </div>
          </form>
        </div>

        <!-- Password Change Form -->
        <div class="bg-white rounded-xl shadow-lg p-6">
          <h2 class="text-xl font-semibold text-gray-900 mb-4">Ubah Password</h2>
          
          <form action="{{ route('profile.update-password') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Current Password -->
              <div>
                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                  Password Lama <span class="text-red-500">*</span>
                </label>
                <input type="password" 
                       id="current_password" 
                       name="current_password" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('current_password') border-red-500 @enderror"
                       placeholder="Masukkan password lama">
                @error('current_password')
                  <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>

              <!-- New Password -->
              <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                  Password Baru <span class="text-red-500">*</span>
                </label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('password') border-red-500 @enderror"
                       placeholder="Masukkan password baru">
                @error('password')
                  <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
              </div>

              <!-- Confirm Password -->
              <div class="md:col-span-2">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                  Konfirmasi Password Baru <span class="text-red-500">*</span>
                </label>
                <input type="password" 
                       id="password_confirmation" 
                       name="password_confirmation" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                       placeholder="Konfirmasi password baru">
              </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end space-x-3">
              <a href="{{ $backUrl }}" 
                 class="px-4 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors font-medium">
                Batal
              </a>
              <button type="submit" 
                      class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium">
                Ubah Password
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Account Information -->
    <div class="mt-8 bg-white rounded-xl shadow-lg p-6">
      <h2 class="text-xl font-semibold text-gray-900 mb-4">Informasi Akun</h2>
      
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gray-50 rounded-lg p-4">
          <h3 class="text-sm font-medium text-gray-500 mb-2">Role</h3>
          <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
            {{ ucfirst(str_replace('_', ' ', $user->role)) }}
          </span>
        </div>
        
        <div class="bg-gray-50 rounded-lg p-4">
          <h3 class="text-sm font-medium text-gray-500 mb-2">Tanggal Registrasi</h3>
          <p class="text-sm font-medium text-gray-900">
            {{ $user->created_at ? $user->created_at->format('d M Y H:i') : 'N/A' }}
          </p>
        </div>
        
        <div class="bg-gray-50 rounded-lg p-4">
          <h3 class="text-sm font-medium text-gray-500 mb-2">Terakhir Update</h3>
          <p class="text-sm font-medium text-gray-900">
            {{ $user->updated_at ? $user->updated_at->format('d M Y H:i') : 'N/A' }}
          </p>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
// Success notifications
@if(session('success'))
  document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
      icon: 'success',
      title: 'Berhasil!',
      text: '{{ session('success') }}',
      timer: 3000,
      showConfirmButton: false,
      toast: true,
      position: 'top-end'
    });
  });
@endif

// Error notifications
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

// Photo preview
document.getElementById('foto_profil').addEventListener('change', function(e) {
  const file = e.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function(e) {
      // Update preview in photo section
      const preview = document.querySelector('.w-32.h-32');
      if (preview) {
        preview.innerHTML = `<img src="${e.target.result}" alt="Preview" class="w-full h-full rounded-full object-cover">`;
      }
    };
    reader.readAsDataURL(file);
  }
});

// Form validation
document.addEventListener('DOMContentLoaded', function() {
  const forms = document.querySelectorAll('form');
  
  forms.forEach(form => {
    form.addEventListener('submit', function(e) {
      const submitBtn = form.querySelector('button[type="submit"]');
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<div class="animate-spin rounded-full h-4 w-4 border-b-2 border-white mr-2"></div>Memproses...';
      }
    });
  });
});
</script>
@endsection
