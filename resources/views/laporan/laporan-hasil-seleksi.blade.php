<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Hasil Akhir Penetapan Penerima KIP</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600;700&display=swap">
    <style>
        body {
            font-family: 'Source Sans Pro', sans-serif;
            color: #000;
            margin: 20px;
            padding: 0;
            line-height: 1.5;
        }

        .container {
            width: 90%;
            max-width: 1000px;
            margin: 0 auto;
        }

        .text-center {
            text-align: center;
        }

        h3, h5 {
            margin: 0;
        }

        hr {
            border: none;
            border-top: 2px solid #000;
            margin: 15px 0 25px;
        }

        address {
            font-size: 0.9rem;
            text-align: center;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .section-title {
            font-size: 1rem;
            font-weight: 600;
            margin: 30px 0 10px;
            color: #333;
        }

        .data-table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 10px;
            font-size: 0.95rem;
        }

        .data-table thead {
            background-color: #e8ecef;
        }

        .data-table th,
        .data-table td {
            border: 1px solid #333;
            padding: 10px 12px;
            text-align: left;
        }

        .data-table th {
            text-align: center;
            font-weight: 600;
            background-color: #e8ecef;
        }

        .data-table td {
            vertical-align: middle;
        }

        .text-center {
            text-align: center;
        }

        .no-data {
            text-align: center;
            color: #666;
            margin: 20px 0;
            font-size: 0.95rem;
        }

        .footer {
            margin-top: 40px;
            text-align: right;
            font-size: 0.9rem;
            color: #333;
        }

        @media print {
            body {
                margin: 0;
                padding: 10mm;
            }
            .container {
                width: 100%;
                max-width: none;
            }
            .data-table th,
            .data-table td {
                border-color: #000;
            }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="container">
        <h3 class="text-center">LAPORAN HASIL AKHIR</h3>
        <h5 class="text-center"><u>PENETAPAN PENERIMA KARTU INDONESIA PINTAR (KIP)</u></h5>
        <address>
            Disusun oleh Panitia Seleksi Penerima KIP<br>
            Tahun {{ \Carbon\Carbon::now()->translatedFormat('Y') }}
        </address>
        <hr>

        <p class="section-title">3 Besar Penerima KIP</p>

        @if ($siswaLolos->isEmpty())
            <p class="no-data">Tidak ada data penerima KIP yang tersedia.</p>
        @else
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Peringkat</th>
                        <th>Nama Siswa</th>
                        <th>NISN</th>
                        <th>Skor Akhir</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($siswaLolos as $index => $siswa)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $siswa->nama }}</td>
                            <td>{{ $siswa->nisn }}</td>
                            <td>{{ number_format($siswa->skor, 2) }}</td>
                            <td class="text-center">
            DITERIMA
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <div class="footer">
            Kolaka, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br><br><br>
            <strong>Panitia Seleksi</strong>
        </div>
    </div>
</body>
</html>
