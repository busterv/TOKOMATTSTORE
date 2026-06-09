
<?php $__env->startSection('title', 'Kasir POS'); ?>
<?php $__env->startSection('content'); ?>
<div class="row g-3">
    <!-- Sisi Kiri: Katalog Produk -->
    <div class="col-lg-7">
        <div class="card p-3 h-100">
            <div class="d-flex justify-content-between mb-3">
                <h5 class="fw-bold mb-0">Katalog Handphone</h5>
                <input type="text" id="searchMenu" class="form-control w-50" placeholder="Cari nama HP...">
            </div>
            <div class="row" id="catalogContainer" style="max-height: 60vh; overflow-y: auto;"></div>
        </div>
    </div>

    <!-- Sisi Kanan: Keranjang -->
    <div class="col-lg-5">
        <div class="card p-3 h-100 bg-white">
            <h5 class="fw-bold mb-3">Keranjang Belanja</h5>
            <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                <table class="table table-sm table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Produk</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="cartBody">
                        <tr><td colspan="4" class="text-center text-muted py-3">Keranjang kosong</td></tr>
                    </tbody>
                </table>
            </div>
            
            <hr>
            
            <input type="hidden" id="cartTotal" value="0">
            <input type="hidden" id="cartReturn" value="0">
            
            <div class="mb-3">
                <label class="form-label fw-bold">💰 Uang Bayar (Rp)</label>
                <input type="number" id="totalPaid" class="form-control form-control-lg fw-bold text-end" placeholder="0" oninput="calculateChange()">
            </div>
            
            <div class="d-flex justify-content-between align-items-center mb-3 p-3 bg-light rounded">
                <div>
                    <small class="text-muted d-block">Total Belanja</small>
                    <h4 class="fw-bold mb-0 text-success" id="displayTotal">Rp 0</h4>
                </div>
                <div class="text-end">
                    <small class="text-muted d-block">Kembalian</small>
                    <h4 class="fw-bold mb-0 text-primary" id="displayChange">Rp 0</h4>
                </div>
            </div>
            
            <button class="btn btn-emerald w-100 py-3 fw-bold fs-5" onclick="processTransaction()" id="btnProcess">
                <i class="fas fa-check-circle me-2"></i> PROSES TRANSAKSI
            </button>
        </div>
    </div>
</div>

