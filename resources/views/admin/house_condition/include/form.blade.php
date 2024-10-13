<div class="row">
    <div class="col-md-6 mb-6">
        <label class="form-label" for="basic-default-fullname">Luas Bangunan</label>
        <select name="building_area" id=""
            class="form-select @error('building_area')
        invalid
    @enderror">
            <option disabled selected>-- Pilih Luas Bangunan --</option>
            <option value="1"
                {{ isset($person->houseCondition) && $person->houseCondition->building_area == 1 ? 'selected' : (old('building_area') == '1' ? 'selected' : '') }}>
                < 50m Persegi</option>
            <option value="2"
                {{ isset($person->houseCondition) && $person->houseCondition->building_area == 2 ? 'selected' : (old('building_area') == '2' ? 'selected' : '') }}>
                50 - 99m Persegi</option>
            <option value="3"
                {{ isset($person->houseCondition) && $person->houseCondition->building_area == 3 ? 'selected' : (old('building_area') == '3' ? 'selected' : '') }}>
                100 - 199m Persegi</option>
            <option value="4"
                {{ isset($person->houseCondition) && $person->houseCondition->building_area == 4 ? 'selected' : (old('building_area') == '4' ? 'selected' : '') }}>
                200 - 499m Persegi</option>
            <option value="5"
                {{ isset($person->houseCondition) && $person->houseCondition->building_area == 5 ? 'selected' : (old('building_area') == '5' ? 'selected' : '') }}>
                500 - 100m Persegi</option>
            <option value="6"
                {{ isset($person->houseCondition) && $person->houseCondition->building_area == 6 ? 'selected' : (old('building_area') == '6' ? 'selected' : '') }}>
                > 1000m Persegi</option>
        </select>
        @error('building_area')
            <div class="small text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-6 mb-6">
        <label class="form-label" for="basic-default-fullname">Jenis Lantai</label>
        <select name="floor_material" id=""
            class="form-select @error('floor_material')
        invalid
    @enderror">
            <option disabled selected>-- Pilih Jenis Lantai --</option>
            <option value="1"
                {{ isset($person->houseCondition) && $person->houseCondition->floor_material == 1 ? 'selected' : (old('floor_material') == '1' ? 'selected' : '') }}>
                Marmer</option>
            <option value="2"
                {{ isset($person->houseCondition) && $person->houseCondition->floor_material == 2 ? 'selected' : (old('floor_material') == '2' ? 'selected' : '') }}>
                Kayu/Papan</option>
            <option value="3"
                {{ isset($person->houseCondition) && $person->houseCondition->floor_material == 3 ? 'selected' : (old('floor_material') == '3' ? 'selected' : '') }}>
                Semen</option>
            <option value="4"
                {{ isset($person->houseCondition) && $person->houseCondition->floor_material == 4 ? 'selected' : (old('floor_material') == '4' ? 'selected' : '') }}>
                Bambu</option>
            <option value="5"
                {{ isset($person->houseCondition) && $person->houseCondition->floor_material == 5 ? 'selected' : (old('floor_material') == '5' ? 'selected' : '') }}>
                Lainnya</option>
        </select>
        @error('floor_material')
            <div class="small text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-6 mb-6">
        <label class="form-label" for="basic-default-fullname">Jenis Dinding</label>
        <select name="wall_material" id="" class="form-select @error('wall_material')
    invalid
@enderror">
            <option disabled selected>-- Pilih Jenis Dinding --</option>
            <option value="1"
                {{ isset($person->houseCondition) && $person->houseCondition->wall_material == 1 ? 'selected' : (old('wall_material') == '1' ? 'selected' : '') }}>
                Bambu</option>
            <option value="2"
                {{ isset($person->houseCondition) && $person->houseCondition->wall_material == 2 ? 'selected' : (old('wall_material') == '2' ? 'selected' : '') }}>
                Tembok Tanpa Diplester</option>
            <option value="3"
                {{ isset($person->houseCondition) && $person->houseCondition->wall_material == 3 ? 'selected' : (old('wall_material') == '3' ? 'selected' : '') }}>
                Lainnya</option>
        </select>
        @error('wall_material')
            <div class="small text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-6 mb-6">
        <label class="form-label" for="basic-default-fullname">Sumber Listrik</label>
        <input type="text" name="electricity_source"
            class="form-control @error('electricity_source')
           invalid
       @enderror"
            value="{{ isset($person->houseCondition) ? $person->houseCondition->electricity_source : old('electricity_source') }}">
        @error('electricity_source')
            <div class="small text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-6 mb-6">
        <label class="form-label" for="basic-default-fullname">Sumber Air</label>
        <input type="text" name="water_source"
            class="form-control @error('water_source')
        invalid
    @enderror"
            value="{{ isset($person->houseCondition) ? $person->houseCondition->water_source : old('water_source') }}">
        @error('water_source')
            <div class="small text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-6 mb-6">
        <label class="form-label" for="basic-default-fullname">Daya Listrik Rumah</label>
        <input type="text" name="electricity_capacity"
            class="form-control @error('electricity_capacity')
        invalid
    @enderror"
            value="{{ isset($person->houseCondition) ? $person->houseCondition->electricity_capacity : old('electricity_capacity') }}">
        @error('electricity_capacity')
            <div class="small text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-6 mb-6">
        <label class="form-label" for="basic-default-fullname">Bahan Bakar Masak</label>
        <select name="cooking_fuel" id=""
            class="form-select @error('cooking_fuel')
       invalid
   @enderror">
            <option disabled selected>-- Pilih Bahan Bakar Masak --</option>
            <option value="1"
                {{ isset($person->houseCondition) && $person->houseCondition->cooking_fuel == 1 ? 'selected' : (old('cooking_fuel') == '1' ? 'selected' : '') }}>
                Kayu Bakar</option>
            <option value="2"
                {{ isset($person->houseCondition) && $person->houseCondition->cooking_fuel == 2 ? 'selected' : (old('cooking_fuel') == '2' ? 'selected' : '') }}>
                Minyak Tanah</option>
            <option value="3"
                {{ isset($person->houseCondition) && $person->houseCondition->cooking_fuel == 3 ? 'selected' : (old('cooking_fuel') == '3' ? 'selected' : '') }}>
                Gas</option>
        </select>
        @error('cooking_fuel')
            <div class="small text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="col-md-6 mb-6">
        <label class="form-label" for="basic-default-fullname">Fasilitas MCK</label>
        <select name="sanitation_facility" id=""
            class="form-select @error('sanitation_facility')
       invalid
   @enderror">
            <option disabled selected>-- Pilih Fasilitas MCK --</option>
            <option value="1"
                {{ isset($person->houseCondition) && $person->houseCondition->sanitation_facility == 1 ? 'selected' : (old('sanitation_facility') == '1' ? 'selected' : '') }}>
                Milik Umum</option>
            <option value="2"
                {{ isset($person->houseCondition) && $person->houseCondition->sanitation_facility == 2 ? 'selected' : (old('sanitation_facility') == '2' ? 'selected' : '') }}>
                Milik Pribadi</option>
        </select>
        @error('sanitation_facility')
            <div class="small text-danger">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
