<div class="row">
    <div class="col-md-12 mb-6">
        <label class="form-label" for="basic-default-fullname">Nama Pekerjaan</label>
        <input type="text" name="name" class="form-control @error('name')
            invalid
        @enderror"
            value="{{ isset($work) ? $work->name : old('name') }}">
        @error('name')
            <div class="small text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
