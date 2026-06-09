
<?php $__env->startSection('title', 'Manajemen Kategori'); ?>
<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="fas fa-tags me-2 text-success"></i>Manajemen Kategori</h4>
    <a href="<?php echo e(route('categories.create')); ?>" class="btn btn-emerald">
        <i class="fas fa-plus me-1"></i> Tambah Kategori
    </a>
</div>

<div class="card p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">Daftar Kategori Produk</h5>
        <div>
            <button onclick="exportToExcel('tblCategories', 'Laporan_Kategori')" class="btn btn-sm btn-success me-1">
                <i class="fas fa-file-excel me-1"></i> Excel
            </button>
            <button onclick="exportToWord('tblCategories', 'Laporan_Kategori')" class="btn btn-sm btn-primary">
                <i class="fas fa-file-word me-1"></i> Word
            </button>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle" id="tblCategories">
            <thead class="table-dark">
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Nama Kategori</th>
                    <th>Jumlah Produk</th>
                    <th style="width: 150px;" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($index + 1); ?></td>
                    <td class="fw-bold"><?php echo e($category->category_name); ?></td>
                    <td>
                        <span class="badge bg-info text-dark">
                            <?php echo e($category->menus_count ?? $category->menus()->count()); ?> Produk
                        </span>
                    </td>
                    <td class="text-center">
                        <div class="btn-group btn-group-sm" role="group">
                            <a href="<?php echo e(route('categories.edit', $category->id)); ?>" class="btn btn-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="<?php echo e(route('categories.destroy', $category->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus kategori ini? Produk dalam kategori ini juga akan terhapus!')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-danger" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">
                        <i class="fas fa-folder-open fa-3x mb-3 d-block"></i>
                        Belum ada kategori. Silakan tambahkan kategori baru.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\mattstore\resources\views/categories/index.blade.php ENDPATH**/ ?>