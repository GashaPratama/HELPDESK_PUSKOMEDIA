@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
  <!-- Header Section -->
  <div class="bg-white shadow-sm border-b">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center py-6">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Dashboard Superadmin</h1>
          <p class="text-gray-600 mt-1">Selamat datang, {{ auth()->user()->nama_lengkap ?? auth()->user()->name }}! 👋</p>
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
              <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                <span class="text-white font-bold text-lg">{{ substr(auth()->user()->nama_lengkap ?? auth()->user()->name, 0, 1) }}</span>
              </div>
            @endif
          </div>
    </div>
    </div>
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Quick Stats Cards -->
  @php
      $totalUsers = \App\Models\User::count();
      $customers = \App\Models\User::where('role','customer')->count();
      $customerService = \App\Models\User::where('role','customer_service')->count();
      $teknisi = \App\Models\User::where('role','teknisi')->count();
      $staff = $customerService + $teknisi;
    $totalTiket = \App\Models\Laporan::count();
      $proses = \App\Models\Laporan::where('status','Diproses')->count();
      $selesai = \App\Models\Laporan::where('status','Selesai')->count();
      $ditolak = \App\Models\Laporan::where('status','Ditolak')->count();
      
      // Data untuk chart
      $ticketStatusData = [$proses, $selesai, $ditolak];
      $ticketStatusLabels = ['Diproses', 'Selesai', 'Ditolak'];
      
      // Data untuk trend bulanan (6 bulan terakhir)
      $monthlyData = [];
      $monthlyLabels = [];
      for ($i = 5; $i >= 0; $i--) {
        $date = now()->subMonths($i);
        $monthlyData[] = \App\Models\Laporan::whereYear('created_at', $date->year)
          ->whereMonth('created_at', $date->month)
          ->count();
        $monthlyLabels[] = $date->format('M');
      }
  @endphp

    <!-- User Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
      <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600">Total Users</p>
            <p class="text-3xl font-bold text-gray-900">{{ $totalUsers }}</p>
            <p class="text-sm text-green-600 mt-1">+12% dari bulan lalu</p>
          </div>
          <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
            </svg>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600">Customers</p>
            <p class="text-3xl font-bold text-gray-900">{{ $customers }}</p>
            <p class="text-sm text-blue-600 mt-1">Aktif</p>
          </div>
          <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600">Staff (CS & Teknisi)</p>
            <p class="text-3xl font-bold text-gray-900">{{ $staff }}</p>
            <p class="text-sm text-purple-600 mt-1">CS: {{ $customerService }} | Teknisi: {{ $teknisi }}</p>
          </div>
          <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
        </div>
      </div>
    </div>

    <!-- Ticket Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
      <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-blue-100 text-sm font-medium">Total Tiket</p>
            <p class="text-3xl font-bold" data-count="total">{{ $totalTiket }}</p>
          </div>
          <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
        </div>
      </div>

      <div class="bg-gradient-to-r from-indigo-500 to-purple-500 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-indigo-100 text-sm font-medium">Diproses</p>
            <p class="text-3xl font-bold" data-count="diproses">{{ $proses }}</p>
          </div>
          <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"></path>
            </svg>
          </div>
        </div>
      </div>

      <div class="bg-gradient-to-r from-green-500 to-emerald-500 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-green-100 text-sm font-medium">Selesai</p>
            <p class="text-3xl font-bold" data-count="selesai">{{ $selesai }}</p>
          </div>
          <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
            </svg>
          </div>
        </div>
      </div>

      <div class="bg-gradient-to-r from-red-500 to-pink-500 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-red-100 text-sm font-medium">Ditolak</p>
            <p class="text-3xl font-bold" data-count="ditolak">{{ $ditolak }}</p>
          </div>
          <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
          </div>
        </div>
      </div>
    </div>

    <!-- System Status & Notifications -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
      <!-- System Status -->
      <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Status Sistem</h3>
        <div class="space-y-3">
          <div class="flex items-center justify-between">
            <span class="text-sm text-gray-600">Server Status</span>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
              <div class="w-2 h-2 bg-green-400 rounded-full mr-1"></div>
              Online
            </span>
          </div>
          <div class="flex items-center justify-between">
            <span class="text-sm text-gray-600">Database</span>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
              <div class="w-2 h-2 bg-green-400 rounded-full mr-1"></div>
              Connected
            </span>
          </div>
          <div class="flex items-center justify-between">
            <span class="text-sm text-gray-600">Cache</span>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
              <div class="w-2 h-2 bg-yellow-400 rounded-full mr-1"></div>
              Warming
            </span>
          </div>
          <div class="flex items-center justify-between">
            <span class="text-sm text-gray-600">Uptime</span>
            <span class="text-sm font-medium text-gray-900">99.9%</span>
          </div>
        </div>
      </div>

      <!-- Recent Activity -->
      <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Aktivitas Terbaru</h3>
        <div id="recent-activities" class="space-y-3 max-h-80 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
          @php
            // Get recent tickets
            $recentTickets = \App\Models\Laporan::with('customer')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
            
            // Get recent users
            $recentUsers = \App\Models\User::where('role', 'customer')
                ->orderBy('created_at', 'desc')
                ->limit(3)
                ->get();
            
            // Get recent categories
            $recentCategories = \App\Models\Kategori::orderBy('created_at', 'desc')
                ->limit(3)
                ->get();
            
            // Get recent logo changes
            $recentLogoChanges = \App\Models\SystemSetting::where('key', 'login_logo')
                ->orderBy('updated_at', 'desc')
                ->limit(2)
                ->get();
            
            // Combine activities
            $activities = collect();
            
            // Add recent tickets
            foreach($recentTickets as $ticket) {
                $activities->push([
                    'type' => 'ticket',
                    'title' => 'Tiket baru #' . $ticket->id . ' - ' . ($ticket->customer->nama_lengkap ?? 'Unknown'),
                    'time' => $ticket->created_at,
                    'icon' => 'ticket',
                    'color' => 'blue'
                ]);
            }
            
            // Add recent users
            foreach($recentUsers as $user) {
                $activities->push([
                    'type' => 'user',
                    'title' => 'User baru terdaftar: ' . $user->nama_lengkap,
                    'time' => $user->created_at,
                    'icon' => 'user',
                    'color' => 'green'
                ]);
            }
            
            // Add recent categories
            foreach($recentCategories as $category) {
                $activities->push([
                    'type' => 'category',
                    'title' => 'Kategori baru: ' . $category->nama,
                    'time' => $category->created_at,
                    'icon' => 'category',
                    'color' => 'purple'
                ]);
            }
            
            // Add recent logo changes
            foreach($recentLogoChanges as $logo) {
                if($logo->updated_at != $logo->created_at) {
                    $activities->push([
                        'type' => 'logo',
                        'title' => 'Logo diperbarui',
                        'time' => $logo->updated_at,
                        'icon' => 'logo',
                        'color' => 'yellow'
                    ]);
                }
            }
            
            // Add some system activities (simulated)
            $activities->push([
                'type' => 'system',
                'title' => 'Sistem dijalankan',
                'time' => now()->subMinutes(5),
                'icon' => 'system',
                'color' => 'gray'
            ]);
            
            // Sort by time and take latest 5
            $activities = $activities->sortByDesc('time')->take(5);
          @endphp
          
          @if($activities->count() > 0)
            @foreach($activities as $activity)
              <div class="flex items-start space-x-3">
                <div class="w-8 h-8 bg-{{ $activity['color'] }}-100 rounded-full flex items-center justify-center">
                  @if($activity['icon'] == 'ticket')
                    <svg class="w-4 h-4 text-{{ $activity['color'] }}-600" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                  @elseif($activity['icon'] == 'user')
                    <svg class="w-4 h-4 text-{{ $activity['color'] }}-600" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                    </svg>
                  @elseif($activity['icon'] == 'category')
                    <svg class="w-4 h-4 text-{{ $activity['color'] }}-600" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                    </svg>
                  @elseif($activity['icon'] == 'logo')
                    <svg class="w-4 h-4 text-{{ $activity['color'] }}-600" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                    </svg>
                  @elseif($activity['icon'] == 'system')
                    <svg class="w-4 h-4 text-{{ $activity['color'] }}-600" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"></path>
                    </svg>
                  @else
                    <svg class="w-4 h-4 text-{{ $activity['color'] }}-600" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                    </svg>
                  @endif
                </div>
                <div class="flex-1 min-w-0">
                  <p class="text-sm text-gray-900">{{ $activity['title'] }}</p>
                  <p class="text-xs text-gray-500">{{ $activity['time']->diffForHumans() }}</p>
                </div>
              </div>
            @endforeach
          @else
            <div class="text-center py-4">
              <p class="text-sm text-gray-500">Belum ada aktivitas terbaru</p>
            </div>
          @endif
        </div>
      </div>

      <!-- Quick Stats Summary -->
      @php
        $todayTickets = \App\Models\Laporan::whereDate('created_at', today())->count();
        $todayCompleted = \App\Models\Laporan::whereDate('updated_at', today())->where('status', 'Selesai')->count();
        $avgResponseTime = \App\Models\Laporan::where('status', 'Selesai')
          ->whereNotNull('updated_at')
          ->get()
          ->map(function($ticket) {
            return $ticket->created_at->diffInHours($ticket->updated_at);
          })
          ->avg();
        $completionRate = $totalTiket > 0 ? round(($selesai / $totalTiket) * 100, 1) : 0;
      @endphp
      <div class="bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
        <h3 class="text-lg font-semibold mb-4">Ringkasan Hari Ini</h3>
        <div class="space-y-4">
          <div class="flex items-center justify-between">
            <span class="text-blue-100">Tiket Baru</span>
            <span class="text-2xl font-bold">{{ $todayTickets }}</span>
          </div>
          <div class="flex items-center justify-between">
            <span class="text-blue-100">Tiket Selesai</span>
            <span class="text-2xl font-bold">{{ $todayCompleted }}</span>
          </div>
          <div class="flex items-center justify-between">
            <span class="text-blue-100">Avg Response</span>
            <span class="text-2xl font-bold">{{ $avgResponseTime ? round($avgResponseTime, 1) . 'h' : 'N/A' }}</span>
          </div>
          <div class="flex items-center justify-between">
            <span class="text-blue-100">Completion Rate</span>
            <span class="text-2xl font-bold">{{ $completionRate }}%</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
      <!-- Ticket Status Chart -->
      <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Distribusi Status Tiket</h3>
        <div class="relative h-64">
          <canvas id="ticketStatusChart"></canvas>
        </div>
      </div>

      <!-- Monthly Ticket Trend -->
      <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Trend Tiket Bulanan</h3>
        <div class="relative h-64">
          <canvas id="monthlyTrendChart"></canvas>
        </div>
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
      <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-900">Quick Actions</h3>
        <div class="flex space-x-2">
          <a href="{{ route('superadmin.export.tickets.csv') }}" 
             class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Export Tiket CSV
          </a>
          <a href="{{ route('superadmin.export.users.csv') }}" 
             class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
            </svg>
            Export User CSV
          </a>
    </div>
  </div>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="{{ route('superadmin.users.index') }}" class="group bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-4 text-white hover:from-blue-600 hover:to-blue-700 transition-all duration-300 transform hover:scale-105">
          <div class="flex items-center">
            <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-3">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
              </svg>
            </div>
            <div>
              <p class="font-medium">Kelola User</p>
              <p class="text-sm text-blue-100">Manage users & permissions</p>
            </div>
            <svg class="w-5 h-5 ml-auto group-hover:translate-x-1 transition-transform" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
            </svg>
          </div>
        </a>

        <a href="{{ route('superadmin.tickets.index') }}" class="group bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg p-4 text-white hover:from-purple-600 hover:to-purple-700 transition-all duration-300 transform hover:scale-105">
          <div class="flex items-center">
            <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-3">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
              </svg>
            </div>
            <div>
              <p class="font-medium">Kelola Tiket</p>
              <p class="text-sm text-purple-100">View & manage tickets</p>
            </div>
            <svg class="w-5 h-5 ml-auto group-hover:translate-x-1 transition-transform" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
            </svg>
          </div>
        </a>

        <a href="{{ route('superadmin.logo.index') }}" class="group bg-gradient-to-r from-pink-500 to-pink-600 rounded-lg p-4 text-white hover:from-pink-600 hover:to-pink-700 transition-all duration-300 transform hover:scale-105">
          <div class="flex items-center">
            <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-3">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
              </svg>
            </div>
            <div>
              <p class="font-medium">Kelola Logo</p>
              <p class="text-sm text-pink-100">Atur logo halaman login</p>
            </div>
            <svg class="w-5 h-5 ml-auto group-hover:translate-x-1 transition-transform" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
            </svg>
          </div>
        </a>

        <a href="{{ route('superadmin.kategori.index') }}" class="group bg-gradient-to-r from-green-500 to-green-600 rounded-lg p-4 text-white hover:from-green-600 hover:to-green-700 transition-all duration-300 transform hover:scale-105">
          <div class="flex items-center">
            <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-3">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
              </svg>
            </div>
            <div>
              <p class="font-medium">Kelola Kategori</p>
              <p class="text-sm text-green-100">Manage ticket categories</p>
            </div>
            <svg class="w-5 h-5 ml-auto group-hover:translate-x-1 transition-transform" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
            </svg>
          </div>
        </a>

        <a href="{{ route('superadmin.website-settings') }}" class="group bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-lg p-4 text-white hover:from-indigo-600 hover:to-indigo-700 transition-all duration-300 transform hover:scale-105">
          <div class="flex items-center">
            <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-3">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
              </svg>
            </div>
            <div>
              <p class="font-medium">Pengaturan Website</p>
              <p class="text-sm text-indigo-100">Atur nama, kontak & background website</p>
            </div>
            <svg class="w-5 h-5 ml-auto group-hover:translate-x-1 transition-transform" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
            </svg>
          </div>
        </a>

        <a href="{{ route('superadmin.archive.index') }}" class="group bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-lg p-4 text-white hover:from-yellow-600 hover:to-yellow-700 transition-all duration-300 transform hover:scale-105">
          <div class="flex items-center">
            <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-3">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" clip-rule="evenodd"></path>
              </svg>
            </div>
            <div>
              <p class="font-medium">Arsip Tiket</p>
              <p class="text-sm text-yellow-100">Kelola tiket yang dihapus</p>
            </div>
            <svg class="w-5 h-5 ml-auto group-hover:translate-x-1 transition-transform" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
            </svg>
          </div>
        </a>

        <button onclick="openDeleteAllModal()" class="group bg-gradient-to-r from-red-500 to-red-600 rounded-lg p-4 text-white hover:from-red-600 hover:to-red-700 transition-all duration-300 transform hover:scale-105">
          <div class="flex items-center">
            <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-3">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" clip-rule="evenodd"></path>
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
              </svg>
            </div>
            <div>
              <p class="font-medium">Delete All</p>
              <p class="text-sm text-red-100">Hapus semua laporan</p>
            </div>
            <svg class="w-5 h-5 ml-auto group-hover:translate-x-1 transition-transform" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
            </svg>
          </div>
        </button>
      </div>
  </div>

    <!-- Recent Tickets Table -->
  @php
      $latest = \App\Models\Laporan::with(['kategori', 'customer'])
        ->orderBy('created_at','desc')
        ->limit(5)
        ->get();
  @endphp

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
      <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
        <div class="flex items-center justify-between">
          <h3 class="text-lg font-semibold text-gray-900">Tiket Terbaru</h3>
          <a href="{{ route('superadmin.tickets.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center">
            Lihat semua
            <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
            </svg>
          </a>
        </div>
      </div>
      
      <div class="overflow-x-auto max-h-80 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
        <table id="ticket-table" class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ticket ID</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kendala</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Note Target</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dibuat</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
          </tr>
        </thead>
          <tbody class="bg-white divide-y divide-gray-200">
          @forelse($latest as $t)
              <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                  #{{ $t->ticket_id ?? $t->id }}
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
                  <div class="max-w-xs truncate">
                    {{ \Illuminate\Support\Str::limit($t->kendala ?? '-', 50) }}
                  </div>
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
                  @if($t->note_target_role)
                    @php
                      $roleColors = [
                        'superadmin' => 'bg-purple-100 text-purple-800',
                        'customer_service' => 'bg-blue-100 text-blue-800',
                        'teknisi' => 'bg-orange-100 text-orange-800',
                        'customer' => 'bg-green-100 text-green-800',
                      ];
                      $roleColor = $roleColors[$t->note_target_role] ?? 'bg-gray-100 text-gray-800';
                      $roleName = ucfirst(str_replace('_', ' ', $t->note_target_role));
                    @endphp
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $roleColor }}">
                      {{ $roleName }}
                    </span>
                  @else
                    <span class="text-gray-400">-</span>
                  @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ $t->created_at ? $t->created_at->format('d M Y H:i') : '-' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <div class="flex space-x-2">
                    <button onclick="openNoteModal('{{ $t->ticket_id ?? $t->id }}', '{{ $t->note ?? '' }}', '{{ $t->note_target_role ?? '' }}')" 
                            class="text-blue-600 hover:text-blue-900 text-xs bg-blue-100 hover:bg-blue-200 px-2 py-1 rounded">
                      Note
                    </button>
                    <button onclick="openAssignModal('{{ $t->ticket_id ?? $t->id }}', '{{ $t->assigned_to ?? '' }}')" 
                            class="text-green-600 hover:text-green-900 text-xs bg-green-100 hover:bg-green-200 px-2 py-1 rounded">
                      Assign
                    </button>
                  </div>
              </td>
            </tr>
          @empty
              <tr>
                <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                  <div class="flex flex-col items-center">
                    <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="text-lg font-medium">Belum ada tiket</p>
                    <p class="text-sm">Tiket akan muncul di sini setelah ada yang dibuat</p>
                  </div>
                </td>
              </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
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

  /* Custom scrollbar styles */
  .scrollbar-thin {
    scrollbar-width: thin;
  }
  
  .scrollbar-thin::-webkit-scrollbar {
    width: 6px;
    height: 6px;
  }
  
  .scrollbar-thin::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 3px;
  }
  
  .scrollbar-thin::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 3px;
  }
  
  .scrollbar-thin::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
  }
  
  .animate-fadeInUp {
    animation: fadeInUp 0.6s ease-out;
  }
  
  .hover\:scale-105:hover {
    transform: scale(1.05);
  }
</style>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  // Add some interactive features
  document.addEventListener('DOMContentLoaded', function() {
    // Add animation to cards
    const cards = document.querySelectorAll('.bg-white, .bg-gradient-to-r');
    cards.forEach((card, index) => {
      card.style.animationDelay = `${index * 0.1}s`;
      card.classList.add('animate-fadeInUp');
    });
    
    // Initialize Charts
    initCharts();
    
    // Add refresh functionality
    setInterval(function() {
      // This would typically make an AJAX call to refresh data
      console.log('Refreshing dashboard data...');
    }, 30000); // Refresh every 30 seconds
  });

  function initCharts() {
    // Ticket Status Chart (Doughnut)
    const ticketStatusCtx = document.getElementById('ticketStatusChart').getContext('2d');
    new Chart(ticketStatusCtx, {
      type: 'doughnut',
      data: {
        labels: {!! json_encode($ticketStatusLabels) !!},
        datasets: [{
          data: {!! json_encode($ticketStatusData) !!},
          backgroundColor: [
            '#8B5CF6', // Purple for Diproses
            '#10B981', // Green for Selesai
            '#EF4444'  // Red for Ditolak
          ],
          borderWidth: 0,
          hoverOffset: 4
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'bottom',
            labels: {
              padding: 20,
              usePointStyle: true
            }
          },
          tooltip: {
            callbacks: {
              label: function(context) {
                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                const percentage = total > 0 ? ((context.parsed / total) * 100).toFixed(1) : 0;
                return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
              }
            }
          }
        }
      }
    });

    // Monthly Trend Chart (Line)
    const monthlyTrendCtx = document.getElementById('monthlyTrendChart').getContext('2d');
    
    new Chart(monthlyTrendCtx, {
      type: 'line',
      data: {
        labels: {!! json_encode($monthlyLabels) !!},
        datasets: [{
          label: 'Tiket Dibuat',
          data: {!! json_encode($monthlyData) !!},
          borderColor: '#3B82F6',
          backgroundColor: 'rgba(59, 130, 246, 0.1)',
          borderWidth: 3,
          fill: true,
          tension: 0.4,
          pointBackgroundColor: '#3B82F6',
          pointBorderColor: '#ffffff',
          pointBorderWidth: 2,
          pointRadius: 6,
          pointHoverRadius: 8
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false
          },
          tooltip: {
            backgroundColor: 'rgba(0, 0, 0, 0.8)',
            titleColor: '#ffffff',
            bodyColor: '#ffffff',
            borderColor: '#3B82F6',
            borderWidth: 1
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            grid: {
              color: 'rgba(0, 0, 0, 0.1)'
            },
            ticks: {
              color: '#6B7280'
            }
          },
          x: {
            grid: {
              display: false
            },
            ticks: {
              color: '#6B7280'
            }
          }
        },
        elements: {
          point: {
            hoverBackgroundColor: '#3B82F6'
          }
        }
      }
    });
  }
</script>

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

// Real-time updates functionality
let updateInterval;
let isPageVisible = true;
let lastUpdateTime = null;

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
      updateRecentActivities(data.activities);
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

// Update recent activities
function updateRecentActivities(activities) {
  const activitiesContainer = document.getElementById('recent-activities');
  if (!activitiesContainer) return;
  
  activitiesContainer.innerHTML = activities.map(activity => `
    <div class="flex items-center space-x-3 py-2">
      <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
      </div>
      <div class="flex-1 min-w-0">
        <p class="text-sm font-medium text-gray-900">Tiket baru #${activity.ticket_id} - ${activity.customer}</p>
        <p class="text-xs text-gray-500">${activity.created_at}</p>
      </div>
    </div>
  `).join('');
}

// Update ticket table
function updateTicketTable(tickets) {
  const tbody = document.querySelector('#ticket-table tbody');
  if (!tbody) return;
  
  if (tickets.length === 0) {
    tbody.innerHTML = `
      <tr>
        <td colspan="8" class="px-6 py-12 text-center text-gray-500">
          <div class="flex flex-col items-center">
            <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <p class="text-lg font-medium mb-2">Tidak ada tiket</p>
            <p class="text-sm">Belum ada tiket yang tersedia</p>
          </div>
        </td>
      </tr>
    `;
    return;
  }
  
  let html = '';
  tickets.forEach(ticket => {
    const statusColors = {
      'Diproses': 'bg-blue-100 text-blue-800',
      'Selesai': 'bg-green-100 text-green-800',
      'Ditolak': 'bg-red-100 text-red-800',
    };
    const statusColor = statusColors[ticket.status] || 'bg-gray-100 text-gray-800';
    
    const roleColors = {
      'superadmin': 'bg-purple-100 text-purple-800',
      'customer_service': 'bg-blue-100 text-blue-800',
      'teknisi': 'bg-orange-100 text-orange-800',
      'customer': 'bg-green-100 text-green-800',
    };
    const roleColor = roleColors[ticket.note_target_role] || 'bg-gray-100 text-gray-800';
    const roleName = ticket.note_target_role ? 
      ticket.note_target_role.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase()) : '-';
    
    html += `
      <tr class="hover:bg-gray-50 transition-colors">
        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
          #${ticket.ticket_id || ticket.id}
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
          <div class="flex items-center">
            <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center mr-3">
              <span class="text-xs font-medium text-gray-600">
                ${(ticket.customer?.nama_lengkap || 'N/A').charAt(0)}
              </span>
            </div>
            <div>
              <div class="text-sm font-medium text-gray-900">${ticket.customer?.nama_lengkap || 'N/A'}</div>
              <div class="text-sm text-gray-500">${ticket.customer?.email || 'N/A'}</div>
            </div>
          </div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
          <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
            ${ticket.kategori?.nama || 'Tidak ada kategori'}
          </span>
        </td>
        <td class="px-6 py-4 text-sm text-gray-900">
          <div class="max-w-xs truncate">
            ${ticket.kendala || 'Tidak ada deskripsi'}
          </div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
          <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${statusColor}">
            ${ticket.status || 'Unknown'}
          </span>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
          ${ticket.note_target_role ? 
            `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${roleColor}">${roleName}</span>` : 
            '<span class="text-gray-400">-</span>'
          }
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
          ${ticket.created_at ? new Date(ticket.created_at).toLocaleDateString('id-ID', {
            day: '2-digit',
            month: 'short',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
          }) : '-'}
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
          <div class="flex space-x-2">
            <button onclick="openNoteModal('${ticket.ticket_id || ticket.id}', '${ticket.note || ''}', '${ticket.note_target_role || ''}')" 
                    class="text-blue-600 hover:text-blue-900 text-xs bg-blue-100 hover:bg-blue-200 px-2 py-1 rounded">
              Note
            </button>
            <button onclick="openAssignModal('${ticket.ticket_id || ticket.id}', '${ticket.assigned_to || ''}')" 
                    class="text-green-600 hover:text-green-900 text-xs bg-green-100 hover:bg-green-200 px-2 py-1 rounded">
              Assign
            </button>
          </div>
        </td>
      </tr>
    `;
  });
  
  tbody.innerHTML = html;
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
  console.log('Opening assign modal for ticket:', ticketId, 'current assigned:', currentAssigned);
  document.getElementById('assign-ticket-id').value = ticketId;
  document.getElementById('assign-teknisi').value = currentAssigned;
  
  // Load teknisi list if not already loaded
  if (teknisiList.length === 0) {
    console.log('Loading teknisi list...');
    loadTeknisiList();
  } else {
    console.log('Populating teknisi select...');
    populateTeknisiSelect();
  }
  
  document.getElementById('assignModal').classList.remove('hidden');
}

function closeAssignModal() {
  document.getElementById('assignModal').classList.add('hidden');
}

function loadTeknisiList() {
  console.log('Fetching teknisi list...');
  fetch('/api/tickets/teknisi-list')
    .then(response => {
      console.log('Response status:', response.status);
      return response.json();
    })
    .then(data => {
      console.log('Teknisi list response:', data);
      if (data.success) {
        teknisiList = data.data;
        console.log('Teknisi list loaded:', teknisiList);
        populateTeknisiSelect();
      } else {
        console.error('Failed to load teknisi list:', data.message);
        alert('Gagal memuat daftar teknisi: ' + data.message);
      }
    })
    .catch(error => {
      console.error('Error loading teknisi list:', error);
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
  
  console.log('Assigning ticket:', ticketId, 'to teknisi:', teknisiId);
  
  if (!teknisiId) {
    alert('Pilih teknisi terlebih dahulu');
    return;
  }
  
  console.log('Sending assign request...');
  
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
  .then(response => {
    console.log('Response status:', response.status);
    return response.json();
  })
  .then(data => {
    console.log('Response data:', data);
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
  
  console.log('Starting delete all process...');
  
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
  fetch('/superadmin/tickets/delete-all', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': csrfToken
    },
    body: JSON.stringify({})
  })
  .then(response => {
    console.log('Response status:', response.status);
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }
    return response.json();
  })
  .then(data => {
    console.log('Response data:', data);
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
        text: data.message || 'Terjadi kesalahan yang tidak diketahui',
        icon: 'error',
        confirmButtonText: 'OK'
      });
    }
  })
  .catch(error => {
    console.error('Error details:', error);
    Swal.fire({
      title: 'Error!',
      text: 'Terjadi kesalahan saat menghapus data: ' + error.message,
      icon: 'error',
      confirmButtonText: 'OK'
    });
  })
  .finally(() => {
    // Reset button state
    console.log('Resetting button state...');
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
          <select id="note-target-role" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Pilih Role Target</option>
            <option value="superadmin">Superadmin</option>
            <option value="customer_service">Customer Service</option>
            <option value="teknisi">Teknisi</option>
            <option value="customer">Customer</option>
          </select>
        </div>
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-2">Note</label>
          <textarea id="note-content" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan note untuk ticket ini..."></textarea>
        </div>
      </div>
      <div class="px-6 py-4 bg-gray-50 flex justify-end space-x-3">
        <button onclick="closeNoteModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
          Batal
        </button>
        <button onclick="saveNote()" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
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

@endsection
