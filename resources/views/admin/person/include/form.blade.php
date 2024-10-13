 <div class="row">
     <div class="col-md-6 mb-6">
         <label class="form-label" for="basic-default-fullname">Nomor KK</label>
         <input type="number" name="family_card"
             class="form-control @error('family_card')
            invalid
        @enderror"
             value="{{ isset($person) ? $person->family_card : old('family_card') }}">
         @error('family_card')
             <div class="small text-danger">
                 {{ $message }}
             </div>
         @enderror
     </div>
     <div class="col-md-6 mb-6">
         <label class="form-label" for="basic-default-fullname">NIK</label>
         <input type="number" name="identification_number"
             class="form-control @error('identification_number')
            invalid
        @enderror"
             value="{{ isset($person) ? $person->identification_number : old('identification_number') }}">
         @error('identification_number')
             <div class="small text-danger">
                 {{ $message }}
             </div>
         @enderror
     </div>
     <div class="col-md-6 mb-6">
         <label class="form-label" for="basic-default-fullname">Nama</label>
         <input type="text" name="name" class="form-control @error('name')
            invalid
        @enderror"
             value="{{ isset($person) ? $person->name : old('name') }}">
         @error('name')
             <div class="small text-danger">
                 {{ $message }}
             </div>
         @enderror
     </div>
     <div class="col-md-6 mb-6">
         <label class="form-label" for="basic-default-fullname">Jenis Kelamin</label>
         <select name="gender" id="" class="form-select @error('gender')
        invalid
    @enderror">
             <option disabled selected>-- Pilih Jenis Kelamin --</option>
             <option value="1"
                 {{ isset($person) && $person->gender == 1 ? 'selected' : (old('gender') == '1' ? 'selected' : '') }}>
                 Laki - Laki</option>
             <option value="2"
                 {{ isset($person) && $person->gender == 2 ? 'selected' : (old('gender') == '2' ? 'selected' : '') }}>
                 Perempuan</option>
         </select>
         @error('gender')
             <div class="small text-danger">
                 {{ $message }}
             </div>
         @enderror
     </div>
     <div class="col-md-6 mb-6">
         <label class="form-label" for="basic-default-fullname">Tempat Lahir</label>
         <input type="text" name="birth_place"
             class="form-control @error('birth_place')
            invalid
        @enderror"
             value="{{ isset($person) ? $person->birth_place : old('birth_place') }}">
         @error('birth_place')
             <div class="small text-danger">
                 {{ $message }}
             </div>
         @enderror
     </div>
     <div class="col-md-6 mb-6">
         <label class="form-label" for="basic-default-fullname">Tanggal Lahir</label>
         <input type="date" name="birth_date"
             class="form-control @error('birth_date')
            invalid
        @enderror"
             value="{{ isset($person) ? $person->birth_date : old('birth_date') }}">
         @error('birth_date')
             <div class="small text-danger">
                 {{ $message }}
             </div>
         @enderror
     </div>
     <div class="col-md-6 mb-6">
         <label class="form-label" for="basic-default-fullname">Hubungan Keluarga</label>
         <select name="kinship" id="" class="form-select @error('kinship')
        invalid
    @enderror">
             <option disabled selected>-- Pilih Hubungan Keluarga --</option>
             <option value="1"
                 {{ isset($person) && $person->kinship == 1 ? 'selected' : (old('kinship') == '1' ? 'selected' : '') }}>
                 Kepala Keluarga</option>
             <option value="2"
                 {{ isset($person) && $person->kinship == 2 ? 'selected' : (old('kinship') == '2' ? 'selected' : '') }}>
                 Istri</option>
             <option value="3"
                 {{ isset($person) && $person->kinship == 3 ? 'selected' : (old('kinship') == '3' ? 'selected' : '') }}>
                 Anak</option>
             <option value="4"
                 {{ isset($person) && $person->kinship == 4 ? 'selected' : (old('kinship') == '4' ? 'selected' : '') }}>
                 Kakek</option>
             <option value="5"
                 {{ isset($person) && $person->kinship == 5 ? 'selected' : (old('kinship') == '5' ? 'selected' : '') }}>
                 Nenek</option>
             <option value="6"
                 {{ isset($person) && $person->kinship == 6 ? 'selected' : (old('kinship') == '6' ? 'selected' : '') }}>
                 Famili Lain</option>
         </select>
         @error('kinship')
             <div class="small text-danger">
                 {{ $message }}
             </div>
         @enderror
     </div>
     <div class="col-md-6 mb-6">
         <label class="form-label" for="basic-default-fullname">Pendidikan Terakhir</label>
         <select name="last_education" id=""
             class="form-select @error('last_education')
        invalid
    @enderror">
             <option disabled selected>-- Pilih Pendidikan Terakhir --</option>
             <option value="1"
                 {{ isset($person) && $person->last_education == 1 ? 'selected' : (old('last_education') == '1' ? 'selected' : '') }}>
                 Tidak Sekolah</option>
             <option value="2"
                 {{ isset($person) && $person->last_education == 2 ? 'selected' : (old('last_education') == '2' ? 'selected' : '') }}>
                 Tidak Tamat SD</option>
             <option value="3"
                 {{ isset($person) && $person->last_education == 3 ? 'selected' : (old('last_education') == '3' ? 'selected' : '') }}>
                 SD dan Sederajat</option>
             <option value="4"
                 {{ isset($person) && $person->last_education == 4 ? 'selected' : (old('last_education') == '4' ? 'selected' : '') }}>
                 SMP dan Sederajat</option>
             <option value="5"
                 {{ isset($person) && $person->last_education == 5 ? 'selected' : (old('last_education') == '5' ? 'selected' : '') }}>
                 SMA dan Sedejarat</option>
             <option value="6"
                 {{ isset($person) && $person->last_education == 6 ? 'selected' : (old('last_education') == '6' ? 'selected' : '') }}>
                 Diploma 1 - 3</option>
             <option value="7"
                 {{ isset($person) && $person->last_education == 7 ? 'selected' : (old('last_education') == '7' ? 'selected' : '') }}>
                 S1 dan Sederajat</option>
             <option value="8"
                 {{ isset($person) && $person->last_education == 8 ? 'selected' : (old('last_education') == '8' ? 'selected' : '') }}>
                 S2 dan Sederajat</option>
             <option value="9"
                 {{ isset($person) && $person->last_education == 9 ? 'selected' : (old('last_education') == '9' ? 'selected' : '') }}>
                 S3 dan Sederajat</option>
         </select>
         @error('last_education')
             <div class="small text-danger">
                 {{ $message }}
             </div>
         @enderror
     </div>
     <div class="col-md-6 mb-6">
         <label class="form-label" for="basic-default-fullname">Nama Ayah</label>
         <input type="text" name="father_name"
             class="form-control @error('father_name')
            invalid
        @enderror"
             value="{{ isset($person) ? $person->father_name : old('father_name') }}">
         @error('father_name')
             <div class="small text-danger">
                 {{ $message }}
             </div>
         @enderror
     </div>
     <div class="col-md-6 mb-6">
         <label class="form-label" for="basic-default-fullname">Nama Ibu</label>
         <input type="text" name="mother_name"
             class="form-control @error('mother_name')
            invalid
        @enderror"
             value="{{ isset($person) ? $person->mother_name : old('mother_name') }}">
         @error('mother_name')
             <div class="small text-danger">
                 {{ $message }}
             </div>
         @enderror
     </div>
     <div class="col-md-6 mb-6">
         <label class="form-label" for="basic-default-fullname">Agama</label>
         <select name="religion" id="" class="form-select @error('religion')
        invalid
    @enderror">
             <option disabled selected>-- Pilih Agama --</option>
             <option value="1"
                 {{ isset($person) && $person->religion == 1 ? 'selected' : (old('religion') == '1' ? 'selected' : '') }}>
                 Islam</option>
             <option value="2"
                 {{ isset($person) && $person->religion == 2 ? 'selected' : (old('religion') == '2' ? 'selected' : '') }}>
                 Kristen</option>
             <option value="3"
                 {{ isset($person) && $person->religion == 3 ? 'selected' : (old('religion') == '3' ? 'selected' : '') }}>
                 Hindu</option>
             <option value="4"
                 {{ isset($person) && $person->religion == 4 ? 'selected' : (old('religion') == '4' ? 'selected' : '') }}>
                 Budha</option>
             <option value="5"
                 {{ isset($person) && $person->religion == 5 ? 'selected' : (old('religion') == '5' ? 'selected' : '') }}>
                 Konghucu</option>
         </select>
         @error('religion')
             <div class="small text-danger">
                 {{ $message }}
             </div>
         @enderror
     </div>
     <div class="col-md-6 mb-6">
         <label class="form-label" for="basic-default-fullname">Dusun</label>
         <select name="village_id" id=""
             class="form-select @error('village_id')
        invalid
    @enderror">
             <option disabled selected>-- Pilih Dusun --</option>
             @foreach ($villages as $village)
                 <option value="{{ $village->id }}"
                     {{ isset($person) && $person->village_id == $village->id ? 'selected' : (old('village_id') == $village->id ? 'selected' : '') }}>
                     {{ $village->name }}</option>
             @endforeach
         </select>
         @error('village_id')
             <div class="small text-danger">
                 {{ $message }}
             </div>
         @enderror
     </div>
     <div class="col-md-6 mb-6">
         <label class="form-label" for="basic-default-fullname">Pekerjaan Utama</label>
         {{-- <select name="work_id" id="" class="form-select @error('work_id')
    invalid
@enderror">
            <option disabled selected>-- Pilih Pekerjaan Utama --</option>
            @foreach ($works as $work)
                <option value="{{ $work->id }}"
                    {{ isset($person) && $person->work_id == $work->id ? 'selected' : (old('work_id') == $work->id ? 'selected' : '') }}>
                    {{ $work->name }}</option>
            @endforeach
        </select>
        @error('work_id')
            <div class="small text-danger">
                {{ $message }}
            </div>
        @enderror --}}
         <input type="text" name="work" class="form-control @error('work')
        invalid
    @enderror"
             value="{{ isset($person) ? $person->work : old('work') }}">
         @error('work')
             <div class="small text-danger">
                 {{ $message }}
             </div>
         @enderror
     </div>
     <div class="col-md-6 mb-6">
         <label class="form-label" for="basic-default-fullname">Penghasilan Per Bulan</label>
         <input type="text" name="income_month"
             class="form-control @error('income_month')
            invalid
        @enderror"
             value="{{ isset($person) ? $person->income_month : old('income_month') }}">
         @error('income_month')
             <div class="small text-danger">
                 {{ $message }}
             </div>
         @enderror
     </div>
 </div>
