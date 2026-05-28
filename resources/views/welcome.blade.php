<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi RPL - STIE Mahardhika</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-900">

    <nav class="bg-white shadow-sm border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center space-x-3">
                    <span class="text-xl font-black tracking-wider text-indigo-600">MAHARDHIKA</span>
                    <span class="text-gray-300">|</span>
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wide">Sistem Informasi RPL</span>
                </div>
                
                <div class="flex items-center space-x-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm font-bold text-indigo-600 hover:text-indigo-800 transition">Dashboard Anda</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-bold text-gray-600 hover:text-indigo-600 transition">Masuk</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl text-sm font-bold transition shadow-sm">Registrasi</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <header class="bg-gradient-to-r from-indigo-700 to-indigo-900 text-white py-20 px-4">
        <div class="max-w-4xl mx-auto text-center space-y-6">
            <span class="bg-indigo-500 text-indigo-100 text-xs font-extrabold px-3 py-1.5 rounded-full uppercase tracking-widest">Penerimaan Mahasiswa Baru</span>
            <h1 class="text-3xl md:text-5xl font-black leading-tight">Rekognisi Pembelajaran Lampau (RPL)</h1>
            <p class="text-base md:text-lg text-indigo-100 max-w-2xl mx-auto leading-relaxed">
                RPL adalah pengakuan atas Capaian Pembelajaran seseorang yang diperoleh dari pendidikan formal, nonformal, informal, dan/atau pengalaman kerja sebagai dasar untuk melanjutkan pendidikan formal dan melakukan penyetaraan kualifikasi tertentu.
            </p>
            <div class="pt-4">
                <a href="{{ route('register') }}" class="inline-block bg-white text-indigo-700 hover:bg-indigo-50 px-8 py-4 rounded-2xl font-black text-base shadow-xl transition transform active:scale-95">
                    MULAI DAFTAR SEKARANG
                </a>
            </div>
        </div>
    </header>

    <section class="max-w-6xl mx-auto px-4 py-16">
        <div class="text-center max-w-xl mx-auto mb-12">
            <h2 class="text-2xl font-black uppercase tracking-wide text-gray-800">Alur Pendaftaran & Penerimaan</h2>
            <p class="text-sm text-gray-400 mt-2">Simak 4 tahapan mudah untuk mengonversi pengalaman kerja Anda menjadi SKS akademik.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden">
                <div class="text-3xl font-black text-indigo-100 absolute right-4 top-2">01</div>
                <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600 font-bold mb-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                </div>
                <h3 class="font-bold text-gray-800 text-base">Registrasi Akun</h3>
                <p class="text-xs text-gray-500 mt-2 leading-relaxed">Calon mahasiswa membuat akun baru menggunakan email aktif dan membuat password terproteksi.</p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden">
                <div class="text-3xl font-black text-indigo-100 absolute right-4 top-2">02</div>
                <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600 font-bold mb-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <h3 class="font-bold text-gray-800 text-base">Isi Berkas Formulir</h3>
                <p class="text-xs text-gray-500 mt-2 leading-relaxed">Login ke sistem, lengkapi biodata asli, pilih program studi, dan unggah dokumen pendukung (KTP, KK, Ijazah, Sertifikat).</p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden">
                <div class="text-3xl font-black text-indigo-100 absolute right-4 top-2">03</div>
                <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600 font-bold mb-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                </div>
                <h3 class="font-bold text-gray-800 text-base">Asesmen & Konversi</h3>
                <p class="text-xs text-gray-500 mt-2 leading-relaxed">Tim Kurator Admin RPL akan memeriksa keabsahan berkas dan melakukan penilaian konversi transkrip nilai ke SKS institusi.</p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden">
                <div class="text-3xl font-black text-indigo-100 absolute right-4 top-2">04</div>
                <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600 font-bold mb-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <h3 class="font-bold text-gray-800 text-base">Unduh Hasil PDF</h3>
                <p class="text-xs text-gray-500 mt-2 leading-relaxed">Setelah berstatus disetujui (Converted), hasil konversi dikunci aman dan berkas legalitas berupa PDF dapat diunduh.</p>
            </div>

        </div>
    </section>

    <footer class="bg-white border-t border-gray-200 py-8 text-center text-xs text-gray-400">
        <p>&copy; {{ date('Y') }} STIE Mahardhika Surabaya - Sistem Informasi Pendaftaran Jalur RPL</p>
    </footer>

</body>
</html>