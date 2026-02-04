

<?php $__env->startSection('title', 'Login Gerai'); ?>

<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<section class="login-page">
    <div class="login-page__bg"></div>
    <div class="login-page__overlay"></div>

    <div class="login-card">
        <div class="login-title">
            <span class="login-title__grad">LOGIN</span>
            <span class="login-title__grad">GERAI</span>
        </div>

        <div class="login-subtitle">(Silahkan masukkan username dan password Anda!)</div>

        <form class="login-form" method="POST" action="<?php echo e(route('gerai.login.submit')); ?>">
            <?php echo csrf_field(); ?>

            <div class="field">
                <label>Username Gerai</label>
                <input type="text" name="username" placeholder="Silahkan masukkan username gerai" required>
            </div>

            <div class="field">
                <label>Password Gerai</label>
                <input type="password" name="password" placeholder="Silahkan masukkan password gerai" required>
            </div>

            <button class="btn-submit" type="submit">Masuk</button>

            <div class="divider">
                <span>Atau login dengan</span>
            </div>

            <a class="btn-google" href="<?php echo e(route('google.redirect')); ?>">
                <span class="g-icon">G</span>
                <span>Masuk dengan Google</span>
            </a>

            <div class="register-link">
                Belum punya akun? <a href="/register">Daftar di sini</a>
            </div>
        </form>
    </div>
</section>

<style>
/* background page */
.login-page{
    position: relative;
    min-height: calc(100vh - 90px); /* header height */
    display:flex;
    align-items:center;
    justify-content:center;
    overflow:hidden;
    padding: 40px 18px;
    box-sizing: border-box;
}

/* gedung background */
.login-page__bg{
    position:absolute;
    inset:0;
    background: url('<?php echo e(asset('assets/gedung.jpg')); ?>') center/cover no-repeat;
    transform: scale(1.02);
}

/* soft overlay biar kebaca */
.login-page__overlay{
    position:absolute;
    inset:0;
    background: radial-gradient(circle at center, rgba(255,255,255,.35), rgba(255,255,255,.15));
}

/* card */
.login-card{
    position:relative;
    width: min(720px, 100%);
    background: rgba(255,255,255,.92);
    border-radius: 10px;
    padding: 44px 42px;
    box-shadow: 0 18px 50px rgba(0,0,0,.22);
    backdrop-filter: blur(2px);
}

.login-title{
    text-align:center;
    font-weight:900;
    font-size: 34px;
    letter-spacing: .5px;
    margin-bottom: 6px;
}

/* gradien footer */
.login-title__grad{
    background: linear-gradient(90deg, #F12424 0%, #791B91 50%, #0011FF 100%);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
}

.login-subtitle{
    text-align:center;
    font-size: 13px;
    color: rgba(0,0,0,.65);
    margin-bottom: 26px;
}

.login-form{
    width: min(430px, 100%);
    margin: 0 auto;
}

.field{
    margin-bottom: 16px;
}

.field label{
    display:block;
    font-size: 13px;
    font-weight: 700;
    color: rgba(0,0,0,.65);
    margin-bottom: 8px;
}

.field input{
    width: 100%;
    box-sizing: border-box;
    border: 1px solid rgba(0,0,0,.15);
    border-radius: 10px;
    padding: 12px 14px;
    outline: none;
    background: rgba(226,245,246,.9);
}

.field input:focus{
    border-color: rgba(121,27,145,.45);
    box-shadow: 0 0 0 4px rgba(121,27,145,.12);
}

/* tombol masuk gradien footer */
.btn-submit{
    width: 160px;
    display:block;
    margin: 18px auto 12px;
    padding: 10px 18px;
    border: 0;
    cursor:pointer;
    border-radius: 6px;
    color:#fff;
    font-weight:800;
    background: linear-gradient(90deg, #F12424 0%, #791B91 50%, #0011FF 100%);
    box-shadow: 0 10px 22px rgba(0,0,0,.18);
    transition: transform .15s ease, opacity .15s ease;
}

.btn-submit:hover{ transform: translateY(-2px); opacity: .96; }
.btn-submit:active{ transform: translateY(-1px) scale(.99); }

/* divider */
.divider{
    position: relative;
    text-align:center;
    margin: 16px 0 10px;
    color: rgba(0,0,0,.55);
    font-size: 13px;
}
.divider:before,
.divider:after{
    content:"";
    position:absolute;
    top: 50%;
    width: 40%;
    height: 1px;
    background: rgba(0,0,0,.15);
}
.divider:before{ left:0; }
.divider:after{ right:0; }

/* google button */
.btn-google{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:10px;
    width: 240px;
    margin: 0 auto;
    padding: 10px 14px;
    border: 1px solid rgba(0,0,0,.2);
    border-radius: 6px;
    background: #fff;
    color:#222;
    text-decoration:none;
    font-weight:700;
    transition: transform .15s ease, box-shadow .15s ease;
}
.btn-google:hover{
    transform: translateY(-2px);
    box-shadow: 0 10px 22px rgba(0,0,0,.12);
}
.g-icon{
    width: 22px;
    height: 22px;
    border-radius: 6px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:900;
    background: #fff;
    border: 1px solid rgba(0,0,0,.12);
}

.register-link{
    text-align:center;
    margin-top: 12px;
    font-size: 13px;
    color: rgba(0,0,0,.6);
}
.register-link a{
    color: #5b3df2;
    font-weight:800;
    text-decoration:none;
}

@media (max-width: 520px){
    .login-card{ padding: 34px 18px; }
    .login-title{ font-size: 28px; }
}
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
    <?php echo $__env->make('partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\KP_SIGERAI\resources\views/auth/login-gerai.blade.php ENDPATH**/ ?>