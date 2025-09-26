@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100" 
     x-data="{open:false, current:{id:null, kategori:'', deskripsi:'', status:'', link:'', foto:'', customer:'', created_at:''}, selectedTickets: [], showBulkActions: false, openPhotoModal(imageSrc) { window.openPhotoModal(imageSrc); }, deleteSelectedTickets() { window.deleteSelectedTickets(); }}"
     x-on:opendetail.window="open=true; current=$event.detail">

  <!-- Header Section -->
  <div class="bg-white shadow-sm border-b">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center py-6">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Kelola Tiket</h1>
          <p class="text-gray-600 mt-1">Kelola dan pantau semua tiket laporan</p>
        </div>
        <div class="flex items-center space-x-4">
          <a href="{{ route('superadmin.archive.index') }}" 
             class="inline-flex items-center gap-2 px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg font-medium transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
            </svg>
            Arsip Tiket
          </a>
    <a href="{{ route('superadmin.dashboard') }}" 
             class="inline-flex items-center gap-2 px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg font-medium transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
      </svg>
      Kembali ke Dashboard
    </a>
  </div>
      </div>
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

  @if(session('success'))
    <div class="mb-6 rounded-lg bg-green-50 border border-green-200 p-4 text-green-700 font-medium shadow-sm" role="alert">
      {{ session('success') }}
    </div>
  @endif

    <!-- Quick Stats -->
    @php
      $totalTickets = $tickets->count();
      $ticketsDiproses = $tickets->where('status', 'Diproses')->count();
      $ticketsSelesai = $tickets->where('status', 'Selesai')->count();
      $ticketsDitolak = $tickets->where('status', 'Ditolak')->count();
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
      <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600">Total Tiket</p>
            <p class="text-3xl font-bold text-gray-900">{{ $totalTickets }}</p>
          </div>
          <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600">Diproses</p>
            <p class="text-3xl font-bold text-gray-900">{{ $ticketsDiproses }}</p>
          </div>
          <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600">Selesai</p>
            <p class="text-3xl font-bold text-gray-900">{{ $ticketsSelesai }}</p>
          </div>
          <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600">Ditolak</p>
            <p class="text-3xl font-bold text-gray-900">{{ $ticketsDitolak }}</p>
          </div>
          <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </div>
        </div>
      </div>
    </div>

    <!-- Filter & Search -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
      <h3 class="text-lg font-semibold text-gray-900 mb-4">Filter & Pencarian</h3>
      <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
        <div class="md:col-span-2">
          <label for="q" class="block text-sm font-medium text-gray-700 mb-2">Cari Tiket</label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
              </svg>
            </div>
      <input
        type="text" name="q" id="q" value="{{ $q ?? '' }}"
        placeholder="Cari berdasarkan ID, URL, atau Deskripsi..."
              class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
      />
          </div>
    </div>

    <div>
          <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
          <select name="status" id="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <option value="">Semua Status</option>
            @php $statuses = ['Diproses','Selesai','Ditolak']; @endphp
        @foreach($statuses as $s)
          <option value="{{ $s }}" {{ ($status ?? '') === $s ? 'selected' : '' }}>
            {{ $s }}
          </option>
        @endforeach
      </select>
    </div>

    <div>
          <label for="kategori" class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
          <select name="kategori" id="kategori" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        <option value="">Semua Kategori</option>
        @foreach($categoryOptions as $id => $name)
          <option value="{{ $id }}" {{ (string)($kategori ?? '') === (string)$id ? 'selected' : '' }}>
            {{ $name }}
          </option>
        @endforeach
      </select>
    </div>

        <div class="flex items-end gap-2">
          <button type="submit" class="flex-1 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors flex items-center justify-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        Terapkan
      </button>
      <a href="{{ route('superadmin.tickets.index') }}" 
             class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors text-gray-700 flex items-center justify-center">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
      </a>
    </div>
  </form>
    </div>

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

    <!-- Tabel Tiket -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
      <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
        <div class="flex items-center justify-between">
          <h3 class="text-lg font-semibold text-gray-900">Daftar Tiket</h3>
          <div class="flex items-center space-x-2">
            <a href="{{ route('superadmin.export.tickets.csv', request()->query()) }}" 
               class="px-3 py-1 text-sm bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors flex items-center">
              <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
              </svg>
              Export CSV
            </a>
          </div>
        </div>
      </div>
      
      @if($tickets->isEmpty())
        <div class="px-6 py-12 text-center text-gray-500">
          <div class="flex flex-col items-center">
            <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <p class="text-lg font-medium mb-2">Belum ada tiket</p>
            <p class="text-sm">Tiket akan muncul di sini setelah ada yang dibuat</p>
          </div>
        </div>
      @else
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" 
                         @change="toggleAllCheckboxes()">
          </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ticket ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kendala</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Foto</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
        </tr>
      </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              @foreach($tickets as $t)
                <tr class="hover:bg-gray-50 transition-colors">
                  <td class="px-6 py-4 whitespace-nowrap">
                    <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 ticket-checkbox"
                           value="{{ $t->id_laporan ?? $t->id }}" @change="updateSelectAllCheckbox()">
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    #{{ $t->ticket_id ?? $t->id_laporan ?? $t->id }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    <div class="flex items-center">
                      <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center mr-3">
                        <span class="text-xs font-medium text-gray-600">
                          {{ substr($t->customer->nama_lengkap ?? 'N/A', 0, 1) }}
                        </span>
                      </div>
                      <div>
                        <div class="font-medium">{{ $t->customer->nama_lengkap ?? 'N/A' }}</div>
                        <div class="text-xs text-gray-500">{{ $t->customer->email ?? 'N/A' }}</div>
                      </div>
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                      {{ $t->kategori->nama ?? 'Tidak ada kategori' }}
                    </span>
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-900">
                    <div class="max-w-xs truncate" title="{{ $t->kendala ?? '-' }}">
                      {{ \Illuminate\Support\Str::limit($t->kendala ?? '-', 50) }}
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    @if($t->foto)
                      <div class="flex items-center">
                        <img src="{{ asset('storage/' . $t->foto) }}" 
                             alt="Foto Bukti" 
                             class="w-12 h-12 rounded-lg object-cover border border-gray-200 hover:scale-110 transition-transform duration-200 cursor-pointer"
                             onclick="openPhotoModal('{{ asset('storage/' . $t->foto) }}')">
                      </div>
                    @else
                      <span class="text-gray-400 text-sm">Tidak ada foto</span>
                    @endif
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    @php
                      $status = $t->status ?? 'Unknown';
                $statusColors = [
                        'Diproses' => 'bg-blue-100 text-blue-800',
                        'Selesai' => 'bg-green-100 text-green-800',
                        'Ditolak' => 'bg-red-100 text-red-800',
                      ];
                      $colorClass = $statusColors[$status] ?? 'bg-gray-100 text-gray-800';
              @endphp
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $colorClass }}">
                      {{ $status }}
              </span>
            </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
              {{ $t->created_at ? $t->created_at->format('d M Y H:i') : '-' }}
            </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <div class="flex items-center space-x-2">
                      <form method="POST" action="{{ route('superadmin.tickets.updateStatus', $t->id_laporan ?? $t->id) }}" class="inline">
                  @csrf
                  @method('PUT')
                        <select name="status" onchange="this.form.submit()" 
                                class="text-xs border-gray-300 rounded px-2 py-1 focus:ring-blue-500 focus:border-blue-500">
                    @foreach($statuses as $s)
                      <option value="{{ $s }}" {{ ($t->status ?? '') === $s ? 'selected' : '' }}>
                        {{ $s }}
                      </option>
                    @endforeach
                  </select>
                </form>
                <button
                  type="button"
                        class="text-blue-600 hover:text-blue-900"
                  @click="$dispatch('opendetail', {
                            id: '{{ $t->ticket_id ?? $t->id_laporan ?? $t->id }}',
                      kategori: '{{ $t->kategori->nama ?? '-' }}',
                            deskripsi: @js($t->kendala ?? '-'),
                      status: @js($t->status ?? '-'),
                            link: '{{ $t->url_situs ?? '' }}',
                            foto: '{{ $t->foto ? asset('storage/' . $t->foto) : '' }}',
                            customer: '{{ $t->customer->nama_lengkap ?? 'N/A' }}',
                            created_at: '{{ $t->created_at ? $t->created_at->format('d M Y H:i') : '-' }}'
                        })"
                      >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
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

    <!-- Modal Detail -->
  <div
    x-show="open"
    x-cloak
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 scale-95"
    x-transition:enter-end="opacity-100 scale-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 scale-100"
    x-transition:leave-end="opacity-0 scale-95"
      class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center z-50 p-4"
  >
    <div
        class="bg-white max-w-2xl w-full rounded-xl shadow-2xl p-6 sm:p-8 relative max-h-[90vh] overflow-y-auto"
      @click.away="open=false"
      x-trap.noscroll="open"
      role="dialog" aria-modal="true" aria-labelledby="modal-title"
    >
        <!-- Close Button -->
      <button
        @click="open=false"
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
            Detail Tiket #<span x-text="current.id"></span>
      </h2>
          <p class="text-gray-600">Informasi lengkap tiket laporan</p>
        </div>

        <!-- Content -->
        <div class="space-y-6">
          <!-- Basic Info -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-gray-50 rounded-lg p-4">
              <h3 class="text-sm font-medium text-gray-500 mb-2">Customer</h3>
              <p class="text-lg font-semibold text-gray-900" x-text="current.customer"></p>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
              <h3 class="text-sm font-medium text-gray-500 mb-2">Kategori</h3>
              <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800" x-text="current.kategori"></span>
            </div>
          </div>

          <!-- Status & Date -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-gray-50 rounded-lg p-4">
              <h3 class="text-sm font-medium text-gray-500 mb-2">Status</h3>
              <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium"
                :class="{
                      'bg-blue-100 text-blue-800': current.status === 'Diproses',
                      'bg-green-100 text-green-800': current.status === 'Selesai',
                      'bg-red-100 text-red-800': current.status === 'Ditolak',
                    }"
                    x-text="current.status"></span>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
              <h3 class="text-sm font-medium text-gray-500 mb-2">Tanggal Dibuat</h3>
              <p class="text-sm font-medium text-gray-900" x-text="current.created_at"></p>
            </div>
          </div>

          <!-- Description -->
          <div>
            <h3 class="text-sm font-medium text-gray-500 mb-2">Deskripsi Kendala</h3>
            <div class="bg-gray-50 rounded-lg p-4">
              <p class="text-gray-900 whitespace-pre-wrap" x-text="current.deskripsi"></p>
            </div>
          </div>

          <!-- URL Link -->
          <div x-show="current.link">
            <h3 class="text-sm font-medium text-gray-500 mb-2">URL Situs</h3>
            <div class="bg-gray-50 rounded-lg p-4">
                <a :href="current.link" target="_blank"
                 class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                </svg>
                  Buka Link
                </a>
            </div>
          </div>

          <!-- Foto Bukti -->
          <div x-show="current.foto">
            <h3 class="text-sm font-medium text-gray-500 mb-2">Foto Bukti</h3>
            <div class="bg-gray-50 rounded-lg p-4">
              <div class="flex items-center space-x-4">
                <img :src="current.foto" 
                     alt="Foto Bukti" 
                     class="w-20 h-20 rounded-lg object-cover border border-gray-200 hover:scale-110 transition-transform duration-200 cursor-pointer"
                     @click="openPhotoModal(current.foto)">
                <div class="flex-1">
                  <p class="text-sm text-gray-600 mb-2">Klik foto untuk melihat dalam ukuran penuh</p>
                  <button @click="openPhotoModal(current.foto)"
                          class="inline-flex items-center px-3 py-1 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Lihat Foto
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Actions -->
        <div class="mt-8 flex justify-end space-x-3">
          <button @click="open=false" 
                  class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
            Tutup
          </button>
          <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
            Edit Status
          </button>
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

// Warning notifications
@if(session('warning'))
  document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
      icon: 'warning',
      title: 'Peringatan!',
      text: '{{ session('warning') }}',
      confirmButtonText: 'OK'
    });
  });
@endif

// Info notifications
@if(session('info'))
  document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
      icon: 'info',
      title: 'Informasi',
      text: '{{ session('info') }}',
      timer: 3000,
      showConfirmButton: false,
      toast: true,
      position: 'top-end'
    });
  });
@endif

// Confirmation for delete actions
function confirmDelete(message, formId) {
  Swal.fire({
    title: 'Apakah Anda yakin?',
    text: message,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Ya, hapus!',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      document.getElementById(formId).submit();
    }
  });
}

// Confirmation for status change
function confirmStatusChange(ticketId, newStatus) {
  Swal.fire({
    title: 'Ubah Status Tiket?',
    text: `Apakah Anda yakin ingin mengubah status tiket menjadi "${newStatus}"?`,
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, ubah!',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      // Submit status change form
      const form = document.createElement('form');
      form.method = 'POST';
      form.action = `/superadmin/tickets/${ticketId}/status`;
      
      const csrfToken = document.createElement('input');
      csrfToken.type = 'hidden';
      csrfToken.name = '_token';
      csrfToken.value = '{{ csrf_token() }}';
      
      const statusInput = document.createElement('input');
      statusInput.type = 'hidden';
      statusInput.name = 'status';
      statusInput.value = newStatus;
      
      form.appendChild(csrfToken);
      form.appendChild(statusInput);
      document.body.appendChild(form);
      form.submit();
    }
  });
}

