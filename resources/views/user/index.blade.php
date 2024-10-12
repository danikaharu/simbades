@extends('layouts.user.index')

@section('content')
    <div class="hero_area">
        @include('layouts.user.include.header')
        <!-- slider section -->
        <section class="slider_section long_section">
            <div class="container">
                <div class="row">
                    <div class="col-md-5">
                        <div class="detail-box">
                            <h5>Selamat datang di</h5>
                            <h1>
                                Sistem Informasi Bantuan <br />
                                Masyarakat Desa
                            </h1>
                            <p>
                                Program ini dirancang pemerintah untuk membantu berjalannya
                                program pemberantasan masyarakat kurang mampu yang
                                diprogramkan oleh pemerintah pusat
                            </p>
                            <div class="btn-box">
                                <button type="button" class="btn btn1" data-toggle="modal" data-target="#exampleModal">
                                    Lihat
                                    Daftar Penerima Bantuan </button>


                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="img-box">
                            <img src="{{ asset('template_user/images/slider-img.png') }}" alt="" />
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end slider section -->
    </div>

    <!-- about section -->

    <section class="about_section layout_padding long_section">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="img-box">
                        <img src="{{ asset('template_user/images/about-img.png') }}" alt="" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-box">
                        <div class="heading_container">
                            <h2>Kontak Hotline Bantuan Sosial</h2>
                        </div>
                        <p>
                            Anda dapat menghubungi Hotline Bantuan Sosial untuk bertanya
                            atau sekedar mencari informasi seputar Bantuan
                        </p>
                        <a href="https://wa.me/{{ ltrim($profile->whatsapp_number, '+') }}" target="_blank">Hubungi
                            Kami</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- end about section -->

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection
