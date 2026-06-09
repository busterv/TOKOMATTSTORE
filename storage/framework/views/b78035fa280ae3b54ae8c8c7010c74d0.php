<?php $__env->startSection('content'); ?>


<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@700&display=swap');

    * {
        box-sizing: border-box;
    }

    .login-scene {
        min-height: 100vh;
        background: #060d0a;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
        font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif;
    }

    /* ---- Background dekoratif ---- */
    .bg-glow-top {
        position: absolute;
        width: 500px;
        height: 500px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(5,150,105,0.18) 0%, transparent 70%);
        top: -120px;
        right: -100px;
        pointer-events: none;
    }
    .bg-glow-bottom {
        position: absolute;
        width: 400px;
        height: 400px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(5,150,105,0.10) 0%, transparent 70%);
        bottom: -100px;
        left: -80px;
        pointer-events: none;
    }
    .bg-grid {
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(5,150,105,0.05) 1px, transparent 1px),
            linear-gradient(90deg, rgba(5,150,105,0.05) 1px, transparent 1px);
        background-size: 40px 40px;
        pointer-events: none;
    }

    /* ---- Kartu utama ---- */
    .login-card {
        position: relative;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(5, 150, 105, 0.25);
        border-radius: 20px;
        padding: 2.5rem;
        width: 100%;
        max-width: 460px;
        z-index: 1;
    }

    /* ---- Brand header ---- */
    .brand-icon {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: rgba(5, 150, 105, 0.15);
        border: 1px solid rgba(5, 150, 105, 0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-size: 26px;
    }
    .brand-title {
        font-family: 'Space Grotesk', sans-serif;
        font-size: 1.6rem;
        color: #fff;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }
    .brand-title span {
        color: #34d399;
    }
    .brand-sub {
        font-size: 13px;
        color: rgba(255, 255, 255, 0.4);
    }

    /* ---- Alert error ---- */
    .alert-custom {
        border-radius: 10px;
        padding: 10px 14px;
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 1.2rem;
    }
    .alert-danger-custom {
        background: rgba(220, 38, 38, 0.12);
        border: 1px solid rgba(220, 38, 38, 0.3);
        color: #fca5a5;
    }
    .alert-custom .btn-close-custom {
        margin-left: auto;
        background: none;
        border: none;
        color: #fca5a5;
        cursor: pointer;
        font-size: 16px;
        line-height: 1;
        padding: 0;
    }

    /* ---- Form label ---- */
    .form-label-custom {
        display: block;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.8px;
        text-transform: uppercase;
        color: rgba(255, 255, 255, 0.5);
        margin-bottom: 8px;
    }

    /* ---- Input group ---- */
    .input-group-custom {
        display: flex;
        align-items: center;
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        overflow: hidden;
        transition: border-color 0.2s, background 0.2s;
    }
    .input-group-custom:focus-within {
        border-color: rgba(52, 211, 153, 0.6);
        background: rgba(52, 211, 153, 0.05);
    }
    .input-icon {
        width: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: rgba(255, 255, 255, 0.3);
        font-size: 15px;
        flex-shrink: 0;
    }
    .input-group-custom input {
        flex: 1;
        background: transparent;
        border: none;
        outline: none;
        color: #fff;
        font-size: 14px;
        padding: 12px 0;
        font-family: inherit;
    }
    .input-group-custom input::placeholder {
        color: rgba(255, 255, 255, 0.25);
    }
    .toggle-password-btn {
        width: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: none;
        border: none;
        border-left: 1px solid rgba(255, 255, 255, 0.08);
        color: rgba(255, 255, 255, 0.3);
        cursor: pointer;
        transition: color 0.2s;
        padding: 0;
        height: 100%;
        min-height: 44px;
    }
    .toggle-password-btn:hover {
        color: rgba(52, 211, 153, 0.8);
    }

    /* ---- Remember me ---- */
    .remember-row {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 1.6rem;
    }
    .remember-row input[type="checkbox"] {
        width: 17px;
        height: 17px;
        accent-color: #34d399;
        cursor: pointer;
    }
    .remember-row label {
        font-size: 13px;
        color: rgba(255, 255, 255, 0.5);
        cursor: pointer;
        margin-bottom: 0;
    }

    /* ---- Tombol submit ---- */
    .btn-login {
        width: 100%;
        padding: 14px;
        border: none;
        border-radius: 10px;
        background: linear-gradient(135deg, #059669, #34d399);
        color: #fff;
        font-size: 15px;
        font-weight: 700;
        letter-spacing: 0.5px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: opacity 0.2s, transform 0.15s;
        font-family: inherit;
    }
    .btn-login:hover {
        opacity: 0.9;
        transform: translateY(-1px);
    }
    .btn-login:active {
        transform: translateY(0);
    }

    /* ---- Demo info box ---- */
    .demo-box {
        margin-top: 1.2rem;
        background: rgba(52, 211, 153, 0.06);
        border: 1px solid rgba(52, 211, 153, 0.2);
        border-radius: 10px;
        padding: 10px 14px;
    }
    .demo-box p {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.4);
        line-height: 1.7;
        margin: 0;
    }
    .demo-box p strong {
        color: rgba(52, 211, 153, 0.8);
        font-weight: 600;
    }
</style>


<div class="login-scene">

    
    <div class="bg-glow-top"></div>
    <div class="bg-glow-bottom"></div>
    <div class="bg-grid"></div>

    
    <div class="login-card">

        
        <div class="text-center mb-4">
            <div class="brand-icon">
                <i class="fas fa-mobile-alt"></i>
            </div>
            <h3 class="brand-title fw-bold mb-1">MATTSTORE <span>POS</span></h3>
            <p class="brand-sub mb-0">Sistem Kasir &amp; Manajemen Handphone</p>
        </div>

        
        <?php if($errors->any()): ?>
            <div class="alert-custom alert-danger-custom" role="alert">
                <i class="fas fa-exclamation-circle"></i>
                <span><?php echo e($errors->first()); ?></span>
                <button type="button" class="btn-close-custom" aria-label="Tutup notifikasi">✕</button>
            </div>
        <?php endif; ?>

        
        <form method="POST" action="<?php echo e(route('login')); ?>">
            <?php echo csrf_field(); ?>

            
            <div class="mb-3">
                <label for="email" class="form-label-custom">Email</label>
                <div class="input-group-custom">
                    <div class="input-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        placeholder="admin@mattstore.com"
                        value="<?php echo e(old('email')); ?>"
                        autocomplete="email"
                        required
                        autofocus>
                </div>
            </div>

            
            <div class="mb-3">
                <label for="password" class="form-label-custom">Password</label>
                <div class="input-group-custom">
                    <div class="input-icon">
                        <i class="fas fa-lock"></i>
                    </div>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        placeholder="••••••••"
                        autocomplete="current-password"
                        required>
                    <button
                        type="button"
                        class="toggle-password-btn"
                        id="toggleBtn"
                        title="Tampilkan / Sembunyikan password"
                        aria-label="Tampilkan atau sembunyikan password">
                        <i class="fas fa-eye" id="toggleIcon"></i>
                    </button>
                </div>
            </div>

            
            <div class="remember-row">
                <input
                    type="checkbox"
                    name="remember"
                    id="remember"
                    <?php echo e(old('remember') ? 'checked' : ''); ?>>
                <label for="remember">Ingat saya</label>
            </div>

            
            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt"></i> MASUK SISTEM
            </button>

            
            <div class="demo-box">
                <p>
                    <strong><i class="fas fa-info-circle me-1"></i> Demo Login</strong><br>
                    Email: <strong>admin@mattstore.com</strong><br>
                    Password: <strong>password123</strong>
                </p>
            </div>

        </form>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {

        // ---- Toggle show/hide password ----
        const toggleBtn  = document.getElementById('toggleBtn');
        const pwInput    = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');

        if (toggleBtn && pwInput && toggleIcon) {
            toggleBtn.addEventListener('click', function () {
                const isHidden = pwInput.type === 'password';

                pwInput.type = isHidden ? 'text' : 'password';
                toggleIcon.classList.toggle('fa-eye',      !isHidden);
                toggleIcon.classList.toggle('fa-eye-slash', isHidden);

                // Kembalikan fokus ke input setelah klik tombol
                pwInput.focus();
            });
        }

        // ---- Dismiss alert dengan klik ----
        document.querySelectorAll('.btn-close-custom').forEach(function (btn) {
            btn.addEventListener('click', function () {
                this.closest('.alert-custom').remove();
            });
        });

    });
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\mattstore\resources\views/auth/login.blade.php ENDPATH**/ ?>