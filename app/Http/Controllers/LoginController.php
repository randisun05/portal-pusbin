<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\User;
use App\Services\TwoFactorAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

        $user = User::where('email', $credentials['email'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            AuditLog::record('login-failed', 'Percobaan login gagal untuk email ' . $credentials['email']);

            return back()->with('loginerror', 'Login Gagal');
        }

        if ($user->hasTwoFactorEnabled()) {
            $request->session()->put('2fa:user:id', $user->id);

            return redirect('/login/verifikasi-2fa');
        }

        Auth::login($user);
        $request->session()->regenerate();
        AuditLog::record('login', $user->name . ' login ke panel admin');

        return redirect()->intended('/admin')->with('success', 'Berhasil Login');
    }

    /**
     * Tampilkan form input kode 2FA setelah email & password benar.
     */
    public function showTwoFactorChallenge(Request $request)
    {
        if (! $request->session()->has('2fa:user:id')) {
            return redirect('/login');
        }

        return view('login.verify-2fa', [
            'title' => 'Verifikasi Dua Langkah',
        ]);
    }

    /**
     * Verifikasi kode 2FA (dari aplikasi authenticator atau recovery code).
     */
    public function verifyTwoFactor(Request $request, TwoFactorAuthService $twoFactor)
    {
        $userId = $request->session()->get('2fa:user:id');

        if (! $userId) {
            return redirect('/login');
        }

        $request->validate(['code' => 'required|string']);

        $user = User::findOrFail($userId);
        $code = $request->input('code');

        if ($twoFactor->verifyCode($user->two_factor_secret, $code)) {
            $request->session()->forget('2fa:user:id');
            Auth::login($user);
            $request->session()->regenerate();
            AuditLog::record('login', $user->name . ' login ke panel admin (2FA)');

            return redirect()->intended('/admin')->with('success', 'Berhasil Login');
        }

        $recoveryCodes = $user->two_factor_recovery_codes ?? [];
        $matchIndex = $twoFactor->matchRecoveryCode($recoveryCodes, $code);

        if (! is_null($matchIndex)) {
            unset($recoveryCodes[$matchIndex]);
            $user->two_factor_recovery_codes = array_values($recoveryCodes);
            $user->save();

            $request->session()->forget('2fa:user:id');
            Auth::login($user);
            $request->session()->regenerate();
            AuditLog::record('login', $user->name . ' login ke panel admin (recovery code 2FA)');

            return redirect()->intended('/admin')->with('success', 'Berhasil Login menggunakan recovery code. Sisa recovery code: ' . count($user->two_factor_recovery_codes));
        }

        AuditLog::record('login-failed', 'Kode 2FA salah untuk ' . $user->email);

        return back()->with('loginerror', 'Kode verifikasi salah atau sudah kedaluwarsa.');
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
