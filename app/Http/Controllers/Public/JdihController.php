<?php

namespace App\Http\Controllers\Public;

use App\Models\Jdihjfk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JdihController extends Controller
{
    public function index()
    {
        return view('public.jdihjfk.index', [
            "title" => "Repository JF MASN",
            "jdihs" => Jdihjfk::published()->latest()->filter(request(['search']))->paginate(6),
        ]);
    }
}
