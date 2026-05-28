<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-3xl font-black text-gray-900 uppercase tracking-wider">Daftar Calon Mahasiswa</h2>
                    <p class="text-gray-500 font-medium">Kelola dan verifikasi pendaftaran jalur RPL.</p>
                </div>
                
            </div>

            <div class="flex flex-col md:flex-row justify-between items-center gap-4 bg-white p-4 rounded-xl shadow-sm mb-6">
                <div class="relative w-full md:w-72">
                    <input type="text" 
                        id="searchNama" 
                        placeholder="Cari nama mahasiswa..." 
                        value="{{ request('search') }}"
                        class="w-full rounded-xl border-gray-200 text-sm focus:ring-indigo-500 pl-10"
                        onkeyup="if(event.key === 'Enter') filterData()">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-3 w-full md:w-auto justify-end">
                    <select onchange="filterData()" id="filterProdi" class="rounded-xl border-gray-200 text-sm focus:ring-indigo-500 min-w-[180px]">
                        <option value="">Semua Prodi</option>
                        @foreach($programStudies as $prodi)
                            <option value="{{ $prodi->id }}" {{ request('prodi') == $prodi->id ? 'selected' : '' }}>
                                {{ $prodi->name }}
                            </option>
                        @endforeach
                    </select>

                    <select onchange="filterData()" id="filterTahun" class="rounded-xl border-gray-200 text-sm focus:ring-indigo-500 min-w-[150px]">
                        <option value="">Semua Tahun</option>
                        @foreach($years as $year)
                            <option value="{{ $year->id }}" {{ request('tahun') == $year->id ? 'selected' : '' }}>
                                {{ $year->year_code }}
                            </option>
                        @endforeach
                    </select>

                    <select onchange="filterData()" id="filterStatus" class="rounded-xl border-gray-200 text-sm focus:ring-indigo-500 min-w-[150px]">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="converted" {{ request('status') == 'converted' ? 'selected' : '' }}>Converted</option>
                    </select>
                    
                    <button onclick="filterData()" class="bg-indigo-600 text-white px-4 py-2 rounded-xl text-sm font-bold hover:bg-indigo-700">
                        Cari
                    </button>
                </div>
            </div>

            <div class="bg-white border border-gray-100 shadow-sm rounded-3xl overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <div class="mt-4 p-4 bg-white rounded-xl shadow-sm">
                        {{ $registrations->links() }}
                    </div>
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100 text-gray-400">
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-900">No. Registrasi</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-900">Nama Lengkap</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-900">Prodi Pilihan</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-900 text-center">Status</th> <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-center text-gray-900">Aksi</th> </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-gray-900">
                        @forelse($registrations as $reg)
                        <tr class="hover:bg-indigo-50/30 transition-colors group">
                            <td class="px-6 py-4 font-mono text-sm font-bold text-indigo-600">{{ $reg->registration_number }}</td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900">{{ $reg->name }}</div>
                                <div class="text-xs text-gray-400">{{ $reg->email }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 font-semibold">
                                {{ $reg->programStudy->name ?? '-' }} 
                            </td>
                            <td class="px-6 py-4 text-center"> 
                                <span class="px-3 py-1 rounded-full text-xs font-bold 
                                    @if($reg->status == 'pending') bg-amber-100 text-amber-700 
                                    @elseif($reg->status == 'converted') bg-indigo-100 text-indigo-700 
                                    @else bg-green-100 text-green-700 @endif">
                                    {{ strtoupper($reg->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('admin.registrations.show', $reg->id) }}" class="p-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition shadow-sm" title="Lihat Detail">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>

                                    <a href="{{ route('admin.registrations.edit', $reg->id) }}" class="p-2 bg-amber-50 text-amber-600 rounded-lg hover:bg-amber-600 hover:text-white transition shadow-sm" title="Ubah Data">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>

                                    <a href="{{ route('admin.registrations.conversion', $reg->id) }}" 
                                        class="p-2 bg-green-50 text-green-600 rounded-lg hover:bg-green-600 hover:text-white transition shadow-sm" 
                                        title="Konversi SKS">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                        </svg>
                                    </a>

                                    <form action="{{ route('admin.registrations.destroy', $reg->id) }}" method="POST" onsubmit="return confirm('Hapus data pendaftaran ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition shadow-sm" title="Hapus Data">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-400 font-medium italic">Belum ada calon mahasiswa yang mendaftar.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>

<script>

    let searchTimeout = null;

    function filterData() {

        const search = document.getElementById('searchNama').value;
        const prodi = document.getElementById('filterProdi').value;
        const tahun = document.getElementById('filterTahun').value;
        const status = document.getElementById('filterStatus').value;

        let url = new URL(window.location.origin + window.location.pathname);
        
        if (search) url.searchParams.set('search', search);
        if (prodi) url.searchParams.set('prodi', prodi);
        if (tahun) url.searchParams.set('tahun', tahun);
        if (status) url.searchParams.set('status', status);

        window.location.href = url.toString(); 
    }

    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchNama');

        if (searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);

                searchTimeout = setTimeout(function() {
                    filterData();
                }, 500); 
            });

            searchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    clearTimeout(searchTimeout);
                    filterData();
                }
            });
        }
    });
</script>