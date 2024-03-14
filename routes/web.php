<?php

use App\Http\Controllers\Admin\HighlightController;
use App\Http\Controllers\Admin\KodeKonsultasiController;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdminPostController;
use App\Http\Controllers\AdminLayananController;
use App\Http\Controllers\AdminKonsultasiController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminHomeController;
use App\Http\Middleware\PreventBackHistory;
use App\Http\Controllers\AdminJadwalController;
use App\Http\Controllers\AdminKegiatanController;
use App\Http\Controllers\AdminAbsensiController;
use App\Http\Controllers\Admin\AdminJdifjfkController;
use App\Http\Controllers\Admin\AdminSurveiController;
use App\Http\Controllers\Admin\AdminSurveiIndikatorController;
use App\Http\Controllers\JdihjfkController;
use App\Http\Controllers\SurveiPublicController;

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

// Route::get('/', function () {
//     return view('portal.index');
// });

//route halaman awal web
Route::get('/', [PostController::class, 'index2'] );
Route::get('/webpusbin', [PostController::class, 'index1'] );
Route::get('/notfound', function () {
    return view('errors.404',[
        'title' => "Page Not Found"
    ]); 
});

//route publikasi
Route::get('/publikasi', [PostController::class, 'index'] );       //daftar publikasi
Route::get('/publikasi/{post:slug}', [PostController::class,'show'] );    //halaman single post
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


// route admin

// Route::get('/admin', function () {
//     return view('admin\home');
// })->Middleware('auth');

Route::get('/admin/publikasi/checkSlug', [AdminPostController::class, 'checkSlug']);
Route::get('/admin', [AdminDashboardController::class, 'home'] )->Middleware(['auth','prevent-back-history']);

Route::resource('/admin/publikasi', AdminPostController::class)->parameters(['publikasi' => 'post'])->Middleware(['auth','prevent-back-history']);
Route::resource('/admin/layanan', AdminLayananController::class)->Middleware(['auth','prevent-back-history']);
Route::resource('/admin/register', RegisterController::class)->parameters(['register' => 'user'])->Middleware(['auth','prevent-back-history']);
Route::resource('/admin/konsultasi', AdminKonsultasiController::class)->Middleware(['auth','prevent-back-history']);
Route::resource('/admin/highlight', HighlightController::class)->Middleware(['auth','prevent-back-history']);
Route::resource('/admin/jdihjfk', AdminJdifjfkController::class)->Middleware(['auth','prevent-back-history']);
Route::resource('/admin/konsultasi', AdminKonsultasiController::class)->Middleware(['auth','prevent-back-history']);
Route::resource('/admin/survei', AdminSurveiController::class)->Middleware(['auth','prevent-back-history']);
Route::resource('/admin/surveiindikator', AdminSurveiIndikatorController::class)->Middleware(['auth','prevent-back-history']);
// Route::resource('/konsultasi', AdminKonsultasiController::class);
Route::resource('/admin/dashboard', AdminDashboardController::class)->Middleware(['auth','prevent-back-history']);
Route::resource('/admin/jadwalukom', AdminJadwalController::class)->Middleware(['auth','prevent-back-history']);
Route::resource('/admin/kegiatan', AdminKegiatanController::class)->Middleware(['auth','prevent-back-history']);
Route::resource('/admin/absensi', AdminAbsensiController::class)->Middleware(['auth','prevent-back-history']);
Route::resource('/admin/kodekonsultasi', KodeKonsultasiController::class)->Middleware(['auth','prevent-back-history']);
// route login
Route::get('/login', [LoginController::class, 'index'] )->name('login')->Middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate'] );
Route::post('/logout', [LoginController::class, 'logout'] );

Route::get('/konsultasi', [AdminKonsultasiController::class,'create']);
Route::post('/konsultasi', [AdminKonsultasiController::class,'store']);

Route::post('/absensi/{kegiatan:slug}/berhasil', [AdminAbsensiController::class,'store']);
Route::get('/absensi/{kegiatan:slug}', [AdminAbsensiController::class,'create']);
Route::get('/absensi', [AdminAbsensiController::class, 'index1']);

//custom route for enrolle create
Route::get('/admin/survei/{survei}/create', [\App\Http\Controllers\Admin\AdminSurveiController::class, 'TambahIndikator']);
Route::post('/admin/survei/{survei}/store', [\App\Http\Controllers\Admin\AdminSurveiController::class, 'StoreIndikator']);
Route::delete('/admin/survei/{indikator}/delete', [\App\Http\Controllers\Admin\AdminSurveiController::class, 'DeleteIndikator']);



Route::get('/dashboard', function () {
    return view('portal.dashboard',[
        'title' => "Daftar Dashboard"
    ]);
});

Route::get('/konsultasi/cari', function () {
    return view('konsultasi.cari',[
        'title' => "Cari Konsultasi"
    ]);
});

Route::get('/konsultasi/jadwal', [AdminKonsultasiController::class, 'search']);
Route::get('/konsultasi/tiket', [AdminKonsultasiController::class, 'tiket']);

//layanan
Route::get('/layanan/pengajuan-rekomendasi', function () {
    return view('layanan.pengajuan-rekomendasi',[
        "title"=>"Pengajuan Rekomendasi",
    ]);
});

Route::get('/layanan/pengembangan-kompetensi', function () {
    return view('layanan.pengembangan-kompetensi',[
        "title"=>"Pengembangan Kompetensi",
    ]);
});

Route::get('/layanan/pendaftaran-ujikom', function () {
    return view('layanan.pendaftaran-ukom',[
        "title"=>"Pendaftara Uji Kompetensi",
    ]);
});

Route::get('/layanan/perubahan-nomenklatur', function () {
    return view('layanan.perubahan-nomenklatur',[
        "title"=>"Perubahan Nomenklatur",
    ]);
});

Route::get('/layanan/konversi-ak', function () {
    return view('layanan.konversi-ak',[
        "title"=>"Konversi Angka Kredit",
    ]);
});

Route::get('/layanan/perpindahan-audiwan', function () {
    return view('layanan.perpindahan-audiwan',[
        "title"=>"Perpindahan JF Audiwan Ke JF Lainnya",
    ]);
});

Route::get('/layanan/pengusulan-pak', function () {
    return view('layanan.pengusulan-pak',[
        "title"=>"Pengusulan Penetapan Angka Kredit",
    ]);
});



Route::resource('/admin/highlight', HighlightController::class);
Route::resource('/jdihjfk', JdihjfkController::class);
Route::get('/survei/', [\App\Http\Controllers\SurveiPublicController::class, 'index']);
Route::get('/survei/{survei}/create', [\App\Http\Controllers\SurveiPublicController::class, 'create']);
Route::get('/survei/{survei}/create/store', [\App\Http\Controllers\SurveiPublicController::class, 'store']);














