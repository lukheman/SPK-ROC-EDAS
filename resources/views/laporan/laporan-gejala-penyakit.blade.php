<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Gejala Penyakit</title>


    <!-- TODO: buat perhari -->
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <style>
        hr {
            height: 2px;
            background-color: black;
            border: none;
        }

        .container {
            width: 70%;
            margin: 0 auto;
        }

        .text-center {
            text-align: center;
        }

        #keterangan tr td:first-child {
            width: 150px;
        }

        #pesanan {
            border-collapse: collapse;
            margin-top: 50px;
            margin-bottom: 50px;
            width: 90%;
        }


        #pesanan td,
        #pesanan th {
            border: 1px solid black;
            padding: 8px;
        }

        .row {
            display: flex;
        }

        .col {
            flex: 1;
            padding: 10px;
        }
    </style>

</head>

<body onload="window.print()">
    <div class="container">


    <h3>RSUD SMS BERJAYA</h3>
    <h3>

Alamat: Jl. Mekongga Indah Jl. Poros Kolaka - Pomalaa, Tahoa, Kec. Latambaga, Kabupaten Kolaka, Sulawesi Tenggara 93511
    </h3>
    <hr>

        <h5 class="text-center"><u>Laporan Data Penyakit</u></h5>

        <table id="keterangan">
            <tr>

                <td>Kode Penyakit</td>
                <td>:</td>
                <td>{{ $penyakit->kode }}</td>

            </tr>
                <tr>

                <td>Nama Penyakit</td>
                <td>:</td>
                <td>{{ $penyakit->nama }}</td>

                </tr>
                <tr>

                <td>Deskripsi</td>
                <td>:</td>
                <td>{{ $penyakit->deskripsi }}</td>

                </tr>
        </table>

        <p>Berikut ini adalah gejala-gejala dari penyakit tersebut: </p>

        <ul>

            @foreach ($penyakit->gejala as $item)

                <li>{{ $item->kode }} - {{ $item->nama}}</li>

            @endforeach

        </ul>


    </div>

</body>

</html>
