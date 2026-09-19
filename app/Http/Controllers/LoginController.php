<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\User;
use App\Services\SiasnSsoService;
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
        'active' => "Login",
        'siasnEnabled' => app(SiasnSsoService::class)->isConfigured(),
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

        return $this->proceedAfterCredentialsVerified($request, $user, 'lokal');
    }

    /**
     * Login pakai SSO SIASN: NIP + password SIASN diverifikasi ke BKN,
     * lalu dicocokkan ke akun admin lokal yang NIP-nya sudah ditautkan
     * (lihat kolom nip di tabel users). Identitas valid di SIASN TIDAK
     * otomatis memberi akses admin - akun lokalnya harus sudah ada &
     * ditautkan lebih dulu oleh Super Admin.
     */
    public function authenticateSiasn(Request $request, SiasnSsoService $siasn)
    {
        if (! $siasn->isConfigured()) {
            return back()->with('loginerror', 'Login SSO SIASN belum diaktifkan.');
        }

        $credentials = $request->validate([
            'nip' => 'required|string',
            'password' => 'required|string',
        ]);

        $identity = $siasn->authenticate($credentials['nip'], $credentials['password']);

        if (! $identity) {
            AuditLog::record('login-failed', 'Percobaan login SSO SIASN gagal untuk NIP ' . $credentials['nip']);

            return back()->with('loginerror', 'NIP atau password SIASN salah.');
        }

        $user = User::where('nip', $identity['nip'])->first();

        if (! $user) {
            AuditLog::record('login-failed', 'Login SIASN berhasil tapi NIP ' . $identity['nip'] . ' belum ditautkan ke akun admin manapun.');

            return back()->with('loginerror', 'Identitas SIASN Anda valid, tapi belum terdaftar sebagai admin di portal ini. Hubungi Super Admin untuk menautkan NIP Anda.');
        }

        return $this->proceedAfterCredentialsVerified($request, $user, 'SSO SIASN');
    }

    /**
     * Titik temu setelah kredensial (lokal maupun SIASN) terverifikasi:
     * lanjut ke tantangan 2FA jika aktif, atau langsung masuk.
     */
    protected function proceedAfterCredentialsVerified(Request $request, User $user, string $via)
    {
        if ($user->hasTwoFactorEnabled()) {
            $request->session()->put('2fa:user:id', $user->id);

            return redirect('/login/verifikasi-2fa');
        }

        Auth::login($user);
        $request->session()->regenerate();
        AuditLog::record('login', $user->name . " login ke panel admin ({$via})");

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
