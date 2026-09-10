<?php

use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Middleware\PreventBackHistory;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdminHomeController;
use App\Http\Controllers\AdminPostController;
use App\Http\Controllers\AdminJadwalController;
use App\Http\Controllers\AdminAbsensiController;
use App\Http\Controllers\AdminKegiatanController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Admin\HighlightController;
use App\Http\Controllers\AdminKonsultasiController;
use App\Http\Controllers\Admin\AdminSurveiController;
use App\Http\Controllers\Admin\AdminJdifjfkController;
use App\Http\Controllers\Admin\KodeKonsultasiController;
use App\Http\Controllers\Admin\AdminOrganisasiController;
use App\Http\Controllers\Admin\AdminProfilController;
use App\Http\Controllers\Admin\AdminMisiController;
use App\Http\Controllers\Admin\AdminPesanKontakController;
use App\Http\Controllers\Admin\AdminAuditLogController;
use App\Http\Controllers\Admin\AdminPengunjungController;
use App\Http\Controllers\Admin\AdminAbsensiStatController;
use App\Http\Controllers\Admin\AdminSurveiStatController;
use App\Http\Controllers\Admin\AdminCommentController;
use App\Http\Controllers\Admin\AdminFaqController;
use App\Http\Controllers\Admin\AdminSertifikatController;
use App\Http\Controllers\Admin\AdminSurveiIndikatorController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//prefix "admin"
Route::prefix('admin')->group(function() {

    //middleware "auth"
    Route::group(['middleware' => ['auth']], function () {

        Route::get('/publikasi/checkSlug', [AdminPostController::class, 'checkSlug']);
        Route::get('/', [AdminDashboardController::class, 'home'] )->Middleware(['prevent-back-history']);

        // Modul konten
        Route::resource('/publikasi', \App\Http\Controllers\Admin\AdminPostController::class)->parameters(['publikasi' => 'post'])->Middleware(['prevent-back-history', 'permission:manage-publikasi']);
        Route::resource('/layanan', \App\Http\Controllers\Admin\AdminLayananController::class)->Middleware(['prevent-back-history', 'permission:manage-layanan']);
        Route::resource('/kegiatan', AdminKegiatanController::class)->Middleware(['prevent-back-history', 'permission:manage-kegiatan']);
        Route::resource('/highlight', HighlightController::class)->Middleware(['prevent-back-history', 'permission:manage-highlight']);
        Route::group(['middleware' => ['permission:manage-comment']], function () {
            Route::get('/comment', [AdminCommentController::class, 'index'])->Middleware(['prevent-back-history']);
            Route::post('/comment/{comment}/approve', [AdminCommentController::class, 'approve']);
            Route::delete('/comment/{comment}', [AdminCommentController::class, 'destroy']);
        });
        Route::resource('/faq', AdminFaqController::class)->Middleware(['prevent-back-history', 'permission:manage-faq']);

        // Manajemen admin & role - hanya yang memiliki permission manage-users (Super Admin selalu punya)
        Route::group(['middleware' => ['permission:manage-users']], function () {
            Route::resource('/register', RegisterController::class)->parameters(['register' => 'user'])->Middleware(['prevent-back-history']);
            Route::get('/role', [\App\Http\Controllers\Admin\AdminRoleController::class, 'index'])->Middleware(['prevent-back-history']);
            Route::get('/role/{role}/edit', [\App\Http\Controllers\Admin\AdminRoleController::class, 'edit'])->Middleware(['prevent-back-history']);
            Route::put('/role/{role}', [\App\Http\Controllers\Admin\AdminRoleController::class, 'update']);
        });

        // Modul operasional
        Route::get('/konsultasi-tiket', [AdminKonsultasiController::class, 'tiketIndex'])->Middleware(['prevent-back-history', 'permission:manage-konsultasi']);
        Route::resource('/konsultasi', AdminKonsultasiController::class)->except(['create'])->Middleware(['prevent-back-history', 'permission:manage-konsultasi']);
        Route::resource('/repository', AdminJdifjfkController::class)->Middleware(['prevent-back-history', 'permission:manage-repository']);
        Route::group(['middleware' => ['permission:manage-survei']], function () {
            Route::resource('/survei', AdminSurveiController::class)->Middleware(['prevent-back-history']);
            Route::resource('/surveiindikator', AdminSurveiIndikatorController::class)->Middleware(['prevent-back-history']);
            //custom route for enrolle create
            Route::get('/survei/{survei}/create', [\App\Http\Controllers\Admin\AdminSurveiController::class, 'TambahIndikator']);
            Route::post('/survei/{survei}/store', [\App\Http\Controllers\Admin\AdminSurveiController::class, 'StoreIndikator']);
            Route::delete('/survei/{indikator}/delete', [\App\Http\Controllers\Admin\AdminSurveiController::class, 'DeleteIndikator']);
        });
        Route::resource('/dashboard', AdminDashboardController::class)->Middleware(['prevent-back-history']);
        Route::resource('/jadwalukom', AdminJadwalController::class)->Middleware(['prevent-back-history', 'permission:manage-jadwalukom']);
        Route::get('/absensi/export', [AdminAbsensiController::class, 'export'])->Middleware(['prevent-back-history', 'permission:manage-absensi']);
        Route::get('/absensi/daftar-hadir', [AdminAbsensiController::class, 'cetakDaftarHadir'])->Middleware(['prevent-back-history', 'permission:manage-absensi']);
        Route::resource('/absensi', AdminAbsensiController::class)->Middleware(['prevent-back-history', 'permission:manage-absensi']);
        Route::resource('/kodekonsultasi', KodeKonsultasiController::class)->Middleware(['prevent-back-history', 'permission:manage-kodekonsultasi']);
        Route::resource('/organisasi', AdminOrganisasiController::class)->Middleware(['prevent-back-history', 'permission:manage-organisasi']);
        Route::group(['middleware' => ['permission:manage-profil']], function () {
            Route::get('/profil', [AdminProfilController::class, 'edit'])->Middleware(['prevent-back-history']);
            Route::put('/profil', [AdminProfilController::class, 'update']);
        });
        Route::resource('/misi', AdminMisiController::class)->Middleware(['prevent-back-history', 'permission:manage-misi']);
        Route::resource('/pesankontak', AdminPesanKontakController::class)->only(['index', 'show', 'destroy'])->Middleware(['prevent-back-history', 'permission:manage-pesankontak']);
        Route::group(['middleware' => ['permission:manage-sertifikat']], function () {
            Route::get('/sertifikat', [AdminSertifikatController::class, 'index'])->Middleware(['prevent-back-history']);
            Route::post('/sertifikat/{absensi}/issue', [AdminSertifikatController::class, 'issue']);
            Route::post('/sertifikat/{sertifikat}/send', [AdminSertifikatController::class, 'send']);
            Route::get('/sertifikat/{sertifikat}/cetak', [AdminSertifikatController::class, 'cetak']);
            Route::get('/sertifikat/{sertifikat}/download', [AdminSertifikatController::class, 'download']);
        });

        // Laporan & monitoring
        Route::get('/auditlog', [AdminAuditLogController::class, 'index'])->Middleware(['prevent-back-history', 'permission:view-auditlog']);
        Route::get('/pengunjung', [AdminPengunjungController::class, 'index'])->Middleware(['prevent-back-history', 'permission:view-pengunjung']);
        Route::get('/absensi-statistik', [AdminAbsensiStatController::class, 'index'])->Middleware(['prevent-back-history', 'permission:view-statistik']);
        Route::get('/survei-statistik', [AdminSurveiStatController::class, 'index'])->Middleware(['prevent-back-history', 'permission:view-statistik']);
        Route::get('/survei-statistik/{survei}/export', [AdminSurveiStatController::class, 'export'])->Middleware(['prevent-back-history', 'permission:view-statistik']);
        Route::get('/konsultasi-statistik', [\App\Http\Controllers\Admin\AdminKonsultasiStatController::class, 'index'])->Middleware(['prevent-back-history', 'permission:view-statistik']);
        Route::get('/survei-kepuasan', [\App\Http\Controllers\Admin\AdminSurveiKepuasanController::class, 'index'])->Middleware(['prevent-back-history', 'permission:view-statistik']);
    });
});

