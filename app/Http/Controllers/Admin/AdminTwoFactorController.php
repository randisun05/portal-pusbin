<?php

namespace App\Http\Controllers\Admin;

use App\Models\AuditLog;
use App\Services\TwoFactorAuthService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminTwoFactorController extends Controller
{
    /**
     * Halaman status & pengaturan 2FA untuk akun yang sedang login.
     */
    public function edit(Request $request, TwoFactorAuthService $twoFactor)
    {
        $user = Auth::user();
        $pendingSecret = $request->session()->get('2fa:pending:secret');

        return view('admin.two-factor.edit', [
            'title' => 'Autentikasi Dua Faktor',
            'user' => $user,
            'pendingSecret' => $pendingSecret,
            'qrCodeDataUri' => $pendingSecret ? $twoFactor->qrCodeDataUri($user, $pendingSecret) : null,
            'recoveryCodes' => $request->session()->get('2fa:new-recovery-codes'),
        ]);
    }

    /**
     * Mulai proses aktivasi: buat secret baru (belum aktif) dan tampilkan
     * QR code untuk dipindai, menunggu konfirmasi kode.
     */
    public function enable(Request $request, TwoFactorAuthService $twoFactor)
    {
        if (Auth::user()->hasTwoFactorEnabled()) {
            return redirect('/admin/two-factor')->with('info', '2FA sudah aktif untuk akun Anda.');
        }

        $request->session()->put('2fa:pending:secret', $twoFactor->generateSecretKey());
        $request->session()->forget('2fa:new-recovery-codes');

        return redirect('/admin/two-factor');
    }

    /**
     * Konfirmasi kode dari aplikasi authenticator untuk benar-benar
     * mengaktifkan 2FA, sekaligus membuat recovery code.
     */
    public function confirm(Request $request, TwoFactorAuthService $twoFactor)
    {
        $request->validate(['code' => 'required|string']);

        $secret = $request->session()->get('2fa:pending:secret');

        if (! $secret) {
            return redirect('/admin/two-factor')->with('error', 'Tidak ada proses aktivasi yang sedang berjalan. Silakan mulai lagi.');
        }

        if (! $twoFactor->verifyCode($secret, $request->input('code'))) {
            return redirect('/admin/two-factor')->with('error', 'Kode verifikasi salah. Coba pindai ulang QR dan masukkan kode terbaru.');
        }

        $recovery = $twoFactor->generateRecoveryCodes();

        $user = Auth::user();
        $user->two_factor_secret = $secret;
        $user->two_factor_recovery_codes = $recovery['hashed'];
        $user->two_factor_enabled_at = now();
        $user->save();

        $request->session()->forget('2fa:pending:secret');
        $request->session()->put('2fa:new-recovery-codes', $recovery['plain']);

        AuditLog::record('2fa-enabled', $user->name . ' mengaktifkan autentikasi dua faktor');

        return redirect('/admin/two-factor')->with('success', '2FA berhasil diaktifkan. Simpan recovery code di bawah ini di tempat yang aman.');
    }

    /**
     * Nonaktifkan 2FA. Meminta password saat ini sebagai konfirmasi supaya
     * tidak bisa dinonaktifkan begitu saja lewat sesi yang dibajak.
     */
    public function disable(Request $request)
    {
        $request->validate(['password' => 'required|string']);

        $user = Auth::user();

        if (! Hash::check($request->input('password'), $user->password)) {
            return redirect('/admin/two-factor')->with('error', 'Password salah. 2FA tidak dinonaktifkan.');
        }

        $user->two_factor_secret = null;
        $user->two_factor_recovery_codes = null;
        $user->two_factor_enabled_at = null;
        $user->save();

        $request->session()->forget(['2fa:pending:secret', '2fa:new-recovery-codes']);

        AuditLog::record('2fa-disabled', $user->name . ' menonaktifkan autentikasi dua faktor');

        return redirect('/admin/two-factor')->with('success', '2FA berhasil dinonaktifkan.');
    }
}
