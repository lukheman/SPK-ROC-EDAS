<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Diagnosis Pasien</title>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,300;0,400;0,700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Source Sans Pro', sans-serif;
            margin: 40px;
            color: #000;
        }

        .container {
            width: 80%;
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
            margin: 10px 0 20px;
        }

        address {
            font-size: 0.9rem;
            text-align: center;
            margin-bottom: 20px;
        }

        .info-table {
            width: 100%;
            margin-top: 30px;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 8px;
            font-size: 0.95rem;
        }

        .info-table td:first-child {
            width: 180px;
            font-weight: bold;
        }

        .data-table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .data-table th, .data-table td {
            border: 1px solid #000;
            padding: 10px;
            text-align: left;
            font-size: 0.95rem;
        }

        .data-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .section-title {
            margin-top: 30px;
            font-weight: bold;
            font-size: 1rem;
        }

        .description {
            margin-top: 20px;
            font-size: 0.95rem;
        }

        .footer {
            margin-top: 50px;
            text-align: right;
            font-size: 0.9rem;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .container {
                width: 100%;
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
        <h5 class="text-center"><u>Laporan Hasil Diagnosis Pasien</u></h5>

        <table class="info-table">
            <tr>
                <td>Nama Pasien</td>
                <td>: {{ $diagnosis->nama }}</td>
            </tr>
            <tr>
                <td>Umur</td>
                <td>: {{ $diagnosis->umur }} tahun</td>
            </tr>
            <tr>
                <td>Tanggal Diagnosis</td>
                <td>: {{ $diagnosis->created_at->translatedFormat('d F Y') }}</td>
            </tr>
        </table>

        <p class="section-title">Gejala yang Diderita</p>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Kode Gejala</th>
                    <th>Nama Gejala</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($diagnosis->gejala as $item)
                <tr>
                    <td>{{ $item->kode }}</td>
                    <td>{{ $item->nama }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <p class="section-title">Hasil Diagnosis Penyakit</p>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Kode Penyakit</th>
                    <th>Nama Penyakit</th>
                    <th>Kepercayaan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($diagnosis->penyakit as $item)
                <tr>
                    <td>{{ $item->kode }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->pivot->belief }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <p class="section-title">Deskripsi Penyakit</p>
        @foreach ($diagnosis->penyakit as $item)
        <div class="description">
            <strong>{{ $item->nama }}:</strong>
            <p>{{ $item->deskripsi }}</p>
        </div>
        @endforeach

        <div class="footer">
            Kolaka, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
        </div>
    </div>
</body>
</html>