// route login
Route::get('/login', [LoginController::class, 'index'] )->name('login')->Middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate'] );
Route::post('/logout', [LoginController::class, 'logout'] );

//ROUTE PUBLIC
//route halaman awal web
Route::redirect('/', '/webpusbin');
Route::get('/webpusbin', [\App\Http\Controllers\Public\PublicController::class, 'web'] );



//route publikasi
Route::get('/publikasi', [\App\Http\Controllers\Public\PostController::class, 'index']);       //daftar publikasi
Route::get('/publikasi/{post:slug}', [\App\Http\Controllers\Public\PostController::class, 'show'] );    //halaman single post
Route::post('/publikasi/{post:slug}/komentar', [\App\Http\Controllers\Public\PostController::class, 'storeComment'])->middleware('throttle:5,1');
Route::post('/publikasi/{post:slug}/react', [\App\Http\Controllers\Public\PostController::class, 'react'])->middleware('throttle:30,1');
Route::get('/categories/{category:slug}', function(Category $category ) {
    return view('public.berita.category', [
        'title' => $category -> name,
        'posts' => $category -> posts,
        'category' => $category -> name,
    ]);
});                                                                 //halaman categori post

Route::get('/categories', function( ) {
return view('public.berita.categories', [
    'title' => 'Kategori Publikasi',
    'categories' => Category::all()

    ]);
});                                                                 //halaman categori


