<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi RPL - STIE Mahardhika</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 py-12 px-4">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
            <div class="bg-indigo-600 p-8 text-white flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold uppercase tracking-wide">
                        {{ isset($registration) ? 'Perbarui Formulir RPL' : 'Formulir Pendaftaran RPL' }}
                    </h1>
                    <p class="opacity-80">Silakan lengkapi data diri dan dokumen pendukung Anda sesuai identitas asli.</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-indigo-700 hover:bg-indigo-800 text-white px-4 py-2 rounded-xl text-xs font-bold uppercase">
                        Keluar
                    </button>
                </form>
            </div>

            @if(session('success'))
                <div class="m-8 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-xl">
                    <p class="font-bold">Berhasil!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="m-8 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded-xl">
                    <p class="font-bold">Terjadi Kesalahan!</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="m-8 p-4 bg-orange-100 border-l-4 border-orange-500 text-orange-700 rounded-xl">
                    <ul class="list-disc ml-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ isset($registration) ? route('pendaftaran.update', $registration->id) : route('pendaftaran.store') }}" 
                  method="POST" 
                  enctype="multipart/form-data" 
                  class="p-8 space-y-6 text-gray-900">
                
                @csrf
                @if(isset($registration))
                    @method('PUT')
                @endif
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Program Studi Yang Dipilih *</label>
                        <select name="program_study_id" class="w-full bg-gray-50 border-gray-200 rounded-xl focus:ring-indigo-500" required>
                            <option value="">-- Pilih Program Studi --</option>
                            @foreach($programStudies as $prodi)
                                <option value="{{ $prodi->id }}" {{ old('program_study_id', $registration->program_study_id ?? '') == $prodi->id ? 'selected' : '' }}>
                                    {{ $prodi->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Nama Lengkap *</label>
                        <input type="text" name="name" value="{{ old('name', $registration->name ?? auth()->user()->name) }}" class="w-full bg-gray-50 border-gray-200 rounded-xl focus:ring-indigo-500" placeholder="Nama Lengkap" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Tempat/ Tanggal Lahir *</label>
                        <input type="text" name="birth_place_date" value="{{ old('birth_place_date', $registration->birth_place_date ?? '') }}" class="w-full bg-gray-50 border-gray-200 rounded-xl focus:ring-indigo-500" placeholder="Contoh: Surabaya, 12 Januari 2000" required>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Jenis Kelamin *</label>
                        <select name="gender" class="w-full bg-gray-50 border-gray-200 rounded-xl focus:ring-indigo-500" required>
                            <option value="Laki-Laki" {{ old('gender', $registration->gender ?? '') == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                            <option value="Perempuan" {{ old('gender', $registration->gender ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Status Perkawinan *</label>
                        <select name="marital_status" class="w-full bg-gray-50 border-gray-200 rounded-xl focus:ring-indigo-500" required>
                            <option value="Belum Kawin" {{ old('marital_status', $registration->marital_status ?? '') == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                            <option value="Sudah Kawin" {{ old('marital_status', $registration->marital_status ?? '') == 'Sudah Kawin' ? 'selected' : '' }}>Sudah Kawin</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Kebangsaan *</label>
                        <input type="text" name="nationality" value="{{ old('nationality', $registration->nationality ?? 'Indonesia') }}" class="w-full bg-gray-50 border-gray-200 rounded-xl focus:ring-indigo-500" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Pendidikan Terakhir SMA/SMK/MA *</label>
                        <input type="text" name="school_name" value="{{ old('school_name', $registration->school_name ?? '') }}" class="w-full bg-gray-50 border-gray-200 rounded-xl focus:ring-indigo-500" placeholder="Contoh : SMA ...." required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Tahun Lulus SMA/SMK/MA *</label>
                        <input type="number" name="graduation_year" value="{{ old('graduation_year', $registration->graduation_year ?? '') }}" class="w-full bg-gray-50 border-gray-200 rounded-xl focus:ring-indigo-500" placeholder="Contoh: 2020" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Email *</label>
                        <input type="email" name="email" value="{{ old('email', $registration->email ?? auth()->user()->email) }}" class="w-full bg-gray-100 border-gray-200 rounded-xl focus:ring-indigo-500 text-gray-500" placeholder="email@gmail.com" readonly required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-2">No. HP (WhatsApp) *</label>
                        <input type="text" name="phone" value="{{ old('phone', $registration->phone ?? '') }}" class="w-full bg-gray-50 border-gray-200 rounded-xl focus:ring-indigo-500" placeholder="0812xxxx" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Nomor NIK *</label>
                        <input type="text" id="nik" name="nik" value="{{ old('nik', $registration->nik ?? '') }}" maxlength="16" class="w-full bg-gray-50 border-gray-200 rounded-xl focus:ring-indigo-500 transition-colors duration-200" required>
                        <p id="nik-error" class="text-xs text-red-500 mt-1 hidden">Panjang NIK harus 16 digit angka.</p>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Nomor KK *</label>
                        <input type="text" id="kk" name="kk" value="{{ old('kk', $registration->kk ?? '') }}" maxlength="16" class="w-full bg-gray-50 border-gray-200 rounded-xl focus:ring-indigo-500 transition-colors duration-200" required>
                        <p id="kk-error" class="text-xs text-red-500 mt-1 hidden">Panjang KK harus 16 digit angka.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Nama Ibu Kandung *</label>
                        <input type="text" name="mother_name" value="{{ old('mother_name', $registration->mother_name ?? '') }}" class="w-full bg-gray-50 border-gray-200 rounded-xl focus:ring-indigo-500" placeholder="Nama Ibu Kandung" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-2">NISN (Nomor Induk Siswa Nasional) *</label>
                        <input type="text" id="nisn" name="nisn" value="{{ old('nisn', $registration->nisn ?? '') }}" maxlength="10" class="w-full bg-gray-50 border-gray-200 rounded-xl focus:ring-indigo-500 transition-colors duration-200" placeholder="Contoh: 0042xxxxxx" required>
                        <p id="nisn-error" class="text-xs text-red-500 mt-1 hidden">Panjang NISN harus 10 digit angka.</p>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Alamat Lengkap *</label>
                    <textarea name="address" rows="3" class="w-full bg-gray-50 border-gray-200 rounded-xl focus:ring-indigo-500" required>{{ old('address', $registration->address ?? '') }}</textarea>
                </div>

                <!-- PERUBAHAN BARU: Input Referal Pendaftaran (Berada di tengah) -->
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Referal Pendaftaran (Opsional)</label>
                    <input type="text" name="referral" value="{{ old('referral', $registration->referral ?? '') }}" class="w-full bg-gray-50 border-gray-200 rounded-xl focus:ring-indigo-500" placeholder="Masukkan nama Marketing atau Staff">
                </div>

                <div class="bg-indigo-50 p-6 rounded-2xl border-2 border-dashed border-indigo-100 space-y-4">
                    <h3 class="font-bold text-indigo-900 text-sm uppercase">Dokumen Pendukung (PDF/JPG, Max 2MB)</h3>
                    @if(isset($registration))
                        <p class="text-xs text-orange-600 font-semibold">* Biarkan berkas kosong jika tidak ingin mengubah file dokumen lama.</p>
                    @endif
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">KTP *</label>
                            <input type="file" name="file_ktp" {{ isset($registration) ? '' : 'required' }} class="text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">KK *</label>
                            <input type="file" name="file_kk" {{ isset($registration) ? '' : 'required' }} class="text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Ijazah SMA/SMK/MA *</label>
                            <input type="file" name="file_ijazah_sma" {{ isset($registration) ? '' : 'required' }} class="text-sm">
                        </div>
                        
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Akta Kelahiran *</label>
                            <input type="file" name="birth_certificate" {{ isset($registration) ? '' : 'required' }} class="text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Ijazah D3 (Opsional)</label>
                            <input type="file" name="file_ijazah_d3" class="text-sm">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Sertifikat Pendukung *</label>
                            <input type="file" name="file_sertifikat" {{ isset($registration) ? '' : 'required' }} class="text-sm w-full">
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full bg-indigo-600 text-white py-4 rounded-2xl font-black text-lg hover:bg-indigo-700 shadow-xl shadow-indigo-200 transition transform active:scale-95">
                    {{ isset($registration) ? 'SIMPAN PERUBAHAN DATA' : 'KIRIM PENDAFTARAN SEKARANG' }}
                </button>
            </form>
        </div>
        
        <p class="text-center mt-8 text-gray-400 text-sm">
            &copy; {{ date('Y') }} STIE Mahardhika Surabaya - Sistem Informasi RPL
        </p>
    </div>

    <!-- JAVASCRIPT VALIDATION UNTUK NIK, KK, & NISN -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            
            function validateInputLength(inputId, errorId, requiredLength) {
                const inputElement = document.getElementById(inputId);
                const errorElement = document.getElementById(errorId);

                inputElement.addEventListener('input', function () {
                    this.value = this.value.replace(/[^0-9]/g, '');

                    if (this.value.length > 0 && this.value.length < requiredLength) {
                        inputElement.classList.remove('bg-gray-50', 'border-gray-200', 'focus:ring-indigo-500');
                        inputElement.classList.add('bg-red-50', 'border-red-500', 'focus:ring-red-500', 'focus:border-red-500');
                        errorElement.classList.remove('hidden');
                    } else {
                        inputElement.classList.remove('bg-red-50', 'border-red-500', 'focus:ring-red-500', 'focus:border-red-500');
                        inputElement.classList.add('bg-gray-50', 'border-gray-200', 'focus:ring-indigo-500');
                        errorElement.classList.add('hidden');
                    }
                });
            }

            validateInputLength('nik', 'nik-error', 16);
            validateInputLength('kk', 'kk-error', 16);
            validateInputLength('nisn', 'nisn-error', 10);
        });
    </script>
</body>
</html>