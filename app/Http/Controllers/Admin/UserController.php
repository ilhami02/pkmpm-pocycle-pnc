<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Daftar semua user.
     */
    public function index(Request $request)
    {
        $query = User::withCount('scanHistories')->latest();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate(15)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Toggle status admin user.
     */
    public function toggleAdmin(User $user)
    {
        // Jangan bisa un-admin diri sendiri
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak bisa mengubah status admin diri sendiri.');
        }

        $user->update(['is_admin' => !$user->is_admin]);

        $status = $user->is_admin ? 'dijadikan admin' : 'dicopot dari admin';
        return back()->with('success', "User {$user->name} berhasil {$status}.");
    }

    /**
     * Hapus user beserta data-datanya.
     */
    public function destroy(User $user)
    {
        // Jangan bisa hapus diri sendiri
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak bisa menghapus akun sendiri dari sini.');
        }

        $name = $user->name;

        // Hapus scan histories dan data terkait
        $user->scanHistories()->delete();
        $user->notifications()->delete();
        $user->delete();

        return back()->with('success', "User {$name} berhasil dihapus.");
    }
}
