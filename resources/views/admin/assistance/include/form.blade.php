<div class="row">
    <div class="col-md-12 mb-6">
        <label class="form-label" for="basic-default-fullname">Nama Bantuan</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
            value="{{ isset($assistance) ? $assistance->name : old('name') }}">
        @error('name')
            <div class="small text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12 mb-6">
        <label class="form-label" for="basic-default-fullname">Singkatan</label>
        <input type="text" name="alias" class="form-control @error('alias') is-invalid @enderror"
            value="{{ isset($assistance) ? $assistance->alias : old('alias') }}">
        @error('alias')
            <div class="small text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>
