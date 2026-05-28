<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-3xl font-black text-gray-900 mb-8 uppercase tracking-wider">Edit Data Pendaftar</h2>

            <form action="{{ route('admin.registrations.update', $registration->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="bg-white p-10 rounded-[2.5rem] shadow-sm border border-gray-100 grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ $registration->name }}" class="w-full rounded-2xl border-gray-100 bg-gray-50 p-4 font-bold focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">NIK</label>
                            <input type="number" name="nik" value="{{ $registration->nik }}" class="w-full rounded-2xl border-gray-100 bg-gray-50 p-4 font-bold">
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Program Studi</label>
                            <select name="program_study" class="w-full rounded-2xl border-gray-100 bg-gray-50 p-4 font-bold">
                                <option value="S1 Sistem Informasi" {{ $registration->program_study == 'S1 Sistem Informasi' ? 'selected' : '' }}>S1 Sistem Informasi</option>
                                <option value="S1 Informatika" {{ $registration->program_study == 'S1 Informatika' ? 'selected' : '' }}>S1 Informatika</option>
                            </select>
                        </div>
                        <div class="flex gap-3 pt-6">
                            <button type="submit" class="flex-1 py-4 bg-indigo-600 text-white rounded-2xl font-black uppercase text-xs tracking-widest">Update Data</button>
                            <a href="{{ route('admin.registrations.index') }}" class="flex-1 py-4 bg-gray-100 text-gray-500 text-center rounded-2xl font-black uppercase text-xs tracking-widest">Batal</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>