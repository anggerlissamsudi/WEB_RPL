<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Utama Admin RPL') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- CARD STATISTIK -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white overflow-hidden shadow-sm rounded-2xl p-6 border border-yellow-100 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Menunggu Konversi (Pending)</p>
                        <h3 class="text-3xl font-black text-yellow-600 mt-1">{{ $pendingCount }} <span class="text-sm font-medium text-gray-400">Mahasiswa</span></h3>
                    </div>
                    <div class="p-3 bg-yellow-50 text-yellow-600 rounded-xl">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-2xl p-6 border border-green-100 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Telah Terkonversi (Final)</p>
                        <h3 class="text-3xl font-black text-green-600 mt-1">{{ $convertedCount }} <span class="text-sm font-medium text-gray-400">Mahasiswa</span></h3>
                    </div>
                    <div class="p-3 bg-green-50 text-green-600 rounded-xl">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
            </div>

            <!-- GRAFIK -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wide mb-4">Grafik Jumlah Pendaftar Mahasiswa RPL Per Tahun</h3>
                <div class="h-64 relative">
                    <canvas id="rplYearlyChart"></canvas>
                </div>
            </div>

            <!-- TABEL DAFTAR SELURUH PENDAFTAR MAHASISWA -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wide">Daftar Seluruh Pendaftar Mahasiswa RPL</h3>
                    <span class="text-xs font-semibold bg-indigo-50 text-indigo-700 px-3 py-1 rounded-xl">Total: {{ $registrations->count() }} Pendaftar</span>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-sm">
                        <thead>
                            <tr class="bg-gray-50 text-gray-500 font-bold border-b border-gray-100 text-xs uppercase">
                                <th class="p-4">No. Registrasi</th>
                                <th class="p-4">Nama Lengkap</th>
                                <th class="p-4">Program Studi</th>
                                <th class="p-4">Kontak / WhatsApp</th>
                                <th class="p-4">Status</th>
                                <th class="p-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-600">
                            @forelse($registrations as $reg)
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="p-4 font-mono text-xs font-bold text-gray-900">{{ $reg->registration_number }}</td>
                                    <td class="p-4">
                                        <div class="font-semibold text-gray-800">{{ $reg->name }}</div>
                                        <div class="text-xs text-gray-400 font-mono">{{ $reg->email }}</div>
                                    </td>
                                    <td class="p-4 text-xs font-medium text-gray-700">
                                        {{ $reg->programStudy->name ?? 'Tidak Diketahui' }}
                                    </td>
                                    <td class="p-4 text-xs font-mono text-gray-700">
                                        {{ $reg->phone }}
                                    </td>
                                    <td class="p-4">
                                        @if($reg->status === 'pending')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                                PENDING
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                CONVERTED
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-center">
                                        <a href="{{ route('admin.registrations.show', $reg->id) }}" class="inline-flex items-center justify-center bg-indigo-50 hover:bg-indigo-100 text-indigo-600 font-bold text-xs px-4 py-2 rounded-xl transition shadow-sm">
                                            Lihat Berkas & Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-8 text-center text-gray-400 italic">Belum ada mahasiswa yang mengirimkan formulir pendaftaran.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div> <!-- Penutup max-w-7xl -->
    </div> <!-- Penutup py-12 -->

    <!-- CHART.JS INJECTIONS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('rplYearlyChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                    label: 'Jumlah Pendaftar Baru',
                    data: {!! json_encode($chartData) !!},
                    backgroundColor: 'rgba(79, 70, 229, 0.2)',
                    borderColor: 'rgb(79, 70, 229)',
                    borderWidth: 2,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                }
            }
        });
    </script>
</x-app-layout>