
<div class="admin-sidebar">
    <div class="admin-sidebar__title">
        <span>Menu</span> <span class="grad">SIGERAIMPP</span>
    </div>

    <a class="admin-link <?php echo e(request()->is('admin/dashboard') ? 'active' : ''); ?>"
       href="<?php echo e(route('admin.dashboard')); ?>">
        <span class="icon">📈</span>
        Dashboard
    </a>

    
    <a class="admin-link <?php echo e(request()->is('admin/laporan*') ? 'active' : ''); ?>"
       href="<?php echo e(Route::has('admin.laporan.index') ? route('admin.laporan.index') : '#'); ?>">
        <span class="icon">📄</span>
        Mengelola Laporan
    </a>

    <a class="admin-link <?php echo e(request()->is('admin/gerai*') ? 'active' : ''); ?>"
       href="<?php echo e(Route::has('admin.gerai.index') ? route('admin.gerai.index') : '#'); ?>">
        <span class="icon">🏢</span>
        Mengelola Gerai
    </a>

    <a class="admin-link <?php echo e(request()->is('admin/ranking*') ? 'active' : ''); ?>"
       href="<?php echo e(Route::has('admin.ranking.index') ? route('admin.ranking.index') : '#'); ?>">
        <span class="icon">🏆</span>
        Ranking Layanan
    </a>

    
    <a class="admin-link <?php echo e(request()->is('admin/pesan*') ? 'active active-header' : ''); ?>"
       href="<?php echo e(route('admin.pesan.index')); ?>">
        <span class="icon">✉️</span>
        Pesan
    </a>

    <form method="POST" action="<?php echo e(route('logout')); ?>" class="logout-form">
        <?php echo csrf_field(); ?>
        <button type="submit" class="admin-link logout">
            <span class="icon">⎋</span>
            Logout
        </button>
    </form>
</div>

<style>
:root{
    /* warna footer (yang kamu pakai sebelumnya) */
    --footerGrad: linear-gradient(90deg, #F12424 0%, #791B91 50%, #0011FF 100%);

    /* ✅ warna header (samakan dengan header kamu) */
    /* kalau header kamu beda, ubah warna di sini */
    --headerGrad: linear-gradient(90deg, #E53935 0%, #B71C1C 100%);
}

.admin-sidebar{
    width: 260px;
    background: rgba(255,255,255,.92);
    border-right: 1px solid rgba(0,0,0,.12);
    padding: 18px 14px;
    box-sizing: border-box;
}

.admin-sidebar__title{
    font-size: 22px;
    font-weight: 800;
    margin-bottom: 18px;
}
.admin-sidebar__title .grad{
    background: var(--footerGrad);
    -webkit-background-clip:text;
    background-clip:text;
    color: transparent;
}

.admin-link{
    display:flex;
    align-items:center;
    gap: 10px;
    padding: 12px 12px;
    border-radius: 8px;
    margin-bottom: 10px;
    text-decoration:none;
    color:#111;
    font-weight:700;
    background: rgba(255,255,255,.95);
    border: 1px solid rgba(0,0,0,.15);
    transition: transform .15s ease, box-shadow .15s ease;
}
.admin-link:hover{
    transform: translateY(-2px);
    box-shadow: 0 10px 18px rgba(0,0,0,.10);
}
.admin-link .icon{ width: 22px; text-align:center; }

/* default active (menu lain) tetap footer */
.admin-link.active{
    color:#fff;
    border: 0;
    background: var(--footerGrad);
}

/* ✅ khusus Pesan active → header */
.admin-link.active.active-header{
    background: var(--headerGrad);
}

.logout-form{ margin-top: 10px; }
.admin-link.logout{
    width:100%;
    cursor:pointer;
}
</style>
<?php /**PATH C:\laragon\www\KP_SIGERAI\resources\views/partials/sidebar-admin.blade.php ENDPATH**/ ?>