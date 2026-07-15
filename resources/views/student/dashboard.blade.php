<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Sistem Informasi RPL - STIE Mahardhika</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased text-gray-900">

    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center space-x-3">
                    <span class="text-xl font-black tracking-wider text-indigo-600">MAHARDHIKA</span>
                    <span class="text-gray-300">|</span>
                    <span class="text-sm font-semibold text-gray-500 uppercase tracking-wide">RPL Student Panel</span>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm font-medium text-gray-700 hidden sm:inline">Halo, {{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 px-4 py-2 rounded-xl text-xs font-bold uppercase transition">
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        
        <!-- NOTIFIKASI KHUSUS PASCA BERHASIL DAFTAR FORMULIR RPL -->
        @if(session('success_pendaftaran'))
            <div class="mb-6 p-6 bg-emerald-50 border border-emerald-200 rounded-3xl shadow-sm text-gray-900">
                <div class="flex items-start space-x-4">
                    <!-- Icon Centang Sukses -->
                    <div class="p-2 bg-emerald-500 rounded-xl text-white mt-0.5 shadow-md shadow-emerald-100">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    
                    <div class="flex-1">
                        <h3 class="text-base font-bold text-emerald-800">Berhasil!</h3>
                        <p class="text-sm text-emerald-700 mt-1">{{ session('success_pendaftaran') }}</p>
                        
                        <!-- Kotak Informasi Detail Akun -->
                        <div class="mt-4 bg-white p-4 rounded-2xl border border-gray-150 text-sm max-w-md shadow-sm">
                            <p class="font-bold text-[11px] uppercase tracking-wider text-gray-400 mb-2">Akses Login Dashboard Anda:</p>
                            <div class="space-y-2">
                                <div class="flex justify-between border-b border-gray-100 pb-2">
                                    <span class="text-gray-500 text-xs">Email Login:</span>
                                    <span class="font-mono font-bold text-indigo-600 text-sm">{{ session('registered_email') }}</span>
                                </div>
                                <div class="flex justify-between pt-0.5">
                                    <span class="text-gray-500 text-xs">Password:</span>
                                    <span class="text-gray-400 italic text-xs">Menggunakan password registrasi awal Anda</span>
                                </div>
                            </div>
                        </div>
                        
                        <p class="text-[11px] text-orange-600 font-semibold mt-3">
                            * Penting: Harap catat atau ingat email Anda untuk kebutuhan login kembali ke sistem di masa mendatang.
                        </p>
                    </div>
                </div>
            </div>
        @endif
        
        <!-- Notifikasi Bawaan Lainnya -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-xl shadow-sm">
                <p class="font-bold">Berhasil!</p>
                <p class="text-sm">{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded-xl shadow-sm">
                <p class="font-bold">Pemberitahuan</p>
                <p class="text-sm">{{ session('error') }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="space-y-6">
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 text-center">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Status Verifikasi Berkas</h3>
                    
                    @if($registration->status === 'pending')
                        <div class="inline-block bg-amber-50 text-amber-700 px-6 py-3 rounded-2xl border border-amber-200">
                            <span class="block text-2xl font-black uppercase tracking-wide">PENDING</span>
                        </div>
                        <p class="text-xs text-gray-500 mt-4 leading-relaxed">
                            Berkas Anda telah diterima sistem dan sedang dalam antrean pemeriksaan oleh tim kurator Admin RPL STIE Mahardhika.
                        </p>
                    @else
                        <div class="inline-block bg-emerald-50 text-emerald-700 px-6 py-3 rounded-2xl border border-emerald-200">
                            <span class="block text-2xl font-black uppercase tracking-wide">CONVERTED</span>
                        </div>
                        <p class="text-xs text-emerald-600 font-medium mt-4 leading-relaxed">
                            Selamat! Berkas Anda telah disetujui dan nilai konversi RPL Anda telah diterbitkan oleh Admin.
                        </p>
                    @endif
                </div>

                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Kontrol Data</h4>
                    
                    <!-- PERUBAHAN: Menghapus penguncian status agar tombol edit selalu muncul dan bisa diakses mahasiswa -->
                    <p class="text-xs text-gray-500 mb-4">Apakah ada berkas atau data data diri yang salah ketik? Anda masih bisa memperbaruinya kapan saja diperlukan.</p>
                    <a href="{{ route('pendaftaran.index') }}" class="block text-center w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-xl shadow-md shadow-indigo-100 transition transform active:scale-95 text-sm">
                        Ubah Data Formulir
                    </a>
                </div>
            </div>

            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 p-6 text-white">
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-xs bg-indigo-500 text-indigo-100 font-bold px-2.5 py-1 rounded-md uppercase tracking-wider">No. Registrasi</span>
                                <h2 class="text-xl font-mono font-bold mt-1 tracking-wide">{{ $registration->registration_number }}</h2>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-indigo-200 uppercase">Pilihan Prodi</p>
                                <p class="font-bold text-sm">{{ $registration->programStudy->name ?? 'Tidak Diketahui' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 space-y-6">
                        <h3 class="text-sm font-bold text-indigo-900 uppercase border-b pb-2 tracking-wide">Ringkasan Identitas Calon Mahasiswa</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-xs text-gray-400 uppercase font-bold">Nama Lengkap</p>
                                <p class="font-semibold text-gray-800 mt-0.5">{{ $registration->name }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 uppercase font-bold">Email</p>
                                <p class="font-semibold text-gray-800 mt-0.5">{{ $registration->email }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 uppercase font-bold">Nomor NIK (KTP)</p>
                                <p class="font-semibold text-gray-700 font-mono mt-0.5">{{ $registration->nik }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 uppercase font-bold">Nomor Kartu Keluarga (KK)</p>
                                <p class="font-semibold text-gray-700 font-mono mt-0.5">{{ $registration->kk }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 uppercase font-bold">Tempat, Tanggal Lahir</p>
                                <p class="font-semibold text-gray-800 mt-0.5">{{ $registration->birth_place_date }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 uppercase font-bold font-sans">No. HP / WhatsApp</p>
                                <p class="font-semibold text-gray-800 mt-0.5">{{ $registration->phone }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <p class="text-xs text-gray-400 uppercase font-bold">Alamat Rumah Lengkap</p>
                                <p class="font-semibold text-gray-800 mt-0.5 leading-relaxed">{{ $registration->address }}</p>
                            </div>
                        </div>

                        <h3 class="text-sm font-bold text-indigo-900 uppercase border-b pb-2 tracking-wide pt-4">Dokumen Lampiran Pendukung</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="p-4 border border-gray-100 rounded-2xl flex justify-between items-center bg-gray-50/50">
                                <span class="text-sm font-bold text-gray-700">File Dokumen KTP</span>
                                <a href="{{ asset('storage/' . $registration->file_ktp) }}" target="_blank" class="text-xs font-bold text-indigo-600 hover:underline uppercase">Lihat →</a>
                            </div>

                            <div class="p-4 border border-gray-100 rounded-2xl flex justify-between items-center bg-gray-50/50">
                                <span class="text-sm font-bold text-gray-700">File Kartu Keluarga (KK)</span>
                                @if($registration->file_kk)
                                    <a href="{{ asset('storage/' . $registration->file_kk) }}" target="_blank" class="text-xs font-bold text-indigo-600 hover:underline uppercase">Lihat →</a>
                                @else
                                    <span class="text-xs font-medium text-gray-400 italic">Tidak tersedia</span>
                                @endif
                            </div>

                            <div class="p-4 border border-gray-100 rounded-2xl flex justify-between items-center bg-gray-50/50">
                                <span class="text-sm font-bold text-gray-700">File Ijazah SMA/SMK</span>
                                <a href="{{ asset('storage/' . $registration->file_ijazah_sma) }}" target="_blank" class="text-xs font-bold text-indigo-600 hover:underline uppercase">Lihat →</a>
                            </div>

                            <div class="p-4 border border-gray-100 rounded-2xl flex justify-between items-center bg-gray-50/50">
                                <span class="text-sm font-bold text-gray-700">File Akta Kelahiran</span>
                                @if($registration->birth_certificate)
                                    <a href="{{ asset('storage/' . $registration->birth_certificate) }}" target="_blank" class="text-xs font-bold text-indigo-600 hover:underline uppercase">Lihat →</a>
                                @else
                                    <span class="text-xs font-medium text-gray-400 italic">Tidak tersedia</span>
                                @endif
                            </div>

                            <!-- PERUBAHAN: Menambahkan slot view untuk dokumen Ijazah D3 Mahasiswa -->
                            <div class="p-4 border border-gray-100 rounded-2xl flex justify-between items-center bg-gray-50/50">
                                <span class="text-sm font-bold text-gray-700">File Ijazah D3 (Opsional)</span>
                                @if($registration->file_ijazah_d3)
                                    <a href="{{ asset('storage/' . $registration->file_ijazah_d3) }}" target="_blank" class="text-xs font-bold text-indigo-600 hover:underline uppercase">Lihat →</a>
                                @else
                                    <span class="text-xs font-medium text-gray-400 italic">Tidak tersedia</span>
                                @endif
                            </div>

                            <div class="p-4 border border-gray-100 rounded-2xl flex justify-between items-center bg-gray-50/50">
                                <span class="text-sm font-bold text-gray-700">File Sertifikat Kompetensi</span>
                                <a href="{{ asset('storage/' . $registration->file_sertifikat) }}" target="_blank" class="text-xs font-bold text-indigo-600 hover:underline uppercase">Lihat →</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

</body>
</html>