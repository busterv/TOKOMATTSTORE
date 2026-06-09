
<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('content'); ?>
<h4 class="mb-4 fw-bold">Dashboard Overview</h4>
<div class="row g-4 mb-4">
    <div class="col-md-3"><div class="card p-3 border-start border-4 border-success"><h6 class="text-muted">Pendapatan Hari Ini</h6><h3 class="fw-bold text-success">Rp <?php echo e(number_format($stats['revenue'], 0, ',', '.')); ?></h3></div></div>
    <div class="col-md-3"><div class="card p-3 border-start border-4 border-primary"><h6 class="text-muted">HP Terjual Hari Ini</h6><h3 class="fw-bold text-primary"><?php echo e($stats['sold']); ?> Unit</h3></div></div>
    <div class="col-md-3"><div class="card p-3 border-start border-4 border-warning"><h6 class="text-muted">Total Stok Ready</h6><h3 class="fw-bold text-warning"><?php echo e($stats['stock']); ?> Unit</h3></div></div>
    <div class="col-md-3"><div class="card p-3 border-start border-4 border-info"><h6 class="text-muted">Transaksi Hari Ini</h6><h3 class="fw-bold text-info"><?php echo e($stats['txns']); ?> Trx</h3></div></div>
</div>
<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card p-4">
            <h5 class="mb-3">Tren Pendapatan Bulanan</h5>
            <canvas id="revenueChart" height="120"></canvas>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Transaksi Terakhir</h5>
                <button onclick="exportToExcel('tblRecent', 'Laporan_Trx')" class="btn btn-sm btn-success"><i class="fas fa-file-excel"></i></button>
            </div>
            <table class="table table-hover" id="tblRecent">
                <thead><tr><th>Kode</th><th>Total</th><th>Aksi</th></tr></thead>
                <tbody>
                    <?php $__currentLoopData = $recentTransactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><small><?php echo e($trx->transaction_code); ?></small></td>
                        <td>Rp <?php echo e(number_format($trx->total_price, 0, ',', '.')); ?></td>
                        <td><button class="btn btn-sm btn-outline-primary" onclick="showDetail(<?php echo e($trx->id); ?>)"><i class="fas fa-eye"></i></button></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white"><h5 class="modal-title">Detail Transaksi</h5><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button></div>
            <div class="modal-body" id="modalBody">Loading...</div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script>
    const ctx = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($chartLabels, 15, 512) ?>,
            datasets: [{ label: 'Pendapatan (Rp)', data: <?php echo json_encode($chartData, 15, 512) ?>, borderColor: '#059669', backgroundColor: 'rgba(5, 150, 105, 0.1)', fill: true, tension: 0.4 }]
        },
        options: { responsive: true, plugins: { legend: { display: false } } }
    });

    function showDetail(id) {
        document.getElementById('modalBody').innerHTML = '<div class="text-center py-4"><div class="spinner-border text-success"></div></div>';
        new bootstrap.Modal(document.getElementById('detailModal')).show();
        fetch(`/dashboard/transaction/${id}`)
            .then(res => res.json())
            .then(data => {
                let html = `<h6 class="fw-bold">Kode: ${data.transaction_code}</h6><p>Tanggal: ${new Date(data.transaction_date).toLocaleString()}</p>
                            <table class="table table-sm table-bordered"><thead><tr><th>Item HP</th><th>Qty</th><th>Harga</th><th>Subtotal</th></tr></thead><tbody>`;
                data.details.forEach(d => {
                    html += `<tr><td>${d.menu.item_name} (${d.menu.brand})</td><td>${d.quantity}</td><td>Rp ${Number(d.price_at_transaction).toLocaleString()}</td><td>Rp ${Number(d.subtotal).toLocaleString()}</td></tr>`;
                });
                html += `</tbody></table><div class="d-flex justify-content-end fw-bold"><div class="text-end">
                            <div>Total: Rp ${Number(data.total_price).toLocaleString()}</div>
                            <div>Bayar: Rp ${Number(data.total_paid).toLocaleString()}</div>
                            <div class="text-success">Kembali: Rp ${Number(data.total_return).toLocaleString()}</div></div></div>`;
                document.getElementById('modalBody').innerHTML = html;
            });
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\mattstore\resources\views/dashboard/index.blade.php ENDPATH**/ ?>