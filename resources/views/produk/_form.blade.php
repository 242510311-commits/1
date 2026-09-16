@csrf

@if (!empty($produk?->foto))
    <div class="mb-3">
        <label class="form-label">Foto Saat Ini</label>
        <div>
            <img src="{{ asset('storage/' . $produk->foto) }}"
                 alt="Foto {{ $produk->nama }}"
                 width="150" class="img-thumbnail">
        </div>
    </div>
@endif

<div class="mb-3">
    <label for="foto" class="form-label">Gambar Produk</label>
    <input type="file" id="foto" name="foto"
           onchange="previewImage(this)"
           accept=".jpg,.jpeg,.png,image/jpeg,image/png"
           class="form-control @error('foto') is-invalid @enderror">
    @error('foto')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    <img id="preview" alt="Preview" class="img-thumbnail mt-2"
         style="display:none; max-width:150px;">
</div>

{{-- Dropdown Jenis Produk --}}
<div class="mb-3">
    <label for="jenis_produk_id" class="form-label">Jenis Produk</label>
    <select name="jenis_produk_id" id="jenis_produk_id" 
            class="form-select @error('jenis_produk_id') is-invalid @enderror" required>
        <option value="">-- Pilih Jenis Produk --</option>
        @foreach($jenisProduk as $jenis)
            <option value="{{ $jenis->id }}" 
                {{ old('jenis_produk_id', $produk->jenis_produk_id ?? '') == $jenis->id ? 'selected' : '' }}>
                {{ $jenis->nama_jenis }}
            </option>
        @endforeach
    </select>
    @error('jenis_produk_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="name" class="form-label">Nama Produk</label>
    <input type="text" id="name" name="name"
           class="form-control @error('name') is-invalid @enderror"
           value="{{ old('name', $produk->nama ?? '') }}" required>
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label for="purchase_price" class="form-label">Harga Beli</label>
        <input type="number" id="purchase_price" name="purchase_price" min="0"
               class="form-control @error('purchase_price') is-invalid @enderror"
               value="{{ old('purchase_price', $produk->harga_beli ?? '') }}" required>
        @error('purchase_price')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label for="selling_price" class="form-label">Harga Jual</label>
        <input type="number" id="selling_price" name="selling_price" min="0"
               class="form-control @error('selling_price') is-invalid @enderror"
               value="{{ old('selling_price', $produk->harga_jual ?? '') }}" required>
        @error('selling_price')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label for="stock" class="form-label">Stok</label>
        <input type="number" id="stock" name="stock" min="0"
               class="form-control @error('stock') is-invalid @enderror"
               value="{{ old('stock', $produk->stok ?? 0) }}" required>
        @error('stock')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<button class="btn btn-success" type="submit">
    <i class="bi bi-check-lg"></i> Simpan
</button>
<a href="{{ route('produk.index') }}" class="btn btn-secondary">Kembali</a>

<script>
function previewImage(input) {
    const preview = document.getElementById('preview');
    const file = input.files && input.files[0];

    if (!file) {
        preview.style.display = 'none';
        preview.removeAttribute('src');
        return;
    }

    preview.src = URL.createObjectURL(file);
    preview.style.display = 'block';
}
</script>