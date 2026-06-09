@extends('layouts.app')
@section('title', 'Tambah Kategori')
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0"><i class="fas fa-plus-circle me-2 text-success"></i>Tambah Kategori</h4>
            <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <div class="card p-4">
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="category_name" class="form-label fw-bold">Nama Kategori <span class="text-danger">*</span></label>
                    <input type="text" 
                           name="category_name" 
                           id="category_name"
                           class="form-control @error('category_name') is-invalid @enderror" 
                           value="{{ old('category_name') }}" 
                           placeholder="Contoh: Smartphone Flagship, Aksesoris, Tablet" 
                           required 
                           autofocus>
                    @error('category_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">Nama kategori akan muncul di dropdown saat menambah produk.</div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('categories.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-emerald">
                        <i class="fas fa-save me-1"></i> Simpan Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection