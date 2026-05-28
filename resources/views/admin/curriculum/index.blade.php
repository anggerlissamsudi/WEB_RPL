<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen" 
        x-data="{ 
        openCreate: false, 
        openEdit: false,
        editId: '',
        editCode: '',
        editName: '',
        editYearId: ''
        }">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-8 flex justify-between items-center text-gray-900">
                <div>
                    <h2 class="text-2xl font-extrabold">Data Kurikulum</h2>
                    <p class="text-sm text-gray-500">Manajemen struktur kurikulum per tahun ajaran.</p>
                </div>
                
                <button @click="openCreate = true" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl shadow-md transition-all font-semibold text-sm">
                    + Tambah Kurikulum
                </button>
            </div>

            <div class="mb-6 flex gap-4 items-center bg-white p-4 rounded-2xl border border-gray-100 shadow-sm">
                <span class="text-sm font-bold text-gray-400 uppercase tracking-widest">Filter Prodi:</span>
                <select onchange="window.location.href='?prodi=' + this.value" class="rounded-xl border-gray-200 text-sm focus:ring-indigo-500 min-w-[200px]">
                    <option value="">Semua Program Studi</option>
                    @foreach($programStudies as $prodi)
                        <option value="{{ $prodi->id }}" {{ request('prodi') == $prodi->id ? 'selected' : '' }}>
                            {{ $prodi->name }}
                        </option>
                    @endforeach
                </select>
                
                @if(request('prodi'))
                    <a href="{{ route('curricula.index') }}" class="text-xs text-red-500 font-bold hover:underline">Reset Filter</a>
                @endif
            </div>

            <div class="bg-white border border-gray-100 shadow-sm rounded-3xl overflow-hidden text-gray-900 mb-8">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100 text-gray-400">
                            <th class="px-8 py-5 text-xs font-bold uppercase tracking-wider">No</th>
                            <th class="px-8 py-5 text-xs font-bold uppercase tracking-wider">Kode</th>
                            <th class="px-8 py-5 text-xs font-bold uppercase tracking-wider">Nama Kurikulum</th>
                            <th class="px-8 py-5 text-xs font-bold uppercase tracking-wider">Tahun</th>
                            <th class="px-8 py-5 text-xs font-bold uppercase tracking-wider text-center">Status</th>
                            <th class="px-8 py-5 text-xs font-bold uppercase tracking-wider text-center">Matakuliah</th>
                            <th class="px-8 py-5 text-xs font-bold uppercase tracking-wider text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-gray-700">
                        @forelse($curricula as $index => $item)
                        <tr class="hover:bg-blue-50/30 transition-colors group">
                            <td class="px-8 py-5 text-sm">{{ $index + 1 }}</td>
                            <td class="px-8 py-5 font-bold text-indigo-600">{{ $item->code }}</td>
                            <td class="px-8 py-5 font-medium">{{ $item->name }}</td>
                            <td class="px-8 py-5">
                                <span class="px-3 py-1 bg-gray-100 rounded-full text-xs font-bold text-gray-600">
                                    {{ $item->academicYear->year_code }}
                                </span>
                            </td>
                            <td class="px-8 py-5 text-center">
                                <form action="{{ route('admin.curricula.toggle-status', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                        class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full transition-all duration-300 {{ $item->is_active ? 'bg-emerald-100 text-emerald-700 shadow-sm' : 'bg-gray-100 text-gray-400' }}">
                                        <div class="w-2 h-2 rounded-full {{ $item->is_active ? 'bg-emerald-500 animate-pulse' : 'bg-gray-400' }}"></div>
                                        <span class="text-[10px] font-black uppercase tracking-widest">
                                            {{ $item->is_active ? 'Aktif' : 'Non-Aktif' }}
                                        </span>
                                    </button>
                                </form>
                            </td>

                            <td class="px-8 py-5 text-center text-gray-900">
                                <a href="{{ route('curricula.courses.index', $item->id) }}" 
                                    target="_blank" 
                                    class="inline-flex items-center gap-2 text-sm text-blue-600 hover:text-blue-800 font-semibold transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    Daftar MK
                                </a>
                            </td>
                            <td class="px-8 py-5 text-right flex justify-end gap-2">
                                <button @click="openEdit = true; 
                                        editId = '{{ $item->id }}'; 
                                        editCode = '{{ $item->code }}'; 
                                        editName = '{{ $item->name }}'; 
                                        editYearId = '{{ $item->academic_year_id }}';
                                        editProdiId = '{{ $item->program_study_id }}'" 
                                        class="p-2 text-gray-400 hover:text-amber-500 hover:bg-amber-50 rounded-lg transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                </button>

                                <form action="{{ route('curricula.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus kurikulum ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="px-8 py-10 text-center text-gray-400">Data kurikulum masih kosong.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div x-show="openCreate" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-gray-500/75 transition-opacity" @click="openCreate = false"></div>
                <div class="relative bg-white rounded-3xl shadow-xl transform transition-all sm:max-w-lg sm:w-full p-8 text-gray-900">
                    <h3 class="text-xl font-bold mb-6">Tambah Kurikulum Baru</h3>
                    <form action="{{ route('curricula.store') }}" method="POST">
                        @csrf
                        <div class="space-y-5">
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Program Studi</label>
                                <select name="program_study_id" class="w-full bg-gray-50 border-gray-200 rounded-xl focus:ring-indigo-500 py-3" required>
                                    <option value="">-- Pilih Program Studi --</option>
                                    @foreach($programStudies as $prodi)
                                        <option value="{{ $prodi->id }}">{{ $prodi->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Tahun Akademik</label>
                                <select name="academic_year_id" class="w-full bg-gray-50 border-gray-200 rounded-xl focus:ring-indigo-500 py-3" required>
                                    <option value="">-- Pilih Tahun --</option>
                                    @foreach($years as $year)
                                        <option value="{{ $year->id }}">{{ $year->year_code }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Kode Kurikulum</label>
                                <input type="text" name="code" class="w-full bg-gray-50 border-gray-200 rounded-xl focus:ring-indigo-500 py-3" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Nama Kurikulum</label>
                                <input type="text" name="name" class="w-full bg-gray-50 border-gray-200 rounded-xl focus:ring-indigo-500 py-3" required placeholder="Contoh: Kurikulum Akuntansi 2023">
                            </div>
                        </div>
                        <div class="mt-8 flex gap-3">
                            <button type="button" @click="openCreate = false" class="flex-1 bg-gray-100 py-3 rounded-xl font-bold">Batal</button>
                            <button type="submit" class="flex-1 bg-indigo-600 text-white py-3 rounded-xl font-bold hover:bg-indigo-700">Simpan Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div x-show="openEdit" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-gray-500/75 transition-opacity" @click="openEdit = false"></div>
                <div class="relative bg-white rounded-3xl shadow-xl transform transition-all sm:max-w-lg sm:w-full p-8 text-gray-900 text-left">
                    <h3 class="text-xl font-bold mb-6 text-gray-900">Ubah Data Kurikulum</h3>
                    <form :action="'{{ url('admin/curricula') }}/' + editId" method="POST">
                        @csrf @method('PUT')
                        <div class="space-y-5 text-left">
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Program Studi</label>
                                <select name="program_study_id" x-model="editProdiId" class="w-full bg-gray-50 border-gray-200 rounded-xl focus:ring-indigo-500 py-3" required>
                                    <option value="">-- Pilih Program Studi --</option>
                                    @foreach($programStudies as $prodi)
                                        <option value="{{ $prodi->id }}">{{ $prodi->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Tahun Akademik</label>
                                <select name="academic_year_id" x-model="editYearId" class="w-full bg-gray-50 border-gray-200 rounded-xl focus:ring-indigo-500 py-3" required>
                                    @foreach($years as $year)
                                        <option value="{{ $year->id }}">{{ $year->year_code }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Kode Kurikulum</label>
                                <input type="text" name="code" x-model="editCode" class="w-full bg-gray-50 border-gray-200 rounded-xl focus:ring-indigo-500 py-3" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 text-gray-400 uppercase">Nama Kurikulum</label>
                                <input type="text" name="name" x-model="editName" class="w-full bg-gray-50 border-gray-200 rounded-xl focus:ring-indigo-500 py-3" required>
                            </div>
                        </div>
                        <div class="mt-8 flex gap-3">
                            <button type="button" @click="openEdit = false" class="flex-1 bg-gray-100 py-3 rounded-xl font-bold">Batal</button>
                            <button type="submit" class="flex-1 bg-amber-500 text-white py-3 rounded-xl font-bold hover:bg-amber-600">Update Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> 
</x-app-layout>