<div class="gerai-sidebar">
    <div class="gerai-sidebar__title">
        <span>Menu</span> <span class="grad">SIGERAIMPP</span>
    </div>

    <a class="gerai-link <?php echo e(request()->is('gerai/dashboard') ? 'active' : ''); ?>"
       href="<?php echo e(route('gerai.dashboard')); ?>">
        <span class="icon">📊</span> Dashboard
    </a>

    <a class="gerai-link <?php echo e(request()->is('gerai/laporan*') ? 'active' : ''); ?>"
       href="<?php echo e(route('gerai.laporan.index')); ?>">
        <span class="icon">📄</span> Seluruh Laporan
    </a>

    <a class="gerai-link <?php echo e(request()->is('gerai/ranking*') ? 'active' : ''); ?>"
       href="<?php echo e(route('gerai.ranking.index')); ?>">
        <span class="icon">🏆</span> Ranking Top 1-3
    </a>

    <a class="gerai-link <?php echo e(request()->is('gerai/riwayat*') ? 'active' : ''); ?>"
       href="<?php echo e(route('gerai.riwayat.index')); ?>">
        <span class="icon">🕘</span> Riwayat
    </a>

    <a class="gerai-link <?php echo e(request()->is('gerai/pesan*') ? 'active' : ''); ?>"
       href="<?php echo e(route('gerai.pesan.index')); ?>">
        <span class="icon">✉️</span> Pesan
    </a>

    <a class="gerai-link <?php echo e(request()->is('gerai/statistika*') ? 'active' : ''); ?>"
       href="<?php echo e(route('gerai.statistika.index')); ?>">
        <span class="icon">📈</span> Statistika
    </a>

    <form method="POST" action="<?php echo e(route('logout')); ?>" class="logout-form">
        <?php echo csrf_field(); ?>
        <button type="submit" class="gerai-link logout">
            <span class="icon">⎋</span> Logout
        </button>
    </form>
</div>

<style>
:root{
    --footerGrad: linear-gradient(90deg, #F12424 0%, #791B91 50%, #0011FF 100%);
}

.gerai-sidebar{
    width: 280px;
    min-height: 100vh;
    position: sticky;
    top: 0;
    background: rgba(255,255,255,.92);
    border-right: 1px solid rgba(0,0,0,.10);
    padding: 18px 14px;
    box-sizing: border-box;
}

.gerai-sidebar__title{
    font-size: 22px;
    font-weight: 800;
    margin-bottom: 16px;
}
.gerai-sidebar__title .grad{
    background: var(--footerGrad);
    -webkit-background-clip:text;
    background-clip:text;
    color: transparent;
}

.gerai-link{
    display:flex;
    align-items:center;
    gap:10px;
    padding: 12px 12px;
    border-radius: 10px;
    margin-bottom: 10px;
    text-decoration:none;
    color:#111;
    font-weight:700;
    background:#fff;
    border: 1px solid rgba(0,0,0,.15);
    transition: .15s ease;
    font-size: 14px;
}
.gerai-link:hover{
    transform: translateY(-1px);
    box-shadow: 0 10px 16px rgba(0,0,0,.10);
}
.gerai-link .icon{ width: 22px; text-align:center; }

.gerai-link.active{
    color:#fff;
    border:0;
    background: var(--footerGrad);
}

.logout-form{ margin-top: 10px; }
.gerai-link.logout{
    width:100%;
    cursor:pointer;
}
</style>
<?php /**PATH C:\laragon\www\KP_SIGERAI\resources\views/partials/sidebar-gerai.blade.php ENDPATH**/ ?>