<!-- Modal Struk Preview -->
<div class="modal fade" id="successModal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="fas fa-check me-2"></i>Transaksi Berhasil!</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <p class="mb-1">Kode Transaksi:</p>
                <h5 class="fw-bold" id="modalTrxCode">TRX-XXXX</h5>
                <p class="text-muted small" id="modalTrxDate"></p>
                <div class="d-grid gap-2">
                    <button class="btn btn-outline-success btn-sm" onclick="printStruk()">
                        <i class="fas fa-print me-1"></i> Cetak Struk
                    </button>
                    <button class="btn btn-emerald btn-sm" onclick="resetPOS()">
                        <i class="fas fa-plus me-1"></i> Transaksi Baru
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    // === KONFIGURASI ===
    const menus = <?php echo json_encode($menus, 15, 512) ?>;
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
    let cart = [];
    let lastTransactionId = null;

    console.log('POS Loaded:', { menusCount: menus.length, csrfToken: csrfToken ? 'OK' : 'MISSING' });

    // === RENDER KATALOG ===
    function renderCatalog(filter = '') {
        const container = document.getElementById('catalogContainer');
        container.innerHTML = '';
        
        const filtered = menus.filter(m => 
            m.item_name.toLowerCase().includes(filter.toLowerCase()) || 
            m.brand.toLowerCase().includes(filter.toLowerCase())
        );
        
        if (filtered.length === 0) {
            container.innerHTML = '<div class="col-12 text-center text-muted py-4">Produk tidak ditemukan</div>';
            return;
        }
        
        filtered.forEach(m => {
            const card = document.createElement('div');
            card.className = 'col-md-6 col-lg-4 mb-3';
            card.innerHTML = `
                <div class="card h-100 border-0 shadow-sm product-card" 
                     style="cursor: pointer;" 
                     onclick="addToCart(${m.id}, '${escapeHtml(m.item_name)}', ${m.price}, ${m.stock})">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="badge bg-secondary">${m.category?.category_name || 'Umum'}</span>
                            <span class="badge ${m.stock > 10 ? 'bg-success' : 'bg-warning'}">${m.stock} stok</span>
                        </div>
                        <h6 class="fw-bold mb-1 text-truncate">${m.item_name}</h6>
                        <small class="text-muted d-block mb-2">${m.brand}</small>
                        <div class="fw-bold text-success">Rp ${Number(m.price).toLocaleString('id-ID')}</div>
                    </div>
                </div>`;
            container.appendChild(card);
        });
    }

    // === FUNGSI BANTUAN ===
    function escapeHtml(text) {
        const map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
        return text.replace(/[&<>"']/g, m => map[m]);
    }

    function formatRupiah(amount) {
        return 'Rp ' + Number(amount).toLocaleString('id-ID');
    }

    // === KERANJANG ===
    function addToCart(id, name, price, stock) {
        const existing = cart.find(item => item.menu_id === id);
        
        if (existing) {
            if (existing.quantity < stock) {
                existing.quantity++;
            } else {
                Swal.fire('Stok Habis!', `Maksimal ${stock} unit tersedia`, 'warning');
                return;
            }
        } else {
            cart.push({
                menu_id: id,
                name: name,
                price: parseFloat(price),
                quantity: 1,
                max_stock: stock
            });
        }
        renderCart();
    }

    function renderCart() {
        const tbody = document.getElementById('cartBody');
        
        if (cart.length === 0) {
            tbody.innerHTML = '<tr><td colspan="4" class="text-center text-muted py-3">Keranjang kosong</td></tr>';
            document.getElementById('displayTotal').innerText = formatRupiah(0);
            document.getElementById('cartTotal').value = 0;
            calculateChange();
            return;
        }
        
        tbody.innerHTML = '';
        let total = 0;
        
        cart.forEach((item, index) => {
            const subtotal = item.price * item.quantity;
            total += subtotal;
            
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>
                    <div class="fw-bold small">${item.name}</div>
                    <small class="text-muted">${formatRupiah(item.price)}</small>
                </td>
                <td style="width: 80px;">
                    <div class="input-group input-group-sm">
                        <button class="btn btn-outline-secondary py-0" onclick="updateQty(${index}, -1)">-</button>
                        <input type="text" class="form-control form-control-sm text-center py-0" value="${item.quantity}" readonly style="max-width: 40px;">
                        <button class="btn btn-outline-secondary py-0" onclick="updateQty(${index}, 1)">+</button>
                    </div>
                </td>
                <td class="text-end fw-bold small">${formatRupiah(subtotal)}</td>
                <td style="width: 30px;">
                    <button class="btn btn-sm btn-link text-danger p-0" onclick="removeItem(${index})">
                        <i class="fas fa-times"></i>
                    </button>
                </td>
            `;
            tbody.appendChild(row);
        });
        
        document.getElementById('displayTotal').innerText = formatRupiah(total);
        document.getElementById('cartTotal').value = total;
        calculateChange();
    }

    function updateQty(index, change) {
        const item = cart[index];
        if (!item) return;
        
        if (item.quantity + change > item.max_stock) {
            Swal.fire('Stok Terbatas', `Maksimal ${item.max_stock} unit`, 'warning');
            return;
        }
        
        if (item.quantity + change <= 0) {
            cart.splice(index, 1);
        } else {
            item.quantity += change;
        }
        renderCart();
    }

    function removeItem(index) {
        cart.splice(index, 1);
        renderCart();
    }

    function calculateChange() {
        const total = parseInt(document.getElementById('cartTotal').value) || 0;
        const paid = parseInt(document.getElementById('totalPaid').value) || 0;
        const change = Math.max(0, paid - total);
        
        document.getElementById('displayChange').innerText = formatRupiah(change);
        document.getElementById('cartReturn').value = change;
    }

    // === PROSES TRANSAKSI ===
    async function processTransaction() {
        // Validasi awal
        if (cart.length === 0) {
            Swal.fire('Keranjang Kosong', 'Silakan tambahkan produk terlebih dahulu', 'warning');
            return;
        }
        
        const total = parseInt(document.getElementById('cartTotal').value) || 0;
        const paid = parseInt(document.getElementById('totalPaid').value) || 0;
        
        if (paid < total) {
            Swal.fire('Kurang Bayar', `Kekurangan: ${formatRupiah(total - paid)}`, 'error');
            return;
        }
        
        if (!csrfToken) {
            Swal.fire('Error System', 'CSRF Token tidak ditemukan. Silakan refresh halaman.', 'error');
            console.error('CSRF Token missing');
            return;
        }

        // UI Loading
        const btn = document.getElementById('btnProcess');
        const originalBtnText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memproses...';

        try {
            const response = await fetch('/pos/store', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    items: cart,
                    total_price: total,
                    total_paid: paid,
                    total_return: parseInt(document.getElementById('cartReturn').value)
                })
            });

            const data = await response.json();
            
            if (!response.ok) {
                throw new Error(data.message || 'Terjadi kesalahan server');
            }
            
            if (data.success) {
                // Tampilkan modal sukses
                lastTransactionId = data.trx_id;
                document.getElementById('modalTrxCode').innerText = data.code;
                document.getElementById('modalTrxDate').innerText = new Date().toLocaleString('id-ID');
                
                const modal = new bootstrap.Modal(document.getElementById('successModal'));
                modal.show();
            } else {
                throw new Error(data.message || 'Transaksi gagal diproses');
            }
            
        } catch (error) {
            console.error('Transaction Error:', error);
            Swal.fire('Transaksi Gagal', error.message, 'error');
        } finally {
            // Reset button
            btn.disabled = false;
            btn.innerHTML = originalBtnText;
        }
    }

    // === CETAK STRUK ===
    function printStruk() {
        if (lastTransactionId) {
            window.open(`/pos/print/${lastTransactionId}`, '_blank');
        }
    }

    // === RESET POS ===
    function resetPOS() {
        cart = [];
        document.getElementById('totalPaid').value = '';
        document.getElementById('displayChange').innerText = formatRupiah(0);
        renderCart();
        renderCatalog();
        
        // Tutup modal
        const modalEl = document.getElementById('successModal');
        const modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
    }

    // === EVENT LISTENERS ===
    document.getElementById('searchMenu').addEventListener('input', (e) => {
        renderCatalog(e.target.value);
    });

    // Init
    document.addEventListener('DOMContentLoaded', function() {
        renderCatalog();
        console.log('POS System Ready');
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\mattstore\resources\views/transactions/pos.blade.php ENDPATH**/ ?>