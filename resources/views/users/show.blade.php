@extends('layouts.app')
@section('title', 'Detail User')

@section('content')
<div class="max-w-xl mx-auto">

    <div class="mb-5">
        <a href="{{ route('users.index') }}" class="text-sm text-gray-500 hover:text-gray-700 flex items-center gap-1.5">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke daftar user
        </a>
        <h1 class="text-xl font-bold text-gray-800 mt-2">Detail User</h1>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">

        {{-- Profile header --}}
        <div class="bg-gradient-to-br from-blue-50 to-white px-6 py-6 border-b border-gray-100">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center text-2xl font-semibold flex-shrink-0 ring-4 ring-white shadow-sm">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <p class="text-base font-bold text-gray-800 flex items-center gap-1.5">
                        {{ $user->name }}
                        @if($user->id === auth()->id())
                            <span class="text-[10px] text-blue-500 font-semibold bg-blue-100 px-1.5 py-0.5 rounded">Anda</span>
                        @endif
                    </p>
                    <p class="text-sm text-gray-500 truncate">{{ $user->email }}</p>
                    <div class="flex items-center gap-2 mt-2">
                        <span class="text-xs font-medium px-2.5 py-1 rounded-full capitalize
                            {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-gray-100 text-gray-700' }}">
                            {{ $user->role }}
                        </span>
                        @if($user->is_active)
                            <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-green-100 text-green-700 inline-flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Aktif
                            </span>
                        @else
                            <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-red-100 text-red-700 inline-flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Nonaktif
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="p-6">
            {{-- Quick stats --}}
            <div class="grid grid-cols-2 gap-3 mb-5">
                <div class="bg-gray-50 rounded-lg p-3.5 text-center">
                    <p class="text-xl font-bold text-gray-800">{{ $user->transaksis()->count() }}</p>
                    <p class="text-xs text-gray-500 mt-0.5">Transaksi Diinput</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-3.5 text-center">
                    <p class="text-xl font-bold text-gray-800">{{ $user->instansiAksesibel->count() }}</p>
                    <p class="text-xs text-gray-500 mt-0.5">Instansi Diakses</p>
                </div>
            </div>

            <dl class="divide-y text-sm">
                <div class="py-3">
                    <dt class="text-gray-500 mb-2 flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2M5 21h2m0 0h10"/>
                        </svg>
                        Instansi Diakses
                    </dt>
                    <dd>
                        @if($user->instansiAksesibel->isEmpty())
                            <span class="text-xs text-gray-400 italic">Belum ada instansi</span>
                        @else
                            <div class="flex flex-wrap gap-1.5">
                                @foreach($user->instansiAksesibel as $ins)
                                    <span class="text-xs px-2.5 py-1 rounded-full
                                        {{ $ins->pivot->is_home ? 'bg-blue-50 text-blue-700 font-medium ring-1 ring-blue-200' : 'bg-gray-50 text-gray-600' }}">
                                        {{ $ins->nama }}{{ $ins->pivot->is_home ? ' &middot; Home' : '' }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </dd>
                </div>
                <div class="py-3 flex items-center justify-between">
                    <dt class="text-gray-500 flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Terdaftar Sejak
                    </dt>
                    <dd class="text-gray-800">{{ $user->created_at->isoFormat('D MMMM Y, HH:mm') }}</dd>
                </div>
            </dl>
        </div>

        <div class="flex items-center justify-end gap-3 px-6 py-4 bg-gray-50 border-t">
            <a href="{{ route('users.edit', $user) }}"
               class="bg-amber-500 hover:bg-amber-600 text-white text-sm px-4 py-2 rounded-lg font-medium transition-colors flex items-center gap-1.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit User
            </a>
        </div>
    </div>

</div>
@endsection