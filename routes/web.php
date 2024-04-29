<?php

use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LayananController;
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
        Route::resource('/publikasi', \App\Http\Controllers\Admin\AdminPostController::class)->parameters(['publikasi' => 'post'])->Middleware(['prevent-back-history']);
        Route::resource('/layanan', \App\Http\Controllers\Admin\AdminLayananController::class)->Middleware(['auth','prevent-back-history']);
        Route::resource('/register', RegisterController::class)->parameters(['register' => 'user'])->Middleware(['prevent-back-history']);
        Route::resource('/konsultasi', AdminKonsultasiController::class)->Middleware(['prevent-back-history']);
        Route::resource('/highlight', HighlightController::class)->Middleware(['prevent-back-history']);
        Route::resource('/jdihjfk', AdminJdifjfkController::class)->Middleware(['prevent-back-history']);
        Route::resource('/konsultasi', AdminKonsultasiController::class)->Middleware(['prevent-back-history']);
        Route::resource('/survei', AdminSurveiController::class)->Middleware(['prevent-back-history']);
        Route::resource('/surveiindikator', AdminSurveiIndikatorController::class)->Middleware(['prevent-back-history']);
        // Route::resource('/konsultasi', AdminKonsultasiController::class);
        Route::resource('/dashboard', AdminDashboardController::class)->Middleware(['prevent-back-history']);
        Route::resource('/jadwalukom', AdminJadwalController::class)->Middleware(['prevent-back-history']);
        Route::resource('/kegiatan', AdminKegiatanController::class)->Middleware(['prevent-back-history']);
        Route::resource('/absensi', AdminAbsensiController::class)->Middleware(['prevent-back-history']);
        Route::resource('/kodekonsultasi', KodeKonsultasiController::class)->Middleware(['prevent-back-history']);
        //custom route for enrolle create
        Route::get('/survei/{survei}/create', [\App\Http\Controllers\Admin\AdminSurveiController::class, 'TambahIndikator']);
        Route::post('/survei/{survei}/store', [\App\Http\Controllers\Admin\AdminSurveiController::class, 'StoreIndikator']);
        Route::delete('/survei/{indikator}/delete', [\App\Http\Controllers\Admin\AdminSurveiController::class, 'DeleteIndikator']);
        Route::resource('/highlight', HighlightController::class);
    });
});

// route login
Route::get('/login', [LoginController::class, 'index'] )->name('login')->Middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate'] );
Route::post('/logout', [LoginController::class, 'logout'] );

//ROUTE PUBLIC
//route halaman awal web
Route::get('/', [\App\Http\Controllers\Public\PublicController::class, 'portal']);
Route::get('/webpusbin', [\App\Http\Controllers\Public\PublicController::class, 'web'] );



//route publikasi
Route::get('/publikasi', [\App\Http\Controllers\Public\PostController::class, 'index']);       //daftar publikasi
Route::get('/publikasi/{post:slug}', [\App\Http\Controllers\Public\PostController::class, 'show'] );    //halaman single post
Route::get('/categories/{category:slug}', function(Category $category ) {
    return view('berita.category', [
        'title' => $category -> name,
        'posts' => $category -> posts,
        'category' => $category -> name,
    ]);
});                                                                 //halaman categori post

Route::get('/categories', function( ) {
return view('berita.categories', [
    'title' => 'Kategori Publikasi',
    'categories' => Category::all()

    ]);
});                                                                 //halaman categori


//ROUTE KONSULTASI
Route::get('/konsultasi', [\App\Http\Controllers\Public\KonsultasiController::class, 'index'])->name('public.konsultasi.index');
Route::get('/konsultasi/{kegiatan:slug}', [\App\Http\Controllers\Public\KonsultasiController::class, 'create']);
Route::post('/konsultasi/{kegiatan:slug}/store', [\App\Http\Controllers\Public\KonsultasiController::class, 'store']);
Route::get('/konsultasi/cari', function () {
    return view('konsultasi.cari',[
        'title' => "Cari Konsultasi"
    ]);
});
Route::get('/konsultasi/jadwal', [AdminKonsultasiController::class, 'search']);
Route::get('/konsultasi/tiket', [AdminKonsultasiController::class, 'tiket']);

//ROUTE ABSENSI
Route::get('/absensi', [\App\Http\Controllers\Public\PublicAbsensiController::class, 'index']);
Route::get('/absensi/{kegiatan:slug}', [\App\Http\Controllers\Public\PublicAbsensiController::class, 'create']);
Route::post('/absensi/{kegiatan:slug}/store', [\App\Http\Controllers\Public\PublicAbsensiController::class, 'store']);

//ROUTE KEGIATAN
Route::get('/kegiatan', [\App\Http\Controllers\Public\PublicKegiatanController::class, 'index']);
Route::get('/kegiatan/{kegiatan:slug}', [\App\Http\Controllers\Public\PublicKegiatanController::class, 'show']);
Route::get('/kegiatan/{kegiatan:slug}/create', [\App\Http\Controllers\Public\PublicKegiatanController::class, 'create']);
Route::post('/kegiatan/{kegiatan:slug}/store', [\App\Http\Controllers\Public\PublicKegiatanController::class, 'store']);


//DATA JFK
Route::get('/data-jfk', function () {
    return view('portal.dashboard',[
        'title' => "Daftar Dashboard"
    ]);
});

//RIOUTE JDIH
Route::get('/jdihjfk', [\App\Http\Controllers\Public\JdihController::class, 'index']);

//ROUTE SURVEI
// Route::get('/survei/', [\App\Http\Controllers\Public\SurveiPublicController::class, 'index']);
// Route::get('/survei/{survei}/create', [\App\Http\Controllers\Public\SurveiPublicController::class, 'create']);
// Route::get('/survei/{survei}/create/store', [\App\Http\Controllers\Public\SurveiPublicController::class, 'store']);

//ROUTE ABOUT
Route::get('/layanan/pengajuan-rekomendasi', [\App\Http\Controllers\Public\PublicController::class, 'kebutuhan']);
Route::get('/layanan/pengembangan-kompetensi', [\App\Http\Controllers\Public\PublicController::class, 'pengembangan']);
Route::get('/layanan/uji-kompetensi', [\App\Http\Controllers\Public\PublicController::class, 'ujikom']);
Route::get('/layanan/perpindahan-audiwan', [\App\Http\Controllers\Public\PublicController::class, 'audiwan']);
Route::get('/about/tentang-kami', [\App\Http\Controllers\Public\PublicController::class, 'about']);
Route::get('/about/kontak-kami', [\App\Http\Controllers\Public\PublicController::class, 'kontak']);
Route::get('/about/kepala-pusat', [\App\Http\Controllers\Public\PublicController::class, 'kapus']);
Route::get('/about/visi-misi', [\App\Http\Controllers\Public\PublicController::class, 'visimisi']);
Route::get('/about/struktur-organisasi', [\App\Http\Controllers\Public\PublicController::class, 'struktur']);


Route::get('/getapi', [\App\Http\Controllers\Admin\AdminLayananController::class, 'getData']);
Route::get('/get', [\App\Http\Controllers\Admin\AdminLayananController::class, 'inputData']);
Route::get('/getpublic', [\App\Http\Controllers\Admin\AdminLayananController::class, 'getProdtoken']);
Route::get('/getauth', [\App\Http\Controllers\Admin\AdminLayananController::class, 'getAuthtoken']);












