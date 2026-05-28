<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen" 
         x-data="{ 
            openAdd: false,
            openEdit: false, 
            editId: '', 
            editCode: '', 
            editName: '', 
            editCredits: '', 
            editSemester: '' 
         }">
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm mb-8 flex flex-wrap justify-between items-center gap-6">
                <div>
                    <h2 class="text-2xl font-extrabold text-gray-900">Mata Kuliah: {{ $curriculum->name }}</h2>
                    <p class="text-sm text-gray-500">Kode Kurikulum: <span class="font-bold text-indigo-600">{{ $curriculum->code }}</span> | Tahun: {{ $curriculum->academicYear->year_code }}</p>
                </div>
                
                <div class="flex gap-4">
                    <div class="bg-indigo-50 px-4 py-2 rounded-2xl border border-indigo-100">
                        <p class="text-xs text-indigo-600 font-bold uppercase">Total Matakuliah</p>
                        <p class="text-xl font-black text-indigo-900">{{ $courses->count() }}</p>
                    </div>
                    <div class="bg-emerald-50 px-4 py-2 rounded-2xl border border-emerald-100">
                        <p class="text-xs text-emerald-600 font-bold uppercase">Total SKS</p>
                        <p class="text-xl font-black text-emerald-900">{{ $courses->sum('credits') }}</p>
                    </div>
                </div>
            </div>
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <table id="courseTable" class="display w-full border border-gray-300">

                        <div class="mb-4 text-gray-900 flex justify-between items-center">
                    <a href="{{ route('curricula.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 flex items-center gap-2 font-semibold transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Kembali ke Daftar Kurikulum
                    </a>
                    
                    <button type="button" @click="openAdd = true"
                        class="bg-indigo-600 text-white px-3 py-1.5 rounded-lg text-xs hover:bg-indigo-700">
                        + Tambah
                    </button>
                </div>
                    <thead class="bg-gray-100 text-gray-700 font-bold">
                        <tr>
                            <th class="border border-gray-300 px-4 py-3 text-left">No.</th>
                            <th class="border border-gray-300 px-4 py-3 text-left">Kode</th>
                            <th class="border border-gray-300 px-4 py-3 text-left">Nama</th>
                            <th class="border border-gray-300 px-4 py-3 text-center">SKS</th>
                            <th class="border border-gray-300 px-4 py-3 text-left">Semester</th>
                            <th class="border border-gray-300 px-4 py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600">
                        @foreach($courses as $index => $course)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="border border-gray-300 px-4 py-3 text-center font-bold text-gray-400">{{ $index + 1 }}</td>
                            <td class="border border-gray-300 px-4 py-3 font-mono text-indigo-600 font-bold">{{ $course->course_code }}</td>
                            <td class="border border-gray-300 px-4 py-3 uppercase font-semibold">{{ $course->course_name }}</td>
                            <td class="border border-gray-300 px-4 py-3 text-center font-black">{{ $course->credits }}</td>
                            <td class="border border-gray-300 px-4 py-3 text-sm font-bold">Smt{{ str_pad($course->semester, 2, '0', STR_PAD_LEFT) }}</td>
                            <td class="border border-gray-300 px-4 py-3 text-center">
                                <div class="flex justify-center gap-2">
                                    <button @click="openEdit = true; editId = '{{ $course->id }}'; editCode = '{{ $course->course_code }}'; editName = '{{ $course->course_name }}'; editCredits = '{{ $course->credits }}'; editSemester = '{{ $course->semester }}'" 
                                            class="p-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 shadow-sm transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                    </button>

                                    <form action="{{ route('curricula.courses.destroy', [$curriculum->id, $course->id]) }}" method="POST" onsubmit="return confirm('Hapus MK ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2 bg-red-500 text-white rounded-lg hover:bg-red-600 shadow-sm transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div x-show="openAdd" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" @click="openAdd = false"></div>
                <div class="relative bg-white rounded-3xl shadow-2xl transform transition-all sm:max-w-lg sm:w-full p-8">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-black text-gray-900 uppercase">Tambah Mata Kuliah</h3>
                        <button @click="openAdd = false" class="text-gray-400 hover:text-gray-600 text-2xl font-bold">&times;</button>
                    </div>

                    <form action="{{ route('curricula.courses.store', $curriculum->id) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Kode MK</label>
                            <input type="text" name="course_code" placeholder="Misal: MK001" class="w-full bg-gray-50 border-gray-200 rounded-xl focus:ring-indigo-500 py-3 uppercase font-bold" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Nama Mata Kuliah</label>
                            <input type="text" name="course_name" placeholder="Nama Lengkap MK" class="w-full bg-gray-50 border-gray-200 rounded-xl focus:ring-indigo-500 py-3 font-bold" required>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">SKS</label>
                                <input type="number" name="credits" placeholder="2" class="w-full bg-gray-50 border-gray-200 rounded-xl focus:ring-indigo-500 py-3 font-bold" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Semester</label>
                                <select name="semester" class="w-full bg-gray-50 border-gray-200 rounded-xl focus:ring-indigo-500 py-3 font-bold" required>
                                    @for($i=1; $i<=8; $i++)
                                        <option value="{{ $i }}">Smt {{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="mt-8 flex gap-3">
                            <button type="button" @click="openAdd = false" class="flex-1 bg-gray-100 text-gray-600 py-3 rounded-xl font-bold hover:bg-gray-200 uppercase text-xs tracking-widest">Batal</button>
                            <button type="submit" class="flex-1 bg-indigo-600 text-white py-3 rounded-xl font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-100 uppercase text-xs tracking-widest">Simpan Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div x-show="openEdit" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" @click="openEdit = false"></div>
                <div class="relative bg-white rounded-3xl shadow-2xl transform transition-all sm:max-w-lg sm:w-full p-8 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-black text-gray-900 uppercase">Ubah Mata Kuliah</h3>
                        <button @click="openEdit = false" class="text-gray-400 hover:text-gray-600 text-2xl font-bold">&times;</button>
                    </div>

                    <form :action="'{{ url('admin/curricula/'.$curriculum->id.'/courses') }}/' + editId" method="POST">
                        @csrf @method('PUT')
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Kode MK</label>
                                <input type="text" name="course_code" x-model="editCode" class="w-full bg-gray-50 border-gray-200 rounded-xl focus:ring-indigo-500 py-3 uppercase font-bold" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Nama Mata Kuliah</label>
                                <input type="text" name="course_name" x-model="editName" class="w-full bg-gray-50 border-gray-200 rounded-xl focus:ring-indigo-500 py-3 font-bold" required>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">SKS</label>
                                    <input type="number" name="credits" x-model="editCredits" class="w-full bg-gray-50 border-gray-200 rounded-xl focus:ring-indigo-500 py-3 font-bold" required>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Semester</label>
                                    <select name="semester" x-model="editSemester" class="w-full bg-gray-50 border-gray-200 rounded-xl focus:ring-indigo-500 py-3 font-bold" required>
                                        @for($i=1; $i<=8; $i++)
                                            <option value="{{ $i }}">Smt {{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mt-8 flex gap-3">
                            <button type="button" @click="openEdit = false" class="flex-1 bg-gray-100 text-gray-600 py-3 rounded-xl font-bold hover:bg-gray-200 uppercase text-xs tracking-widest">Batal</button>
                            <button type="submit" class="flex-1 bg-amber-500 text-white py-3 rounded-xl font-bold hover:bg-amber-600 shadow-lg shadow-amber-200 uppercase text-xs tracking-widest">Update Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    $(document).ready(function() {
        $('#courseTable').DataTable({
        pageLength: 10,
        ordering: true,
        language: {
            search: "",
            searchPlaceholder: "Cari...",
            lengthMenu: "_MENU_ data",
            info: "_START_ - _END_ dari _TOTAL_",
            paginate: {
                next: "›",
                previous: "‹"
            }
        },
        columnDefs: [
            { orderable: false, targets: 5 }
        ]
    });
    });
</script>