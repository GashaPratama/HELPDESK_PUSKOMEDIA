@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100" 
     x-data="{selectedTickets: [], showBulkActions: false, openPhotoModal(imageSrc) { window.openPhotoModal(imageSrc); }}">

  <!-- Header Section -->
  <div class="bg-white shadow-sm border-b">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center py-6">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Arsip Tiket</h1>
          <p class="text-gray-600 mt-1">Kelola tiket yang telah dihapus</p>
        </div>
        <div class="flex items-center space-x-4">
          <a href="{{ route('teknisi.dashboard') }}" 
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

  @if(session('error'))
    <div class="mb-6 rounded-lg bg-red-50 border border-red-200 p-4 text-red-700 font-medium shadow-sm" role="alert">
      {{ session('error') }}
    </div>
  @endif

    <!-- Quick Stats -->
    @php
      $totalArchived = $archivedTickets->total();
      $recentlyDeleted = $archivedTickets->where('deleted_at', '>=', now()->subDays(7))->count();
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
      <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600">Total Arsip</p>
            <p class="text-3xl font-bold text-gray-900">{{ $totalArchived }}</p>
          </div>
          <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
            </svg>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600">Dihapus 7 Hari Terakhir</p>
            <p class="text-3xl font-bold text-gray-900">{{ $recentlyDeleted }}</p>
          </div>
          <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600">Status</p>
            <p class="text-lg font-bold text-gray-900">Arsip Aktif</p>
          </div>
          <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
        </div>
      </div>
    </div>

    @if($archivedTickets->count() > 0)
      <!-- Bulk Actions -->
      <div x-show="selectedTickets.length > 0" 
           x-transition:enter="transition ease-out duration-200"
           x-transition:enter-start="opacity-0 transform scale-95"
           x-transition:enter-end="opacity-100 transform scale-100"
           class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
        <div class="flex items-center justify-between">
          <div class="flex items-center">
            <svg class="w-5 h-5 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
            </svg>
            <span class="text-sm font-medium text-yellow-800">
              <span x-text="selectedTickets.length"></span> tiket dipilih
            </span>
          </div>
          <div class="flex items-center space-x-2">
            <button @click="bulkRestore()" class="px-3 py-1 text-xs bg-green-600 text-white rounded hover:bg-green-700 transition-colors">
              Pulihkan
            </button>
            <button @click="bulkForceDelete()" class="px-3 py-1 text-xs bg-red-600 text-white rounded hover:bg-red-700 transition-colors">
              Hapus Permanen
            </button>
            <button @click="selectedTickets = []" class="px-3 py-1 text-xs bg-gray-500 text-white rounded hover:bg-gray-600 transition-colors">
              Batal
            </button>
          </div>
        </div>
      </div>

      <!-- Tabel Arsip Tiket -->
      <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
          <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-900">Daftar Arsip Tiket</h3>
            <div class="flex items-center space-x-2">
              <span class="text-sm text-gray-500">{{ $archivedTickets->total() }} tiket diarsipkan</span>
            </div>
          </div>
        </div>

        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  <input type="checkbox" id="selectAll" onchange="toggleAllCheckboxes()" 
                         class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 hover:scale-110 transition-transform duration-200">
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">TICKET ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CUSTOMER</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">KATEGORI</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">KENDALA</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">FOTO</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">STATUS</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">DIHAPUS</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">AKSI</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              @foreach($archivedTickets as $ticket)
                <tr class="hover:bg-gray-50 transition-colors">
                  <td class="px-6 py-4 whitespace-nowrap">
                    <input type="checkbox" value="{{ $ticket->id }}" 
                           class="ticket-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500 hover:scale-110 transition-transform duration-200"
                           onchange="updateSelectAllCheckbox()">
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-900">
                    #{{ $ticket->ticket_id }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                      @if($ticket->customer->foto_profil)
                        <img src="{{ asset('storage/' . $ticket->customer->foto_profil) }}" 
                             alt="Customer Avatar" 
                             class="w-8 h-8 rounded-full object-cover border border-gray-200 hover:scale-110 transition-transform duration-200">
                      @else
                        <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-sm hover:scale-110 transition-transform duration-200">
                          {{ substr($ticket->customer->nama_lengkap, 0, 1) }}
                        </div>
                      @endif
                      <div class="ml-3">
                        <div class="text-sm font-medium text-gray-900">{{ $ticket->customer->nama_lengkap }}</div>
                        <div class="text-sm text-gray-500">{{ $ticket->customer->email }}</div>
                      </div>
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                      {{ $ticket->kategori->nama ?? 'Tidak ada kategori' }}
                    </span>
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-900">
                    <div class="max-w-xs break-all">
                      {{ $ticket->kendala ? Str::limit($ticket->kendala, 50) : '-' }}
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    @if($ticket->foto)
                      <div class="flex items-center">
                        <img src="{{ asset('storage/' . $ticket->foto) }}" 
                             alt="Foto Bukti" 
                             class="w-12 h-12 rounded-lg object-cover border border-gray-200 hover:scale-110 transition-transform duration-200 cursor-pointer"
                             onclick="openPhotoModal('{{ asset('storage/' . $ticket->foto) }}')">
                      </div>
                    @else
                      <span class="text-gray-400 text-sm">Tidak ada foto</span>
                    @endif
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                      {{ $ticket->status }}
                    </span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $ticket->deleted_at->format('d M Y H:i') }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <div class="flex items-center space-x-2">
                      <form method="POST" action="{{ route('teknisi.teknisi.archive.restore', $ticket->id) }}" class="inline">
                        @csrf
                        <button type="submit" 
                                onclick="return confirm('Yakin ingin memulihkan tiket ini?')"
                                class="text-green-600 hover:text-green-900">
                          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                          </svg>
                        </button>
                      </form>
                      <form method="POST" action="{{ route('teknisi.teknisi.archive.force-delete', $ticket->id) }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                onclick="return confirm('Yakin ingin menghapus tiket ini secara permanen? Tindakan ini tidak dapat dibatalkan!')"
                                class="text-red-600 hover:text-red-900">
                          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
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

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200">
          {{ $archivedTickets->links() }}
        </div>
      </div>
    @else
      <!-- Empty State -->
      <div class="bg-white rounded-xl shadow-lg p-12 text-center">
        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
          <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
          </svg>
        </div>
        <h3 class="text-xl font-semibold text-gray-900 mb-2">Tidak Ada Tiket di Arsip</h3>
        <p class="text-gray-600 mb-6">Belum ada tiket yang dihapus ke arsip</p>
        <a href="{{ route('teknisi.dashboard') }}" 
           class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
          </svg>
          Kembali ke Dashboard
        </a>
      </div>
    @endif
  </div>
</div>

<script>
// Checkbox functions
function toggleAllCheckboxes() {
  const selectAll = document.getElementById('selectAll');
  const checkboxes = document.querySelectorAll('.ticket-checkbox');
  
  checkboxes.forEach(checkbox => {
    checkbox.checked = selectAll.checked;
    if (selectAll.checked) {
      if (!window.Alpine) {
        // Fallback for non-Alpine environments
        if (!window.selectedTickets) window.selectedTickets = [];
        if (!window.selectedTickets.includes(checkbox.value)) {
          window.selectedTickets.push(checkbox.value);
        }
      } else {
        // Alpine.js environment
        Alpine.store('selectedTickets', Alpine.store('selectedTickets') || []);
        if (!Alpine.store('selectedTickets').includes(checkbox.value)) {
          Alpine.store('selectedTickets').push(checkbox.value);
        }
      }
    } else {
      if (!window.Alpine) {
        if (window.selectedTickets) {
          window.selectedTickets = window.selectedTickets.filter(id => id !== checkbox.value);
        }
      } else {
        Alpine.store('selectedTickets', Alpine.store('selectedTickets').filter(id => id !== checkbox.value));
      }
    }
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
  
  if (window.Alpine) {
    Alpine.store('selectedTickets', selectedTickets);
  } else {
    window.selectedTickets = selectedTickets;
  }
}

// Bulk actions
function bulkRestore() {
  const selectedTickets = window.Alpine ? Alpine.store('selectedTickets') : window.selectedTickets;
  
  if (!selectedTickets || selectedTickets.length === 0) {
    alert('Pilih tiket yang ingin dipulihkan!');
    return;
  }
  
  if (confirm(`Yakin ingin memulihkan ${selectedTickets.length} tiket dari arsip?`)) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("teknisi.teknisi.archive.bulk-restore") }}';
    
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
}

function bulkForceDelete() {
  const selectedTickets = window.Alpine ? Alpine.store('selectedTickets') : window.selectedTickets;
  
  if (!selectedTickets || selectedTickets.length === 0) {
    alert('Pilih tiket yang ingin dihapus permanen!');
    return;
  }
  
  if (confirm(`Yakin ingin menghapus ${selectedTickets.length} tiket secara permanen? Tindakan ini tidak dapat dibatalkan!`)) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("teknisi.teknisi.archive.bulk-force-delete") }}';
    
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

// Make function available globally
window.openPhotoModal = openPhotoModal;
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



@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100" 
     x-data="{selectedTickets: [], showBulkActions: false, openPhotoModal(imageSrc) { window.openPhotoModal(imageSrc); }}">

  <!-- Header Section -->
  <div class="bg-white shadow-sm border-b">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center py-6">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Arsip Tiket</h1>
          <p class="text-gray-600 mt-1">Kelola tiket yang telah dihapus</p>
        </div>
        <div class="flex items-center space-x-4">
          <a href="{{ route('teknisi.dashboard') }}" 
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

  @if(session('error'))
    <div class="mb-6 rounded-lg bg-red-50 border border-red-200 p-4 text-red-700 font-medium shadow-sm" role="alert">
      {{ session('error') }}
    </div>
  @endif

    <!-- Quick Stats -->
    @php
      $totalArchived = $archivedTickets->total();
      $recentlyDeleted = $archivedTickets->where('deleted_at', '>=', now()->subDays(7))->count();
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
      <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600">Total Arsip</p>
            <p class="text-3xl font-bold text-gray-900">{{ $totalArchived }}</p>
          </div>
          <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
            </svg>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600">Dihapus 7 Hari Terakhir</p>
            <p class="text-3xl font-bold text-gray-900">{{ $recentlyDeleted }}</p>
          </div>
          <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600">Status</p>
            <p class="text-lg font-bold text-gray-900">Arsip Aktif</p>
          </div>
          <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
        </div>
      </div>
    </div>

    @if($archivedTickets->count() > 0)
      <!-- Bulk Actions -->
      <div x-show="selectedTickets.length > 0" 
           x-transition:enter="transition ease-out duration-200"
           x-transition:enter-start="opacity-0 transform scale-95"
           x-transition:enter-end="opacity-100 transform scale-100"
           class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
        <div class="flex items-center justify-between">
          <div class="flex items-center">
            <svg class="w-5 h-5 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
            </svg>
            <span class="text-sm font-medium text-yellow-800">
              <span x-text="selectedTickets.length"></span> tiket dipilih
            </span>
          </div>
          <div class="flex items-center space-x-2">
            <button @click="bulkRestore()" class="px-3 py-1 text-xs bg-green-600 text-white rounded hover:bg-green-700 transition-colors">
              Pulihkan
            </button>
            <button @click="bulkForceDelete()" class="px-3 py-1 text-xs bg-red-600 text-white rounded hover:bg-red-700 transition-colors">
              Hapus Permanen
            </button>
            <button @click="selectedTickets = []" class="px-3 py-1 text-xs bg-gray-500 text-white rounded hover:bg-gray-600 transition-colors">
              Batal
            </button>
          </div>
        </div>
      </div>

      <!-- Tabel Arsip Tiket -->
      <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
          <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-900">Daftar Arsip Tiket</h3>
            <div class="flex items-center space-x-2">
              <span class="text-sm text-gray-500">{{ $archivedTickets->total() }} tiket diarsipkan</span>
            </div>
          </div>
        </div>

        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  <input type="checkbox" id="selectAll" onchange="toggleAllCheckboxes()" 
                         class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 hover:scale-110 transition-transform duration-200">
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">TICKET ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CUSTOMER</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">KATEGORI</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">KENDALA</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">FOTO</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">STATUS</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">DIHAPUS</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">AKSI</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              @foreach($archivedTickets as $ticket)
                <tr class="hover:bg-gray-50 transition-colors">
                  <td class="px-6 py-4 whitespace-nowrap">
                    <input type="checkbox" value="{{ $ticket->id }}" 
                           class="ticket-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500 hover:scale-110 transition-transform duration-200"
                           onchange="updateSelectAllCheckbox()">
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-900">
                    #{{ $ticket->ticket_id }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                      @if($ticket->customer->foto_profil)
                        <img src="{{ asset('storage/' . $ticket->customer->foto_profil) }}" 
                             alt="Customer Avatar" 
                             class="w-8 h-8 rounded-full object-cover border border-gray-200 hover:scale-110 transition-transform duration-200">
                      @else
                        <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-sm hover:scale-110 transition-transform duration-200">
                          {{ substr($ticket->customer->nama_lengkap, 0, 1) }}
                        </div>
                      @endif
                      <div class="ml-3">
                        <div class="text-sm font-medium text-gray-900">{{ $ticket->customer->nama_lengkap }}</div>
                        <div class="text-sm text-gray-500">{{ $ticket->customer->email }}</div>
                      </div>
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                      {{ $ticket->kategori->nama ?? 'Tidak ada kategori' }}
                    </span>
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-900">
                    <div class="max-w-xs break-all">
                      {{ $ticket->kendala ? Str::limit($ticket->kendala, 50) : '-' }}
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    @if($ticket->foto)
                      <div class="flex items-center">
                        <img src="{{ asset('storage/' . $ticket->foto) }}" 
                             alt="Foto Bukti" 
                             class="w-12 h-12 rounded-lg object-cover border border-gray-200 hover:scale-110 transition-transform duration-200 cursor-pointer"
                             onclick="openPhotoModal('{{ asset('storage/' . $ticket->foto) }}')">
                      </div>
                    @else
                      <span class="text-gray-400 text-sm">Tidak ada foto</span>
                    @endif
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                      {{ $ticket->status }}
                    </span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $ticket->deleted_at->format('d M Y H:i') }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <div class="flex items-center space-x-2">
                      <form method="POST" action="{{ route('teknisi.teknisi.archive.restore', $ticket->id) }}" class="inline">
                        @csrf
                        <button type="submit" 
                                onclick="return confirm('Yakin ingin memulihkan tiket ini?')"
                                class="text-green-600 hover:text-green-900">
                          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                          </svg>
                        </button>
                      </form>
                      <form method="POST" action="{{ route('teknisi.teknisi.archive.force-delete', $ticket->id) }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                onclick="return confirm('Yakin ingin menghapus tiket ini secara permanen? Tindakan ini tidak dapat dibatalkan!')"
                                class="text-red-600 hover:text-red-900">
                          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
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

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200">
          {{ $archivedTickets->links() }}
        </div>
      </div>
    @else
      <!-- Empty State -->
      <div class="bg-white rounded-xl shadow-lg p-12 text-center">
        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
          <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
          </svg>
        </div>
        <h3 class="text-xl font-semibold text-gray-900 mb-2">Tidak Ada Tiket di Arsip</h3>
        <p class="text-gray-600 mb-6">Belum ada tiket yang dihapus ke arsip</p>
        <a href="{{ route('teknisi.dashboard') }}" 
           class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
          </svg>
          Kembali ke Dashboard
        </a>
      </div>
    @endif
  </div>
