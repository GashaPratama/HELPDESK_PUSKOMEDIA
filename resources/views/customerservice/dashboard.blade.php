@extends('layouts.app')

@section('title', 'Kelola Tiket - Customer Service')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100" 
     x-data="{open:false, current:{id:null, kategori:'', deskripsi:'', status:'', link:'', customer:'', created_at:''}, selectedTickets: [], deleteSelectedTickets() { window.deleteSelectedTickets(); }}"
     x-init="open = false; console.log('Modal initialized and closed')">
  <!-- White Header Section -->
  <div class="bg-white border-b border-gray-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Page Title Section -->
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Dashboard Customer Service</h1>
          <p class="text-gray-600 mt-1">Selamat datang, {{ auth()->user()->nama_lengkap ?? auth()->user()->name }}! 👋</p>
        </div>
        <div class="flex items-center space-x-4">
          <!-- Arsip Tiket Button -->
          <a href="{{ route('cs.archive.index') }}" 
             class="inline-flex items-center gap-2 px-3 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg font-medium transition-all duration-200 hover:scale-105 text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
            </svg>
            Arsip Tiket
          </a>
          
          <button onclick="openDeleteAllModal()" 
                  class="inline-flex items-center gap-2 px-3 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-all duration-200 hover:scale-105 text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Delete All
          </button>
          
          <!-- Edit Profil Button -->
          <a href="{{ route('profile.edit') }}" 
             class="inline-flex items-center gap-2 px-3 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium text-gray-700 transition-all duration-200 hover:scale-105 text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            Edit Profil
          </a>
          
          <!-- User Profile Info -->
          <div class="flex items-center space-x-3">
            <!-- User Info -->
            <div class="text-right">
              <div class="text-sm font-medium text-gray-900">{{ auth()->user()->nama_lengkap ?? auth()->user()->name }}</div>
              <div class="text-xs text-gray-500">{{ ucfirst(str_replace('_', ' ', auth()->user()->role)) }}</div>
            </div>
            
            <!-- Profile Avatar -->
            @if(auth()->user()->foto_profil)
              <img src="{{ asset('storage/' . auth()->user()->foto_profil) }}" 
                   alt="Profile" 
                   class="w-10 h-10 rounded-full object-cover border-2 border-gray-200 hover:scale-110 transition-transform duration-200">
            @else
              <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center hover:scale-110 transition-transform duration-200">
                <span class="text-white font-bold text-lg">{{ substr(auth()->user()->nama_lengkap ?? auth()->user()->name, 0, 1) }}</span>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    @if(session('success'))
        <div class="mb-6 p-4 rounded-lg bg-green-50 border border-green-400 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <!-- Stats Cards -->
    @php
      $totalLaporan = $laporans->count();
      $laporanDiproses = $laporans->where('status', 'Diproses')->count();
      $laporanSelesai = $laporans->where('status', 'Selesai')->count();
      $laporanDitolak = $laporans->where('status', 'Ditolak')->count();
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
      <!-- Total Tiket -->
      <div class="bg-white rounded-lg shadow hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 p-6">
        <div class="flex items-center">
          <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
          </div>
          <div>
            <p class="text-sm font-medium text-gray-600">Total Tiket</p>
            <p class="text-2xl font-bold text-gray-900" data-count="total">{{ $totalLaporan }}</p>
          </div>
        </div>
      </div>

      <!-- Diproses -->
      <div class="bg-white rounded-lg shadow hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 p-6">
        <div class="flex items-center">
          <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mr-4">
            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
          <div>
            <p class="text-sm font-medium text-gray-600">Diproses</p>
            <p class="text-2xl font-bold text-gray-900" data-count="diproses">{{ $laporanDiproses }}</p>
          </div>
        </div>
      </div>

      <!-- Selesai -->
      <div class="bg-white rounded-lg shadow hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 p-6">
        <div class="flex items-center">
          <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
          </div>
          <div>
            <p class="text-sm font-medium text-gray-600">Selesai</p>
            <p class="text-2xl font-bold text-gray-900" data-count="selesai">{{ $laporanSelesai }}</p>
          </div>
        </div>
      </div>

      <!-- Ditolak -->
      <div class="bg-white rounded-lg shadow hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 p-6">
        <div class="flex items-center">
          <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mr-4">
            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </div>
          <div>
            <p class="text-sm font-medium text-gray-600">Ditolak</p>
            <p class="text-2xl font-bold text-gray-900" data-count="ditolak">{{ $laporanDitolak }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Filter & Search -->
    <div class="bg-white rounded-lg shadow hover:shadow-lg transition-all duration-300 p-6 mb-8">
      <h3 class="text-lg font-semibold text-gray-900 mb-4">Filter & Pencarian</h3>
      <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Cari Tiket</label>
          <div class="relative">
            <input type="text" 
                   id="searchInput"
                   placeholder="Cari berdasarkan ID, URL, atau Deskripsi..." 
                   class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-blue-400 focus:scale-105">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
              </svg>
            </div>
          </div>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
          <select id="statusFilter" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-blue-400 focus:scale-105">
            <option value="">Semua Status</option>
            <option value="Diproses">Diproses</option>
            <option value="Selesai">Selesai</option>
            <option value="Ditolak">Ditolak</option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
          <select id="kategoriFilter" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-blue-400 focus:scale-105">
            <option value="">Semua Kategori</option>
            @foreach(\App\Models\Kategori::all() as $kategori)
              <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
            @endforeach
          </select>
        </div>
            <div class="flex items-end">
              <button onclick="window.location.reload()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium flex items-center gap-2 transition-all duration-200 hover:scale-105 hover:shadow-lg">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Refresh
              </button>
            </div>
      </div>
    </div>

    <!-- Daftar Tiket -->
    <div class="bg-white rounded-lg shadow hover:shadow-lg transition-all duration-300">
      <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
          <h3 class="text-lg font-semibold text-gray-900">Daftar Tiket</h3>
          <div class="flex items-center space-x-4">
            <a href="{{ route('cs.laporan.export') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium flex items-center gap-2 transition-all duration-200 hover:scale-105 hover:shadow-lg">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
              </svg>
              Export
            </a>
          </div>
        </div>
      </div>
      
      @if($laporans->isEmpty())
        <div class="px-6 py-12 text-center text-gray-500">
          <div class="flex flex-col items-center">
            <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <p class="text-lg font-medium mb-2">Belum ada tiket</p>
            <p class="text-sm">Tiket dari customer akan muncul di sini</p>
          </div>
        </div>
      @else
    <!-- Bulk Actions -->
    <div id="bulkActions" style="display: none;" 
         class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
          <div class="flex items-center justify-between">
            <div class="flex items-center">
              <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              <span class="text-sm font-medium text-blue-800">
                <span x-text="selectedTickets.length"></span> tiket dipilih
              </span>
            </div>
            <div class="flex items-center space-x-2">
              <button @click="deleteSelectedTickets()" class="px-3 py-1 text-xs bg-red-600 text-white rounded hover:bg-red-700 transition-colors">
                Hapus ke Arsip
              </button>
              <button @click="selectedTickets = []" class="px-3 py-1 text-xs bg-gray-500 text-white rounded hover:bg-gray-600 transition-colors">
                Batal
              </button>
            </div>
          </div>
        </div>

        <div class="overflow-x-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
          <table id="ticket-table" class="min-w-full divide-y divide-gray-200" style="min-width: 800px;">
            <thead class="bg-gray-50">
              <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 hover:scale-110 transition-transform duration-200" onchange="toggleAllCheckboxes()">
                    </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">TICKET ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CUSTOMER</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">KATEGORI</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">KENDALA</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">FOTO</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">STATUS</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">TANGGAL</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">AKSI</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              @foreach($laporans as $laporan)
                <tr class="hover:bg-gray-50 transition-colors duration-200">
                  <td class="px-6 py-4 whitespace-nowrap">
                    <input type="checkbox" name="selected_tickets[]" value="{{ $laporan->id }}" class="ticket-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500 hover:scale-110 transition-transform duration-200" onchange="updateSelectAllCheckbox()">
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    #{{ $laporan->ticket_id ?? $laporan->id }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    <div class="flex items-center">
                      <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center mr-3 hover:scale-110 transition-transform duration-200">
                        <span class="text-xs font-medium text-gray-600">
                          {{ substr($laporan->customer->nama_lengkap ?? 'N/A', 0, 1) }}
                        </span>
                      </div>
                      <div>
                        <div class="font-medium">{{ $laporan->customer->nama_lengkap ?? 'N/A' }}</div>
                        <div class="text-xs text-gray-500">{{ $laporan->customer->email ?? 'N/A' }}</div>
                      </div>
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap" data-kategori-id="{{ $laporan->kategori->id ?? '' }}">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 hover:bg-blue-200 transition-colors duration-200">
                      {{ $laporan->kategori->nama ?? 'Tidak ada kategori' }}
                    </span>
                        </td>
                  <td class="px-6 py-4 text-sm text-gray-900">
                    <div class="max-w-xs break-all">
                      {{ $laporan->kendala }}
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    @if($laporan->foto)
                      <div class="flex items-center">
                        <img src="{{ asset('storage/' . $laporan->foto) }}" 
                             alt="Foto Bukti" 
                             class="w-12 h-12 rounded-lg object-cover border border-gray-200 hover:scale-110 transition-transform duration-200 cursor-pointer"
                             onclick="openPhotoModal('{{ asset('storage/' . $laporan->foto) }}')">
                      </div>
                    @else
                      <span class="text-gray-400 text-sm">Tidak ada foto</span>
                    @endif
                        </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    @php
                      $status = $laporan->status ?? 'Unknown';
                      $statusColors = [
                        'Diproses' => 'bg-yellow-100 text-yellow-800',
                        'Selesai' => 'bg-green-100 text-green-800',
                        'Ditolak' => 'bg-red-100 text-red-800',
                      ];
                      $colorClass = $statusColors[$status] ?? 'bg-gray-100 text-gray-800';
                    @endphp
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $colorClass }} hover:scale-105 transition-transform duration-200">
                    {{ $status }}
                  </span>
                        </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $laporan->created_at->format('d M Y H:i') }}
                        </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <div class="flex items-center space-x-2">
                      <!-- Dropdown Status -->
                      <form action="{{ route('cs.laporan.update', $laporan->id) }}" method="POST" class="inline">
                                @csrf
                        <input type="hidden" name="notes" value="{{ $laporan->notes ?? '' }}">
                        <input type="hidden" name="assigned_to" value="{{ $laporan->assigned_to ?? '' }}">
                        <select name="status" onchange="this.form.submit()" 
                                class="text-xs border-gray-300 rounded px-2 py-1 focus:ring-blue-500 focus:border-blue-500">
                          <option value="Diproses" {{ $laporan->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                          <option value="Selesai" {{ $laporan->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                          <option value="Ditolak" {{ $laporan->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                            </form>
                      
                      <!-- Button Mata untuk Detail -->
                      <button
                        type="button"
                        class="text-blue-600 hover:text-blue-900 transition-colors duration-200"
                        onclick="openTicketDetail('{{ $laporan->ticket_id ?? $laporan->id }}', '{{ $laporan->kategori->nama ?? '-' }}', '{{ addslashes($laporan->kendala ?? '-') }}', '{{ $laporan->status ?? '-' }}', '{{ $laporan->url_situs ?? '' }}', '{{ $laporan->customer->nama_lengkap ?? 'N/A' }}', '{{ $laporan->created_at ? $laporan->created_at->format('d M Y H:i') : '-' }}')"
                      >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                      </button>
                      
                      <!-- Button Note -->
                      <button onclick="openNoteModal('{{ $laporan->ticket_id ?? $laporan->id }}', '{{ $laporan->note ?? '' }}', '{{ $laporan->note_target_role ?? '' }}')" 
                              class="text-purple-600 hover:text-purple-900 text-xs bg-purple-100 hover:bg-purple-200 px-2 py-1 rounded transition-colors duration-200">
                        Note
                      </button>
                      
                      <!-- Button Assign -->
                      <button onclick="openAssignModal('{{ $laporan->ticket_id ?? $laporan->id }}', '{{ $laporan->assigned_to ?? '' }}')" 
                              class="text-green-600 hover:text-green-900 text-xs bg-green-100 hover:bg-green-200 px-2 py-1 rounded transition-colors duration-200">
                        Assign
                      </button>
                    </div>
                        </td>
                    </tr>
              @endforeach
            </tbody>
        </table>
        </div>
      @endif
    </div>
    </div>
</div>

<!-- Modal Detail Tiket -->
<div id="ticketDetailModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
  <div class="bg-white max-w-2xl w-full rounded-xl shadow-2xl p-6 sm:p-8 relative max-h-[90vh] overflow-y-auto">
    <!-- Close Button -->
    <button
      onclick="closeTicketDetail()"
      aria-label="Tutup modal"
      class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-full p-1"
    >
      <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
      </svg>
    </button>

    <!-- Header -->
    <div class="mb-6">
      <h2 id="modal-title" class="text-2xl font-bold text-gray-900 mb-2">
        Detail Tiket #<span id="modal-ticket-id"></span>
      </h2>
      <p class="text-gray-600">Informasi lengkap tiket laporan</p>
    </div>

    <!-- Content -->
    <div class="space-y-6">
      <!-- Basic Info -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-gray-50 rounded-lg p-4">
          <h3 class="text-sm font-medium text-gray-500 mb-2">Customer</h3>
          <p id="modal-customer" class="text-lg font-semibold text-gray-900">N/A</p>
        </div>
        <div class="bg-gray-50 rounded-lg p-4">
          <h3 class="text-sm font-medium text-gray-500 mb-2">Kategori</h3>
          <span id="modal-kategori" class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">N/A</span>
        </div>
      </div>

      <!-- Status & Date -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-gray-50 rounded-lg p-4">
          <h3 class="text-sm font-medium text-gray-500 mb-2">Status</h3>
          <span id="modal-status" class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium">N/A</span>
        </div>
        <div class="bg-gray-50 rounded-lg p-4">
          <h3 class="text-sm font-medium text-gray-500 mb-2">Tanggal Dibuat</h3>
          <p id="modal-created-at" class="text-sm font-medium text-gray-900">N/A</p>
        </div>
      </div>

      <!-- Description -->
      <div>
        <h3 class="text-sm font-medium text-gray-500 mb-2">Deskripsi Kendala</h3>
        <div class="bg-gray-50 rounded-lg p-4">
          <p id="modal-deskripsi" class="text-gray-900 whitespace-pre-wrap">Tidak ada deskripsi</p>
        </div>
      </div>

      <!-- URL Link -->
      <div id="modal-url-section" class="hidden">
        <h3 class="text-sm font-medium text-gray-500 mb-2">URL Situs</h3>
        <div class="bg-gray-50 rounded-lg p-4">
          <a id="modal-url-link" href="#" target="_blank"
           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
            </svg>
            Buka Link
          </a>
        </div>
      </div>
    </div>

    <!-- Actions -->
    <div class="mt-8 flex justify-end space-x-3">
      <button onclick="closeTicketDetail()" 
              class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
        Tutup
      </button>
    </div>
  </div>
</div>


<!-- Add some custom CSS for animations -->
<style>
  @keyframes fadeInUp {
    from {
      opacity: 0;
      transform: translateY(30px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
  
  .animate-fadeInUp {
    animation: fadeInUp 0.6s ease-out;
  }
  
  .hover\:scale-105:hover {
    transform: scale(1.05);
  }
  
  /* Fix dropdown text visibility */
  select {
    color: #1f2937 !important;
    font-weight: 500 !important;
  }
  
  select option {
    color: #1f2937 !important;
    font-weight: 500 !important;
    background-color: white !important;
  }
  
  /* Custom scrollbar styling */
  .overflow-x-auto::-webkit-scrollbar {
    height: 8px;
  }
  
  .overflow-x-auto::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 4px;
  }
  
  .overflow-x-auto::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
  }
  
  .overflow-x-auto::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
  }
  
  /* Ensure table columns have proper spacing */
  table th, table td {
    white-space: nowrap;
  }
  
  /* Make specific columns wider for better content display */
  table th:nth-child(3), table td:nth-child(3) { /* CUSTOMER */
    min-width: 200px;
  }
  
  table th:nth-child(5), table td:nth-child(5) { /* KENDALA */
    min-width: 250px;
  }
  
  table th:nth-child(7), table td:nth-child(7) { /* AKSI */
    min-width: 200px;
  }
  
  /* Prevent double click on buttons */
  .view-detail-btn {
    pointer-events: auto;
    user-select: none;
  }
  
  .view-detail-btn:active {
    transform: scale(0.95);
  }
  
  /* Modal animation improvements */
  #ticketDetailModal {
    transition: opacity 0.3s ease-in-out;
  }
  
  #ticketDetailModal.hidden {
    opacity: 0;
    pointer-events: none;
  }
  
  #ticketDetailModal:not(.hidden) {
    opacity: 1;
    pointer-events: auto;
  }
  
  /* Alpine.js x-cloak */
  [x-cloak] {
    display: none !important;
  }
  
  /* Force modal to be hidden by default, but allow Alpine.js to show it */
  [x-show="open"]:not([x-cloak]) {
    display: flex !important;
  }
</style>

<script>
// Modal Functions
function openTicketDetail(id, kategori, deskripsi, status, link, customer, created_at) {
  console.log('=== OPENING TICKET DETAIL ===');
  console.log('ID:', id);
  console.log('Customer:', customer);
  
  // Populate modal with data
  document.getElementById('modal-ticket-id').textContent = id;
  document.getElementById('modal-customer').textContent = customer;
  document.getElementById('modal-kategori').textContent = kategori;
  document.getElementById('modal-deskripsi').textContent = deskripsi;
  document.getElementById('modal-created-at').textContent = created_at;
  
  // Set status with proper styling
  const statusElement = document.getElementById('modal-status');
  statusElement.textContent = status;
  statusElement.className = 'inline-flex items-center px-3 py-1 rounded-full text-sm font-medium';
  
  if (status === 'Diproses') {
    statusElement.classList.add('bg-blue-100', 'text-blue-800');
  } else if (status === 'Selesai') {
    statusElement.classList.add('bg-green-100', 'text-green-800');
  } else if (status === 'Ditolak') {
    statusElement.classList.add('bg-red-100', 'text-red-800');
  }
  
  // Handle URL link
  const urlSection = document.getElementById('modal-url-section');
  const urlLink = document.getElementById('modal-url-link');
  if (link && link !== '') {
    urlLink.href = link;
    urlSection.classList.remove('hidden');
  } else {
    urlSection.classList.add('hidden');
  }
  
  // Show modal
  const modal = document.getElementById('ticketDetailModal');
  modal.classList.remove('hidden');
  modal.classList.add('flex');
  
  console.log('Modal opened with data');
}

function closeTicketDetail() {
  console.log('=== CLOSING TICKET DETAIL ===');
  const modal = document.getElementById('ticketDetailModal');
  modal.classList.add('hidden');
  modal.classList.remove('flex');
  console.log('Modal closed');
}

// Checkbox Functions
function toggleAllCheckboxes() {
  const selectAllCheckbox = document.getElementById('selectAll');
  const ticketCheckboxes = document.querySelectorAll('.ticket-checkbox');
  
  ticketCheckboxes.forEach(checkbox => {
    checkbox.checked = selectAllCheckbox.checked;
  });
}

function updateSelectAllCheckbox() {
  const selectAllCheckbox = document.getElementById('selectAll');
  const ticketCheckboxes = document.querySelectorAll('.ticket-checkbox');
  const checkedCheckboxes = document.querySelectorAll('.ticket-checkbox:checked');
  
  if (checkedCheckboxes.length === 0) {
    selectAllCheckbox.checked = false;
    selectAllCheckbox.indeterminate = false;
  } else if (checkedCheckboxes.length === ticketCheckboxes.length) {
    selectAllCheckbox.checked = true;
    selectAllCheckbox.indeterminate = false;
  } else {
    selectAllCheckbox.checked = false;
    selectAllCheckbox.indeterminate = true;
  }
}


// Event listeners
document.addEventListener('DOMContentLoaded', function() {
  // Force close modal on page load
  console.log('Page loaded, forcing modal to close');
  closeTicketDetail();
  
  // Close modal when clicking outside
  document.addEventListener('click', function(e) {
    const modal = document.getElementById('ticketDetailModal');
    if (e.target === modal) {
      closeTicketDetail();
    }
  });
  
  // Close modal on page unload
  window.addEventListener('beforeunload', function() {
    console.log('Page unloading, closing modal');
    closeTicketDetail();
  });
  
  // Add animation to cards
  const cards = document.querySelectorAll('.bg-white, .bg-gradient-to-r');
  cards.forEach((card, index) => {
    card.style.animationDelay = `${index * 0.1}s`;
    card.classList.add('animate-fadeInUp');
  });
  
  // Search on Enter key - refresh page
  document.getElementById('searchInput').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
      window.location.reload();
    }
  });
  
  // Auto refresh on select change
  document.getElementById('statusFilter').addEventListener('change', function() {
    window.location.reload();
  });
  document.getElementById('kategoriFilter').addEventListener('change', function() {
    window.location.reload();
  });
  
  // Alpine.js handles all modal interactions automatically
  
  // Add refresh functionality
  setInterval(function() {
    // This would typically make an AJAX call to refresh data
    console.log('Refreshing dashboard data...');
  }, 30000); // Refresh every 30 seconds
  
  // Smooth horizontal scrolling for table
  const tableContainer = document.querySelector('.overflow-x-auto');
  if (tableContainer) {
    // Add smooth scrolling behavior
    tableContainer.style.scrollBehavior = 'smooth';
    
    // Add keyboard navigation for table scrolling
    tableContainer.addEventListener('keydown', function(e) {
      if (e.key === 'ArrowLeft') {
        e.preventDefault();
        tableContainer.scrollLeft -= 50;
      } else if (e.key === 'ArrowRight') {
        e.preventDefault();
        tableContainer.scrollLeft += 50;
      }
    });
    
    // Make table container focusable for keyboard navigation
    tableContainer.setAttribute('tabindex', '0');
  }
});

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

