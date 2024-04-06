<?php

namespace App\Http\Controllers\Public;

use App\Models\Jdihjfk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JdihController extends Controller
{
    public function index()
    {
        // $jdihs = Jdihjfk::latest()->filter(request(['search']))->paginate(6);
        // return $jdihs;

        return view('public.jdihjfk.index', [
            "title" => "JDIH JFK",
            "jdihs" => Jdihjfk::latest()->filter(request(['search']))->paginate(6)

        ]);
    }
}
