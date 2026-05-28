<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-3xl font-black text-gray-900 mb-8 uppercase tracking-wider">Ubah Program Studi</h2>

            <div class="bg-white p-10 rounded-[2.5rem] shadow-sm border border-gray-100">
                <form action="{{ route('program-studies.update', $programStudy->id) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="space-y-6">
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Kode Prodi</label>
                            <input type="text" name="code" value="{{ $programStudy->code }}" class="w-full rounded-2xl border-gray-100 bg-gray-50 p-4 font-bold focus:ring-indigo-500 uppercase">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Nama Program Studi</label>
                            <input type="text" name="name" value="{{ $programStudy->name }}" class="w-full rounded-2xl border-gray-100 bg-gray-50 p-4 font-bold focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Status Aktif</label>
                            <select name="is_active" class="w-full rounded-2xl border-gray-100 bg-gray-50 p-4 font-bold">
                                <option value="1" {{ $programStudy->is_active ? 'selected' : '' }}>AKTIF (DIBUKA)</option>
                                <option value="0" {{ !$programStudy->is_active ? 'selected' : '' }}>NON-AKTIF (DITUTUP)</option>
                            </select>
                        </div>
                        <div class="flex gap-4 pt-4">
                            <button type="submit" class="flex-1 py-4 bg-indigo-600 text-white rounded-2xl font-black uppercase text-xs tracking-widest hover:bg-indigo-700 transition">Update Prodi</button>
                            <a href="{{ route('program-studies.index') }}" class="flex-1 py-4 bg-gray-100 text-center text-gray-500 rounded-2xl font-black uppercase text-xs tracking-widest">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>