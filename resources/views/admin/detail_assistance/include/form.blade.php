<div class="row">
    <div class="col-md-12 mb-6">
        <label class="form-label" for="basic-default-fullname">Bantuan</label>
        <select name="assistance_id" class="form-select @error('assistance_id') is-invalid @enderror">
            <option disabled selected>-- Pilih Bantuan --</option>
            @foreach ($assistances as $assistance)
                <option value="{{ $assistance->id }}"
                    {{ isset($detailAssistance) && $detailAssistance->assistance_id == $assistance->id ? 'selected' : (old('assistance_id') == $assistance->id ? 'selected' : '') }}>
                    {{ $assistance->name }}</option>
            @endforeach
        </select>
        @error('assistance_id')
            <div class="small text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12 mb-6">
        <label class="form-label" for="basic-default-fullname">Tanggal Input</label>
        <input type="date" name="input_date" class="form-control @error('input_date') is-invalid @enderror"
            value="{{ isset($detailAssistance) ? $detailAssistance->input_date : old('input_date') }}">
        @error('input_date')
            <div class="small text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12 mb-6">
        <label class="form-label" for="basic-default-fullname">Jenis Bantuan</label>
        <select name="type" id="assistanceType" class="form-select @error('type') is-invalid @enderror">
            <option disabled selected>-- Pilih Jenis Bantuan --</option>
            <option value="1"
                {{ isset($detailAssistance) && $detailAssistance->type == 1 ? 'selected' : (old('type') == '1' ? 'selected' : '') }}>
                Tunai</option>
            <option value="2"
                {{ isset($detailAssistance) && $detailAssistance->type == 2 ? 'selected' : (old('type') == '2' ? 'selected' : '') }}>
                Non Tunai</option>
        </select>
        @error('type')
            <div class="small text-danger">{{ $message }}</div>
        @enderror
    </div>

    <!-- Input nominal muncul hanya untuk Tunai -->
    <div class="col-md-12 mb-6" id="nominalContainer" style="display: none;">
        <label class="form-label" for="additionalNominal">Nominal</label>
        <input type="text" name="additional_data[nominal]" id="additionalNominal" class="form-control"
            placeholder="Masukkan nominal"
            value="{{ old('additional_data.nominal', isset($detailAssistance) ? json_decode($detailAssistance->additional_data)->nominal ?? '' : '') }}">
        @error('additional_data.nominal')
            <div class="small text-danger">{{ $message }}</div>
        @enderror
    </div>

    <!-- Input jumlah barang muncul hanya untuk Non Tunai -->
    <div class="col-md-12 mb-6" id="jumlahBarangContainer" style="display: none;">
        <label class="form-label" for="jumlahBarang">Jumlah Barang</label>
        <input type="text" id="jumlahBarang" class="form-control"
            value="{{ old('additional_data.jumlah_barang', isset($detailAssistance) ? count(json_decode($detailAssistance->additional_data)->nama_barang ?? []) : 1) }}">
    </div>

    <div id="additionalFields" class="mb-3">
        @if (isset($detailAssistance))
            @foreach (json_decode($detailAssistance->additional_data)->nama_barang ?? [] as $index => $nama_barang)
                <div class="mb-3">
                    <label class="form-label">Nama Barang {{ $index + 1 }}</label>
                    <input type="text" name="additional_data[nama_barang][]" class="form-control"
                        value="{{ $nama_barang }}" required>
                    <label class="form-label">Jumlah Barang {{ $index + 1 }}</label>
                    <input type="text" name="additional_data[jumlah_barang][]" class="form-control"
                        value="{{ json_decode($detailAssistance->additional_data)->jumlah_barang[$index] ?? '' }}"
                        required>
                </div>
            @endforeach
        @endif
    </div>
</div>

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const assistanceType = document.getElementById('assistanceType');
            const nominalContainer = document.getElementById('nominalContainer');
            const jumlahBarangContainer = document.getElementById('jumlahBarangContainer');
            const jumlahBarangInput = document.getElementById('jumlahBarang');
            const additionalFields = document.getElementById('additionalFields');

            // Mengatur nilai awal ketika halaman dimuat
            const initialType = '{{ old('type', isset($assistance) ? $assistance->type : null) }}';
            if (initialType) {
                assistanceType.value = initialType;
                assistanceType.dispatchEvent(new Event(
                    'change')); // Trigger event change untuk menampilkan input yang sesuai
            }

            // Fungsi untuk menangani perubahan jenis bantuan
            assistanceType.addEventListener('change', function() {
                const type = this.value;

                // Kosongkan input tambahan
                additionalFields.innerHTML = '';
                nominalContainer.style.display = 'none'; // Sembunyikan input nominal
                jumlahBarangContainer.style.display = 'none'; // Sembunyikan jumlah barang

                if (type == '1') { // Tunai
                    nominalContainer.style.display = 'block'; // Tampilkan input nominal
                } else if (type == '2') { // Non Tunai
                    jumlahBarangContainer.style.display = 'block'; // Tampilkan jumlah barang
                    jumlahBarangInput.value = 1; // Reset ke 1
                    createItemFields(1); // Buat field untuk 1 barang
                }
            });

            // Fungsi untuk membuat input barang berdasarkan jumlah
            jumlahBarangInput.addEventListener('input', function() {
                const jumlah = parseInt(this.value) || 1; // Ambil nilai atau set ke 1
                createItemFields(jumlah);
            });

            function createItemFields(jumlah) {
                additionalFields.innerHTML = ''; // Kosongkan isi sebelumnya

                for (let i = 0; i < jumlah; i++) {
                    additionalFields.innerHTML += `
                <div class="mb-3">
                    <label class="form-label">Nama Barang ${i + 1}</label>
                    <input type="text" name="additional_data[nama_barang][]" class="form-control" required>
                    <label class="form-label">Jumlah Barang ${i + 1}</label>
                    <input type="text" name="additional_data[jumlah_barang][]" class="form-control" required>
                </div>
            `;
                }
            }
        });
    </script>
@endpush
