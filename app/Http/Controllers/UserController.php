<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('instansiAksesibel')->orderBy('name')->paginate(15);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $instansiList = Instansi::orderBy('nama')->get();
        return view('users.create', compact('instansiList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'             => ['required', 'string', 'max:255'],
            'email'            => ['required', 'email', 'unique:users,email'],
            'password'         => ['required', Password::min(8)->letters()->numbers(), 'confirmed'],
            'role'             => ['required', 'in:admin,petugas'],
            'instansi_ids'     => ['required', 'array', 'min:1'],
            'instansi_ids.*'   => ['exists:instansi,id'],
            'instansi_home_id' => ['required', 'integer', Rule::in($request->input('instansi_ids', []))],
        ]);

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role'      => $request->role,
            'is_active' => true,
        ]);

        $user->instansiAksesibel()->sync($this->buildSyncData($request));

        return redirect()->route('users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    public function show(User $user)
    {
        $user->load('instansiAksesibel');
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $instansiList = Instansi::orderBy('nama')->get();
        $user->load('instansiAksesibel');
        return view('users.edit', compact('user', 'instansiList'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'             => ['required', 'string', 'max:255'],
            'email'            => ['required', 'email', 'unique:users,email,' . $user->id],
            'role'             => ['required', 'in:admin,petugas'],
            'is_active'        => ['boolean'],
            'password'         => ['nullable', Password::min(8)->letters()->numbers(), 'confirmed'],
            'instansi_ids'     => ['required', 'array', 'min:1'],
            'instansi_ids.*'   => ['exists:instansi,id'],
            'instansi_home_id' => ['required', 'integer', Rule::in($request->input('instansi_ids', []))],
        ]);

        $data = [
            'name'      => $request->name,
            'email'     => $request->email,
            'role'      => $request->role,
            'is_active' => $request->boolean('is_active'),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        $user->instansiAksesibel()->sync($this->buildSyncData($request));

        return redirect()->route('users.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User berhasil dihapus.');
    }

    /**
     * Susun data pivot instansi_user: setiap instansi_id yang dicentang,
     * ditandai is_home = true hanya untuk yang dipilih sebagai home.
     */
    private function buildSyncData(Request $request): array
    {
        return collect($request->input('instansi_ids', []))
            ->mapWithKeys(fn ($id) => [
                (int) $id => ['is_home' => (int) $id === (int) $request->input('instansi_home_id')],
            ])
            ->toArray();
    }
}