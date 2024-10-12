<div class="row">
    <div class="col-md-12 mb-6">
        <label class="form-label" for="basic-default-fullname">Masyarakat</label>
        <select name="person_id" class="form-select @error('person_id')
        invalid
    @enderror">
            <option disabled selected>-- Pilih Masyarakat --</option>
            @foreach ($persons as $person)
                <option value="{{ $person->id }}"
                    {{ isset($recipient) && $recipient->person_id == $person->id ? 'selected' : (old('person_id') == $person->id ? 'selected' : '') }}>
                    {{ $person->name }}</option>
            @endforeach
        </select>
        @error('person_id')
            <div class="small text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-12 mb-6">
        <label class="form-label" for="basic-default-fullname">Bantuan</label>
        <select name="assistance_id" id="assistance_id"
            class="form-select @error('assistance_id')
        invalid
    @enderror">
            <option disabled selected>-- Pilih Bantuan --</option>
            @foreach ($assistances as $assistance)
                <option value="{{ $assistance->id }}"
                    {{ isset($recipient) && $recipient->assistance_id == $assistance->id ? 'selected' : (old('assistance_id') == $assistance->id ? 'selected' : '') }}>
                    {{ $assistance->name }} - {{ $assistance->type() }}</option>
            @endforeach
        </select>
        @error('assistance_id')
            <div class="small text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-12 mb-6">
        <label class="form-label" for="basic-default-fullname">Tahun Penerimaan</label>
        <select name="year" id="year" class="form-select @error('year')
        invalid
    @enderror">
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
        @error('year')
            <div class="small text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
