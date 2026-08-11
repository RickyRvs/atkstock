@extends('layouts.app')
@section('title', 'Manajemen User')

@section('content')
<div class="space-y-5">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="text-xl font-bold text-gray-800">Manajemen User</h1>
            <p class="text-sm text-gray-500 mt-0.5">Kelola akun, role, dan akses instansi pengguna sistem.</p>
        </div>
        <a href="{{ route('users.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2.5 rounded-lg font-medium transition-colors flex items-center justify-center gap-1.5 shadow-sm shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah User
        </a>
    </div>

    {{-- Stat cards --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        <div class="bg-white rounded-xl shadow-sm p-4">
            <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">Total User</p>
            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $users->total() }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4">
            <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">Admin</p>
            <p class="text-2xl font-bold text-purple-600 mt-1">{{ $users->where('role', 'admin')->count() }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4">
            <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">Petugas</p>
            <p class="text-2xl font-bold text-gray-600 mt-1">{{ $users->where('role', 'petugas')->count() }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4">
            <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">Aktif</p>
            <p class="text-2xl font-bold text-green-600 mt-1">{{ $users->where('is_active', true)->count() }}</p>
        </div>
    </div>

    {{-- Search / filter --}}
    <div class="bg-white rounded-xl shadow-sm p-4">
        <form action="{{ route('users.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari nama atau email..."
                       class="w-full rounded-lg border-gray-300 text-sm pl-9 focus:border-blue-500 focus:ring-blue-500">
            </div>
            <select name="role" onchange="this.form.submit()"
                    class="rounded-lg border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500 sm:w-44">
                <option value="">Semua Role</option>
                <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="petugas" {{ request('role') === 'petugas' ? 'selected' : '' }}>Petugas</option>
            </select>
            <button type="submit"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm px-4 py-2 rounded-lg font-medium transition-colors">
                Cari
            </button>
            @if(request('search') || request('role'))
                <a href="{{ route('users.index') }}"
                   class="text-sm text-gray-400 hover:text-gray-600 px-2 py-2 flex items-center justify-center">
                    Reset
                </a>
            @endif
        </form>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b text-left text-xs text-gray-500 uppercase tracking-wide">
                        <th class="px-5 py-3 font-medium">Nama</th>
                        <th class="px-5 py-3 font-medium">Role</th>
                        <th class="px-5 py-3 font-medium">Instansi</th>
                        <th class="px-5 py-3 font-medium">Status</th>
                        <th class="px-5 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($users as $user)
                        @php
                            $palettes = ['bg-blue-100 text-blue-700','bg-emerald-100 text-emerald-700','bg-amber-100 text-amber-700','bg-rose-100 text-rose-700','bg-indigo-100 text-indigo-700','bg-cyan-100 text-cyan-700'];
                            $palette = $palettes[$user->id % count($palettes)];
                        @endphp
                        <tr class="hover:bg-gray-50/70 transition-colors">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full {{ $palette }} flex items-center justify-center text-xs font-semibold flex-shrink-0">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <p class="font-medium text-gray-800 truncate flex items-center gap-1.5">
                                            {{ $user->name }}
                                            @if($user->id === auth()->id())
                                                <span class="text-[10px] text-blue-500 font-semibold bg-blue-50 px-1.5 py-0.5 rounded">Anda</span>
                                            @endif
                                        </p>
                                        <p class="text-xs text-gray-400 truncate">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="text-xs font-medium px-2.5 py-1 rounded-full capitalize inline-flex items-center gap-1
                                    {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-gray-100 text-gray-700' }}">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5">
                                @if($user->instansiAksesibel->isEmpty())
                                    <span class="text-xs text-gray-400 italic">Belum ada instansi</span>
                                @else
                                    <div class="flex flex-wrap gap-1 max-w-xs">
                                        @foreach($user->instansiAksesibel->take(3) as $ins)
                                            <span class="text-xs px-2 py-0.5 rounded-full whitespace-nowrap
                                                {{ $ins->pivot->is_home ? 'bg-blue-50 text-blue-700 font-medium ring-1 ring-blue-200' : 'bg-gray-50 text-gray-600' }}">
                                                {{ $ins->nama }}
                                                @if($ins->pivot->is_home)
                                                    <span class="text-blue-400">&bull;</span>
                                                @endif
                                            </span>
                                        @endforeach
                                        @if($user->instansiAksesibel->count() > 3)
                                            <span class="text-xs px-2 py-0.5 rounded-full bg-gray-50 text-gray-500">
                                                +{{ $user->instansiAksesibel->count() - 3 }} lainnya
                                            </span>
                                        @endif
                                    </div>
                                @endif
                            </td>
                            <td class="px-5 py-3.5">
                                @if($user->is_active)
                                    <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-green-100 text-green-700 inline-flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Aktif
                                    </span>
                                @else
                                    <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-red-100 text-red-700 inline-flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('users.show', $user) }}" title="Detail"
                                       class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('users.edit', $user) }}" title="Edit"
                                       class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-amber-600 hover:bg-amber-50 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('users.destroy', $user) }}" method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus user {{ $user->name }}?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Hapus"
                                                    class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-14">
                                <div class="flex flex-col items-center justify-center text-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-5.13a4 4 0 11-4-4 4 4 0 014 4zm6 0a4 4 0 11-4-4"/>
                                    </svg>
                                    <p class="text-sm text-gray-400">
                                        @if(request('search') || request('role'))
                                            Tidak ada user yang cocok dengan pencarian.
                                        @else
                                            Belum ada data user.
                                        @endif
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="px-5 py-4 border-t">
                {{ $users->links() }}
            </div>
        @endif
    </div>

</div>
@endsection