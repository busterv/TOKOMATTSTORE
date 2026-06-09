
<?php $__env->startSection('title', 'Master Produk HP'); ?>
<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="fas fa-mobile-alt me-2 text-success"></i>Master Produk HP</h4>
    <a href="<?php echo e(route('menu.create')); ?>" class="btn btn-emerald">
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
                <?php $__empty_1 = true; $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($index + 1); ?></td>
                    <td><span class="badge bg-secondary"><?php echo e($menu->category->category_name); ?></span></td>
                    <td class="fw-bold"><?php echo e($menu->item_name); ?></td>
                    <td><?php echo e($menu->brand); ?></td>
                    <td>Rp <?php echo e(number_format($menu->price, 0, ',', '.')); ?></td>
                    <td>
                        <?php if($menu->stock > 10): ?>
                            <span class="badge bg-success"><?php echo e($menu->stock); ?></span>
                        <?php elseif($menu->stock > 0): ?>
                            <span class="badge bg-warning text-dark"><?php echo e($menu->stock); ?></span>
                        <?php else: ?>
                            <span class="badge bg-danger">Habis</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <a href="<?php echo e(route('menu.edit', $menu->id)); ?>" class="btn btn-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="<?php echo e(route('menu.destroy', $menu->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
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
                    <td colspan="7" class="text-center text-muted py-4">
                        <i class="fas fa-box-open fa-3x mb-3 d-block"></i>
                        Belum ada produk. Silakan tambahkan produk baru.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\mattstore\resources\views/menu/index.blade.php ENDPATH**/ ?>