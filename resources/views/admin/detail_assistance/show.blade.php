@extends('layouts.admin.index')

@section('title')
    Detail Data Bantuan
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Dashboard /</span> Detail Data Bantuan
        </h4>

        <ul class="nav nav-pills flex-column flex-md-row mb-3">
            <li class="nav-item"><a class="nav-link active" href="{{ route('admin.detailAssistance.index') }}"><i
                        class="bx bx-arrow-back me-1"></i>
                    Kembali</a></li>
        </ul>

        <div class="card">
            <div class="card-body">
                <table class="table table-responsive-sm table-hover table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Nama</th>
                            <th scope="col">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Nama Bantuan</strong></td>
                            <td>{{ $detailAssistance->assistance->name }}</td>
                        </tr>
                        <tr>
                            <td><strong>Jenis Bantuan</strong></td>
                            <td>{{ $detailAssistance->type() }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tanggal Bantuan</strong></td>
                            <td>{{ $detailAssistance->input_date }}</td>
                        </tr>
                        <tr>
                            <td><strong>Informasi Tambahan</strong></td>
                            <td>
                                @foreach ($data as $key => $value)
                                    <li>{{ $key }}: {{ $value }}</li>
                                @endforeach
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