</div>

<script>
// Checkbox functions
function toggleAllCheckboxes() {
  const selectAll = document.getElementById('selectAll');
  const checkboxes = document.querySelectorAll('.ticket-checkbox');
  
  checkboxes.forEach(checkbox => {
    checkbox.checked = selectAll.checked;
    if (selectAll.checked) {
      if (!window.Alpine) {
        // Fallback for non-Alpine environments
        if (!window.selectedTickets) window.selectedTickets = [];
        if (!window.selectedTickets.includes(checkbox.value)) {
          window.selectedTickets.push(checkbox.value);
        }
      } else {
        // Alpine.js environment
        Alpine.store('selectedTickets', Alpine.store('selectedTickets') || []);
        if (!Alpine.store('selectedTickets').includes(checkbox.value)) {
          Alpine.store('selectedTickets').push(checkbox.value);
        }
      }
    } else {
      if (!window.Alpine) {
        if (window.selectedTickets) {
          window.selectedTickets = window.selectedTickets.filter(id => id !== checkbox.value);
        }
      } else {
        Alpine.store('selectedTickets', Alpine.store('selectedTickets').filter(id => id !== checkbox.value));
      }
    }
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
  
  if (window.Alpine) {
    Alpine.store('selectedTickets', selectedTickets);
  } else {
    window.selectedTickets = selectedTickets;
  }
}

// Bulk actions
function bulkRestore() {
  const selectedTickets = window.Alpine ? Alpine.store('selectedTickets') : window.selectedTickets;
  
  if (!selectedTickets || selectedTickets.length === 0) {
    alert('Pilih tiket yang ingin dipulihkan!');
    return;
  }
  
  if (confirm(`Yakin ingin memulihkan ${selectedTickets.length} tiket dari arsip?`)) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("teknisi.teknisi.archive.bulk-restore") }}';
    
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
}

function bulkForceDelete() {
  const selectedTickets = window.Alpine ? Alpine.store('selectedTickets') : window.selectedTickets;
  
  if (!selectedTickets || selectedTickets.length === 0) {
    alert('Pilih tiket yang ingin dihapus permanen!');
    return;
  }
  
  if (confirm(`Yakin ingin menghapus ${selectedTickets.length} tiket secara permanen? Tindakan ini tidak dapat dibatalkan!`)) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("teknisi.teknisi.archive.bulk-force-delete") }}';
    
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

// Make function available globally
window.openPhotoModal = openPhotoModal;
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





