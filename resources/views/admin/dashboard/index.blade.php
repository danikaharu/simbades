@extends('layouts.admin.index')

@section('title', 'Dashboard')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        {{-- <h5 class="mb-2">Selamat datang,<span class="h4"> {{ auth()->user()->name }} 👋🏻</span></h5> --}}
        <div class="row">
            <div class="col-lg-4 col-sm-6 mb-2">
                <div class="card card-border-shadow-primary h-100 ">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-primary"><i
                                        class="bx bxs-user-pin bx-lg"></i></span>
                            </div>
                            <h4 class="mb-0">{{ $totalMale }}</h4>
                        </div>
                        <p class="mb-2">Jumlah Laki - Laki</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 mb-2">
                <div class="card card-border-shadow-primary h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-primary"><i
                                        class="bx bxs-user-pin bx-lg"></i></span>
                            </div>
                            <h4 class="mb-0">{{ $totalFemale }}</h4>
                        </div>
                        <p class="mb-2">Jumlah Perempuan</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 mb-2">
                <div class="card card-border-shadow-primary h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-primary"><i
                                        class="bx bxs-user-pin bx-lg"></i></span>
                            </div>
                            <h4 class="mb-0">{{ $totalPerson }}</h4>
                        </div>
                        <p class="mb-2">Total Masyarakat</p>
                    </div>
                </div>
            </div>
            @foreach ($assistanceCounts as $assistance)
                <div class="col-lg-4 col-sm-6 mb-2">
                    <div class="card card-border-shadow-primary h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <div class="avatar me-4">
                                    <span class="avatar-initial rounded bg-label-primary"><i
                                            class="bx bx-notepad bx-lg"></i></span>
                                </div>
                                <h4 class="mb-0">{{ $assistance['recipient_count'] ?? 0 }}</h4>
                            </div>
                            <p class="mb-2">{{ $assistance['name'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
