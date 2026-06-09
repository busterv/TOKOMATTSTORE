<!DOCTYPE html>
<html>
<head>
    <title>Struk <?php echo e($transaction->transaction_code); ?></title>
    <style>
        body { font-family: 'Courier New', monospace; width: 80mm; margin: 0 auto; padding: 10px; font-size: 12px; }
        .text-center { text-align: center; }
        .d-flex { display: flex; justify-content: space-between; }
        .border-top { border-top: 1px dashed #000; margin: 10px 0; padding-top: 10px; }
        .fw-bold { font-weight: bold; }
        @media print { body { width: 100%; } .no-print { display: none; } }
    </style>
</head>
<body onload="window.print()">
    <div class="text-center">
        <h3>MATTSTORE</h3>
        <p>Jl. Teknologi No. 12, Kota Digital<br>Telp: 0812-3456-7890</p>
    </div>
    <div class="border-top"></div>
    <div class="d-flex"><span>Kode:</span> <span><?php echo e($transaction->transaction_code); ?></span></div>
    <div class="d-flex"><span>Tanggal:</span> <span><?php echo e(date('d/m/Y H:i', strtotime($transaction->transaction_date))); ?></span></div>
    <div class="d-flex"><span>Kasir:</span> <span><?php echo e($transaction->user->name); ?></span></div>
    <div class="border-top"></div>
    
    <?php $__currentLoopData = $transaction->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div style="margin-bottom: 5px;">
        <div><?php echo e($detail->menu->item_name); ?></div>
        <div class="d-flex">
            <span><?php echo e($detail->quantity); ?> x <?php echo e(number_format($detail->price_at_transaction, 0, ',', '.')); ?></span>
            <span><?php echo e(number_format($detail->subtotal, 0, ',', '.')); ?></span>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    
    <div class="border-top"></div>
    <div class="d-flex fw-bold"><span>TOTAL</span> <span>Rp <?php echo e(number_format($transaction->total_price, 0, ',', '.')); ?></span></div>
    <div class="d-flex"><span>Bayar</span> <span>Rp <?php echo e(number_format($transaction->total_paid, 0, ',', '.')); ?></span></div>
    <div class="d-flex"><span>Kembali</span> <span>Rp <?php echo e(number_format($transaction->total_return, 0, ',', '.')); ?></span></div>
    
    <div class="border-top"></div>
    <div class="text-center">
        <p>Terima kasih telah berbelanja di MATTSTORE<br>Barang yang dibeli tidak dapat ditukar/dikembalikan</p>
    </div>
    <button class="no-print" onclick="window.close()" style="width:100%; padding: 10px; margin-top: 20px; background: #059669; color: white; border: none; border-radius: 4px;">Tutup Jendela</button>
</body>
</html><?php /**PATH C:\laragon\www\mattstore\resources\views/transactions/print.blade.php ENDPATH**/ ?>