<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Diagnosis Penyakit</title>
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

        .patient-info {
            margin-top: 20px;
            font-size: 0.95rem;
        }

        .patient-info p {
            margin: 5px 0;
            font-size: 0.95rem;
        }

        .patient-info strong {
            display: inline-block;
            width: 120px;
            font-weight: 600;
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
        <h3 class="text-center">RSUD SMS BERJAYA</h3>
        <address>
            Jl. Mekongga Indah, Jl. Poros Kolaka - Pomalaa, Tahoa, Kec. Latambaga,<br>
            Kabupaten Kolaka, Sulawesi Tenggara 93511
        </address>
        <hr>
        <h5 class="text-center"><u>Laporan Data Diagnosis Penyakit</u></h5>

        @forelse ($diagnosis as $item)
            <div class="patient-info">
                <p><strong>Nama Pasien</strong>: {{ $item->nama }}</p>
                <p><strong>Umur</strong>: {{ $item->umur }} tahun</p>
                <p><strong>Tanggal Diagnosis</strong>: {{ $item->created_at->translatedFormat('d F Y') }}</p>
            </div>

            <p class="section-title">Gejala yang Diderita</p>
            @if ($item->gejala->isEmpty())
                <p class="no-data">Tidak ada gejala yang tercatat.</p>
            @else
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Kode Gejala</th>
                            <th>Nama Gejala</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($item->gejala as $gejala)
                            <tr>
                                <td>{{ $gejala->kode }}</td>
                                <td>{{ $gejala->nama }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            <p class="section-title">Hasil Diagnosis Penyakit</p>
            @if ($item->penyakit->isEmpty())
                <p class="no-data">Tidak ada penyakit yang terdeteksi.</p>
            @else
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Kode Penyakit</th>
                            <th>Nama Penyakit</th>
                            <th>Kepercayaan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($item->penyakit as $penyakit)
                            <tr>
                                <td>{{ $penyakit->kode }}</td>
                                <td>{{ $penyakit->nama }}</td>
                                <td>{{ number_format($penyakit->pivot->belief, 2) }}%</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            @if (!$loop->last)
                <hr style="margin: 30px 0; border-top: 1px dashed #000;">
            @endif
        @empty
            <p class="no-data">Tidak ada data diagnosis yang tersedia.</p>
        @endforelse

        <div class="footer">
            Kolaka, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
        </div>
    </div>
</body>
</html>
