@extends('layouts.app')
@section('title', 'Tambah User')

@section('content')
<div class="max-w-xl">

    <div class="mb-5">
        <a href="{{ route('users.index') }}" class="text-sm text-gray-500 hover:text-gray-700 flex items-center gap-1.5">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke daftar user
        </a>
        <h1 class="text-lg font-semibold text-gray-800 mt-2">Tambah User Baru</h1>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <form action="{{ route('users.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                       class="w-full rounded-lg border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500 @error('name') border-red-400 @enderror"
                       placeholder="Contoh: Budi Santoso">
                @error('name')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}"
                       class="w-full rounded-lg border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500 @error('email') border-red-400 @enderror"
                       placeholder="user@bps.go.id">
                @error('email')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                <select name="role" id="role"
                        class="w-full rounded-lg border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500 @error('role') border-red-400 @enderror">
                    <option value="">-- Pilih Role --</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="petugas" {{ old('role') === 'petugas' ? 'selected' : '' }}>Petugas</option>
                </select>
                @error('role')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" id="password"
                           class="w-full rounded-lg border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500 @error('password') border-red-400 @enderror"
                           placeholder="Minimal 8 karakter">
                    @error('password')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                           class="w-full rounded-lg border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500"
                           placeholder="Ulangi password">
                </div>
            </div>
            <p class="text-xs text-gray-400 -mt-2">Password wajib mengandung huruf dan angka, minimal 8 karakter.</p>

            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('users.index') }}"
                   class="text-sm text-gray-600 hover:text-gray-800 px-4 py-2 rounded-lg font-medium transition-colors">
                    Batal
                </a>
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-5 py-2 rounded-lg font-medium transition-colors">
                    Simpan User
                </button>
            </div>
        </form>
    </div>

</div>
@endsection