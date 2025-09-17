<!-- Sidebar Component -->
<aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg transform -translate-x-full transition-transform duration-300 ease-in-out">
  <!-- Sidebar Header -->
  <div class="flex items-center justify-between p-6 border-b border-slate-200">
    <div class="flex items-center space-x-3">
      <img src="{{ asset('img/logo.jpg') }}" alt="Logo Puskomedia" class="w-8 h-8 rounded-lg" />
      <span class="text-lg font-semibold text-slate-800">Menu</span>
    </div>
    <!-- Close button -->
    <button id="closeSidebar" class="p-2 rounded-lg hover:bg-slate-100 transition-colors">
      <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
      </svg>
    </button>
  </div>

  <!-- User Profile Section -->
  <div class="p-6 border-b border-slate-200">
    <div class="text-center">
      <div class="w-20 h-20 mx-auto rounded-full overflow-hidden border-4 border-slate-200 shadow-lg mb-4">
        <img src="{{ auth()->user()->foto_profil ? asset('storage/' . auth()->user()->foto_profil) : asset('images/profile.png') }}" 
             alt="Foto Profil" class="w-full h-full object-cover">
      </div>
      <h3 class="text-lg font-semibold text-slate-800 mb-1">
        {{ auth()->user()->nama_lengkap }}
      </h3>
      <p class="text-sm text-slate-600 mb-2">
        {{ auth()->user()->email }}
      </p>
      <span class="inline-block text-xs bg-slate-100 text-slate-700 px-3 py-1 rounded-full">
        👤 Customer
      </span>
    </div>
  </div>

  <!-- Navigation Menu -->
  <nav class="p-6 space-y-2">
    <h4 class="text-sm font-semibold text-slate-500 uppercase tracking-wide mb-4">Profil</h4>
    
    <a href="{{ route('customer.edit-foto') }}" 
       class="flex items-center space-x-3 px-4 py-3 rounded-lg text-slate-700 hover:bg-slate-100 hover:text-slate-900 transition-colors group">
      <svg class="w-5 h-5 text-slate-500 group-hover:text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
      </svg>
      <span>Edit Foto</span>
    </a>

    <a href="{{ route('customer.edit-nama') }}" 
       class="flex items-center space-x-3 px-4 py-3 rounded-lg text-slate-700 hover:bg-slate-100 hover:text-slate-900 transition-colors group">
      <svg class="w-5 h-5 text-slate-500 group-hover:text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
      </svg>
      <span>Edit Nama</span>
    </a>

    <a href="{{ route('customer.edit-email') }}" 
       class="flex items-center space-x-3 px-4 py-3 rounded-lg text-slate-700 hover:bg-slate-100 hover:text-slate-900 transition-colors group">
      <svg class="w-5 h-5 text-slate-500 group-hover:text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
      </svg>
      <span>Edit Email</span>
    </a>

    <a href="{{ route('customer.edit-password') }}" 
       class="flex items-center space-x-3 px-4 py-3 rounded-lg text-slate-700 hover:bg-slate-100 hover:text-slate-900 transition-colors group">
      <svg class="w-5 h-5 text-slate-500 group-hover:text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
      </svg>
      <span>Edit Password</span>
    </a>

    <div class="pt-4 mt-4 border-t border-slate-200">
      <h4 class="text-sm font-semibold text-slate-500 uppercase tracking-wide mb-4">Laporan</h4>
      
      <a href="{{ route('customer.laporan.index') }}" 
         class="flex items-center space-x-3 px-4 py-3 rounded-lg text-slate-700 hover:bg-slate-100 hover:text-slate-900 transition-colors group">
        <svg class="w-5 h-5 text-slate-500 group-hover:text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        <span>Daftar Laporan</span>
      </a>

      <a href="{{ route('customer.laporan.create') }}" 
         class="flex items-center space-x-3 px-4 py-3 rounded-lg text-slate-700 hover:bg-slate-100 hover:text-slate-900 transition-colors group">
        <svg class="w-5 h-5 text-slate-500 group-hover:text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
        </svg>
        <span>Buat Laporan Baru</span>
      </a>
    </div>
  </nav>
</aside>

<!-- Overlay -->
<div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden"></div>
