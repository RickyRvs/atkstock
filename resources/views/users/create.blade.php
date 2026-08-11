@extends('layouts.app')
@section('title', 'Tambah User')

@section('content')
<div class="max-w-2xl mx-auto">

    <div class="mb-5">
        <a href="{{ route('users.index') }}" class="text-sm text-gray-500 hover:text-gray-700 flex items-center gap-1.5">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke daftar user
        </a>
        <h1 class="text-xl font-bold text-gray-800 mt-2">Tambah User Baru</h1>
        <p class="text-sm text-gray-500">Buat akun baru dan tentukan instansi yang bisa diakses.</p>
    </div>

    @if ($errors->any())
        <div class="mb-4 bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg px-4 py-3 flex items-start gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.7-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"/>
            </svg>
            <span>Ada beberapa isian yang perlu diperbaiki sebelum menyimpan.</span>
        </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST" class="space-y-5">
        @csrf

        {{-- Informasi Akun --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-sm font-semibold text-gray-800 mb-4 pb-3 border-b border-gray-100 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Informasi Akun
            </h2>

            <div class="space-y-4">
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
                <p class="text-xs text-gray-400 -mt-2 flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Password wajib mengandung huruf dan angka, minimal 8 karakter.
                </p>
            </div>
        </div>

        {{-- Akses Instansi --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6"
             x-data="{
                selected: {{ json_encode(old('instansi_ids', [])) }},
                home: {{ json_encode(old('instansi_home_id')) }},
                query: '',
                toggle(id) {
                    if (this.selected.includes(id)) {
                        this.selected = this.selected.filter(i => i !== id);
                        if (this.home === id) this.home = this.selected[0] ?? null;
                    } else {
                        this.selected.push(id);
                        if (!this.home) this.home = id;
                    }
                },
                setHome(id) {
                    if (!this.selected.includes(id)) this.selected.push(id);
                    this.home = id;
                }
             }">
            <div class="flex items-center justify-between mb-1 pb-3 border-b border-gray-100">
                <h2 class="text-sm font-semibold text-gray-800 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2M5 21h2m0 0h10M9 7h1m0 4h1m4-4h1m-1 4h1M9 21v-4a1 1 0 011-1h4a1 1 0 011 1v4"/>
                    </svg>
                    Akses Instansi
                </h2>
                <span class="text-xs font-medium px-2 py-0.5 rounded-full bg-blue-50 text-blue-600" x-text="selected.length + ' dipilih'"></span>
            </div>
            <p class="text-xs text-gray-500 mb-3 mt-3">Centang instansi yang bisa diakses user ini, lalu pilih salah satu sebagai <span class="font-medium">Home</span> (instansi default saat login).</p>

            @if(count($instansiList ?? []) > 6)
                <div class="relative mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-gray-400 absolute left-2.5 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" x-model="query" placeholder="Cari instansi..."
                           class="w-full text-xs rounded-lg border-gray-300 pl-8 py-1.5 focus:border-blue-500 focus:ring-blue-500">
                </div>
            @endif

            <div class="border border-gray-200 rounded-lg divide-y max-h-64 overflow-y-auto">
                @forelse($instansiList as $ins)
                    <div class="flex items-center justify-between px-3 py-2.5 hover:bg-gray-50"
                         x-show="query === '' || '{{ strtolower($ins->nama.' '.$ins->kode) }}'.includes(query.toLowerCase())">
                        <label class="flex items-center gap-2.5 text-sm text-gray-700 cursor-pointer flex-1">
                            <input type="checkbox" name="instansi_ids[]" value="{{ $ins->id }}"
                                   :checked="selected.includes({{ $ins->id }})"
                                   @change="toggle({{ $ins->id }})"
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span>{{ $ins->nama }}</span>
                            <span class="text-xs text-gray-400">({{ $ins->kode }})</span>
                        </label>
                        <label class="flex items-center gap-1.5 text-xs cursor-pointer"
                               :class="home === {{ $ins->id }} ? 'text-blue-600 font-semibold' : 'text-gray-400'">
                            <input type="radio" name="instansi_home_id" value="{{ $ins->id }}"
                                   :checked="home === {{ $ins->id }}"
                                   @change="setHome({{ $ins->id }})"
                                   class="text-blue-600 focus:ring-blue-500">
                            Home
                        </label>
                    </div>
                @empty
                    <p class="px-3 py-4 text-sm text-gray-400 text-center">Belum ada data instansi.</p>
                @endforelse
            </div>
            @error('instansi_ids')
                <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
            @enderror
            @error('instansi_home_id')
                <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-end gap-3 pt-1">
            <a href="{{ route('users.index') }}"
               class="text-sm text-gray-600 hover:text-gray-800 px-4 py-2 rounded-lg font-medium transition-colors">
                Batal
            </a>
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-5 py-2 rounded-lg font-medium transition-colors shadow-sm">
                Simpan User
            </button>
        </div>
    </form>

</div>
@endsection