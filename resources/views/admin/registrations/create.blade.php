<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-3xl font-black text-gray-900 uppercase tracking-wider">Input Pendaftaran Manual</h2>
                    <p class="text-gray-500">Gunakan form ini untuk membantu calon mahasiswa yang datang langsung.</p>
                </div>
                <a href="{{ route('admin.registrations.index') }}" class="text-sm font-bold text-gray-400 hover:text-gray-600">Batal & Kembali</a>
            </div>

            <form action="{{ route('admin.registrations.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    <div class="space-y-6">
                        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
                            <h3 class="text-xs font-black text-indigo-600 uppercase tracking-[0.2em] mb-6">Data Identitas</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Tahun Akademik</label>
                                    <select name="academic_year_id" class="w-full rounded-2xl border-gray-100 bg-gray-50 p-4 text-sm font-bold focus:ring-indigo-500 transition-all">
                                        @foreach($academicYears as $year)
                                            <option value="{{ $year->id }}">{{ $year->year_code }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Nama Lengkap (Sesuai Ijazah)</label>
                                    <input type="text" name="name" class="w-full rounded-2xl border-gray-100 bg-gray-50 p-4 text-sm font-bold focus:ring-indigo-500 transition-all" placeholder="Masukkan nama mahasiswa">
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">NIK (KTP)</label>
                                        <input type="number" name="nik" class="w-full rounded-2xl border-gray-100 bg-gray-50 p-4 text-sm font-bold focus:ring-indigo-500 transition-all" placeholder="16 Digit">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Nomor KK</label>
                                        <input type="number" name="kk" class="w-full rounded-2xl border-gray-100 bg-gray-50 p-4 text-sm font-bold focus:ring-indigo-500 transition-all" placeholder="16 Digit">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
                            <h3 class="text-xs font-black text-indigo-600 uppercase tracking-[0.2em] mb-6">Kontak & Program Studi</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Program Studi Tujuan</label>
                                    <select name="program_study" class="w-full rounded-2xl border-gray-100 bg-gray-50 p-4 text-sm font-bold focus:ring-indigo-500 transition-all">
                                        <option value="S1 Sistem Informasi">S1 Sistem Informasi</option>
                                        <option value="S1 Informatika">S1 Informatika</option>
                                        <option value="S1 Manajemen">S1 Manajemen</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Email Aktif</label>
                                    <input type="email" name="email" class="w-full rounded-2xl border-gray-100 bg-gray-50 p-4 text-sm font-bold focus:ring-indigo-500 transition-all" placeholder="email@contoh.com">
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Nomor WhatsApp</label>
                                    <input type="text" name="phone" class="w-full rounded-2xl border-gray-100 bg-gray-50 p-4 text-sm font-bold focus:ring-indigo-500 transition-all" placeholder="081234567xxx">
                                </div>
                            </div>
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="w-full py-5 bg-indigo-600 text-white rounded-[2rem] font-black uppercase text-xs tracking-[0.2em] shadow-xl shadow-indigo-100 hover:bg-indigo-700 transition transform active:scale-95">
                                Simpan Pendaftaran
                            </button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</x-app-layout>