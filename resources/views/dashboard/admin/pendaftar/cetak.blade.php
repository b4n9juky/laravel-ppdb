<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Bukti Pendaftaran</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            margin: 30px;
        }

        .kop-surat {
            text-align: center;
            margin-bottom: 20px;
        }

        .kop-surat img {
            width: 100%;
            max-height: auto;
        }

        h2 {
            text-align: center;
            margin-top: 20px;
            margin-bottom: 30px;
            text-transform: uppercase;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table td {
            padding: 6px 8px;
            vertical-align: top;
            font-size: 0.8rem;
        }

        .nilai-table th,
        .nilai-table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }

        .footer-section {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
        }

        .foto-pendaftar img {
            width: 150px;
            height: auto;
            object-fit: cover;
            border: 1px solid #000;
        }

        .ttd {
            text-align: center;
        }

        .ttd p {
            margin-bottom: 60px;
        }
    </style>
</head>

<body>

    {{-- Kop Surat --}}
    <div class="kop-surat">

        <img src="{{public_path('storage/'.$atur->kop_surat) }}" alt="Foto" class="rounded-lg shadow-md hover:scale-105 transition duration-300">
    </div>

    <h2>Bukti Pendaftaran Peserta Didik Baru</h2>

    {{-- Data Pendaftar --}}
    <table class="data-table">
        <tr>
            <td width="30%">Nomor Pendaftaran</td>
            <td>: {{ $pendaftar->nomor_pendaftaran }}</td>
        </tr>
        <tr>
            <td width="30%">Nama Lengkap</td>
            <td>: {{ $pendaftar->nama_lengkap }}</td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>: {{ $pendaftar->jenis_kelamin }}</td>
        </tr>
        <tr>
            <td>Tempat, Tanggal Lahir</td>
            <td>: {{ $pendaftar->tempat_lahir }}, {{ \Carbon\Carbon::parse($pendaftar->tanggal_lahir)->translatedFormat('d F Y') }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>: {{ $pendaftar->alamat }}</td>
        </tr>
        <tr>
            <td>No. HP</td>
            <td>: {{ $pendaftar->no_hp }}</td>
        </tr>
        <tr>
            <td>Jalur Pendaftaran</td>
            <td>: {{ $pendaftar->jalur->nama_jalur ?? '-' }}</td>
        </tr>
    </table>

    <br><br>

    <!-- {{-- Nilai Pendaftar --}}
    <strong>Nilai Mata Pelajaran:</strong>
    <table class="nilai-table" style="margin-top: 10px;">
        <thead>
            <tr>
                <th>No</th>
                <th>Mata Pelajaran</th>
                <th>Nilai</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pendaftar->nilaiPendaftar as $index => $nilai)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $nilai->mapel->nama ?? '-' }}</td>
                <td>{{ $nilai->nilai }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="3">Belum ada nilai.</td>
            </tr>
            @endforelse
            <tr>
                <th colspan="2" style="text-align: right;">Total Nilai</th>
                <th>{{ $totalNilai }}</th>
            </tr>
        </tbody>
    </table> -->

    {{-- Footer --}}
    <div class="footer-section">
        <table width="100%" style="margin-top: 40px;">
            <tr>
                <td width="50%" align="left">

                    @if ($foto && $foto->file_path)
                    <img src="{{ public_path('storage/' . $foto->file_path) }}" alt="Foto" width="150" style="border: 1px solid #000;">
                    @else
                    <p>Tidak ada foto yang diupload.</p>
                    @endif
                </td>
                <td width="50%" align="center">
                    <p>{{ $atur->kota ?? '.............' }}, {{ now()->translatedFormat('d F Y') }}</p>
                    <p>Panitia PPDB</p>
                    <br><br><br><br>
                    <p>_________________________</p>
                </td>
            </tr>
        </table>

    </div>

</body>

</html>