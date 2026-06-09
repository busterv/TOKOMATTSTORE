@extends('layouts.app')
@section('title', 'Tambah Produk')
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0"><i class="fas fa-plus-circle me-2 text-success"></i>Tambah Produk HP</h4>
            <a href="{{ route('menu.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <div class="card p-4">
            <form action="{{ route('menu.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-bold">Kategori <span class="text-danger">*</span></label>
                    <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->category_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Produk <span class="text-danger">*</span></label>
                    <input type="text" name="item_name" class="form-control @error('item_name') is-invalid @enderror" 
                           value="{{ old('item_name') }}" placeholder="Contoh: iPhone 15 Pro Max" required>
                    @error('item_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Brand <span class="text-danger">*</span></label>
                    <input type="text" name="brand" class="form-control @error('brand') is-invalid @enderror" 
                           value="{{ old('brand') }}" placeholder="Contoh: Apple, Samsung, Xiaomi" required>
                    @error('brand')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Harga Jual (Rp) <span class="text-danger">*</span></label>
                        <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" 
                               value="{{ old('price') }}" placeholder="Contoh: 15000000" required min="0">
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Stok <span class="text-danger">*</span></label>
                        <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" 
                               value="{{ old('stock', 0) }}" placeholder="Contoh: 10" required min="0">
                        @error('stock')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Deskripsi</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                              rows="3" placeholder="Contoh: 256GB, Natural Titanium">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('menu.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-emerald">
                        <i class="fas fa-save me-1"></i> Simpan Produk
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection