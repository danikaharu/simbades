2

<html>

<head>
    <title>Laporan | {{ config('app.name') }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <style type="text/css">
        * {
            font-size: 12pt;
        }

        .table-border {
            border: 1px solid black;
            border-collapse: collapse;
            width: 100%;
        }

        .table-border tr td,
        .table-border tr th {
            border: 1px solid black;
            padding: 10px;
            width: auto;
        }
    </style>

    <center>
        <h6 style="margin: 0;">DAFTAR PENERIMA {{ Str::upper($assistance_name) }}</h6>
        <h6 style="margin: 0;">BULAN {{ Str::upper($month_name) }} TAHUN {{ $year }}</h6>
    </center>

    <div style="margin: 2% 0;">
        <table class='table-border'>
            <thead>
                <tr>
                    <th style="text-align:center;vertical-align:middle;">No.</th>
                    <th style="text-align:center;vertical-align:middle;">NIK</th>
                    <th style="text-align:center;vertical-align:middle;">NAMA KELUARGA PENERIMA MANFAAT
                    </th>
                    <th style="text-align:center;vertical-align:middle;">ALAMAT</th>
                    <th style="text-align:center;vertical-align:middle;">STATUS</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($logs as $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data->recipient->person->identification_number }}</td>
                        <td>{{ $data->recipient->person->name }}</td>
                        <td>{{ $data->recipient->person->village->name }}</td>
                        <td>{{ $data->status() }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center">DATA BELUM ADA</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="float: right; text-align: center;">
        <h6>MENGETAHUI</h6>
        <h6>KEPALA DESA PANTUNGO,</h6>
        <h6>&nbsp;</h6>
        <h6>&nbsp;</h6>
        <h6 style="margin: 0">SOFYAN GANI, SE</h6>
    </div>

</body>

</html>
