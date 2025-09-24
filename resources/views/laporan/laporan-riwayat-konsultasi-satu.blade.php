<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Konsultasi</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600;700&display=swap">
    <style>
        body {
            font-family: 'Source Sans Pro', sans-serif;
            color: #000;
            margin: 20px;
            padding: 0;
            line-height: 1.6;
            font-size: 0.95rem;
        }

        .container {
            width: 90%;
            max-width: 800px;
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

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .info-table td:first-child {
            width: 150px;
            font-weight: 600;
            vertical-align: top;
        }

        .colon {
            display: inline-block;
            width: 15px;
            text-align: center;
        }

        .section-box {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .section-title {
            font-weight: 600;
            margin-bottom: 10px;
            color: #333;
        }

        .badge {
            display: inline-block;
            padding: 3px 8px;
            font-size: 0.85rem;
            border-radius: 12px;
            background-color: #0d6efd;
            color: #fff;
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
        }
    </style>
</head>
<body onload="window.print()">
    <div class="container">
        <!-- Header -->
        <h3 class="text-center">CacaoCare</h3>
        <hr>
        <h5 class="text-center"><u>Laporan Hasil Konsultasi</u></h5>

        <!-- Data Konsultan -->
        <div class="mb-4">
            <table class="info-table">
                <tr>
                    <td>Nama</td>
                    <td><span class="colon">:</span> {{ $riwayat->nama ?? '' }}</td>
                </tr>
                <tr>
                    <td>Umur</td>
                    <td><span class="colon">:</span> {{ $riwayat->umur ?? '' }} tahun</td>
                </tr>
                <tr>
                    <td>Jenis Kelamin</td>
                    <td><span class="colon">:</span> {{ $riwayat->jenis_kelamin ?? '' }}</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td><span class="colon">:</span> {{ $riwayat->alamat ?? '' }}</td>
                </tr>
            </table>
        </div>

        <!-- Hasil -->
        <div class="section-box">
            <p class="mb-0">
                Berdasarkan hasil konsultasi, pasien terdeteksi menderita penyakit
                <b>{{ $riwayat->penyakit->nama ?? '' }}</b>
                dengan persentase keyakinan
                <span>{{ $riwayat->belief ?? '' }}%</span>.
            </p>
        </div>

        <!-- Detail Penyakit -->
        <div class="mb-4">
            <p class="section-title">Deskripsi Penyakit</p>
            <p>{{ $riwayat->deskripsi ?? '' }}</p>

            <p class="section-title">Solusi</p>
            <p>{{ $riwayat->penyakit->solusi ?? '' }}</p>
        </div>

        <!-- Footer -->
        <div class="footer">
            Kolaka, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
        </div>
    </div>
</body>
</html>
