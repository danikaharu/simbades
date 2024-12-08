<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview Data</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Preview Data</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>NO KK</th>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>Hubungan Keluarga</th>
                    <th>Tempat Lahir</th>
                    <th>Tgl Lahir</th>
                    <th>Agama</th>
                    <th>Pendidikan Terakhir</th>
                    <th>Pekerjaan Utama</th>
                    <th>Penghasilan Perbulan</th>
                    <th>Dusun</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($persons as $person)
                    <tr>
                        <td>{{ $person->family_card }}</td>
                        <td>{{ $person->identification_number }}</td>
                        <td>{{ $person->name }}</td>
                        <td>{{ $person->gender() }}</td>
                        <td>{{ $person->kinship() }}</td>
                        <td>{{ $person->birth_place }}</td>
                        <td>{{ $person->birth_date }}</td>
                        <td>{{ $person->religion() }}</td>
                        <td>{{ $person->last_education() }}</td>
                        <td>{{ $person->work }}</td>
                        <td>{{ 'Rp ' . number_format($person->income_month, 0, ',', '.') }}</td>
                        <td>{{ $person->village->name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <a href="{{ route('admin.person.index') }}" class="btn btn-secondary mt-3">Kembali</a>
        <a href="{{ route('admin.export.low_income') }}" class="btn btn-success mt-3">Download Excel</a>
    </div>
</body>

</html>
