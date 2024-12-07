@extends('layouts.admin.index')

@section('title', 'Penerimaan Bantuan')

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
                <h5>Penerimaan Bantuan</h5>
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
                                    <form action="{{ route('admin.log.export') }}" method="GET">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-4 mb-0">
                                                    <label for="endDate" class="form-label">Bantuan</label>
                                                    <select style="cursor:pointer;" class="form-select" name="assistance_id">
                                                        <option disabled selected>-- Pilih Bantuan --</option>
                                                        @foreach ($assistances as $assistance)
                                                            <option value="{{ $assistance->id }}">
                                                                {{ $assistance->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4 mb-0">
                                                    <label for="endDate" class="form-label">Bulan</label>
                                                    <select style="cursor:pointer;" class="form-select" name="month">
                                                        <option disabled selected>-- Pilih Bulan --</option>
                                                        @php
                                                            for ($m = 1; $m <= 12; ++$m) {
                                                                $month_label = date('F', mktime(0, 0, 0, $m, 1));
                                                                echo '<option value=' .
                                                                    $m .
                                                                    '>' .
                                                                    $month_label .
                                                                    '</option>';
                                                            }
                                                        @endphp
                                                    </select>
                                                </div>
                                                <div class="col-md-4 mb-0">
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
                            <th>Bantuan</th>
                            <th>Periode</th>
                            <th>Status</th>
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
                        data: 'person',
                    },
                    {
                        data: 'assistance',
                    },
                    {
                        data: 'period',
                    },
                    {
                        data: 'status',
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
