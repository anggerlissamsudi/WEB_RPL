<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-3xl font-black text-gray-900 uppercase tracking-wider">Master Program Studi</h2>
                    <p class="text-gray-500 font-medium">Kelola daftar Prodi yang tersedia untuk jalur RPL.</p>
                </div>
            </div>

            <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm mb-8">
                <form action="{{ route('program-studies.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Kode</label>
                        <input type="text" name="code" class="w-full rounded-2xl border-gray-100 bg-gray-50 p-4 text-sm font-bold focus:ring-indigo-500" placeholder="S1-MAN">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Nama Program Studi</label>
                        <input type="text" name="name" class="w-full rounded-2xl border-gray-100 bg-gray-50 p-4 text-sm font-bold focus:ring-indigo-500" placeholder="Manajemen">
                    </div>
                    <div class="md:col-span-1">
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Fakultas</label>
                        <input type="text" name="faculty" class="w-full rounded-2xl border-gray-100 bg-gray-50 p-4 text-sm font-bold focus:ring-indigo-500" placeholder="Ekonomi" required>
                    </div>
                    <button type="submit" class="w-full py-4 bg-indigo-600 text-white rounded-2xl font-black uppercase text-[10px] tracking-widest shadow-lg shadow-indigo-100">
                        Tambah Prodi
                    </button>
                </form>
            </div>

            <div class="bg-white border border-gray-100 shadow-sm rounded-3xl overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100">
                            <th class="px-8 py-5 text-[10px] font-black uppercase text-gray-900">Kode</th>
                            <th class="px-8 py-5 text-[10px] font-black uppercase text-gray-900">Nama Prodi</th>
                            <th class="px-8 py-5 text-[10px] font-black uppercase text-gray-900 text-center">Status</th>
                            <th class="px-8 py-5 text-[10px] font-black uppercase text-gray-900 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($prodis as $prodi)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-8 py-5 font-bold text-indigo-600 uppercase">{{ $prodi->code }}</td>
                            <td class="px-8 py-5 font-bold text-gray-800">{{ $prodi->name }}</td>
                            <td class="px-8 py-5 text-center">
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-[10px] font-black uppercase border border-green-200">Aktif</span>
                            </td>
                            <td class="px-8 py-5 text-right flex justify-end gap-2">
                                <a href="{{ route('program-studies.edit', $prodi->id) }}" 
                                class="p-2 bg-amber-50 text-amber-600 rounded-xl hover:bg-amber-600 hover:text-white transition shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>

                                <form action="{{ route('program-studies.destroy', $prodi->id) }}" method="POST" onsubmit="return confirm('Hapus prodi ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 bg-red-50 text-red-600 rounded-xl hover:bg-red-600 hover:text-white transition shadow-sm">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>