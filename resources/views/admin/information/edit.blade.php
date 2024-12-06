@extends('layouts.admin.index')

@section('title')
    Informasi
@endsection

@push('style')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Dashboard /</span> Informasi
        </h4>

        <div class="card">
            <h5 class="card-header">Edit Informasi</h5>

            <div class="card-body">
                <form action="{{ route('admin.information.update', $information->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    @include('admin.information.include.form')

                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary me-2">Simpan</button>
                        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#description').summernote({
                tabsize: 2,
                height: 300,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['help']],
                ],
            });
        });
    </script>
@endpush
