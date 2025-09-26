@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
  <!-- Header Section -->
  <div class="bg-white shadow-sm border-b">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center py-6">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">⚙️ Pengaturan Website</h1>
          <p class="text-gray-600 mt-1">Kelola pengaturan umum website</p>
        </div>
        <div class="flex items-center space-x-4">
          <a href="{{ route('superadmin.dashboard') }}" 
             class="inline-flex items-center gap-2 px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg font-medium transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Dashboard
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Settings Form -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
      <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
        <h2 class="text-lg font-semibold text-gray-900">🌐 Informasi Website</h2>
        <p class="text-sm text-gray-600 mt-1">Atur nama, deskripsi, dan kontak WhatsApp untuk website</p>
      </div>

      <form action="{{ route('superadmin.website-settings.update') }}" method="POST" class="p-6">
        @csrf
        @method('PUT')

        <!-- Website Name -->
        <div class="mb-6">
          <label for="website_name" class="block text-sm font-medium text-gray-700 mb-2">
            Nama Website <span class="text-red-500">*</span>
          </label>
          <input type="text" 
                 id="website_name" 
                 name="website_name" 
                 value="{{ old('website_name', $settings->website_name) }}"
                 class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('website_name') border-red-500 @enderror"
                 placeholder="Masukkan nama website"
                 required>
          @error('website_name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <!-- Website Description -->
        <div class="mb-6">
          <label for="website_description" class="block text-sm font-medium text-gray-700 mb-2">
            Deskripsi Website
          </label>
          <textarea id="website_description" 
                    name="website_description" 
                    rows="4"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('website_description') border-red-500 @enderror"
                    placeholder="Masukkan deskripsi website">{{ old('website_description', $settings->website_description) }}</textarea>
          @error('website_description')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
          <p class="mt-1 text-sm text-gray-500">Maksimal 1000 karakter</p>
        </div>

        <!-- Contact Information Section -->
        <div class="mb-8">
          <h3 class="text-lg font-semibold text-gray-900 mb-4">📞 Informasi Kontak</h3>
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- WhatsApp CS -->
            <div>
              <label for="whatsapp_cs" class="block text-sm font-medium text-gray-700 mb-2">
                WhatsApp Customer Service
              </label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" clip-rule="evenodd"></path>
                  </svg>
                </div>
                <input type="text" 
                       id="whatsapp_cs" 
                       name="whatsapp_cs" 
                       value="{{ old('whatsapp_cs', $settings->whatsapp_cs) }}"
                       class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('whatsapp_cs') border-red-500 @enderror"
                       placeholder="+6281234567890">
              </div>
              @error('whatsapp_cs')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <!-- Phone 1 -->
            <div>
              <label for="phone_1" class="block text-sm font-medium text-gray-700 mb-2">
                Nomor HP 1
              </label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                  </svg>
                </div>
                <input type="text" 
                       id="phone_1" 
                       name="phone_1" 
                       value="{{ old('phone_1', $settings->phone_1) }}"
                       class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('phone_1') border-red-500 @enderror"
                       placeholder="081234567890">
              </div>
              @error('phone_1')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <!-- Phone 2 -->
            <div>
              <label for="phone_2" class="block text-sm font-medium text-gray-700 mb-2">
                Nomor HP 2
              </label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                  </svg>
                </div>
                <input type="text" 
                       id="phone_2" 
                       name="phone_2" 
                       value="{{ old('phone_2', $settings->phone_2) }}"
                       class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('phone_2') border-red-500 @enderror"
                       placeholder="081234567891">
              </div>
              @error('phone_2')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <!-- Email 1 -->
            <div>
              <label for="email_1" class="block text-sm font-medium text-gray-700 mb-2">
                Email 1
              </label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                  </svg>
                </div>
                <input type="email" 
                       id="email_1" 
                       name="email_1" 
                       value="{{ old('email_1', $settings->email_1) }}"
                       class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('email_1') border-red-500 @enderror"
                       placeholder="cs@puskomedia.com">
              </div>
              @error('email_1')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <!-- Email 2 -->
            <div>
              <label for="email_2" class="block text-sm font-medium text-gray-700 mb-2">
                Email 2
              </label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                  </svg>
                </div>
                <input type="email" 
                       id="email_2" 
                       name="email_2" 
                       value="{{ old('email_2', $settings->email_2) }}"
                       class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('email_2') border-red-500 @enderror"
                       placeholder="support@puskomedia.com">
              </div>
              @error('email_2')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <!-- Address -->
            <div class="md:col-span-2">
              <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                Alamat
              </label>
              <textarea id="address" 
                        name="address" 
                        rows="3"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('address') border-red-500 @enderror"
                        placeholder="Masukkan alamat lengkap">{{ old('address', $settings->address) }}</textarea>
              @error('address')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
        </div>
      </div>
    </div>

    <!-- Background Settings Section -->
    <div class="mb-8">
      <h3 class="text-lg font-semibold text-gray-900 mb-4">🎨 Pengaturan Background</h3>
      
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Background Type -->
        <div>
          <label for="background_type" class="block text-sm font-medium text-gray-700 mb-2">
            Tipe Background
          </label>
          <select id="background_type" 
                  name="background_type" 
                  class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('background_type') border-red-500 @enderror"
                  onchange="toggleBackgroundOptions()">
            <option value="gradient" {{ old('background_type', $settings->background_type) == 'gradient' ? 'selected' : '' }}>Gradient</option>
            <option value="image" {{ old('background_type', $settings->background_type) == 'image' ? 'selected' : '' }}>Gambar</option>
            <option value="solid" {{ old('background_type', $settings->background_type) == 'solid' ? 'selected' : '' }}>Warna Solid</option>
          </select>
          @error('background_type')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <!-- Background Color (for solid type) -->
        <div id="color-option" class="hidden">
          <label for="background_color" class="block text-sm font-medium text-gray-700 mb-2">
            Warna Background
          </label>
          <div class="flex items-center space-x-3">
            <input type="color" 
                   id="color-picker"
                   value="{{ old('background_color', $settings->background_color) ?: '#3B82F6' }}"
                   class="w-12 h-12 border border-gray-300 rounded-lg cursor-pointer">
            <input type="text" 
                   id="background_color" 
                   name="background_color" 
                   value="{{ old('background_color', $settings->background_color) }}"
                   placeholder="#3B82F6"
                   class="flex-1 px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('background_color') border-red-500 @enderror">
          </div>
          @error('background_color')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
          <p class="mt-1 text-sm text-gray-500">Format: #RRGGBB (contoh: #3B82F6)</p>
        </div>

        <!-- Background Image (for image type) -->
        <div id="image-option" class="hidden">
          <label for="background_image" class="block text-sm font-medium text-gray-700 mb-2">
            Upload Gambar Background
          </label>
          <div class="flex items-center space-x-4">
            <input type="file" 
                   id="background_image" 
                   name="background_image" 
                   accept="image/*"
                   class="flex-1 px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('background_image') border-red-500 @enderror">
            @if($settings->background_image)
              <div class="w-16 h-16 rounded-lg overflow-hidden border-2 border-gray-200">
                <img src="{{ asset('storage/' . $settings->background_image) }}" 
                     alt="Current background" 
                     class="w-full h-full object-cover">
              </div>
            @endif
          </div>
          @error('background_image')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
          <p class="mt-1 text-sm text-gray-500">Format: JPEG, PNG, JPG, GIF, WebP (maksimal 5MB)</p>
        </div>
      </div>

      <!-- Background Preview -->
      <div class="mt-6">
        <label class="block text-sm font-medium text-gray-700 mb-2">Preview Background</label>
        <div id="background-preview" 
             class="w-full h-32 rounded-lg border-2 border-gray-200 overflow-hidden relative">
          <div class="absolute inset-0 flex items-center justify-center text-white font-semibold">
            Preview Background
          </div>
        </div>
      </div>
    </div>

    <!-- Action Buttons -->
        <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
          <a href="{{ route('superadmin.dashboard') }}" 
             class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors font-medium">
            Batal
          </a>
          <button type="submit" 
                  class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            Simpan Pengaturan
          </button>
        </div>
      </form>
    </div>

    <!-- Current Settings Preview -->
    <div class="mt-8 bg-white rounded-xl shadow-lg overflow-hidden">
      <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
        <h3 class="text-lg font-semibold text-gray-900">👁️ Preview Pengaturan Saat Ini</h3>
      </div>
      <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div class="bg-blue-50 rounded-lg p-4">
            <h4 class="font-medium text-blue-900 mb-2">Nama Website</h4>
            <p class="text-blue-700">{{ $settings->website_name }}</p>
          </div>
          <div class="bg-green-50 rounded-lg p-4">
            <h4 class="font-medium text-green-900 mb-2">Deskripsi</h4>
            <p class="text-green-700">{{ $settings->website_description ?: 'Belum diatur' }}</p>
          </div>
          <div class="bg-purple-50 rounded-lg p-4">
            <h4 class="font-medium text-purple-900 mb-2">WhatsApp CS</h4>
            <p class="text-purple-700">{{ $settings->whatsapp_cs ?: 'Belum diatur' }}</p>
          </div>
          <div class="bg-orange-50 rounded-lg p-4">
            <h4 class="font-medium text-orange-900 mb-2">HP 1</h4>
            <p class="text-orange-700">{{ $settings->phone_1 ?: 'Belum diatur' }}</p>
          </div>
          <div class="bg-red-50 rounded-lg p-4">
            <h4 class="font-medium text-red-900 mb-2">HP 2</h4>
            <p class="text-red-700">{{ $settings->phone_2 ?: 'Belum diatur' }}</p>
          </div>
          <div class="bg-indigo-50 rounded-lg p-4">
            <h4 class="font-medium text-indigo-900 mb-2">Email 1</h4>
            <p class="text-indigo-700">{{ $settings->email_1 ?: 'Belum diatur' }}</p>
          </div>
          <div class="bg-pink-50 rounded-lg p-4">
            <h4 class="font-medium text-pink-900 mb-2">Email 2</h4>
            <p class="text-pink-700">{{ $settings->email_2 ?: 'Belum diatur' }}</p>
          </div>
          <div class="bg-gray-50 rounded-lg p-4 md:col-span-2 lg:col-span-1">
            <h4 class="font-medium text-gray-900 mb-2">Alamat</h4>
            <p class="text-gray-700">{{ $settings->address ?: 'Belum diatur' }}</p>
          </div>
        </div>
        
        <!-- Background Settings Preview -->
        <div class="mt-6">
          <h3 class="text-lg font-semibold text-gray-900 mb-4">🎨 Preview Background</h3>
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-gray-50 rounded-lg p-4">
              <h4 class="font-medium text-gray-900 mb-2">Tipe Background</h4>
              <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                {{ ucfirst($settings->background_type) }}
              </span>
            </div>
            @if($settings->background_type === 'solid' && $settings->background_color)
              <div class="bg-gray-50 rounded-lg p-4">
                <h4 class="font-medium text-gray-900 mb-2">Warna</h4>
                <div class="flex items-center space-x-2">
                  <div class="w-6 h-6 rounded border border-gray-300" style="background-color: {{ $settings->background_color }}"></div>
                  <span class="text-sm text-gray-700">{{ $settings->background_color }}</span>
                </div>
              </div>
            @endif
            @if($settings->background_type === 'image' && $settings->background_image)
              <div class="bg-gray-50 rounded-lg p-4">
                <h4 class="font-medium text-gray-900 mb-2">Gambar</h4>
                <div class="w-16 h-16 rounded-lg overflow-hidden border-2 border-gray-200">
                  <img src="{{ asset('storage/' . $settings->background_image) }}" 
                       alt="Background preview" 
                       class="w-full h-full object-cover">
                </div>
              </div>
            @endif
          </div>
          
          <!-- Live Background Preview -->
          <div class="mt-4">
            <h4 class="font-medium text-gray-900 mb-2">Live Preview</h4>
            <div class="w-full h-24 rounded-lg border-2 border-gray-200 overflow-hidden relative"
                 style="
                   @if($settings->background_type === 'gradient')
                     background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                   @elseif($settings->background_type === 'solid' && $settings->background_color)
                     background: {{ $settings->background_color }};
                   @elseif($settings->background_type === 'image' && $settings->background_image)
                     background-image: url('{{ asset('storage/' . $settings->background_image) }}');
                     background-size: cover;
                     background-position: center;
                   @else
                     background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                   @endif
                 ">
              <div class="absolute inset-0 flex items-center justify-center text-white font-semibold text-sm">
                Background Preview
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Success/Error Notifications -->
<script>
// Background Settings JavaScript
function toggleBackgroundOptions() {
  const backgroundType = document.getElementById('background_type').value;
  const colorOption = document.getElementById('color-option');
  const imageOption = document.getElementById('image-option');
  
  // Hide all options first
  colorOption.classList.add('hidden');
  imageOption.classList.add('hidden');
  
  // Show relevant option
  if (backgroundType === 'solid') {
    colorOption.classList.remove('hidden');
  } else if (backgroundType === 'image') {
    imageOption.classList.remove('hidden');
  }
  
  // Update preview
  updateBackgroundPreview();
}

function updateBackgroundPreview() {
  const backgroundType = document.getElementById('background_type').value;
  const preview = document.getElementById('background-preview');
  const colorInput = document.getElementById('background_color');
  const colorPicker = document.getElementById('color-picker');
  const imageInput = document.getElementById('background_image');
  
  // Reset preview
  preview.style.background = '';
  preview.style.backgroundImage = '';
  
  if (backgroundType === 'gradient') {
    preview.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
  } else if (backgroundType === 'solid') {
    const color = colorInput.value || colorPicker.value || '#3B82F6';
    preview.style.background = color;
  } else if (backgroundType === 'image') {
    if (imageInput.files && imageInput.files[0]) {
      const reader = new FileReader();
      reader.onload = function(e) {
        preview.style.backgroundImage = `url(${e.target.result})`;
        preview.style.backgroundSize = 'cover';
        preview.style.backgroundPosition = 'center';
      };
      reader.readAsDataURL(imageInput.files[0]);
    } else {
      // Show current image if exists
      const currentImage = '{{ $settings->background_image ? asset("storage/" . $settings->background_image) : "" }}';
      if (currentImage) {
        preview.style.backgroundImage = `url(${currentImage})`;
        preview.style.backgroundSize = 'cover';
        preview.style.backgroundPosition = 'center';
      }
    }
  }
}

// Sync color picker with text input
document.getElementById('color-picker').addEventListener('input', function() {
  document.getElementById('background_color').value = this.value;
  updateBackgroundPreview();
});

// Sync text input with color picker
document.getElementById('background_color').addEventListener('input', function() {
  if (this.value.match(/^#[0-9A-Fa-f]{6}$/)) {
    document.getElementById('color-picker').value = this.value;
    updateBackgroundPreview();
  }
});

// Update preview when image changes
document.getElementById('background_image').addEventListener('change', function() {
  updateBackgroundPreview();
});

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
  toggleBackgroundOptions();
  updateBackgroundPreview();
});
</script>

<script>
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
