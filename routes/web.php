<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SuratController;

/*
|--------------------------------------------------------------------------
| BERANDA
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    // Kembalikan tampilan beranda tanpa redirect otomatis ke PDF.
    // Penanganan error DB dilakukan di view agar halaman tetap responsif
    // dan user tidak langsung diarahkan ke route /dev/sample-surat.
    return view('beranda');
})->name('beranda');

// Verifikasi Surat (TTE)
Route::get('/verifikasi-surat/{id}', [SuratController::class, 'verify'])->name('surat.verify');

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::get('/register', [AuthController::class, 'registerForm'])->middleware('guest')->name('register.form');
Route::post('/register', [AuthController::class, 'registerStore'])->middleware('guest')->name('register.store');

Route::get('/login', [AuthController::class, 'loginForm'])->middleware('guest')->name('login');
Route::post('/login', [AuthController::class, 'loginAttempt'])->middleware('guest')->name('login.attempt');

// Password Reset Routes
Route::get('/forgot-password', [App\Http\Controllers\PasswordResetController::class, 'showLinkRequestForm'])
    ->middleware('guest')
    ->name('password.request');
Route::post('/forgot-password', [App\Http\Controllers\PasswordResetController::class, 'sendResetLinkEmail'])
    ->middleware('guest')
    ->name('password.email');
Route::get('/reset-password/{token}', [App\Http\Controllers\PasswordResetController::class, 'showResetForm'])
    ->middleware('guest')
    ->name('password.reset');
Route::post('/reset-password', [App\Http\Controllers\PasswordResetController::class, 'reset'])
    ->middleware('guest')
    ->name('password.update');



Route::get('/desa-wonokasian/profile', [App\Http\Controllers\DesaController::class, 'profile'])->name('desa.profile');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Secret Admin Login
Route::get('/simpanel/login', [AuthController::class, 'adminLoginForm'])->middleware('guest')->name('admin.login');
Route::post('/simpanel/login', [AuthController::class, 'adminLoginAttempt'])->middleware('guest')->name('admin.login.attempt');

/*
|--------------------------------------------------------------------------
| ADMIN PANEL (Restricted Access)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/activity-logs', [\App\Http\Controllers\Admin\ActivityLogAdminController::class, 'index'])->name('activity-logs.index');

    // Desa Profile Management
    Route::get('/desa/profile', [App\Http\Controllers\DesaController::class, 'profile'])->name('desa.profile');
    Route::post('/desa/profile', [App\Http\Controllers\DesaController::class, 'updateProfile'])->name('desa.update');

    // CRUD Resources
    // CRUD Resources
    Route::resource('users', \App\Http\Controllers\Admin\UserAdminController::class);
    Route::resource('penduduk', \App\Http\Controllers\Admin\PendudukAdminController::class);
    Route::resource('keuangan', \App\Http\Controllers\Admin\KeuanganAdminController::class);
    Route::resource('pengaduan', \App\Http\Controllers\Admin\PengaduanAdminController::class)->only(['index', 'show', 'update', 'destroy']);
    Route::resource('kegiatan', \App\Http\Controllers\Admin\KegiatanAdminController::class);
    Route::resource('surat', \App\Http\Controllers\Admin\SuratAdminController::class)->only(['index', 'show', 'update', 'destroy']);
});

/*
|--------------------------------------------------------------------------
| PROFILE (Shared)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
});

Route::get('/warga/dashboard', [\App\Http\Controllers\Warga\DashboardController::class, 'index'])
    ->middleware('auth')->name('warga.dashboard');

/*
|--------------------------------------------------------------------------
| SURAT (Publik - Info jenis surat)
|--------------------------------------------------------------------------
*/
// Route::get('/surat', [App\Http\Controllers\SuratController::class, 'index'])->name('surat'); // Old index removed

/*
|--------------------------------------------------------------------------
| KEGIATAN (Publik)
|--------------------------------------------------------------------------
*/
Route::get('/kegiatan', [App\Http\Controllers\KegiatanController::class, 'index'])->name('kegiatan.index');
Route::get('/kegiatan/{kegiatan}', [App\Http\Controllers\KegiatanController::class, 'show'])->name('kegiatan.show');

/*
|--------------------------------------------------------------------------
| GALLERY (Publik - Pengaduan & Kegiatan Display)
|--------------------------------------------------------------------------
*/
Route::get('/gallery', [App\Http\Controllers\GalleryController::class, 'dashboard'])->name('gallery.dashboard');
Route::get('/gallery/pengaduan', [App\Http\Controllers\GalleryController::class, 'pengaduan'])->name('gallery.pengaduan');
Route::get('/gallery/pengaduan/{id}', [App\Http\Controllers\GalleryController::class, 'showPengaduan'])->name('gallery.pengaduan.show');
Route::get('/gallery/kegiatan', [App\Http\Controllers\GalleryController::class, 'kegiatan'])->name('gallery.kegiatan');
Route::get('/gallery/kegiatan/{id}', [App\Http\Controllers\GalleryController::class, 'showKegiatan'])->name('gallery.kegiatan.show');

