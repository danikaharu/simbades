@extends('layouts.admin.index')

@section('title', 'Edit Pekerjaan')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-6">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Edit Data Pekerjaan</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.work.update', $work->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            @include('admin.work.include.form')

                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
