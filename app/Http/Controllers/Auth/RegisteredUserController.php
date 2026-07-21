<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Form registrasi sederhana.
     */
    public function create(Request $request): View
    {
        // Simpan URL tujuan redirect setelah register (misal dari tutorial step 3)
        if ($request->has('redirect_to')) {
            session()->put('url.intended', $request->redirect_to);
        }

        return view('auth.register');
    }

    /**
     * Proses registrasi — hanya nama, nomor HP, password.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'alpha_dash', 'unique:'.User::class],
            'phone'    => ['required', 'string', 'regex:/^08[0-9]{8,13}$/', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'name.required'      => 'Nama wajib diisi.',
            'username.required'  => 'Username wajib diisi.',
            'username.alpha_dash'=> 'Username hanya boleh berisi huruf, angka, strip (-), atau garis bawah (_).',
            'username.unique'    => 'Username sudah terdaftar.',
            'phone.required'     => 'Nomor HP wajib diisi.',
            'phone.regex'        => 'Format nomor HP tidak valid. Gunakan format 08xxxxxxxxxx.',
            'phone.unique'       => 'Nomor HP sudah terdaftar.',
            'password.required'  => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'username' => $request->username,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->intended(route('home'));
    }
}