/*
|--------------------------------------------------------------------------
| SURAT MENYURAT (Auth Required)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Halaman pilihan surat (universal)
    Route::get('/surat/ajukan', [App\Http\Controllers\SuratController::class, 'create'])->name('surat.create');

    // Form untuk setiap jenis surat
    Route::get('/surat/ajukan/usaha', [App\Http\Controllers\SuratController::class, 'createUsaha'])->name('surat.usaha');
    Route::get('/surat/ajukan/domisili', [App\Http\Controllers\SuratController::class, 'createDomisili'])->name('surat.domisili');
    Route::get('/surat/ajukan/tidak-mampu', [App\Http\Controllers\SuratController::class, 'createTidakMampu'])->name('surat.tidak-mampu');
    Route::get('/surat/ajukan/pindah', [App\Http\Controllers\SuratController::class, 'createPindah'])->name('surat.pindah');
    Route::get('/surat/ajukan/kelahiran', [App\Http\Controllers\SuratController::class, 'createKelahiran'])->name('surat.kelahiran');
    Route::get('/surat/ajukan/skck', [App\Http\Controllers\SuratController::class, 'createSkck'])->name('surat.skck');

    // Store dan history
    Route::post('/surat', [App\Http\Controllers\SuratController::class, 'store'])->name('surat.store');
    Route::get('/surat/terima-kasih', [App\Http\Controllers\SuratController::class, 'thanks'])->name('surat.thanks');
    Route::get('/surat/riwayat', [App\Http\Controllers\SuratController::class, 'history'])->name('surat.history');
    Route::get('/surat/{surat}/download', [App\Http\Controllers\SuratController::class, 'download'])->name('surat.download');
    // View (inline) - opens PDF in browser when available
    Route::get('/surat/{surat}/view', [App\Http\Controllers\SuratController::class, 'download'])->name('surat.view');
    // PENGADUAN (Auth Required for Warga)
    Route::get('/pengaduan/ajukan', [App\Http\Controllers\PengaduanController::class, 'create'])->name('pengaduan.create');
    Route::post('/pengaduan', [App\Http\Controllers\PengaduanController::class, 'store'])->name('pengaduan.store');
    Route::get('/pengaduan/terima-kasih', [App\Http\Controllers\PengaduanController::class, 'thanks'])->name('pengaduan.thanks');
    Route::get('/pengaduan/riwayat', [App\Http\Controllers\PengaduanController::class, 'history'])->name('pengaduan.history');
    // Redirect /surat to /surat/ajukan or just handle it here
    Route::get('/surat', [App\Http\Controllers\SuratController::class, 'create'])->name('surat');

    // User Cancel Surat
    Route::delete('/surat/{surat}/cancel', [App\Http\Controllers\SuratController::class, 'destroy'])->name('surat.cancel');
});

/*
|--------------------------------------------------------------------------
| DEV: Sample PDF generator (for local verification)
|--------------------------------------------------------------------------
| Route ini hanya aktif pada environment 'local', 'testing', atau 'staging'.
| Mengakses route ini akan membuat object Surat contoh (tidak disimpan ke DB),
| memanggil SuratPdfGenerator::generate dan mengembalikan file PDF untuk diunduh.
*/
Route::get('/dev/sample-surat', function () {
    if (!in_array(app()->environment(), ['local', 'testing', 'staging'])) {
        abort(404);
    }

    // Buat objek Surat contoh (tidak disimpan ke database)
    $surat = new \App\Models\Surat();
    $surat->id = time();
    $surat->jenis_surat = 'Surat Keterangan Domisili';
    $surat->nama_pemohon = 'Contoh Pemohon';
    $surat->nik = '1234567890123456';
    $surat->no_hp = '081234567890';
    $surat->keterangan = json_encode([
        'alamat' => 'Jl. Contoh No. 123',
        'tujuan' => 'Pendaftaran Sekolah',
    ]);

    $path = \App\Services\SuratPdfGenerator::generate($surat);

    if (!$path) {
        return response('Gagal generate PDF. Periksa log aplikasi.', 500);
    }

    $full = \Illuminate\Support\Facades\Storage::disk('public')->path($path);
    return response()->download($full, basename($full));
});

Route::get('/test-firebase', function () {
    $db = app('firebase.database');

    $db->getReference('cek')->set([
        'status' => 'OK',
        'time' => now()->toDateTimeString()
    ]);

    return 'Firebase CONNECTED';
});