// Photo Modal Functions
function openPhotoModal(imageSrc) {
  const modal = document.getElementById('photoModal');
  const modalImg = document.getElementById('modalPhoto');
  modalImg.src = imageSrc;
  modal.classList.remove('hidden');
  document.body.style.overflow = 'hidden';
}

function closePhotoModal() {
  const modal = document.getElementById('photoModal');
  modal.classList.add('hidden');
  document.body.style.overflow = 'auto';
}

// Close modal when clicking outside
document.addEventListener('click', function(e) {
  const modal = document.getElementById('photoModal');
  if (e.target === modal) {
    closePhotoModal();
  }
});

// Real-time updates functionality
let updateInterval;
let isPageVisible = true;

// Function to update dashboard data
async function updateDashboardData() {
  if (!isPageVisible) return;
  
  try {
    const response = await fetch('/api/tickets/latest', {
      method: 'GET',
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'Content-Type': 'application/json',
      },
      credentials: 'same-origin'
    });
    
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }
    
    const data = await response.json();
    
    if (data.success) {
      updateTicketCounts(data.counts);
      updateTicketTable(data.tickets);
      updateLastUpdateTime();
    }
  } catch (error) {
    console.error('Error updating dashboard:', error);
  }
}

// Update ticket counts
function updateTicketCounts(counts) {
  // Update total tickets
  const totalElement = document.querySelector('[data-count="total"]');
  if (totalElement) {
    totalElement.textContent = counts.total;
  }
  
  // Update processed tickets
  const diprosesElement = document.querySelector('[data-count="diproses"]');
  if (diprosesElement) {
    diprosesElement.textContent = counts.diproses;
  }
  
  // Update completed tickets
  const selesaiElement = document.querySelector('[data-count="selesai"]');
  if (selesaiElement) {
    selesaiElement.textContent = counts.selesai;
  }
  
  // Update rejected tickets
  const ditolakElement = document.querySelector('[data-count="ditolak"]');
  if (ditolakElement) {
    ditolakElement.textContent = counts.ditolak;
  }
}

