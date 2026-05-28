<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 12px; line-height: 1.5; color: #000; }
        .page-break { page-break-after: always; }
        
        /* Header & Info (Tanpa Border) */
        .table-info { width: 100%; border: none; margin-bottom: 20px; }
        .table-info td { border: none !important; padding: 2px 0; }

        /* Tabel Data Mata Kuliah (Border Hitam Solid) */
        .table-data { 
            width: 100%; 
            border-collapse: collapse; 
            table-layout: fixed; 
            margin-top: 10px;
        }
        
        .table-data th, .table-data td { 
            border: 1px solid #000; 
            padding: 4px 2px; 
            vertical-align: middle; 
            font-size: 10px;
            word-wrap: break-word; 
            overflow: hidden;
        }
        
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        .font-italic { font-style: italic; }

        /* Deklarasi/Pernyataan */
        .declaration { margin-top: 30px; text-align: justify; }
        .signature-container { margin-top: 50px; float: right; width: 250px; text-align: center; }
    </style>
</head>
<body>
    <div class="header-title text-center bold">
        FORMULIR APLIKASI RPL TIPE A (Form 2/F02)
    </div>

    <table class="table-info">
        <tr>
            <td width="25%">Program Studi</td>
            <td width="2%">:</td>
            <td>{{ $registration->programStudy->name ?? '-' }}</td>
        </tr>
        <tr>
            <td>Nama Perguruan Tinggi</td>
            <td>:</td>
            <td>Sekolah Tinggi Ilmu Ekonomi Mahardhika Surabaya</td>
        </tr>
    </table>
    
    <div class="section-header">Bagian 1: Rincian Data Calon Mahasiswa</div>
    <div class="section-description">
        Pada bagian ini, cantumkan data pribadi, data pendidikan formal serta data pekerjaan saudara pada saat ini.
    </div>

    <div class="section-header">a. Data Pribadi</div>
    <table class="table-info" style="margin-left: 10px;">
        <tr>
            <td width="30%">Nama lengkap</td>
            <td width="3%">:</td>
            <td>{{ $registration->name }}</td>
        </tr>
        <tr>
            <td>Tempat / tgl. lahir</td>
            <td>:</td>
            <td>{{ $registration->birth_place_date }}</td>
        </tr>
        <tr>
            <td>Jenis kelamin</td>
            <td>:</td>
            <td>{{ $registration->gender }}</td>
        </tr>
        <tr>
            <td>Status</td>
            <td>:</td>
            <td>{{ $registration->marital_status }}</td>
        </tr>
        <tr>
            <td>Kebangsaan</td>
            <td>:</td>
            <td>Indonesia</td>
        </tr>
        <tr>
            <td>Alamat rumah</td>
            <td>:</td>
            <td>{{ $registration->address }}</td>
        </tr>
        <tr>
            <td>No. Telepon/E-mail</td>
            <td>:</td>
            <td>{{ $registration->phone }} / {{ $registration->email }}</td>
        </tr>
    </table>

    <div class="section-header">b. Data Pendidikan</div>
    <table class="table-info" style="margin-left: 10px;">
        <tr>
            <td>Nama Sekolah / Perguruan Tinggi</td>
            <td>:</td>
            <td>{{ $registration->school_name }}</td>
        </tr>
        <tr>
            <td>Tahun lulus</td>
            <td>:</td>
            <td>{{ $registration->graduation_year }}</td>
        </tr>
    </table>

    <div class="section-title">Bagian 2: Daftar Mata Kuliah</div>
    <table class="table-data">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 8%;">Smt</th>
                <th style="width: 12%;">Kode MK</th>
                <th style="width: 35%;">Nama Mata Kuliah</th> 
                <th style="width: 6%;">SKS</th>
                <th style="width: 7%;">Nilai</th>
                <th style="width: 5%;">YA</th>
                <th style="width: 7%;">TIDAK</th>
                <th style="width: 15%;">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($courses as $index => $course)
            @php $conv = $conversions->get($course->id); @endphp
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ $course->semester }}</td>
                <td class="text-center">{{ $course->course_code }}</td>
                <td>{{ $course->course_name }}</td>
                <td class="text-center">{{ $course->credits }}</td>
                <td class="text-center">{{ $conv->assessment_score ?? '-' }}</td>
                <td class="text-center">{{ ($conv && $conv->is_recognized) ? 'x' : '' }}</td>
                <td class="text-center">{{ (!$conv || !$conv->is_recognized) ? 'x' : '' }}</td>
                <td style="font-size: 10px;">{{ $conv->description ?? 'Wajib Menempuh SKS' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        <table class="table-data" style="width: 80%; margin: 0 auto;">
            <thead>
                <tr>
                    <th>Semester</th>
                    <th>Perolehan SKS</th>
                    <th>Wajib SKS</th>
                </tr>
            </thead>
            <tbody>
                @php $romans = [1=>'I', 2=>'II', 3=>'III', 4=>'IV', 5=>'V', 6=>'VI', 7=>'VII']; @endphp
                @foreach($summary as $sem => $data)
                <tr>
                    <td class="text-center font-bold">{{ $romans[$sem] }}</td>
                    <td class="text-center">{{ $data['accepted'] }} SKS</td>
                    <td class="text-center">{{ $data['required'] }} SKS</td>
                </tr>
                @endforeach
                <tr>
                    <td class="text-center font-bold">Skripsi</td>
                    <td class="text-center">-</td>
                    <td class="text-center">6 SKS</td>
                </tr>
                <tr class="font-bold" style="background: #eee;">
                    <td class="text-center font-italic">TOTAL</td>
                    <td class="text-center">{{ $totalAccepted }} SKS</td>
                    <td class="text-center">{{ $totalRequired + 6 }} SKS</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="page-break"></div>

    <div class="declaration">
        Bersama ini saya mengajukan permohonan untuk dapat mengikuti Rekognisi Pembelajaran Lampau (RPL) dan dengan ini saya menyatakan bahwa:
        <ol>
            <li>Semua informasi yang saya tuliskan adalah sepenuhnya benar dan saya bertanggung-jawab atas seluruh data dalam formulir ini, dan apabila dikemudian hari ternyata informasi yang saya sampaikan tersebut adalah tidak benar, maka saya bersedia menerima sangsi sesuai dengan ketentuan yang berlaku;</li>
            <li>Saya memberikan ijin kepada pihak pengelola program RPL, untuk melakukan pemeriksaan kebenaran informasi yang saya berikan dalam formulir aplikasi ini kepada seluruh pihak yang terkait dengan jenjang akademik sebelumnya dan kepada perusahaan tempat saya bekerja sebelumnya dan atau saat ini saya bekerja; dan</li>
            <li>Saya akan mengikuti proses asesmen sesuai dengan jadwal/waktu yang ditetapkan oleh Perguruan Tinggi.</li>
        </ol>
    </div>

    <div class="signature-container">
        Surabaya, {{ date('d F Y') }}<br><br>
        Tanda tangan Pemohon<br><br><br><br><br>
        ( {{ $registration->name }} )
    </div>
</body>
</html>