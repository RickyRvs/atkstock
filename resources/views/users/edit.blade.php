@extends('layouts.app')
@section('title', 'Edit User')

@section('content')
<div class="max-w-xl">

    <div class="mb-5">
        <a href="{{ route('users.index') }}" class="text-sm text-gray-500 hover:text-gray-700 flex items-center gap-1.5">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke daftar user
        </a>
        <h1 class="text-lg font-semibold text-gray-800 mt-2">Edit User</h1>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <form action="{{ route('users.update', $user) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                       class="w-full rounded-lg border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500 @error('name') border-red-400 @enderror">
                @error('name')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                       class="w-full rounded-lg border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500 @error('email') border-red-400 @enderror">
                @error('email')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                <select name="role" id="role"
                        {{ $user->id === auth()->id() ? 'disabled' : '' }}
                        class="w-full rounded-lg border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500 @error('role') border-red-400 @enderror">
                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="petugas" {{ old('role', $user->role) === 'petugas' ? 'selected' : '' }}>Petugas</option>
                </select>
                @if($user->id === auth()->id())
                    {{-- kirim ulang value asli karena select disabled tidak ikut ter-submit --}}
                    <input type="hidden" name="role" value="{{ $user->role }}">
                    <p class="text-xs text-gray-400 mt-1">Anda tidak dapat mengubah role akun sendiri.</p>
                @endif
                @error('role')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="inline-flex items-center gap-2">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1"
                           {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                           {{ $user->id === auth()->id() ? 'disabled' : '' }}
                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span class="text-sm text-gray-700">Akun aktif</span>
                </label>
                @if($user->id === auth()->id())
                    <p class="text-xs text-gray-400 mt-1">Anda tidak dapat menonaktifkan akun sendiri.</p>
                @endif
            </div>

            <hr class="border-gray-100">

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                    <input type="password" name="password" id="password"
                           class="w-full rounded-lg border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500 @error('password') border-red-400 @enderror"
                           placeholder="Kosongkan jika tidak diubah">
                    @error('password')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                           class="w-full rounded-lg border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500"
                           placeholder="Ulangi password baru">
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('users.index') }}"
                   class="text-sm text-gray-600 hover:text-gray-800 px-4 py-2 rounded-lg font-medium transition-colors">
                    Batal
                </a>
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-5 py-2 rounded-lg font-medium transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</div>
@endsection