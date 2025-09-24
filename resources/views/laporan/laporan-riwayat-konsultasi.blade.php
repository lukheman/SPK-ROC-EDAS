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
        <h3 class="text-center">CacaoCare</h3>
        <hr>
        <h5 class="text-center"><u>Laporan Data Riwayat Konsultasi</u></h5>


            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Umur</th>
                        <th>Jenis Kelamin</th>
                        <th>Alamat</th>
                        <th>Tanggal Konsultasi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($riwayat as $item)
                        <tr wire:key="{{ $item->id }}">
                        <td scope="row">{{ $loop->index + 1 }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->umur }}</td>
                        <td>{{ $item->jenis_kelamin }}</td>
                        <td>{{ $item->alamat }}</td>
                        <td>{{ $item->tanggal_konsultasi}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>


        <div class="footer">
            Kolaka, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
        </div>
    </div>
</body>
</html>
