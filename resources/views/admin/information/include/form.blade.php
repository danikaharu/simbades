<div class="row">
    <div class="mb-3 col-md-12">
        <label for="description" class="form-label">Deskripsi</label>
        <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description', $information->description) }}</textarea>
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
