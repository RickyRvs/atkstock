<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', pengaturan()->nama_sistem) — {{ pengaturan()->nama_instansi }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
   <style>
    body { font-family: 'Inter', sans-serif; }
    .choices__inner {
        border-radius: 0.5rem;
        border-color: #d1d5db;
        font-size: 0.875rem;
        padding: 0.4rem 0.75rem;
        min-height: unset;
    }
    .choices__list--dropdown .choices__item--selectable.is-highlighted {
        background-color: #eff6ff;
    }
    .choices__list--dropdown {
        max-height: 200px;
        overflow-y: auto;
    }
    .choices__list--dropdown .choices__list {
        max-height: 200px;
        overflow-y: auto;
    }
</style>
</head>
<body class="bg-gray-50 min-h-screen" x-data="{ sidebarOpen: true }">

<div class="flex h-screen overflow-hidden">

    {{-- ============================================================ --}}
    {{-- SIDEBAR --}}
    {{-- ============================================================ --}}
    <aside class="bg-slate-900 flex flex-col transition-all duration-200 flex-shrink-0"
           :class="sidebarOpen ? 'w-60' : 'w-14'">

        {{-- Logo --}}
        <div class="flex items-center gap-3 px-4 h-14 border-b border-slate-700 flex-shrink-0">
            @if(pengaturan()->logo_url)
                <img src="{{ pengaturan()->logo_url }}" alt="Logo" class="w-7 h-7 flex-shrink-0 object-contain">
            @else
                <img src="{{ asset('images/logo-magang-hub.png') }}" alt="Logo" class="w-7 h-7 flex-shrink-0 object-contain">
            @endif
            <div x-show="sidebarOpen" x-transition:enter="transition-opacity duration-150"
                 x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                <p class="text-xs font-semibold text-white leading-tight">{{ pengaturan()->nama_sistem }}</p>
                <p class="text-xs text-slate-400 leading-tight">{{ pengaturan()->nama_instansi }}</p>
            </div>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 overflow-y-auto py-3 space-y-0.5 px-2">

            {{-- ── MENU UTAMA ── --}}
            <div x-show="sidebarOpen" class="px-2 pt-1 pb-1">
                <p class="text-xs font-medium text-slate-500 uppercase tracking-widest">Menu</p>
            </div>

            @php
                $navItems = [
                    [
                        'route' => 'dashboard',
                        'label' => 'Dashboard',
                        'match' => 'dashboard',
                        'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>',
                    ],
                    [
                        'route' => 'barang.index',
                        'label' => 'Master Barang',
                        'match' => 'barang*',
                        'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/></svg>',
                    ],
                    [
                        'route' => 'kategori.index',
                        'label' => 'Kategori',
                        'match' => 'kategori*',
                        'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/></svg>',
                    ],
                    [
                        'route' => 'stok-awal.index',
                        'label' => 'Stok Awal',
                        'match' => 'stok-awal*',
                        'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>',
                    ],
                    [
                        'route' => 'transaksi.index',
                        'label' => 'Transaksi',
                        'match' => 'transaksi*',
                        'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>',
                    ],
                ];
            @endphp

            @foreach($navItems as $item)
                <a href="{{ route($item['route']) }}"
                   class="flex items-center gap-2.5 px-2 py-2 rounded-lg text-sm transition-colors
                          {{ request()->routeIs($item['match'])
                              ? 'bg-blue-600 text-white font-medium'
                              : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}"
                   title="{{ $item['label'] }}">
                    <span class="{{ request()->routeIs($item['match']) ? 'text-white' : 'text-slate-400' }}">
                        {!! $item['icon'] !!}
                    </span>
                    <span x-show="sidebarOpen" class="truncate">{{ $item['label'] }}</span>
                </a>
            @endforeach

            {{-- ── LAPORAN ── --}}
            <div x-show="sidebarOpen" class="px-2 pt-4 pb-1">
                <p class="text-xs font-medium text-slate-500 uppercase tracking-widest">Laporan</p>
            </div>
            <div x-show="!sidebarOpen" class="my-2 border-t border-slate-700"></div>

            @php
                $laporanItems = [
                    [
                        'route' => 'laporan.kartu-persediaan',
                        'label' => 'Kartu Persediaan',
                        'match' => 'laporan.kartu-persediaan*',
                        'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>',
                    ],
                    [
                        'route' => 'laporan.bulanan',
                        'label' => 'Laporan Bulanan',
                        'match' => 'laporan.bulanan*',
                        'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>',
                    ],
                    [
                        'route' => 'laporan.tahunan',
                        'label' => 'Rekap Tahunan',
                        'match' => 'laporan.tahunan*',
                        'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>',
                    ],
                ];
            @endphp

            @foreach($laporanItems as $item)
                <a href="{{ route($item['route']) }}"
                   class="flex items-center gap-2.5 px-2 py-2 rounded-lg text-sm transition-colors
                          {{ request()->routeIs($item['match'])
                              ? 'bg-blue-600 text-white font-medium'
                              : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}"
                   title="{{ $item['label'] }}">
                    <span class="{{ request()->routeIs($item['match']) ? 'text-white' : 'text-slate-400' }}">
                        {!! $item['icon'] !!}
                    </span>
                    <span x-show="sidebarOpen" class="truncate">{{ $item['label'] }}</span>
                </a>
            @endforeach

            {{-- ── ADMIN ── --}}
            @if(auth()->user()->isAdmin())
                <div x-show="sidebarOpen" class="px-2 pt-4 pb-1">
                    <p class="text-xs font-medium text-slate-500 uppercase tracking-widest">Admin</p>
                </div>
                <div x-show="!sidebarOpen" class="my-2 border-t border-slate-700"></div>

                @php
                    $adminItems = [
                        [
                            'route' => 'users.index',
                            'label' => 'Manajemen User',
                            'match' => 'users*',
                            'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>',
                        ],
                        [
                            'route' => 'pengaturan.edit',
                            'label' => 'Pengaturan Sistem',
                            'match' => 'pengaturan*',
                            'icon'  => '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>',
                        ],
                    ];
                @endphp

                @foreach($adminItems as $item)
                    <a href="{{ route($item['route']) }}"
                       class="flex items-center gap-2.5 px-2 py-2 rounded-lg text-sm transition-colors
                              {{ request()->routeIs($item['match'])
                                  ? 'bg-blue-600 text-white font-medium'
                                  : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}"
                       title="{{ $item['label'] }}">
                        <span class="{{ request()->routeIs($item['match']) ? 'text-white' : 'text-slate-400' }}">
                            {!! $item['icon'] !!}
                        </span>
                        <span x-show="sidebarOpen" class="truncate">{{ $item['label'] }}</span>
                    </a>
                @endforeach
            @endif

        </nav>

        {{-- User info + Logout --}}
        <div class="border-t border-slate-700 px-3 py-3 flex-shrink-0">
            <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs font-semibold flex-shrink-0">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div x-show="sidebarOpen" class="flex-1 min-w-0">
                    <p class="text-xs font-medium text-white truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-slate-400 capitalize">{{ auth()->user()->role }}</p>
                </div>
                <div x-show="sidebarOpen">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="text-slate-400 hover:text-red-400 transition-colors"
                                title="Keluar">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </aside>

    {{-- ============================================================ --}}
    {{-- MAIN CONTENT --}}
    {{-- ============================================================ --}}
    <div class="flex-1 flex flex-col overflow-hidden min-w-0">

        {{-- Topbar --}}
        <header class="bg-white border-b border-gray-200 px-5 h-14 flex items-center justify-between flex-shrink-0">
            <div class="flex items-center gap-3">
                <button @click="sidebarOpen = !sidebarOpen"
                        class="text-gray-400 hover:text-gray-600 transition-colors p-1 rounded-md hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <div class="flex items-center gap-1.5 text-sm text-gray-500">
                    <a href="{{ route('dashboard') }}" class="hover:text-gray-800 transition-colors">{{ pengaturan()->nama_instansi }}</a>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                    <span class="text-gray-800 font-medium">@yield('title', 'Dashboard')</span>
                </div>
            </div>
            <div class="flex items-center gap-3">

                {{-- ================================================== --}}
                {{-- DROPDOWN SWITCH AKUN --}}
                {{-- ================================================== --}}
                @php
                    $linkedAccounts = \App\Models\AccountSwitchLink::with('user')
                        ->where('device_token', request()->cookie('device_token'))
                        ->whereHas('user', fn ($q) => $q->where('is_active', true))
                        ->get()
                        ->unique('user_id');
                @endphp

                <div x-data="{ openAcc: false, showAdd: false }" class="relative">
                    <button @click="openAcc = !openAcc"
                            class="flex items-center gap-2 text-sm border border-gray-200 rounded-lg px-3 py-1.5 hover:bg-gray-50 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-5.13a4 4 0 11-4-4 4 4 0 014 4zm6 0a4 4 0 11-4-4"/>
                        </svg>
                        <span class="font-medium text-gray-700 max-w-[100px] truncate">{{ auth()->user()->name }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div x-show="openAcc" @click.away="openAcc = false" x-cloak
                         class="absolute right-0 mt-2 bg-white shadow-lg border border-gray-100 rounded-xl w-72 py-1.5 z-50">
                        <p class="px-3 py-1.5 text-xs text-gray-400 uppercase tracking-wide font-medium">Akun Tersimpan</p>

                        @foreach($linkedAccounts as $link)
                            <div class="flex items-center justify-between px-3 py-2 hover:bg-gray-50 group">
                                <form method="POST" action="{{ route('account-switch.switch', $link->user_id) }}" class="flex-1 min-w-0">
                                    @csrf
                                    <button type="submit" class="text-left w-full {{ $link->user_id === auth()->id() ? 'text-blue-600 font-semibold' : 'text-gray-700' }}">
                                        <span class="text-sm block truncate">{{ $link->user->name }}</span>
                                        <span class="text-xs text-gray-400 block truncate">{{ $link->user->email }}</span>
                                    </button>
                                </form>

                                <div class="flex items-center gap-1 flex-shrink-0">
                                    @if($link->user_id === auth()->id())
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    @endif
                                    <form method="POST" action="{{ route('account-switch.destroy', $link->user_id) }}"
                                          onsubmit="return confirm('Lepas akun {{ $link->user->name }} dari daftar ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Lepas akun" class="text-gray-300 hover:text-red-500 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach

                        <hr class="my-1">
                        <button @click="showAdd = true; openAcc = false"
                                class="w-full text-left px-3 py-2 text-sm text-blue-600 hover:bg-gray-50 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                            Tambah Akun Lain
                        </button>
                    </div>

                    {{-- Modal tambah akun --}}
                    <div x-show="showAdd" x-cloak
                         class="fixed inset-0 bg-black/30 flex items-center justify-center z-50" style="display: none;">
                        <div @click.away="showAdd = false" class="bg-white rounded-xl p-5 w-80 space-y-3 shadow-xl">
                            <div class="flex items-center justify-between">
                                <h3 class="text-sm font-semibold text-gray-800">Tambah Akun</h3>
                                <button @click="showAdd = false" class="text-gray-400 hover:text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                            <form method="POST" action="{{ route('account-switch.store') }}" class="space-y-2">
                                @csrf
                                <input type="email" name="email" placeholder="Email" required
                                       class="w-full rounded-lg border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500">
                                <input type="password" name="password" placeholder="Password" required
                                       class="w-full rounded-lg border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('email')
                                    <p class="text-xs text-red-600">{{ $message }}</p>
                                @enderror
                                <button type="submit"
                                        class="w-full bg-blue-600 hover:bg-blue-700 text-white text-sm py-2 rounded-lg font-medium transition-colors">
                                    Masuk & Tambah
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- ================================================== --}}
                {{-- DROPDOWN SWITCH INSTANSI (sudah ada sebelumnya) --}}
                {{-- ================================================== --}}
                @if(auth()->user()->instansiAksesibel->count() > 1)
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open"
                                class="flex items-center gap-2 text-sm border border-gray-200 rounded-lg px-3 py-1.5 hover:bg-gray-50 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2M5 21h2m0 0h10M9 7h1m0 4h1m4-4h1m-1 4h1M9 21v-4a1 1 0 011-1h4a1 1 0 011 1v4"/>
                            </svg>
                            <span class="font-medium text-gray-700">{{ instansiAktif()?->nama ?? 'Pilih Instansi' }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div x-show="open" @click.away="open = false" x-cloak
                             class="absolute right-0 mt-2 bg-white shadow-lg border border-gray-100 rounded-xl w-64 py-1.5 z-50">
                            <p class="px-3 py-1.5 text-xs text-gray-400 uppercase tracking-wide font-medium">Pilih Instansi</p>
                            @foreach(auth()->user()->instansiAksesibel as $ins)
                                <form method="POST" action="{{ route('instansi.switch') }}">
                                    @csrf
                                    <input type="hidden" name="instansi_id" value="{{ $ins->id }}">
                                    <button type="submit"
                                            class="w-full text-left px-3 py-2 text-sm hover:bg-gray-50 flex items-center justify-between
                                                   {{ $ins->id == session('instansi_aktif_id') ? 'text-blue-600 font-semibold bg-blue-50' : 'text-gray-700' }}">
                                        {{ $ins->nama }}
                                        @if($ins->id == session('instansi_aktif_id'))
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                        @endif
                                    </button>
                                </form>
                            @endforeach
                        </div>
                    </div>
                @endif

                <span class="text-xs text-gray-400">{{ now()->isoFormat('D MMM Y') }}</span>
            </div>
        </header>

        {{-- Flash Messages --}}
        @if(session('success') || session('error'))
            <div class="px-5 pt-4 space-y-2 flex-shrink-0">
                @if(session('success'))
                    <div class="flex items-center justify-between gap-3 bg-green-50 border border-green-200 text-green-800 text-sm px-4 py-2.5 rounded-lg"
                         x-data x-init="setTimeout(() => $el.remove(), 4000)">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>{{ session('success') }}</span>
                        </div>
                        <button @click="$el.remove()" class="text-green-500 hover:text-green-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="flex items-center justify-between gap-3 bg-red-50 border border-red-200 text-red-800 text-sm px-4 py-2.5 rounded-lg"
                         x-data x-init="setTimeout(() => $el.remove(), 5000)">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>{{ session('error') }}</span>
                        </div>
                        <button @click="$el.remove()" class="text-red-500 hover:text-red-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                @endif
            </div>
        @endif

        {{-- Page Content --}}
        <main class="flex-1 overflow-y-auto px-5 py-5">
            @yield('content')
        </main>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.js-select-search').forEach(function (el) {
        new Choices(el, {
            searchEnabled: true,
            searchPlaceholderValue: el.dataset.placeholder || 'Cari...',
            itemSelectText: '',
            shouldSort: false,
            noResultsText: 'Barang tidak ditemukan',
            noChoicesText: 'Tidak ada pilihan',
        });
    });
});
</script>

@stack('scripts')

</body>
</html>