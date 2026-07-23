@extends('layouts.app')
@section('title', 'Detail User')

@section('content')
<div class="max-w-xl">

    <div class="mb-5">
        <a href="{{ route('users.index') }}" class="text-sm text-gray-500 hover:text-gray-700 flex items-center gap-1.5">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke daftar user
        </a>
        <h1 class="text-lg font-semibold text-gray-800 mt-2">Detail User</h1>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center gap-4 mb-6">
            <div class="w-14 h-14 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center text-xl font-semibold flex-shrink-0">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <p class="text-base font-semibold text-gray-800">{{ $user->name }}</p>
                <p class="text-sm text-gray-500">{{ $user->email }}</p>
            </div>
        </div>

        <dl class="divide-y text-sm">
            <div class="py-3 flex items-center justify-between">
                <dt class="text-gray-500">Role</dt>
                <dd>
                    <span class="text-xs font-medium px-2 py-1 rounded-full capitalize
                        {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-gray-100 text-gray-700' }}">
                        {{ $user->role }}
                    </span>
                </dd>
            </div>
            <div class="py-3 flex items-center justify-between">
                <dt class="text-gray-500">Status</dt>
                <dd>
                    @if($user->is_active)
                        <span class="text-xs font-medium px-2 py-1 rounded-full bg-green-100 text-green-700">Aktif</span>
                    @else
                        <span class="text-xs font-medium px-2 py-1 rounded-full bg-red-100 text-red-700">Nonaktif</span>
                    @endif
                </dd>
            </div>
            <div class="py-3 flex items-center justify-between">
                <dt class="text-gray-500">Terdaftar Sejak</dt>
                <dd class="text-gray-800">{{ $user->created_at->isoFormat('D MMMM Y, HH:mm') }}</dd>
            </div>
            <div class="py-3 flex items-center justify-between">
                <dt class="text-gray-500">Total Transaksi Diinput</dt>
                <dd class="text-gray-800">{{ $user->transaksis()->count() }}</dd>
            </div>
        </dl>

        <div class="flex items-center justify-end gap-3 pt-5 mt-2 border-t">
            <a href="{{ route('users.edit', $user) }}"
               class="bg-amber-500 hover:bg-amber-600 text-white text-sm px-4 py-2 rounded-lg font-medium transition-colors">
                Edit User
            </a>
        </div>
    </div>

</div>
@endsection