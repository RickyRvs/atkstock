{{-- TARUH DI: resources/views/pengaturan/edit.blade.php --}}
@extends('layouts.app')
@section('title', 'Pengaturan Sistem')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex items-center gap-3">
        <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
        </div>
        <div>
            <h2 class="text-lg font-semibold text-gray-800">Pengaturan Sistem</h2>
            <p class="text-sm text-gray-500">Nama sistem, instansi, logo, dan tanda tangan laporan</p>
        </div>
    </div>

    {{-- Flash validation summary (kalau ada error umum) --}}
    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-4 py-3">
            Ada beberapa isian yang perlu diperbaiki di bawah.
        </div>
    @endif

    <form method="POST" action="{{ route('pengaturan.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- ===== Section: Identitas Sistem ===== --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/60">
                <h3 class="text-sm font-semibold text-gray-700">Identitas Sistem</h3>
                <p class="text-xs text-gray-400 mt-0.5">Ditampilkan di sidebar, judul halaman, dan laporan.</p>
            </div>

            <div class="p-6 space-y-5">
                <div>
                    <label class="text-sm font-medium text-gray-700 block mb-1.5">Nama Sistem</label>
                    <input type="text" name="nama_sistem" value="{{ old('nama_sistem', $pengaturan->nama_sistem) }}"
                           class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition-colors @error('nama_sistem') border-red-300 @enderror"
                           placeholder="Contoh: Sistem Stok ATK/ARK">
                    @error('nama_sistem') <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700 block mb-1.5">Nama Instansi</label>
                    <input type="text" name="nama_instansi" value="{{ old('nama_instansi', $pengaturan->nama_instansi) }}"
                           class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition-colors @error('nama_instansi') border-red-300 @enderror"
                           placeholder="Contoh: BPS Provinsi Riau">
                    @error('nama_instansi') <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="text-sm font-medium text-gray-700 block mb-1.5">Alamat Instansi <span class="text-gray-400 font-normal">(opsional)</span></label>
                        <textarea name="alamat_instansi" rows="3"
                                  class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition-colors resize-none">{{ old('alamat_instansi', $pengaturan->alamat_instansi) }}</textarea>
                        <p class="text-xs text-gray-400 mt-1.5">Muncul di footer laporan PDF, jika diisi.</p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-700 block mb-1.5">Lokasi / Kota</label>
                        <input type="text" name="kota" value="{{ old('kota', $pengaturan->kota) }}"
                               placeholder="Contoh: Pekanbaru"
                               class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition-colors @error('kota') border-red-300 @enderror">
                        <p class="text-xs text-gray-400 mt-1.5">Dipakai untuk baris tanggal di atas tanda tangan, misal "Pekanbaru, 23 Juli 2026".</p>
                        @error('kota') <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== Section: Logo ===== --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/60">
                <h3 class="text-sm font-semibold text-gray-700">Logo</h3>
                <p class="text-xs text-gray-400 mt-0.5">Tampil di sidebar dan kop laporan.</p>
            </div>

            <div class="p-6">
                <div class="flex items-center gap-5">
                    <div class="w-20 h-20 rounded-xl border border-gray-200 bg-gray-50 flex items-center justify-center flex-shrink-0 overflow-hidden">
                        @if($pengaturan->logo_url)
                            <img src="{{ $pengaturan->logo_url }}" alt="Logo saat ini" class="w-full h-full object-contain p-2">
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <input type="file" name="logo" accept="image/png,image/jpeg,image/svg+xml"
                               class="w-full text-sm text-gray-600 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 file:text-sm file:font-medium file:cursor-pointer hover:file:bg-blue-100 file:transition-colors">
                        <p class="text-xs text-gray-400 mt-1.5">PNG/JPG/SVG, maks 2MB. Kosongkan jika tidak ingin ganti.</p>
                        @error('logo') <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== Section: Tanda Tangan ===== --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/60">
                <h3 class="text-sm font-semibold text-gray-700">Tanda Tangan Laporan</h3>
                <p class="text-xs text-gray-400 mt-0.5">
                    Sampai 3 tanda tangan bisa ditampilkan berjejer di bagian bawah laporan PDF. Isi minimal jabatan &amp; nama untuk memunculkan slot; NIP opsional.
                </p>
            </div>

            <div class="p-6 space-y-4">
                @for ($i = 1; $i <= 3; $i++)
                    <div class="rounded-xl border border-gray-100 bg-gray-50/50 p-4">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3">Slot {{ $i }}</p>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div>
                                <label class="text-xs font-medium text-gray-600 block mb-1">Jabatan</label>
                                <input type="text" name="ttd{{ $i }}_jabatan" value="{{ old('ttd'.$i.'_jabatan', $pengaturan->{'ttd'.$i.'_jabatan'}) }}"
                                       placeholder="Contoh: Kepala BPS Provinsi Riau"
                                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition-colors">
                            </div>
                            <div>
                                <label class="text-xs font-medium text-gray-600 block mb-1">Nama</label>
                                <input type="text" name="ttd{{ $i }}_nama" value="{{ old('ttd'.$i.'_nama', $pengaturan->{'ttd'.$i.'_nama'}) }}"
                                       placeholder="Nama lengkap & gelar"
                                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition-colors">
                            </div>
                            <div>
                                <label class="text-xs font-medium text-gray-600 block mb-1">NIP <span class="text-gray-400 font-normal">(opsional)</span></label>
                                <input type="text" name="ttd{{ $i }}_nip" value="{{ old('ttd'.$i.'_nip', $pengaturan->{'ttd'.$i.'_nip'}) }}"
                                       placeholder="Contoh: 198501012010011001"
                                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-400 transition-colors">
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>

        {{-- Submit --}}
        <div class="flex justify-end pb-6">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-6 py-2.5 rounded-lg font-medium transition-colors shadow-sm flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
                Simpan Pengaturan
            </button>
        </div>
    </form>
</div>
@endsection