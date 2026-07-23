{{-- TARUH DI: resources/views/pengaturan/edit.blade.php --}}
@extends('layouts.app')
@section('title', 'Pengaturan Sistem')

@section('content')
<div class="space-y-4 max-w-2xl">
    <div>
        <h2 class="text-lg font-semibold text-gray-800">Pengaturan Sistem</h2>
        <p class="text-sm text-gray-500">Ubah nama sistem, nama instansi, logo, dan tanda tangan. Perubahan ini otomatis berlaku di seluruh halaman, laporan PDF, dan Excel.</p>
    </div>

    <form method="POST" action="{{ route('pengaturan.update') }}" enctype="multipart/form-data"
          class="bg-white rounded-xl shadow-sm p-6 space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label class="text-sm font-medium text-gray-700 block mb-1">Nama Sistem</label>
            <input type="text" name="nama_sistem" value="{{ old('nama_sistem', $pengaturan->nama_sistem) }}"
                   class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
            @error('nama_sistem') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="text-sm font-medium text-gray-700 block mb-1">Nama Instansi</label>
            <input type="text" name="nama_instansi" value="{{ old('nama_instansi', $pengaturan->nama_instansi) }}"
                   class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
            @error('nama_instansi') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="text-sm font-medium text-gray-700 block mb-1">Alamat Instansi (opsional)</label>
            <textarea name="alamat_instansi" rows="2"
                      class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">{{ old('alamat_instansi', $pengaturan->alamat_instansi) }}</textarea>
            <p class="text-xs text-gray-400 mt-1">Muncul di footer laporan PDF, jika diisi.</p>
        </div>

        <div>
            <label class="text-sm font-medium text-gray-700 block mb-1">Lokasi / Kota</label>
            <input type="text" name="kota" value="{{ old('kota', $pengaturan->kota) }}"
                   placeholder="Contoh: Pekanbaru"
                   class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
            <p class="text-xs text-gray-400 mt-1">Dipakai untuk baris tanggal di atas tanda tangan, misal "Pekanbaru, 23 Juli 2026".</p>
            @error('kota') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="text-sm font-medium text-gray-700 block mb-1">Logo</label>
            @if($pengaturan->logo_url)
                <img src="{{ $pengaturan->logo_url }}" alt="Logo saat ini" class="h-14 mb-2 object-contain">
            @endif
            <input type="file" name="logo" accept="image/png,image/jpeg,image/svg+xml"
                   class="w-full text-sm text-gray-600 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 file:text-sm">
            <p class="text-xs text-gray-400 mt-1">PNG/JPG/SVG, maks 2MB. Kosongkan jika tidak ingin ganti.</p>
            @error('logo') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- ===== Tanda Tangan ===== --}}
        <div class="pt-2 border-t">
            <p class="text-sm font-semibold text-gray-800 mt-4 mb-1">Tanda Tangan Laporan</p>
            <p class="text-xs text-gray-400 mb-4">
                Sampai 3 tanda tangan bisa ditampilkan di bagian bawah laporan PDF, berjejer secara otomatis. Isi minimal jabatan & nama untuk memunculkan; NIP opsional. Kosongkan jabatan+nama kalau slot tidak ingin ditampilkan.
            </p>

            @for ($i = 1; $i <= 3; $i++)
                <div class="grid grid-cols-3 gap-3 mb-3 bg-gray-50 rounded-lg p-3">
                    <div>
                        <label class="text-xs font-medium text-gray-600 block mb-1">Jabatan {{ $i }}</label>
                        <input type="text" name="ttd{{ $i }}_jabatan" value="{{ old('ttd'.$i.'_jabatan', $pengaturan->{'ttd'.$i.'_jabatan'}) }}"
                               placeholder="Contoh: Kepala BPS Provinsi Riau"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-600 block mb-1">Nama {{ $i }}</label>
                        <input type="text" name="ttd{{ $i }}_nama" value="{{ old('ttd'.$i.'_nama', $pengaturan->{'ttd'.$i.'_nama'}) }}"
                               placeholder="Nama lengkap & gelar"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-600 block mb-1">NIP {{ $i }} (opsional)</label>
                        <input type="text" name="ttd{{ $i }}_nip" value="{{ old('ttd'.$i.'_nip', $pengaturan->{'ttd'.$i.'_nip'}) }}"
                               placeholder="Contoh: 198501012010011001"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                    </div>
                </div>
            @endfor
        </div>

        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-5 py-2 rounded-lg transition-colors">
            Simpan Pengaturan
        </button>
    </form>
</div>
@endsection