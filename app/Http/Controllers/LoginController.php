<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.index', [
        'title' => "login",
        'active' => "Login"
        ]);
    }


    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            AuditLog::record('login', Auth::user()->name . ' login ke panel admin');
            return redirect()->intended('/admin')->with('success', 'Berhasil Login');
        }

        AuditLog::record('login-failed', 'Percobaan login gagal untuk email ' . $credentials['email']);

        return back()->with('loginerror', 'Login Gagal');

    }

    public function logout(Request $request)
    {

    if (Auth::check()) {
        AuditLog::record('logout', Auth::user()->name . ' logout dari panel admin');
    }

    Auth::logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect('/login');
    }


}
