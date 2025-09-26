<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100" 
     x-data="{open:false, current:{id:null, nama:'', email:'', telp:'', jk:'', role:'', created_at:''}, selectedUsers: [], showBulkActions: false}"
     x-on:opendetail.window="open=true; current=$event.detail">

  <!-- Header Section -->
  <div class="bg-white shadow-sm border-b">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center py-6">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Kelola User</h1>
          <p class="text-gray-600 mt-1">Kelola dan pantau semua pengguna sistem</p>
        </div>
        <div class="flex items-center space-x-4">
          <a href="<?php echo e(route('superadmin.dashboard')); ?>" 
             class="inline-flex items-center gap-2 px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg font-medium transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke Dashboard
          </a>
          <a href="<?php echo e(route('superadmin.users.create')); ?>" 
             class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Tambah User
          </a>
        </div>
      </div>
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <?php if(session('success')): ?>
      <div class="mb-6 rounded-lg bg-green-50 border border-green-200 p-4 text-green-700 font-medium shadow-sm" role="alert">
        <?php echo e(session('success')); ?>

      </div>
    <?php endif; ?>
    <?php if(session('error')): ?>
      <div class="mb-6 rounded-lg bg-red-50 border border-red-200 p-4 text-red-700 font-medium shadow-sm" role="alert">
        <?php echo e(session('error')); ?>

      </div>
    <?php endif; ?>

    <!-- Quick Stats -->
    <?php
      $totalUsers = $users->count();
      $customers = $users->where('role', 'customer')->count();
      $customerService = $users->where('role', 'customer_service')->count();
      $teknisi = $users->where('role', 'teknisi')->count();
      $superadmin = $users->where('role', 'superadmin')->count();
    ?>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
      <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600">Total Users</p>
            <p class="text-3xl font-bold text-gray-900"><?php echo e($totalUsers); ?></p>
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
            <p class="text-3xl font-bold text-gray-900"><?php echo e($customers); ?></p>
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
            <p class="text-sm font-medium text-gray-600">Staff</p>
            <p class="text-3xl font-bold text-gray-900"><?php echo e($customerService + $teknisi); ?></p>
            <p class="text-sm text-purple-600 mt-1">CS: <?php echo e($customerService); ?> | Teknisi: <?php echo e($teknisi); ?></p>
          </div>
          <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600">Superadmin</p>
            <p class="text-3xl font-bold text-gray-900"><?php echo e($superadmin); ?></p>
          </div>
          <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
            </svg>
          </div>
        </div>
      </div>
    </div>

    <!-- Filter & Search -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
      <h3 class="text-lg font-semibold text-gray-900 mb-4">Filter & Pencarian</h3>
      <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="md:col-span-2">
          <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Cari User</label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
              </svg>
            </div>
            <input
              type="text" name="search" id="search" value="<?php echo e(request('search')); ?>"
              placeholder="Cari berdasarkan nama, email, atau telepon..."
              class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
        </div>

        <div>
          <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Role</label>
          <select name="role" id="role" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <option value="">Semua Role</option>
            <option value="customer" <?php echo e(request('role') === 'customer' ? 'selected' : ''); ?>>Customer</option>
            <option value="customer_service" <?php echo e(request('role') === 'customer_service' ? 'selected' : ''); ?>>Customer Service</option>
            <option value="teknisi" <?php echo e(request('role') === 'teknisi' ? 'selected' : ''); ?>>Teknisi</option>
            <option value="superadmin" <?php echo e(request('role') === 'superadmin' ? 'selected' : ''); ?>>Superadmin</option>
          </select>
        </div>

        <div class="flex items-end gap-2">
          <button type="submit" class="flex-1 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors flex items-center justify-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            Cari
          </button>
          <a href="<?php echo e(route('superadmin.users.index')); ?>" 
             class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors text-gray-700 flex items-center justify-center">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
          </a>
        </div>
      </form>
    </div>

    <!-- Bulk Actions -->
    <div x-show="selectedUsers.length > 0" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 transform scale-95"
         x-transition:enter-end="opacity-100 transform scale-100"
         class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
      <div class="flex items-center justify-between">
        <div class="flex items-center">
          <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
          <span class="text-sm font-medium text-blue-800">
            <span x-text="selectedUsers.length"></span> user dipilih
          </span>
        </div>
        <div class="flex items-center space-x-2">
          <button class="px-3 py-1 text-xs bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors">
            Update Role
          </button>
          <button class="px-3 py-1 text-xs bg-red-600 text-white rounded hover:bg-red-700 transition-colors">
            Hapus
          </button>
          <button @click="selectedUsers = []" class="px-3 py-1 text-xs bg-gray-500 text-white rounded hover:bg-gray-600 transition-colors">
            Batal
          </button>
        </div>
      </div>
    </div>

    <!-- Tabel User -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
      <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
        <div class="flex items-center justify-between">
          <h3 class="text-lg font-semibold text-gray-900">Daftar User</h3>
          <div class="flex items-center space-x-2">
            <a href="<?php echo e(route('superadmin.export.users.csv', request()->query())); ?>" 
               class="px-3 py-1 text-sm bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors flex items-center">
              <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
              </svg>
              Export CSV
            </a>
          </div>
        </div>
      </div>
      
      <?php if($users->isEmpty()): ?>
        <div class="px-6 py-12 text-center text-gray-500">
          <div class="flex flex-col items-center">
            <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
            </svg>
            <p class="text-lg font-medium mb-2">Belum ada user</p>
            <p class="text-sm">User akan muncul di sini setelah ada yang terdaftar</p>
          </div>
        </div>
      <?php else: ?>
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" 
                         @change="selectedUsers = $event.target.checked ? [<?php echo e($users->pluck('id_user')->join(',')); ?>] : []">
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telepon</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Kelamin</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="hover:bg-gray-50 transition-colors">
                  <td class="px-6 py-4 whitespace-nowrap">
                    <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                           x-model="selectedUsers" value="<?php echo e($u->id_user); ?>">
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    #<?php echo e($u->id_user); ?>

                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    <div class="flex items-center">
                      <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center mr-4">
                        <span class="text-white font-bold text-sm">
                          <?php echo e(substr($u->nama_lengkap, 0, 1)); ?>

                        </span>
                      </div>
                      <div>
                        <div class="font-medium text-gray-900"><?php echo e($u->nama_lengkap); ?></div>
                        <div class="text-sm text-gray-500">ID: <?php echo e($u->id_user); ?></div>
                      </div>
                    </div>
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-900">
                    <div class="flex items-center">
                      <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                      </svg>
                      <?php echo e($u->email); ?>

                    </div>
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-900">
                    <div class="flex items-center">
                      <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                      </svg>
                      <?php echo e($u->no_telpon); ?>

                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                      <?php echo e($u->jenis_kelamin); ?>

                    </span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <?php
                      $role = $u->role;
                      $roleColors = [
                        'customer' => 'bg-green-100 text-green-800',
                        'customer_service' => 'bg-blue-100 text-blue-800',
                        'teknisi' => 'bg-purple-100 text-purple-800',
                        'superadmin' => 'bg-red-100 text-red-800',
                      ];
                      $colorClass = $roleColors[$role] ?? 'bg-gray-100 text-gray-800';
                    ?>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($colorClass); ?>">
                      <?php echo e(ucfirst(str_replace('_',' ',$role))); ?>

                    </span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <div class="flex items-center space-x-2">
                      <button
                        type="button"
                        class="text-blue-600 hover:text-blue-900"
                        @click="$dispatch('opendetail', {
                            id: '<?php echo e($u->id_user); ?>',
                            nama: '<?php echo e($u->nama_lengkap); ?>',
                            email: '<?php echo e($u->email); ?>',
                            telp: '<?php echo e($u->no_telpon); ?>',
                            jk: '<?php echo e($u->jenis_kelamin); ?>',
                            role: '<?php echo e(ucfirst(str_replace('_',' ',$u->role))); ?>',
                            created_at: '<?php echo e($u->created_at ? $u->created_at->format('d M Y H:i') : '-'); ?>'
                        })"
                      >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                      </button>
                      <a href="<?php echo e(route('superadmin.users.edit', $u->id_user)); ?>" 
                         class="text-yellow-600 hover:text-yellow-900">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                      </a>
                      <form action="<?php echo e(route('superadmin.users.destroy', $u->id_user)); ?>" method="POST" 
                            onsubmit="return confirm('Hapus user ini?')" class="inline">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="text-red-600 hover:text-red-900">
                          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                          </svg>
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>

    <!-- Pagination -->
    <?php if($users->hasPages()): ?>
      <div class="mt-8 flex justify-center">
        <nav class="flex items-center space-x-1">
          <?php if($users->onFirstPage()): ?>
            <span class="px-3 py-2 rounded-lg bg-gray-200 text-gray-500 cursor-not-allowed flex items-center">
              <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
              </svg>
              Previous
            </span>
          <?php else: ?>
            <a href="<?php echo e($users->previousPageUrl()); ?>" class="px-3 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition-colors flex items-center">
              <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
              </svg>
              Previous
            </a>
          <?php endif; ?>

          <?php $__currentLoopData = $users->getUrlRange(1, $users->lastPage()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($page == $users->currentPage()): ?>
              <span class="px-3 py-2 rounded-lg bg-blue-600 text-white font-bold"><?php echo e($page); ?></span>
            <?php else: ?>
              <a href="<?php echo e($url); ?>" class="px-3 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 transition-colors"><?php echo e($page); ?></a>
            <?php endif; ?>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

          <?php if($users->hasMorePages()): ?>
            <a href="<?php echo e($users->nextPageUrl()); ?>" class="px-3 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition-colors flex items-center">
              Next
              <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
              </svg>
            </a>
          <?php else: ?>
            <span class="px-3 py-2 rounded-lg bg-gray-200 text-gray-500 cursor-not-allowed flex items-center">
              Next
              <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
              </svg>
            </span>
          <?php endif; ?>
        </nav>
      </div>
    <?php endif; ?>

    <!-- Modal Detail User -->
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
            Detail User #<span x-text="current.id"></span>
          </h2>
          <p class="text-gray-600">Informasi lengkap pengguna sistem</p>
        </div>

        <!-- Content -->
        <div class="space-y-6">
          <!-- User Info -->
          <div class="flex items-center space-x-4">
            <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
              <span class="text-white font-bold text-xl" x-text="current.nama ? current.nama.charAt(0) : 'U'"></span>
            </div>
            <div>
              <h3 class="text-xl font-semibold text-gray-900" x-text="current.nama"></h3>
              <p class="text-gray-600" x-text="current.role"></p>
            </div>
          </div>

          <!-- Basic Info -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-gray-50 rounded-lg p-4">
              <h3 class="text-sm font-medium text-gray-500 mb-2">Email</h3>
              <div class="flex items-center">
                <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                <p class="text-sm font-medium text-gray-900" x-text="current.email"></p>
              </div>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
              <h3 class="text-sm font-medium text-gray-500 mb-2">Telepon</h3>
              <div class="flex items-center">
                <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                </svg>
                <p class="text-sm font-medium text-gray-900" x-text="current.telp"></p>
              </div>
            </div>
          </div>

          <!-- Additional Info -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-gray-50 rounded-lg p-4">
              <h3 class="text-sm font-medium text-gray-500 mb-2">Jenis Kelamin</h3>
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800" x-text="current.jk"></span>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
              <h3 class="text-sm font-medium text-gray-500 mb-2">Role</h3>
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800" x-text="current.role"></span>
            </div>
          </div>

          <!-- Registration Date -->
          <div class="bg-gray-50 rounded-lg p-4">
            <h3 class="text-sm font-medium text-gray-500 mb-2">Tanggal Registrasi</h3>
            <p class="text-sm font-medium text-gray-900" x-text="current.created_at"></p>
          </div>
        </div>

        <!-- Actions -->
        <div class="mt-8 flex justify-end space-x-3">
          <button @click="open=false" 
                  class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
            Tutup
          </button>
          <a :href="`/superadmin/users/${current.id}/edit`" 
             class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
            Edit User
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
// Success notifications
<?php if(session('success')): ?>
  document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
      icon: 'success',
      title: 'Berhasil!',
      text: '<?php echo e(session('success')); ?>',
      timer: 3000,
      showConfirmButton: false,
      toast: true,
      position: 'top-end'
    });
  });
<?php endif; ?>

// Error notifications
<?php if(session('error')): ?>
  document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
      icon: 'error',
      title: 'Gagal!',
      text: '<?php echo e(session('error')); ?>',
      confirmButtonText: 'OK'
    });
  });
<?php endif; ?>

// Warning notifications
<?php if(session('warning')): ?>
  document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
      icon: 'warning',
      title: 'Peringatan!',
      text: '<?php echo e(session('warning')); ?>',
      confirmButtonText: 'OK'
    });
  });
<?php endif; ?>

// Info notifications
<?php if(session('info')): ?>
  document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
      icon: 'info',
      title: 'Informasi',
      text: '<?php echo e(session('info')); ?>',
      timer: 3000,
      showConfirmButton: false,
      toast: true,
      position: 'top-end'
    });
  });
<?php endif; ?>

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

// Confirmation for bulk actions
function confirmBulkAction(action, count) {
  Swal.fire({
    title: 'Konfirmasi Aksi',
    text: `Apakah Anda yakin ingin ${action} ${count} user yang dipilih?`,
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Ya, lakukan!',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      // Trigger bulk action
      Alpine.store('bulkAction', action);
    }
  });
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Tugas\HELPDESK_PUSKOMEDIA\resources\views/superadmin/users/index.blade.php ENDPATH**/ ?>