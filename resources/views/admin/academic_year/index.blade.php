<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Data Tahun RPL') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ openEdit: false, editId: '', editYear: '' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="mb-8 bg-gray-50 p-6 rounded-xl border border-gray-200">
                    <h3 class="text-lg font-bold mb-4 text-gray-700">Buka Tahun Pendaftaran Baru</h3>
                    <form action="{{ route('academic-years.store') }}" method="POST" class="flex flex-wrap gap-4 items-end">
                        @csrf
                        <div class="flex-1 min-w-[200px]">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kode Tahun</label>
                            <input type="text" name="year_code" placeholder="Misal: 20261" 
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            @error('year_code') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 shadow-sm transition">
                            Simpan Data
                        </button>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 border">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tahun</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($years as $index => $item)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-indigo-600">{{ $item->year_code }}</td>
                                <td class="px-8 py-5 text-center">
                                    <form action="{{ route('admin.academic-years.toggle', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                            class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full transition-all duration-300 {{ $item->is_active ? 'bg-indigo-100 text-indigo-700 shadow-sm' : 'bg-gray-100 text-gray-400' }}">
                                            
                                            <div class="w-2 h-2 rounded-full {{ $item->is_active ? 'bg-indigo-500 animate-pulse' : 'bg-gray-400' }}"></div>
                                            
                                            <span class="text-[10px] font-black uppercase tracking-widest">
                                                {{ $item->is_active ? 'Aktif' : 'Non-Aktif' }}
                                            </span>
                                        </button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center font-medium">
                                    <div class="flex justify-center gap-3">
                                        <button @click="openEdit = true; editId = '{{ $item->id }}'; editYear = '{{ $item->year_code }}'" 
                                                class="text-amber-600 hover:text-amber-900">Ubah</button>
                                        
                                        <form action="{{ route('academic-years.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus tahun ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-gray-500">Belum ada data tahun pendaftaran.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div x-show="openEdit" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
                <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full p-6">
                    <h3 class="text-lg font-bold mb-4">Ubah Tahun Pendaftaran</h3>
                    <form :action="'{{ url('admin/academic-years') }}/' + editId" method="POST">
                        @csrf @method('PUT')
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Kode Tahun</label>
                            <input type="text" name="year_code" x-model="editYear" class="w-full mt-1 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500">
                        </div>
                        <div class="flex justify-end gap-2">
                            <button type="button" @click="openEdit = false" class="bg-gray-200 px-4 py-2 rounded-md">Batal</button>
                            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Update Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>