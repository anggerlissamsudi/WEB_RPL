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
        
        <!-- Notifikasi Sukses Bawaan -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-xl shadow-sm">
                <p class="font-bold">Berhasil!</p>
                <p class="text-sm">{{ session('success') }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- KOLOM KIRI: STATUS VERIFIKASI DENGAN PROTEKSI NULL -->
            <div class="space-y-6">
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 text-center space-y-4">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Status Verifikasi Berkas</h3>
                    
                    @if(!$registration)
                        <!-- JIKA BELUM MENGISI FORMULIR -->
                        <div class="inline-block bg-blue-50 text-blue-700 px-6 py-3 rounded-2xl border border-blue-200">
                            <span class="block text-sm font-black uppercase tracking-wide">BELUM DAFTAR</span>
                        </div>
                        <p class="text-xs text-gray-500 leading-relaxed">
                            Akun Anda berhasil dibuat. Silakan lengkapi formulir pendaftaran RPL untuk memulai proses verifikasi berkas.
                        </p>
                    
                    <!-- PERUBAHAN DI SINI: Satukan status 'pending' dan 'draft_converted' -->
                    @elseif($registration->status === 'pending' || $registration->status === 'draft_converted')
                        <!-- JIKA STATUS PENDING / BARU DISIMPAN OLEH ADMIN -->
                        <div class="inline-block bg-amber-50 text-amber-700 px-6 py-3 rounded-2xl border border-amber-200">
                            <span class="block text-2xl font-black uppercase tracking-wide">PENDING</span>
                        </div>
                        <p class="text-xs text-gray-500 leading-relaxed">
                            Berkas Anda telah diterima sistem dan sedang dalam antrean pemeriksaan oleh tim kurator Admin RPL STIE Mahardhika.
                        </p>
                    @else
                        <!-- JIKA STATUS CONVERTED (SUDAH DIKLIK SIMPAN & CETAK OLEH ADMIN) -->
                        <div class="inline-block bg-emerald-50 text-emerald-700 px-6 py-3 rounded-2xl border border-emerald-200 shadow-sm">
                            <span class="block text-2xl font-black uppercase tracking-wide">CONVERTED</span>
                        </div>
                        
                        <div class="text-xs text-emerald-700 font-semibold bg-emerald-50/50 p-3 rounded-xl border border-emerald-100 leading-relaxed">
                            Selamat! Berkas pendaftaran Anda telah disetujui, data SKS Anda telah berhasil terkonversi, dan lembar hasil resmi sudah siap diunduh.
                        </div>

                        <a href="{{ route('admin.registrations.pdf', $registration->id) }}" target="_blank" 
                           class="flex items-center justify-center gap-2 w-full bg-emerald-600 hover:bg-emerald-700 text-white font-black py-3.5 px-4 rounded-xl shadow-lg shadow-emerald-100 transition transform active:scale-95 text-xs uppercase tracking-wider">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Unduh PDF Hasil Konversi
                        </a>
                    @endif
                </div>

                <!-- KONTROL DATA -->
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Kontrol Data</h4>
                    @if(!$registration)
                        <p class="text-xs text-gray-500 mb-4">Silakan isi formulir pendaftaran beserta berkas-berkas persyaratan pendaftaran mahasiswa baru RPL.</p>
                        <!-- MENGGUNAKAN ROUTE RESMI DARI WEB.PHP -->
                        <a href="{{ route('pendaftaran.index') }}" class="block text-center w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-xl shadow-md shadow-indigo-100 transition transform active:scale-95 text-sm">
                            Isi Formulir Pendaftaran
                        </a>
                    @else
                        <p class="text-xs text-gray-500 mb-4">Apakah ada berkas atau data diri yang salah ketik? Anda masih bisa memperbaruinya kapan saja diperlukan.</p>
                        <!-- MENGGUNAKAN ROUTE RESMI DARI WEB.PHP -->
                        <a href="{{ route('pendaftaran.index') }}" class="block text-center w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-xl shadow-md shadow-indigo-100 transition transform active:scale-95 text-sm">
                            Ubah Data Formulir
                        </a>
                    @endif
                </div>
            </div>

            <!-- KOLOM KANAN: DETAIL DATA IDENTITAS MAHASISWA -->
            <div class="lg:col-span-2 space-y-6">
                @if(!$registration)
                    <!-- TAMPILAN JIKA BELUM ISI FORMULIR -->
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 text-center space-y-4">
                        <div class="w-16 h-16 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center mx-auto text-2xl">
                            📋
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">Formulir Pendaftaran Kosong</h3>
                        <p class="text-xs text-gray-500 max-w-md mx-auto leading-relaxed">
                            Anda belum menginputkan data data diri dan mengunggah berkas persyaratan digital (KTP, KK, Ijazah, dll.). Klik tombol di sebelah kiri untuk mengisi formulir sekarang.
                        </p>
                    </div>
                @else
                    <!-- TAMPILAN JIKA SUDAH ISI FORMULIR -->
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
                                    <p class="text-xs text-gray-400 uppercase font-bold">No. HP / WhatsApp</p>
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
                @endif
            </div>

        </div>
    </main>

</body>
</html>