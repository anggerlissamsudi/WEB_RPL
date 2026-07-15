<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div id="alert-success" class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl shadow-sm font-bold flex justify-between items-center">
                    <span>{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700">&times;</button>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl shadow-sm font-bold">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white p-8 rounded-t-3xl border-b border-gray-100 shadow-sm text-gray-900">
                <h2 class="text-xl font-black text-center mb-6 uppercase tracking-wider">Hasil Konversi Mahasiswa RPL</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                    <div class="space-y-3">
                        <p><span class="w-32 inline-block font-bold text-gray-400 uppercase tracking-widest text-[10px]">Nama</span>: <span class="font-bold text-gray-900">{{ $registration->name }}</span></p>
                        <p><span class="w-32 inline-block font-bold text-gray-400 uppercase tracking-widest text-[10px]">No. Reg</span>: <span class="font-mono text-indigo-600 font-bold">{{ $registration->registration_number }}</span></p>
                    </div>
                    <div class="space-y-3 md:text-right">
                        <p>
                            <span class="font-bold text-gray-400 uppercase tracking-widest text-[10px]">Status</span>: 
                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase shadow-sm border
                                {{ $registration->status == 'pending' ? 'bg-amber-100 text-amber-700 border-amber-200' : 'bg-green-100 text-green-700 border-green-200' }}">
                                {{ $registration->status }}
                            </span>
                        </p>
                        <p><span class="font-bold text-gray-400 uppercase tracking-widest text-[10px]">Program Studi</span>: <span class="font-bold text-gray-900">{{ $registration->programStudy->name ?? 'Tidak Diketahui' }}</span></p>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-2xl shadow-sm font-bold flex justify-between items-center animate-pulse">
                    <span>✅ {{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-800 text-xl">&times;</button>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded-2xl shadow-sm font-bold">
                    ❌ {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('admin.conversions.store', $registration->id) }}" method="POST">
                @csrf
                <div class="bg-white shadow-sm overflow-x-auto border-x border-gray-100">
                    <table class="w-full border-collapse">
                        <thead class="bg-gray-900 text-white">
                            <tr>
                                <th class="p-4 text-center text-[10px] font-black uppercase tracking-widest w-12">No</th>
                                <th class="p-4 text-center text-[10px] font-black uppercase tracking-widest w-12">Smt</th>
                                <th class="p-4 text-left text-[10px] font-black uppercase tracking-widest w-28">Kode MK</th>
                                <th class="p-4 text-left text-[10px] font-black uppercase tracking-widest">Mata Kuliah</th>
                                <th class="p-4 text-center text-[10px] font-black uppercase tracking-widest w-16">SKS</th>
                                <th class="p-4 text-center text-[10px] font-black uppercase tracking-widest w-24 bg-gray-800">Nilai Asesmen</th>
                                <th class="p-4 text-center text-[10px] font-black uppercase tracking-widest w-16 bg-green-600">YA</th>
                                <th class="p-4 text-center text-[10px] font-black uppercase tracking-widest w-16 bg-red-600">TIDAK</th>
                                <th class="p-4 text-left text-[10px] font-black uppercase tracking-widest w-48 bg-gray-800">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-900 divide-y divide-gray-100">
                        @foreach($courses as $index => $course)
                            @php
                                $conv = $conversions->get($course->id);
                            @endphp
                            
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="p-4 text-center text-xs font-bold text-gray-400">{{ $index + 1 }}</td>
                                <td class="p-4 text-center text-xs font-bold">{{ $course->semester }}</td>
                                <td class="p-4 font-mono text-xs text-indigo-600 font-bold uppercase">{{ $course->course_code }}</td>
                                <td class="p-4 text-xs font-bold">{{ $course->course_name }}</td>
                                <td class="p-4 text-center text-xs font-black">{{ $course->credits }}</td>
                                
                                <td class="p-4 bg-gray-50/50">
                                    <select name="assessments[{{ $course->id }}]" class="w-full text-[10px] rounded-xl border-gray-200 bg-white font-black">
                                        <option value="">-</option>
                                        <option value="A" {{ ($conv && $conv->assessment_score == 'A') ? 'selected' : '' }}>A</option>
                                        <option value="B" {{ ($conv && $conv->assessment_score == 'B') ? 'selected' : '' }}>B</option>
                                    </select>
                                </td>

                                <td class="p-4 text-center bg-green-50/30">
                                    <input type="radio" name="course_ids[{{ $course->id }}]" value="ya" 
                                        class="custom-radio w-5 h-5 text-green-600"
                                        {{ ($conv && $conv->is_recognized) ? 'checked' : '' }}>
                                </td>

                                <td class="p-4 text-center bg-red-50/30">
                                    <input type="radio" name="course_ids[{{ $course->id }}]" value="tidak" 
                                        class="custom-radio w-5 h-5 text-red-600"
                                        {{ ($conv && $conv->is_recognized == false) ? 'checked' : '' }}>
                                </td>

                                <td class="p-4 bg-gray-800/5">
                                    <select name="descriptions[{{ $course->id }}]" class="w-full text-[10px] rounded-xl border-gray-200 bg-white font-black">
                                        <option value="">- Pilih Keterangan -</option>
                                        <option value="Perolehan SKS" {{ ($conv && $conv->description == 'Perolehan SKS') ? 'selected' : '' }}>Perolehan SKS</option>
                                        <option value="Wajib Menempuh SKS" {{ ($conv && $conv->description == 'Wajib Menempuh SKS') ? 'selected' : '' }}>Wajib Menempuh SKS</option>
                                    </select>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    </table>
                </div>

                <div class="mt-8 bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
                    <h3 class="text-sm font-black uppercase tracking-widest mb-4 text-gray-400">Ringkasan Konversi SKS</h3>
                    <table class="w-full border-collapse border border-gray-100 text-sm">
                        <thead>
                            <tr class="bg-gray-50 text-[10px] font-black uppercase tracking-widest">
                                <th class="border border-gray-100 p-3 text-left">Semester</th>
                                <th class="border border-gray-100 p-3 text-center">Perolehan SKS</th>
                                <th class="border border-gray-100 p-3 text-center">Wajib SKS</th>
                            </tr>
                        </thead>
                        <tbody id="summary-body">
                            @php
                                $romans = [1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI', 7 => 'VII'];
                            @endphp

                            @for ($i = 1; $i <= 7; $i++)
                            <tr>
                                <td class="border border-gray-100 p-3 font-bold text-gray-600">{{ $romans[$i] }}</td>
                                <td class="border border-gray-100 p-3 text-center font-mono font-bold text-indigo-600" id="perolehan-sem-{{ $i }}">0 SKS</td>
                                <td class="border border-gray-100 p-3 text-center font-mono font-bold text-amber-600" id="wajib-sem-{{ $i }}">0 SKS</td>
                            </tr>
                            @endfor
                            
                            <tr class="bg-gray-50/50">
                                <td class="border border-gray-100 p-3 font-black text-gray-900">Skripsi</td>
                                <td class="border border-gray-100 p-3 text-center text-gray-400">-</td>
                                <td class="border border-gray-100 p-3 text-center font-mono font-bold text-amber-600" id="wajib-skripsi">0 SKS</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr class="bg-gray-900 text-white font-black">
                                <td class="p-3">Total</td>
                                <td class="p-3 text-center font-mono" id="total-perolehan">0 SKS</td>
                                <td class="p-3 text-center font-mono" id="total-wajib">0 SKS</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="bg-white p-8 rounded-b-3xl border-t border-gray-100 flex flex-col md:flex-row justify-end items-center gap-4 shadow-sm">
                    
                    <!-- Tombol 1: Simpan Saja ke Database -->
                    <button type="submit" name="action" value="save_only"
                            class="w-full md:w-auto text-center bg-white border border-gray-200 text-gray-700 px-8 py-4 rounded-2xl font-black hover:bg-gray-50 hover:text-indigo-600 transition uppercase tracking-widest text-xs shadow-sm flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                        Simpan Hasil Konversi
                    </button>

                    <!-- Tombol 2: Simpan Sekaligus Langsung Unduh Cetak PDF -->
                    <button type="submit" name="action" value="save_and_print" 
                            class="w-full md:w-auto bg-indigo-600 text-white px-10 py-4 rounded-2xl font-black hover:bg-indigo-700 shadow-xl shadow-indigo-200 transition uppercase tracking-widest text-xs transform active:scale-95 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        Simpan & Cetak PDF
                    </button>
                    
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            let isDirty = false; // Menandai jika ada perubahan yang belum disimpan

            // Pantau semua input (radio dan select)
            document.querySelectorAll('input, select').forEach(input => {
                input.addEventListener('change', () => {
                    isDirty = true; // Tandai bahwa ada perubahan data
                });
            });


            const allRadios = document.querySelectorAll('.custom-radio');
            const descriptions = document.querySelectorAll('select[name^="descriptions"]');
            const form = document.querySelector('form');
            const btnCetak = document.getElementById('btn-cetak-pdf');
            const assessmentSelects = document.querySelectorAll('select[name^="assessments"]');
            const tidakRadios = document.querySelectorAll('input[value="tidak"]');

            // 1. FUNGSI UPDATE RINGKASAN SKS [cite: 15]
            function updateSummary() {
                let summary = {};
                for(let i = 1; i <= 7; i++) {
                    summary[i] = { perolehan: 0, wajib: 0 };
                }
                let totalPerolehan = 0;
                let totalWajib = 0;
                let skripsiWajib = 0;

                const rows = document.querySelectorAll('tbody tr[class*="hover"]');
                
                rows.forEach(row => {
                    const semester = parseInt(row.cells[1].innerText);
                    const sks = parseInt(row.cells[4].innerText) || 0;
                    const courseName = row.cells[3].innerText.toLowerCase();
                    
                    const yaRadio = row.querySelector('input[value="ya"]');
                    const tidakRadio = row.querySelector('input[value="tidak"]');
                    const descSelect = row.querySelector('select[name^="descriptions"]');

                    // Logika otomatisasi teks keterangan berdasarkan status radio [cite: 12]
                    if (yaRadio.checked) {
                        descSelect.value = "Perolehan SKS";
                    } else if (tidakRadio.checked) {
                        descSelect.value = "Wajib Menempuh SKS";
                    } else {
                        descSelect.value = ""; 
                    }

                    // Hitung SKS untuk tabel ringkasan [cite: 15]
                    if (yaRadio.checked && descSelect.value === "Perolehan SKS") {
                        summary[semester].perolehan += sks;
                        totalPerolehan += sks;
                    } else if (descSelect.value === "Wajib Menempuh SKS") {
                        if (courseName.includes('skripsi') || courseName.includes('tugas akhir')) {
                            skripsiWajib += sks;
                        } else {
                            summary[semester].wajib += sks;
                        }
                        totalWajib += sks;
                    }
                });

                // Update tampilan DOM tabel ringkasan [cite: 15]
                for(let i = 1; i <= 7; i++) {
                    document.getElementById(`perolehan-sem-${i}`).innerText = summary[i].perolehan + " SKS";
                    document.getElementById(`wajib-sem-${i}`).innerText = summary[i].wajib + " SKS";
                }
                document.getElementById('wajib-skripsi').innerText = skripsiWajib + " SKS";
                document.getElementById('total-perolehan').innerText = totalPerolehan + " SKS";
                document.getElementById('total-wajib').innerText = totalWajib + " SKS";
            }

            // 2. FUNGSI VALIDASI (Mencegah Nilai Kosong saat YA)
            function checkValidation() {
                let isValid = true;
                let errorMessage = "";
                const rows = document.querySelectorAll('tbody tr[class*="hover"]');

                rows.forEach((row, index) => {
                    const yaRadio = row.querySelector('input[value="ya"]');
                    const assessmentSelect = row.querySelector('select[name^="assessments"]');
                    const courseName = row.cells[3].innerText;

                    if (yaRadio.checked && assessmentSelect.value === "") {
                        isValid = false;
                        if (errorMessage === "") {
                            errorMessage = `Mata kuliah "${courseName}" (Baris ${index + 1}) sudah di-YA, tapi Nilai Asesmen belum diisi!`;
                        }
                        assessmentSelect.classList.add('border-red-500', 'bg-red-50');
                    } else {
                        assessmentSelect.classList.remove('border-red-500', 'bg-red-50');
                    }
                });

                return { isValid, errorMessage };
            }

            // 3. LOGIKA UNCHECK (TOGGLE)
            allRadios.forEach(radio => {
                if (radio.checked) {
                    radio.setAttribute('data-was-checked', 'true');
                }

                radio.addEventListener('click', function(e) {
                    const isAlreadyChecked = this.getAttribute('data-was-checked') === 'true';

                    if (isAlreadyChecked) {
                        this.checked = false;
                        this.setAttribute('data-was-checked', 'false');
                        const row = this.closest('tr');
                        const descSelect = row.querySelector('select[name^="descriptions"]');
                        descSelect.value = "";
                    } else {
                        document.querySelectorAll(`input[name="${this.name}"]`).forEach(r => {
                            r.setAttribute('data-was-checked', 'false');
                        });
                        this.checked = true;
                        this.setAttribute('data-was-checked', 'true');
                    }
                    updateSummary(); 
                });
            });

            // 4. OTOMATISASI: Nilai Asesmen -> YA [cite: 12]
            assessmentSelects.forEach(select => {
                select.addEventListener('change', function() {
                    if (this.value !== "") {
                        const row = this.closest('tr');
                        const yaRadio = row.querySelector('input[value="ya"]');
                        yaRadio.checked = true;
                        yaRadio.setAttribute('data-was-checked', 'true');
                        updateSummary(); 
                    }
                });
            });

            // 5. OTOMATISASI: Klik TIDAK -> Reset Nilai [cite: 12]
            tidakRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.checked) {
                        const row = this.closest('tr');
                        const assessmentSelect = row.querySelector('select[name^="assessments"]');
                        assessmentSelect.value = ""; 
                        updateSummary();
                    }
                });
            });

            // 6. EVENT LISTENER FORM & TOMBOL
            form.addEventListener('submit', function (e) {
                const validation = checkValidation();
                if (!validation.isValid) {
                    e.preventDefault(); 
                    alert(validation.errorMessage);
                }
            });

            if (btnCetak) {
                btnCetak.addEventListener('click', function (e) {
                    const validation = checkValidation();
                    
                    // 1. Validasi Nilai Kosong
                    if (!validation.isValid) {
                        e.preventDefault(); 
                        alert("Gagal Cetak: " + validation.errorMessage);
                        return;
                    }

                    // 2. Cegah Cetak jika belum di-Simpan (Silent Failure Prevention)
                    if (isDirty) {
                        const confirmCetak = confirm("Peringatan: Anda memiliki perubahan yang belum disimpan. Hasil PDF mungkin tidak sesuai. Tetap cetak?");
                        if (!confirmCetak) {
                            e.preventDefault();
                        }
                    }
                });
            }

            updateSummary();
        });
        </script>

</x-app-layout>