<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-3xl font-black text-gray-900">Detail Calon Mahasiswa</h2>
                    <p class="text-gray-500">Verifikasi berkas dan identitas pendaftar.</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('admin.registrations.index') }}" class="px-6 py-3 bg-white border border-gray-200 text-gray-600 rounded-2xl font-bold hover:bg-gray-50 transition"> Kembali </a>
                    <a href="{{ route('admin.registrations.conversion', $registration->id) }}" class="px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-100 transition"> Mulai Konversi SKS </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                        <div class="flex items-center justify-center mb-6">
                            <div class="w-20 h-20 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center text-3xl font-black">
                                {{ strtoupper(substr($registration->name, 0, 1)) }}
                            </div>
                        </div>
                        
                        <h3 class="text-xl font-black text-center text-gray-900 mb-1">{{ $registration->name }}</h3>
                        <p class="text-center text-indigo-600 font-mono text-sm mb-6">{{ $registration->registration_number }}</p>

                        <div class="space-y-4 pt-6 border-t border-gray-50">
                            <div>
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">NIK / No. KK</label>
                                <p class="text-gray-900 font-semibold">{{ $registration->nik }} / {{ $registration->kk }}</p>
                            </div>
                            <div>
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Program Studi</label>
                                <p class="text-gray-900 font-semibold">{{ $registration->program_study }}</p>
                            </div>
                            <div>
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Kontak</label>
                                <p class="text-gray-900 font-semibold">{{ $registration->email }}</p>
                                <p class="text-gray-500 text-sm">{{ $registration->phone }}</p>
                            </div>
                            <div>
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Alamat</label>
                                <p class="text-gray-900 font-semibold text-sm">{{ $registration->address }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                        <h3 class="text-lg font-black text-gray-900 mb-6 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            Lampiran Berkas Digital
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                            @php
                                $files = [
                                    ['label' => 'KTP', 'field' => 'file_ktp'],
                                    ['label' => 'Kartu Keluarga', 'field' => 'file_kk'],
                                    ['label' => 'Ijazah Terakhir', 'field' => 'file_ijazah_sma'],
                                    ['label' => 'Sertifikat / Portofolio', 'field' => 'file_sertifikat'],
                                ];
                            @endphp

                            @foreach($files as $file)
                                @if($registration->{$file['field']})
                                <button onclick="previewFile('{{ asset('storage/' . $registration->{$file['field']}) }}', '{{ $file['label'] }}')" 
                                        class="flex items-center justify-between p-4 border border-gray-100 rounded-2xl hover:bg-indigo-50 hover:border-indigo-200 transition group">
                                    <div class="flex items-center gap-3">
                                        <div class="p-2 bg-gray-50 rounded-lg group-hover:bg-white">
                                            <svg class="w-5 h-5 text-gray-400 group-hover:text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </div>
                                        <span class="text-sm font-bold text-gray-700">{{ $file['label'] }}</span>
                                    </div>
                                    <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </button>
                                @endif
                            @endforeach
                        </div>

                        <div id="preview-container" class="hidden">
                            <div class="flex justify-between items-center mb-3">
                                <span id="preview-label" class="text-xs font-black text-indigo-600 uppercase tracking-widest">Preview</span>
                                <button onclick="closePreview()" class="text-xs text-red-500 font-bold hover:underline">Tutup Preview</button>
                            </div>
                            <div class="rounded-2xl overflow-hidden border border-gray-100 bg-gray-50" style="height: 500px;">
                                <iframe id="preview-frame" src="" class="w-full h-full" frameborder="0"></iframe>
                                <img id="preview-image" src="" class="hidden w-full h-auto object-contain mx-auto" style="max-height: 500px;">
                            </div>
                        </div>

                        <div id="preview-placeholder" class="py-20 text-center border-2 border-dashed border-gray-100 rounded-3xl">
                            <p class="text-gray-400 text-sm">Klik salah satu berkas di atas untuk melihat preview</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewFile(url, label) {
            const container = document.getElementById('preview-container');
            const placeholder = document.getElementById('preview-placeholder');
            const frame = document.getElementById('preview-frame');
            const img = document.getElementById('preview-image');
            const labelEl = document.getElementById('preview-label');

            labelEl.innerText = 'Preview: ' + label;
            placeholder.classList.add('hidden');
            container.classList.remove('hidden');

            // Cek apakah file adalah gambar atau PDF
            if (url.match(/\.(jpeg|jpg|gif|png)$/) != null) {
                img.src = url;
                img.classList.remove('hidden');
                frame.classList.add('hidden');
            } else {
                frame.src = url;
                frame.classList.remove('hidden');
                img.classList.add('hidden');
            }
        }

        function closePreview() {
            document.getElementById('preview-container').classList.add('hidden');
            document.getElementById('preview-placeholder').classList.remove('hidden');
        }
    </script>
</x-app-layout>