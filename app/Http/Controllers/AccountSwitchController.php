<?php

namespace App\Http\Controllers;

use App\Models\AccountSwitchLink;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountSwitchController extends Controller
{
    /**
     * Tambah akun baru ke daftar switcher device ini (butuh verifikasi password sekali).
     */
    public function store(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        $deviceToken = $request->cookie('device_token');
        if (! $deviceToken) {
            return back()->withErrors(['email' => 'Device token tidak ditemukan, silakan refresh halaman.']);
        }

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return back()->withErrors(['email' => 'Email atau password salah.']);
        }

        if (! $user->is_active) {
            return back()->withErrors(['email' => 'Akun ini nonaktif.']);
        }

        AccountSwitchLink::firstOrCreate([
            'device_token' => $deviceToken,
            'user_id'      => $user->id,
        ]);

        Auth::loginUsingId($user->id);
        $request->session()->regenerate();

        return redirect()->route('dashboard')->with('success', "Berhasil masuk sebagai {$user->name}.");
    }

    /**
     * Pindah ke akun lain yang sudah pernah di-link di device ini, tanpa password lagi.
     */
    public function switch(Request $request, User $user)
    {
        $deviceToken = $request->cookie('device_token');

        $linked = AccountSwitchLink::where('device_token', $deviceToken)
            ->where('user_id', $user->id)
            ->exists();

        abort_unless($linked, 403, 'Akun ini belum terhubung di device ini.');
        abort_unless($user->is_active, 403, 'Akun ini nonaktif.');

        Auth::loginUsingId($user->id);
        $request->session()->regenerate();

        return redirect()->route('dashboard')->with('success', "Berpindah ke akun {$user->name}.");
    }

    /**
     * Lepas satu akun dari daftar switcher device ini (bukan hapus user-nya).
     */
    public function destroy(Request $request, User $user)
    {
        $deviceToken = $request->cookie('device_token');

        AccountSwitchLink::where('device_token', $deviceToken)
            ->where('user_id', $user->id)
            ->delete();

        // Kalau yang dilepas adalah akun yang lagi aktif, logout paksa
        if (Auth::id() === $user->id) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login');
        }

        return back()->with('success', 'Akun dilepas dari daftar switcher.');
    }
}