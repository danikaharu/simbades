@push('style')
    <style>
        textarea {
            white-space: pre-wrap;
        }
    </style>
@endpush

<div class="row">
    <div class="col-md-12 mb-6">
        <label class="form-label" for="basic-default-fullname">Nama Desa</label>
        <input type="text" name="village_name"
            class="form-control @error('village_name')
            invalid
        @enderror"
            value="{{ isset($profile) ? $profile->village_name : old('village_name') }}">
        @error('village_name')
            <div class="small text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-12 mb-6">
        <label class="form-label" for="basic-default-fullname">Alamat Desa</label>
        <input type="text" name="address" class="form-control @error('address')
        invalid
    @enderror"
            value="{{ isset($profile) ? $profile->address : old('address') }}">
        @error('address')
            <div class="small text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-12 mb-6">
        <label class="form-label" for="basic-default-fullname">Nomor Whatsapp</label>
        <input type="numeric" name="whatsapp_number"
            class="form-control @error('whatsapp_number')
        invalid
    @enderror"
            value="{{ isset($profile) ? $profile->whatsapp_number : old('whatsapp_number') }}">
        @error('whatsapp_number')
            <div class="small text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-3 p-2">
        <img src="{{ asset('storage/upload/logo/' . $profile->village_logo) }}" class="p-2" style="max-width:150px;">
    </div>
    <div class="col-md-9">
        <div class="form-group">
            <label for="exampleInputFile">Logo Desa</label>
            <div class="input-group">
                <div class="form-control">
                    <input type="file" class="custom-file-input" id="exampleInputFile" name="village_logo">
                    <label class="custom-file-label" for="exampleInputFile">Pilih
                        Gambar</label>
                </div>
            </div>
        </div>
    </div>
    @error('village_logo')
        <div class="small text-danger">
            {{ $message }}
        </div>
    @enderror
</div>
