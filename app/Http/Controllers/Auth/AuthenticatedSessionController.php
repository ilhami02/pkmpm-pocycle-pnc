<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Form login sederhana.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Proses login.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'login'    => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'login.required'    => 'Username atau Nomor HP wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $loginField = filter_var($request->login, FILTER_VALIDATE_INT) || preg_match('/^[0-9]+$/', $request->login) 
            ? 'phone' 
            : 'username';

        if (!Auth::attempt([$loginField => $request->login, 'password' => $request->password], $request->boolean('remember'))) {
            return back()
                ->withInput($request->only('login'))
                ->withErrors([
                    'login' => 'Username/Nomor HP atau password salah. Silakan coba lagi.',
                ]);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('home'));
    }

    /**
     * Logout.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
