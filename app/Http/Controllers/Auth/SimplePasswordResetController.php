<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class SimplePasswordResetController extends Controller
{
    /**
     * Display the simple password reset view.
     */
    public function create()
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming simple password reset request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Find the user by username or phone
        $user = User::where('username', $request->login)
                    ->orWhere('phone', $request->login)
                    ->first();

        if (!$user) {
            return back()->withErrors(['login' => 'Akun dengan Username atau Nomor HP tersebut tidak ditemukan.']);
        }

        // Update the password directly
        $user->forceFill([
            'password' => Hash::make($request->password)
        ])->save();

        return redirect()->route('login')->with('status', 'Password berhasil direset! Silakan masuk dengan password baru Anda.');
    }
}
