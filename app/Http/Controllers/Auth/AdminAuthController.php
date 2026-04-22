<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminAuthController extends Controller
{
    /**
     * Constructor
     * - middleware guest untuk guard admin (optional diaktifkan).
     */
    public function __construct()
    {
        // $this->middleware('guest:admin')->except('logout');
    }

    /**
     * Tampilkan halaman login admin.
     */
    public function showLogin()
    {
        return response()->view('Adminn.login')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    /**
     * Proses login admin.
     */
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Jika sudah ada admin login, logout dulu
        if (Auth::guard('admin')->check()) {
            Log::info('Admin re-login: logging out current admin', [
                'current_admin_id' => Auth::guard('admin')->id(),
                'attempt_email'    => $request->input('email'),
                'ip'               => $request->ip(),
            ]);

            Auth::guard('admin')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        // Coba login admin
        if (Auth::guard('admin')->attempt($credentials)) {

            // Regenerate session (security)
            $request->session()->regenerate();

            Log::info('Admin login success', [
                'admin_id' => Auth::guard('admin')->id(),
                'ip'       => $request->ip(),
            ]);

            return redirect()->intended(route('adminn.barang.index'));
        }

        // Jika gagal
        return redirect()->route('adminn.login')
            ->withErrors(['login' => 'Email atau password salah!'])
            ->withInput($request->only('email'));
    }

    /**
     * Logout admin.
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('adminn.login');
    }
}
