<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Utama Admin RPL') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
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

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wide mb-4">Grafik Jumlah Pendaftar Mahasiswa RPL Per Tahun</h3>
                <div class="h-64 relative">
                    <canvas id="rplYearlyChart"></canvas>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wide mb-4">Rincian Mahasiswa Terkonversi Berdasarkan Periode</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-sm">
                        <thead>
                            <tr class="bg-gray-50 text-gray-500 font-bold border-b border-gray-100 text-xs uppercase">
                                <th class="p-4">Tahun Akademik</th>
                                <th class="p-4">Kode Periode</th>
                                <th class="p-4 text-right">Jumlah Mahasiswa Terkonversi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-600">
                            @foreach($convertedByYear as $year)
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="p-4 font-semibold text-gray-900">{{ $year->year_name ?? 'N/A' }}</td>
                                    <td class="p-4 text-xs font-mono bg-gray-50 rounded px-2 py-0.5 inline-block mt-3">{{ $year->year_code }}</td>
                                    <td class="p-4 text-right font-bold text-indigo-600">{{ $year->total_converted }} Orang</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

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