// Update ticket table
function updateTicketTable(tickets) {
  const tbody = document.querySelector('#ticket-table tbody');
  if (!tbody) return;
  
  // Clear existing rows
  tbody.innerHTML = '';
  
  // Add new rows
  tickets.forEach(ticket => {
    const row = document.createElement('tr');
    row.className = 'hover:bg-gray-50 transition-colors duration-200';
    row.innerHTML = `
      <td class="px-6 py-4 whitespace-nowrap">
        <input type="checkbox" name="selected_tickets[]" value="${ticket.id}" class="ticket-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500 hover:scale-110 transition-transform duration-200" onchange="updateSelectAllCheckbox()">
      </td>
      <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
        #${ticket.ticket_id || ticket.id}
      </td>
      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
        <div class="flex items-center">
          <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center mr-3 hover:scale-110 transition-transform duration-200">
            <span class="text-xs font-medium text-gray-600">
              ${ticket.customer?.nama_lengkap?.charAt(0) || 'N'}
            </span>
          </div>
          <div>
            <div class="font-medium">${ticket.customer?.nama_lengkap || 'N/A'}</div>
            <div class="text-xs text-gray-500">${ticket.customer?.email || 'N/A'}</div>
          </div>
        </div>
      </td>
      <td class="px-6 py-4 whitespace-nowrap" data-kategori-id="${ticket.kategori?.id || ''}">
        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 hover:bg-blue-200 transition-colors duration-200">
          ${ticket.kategori?.nama || 'Tidak ada kategori'}
        </span>
      </td>
      <td class="px-6 py-4 text-sm text-gray-900">
        <div class="max-w-xs break-all">
          ${ticket.kendala || '-'}
        </div>
      </td>
      <td class="px-6 py-4 whitespace-nowrap">
        ${ticket.foto ? `
          <div class="flex items-center">
            <img src="${ticket.foto}" 
                 alt="Foto Bukti" 
                 class="w-12 h-12 rounded-lg object-cover border border-gray-200 hover:scale-110 transition-transform duration-200 cursor-pointer"
                 onclick="openPhotoModal('${ticket.foto}')">
          </div>
        ` : '<span class="text-gray-400 text-sm">Tidak ada foto</span>'}
      </td>
      <td class="px-6 py-4 whitespace-nowrap">
        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${getStatusColor(ticket.status)}">
          ${ticket.status || 'Unknown'}
        </span>
      </td>
      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
        ${new Date(ticket.created_at).toLocaleDateString('id-ID', { 
          day: '2-digit', 
          month: 'short', 
          year: 'numeric',
          hour: '2-digit',
          minute: '2-digit'
        })}
      </td>
      <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
        <div class="flex items-center space-x-2">
          <form method="POST" action="/customerservice/tickets/${ticket.id}/status" class="inline">
            @csrf
            @method('PUT')
            <select name="status" onchange="this.form.submit()" class="text-xs border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
              <option value="Diproses" ${ticket.status === 'Diproses' ? 'selected' : ''}>Diproses</option>
              <option value="Selesai" ${ticket.status === 'Selesai' ? 'selected' : ''}>Selesai</option>
              <option value="Ditolak" ${ticket.status === 'Ditolak' ? 'selected' : ''}>Ditolak</option>
            </select>
          </form>
          <button type="button" class="text-blue-600 hover:text-blue-900" onclick="openDetailModal(${ticket.id})">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
            </svg>
          </button>
        </div>
      </td>
    `;
    tbody.appendChild(row);
  });
}

// Get status color class
function getStatusColor(status) {
  const colors = {
    'Diproses': 'bg-yellow-100 text-yellow-800',
    'Selesai': 'bg-green-100 text-green-800',
    'Ditolak': 'bg-red-100 text-red-800',
  };
  return colors[status] || 'bg-gray-100 text-gray-800';
}

// Update last update time indicator
function updateLastUpdateTime() {
  const indicator = document.getElementById('update-indicator');
  if (indicator) {
    const now = new Date();
    const timeString = now.toLocaleTimeString('id-ID', { 
      hour: '2-digit', 
      minute: '2-digit', 
      second: '2-digit' 
    });
    indicator.textContent = `Terakhir update: ${timeString}`;
  }
}

// Show update indicator
function showUpdateIndicator() {
  let indicator = document.getElementById('update-indicator');
  if (!indicator) {
    indicator = document.createElement('div');
    indicator.id = 'update-indicator';
    indicator.className = 'fixed top-4 right-4 bg-green-600 text-white px-4 py-2 rounded-lg shadow-lg z-50 flex items-center space-x-2';
    indicator.innerHTML = `
      <svg class="w-4 h-4 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
      </svg>
      <span>Terakhir update: --:--:--</span>
    `;
    document.body.appendChild(indicator);
  }
}

// Start real-time updates
function startRealTimeUpdates() {
  showUpdateIndicator();
  updateDashboardData(); // Initial update
  updateInterval = setInterval(updateDashboardData, 10000); // Update every 10 seconds
}

// Stop real-time updates
function stopRealTimeUpdates() {
  if (updateInterval) {
    clearInterval(updateInterval);
  }
  const indicator = document.getElementById('update-indicator');
  if (indicator) {
    indicator.remove();
  }
}

// Page visibility API to pause updates when tab is not active
document.addEventListener('visibilitychange', function() {
  isPageVisible = !document.hidden;
  
  if (isPageVisible) {
    startRealTimeUpdates();
  } else {
    stopRealTimeUpdates();
  }
});

// Start real-time updates when page loads
document.addEventListener('DOMContentLoaded', function() {
  startRealTimeUpdates();
});

// Clean up on page unload
window.addEventListener('beforeunload', function() {
  stopRealTimeUpdates();
});

// Checkbox functions
function toggleAllCheckboxes() {
  const selectAll = document.getElementById('selectAll');
  const checkboxes = document.querySelectorAll('.ticket-checkbox');
  
  checkboxes.forEach(checkbox => {
    checkbox.checked = selectAll.checked;
  });
  
  updateSelectAllCheckbox();
}

function updateSelectAllCheckbox() {
  const checkboxes = document.querySelectorAll('.ticket-checkbox');
  const selectAll = document.getElementById('selectAll');
  const checkedCount = document.querySelectorAll('.ticket-checkbox:checked').length;
  
  selectAll.checked = checkedCount === checkboxes.length;
  selectAll.indeterminate = checkedCount > 0 && checkedCount < checkboxes.length;
  
  // Update selected tickets array
  const selectedTickets = Array.from(document.querySelectorAll('.ticket-checkbox:checked')).map(cb => cb.value);
  
  // Show/hide bulk actions
  const bulkActions = document.getElementById('bulkActions');
  if (selectedTickets.length > 0) {
    bulkActions.style.display = 'block';
    bulkActions.querySelector('span').textContent = `${selectedTickets.length} tiket dipilih`;
  } else {
    bulkActions.style.display = 'none';
  }
  
  // Update Alpine.js data
  if (window.Alpine) {
    Alpine.store('selectedTickets', selectedTickets);
  } else {
    window.selectedTickets = selectedTickets;
  }
}

// Bulk delete function
function deleteSelectedTickets() {
  console.log('deleteSelectedTickets called');
  
  // Debug: Check all checkboxes
  const allCheckboxes = document.querySelectorAll('.ticket-checkbox');
  const checkedCheckboxes = document.querySelectorAll('.ticket-checkbox:checked');
  
  console.log('Total checkboxes found:', allCheckboxes.length);
  console.log('Checked checkboxes found:', checkedCheckboxes.length);
  
  const selectedTickets = Array.from(checkedCheckboxes)
    .map(cb => cb.value)
    .filter(value => value && value !== 'on' && !isNaN(value));
  console.log('Selected tickets:', selectedTickets);
  
  if (!selectedTickets || selectedTickets.length === 0) {
    console.log('No tickets selected, showing warning');
    Swal.fire({
      icon: 'warning',
      title: 'Peringatan',
      text: 'Pilih tiket yang ingin dihapus ke arsip!',
      confirmButtonText: 'OK'
    });
    return;
  }
  
  Swal.fire({
    title: 'Konfirmasi Hapus',
    text: `Yakin ingin menghapus ${selectedTickets.length} tiket ke arsip?`,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Ya, Hapus!',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("tickets.bulk-delete") }}';
    
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = '{{ csrf_token() }}';
    form.appendChild(csrfToken);
    
    selectedTickets.forEach(ticketId => {
      const input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'ticket_ids[]';
      input.value = ticketId;
      form.appendChild(input);
    });
    
      document.body.appendChild(form);
      form.submit();
    }
  });
}

// Note Modal Functions
function openNoteModal(ticketId, currentNote = '', currentTargetRole = '') {
  document.getElementById('note-ticket-id').value = ticketId;
  document.getElementById('note-content').value = currentNote;
  document.getElementById('note-target-role').value = currentTargetRole;
  document.getElementById('noteModal').classList.remove('hidden');
}

function closeNoteModal() {
  document.getElementById('noteModal').classList.add('hidden');
  document.getElementById('note-content').value = '';
  document.getElementById('note-target-role').value = '';
}

function saveNote() {
  const ticketId = document.getElementById('note-ticket-id').value;
  const note = document.getElementById('note-content').value;
  const targetRole = document.getElementById('note-target-role').value;
  
  if (!note.trim()) {
    alert('Note tidak boleh kosong');
    return;
  }
  
  if (!targetRole) {
    alert('Pilih role target untuk note');
    return;
  }
  
  fetch('/api/tickets/note', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    body: JSON.stringify({
      ticket_id: ticketId,
      note: note,
      target_role: targetRole
    })
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      alert('Note berhasil disimpan');
      closeNoteModal();
      // Refresh data
      updateDashboardData();
    } else {
      alert('Gagal menyimpan note: ' + data.message);
    }
  })
  .catch(error => {
    console.error('Error:', error);
    alert('Terjadi kesalahan saat menyimpan note');
  });
}

// Assign Modal Functions
let teknisiList = [];

function openAssignModal(ticketId, currentAssigned = '') {
  document.getElementById('assign-ticket-id').value = ticketId;
  document.getElementById('assign-teknisi').value = currentAssigned;
  
  // Load teknisi list if not already loaded
  if (teknisiList.length === 0) {
    loadTeknisiList();
  } else {
    populateTeknisiSelect();
  }
  
  document.getElementById('assignModal').classList.remove('hidden');
}

function closeAssignModal() {
  document.getElementById('assignModal').classList.add('hidden');
}

function loadTeknisiList() {
  fetch('/api/tickets/teknisi-list')
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        teknisiList = data.data;
        populateTeknisiSelect();
      } else {
        alert('Gagal memuat daftar teknisi');
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert('Terjadi kesalahan saat memuat daftar teknisi');
    });
}

function populateTeknisiSelect() {
  const select = document.getElementById('assign-teknisi');
  select.innerHTML = '<option value="">Pilih Teknisi</option>';
  
  teknisiList.forEach(teknisi => {
    const option = document.createElement('option');
    option.value = teknisi.id_user;
    option.textContent = teknisi.nama;
    select.appendChild(option);
  });
}

function saveAssign() {
  const ticketId = document.getElementById('assign-ticket-id').value;
  const teknisiId = document.getElementById('assign-teknisi').value;
  
  if (!teknisiId) {
    alert('Pilih teknisi terlebih dahulu');
    return;
  }
  
  fetch('/api/tickets/assign', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    body: JSON.stringify({
      ticket_id: ticketId,
      teknisi_id: teknisiId
    })
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      alert('Ticket berhasil diassign ke ' + data.data.teknisi_name);
      closeAssignModal();
      // Refresh data
      updateDashboardData();
    } else {
      alert('Gagal mengassign ticket: ' + data.message);
    }
  })
  .catch(error => {
    console.error('Error:', error);
    alert('Terjadi kesalahan saat mengassign ticket');
  });
}

// Delete All Functions
function openDeleteAllModal() {
  document.getElementById('deleteAllModal').classList.remove('hidden');
  document.getElementById('deleteAllConfirm').value = '';
  document.getElementById('confirmDeleteAllBtn').disabled = true;
  
  // Remove existing event listeners first
  const confirmInput = document.getElementById('deleteAllConfirm');
  const newConfirmInput = confirmInput.cloneNode(true);
  confirmInput.parentNode.replaceChild(newConfirmInput, confirmInput);
  
  // Add event listener for confirmation input
  newConfirmInput.addEventListener('input', function() {
    const confirmBtn = document.getElementById('confirmDeleteAllBtn');
    if (this.value === 'DELETE ALL') {
      confirmBtn.disabled = false;
      confirmBtn.classList.remove('disabled:bg-gray-400', 'disabled:cursor-not-allowed');
    } else {
      confirmBtn.disabled = true;
      confirmBtn.classList.add('disabled:bg-gray-400', 'disabled:cursor-not-allowed');
    }
  });
}

function closeDeleteAllModal() {
  document.getElementById('deleteAllModal').classList.add('hidden');
  document.getElementById('deleteAllConfirm').value = '';
  document.getElementById('confirmDeleteAllBtn').disabled = true;
}

