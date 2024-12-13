@extends('layouts.user.index')

@section('content')
    <div class="hero_area">
        <!-- header section strats -->
        @include('layouts.user.include.header')
        <!-- end header section -->

        <div class="container mt-4">
            <h5 class="text-center mb-3">Cari Informasi Penerima Bantuan</h5>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">NO</th>
                            <th scope="col">NAMA</th>
                            <th scope="col">PEKERJAAN</th>
                            <th scope="col">ALAMAT</th>
                            <th scope="col">BANTUAN</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach ($results as $data)
                            <tr>
                                <th scope="row">{{ $no++ }}</th>
                                <td>{{ $data->person->name }}</td>
                                <td>{{ $data->person->work }}</td>
                                <td>{{ $data->person->village->name ?? '-' }}</td>
                                <td>{{ $data->assistance?->name ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