// Photo Modal Functions
function openPhotoModal(imageSrc) {
  const modal = document.getElementById('photoModal');
  const modalImg = document.getElementById('modalPhoto');
  modalImg.src = imageSrc;
  modal.classList.remove('hidden');
  document.body.style.overflow = 'hidden';
}

// Make function available globally
window.openPhotoModal = openPhotoModal;

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

// Auto-refresh functionality
let autoRefreshInterval;
let isPageVisible = true;

// Function to refresh the page
function refreshPage() {
  if (isPageVisible) {
    window.location.reload();
  }
}

// Start auto-refresh (every 30 seconds)
function startAutoRefresh() {
  autoRefreshInterval = setInterval(refreshPage, 30000); // 30 seconds
}

// Stop auto-refresh
function stopAutoRefresh() {
  if (autoRefreshInterval) {
    clearInterval(autoRefreshInterval);
  }
}

// Page visibility API to pause refresh when tab is not active
document.addEventListener('visibilitychange', function() {
  isPageVisible = !document.hidden;
  
  if (isPageVisible) {
    startAutoRefresh();
  } else {
    stopAutoRefresh();
  }
});

// Start auto-refresh when page loads
document.addEventListener('DOMContentLoaded', function() {
  startAutoRefresh();
});

// Clean up on page unload
window.addEventListener('beforeunload', function() {
  stopAutoRefresh();
});

