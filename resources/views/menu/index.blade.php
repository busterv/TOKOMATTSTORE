@extends('layouts.app')
@section('title', 'Master Produk HP')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="fas fa-mobile-alt me-2 text-success"></i>Master Produk HP</h4>
    <a href="{{ route('menu.create') }}" class="btn btn-emerald">
        <i class="fas fa-plus me-1"></i> Tambah Produk
    </a>
</div>

<div class="card p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">Daftar Produk</h5>
        <div>
            <button onclick="exportToExcel('tblMenu', 'Laporan_Produk_HP')" class="btn btn-sm btn-success me-1">
                <i class="fas fa-file-excel me-1"></i> Excel
            </button>
            <button onclick="exportToWord('tblMenu', 'Laporan_Produk_HP')" class="btn btn-sm btn-primary">
                <i class="fas fa-file-word me-1"></i> Word
            </button>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle" id="tblMenu">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Kategori</th>
                    <th>Nama Produk</th>
                    <th>Brand</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($menus as $index => $menu)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td><span class="badge bg-secondary">{{ $menu->category->category_name }}</span></td>
                    <td class="fw-bold">{{ $menu->item_name }}</td>
                    <td>{{ $menu->brand }}</td>
                    <td>Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                    <td>
                        @if($menu->stock > 10)
                            <span class="badge bg-success">{{ $menu->stock }}</span>
                        @elseif($menu->stock > 0)
                            <span class="badge bg-warning text-dark">{{ $menu->stock }}</span>
                        @else
                            <span class="badge bg-danger">Habis</span>
                        @endif
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('menu.edit', $menu->id) }}" class="btn btn-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('menu.destroy', $menu->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">
                        <i class="fas fa-box-open fa-3x mb-3 d-block"></i>
                        Belum ada produk. Silakan tambahkan produk baru.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection