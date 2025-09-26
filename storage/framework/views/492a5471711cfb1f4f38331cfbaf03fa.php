<?php
  $websiteSettings = \App\Models\WebsiteSetting::getSettings();
?>

<nav class="bg-blue-600 text-white py-4 shadow">
  <div class="flex justify-between items-center w-full px-6">
    <div class="flex items-center space-x-6">
      <h1 class="text-base sm:text-lg font-semibold">
        <?php echo e($websiteSettings->website_name); ?>

      </h1>
    </div>
    <div class="flex items-center space-x-4">
      <span class="text-sm text-blue-100">
        Selamat Datang, <?php echo e(auth()->user()->nama_lengkap ?? auth()->user()->name); ?>

      </span>
      <form action="<?php echo e(route('logout')); ?>" method="POST" onsubmit="return confirm('Yakin ingin logout?');">
        <?php echo csrf_field(); ?>
        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded shadow text-sm">
          🔒 Logout
        </button>
      </form>
    </div>
  </div>
</nav>
<?php /**PATH D:\Tugas\HELPDESK_PUSKOMEDIA\resources\views/partials/navbar.blade.php ENDPATH**/ ?>