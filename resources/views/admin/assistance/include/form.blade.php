<div class="row">
    <div class="col-md-12 mb-6">
        <label class="form-label" for="basic-default-fullname">Nama Bantuan</label>
        <input type="text" name="name" class="form-control @error('name')
            invalid
        @enderror"
            value="{{ isset($assistance) ? $assistance->name : old('name') }}">
        @error('name')
            <div class="small text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-12 mb-6">
        <label class="form-label" for="basic-default-fullname">Jenis Bantuan</label>
        <select name="type" id="" class="form-select @error('type')
        invalid
    @enderror">
            <option disabled selected>-- Pilih Jenis Bantuan --</option>
            <option value="1"
                {{ isset($assistance) && $assistance->type == 1 ? 'selected' : (old('type') == '1' ? 'selected' : '') }}>
                Tunai</option>
            <option value="2"
                {{ isset($assistance) && $assistance->type == 2 ? 'selected' : (old('type') == '2' ? 'selected' : '') }}>
                Non Tunai</option>
        </select>
        @error('type')
            <div class="small text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-12 mb-6">
        <label class="form-label" for="basic-default-fullname">Informasi Tambahan</label>
        <input type="text" name="additional_data" id="" class="form-control">
        @error('additional_data')
            <div class="small text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
