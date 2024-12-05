@extends('layouts.admin.index')

@section('title', 'Dashboard')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card mb-3">
            <div class="d-flex align-items-start row">
                <div class="col-sm-7">
                    <div class="card-body">
                        <h5 class="card-title text-primary mb-3">Selamat datang di Sistem Informasi Bantuan Masyarakat Desa
                        </h5>
                        <p class="mb-6">
                            Program ini dirancang pemerintah untuk membantu berjalannya program pemberantas masyarakat
                            kurang mampu yang diprogramkan oleh pemerintah pusat
                        </p>
                    </div>
                </div>
                <div class="col-sm-5 text-center text-sm-left">
                    <div class="card-body pb-0 px-0 px-md-6">
                        <img src="{{ asset('template_admin/img/illustrations/man-with-laptop.png') }}" height="175"
                            class="scaleX-n1-rtl" alt="View Badge User">
                    </div>
                </div>
            </div>
        </div>
        @hasanyrole('Masyarakat')
            <div class="row">
                <div class="col-lg-6 mb-2">
                    <div class="card card-border-shadow-primary h-100 ">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <div class="avatar me-4">
                                    <span class="avatar-initial rounded bg-label-primary"><i
                                            class="bx bxs-user-pin bx-lg"></i></span>
                                </div>
                                <h4 class="mb-0">Tata Cara Pengambilan</h4>
                            </div>
                            <ol>
                                <li>Buka browser dan masuk ke situs https://www.simbades.my.id/ atau masuk melalui aplikasi
                                    simbades.</li>
                                <li>Pilih menu login, kemudian masukan username dan password yang telah diberikan pihak
                                    kantor
                                    desa</li>
                                <li>Masuk ke menu KPM, kemudian pilih Penerimaan Bantuan.</li>
                                <li>Pilih jenis bantuan yang akan di ambil, lalu tekan Cetak Qr-Code</li>
                                <li>Setelah Qr-Code nya tampil, segera perlihatkan ke pegawai kantor desa untuk dilakukan scan.
                                </li>
                                <li>Tunggu beberapa saat hingga pemindaian selesai</li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-2">
                    <div class="card card-border-shadow-primary h-100 ">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <div class="avatar me-4">
                                    <span class="avatar-initial rounded bg-label-primary"><i
                                            class="bx bxs-user-pin bx-lg"></i></span>
                                </div>
                                <h4 class="mb-0">Waktu dan Lokasi</h4>
                            </div>
                            <p class="mb-2">Dinamis</p>
                        </div>
                    </div>
                </div>
            </div>
        @endhasanyrole
        @hasanyrole('Super Admin|Kasi Kesejahteraan|Kepala Desa')
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
        @endhasanyrole
    </div>
@endsection
