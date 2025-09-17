<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard Customer - Puskomedia Helpdesk</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  
  <style>
    body { font-family: 'Inter', sans-serif; }
    .gradient-bg { background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); }
    .card-shadow { box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); }
    .card-hover { transition: all 0.3s ease; }
    .card-hover:hover { transform: translateY(-2px); box-shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); }
  </style>
</head>
<body class="min-h-screen gradient-bg font-sans">

  <!-- Header -->
  <header class="bg-white/90 backdrop-blur-sm border-b border-slate-200 shadow-sm sticky top-0 z-40">
    <div class="w-full px-4 sm:px-6">
      <div class="flex items-center justify-between h-16">
        <!-- Left Section -->
        <div class="flex items-center space-x-4">
          <!-- Toggle Sidebar Button -->
          <button id="toggleSidebar" class="p-2 rounded-lg hover:bg-slate-100 transition-colors focus:outline-none focus:ring-2 focus:ring-slate-300">
            <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
          </button>
          
          <!-- Logo and Brand -->
          <div class="flex items-center space-x-3">
            <img src="{{ asset('img/logo.jpg') }}" alt="Logo Puskomedia" class="w-8 h-8 rounded-lg" />
            <div class="hidden sm:block">
              <h1 class="text-lg font-semibold text-slate-800">Puskomedia Helpdesk</h1>
            </div>
          </div>
        </div>

        <!-- Center Section - Welcome Message (Mobile) -->
        <div class="flex-1 text-center sm:hidden">
          <p class="text-sm text-slate-600 truncate">Selamat datang, {{ auth()->user()->nama_lengkap }}</p>
        </div>

        <!-- Right Section -->
        <div class="flex items-center space-x-3">
          <!-- Welcome Message (Desktop) -->
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

  <!-- Layout -->
  <div class="flex min-h-screen">
    <!-- Sidebar Component -->
    @include('components.sidebar')

    <!-- Main Content -->
    <main class="flex-1 p-6">

      <!-- Section: Lapor -->
      <section class="mb-12">
        <h3 class="text-xl font-bold mb-4">Lapor</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
         <a href="{{ route('customer.laporan.create') }}" class="bg-white p-4 rounded shadow hover:bg-blue-50 block text-center">
   Add Laporan
</a>
        </div>
        <p class="text-sm mt-4 text-gray-600 leading-relaxed">
          ➤ Isian Laporan, Kategori, URL situs, Kendala, Foto/Video, Status laporan.<br>
          ➤ Akan diberi ID Ticket (generate by system).
        </p>
      </section>

<!-- Section: Laporan Saya -->
<section class="mt-12">
  <h3 class="text-xl font-bold mb-4">📋 Laporan Saya</h3>

  @if($laporan->isEmpty())
    <p class="text-gray-500">Belum ada laporan yang dikirim.</p>
  @else
    <div class="bg-white shadow rounded overflow-hidden">
<table class="min-w-full text-sm">
  <thead class="bg-blue-100 text-left">
    <tr>
      <th class="px-4 py-2">ID Ticket</th>
      <th class="px-4 py-2">Kategori</th>
      <th class="px-4 py-2">Kendala</th>
      <th class="px-4 py-2">Status</th>
      <th class="px-4 py-2">Tanggal</th>
      <th class="px-4 py-2">Aksi</th>
    </tr>
  </thead>
  <tbody>
    @foreach($laporan as $item)
      <tr class="border-b hover:bg-gray-50">
        <td class="px-4 py-2">{{ $item->id }}</td>
        <td class="px-4 py-2">
        {{ json_decode($item->kategori)->nama ?? '-' }}
        </td>
        <td class="px-4 py-2">{{ Str::limit($item->kendala, 30) }}</td>
        <td class="px-4 py-2">
          <span class="inline-block px-2 py-1 text-xs bg-blue-200 text-blue-800 rounded">
            {{ $item->status }}
          </span>
        </td>
        <td class="px-4 py-2">{{ $item->created_at->format('d M Y') }}</td>
        <td class="px-4 py-2 flex gap-2">
          <!-- Tombol Edit -->
          <a href="{{ route('customer.laporan.edit', $item->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 text-xs rounded shadow">
            ✏️ Edit
          </a>

          <!-- Tombol Delete -->
          <form action="{{ route('customer.laporan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus laporan ini?');">
              @csrf
              @method('DELETE')
              <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 text-xs rounded shadow">
                  🗑️ Hapus
              </button>
          </form>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>

    </div>
  @endif
</section>

    </main>
  </div>

  <script>
    // Sidebar Toggle Functionality
    document.addEventListener('DOMContentLoaded', function() {
      const toggleSidebar = document.getElementById('toggleSidebar');
      const sidebar = document.getElementById('sidebar');
      const sidebarOverlay = document.getElementById('sidebarOverlay');
      const closeSidebar = document.getElementById('closeSidebar');

      // Toggle sidebar
      function toggleSidebarFunction() {
        sidebar.classList.toggle('-translate-x-full');
        sidebarOverlay.classList.toggle('hidden');
        
        // Prevent body scroll when sidebar is open on mobile
        if (sidebar.classList.contains('-translate-x-full')) {
          document.body.style.overflow = 'auto';
        } else {
          document.body.style.overflow = 'hidden';
        }
      }

      // Close sidebar
      function closeSidebarFunction() {
        sidebar.classList.add('-translate-x-full');
        sidebarOverlay.classList.add('hidden');
        document.body.style.overflow = 'auto';
      }

      // Event listeners
      if (toggleSidebar) {
        toggleSidebar.addEventListener('click', toggleSidebarFunction);
      }

      if (closeSidebar) {
        closeSidebar.addEventListener('click', closeSidebarFunction);
      }

      if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', closeSidebarFunction);
      }

      // Close sidebar on escape key
      document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !sidebar.classList.contains('-translate-x-full')) {
          closeSidebarFunction();
        }
      });

      // Handle window resize
      window.addEventListener('resize', function() {
        // Keep current sidebar state on resize
        // No automatic behavior change based on screen size
      });
    });
  </script>

</body>
</html>