//ROUTE KONSULTASI
Route::get('/konsultasi', [\App\Http\Controllers\Public\KonsultasiController::class, 'index'])->name('public.konsultasi.index');
Route::get('/konsultasi/cari', function () {
    return view('public.konsultasi.cari',[
        'title' => "Cari Konsultasi"
    ]);
});
Route::get('/konsultasi/jadwal', [AdminKonsultasiController::class, 'search']);
Route::get('/konsultasi/tiket', [AdminKonsultasiController::class, 'tiket']);
Route::get('/konsultasi/{kegiatan:slug}', [\App\Http\Controllers\Public\KonsultasiController::class, 'create']);
Route::post('/konsultasi/{kegiatan:slug}/store', [\App\Http\Controllers\Public\KonsultasiController::class, 'store'])->middleware('throttle:5,1');

//ROUTE ABSENSI
Route::get('/absensi', [\App\Http\Controllers\Public\PublicAbsensiController::class, 'index'])->name('public.absensi.index');
Route::get('/absensi/{kegiatan:slug}', [\App\Http\Controllers\Public\PublicAbsensiController::class, 'create']);
Route::post('/absensi/{kegiatan:slug}/store', [\App\Http\Controllers\Public\PublicAbsensiController::class, 'store'])->middleware('throttle:5,1');

//ROUTE KEGIATAN
Route::get('/kegiatan', [\App\Http\Controllers\Public\PublicKegiatanController::class, 'index'])->name('public.kegiatan.index');
Route::get('/kegiatan/{kegiatan:slug}', [\App\Http\Controllers\Public\PublicKegiatanController::class, 'show']);
Route::get('/kegiatan/{kegiatan:slug}/create', [\App\Http\Controllers\Public\PublicKegiatanController::class, 'create']);
Route::post('/kegiatan/{kegiatan:slug}/store', [\App\Http\Controllers\Public\PublicKegiatanController::class, 'store'])->middleware('throttle:5,1');


//ROUTE REPOSITORY
Route::get('/repository', [\App\Http\Controllers\Public\JdihController::class, 'index']);

//ROUTE VERIFIKASI SERTIFIKAT
Route::get('/verifikasi-sertifikat', [\App\Http\Controllers\Public\SertifikatVerifikasiController::class, 'index'])
    ->name('public.sertifikat.verifikasi')
    ->middleware('throttle:10,1');

//ROUTE PENCARIAN
Route::get('/cari', [\App\Http\Controllers\Public\SearchController::class, 'index'])->name('public.search.index');

//ROUTE FAQ
Route::get('/faq', [\App\Http\Controllers\Public\FaqController::class, 'index']);
Route::post('/chat/ask', [\App\Http\Controllers\Public\FaqController::class, 'ask'])->middleware('throttle:12,1');

//ROUTE SURVEI
Route::get('/survei', [\App\Http\Controllers\Public\SurveiPublicController::class, 'index'])->name('public.survei.index');
Route::get('/survei/{survei}/create', [\App\Http\Controllers\Public\SurveiPublicController::class, 'create']);
Route::post('/survei/{survei}', [\App\Http\Controllers\Public\SurveiPublicController::class, 'store'])->middleware('throttle:5,1');

//ROUTE ABOUT
Route::get('/layanan/pengajuan-rekomendasi', [\App\Http\Controllers\Public\PublicController::class, 'kebutuhan']);
Route::get('/layanan/pengembangan-kompetensi', [\App\Http\Controllers\Public\PublicController::class, 'pengembangan']);
Route::get('/layanan/uji-kompetensi', [\App\Http\Controllers\Public\PublicController::class, 'ujikom']);
Route::get('/layanan/perpindahan-audiwan', [\App\Http\Controllers\Public\PublicController::class, 'audiwan']);
Route::get('/layanan/konversi-angka-kredit', [\App\Http\Controllers\Public\PublicController::class, 'konversiAk']);
Route::get('/layanan/pengusulan-pak', [\App\Http\Controllers\Public\PublicController::class, 'pengusulanPak']);
Route::get('/layanan/perubahan-nomenklatur', [\App\Http\Controllers\Public\PublicController::class, 'perubahanNomenklatur']);
Route::get('/about/tentang-kami', [\App\Http\Controllers\Public\PublicController::class, 'about']);
Route::get('/about/kontak-kami', [\App\Http\Controllers\Public\PublicController::class, 'kontak']);
Route::post('/about/kontak-kami', [\App\Http\Controllers\Public\PublicController::class, 'kontakStore'])->middleware('throttle:5,1');
Route::get('/about/kepala-pusat', [\App\Http\Controllers\Public\PublicController::class, 'kapus']);
Route::get('/about/visi-misi', [\App\Http\Controllers\Public\PublicController::class, 'visimisi']);
Route::get('/about/struktur-organisasi', [\App\Http\Controllers\Public\PublicController::class, 'struktur']);














