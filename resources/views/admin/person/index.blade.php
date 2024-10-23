@extends('layouts.admin.index')

@section('title', 'Masyarakat')

@push('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.8/css/rowReorder.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
    <style>
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_info {
            margin-left: 1rem;
        }

        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_paginate {
            margin-right: 1rem;
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Responsive Table -->
        <div class="card">
            <div class="card-header">
                <h5>Data Masyarakat</h5>
                @can('create person')
                    <div class="btn-group">
                        <a class="btn btn-primary" href="{{ route('admin.person.create') }}"><i
                                class="bx bx-plus me-1"></i>Input Data
                            Masyarakat</a>
                    </div>
                @endcan

                @can('export person')
                    <div class="btn-group">
                        <div class="dropdown">
                            <button class="btn btn-info me-2 dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false"><i class="bx bxs-printer me-1"></i>
                                Cetak Data
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('admin.export.all') }}">Semua Masyarakat</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.export.low_income') }}">Masyarakat Kurang
                                        Mampu</a></li>
                            </ul>
                        </div>
                    </div>
                @endcan

            </div>
            <div class="table-responsive text-nowrap">
                <table class="table" id="listData">
                    <thead>
                        <tr class="text-nowrap">
                            <th>#</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>Pekerjaan Utama</th>
                            <th>Penghasilan Per Bulan</th>
                            <th>Dusun</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!--/ Responsive Table -->
    </div>
@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js" defer></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js" defer></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js" defer></script>
    <script src="https://cdn.datatables.net/rowreorder/1.2.8/js/dataTables.rowReorder.min.js" defer></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function() {
            $('#listData').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                ajax: '{{ url()->current() }}',
                columns: [{
                        data: 'DT_RowIndex'
                    },
                    {
                        data: 'name',
                    }, {
                        data: 'gender',
                    },
                    {
                        data: 'work',
                    }, {
                        data: 'income_month',
                    },
                    {
                        data: 'village',
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
            });

            // Sweet Alert Delete
            $("body").on('submit', `form[role='alert']`, function(event) {
                event.preventDefault();

                Swal.fire({
                    title: $(this).attr('alert-title'),
                    text: $(this).attr('alert-text'),
                    icon: "warning",
                    allowOutsideClick: false,
                    showCancelButton: true,
                    cancelButtonText: "Batal",
                    reverseButton: true,
                    confirmButtonText: "Hapus",
                }).then((result) => {
                    if (result.isConfirmed) {
                        event.target.submit();
                    }
                })
            });
        });
    </script>
@endpush