function confirmDeleteAll() {
  const confirmText = document.getElementById('deleteAllConfirm').value;
  
  if (confirmText !== 'DELETE ALL') {
    alert('Silakan ketik "DELETE ALL" untuk mengkonfirmasi');
    return;
  }
  
  // Show loading state
  const confirmBtn = document.getElementById('confirmDeleteAllBtn');
  const originalText = confirmBtn.textContent;
  confirmBtn.textContent = 'Menghapus...';
  confirmBtn.disabled = true;
  
  // Get CSRF token
  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
  if (!csrfToken) {
    console.error('CSRF token not found');
    Swal.fire({
      title: 'Error!',
      text: 'CSRF token tidak ditemukan. Silakan refresh halaman.',
      icon: 'error',
      confirmButtonText: 'OK'
    });
    confirmBtn.textContent = originalText;
    confirmBtn.disabled = false;
    return;
  }
  
  console.log('CSRF token:', csrfToken);
  
  // Send request to delete all
  fetch('/cs/tickets/delete-all', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': csrfToken
    },
    body: JSON.stringify({})
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      Swal.fire({
        title: 'Berhasil!',
        text: data.message,
        icon: 'success',
        confirmButtonText: 'OK'
      }).then(() => {
        closeDeleteAllModal();
        // Refresh the page to show updated data
        window.location.reload();
      });
    } else {
      Swal.fire({
        title: 'Error!',
        text: data.message,
        icon: 'error',
        confirmButtonText: 'OK'
      });
    }
  })
  .catch(error => {
    console.error('Error:', error);
    Swal.fire({
      title: 'Error!',
      text: 'Terjadi kesalahan saat menghapus data',
      icon: 'error',
      confirmButtonText: 'OK'
    });
  })
  .finally(() => {
    // Reset button state
    confirmBtn.textContent = originalText;
    confirmBtn.disabled = false;
  });
}
</script>

<!-- Note Modal -->
<div id="noteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
  <div class="flex items-center justify-center min-h-screen p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
      <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">Tambah Note</h3>
      </div>
      <div class="px-6 py-4">
        <input type="hidden" id="note-ticket-id">
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-2">Note untuk Role</label>
          <select id="note-target-role" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
            <option value="">Pilih Role Target</option>
            <option value="superadmin">Superadmin</option>
            <option value="customer_service">Customer Service</option>
            <option value="teknisi">Teknisi</option>
            <option value="customer">Customer</option>
          </select>
        </div>
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-2">Note</label>
          <textarea id="note-content" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500" placeholder="Masukkan note untuk ticket ini..."></textarea>
        </div>
      </div>
      <div class="px-6 py-4 bg-gray-50 flex justify-end space-x-3">
        <button onclick="closeNoteModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
          Batal
        </button>
        <button onclick="saveNote()" class="px-4 py-2 text-sm font-medium text-white bg-purple-600 rounded-md hover:bg-purple-700">
          Simpan
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Assign Modal -->
<div id="assignModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
  <div class="flex items-center justify-center min-h-screen p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
      <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">Assign ke Teknisi</h3>
      </div>
      <div class="px-6 py-4">
        <input type="hidden" id="assign-ticket-id">
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Teknisi</label>
          <select id="assign-teknisi" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
            <option value="">Loading...</option>
          </select>
        </div>
      </div>
      <div class="px-6 py-4 bg-gray-50 flex justify-end space-x-3">
        <button onclick="closeAssignModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
          Batal
        </button>
        <button onclick="saveAssign()" class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700">
          Assign
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Photo Modal -->
<div id="photoModal" class="hidden fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 p-4">
  <div class="relative max-w-4xl max-h-full">
    <button onclick="closePhotoModal()" 
            class="absolute top-4 right-4 text-white hover:text-gray-300 text-4xl font-bold z-10">
      &times;
    </button>
    <img id="modalPhoto" src="" alt="Foto Bukti" class="max-w-full max-h-full rounded-lg shadow-2xl">
  </div>
</div>

<!-- Delete All Modal -->
<div id="deleteAllModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
  <div class="flex items-center justify-center min-h-screen p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
      <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">⚠️ Delete All Laporan</h3>
      </div>
      <div class="px-6 py-4">
        <div class="flex items-center mb-4">
          <div class="flex-shrink-0">
            <svg class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
            </svg>
          </div>
          <div class="ml-3">
            <h3 class="text-sm font-medium text-gray-800">
              Apakah Anda yakin ingin menghapus SEMUA laporan?
            </h3>
            <div class="mt-2 text-sm text-gray-500">
              <p>⚠️ <strong>PERINGATAN:</strong> Tindakan ini akan menghapus semua laporan secara permanen dan tidak dapat dibatalkan!</p>
              <p class="mt-2">• Semua data laporan akan hilang</p>
              <p>• Data tidak dapat dipulihkan</p>
              <p>• Pastikan Anda sudah membackup data penting</p>
            </div>
          </div>
        </div>
        <div class="bg-red-50 border border-red-200 rounded-md p-3 mb-4">
          <div class="flex">
            <div class="flex-shrink-0">
              <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
              </svg>
            </div>
            <div class="ml-3">
              <h3 class="text-sm font-medium text-red-800">
                Konfirmasi Penghapusan
              </h3>
              <div class="mt-2 text-sm text-red-700">
                <p>Ketik <strong>"DELETE ALL"</strong> untuk mengkonfirmasi:</p>
                <input type="text" id="deleteAllConfirm" class="mt-2 w-full px-3 py-2 border border-red-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500" placeholder="Ketik DELETE ALL">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="px-6 py-4 bg-gray-50 flex justify-end space-x-3">
        <button onclick="closeDeleteAllModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
          Batal
        </button>
        <button onclick="confirmDeleteAll()" id="confirmDeleteAllBtn" disabled class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700 disabled:bg-gray-400 disabled:cursor-not-allowed">
          Hapus Semua
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Contact Section -->
@include('partials.contact-section')
@endsection
