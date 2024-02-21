<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\Layanan;
use App\Models\Dashboard;
use App\Models\Konsultasi;
use RealRashid\SweetAlert\Facades\Alert;

class AdminHomeController extends Controller
{
    public function index()
    {
        return view('admin.home', [
            $sumpost = Post::count(),
            "sumpost" => $sumpost,
            "sumumum" => Post::where('category_id',1)->count(),
            "sumpeng" => Post::where('category_id',2)->count(),
            "sumkegiatan" => Post::where('category_id',3)->count(),
            "sumlay" => Layanan::count(),
            "sumdashb" => Dashboard::count(),
            "sumkonsul" => Konsultasi::count(),
        ]);
    }

}
