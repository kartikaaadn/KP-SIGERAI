 

<?php $__env->startSection('title', 'Landing'); ?>

<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<section class="sigera-hero">
    <div class="sigera-hero__overlay"></div>

    <div class="sigera-hero__container">
        <div class="sigera-hero__inner">
            <div class="sigera-hero__welcome">SELAMAT DATANG DI</div>

            
            <div class="sigera-hero__brand">
                <img 
                    src="<?php echo e(asset('assets/SIGERAIMPP.png')); ?>" 
                    alt="SIGERAIMPP"
                    class="sigera-hero__brand-img"
                >
            </div>

            <div class="sigera-hero__subtitle">
                Sistem Informasi Gerai Mal Pelayanan Publik
            </div>

            <div class="sigera-hero__buttons">
                <a href="/login" class="sigera-btn sigera-btn--primary">
                    <span class="sigera-btn__label">Login</span>
                    <span class="sigera-btn__ripple" aria-hidden="true"></span>
                </a>

                <a href="/register" class="sigera-btn sigera-btn--secondary">
                    <span class="sigera-btn__label">Daftar Akun</span>
                    <span class="sigera-btn__ripple" aria-hidden="true"></span>
                </a>
            </div>
        </div>
    </div>
</section>

<style>
/* ================= HERO ================= */
.sigera-hero{
    position: relative;
    min-height: calc(100vh - 90px);
    display:flex;
    align-items:center;
    justify-content:center;
    overflow:hidden;
}

.sigera-hero__overlay{
    position:absolute;
    inset:0;
    background: linear-gradient(
        90deg,
        rgba(244,69,69,.35),
        rgba(124,16,18,.35)
    );
}

.sigera-hero__container{
    position:relative;
    max-width:1200px;
    width:100%;
    padding:60px 24px;
}

.sigera-hero__inner{
    text-align:center;
    color:#fff;
    text-shadow:0 3px 14px rgba(0,0,0,.45);
}

.sigera-hero__welcome{
    font-size:14px;
    letter-spacing:6px;
    font-weight:700;
    margin-bottom:14px;
}

/* ===== BRAND AREA ===== */
.sigera-hero__brand{
    margin-bottom:14px;
}

/* BRAND IMAGE (pengganti text SIGERAIMPP) */
.sigera-hero__brand-img{
    height:55px;
    width:auto;
    max-width:100%;
    filter: drop-shadow(0 4px 14px rgba(0,0,0,.35));
}

.sigera-hero__subtitle{
    font-size:26px;
    margin-bottom:34px;
}

/* ================= BUTTON AREA ================= */
.sigera-hero__buttons{
    display:flex;
    justify-content:center;
    gap:18px;
    flex-wrap:wrap;
}

/* ================= BUTTON BASE ================= */
.sigera-btn{
    position: relative;
    display:inline-flex;
    align-items:center;
    justify-content:center;

    padding:14px 34px;
    border-radius:999px;
    font-weight:800;
    text-decoration:none;
    min-width:170px;
    text-align:center;

    overflow:hidden;
    transform: translateZ(0);

    transition:
        transform .18s ease,
        box-shadow .22s ease,
        filter .22s ease;
}

.sigera-btn__label{
    position:relative;
    z-index:2;
}

/* SHINE */
.sigera-btn::before{
    content:"";
    position:absolute;
    top:-60%;
    left:-40%;
    width:60%;
    height:220%;
    transform: rotate(25deg) translateX(-120%);
    opacity:0;
    background: linear-gradient(
        to right,
        rgba(255,255,255,0),
        rgba(255,255,255,.28),
        rgba(255,255,255,0)
    );
    transition: transform .55s ease, opacity .22s ease;
}

/* HOVER */
.sigera-btn:hover{
    transform: translateY(-3px);
    filter: saturate(1.05);
    box-shadow: 0 14px 30px rgba(0,0,0,.28);
}

.sigera-btn:hover::before{
    opacity:1;
    transform: rotate(25deg) translateX(260%);
}

/* ACTIVE */
.sigera-btn:active{
    transform: translateY(-1px) scale(.98);
    box-shadow: 0 8px 18px rgba(0,0,0,.22);
}

/* FOCUS */
.sigera-btn:focus-visible{
    outline:none;
    box-shadow: 0 0 0 4px rgba(255,255,255,.45), 0 14px 30px rgba(0,0,0,.28);
}

/* RIPPLE */
.sigera-btn__ripple{
    position:absolute;
    inset:0;
    pointer-events:none;
    background: radial-gradient(circle,
        rgba(255,255,255,.35) 0%,
        rgba(255,255,255,0) 55%
    );
    transform: scale(.2);
    opacity:0;
    transition: transform .35s ease, opacity .45s ease;
}

.sigera-btn:active .sigera-btn__ripple{
    transform: scale(1.4);
    opacity:1;
}

/* ================= LOGIN (PRIMARY) ================= */
.sigera-btn--primary{
    color:#fff;
    background: linear-gradient(
        90deg,
        #F44545 0%,
        #7C1012 100%
    );
    box-shadow: 0 10px 24px rgba(124,16,18,.28);
}

.sigera-btn--primary:hover{
    box-shadow:
        0 16px 34px rgba(124,16,18,.32),
        0 14px 30px rgba(0,0,0,.22);
}

/* ================= DAFTAR (SECONDARY) ================= */
.sigera-btn--secondary{
    color:#111;
    background: rgba(255,255,255,.92);
    backdrop-filter: blur(4px);
    box-shadow: 0 10px 24px rgba(0,0,0,.18);
}

.sigera-btn--secondary:hover{
    background: rgba(255,255,255,.98);
    box-shadow: 0 16px 34px rgba(0,0,0,.22);
}

/* ================= RESPONSIVE ================= */
@media (max-width:768px){
    .sigera-hero__brand-img{ height:46px; }
    .sigera-hero__subtitle{ font-size:18px; }
    .sigera-hero__welcome{ letter-spacing:4px; }
}

@media (max-width:420px){
    .sigera-hero__brand-img{ height:38px; }
    .sigera-btn{ width:100%; max-width:320px; }
}
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
    <?php echo $__env->make('partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\KP_SIGERAI\resources\views/landing.blade.php ENDPATH**/ ?>