// Checkbox functions
function toggleAllCheckboxes() {
  console.log('toggleAllCheckboxes called');
  const selectAll = document.getElementById('selectAll');
  const checkboxes = document.querySelectorAll('.ticket-checkbox');
  
  console.log('Select all checked:', selectAll.checked);
  console.log('Total checkboxes:', checkboxes.length);
  
  checkboxes.forEach(checkbox => {
    checkbox.checked = selectAll.checked;
  });
  
  updateSelectAllCheckbox();
}

function updateSelectAllCheckbox() {
  console.log('updateSelectAllCheckbox called');
  const checkboxes = document.querySelectorAll('.ticket-checkbox');
  const selectAll = document.getElementById('selectAll');
  const checkedCount = document.querySelectorAll('.ticket-checkbox:checked').length;
  
  console.log('Checked count:', checkedCount);
  
  selectAll.checked = checkedCount === checkboxes.length;
  selectAll.indeterminate = checkedCount > 0 && checkedCount < checkboxes.length;
  
  // Update selected tickets array - filter out invalid values
  const selectedTickets = Array.from(document.querySelectorAll('.ticket-checkbox:checked'))
    .map(cb => cb.value)
    .filter(value => value && value !== 'on' && !isNaN(value));
  console.log('Selected tickets:', selectedTickets);
  
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
  
  // Debug: Log each checkbox
  allCheckboxes.forEach((cb, index) => {
    console.log(`Checkbox ${index}:`, {
      checked: cb.checked,
      value: cb.value,
      id: cb.id
    });
  });
  
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
    console.log('User confirmed deletion');
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("superadmin.tickets.bulk-delete") }}';
    
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = '{{ csrf_token() }}';
    form.appendChild(csrfToken);
    
    selectedTickets.forEach(ticketId => {
      console.log('Adding ticket ID to form:', ticketId);
      const input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'ticket_ids[]';
      input.value = ticketId;
      form.appendChild(input);
    });
    
    console.log('Form data before submit:', new FormData(form));
    
      console.log('Form created, submitting...');
      document.body.appendChild(form);
      form.submit();
    } else {
      console.log('User cancelled deletion');
    }
  });
}
</script>

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
@endsection
