<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistrasiController;
use App\Http\Controllers\Superadmin\UserController;
use App\Http\Controllers\Superadmin\TicketController;
use App\Http\Controllers\Superadmin\ExportController;
use App\Http\Controllers\Superadmin\LogoController;
use App\Http\Controllers\Customer\ProfileController as CustomerProfileController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Customer\LaporanController;
use App\Http\Controllers\CustomerService\KategoriController;
use App\Http\Controllers\CustomerService\LaporanController as CSLaporanController;
use App\Http\Controllers\Teknisi\TeknisiLaporanController;
use App\Http\Controllers\Teknisi\TiketController;
use App\Http\Controllers\Superadmin\WebsiteSettingController;
use App\Http\Controllers\Superadmin\ArchiveController;
use App\Http\Controllers\Api\TicketController as ApiTicketController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES (tanpa login)
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => view('landing-page'));

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/register', [RegistrasiController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegistrasiController::class, 'register'])->name('register.post');

/*
|--------------------------------------------------------------------------
| LOGOUT (butuh auth)
|--------------------------------------------------------------------------
*/
Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

/*
|--------------------------------------------------------------------------
| SUPERADMIN AREA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:superadmin'])
    ->prefix('superadmin')
    ->name('superadmin.')
    ->group(function () {
        Route::get('/dashboard', function () {
            $users = \App\Models\User::orderBy('id_user', 'desc')->paginate(10);
            $recentTickets = \App\Models\Laporan::with(['kategori', 'customer'])
                ->whereNull('deleted_at')
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();
            return view('superadmin.dashboard', compact('users', 'recentTickets'));
        })->name('dashboard');

        // Manajemen Kategori
        Route::resource('kategori', \App\Http\Controllers\Superadmin\KategoriController::class);

        // Manajemen User
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::post('/', [UserController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
            Route::put('/{id}', [UserController::class, 'update'])->name('update');
            Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
        });

        // Kelola Tiket
        Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
        Route::put('/tickets/{id}/status', [TicketController::class, 'updateStatus'])->name('tickets.updateStatus');
        Route::delete('/tickets/{id}', [TicketController::class, 'remove'])->name('tickets.remove');
        Route::post('/tickets/bulk-delete', [TicketController::class, 'bulkDelete'])->name('tickets.bulk-delete');
    Route::post('/tickets/delete-all', [TicketController::class, 'deleteAll'])->name('tickets.delete-all');
        Route::get('/tickets/categories', [TicketController::class, 'listCategories'])->name('tickets.categories');
        
        // Export Routes
        Route::prefix('export')->name('export.')->group(function () {
            Route::get('/tickets/csv', [ExportController::class, 'exportTicketsCSV'])->name('tickets.csv');
            Route::get('/users/csv', [ExportController::class, 'exportUsersCSV'])->name('users.csv');
        });

        // Logo Management Routes
        Route::get('/logo', [App\Http\Controllers\Superadmin\LogoController::class, 'index'])->name('logo.index');
        Route::put('/logo', [App\Http\Controllers\Superadmin\LogoController::class, 'update'])->name('logo.update');
        Route::delete('/logo', [App\Http\Controllers\Superadmin\LogoController::class, 'destroy'])->name('logo.destroy');

        // Website Settings Routes
        Route::get('/website-settings', [WebsiteSettingController::class, 'index'])->name('website-settings');
        Route::put('/website-settings', [WebsiteSettingController::class, 'update'])->name('website-settings.update');
        
        // Archive Routes
        Route::get('/archive', [ArchiveController::class, 'index'])->name('archive.index');
        Route::post('/archive/{id}/restore', [ArchiveController::class, 'restore'])->name('archive.restore');
        Route::delete('/archive/{id}/force-delete', [ArchiveController::class, 'forceDelete'])->name('archive.force-delete');
        Route::post('/archive/bulk-restore', [ArchiveController::class, 'bulkRestore'])->name('archive.bulk-restore');
        Route::post('/archive/bulk-force-delete', [ArchiveController::class, 'bulkForceDelete'])->name('archive.bulk-force-delete');
    });

Route::middleware(['auth', 'role:superadmin'])->get('/dashboard/superadmin', function () {
    return redirect()->route('superadmin.dashboard');
})->name('dashboard.superadmin');

/*
|--------------------------------------------------------------------------
| CUSTOMER SERVICE AREA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:customer_service'])->prefix('cs')->group(function () {
    // Dashboard Customer Service
    Route::get('/dashboard', [CSLaporanController::class, 'index'])
        ->name('dashboard.customerservice');

    // Update & Hapus Laporan
    Route::post('/laporan/{id}/update', [CSLaporanController::class, 'update'])->name('cs.laporan.update');
    Route::delete('/laporan/{id}', [CSLaporanController::class, 'destroy'])->name('cs.laporan.delete');
    Route::post('/tickets/bulk-delete', [CSLaporanController::class, 'bulkDelete'])->name('tickets.bulk-delete');
    Route::post('/tickets/delete-all', [CSLaporanController::class, 'deleteAll'])->name('tickets.delete-all');
    
    // Export
    Route::get('/laporan/export', [CSLaporanController::class, 'export'])->name('cs.laporan.export');
    
    // Archive Routes
    Route::get('/archive', [\App\Http\Controllers\CustomerService\ArchiveController::class, 'index'])->name('cs.archive.index');
    Route::post('/archive/{id}/restore', [\App\Http\Controllers\CustomerService\ArchiveController::class, 'restore'])->name('cs.archive.restore');
    Route::delete('/archive/{id}/force-delete', [\App\Http\Controllers\CustomerService\ArchiveController::class, 'forceDelete'])->name('cs.archive.force-delete');
    Route::post('/archive/bulk-restore', [\App\Http\Controllers\CustomerService\ArchiveController::class, 'bulkRestore'])->name('cs.archive.bulk-restore');
    Route::post('/archive/bulk-force-delete', [\App\Http\Controllers\CustomerService\ArchiveController::class, 'bulkForceDelete'])->name('cs.archive.bulk-force-delete');

    // ✅ Kirim ke teknisi → ubah status laporan menjadi 'dikirim'
    Route::post('/laporan/{id}/kirim', [CSLaporanController::class, 'kirim'])->name('cs.laporan.kirim');

    // Kategori
    Route::prefix('kategori')->name('kategori.')->group(function () {
        Route::get('/', [KategoriController::class, 'index'])->name('index');
        Route::post('/', [KategoriController::class, 'store'])->name('store');
        Route::delete('/{kategori}', [KategoriController::class, 'destroy'])->name('destroy');
    });
});

/*
|--------------------------------------------------------------------------
| TEKNISI AREA
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| CUSTOMER AREA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/dashboard/customer', [LaporanController::class, 'dashboard'])
        ->name('dashboard.customer');

    Route::prefix('laporan')->name('customer.laporan.')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])->name('index');
        Route::get('/create', [LaporanController::class, 'create'])->name('create');
        Route::post('/store', [LaporanController::class, 'store'])->name('store');
        Route::get('/{id}', [LaporanController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [LaporanController::class, 'edit'])->name('edit');
        Route::put('/{id}', [LaporanController::class, 'update'])->name('update');
        Route::delete('/{id}', [LaporanController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('profil')->name('customer.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('profil');
        Route::get('/edit-foto', [ProfileController::class, 'editFoto'])->name('edit-foto');
        Route::post('/update-foto', [ProfileController::class, 'updateFoto'])->name('update-foto');
        Route::get('/edit-nama', [ProfileController::class, 'editNama'])->name('edit-nama');
        Route::post('/update-nama', [ProfileController::class, 'updateNama'])->name('update-nama');
        Route::get('/edit-email', [ProfileController::class, 'editEmail'])->name('edit-email');
        Route::post('/update-email', [ProfileController::class, 'updateEmail'])->name('update-email');
        Route::get('/edit-password', [ProfileController::class, 'editPassword'])->name('edit-password');
        Route::post('/update-password', [ProfileController::class, 'updatePassword'])->name('update-password');
    });
});

/*
|--------------------------------------------------------------------------
| PROFILE ROUTES (untuk semua role)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
    Route::delete('/profile/delete-photo', [ProfileController::class, 'deletePhoto'])->name('profile.delete-photo');
});

/*
||--------------------------------------------------------------------------
|| TEKNISI AREA
||--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:teknisi'])
    ->prefix('teknisi')
    ->name('teknisi.')
    ->group(function () {
        Route::get('/dashboard', [TiketController::class, 'index'])->name('dashboard');
        Route::put('/tickets/{id}/status', [TiketController::class, 'updateStatus'])->name('tickets.updateStatus');
        Route::delete('/tickets/{id}', [TiketController::class, 'remove'])->name('tickets.remove');
        Route::post('/tickets/bulk', [TiketController::class, 'bulkUpdate'])->name('tickets.bulk');
        Route::post('/tickets/bulk-delete', [TiketController::class, 'bulkDelete'])->name('tickets.bulk-delete');
        Route::post('/tickets/delete-all', [TiketController::class, 'deleteAll'])->name('tickets.delete-all');
        Route::get('/tickets/{id}/details', [TiketController::class, 'getTicketDetails'])->name('tickets.details');
        
        // Archive Routes
        Route::get('/archive', [\App\Http\Controllers\Teknisi\ArchiveController::class, 'index'])->name('teknisi.archive.index');
        Route::post('/archive/{id}/restore', [\App\Http\Controllers\Teknisi\ArchiveController::class, 'restore'])->name('teknisi.archive.restore');
        Route::delete('/archive/{id}/force-delete', [\App\Http\Controllers\Teknisi\ArchiveController::class, 'forceDelete'])->name('teknisi.archive.force-delete');
        Route::post('/archive/bulk-restore', [\App\Http\Controllers\Teknisi\ArchiveController::class, 'bulkRestore'])->name('teknisi.archive.bulk-restore');
        Route::post('/archive/bulk-force-delete', [\App\Http\Controllers\Teknisi\ArchiveController::class, 'bulkForceDelete'])->name('teknisi.archive.bulk-force-delete');
    });

// API Routes for real-time updates
Route::middleware(['auth'])->prefix('api')->group(function () {
    Route::get('/tickets/latest', [ApiTicketController::class, 'getLatestTickets'])->name('api.tickets.latest');
    Route::get('/tickets/counts', [ApiTicketController::class, 'getTicketCounts'])->name('api.tickets.counts');
    
    // Ticket note and assignment routes
    Route::post('/tickets/note', [\App\Http\Controllers\Api\TicketNoteController::class, 'addNote'])->name('api.tickets.note');
    Route::post('/tickets/assign', [\App\Http\Controllers\Api\TicketNoteController::class, 'assignTicket'])->name('api.tickets.assign');
    Route::post('/tickets/update-status', [\App\Http\Controllers\Api\TicketNoteController::class, 'updateStatus'])->name('api.tickets.update-status');
    Route::get('/tickets/teknisi-list', [\App\Http\Controllers\Api\TicketNoteController::class, 'getTeknisiList'])->name('api.tickets.teknisi-list');
    Route::get('/tickets/{ticket_id}/details', [\App\Http\Controllers\Api\TicketNoteController::class, 'getTicketDetails'])->name('api.tickets.details');
});
