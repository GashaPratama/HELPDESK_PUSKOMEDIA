@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">

  <!-- Header Section -->
  <div class="bg-white shadow-sm border-b">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center py-6">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Dashboard Customer</h1>
          <p class="text-gray-600 mt-1">Selamat datang, {{ auth()->user()->nama_lengkap }}! 👋</p>
        </div>
        <div class="flex items-center space-x-4">
          <!-- Edit Profil Button -->
          <a href="{{ route('profile.edit') }}" 
             class="inline-flex items-center gap-2 px-3 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium text-gray-700 transition-colors text-sm">
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
                   class="w-10 h-10 rounded-full object-cover border-2 border-gray-200">
            @else
              <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-blue-600 rounded-full flex items-center justify-center">
                <span class="text-white font-bold text-lg">{{ substr(auth()->user()->nama_lengkap ?? auth()->user()->name, 0, 1) }}</span>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Quick Stats -->
    @php
      // Gunakan data yang sudah dihitung dari controller
      $laporanDiproses = $diproses;
      $laporanSelesai = $selesai;
      $laporanDitolak = $ditolak;
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
      <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600">Total Laporan</p>
            <p class="text-3xl font-bold text-gray-900" data-count="total">{{ $totalLaporan }}</p>
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
            <p class="text-3xl font-bold text-gray-900" data-count="diproses">{{ $laporanDiproses }}</p>
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
            <p class="text-3xl font-bold text-gray-900" data-count="selesai">{{ $laporanSelesai }}</p>
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
            <p class="text-3xl font-bold text-gray-900" data-count="ditolak">{{ $laporanDitolak }}</p>
          </div>
          <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
          </div>
        </div>
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
      <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <a href="{{ route('customer.laporan.create') }}" class="group bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-6 text-white hover:from-blue-600 hover:to-blue-700 transition-all duration-300 transform hover:scale-105">
          <div class="flex items-center">
            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-4">
              <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
              </svg>
            </div>
            <div>
              <p class="font-medium text-lg">Buat Laporan Baru</p>
              <p class="text-sm text-blue-100">Laporkan kendala atau masalah yang Anda alami</p>
            </div>
            <svg class="w-5 h-5 ml-auto group-hover:translate-x-1 transition-transform" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
            </svg>
          </div>
        </a>

        <a href="#laporan-saya" class="group bg-gradient-to-r from-green-500 to-green-600 rounded-lg p-6 text-white hover:from-green-600 hover:to-green-700 transition-all duration-300 transform hover:scale-105">
          <div class="flex items-center">
            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-4">
              <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
              </svg>
            </div>
            <div>
              <p class="font-medium text-lg">Lihat Laporan Saya</p>
              <p class="text-sm text-green-100">Pantau status laporan yang sudah dikirim</p>
            </div>
            <svg class="w-5 h-5 ml-auto group-hover:translate-x-1 transition-transform" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
            </svg>
          </div>
        </a>
      </div>
    </div>

    <!-- Laporan Saya Section -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden" id="laporan-saya">
      <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
        <div class="flex items-center justify-between">
          <h3 class="text-lg font-semibold text-gray-900">📋 Laporan Saya</h3>
          <span class="text-sm text-gray-500">{{ $totalLaporan }} laporan</span>
        </div>
      </div>

      @if($totalLaporan == 0)
        <div class="px-6 py-12 text-center text-gray-500">
          <div class="flex flex-col items-center">
            <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <p class="text-lg font-medium mb-2">Belum ada laporan</p>
            <p class="text-sm mb-4">Mulai laporkan kendala Anda untuk mendapatkan bantuan</p>
            <a href="{{ route('customer.laporan.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
              <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
              </svg>
              Buat Laporan Pertama
            </a>
          </div>
        </div>
  @else
        <div class="overflow-x-auto">
          <table id="ticket-table" class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ticket ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kendala</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Foto</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
    </tr>
  </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              @foreach($laporan as $item)
                <tr class="hover:bg-gray-50 transition-colors">
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    #{{ $item->ticket_id ?? $item->id }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                      {{ $item->kategori->nama ?? 'Tidak ada kategori' }}
                    </span>
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-900">
                    <div class="max-w-xs truncate">
                      {{ \Illuminate\Support\Str::limit($item->kendala, 50) }}
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    @if($item->foto)
                      <div class="flex items-center">
                        <img src="{{ asset('storage/' . $item->foto) }}" 
                             alt="Foto Bukti" 
                             class="w-12 h-12 rounded-lg object-cover border border-gray-200 hover:scale-110 transition-transform duration-200 cursor-pointer"
                             onclick="openPhotoModal('{{ asset('storage/' . $item->foto) }}')">
                      </div>
                    @else
                      <span class="text-gray-400 text-sm">Tidak ada foto</span>
                    @endif
        </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    @php
                      $status = $item->status ?? 'Unknown';
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
                    {{ $item->created_at->format('d M Y H:i') }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <div class="flex space-x-2">
                      <a href="{{ route('customer.laporan.edit', $item->id) }}" class="text-yellow-600 hover:text-yellow-900">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                          <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                        </svg>
                      </a>
                      <form action="{{ route('customer.laporan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus laporan ini?');" class="inline">
              @csrf
              @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900">
                          <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" clip-rule="evenodd"></path>
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                          </svg>
              </button>
          </form>
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
    row.className = 'hover:bg-gray-50 transition-colors';
    row.innerHTML = `
      <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
        #${ticket.ticket_id || ticket.id}
      </td>
      <td class="px-6 py-4 whitespace-nowrap">
        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
          ${ticket.kategori?.nama || 'Tidak ada kategori'}
        </span>
      </td>
      <td class="px-6 py-4 text-sm text-gray-900">
        <div class="max-w-xs truncate">
          ${ticket.kendala ? ticket.kendala.substring(0, 50) + (ticket.kendala.length > 50 ? '...' : '') : '-'}
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
        <div class="flex space-x-2">
          <a href="/customer/laporan/${ticket.id}/edit" class="text-blue-600 hover:text-blue-900">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
          </a>
          <button onclick="confirmDelete(${ticket.id})" class="text-red-600 hover:text-red-900">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
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
    'Diproses': 'bg-blue-100 text-blue-800',
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
    const span = indicator.querySelector('span');
    if (span) {
      span.textContent = `Terakhir update: ${timeString}`;
    } else {
      indicator.textContent = `Terakhir update: ${timeString}`;
    }
  }
}

// Show update indicator
function showUpdateIndicator() {
  // Indicator sudah ada di HTML, tidak perlu membuat element baru
  console.log('Update indicator ready');
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

<!-- Update Status Section -->
<div class="bg-white rounded-xl shadow-lg p-4 mb-6">
  <div class="flex items-center justify-between">
    <div class="flex items-center space-x-2">
      <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
      <span class="text-sm text-gray-600">Status Update</span>
    </div>
    <div id="update-indicator" class="text-sm text-gray-500">
      <span>Terakhir update: --:--:--</span>
    </div>
  </div>
</div>

<!-- Contact Section -->
@include('partials.contact-section')
@endsection
