@extends('layouts.admin.index')

@section('title', 'Nama KPM')

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
                <h5>Data Nama KPM</h5>
                @can('create recipient')
                    <div class="btn-group">
                        <a class="btn btn-primary" href="{{ route('admin.recipient.create') }}"><i
                                class="bx bx-plus me-1"></i>Input Data
                            Nama KPM</a>
                    </div>
                @endcan
                @can('export recipient')
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exportModal"><i
                                class="bx bxs-printer"></i>
                            Cetak
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exportModalLabel">Data Penerimaan Bantuan</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('admin.export.recipient') }}" method="GET">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="col mb-0">
                                                <label for="endDate" class="form-label">Tahun</label>
                                                <select style="cursor:pointer;" class="form-select" name="year">
                                                    <option disabled selected>-- Pilih Tahun --</option>
                                                    @php
                                                        $year = date('Y');
                                                        $min = $year - 5;
                                                        $max = $year;
                                                        for ($i = $max; $i >= $min; $i--) {
                                                            echo '<option value=' . $i . '>' . $i . '</option>';
                                                        }
                                                    @endphp
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Cetak</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
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
                            <th>Alamat</th>
                            <th>Bantuan</th>
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
                }, {
                    data: 'person',
                }, {
                    data: 'address',
                }, {
                    data: 'assistance',
                }, {
                    data: 'action',
                    orderable: false,
                    searchable: false,
                }, ],
            });
        });
    </script>
@endpush
