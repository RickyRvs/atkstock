<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Instansi;
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
     * Tampilkan form registrasi.
     */
    public function create(): View
    {
        $instansiList = Instansi::orderBy('nama')->get();

        return view('auth.register', compact('instansiList'));
    }

    /**
     * Proses registrasi user baru.
     * Role selalu di-set 'petugas' — role admin hanya bisa
     * diberikan lewat menu Manajemen User oleh admin yang sudah ada.
     * Instansi yang dipilih saat daftar otomatis jadi instansi home user.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'email'       => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password'    => ['required', 'confirmed', Rules\Password::defaults()],
            'instansi_id' => ['required', 'integer', 'exists:instansi,id'],
        ]);

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role'      => 'petugas',
            'is_active' => true,
        ]);

        $user->instansiAksesibel()->attach($request->instansi_id, [
            'is_home' => true,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard'));
    }
}