<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun — {{ pengaturan()->nama_sistem }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }

        .bg-animated {
            background: linear-gradient(-45deg, #1e3a8a, #1d4ed8, #0369a1, #1e40af);
            background-size: 400% 400%;
            animation: gradientShift 12s ease infinite;
        }
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .blob {
            position: absolute;
            border-radius: 9999px;
            filter: blur(60px);
            opacity: 0.35;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.97);
            backdrop-filter: blur(10px);
        }

        .input-focus:focus {
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
        }
    </style>
</head>
<body class="bg-animated min-h-screen flex items-center justify-center p-4 relative overflow-hidden">

    {{-- Dekorasi blob --}}
    <div class="blob w-96 h-96 bg-blue-400 -top-20 -left-20"></div>
    <div class="blob w-96 h-96 bg-cyan-300 -bottom-20 -right-20"></div>
    <div class="blob w-72 h-72 bg-indigo-400 top-1/3 right-10"></div>

    <div class="relative w-full max-w-lg">
        <div class="glass-card rounded-3xl shadow-2xl w-full p-10 border border-white/40">

            {{-- Logo & judul --}}
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-blue-50 mb-4 shadow-sm">
                    @if(pengaturan()->logo_url)
                        <img src="{{ pengaturan()->logo_url }}" alt="Logo" class="w-10 h-10 object-contain">
                    @else
                        <img src="{{ asset('images/logo-magang-hub.png') }}" alt="Logo" class="w-10 h-10 object-contain">
                    @endif
                </div>
                <h1 class="text-xl font-bold text-gray-800">Buat Akun Baru</h1>
                <p class="text-sm text-gray-500 mt-1">{{ pengaturan()->nama_instansi }}</p>
            </div>

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-xl mb-5 flex items-start gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-4" x-data="{ showPassword: false, showConfirm: false }">
                @csrf

                {{-- Nama & Email sejajar --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap</label>
                        <div class="relative">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <input type="text" name="name" value="{{ old('name') }}" required autofocus
                                   class="input-focus w-full border border-gray-300 rounded-xl pl-10 pr-3 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-all @error('name') border-red-400 @enderror"
                                   placeholder="Nama sesuai identitas">
                        </div>
                        @error('name') <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                        <div class="relative">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                            </svg>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                   class="input-focus w-full border border-gray-300 rounded-xl pl-10 pr-3 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-all @error('email') border-red-400 @enderror"
                                   placeholder="email@bps.go.id">
                        </div>
                        @error('email') <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Instansi</label>
                    <div class="relative">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2M5 21h2m0 0h10M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5"/>
                        </svg>
                        <select name="instansi_id" required
                                class="input-focus w-full border border-gray-300 rounded-xl pl-10 pr-8 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-all appearance-none bg-white @error('instansi_id') border-red-400 @enderror">
                            <option value="" disabled {{ old('instansi_id') ? '' : 'selected' }}>Pilih instansi</option>
                            @foreach($instansiList as $instansi)
                                <option value="{{ $instansi->id }}" {{ (int) old('instansi_id') === $instansi->id ? 'selected' : '' }}>
                                    {{ $instansi->nama }}
                                </option>
                            @endforeach
                        </select>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 absolute right-3.5 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                    @error('instansi_id') <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p> @enderror
                </div>

                {{-- Password & Konfirmasi sejajar --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                        <div class="relative">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            <input :type="showPassword ? 'text' : 'password'" name="password" required
                                   class="input-focus w-full border border-gray-300 rounded-xl pl-10 pr-10 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-all @error('password') border-red-400 @enderror"
                                   placeholder="Min. 8 karakter">
                            <button type="button" @click="showPassword = !showPassword"
                                    class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"/>
                                </svg>
                            </button>
                        </div>
                        @error('password') <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Konfirmasi Password</label>
                        <div class="relative">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <input :type="showConfirm ? 'text' : 'password'" name="password_confirmation" required
                                   class="input-focus w-full border border-gray-300 rounded-xl pl-10 pr-10 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-all"
                                   placeholder="Ulangi password">
                            <button type="button" @click="showConfirm = !showConfirm"
                                    class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <svg x-show="!showConfirm" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg x-show="showConfirm" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <button type="submit"
                        class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3 rounded-xl transition-all text-sm mt-2 shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 flex items-center justify-center gap-2">
                    Daftar Akun
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </button>
            </form>

            <p class="text-center text-sm text-gray-500 mt-6">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-blue-600 font-medium hover:underline">Masuk di sini</a>
            </p>
        </div>

        <p class="text-center text-xs text-blue-100/80 mt-5">
            &copy; {{ now()->year }} {{ pengaturan()->nama_instansi }}
        </p>
    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>