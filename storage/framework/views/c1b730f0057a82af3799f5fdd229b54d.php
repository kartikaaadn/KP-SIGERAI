

<?php $__env->startSection('title', 'Profil Gerai'); ?>

<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<section class="gerai-shell">
    
    <?php echo $__env->make('partials.sidebar-gerai', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="gerai-main">

        
        <?php if(session('success')): ?>
            <div class="toast-center" id="toastCenter">
                <div class="toast-center__box">
                    <?php echo e(session('success')); ?>

                </div>
            </div>
        <?php endif; ?>

        <div class="page-head">
            <div class="page-head__title">Pengaturan Profile</div>
            <div class="page-head__sub">Kelola informasi profil dan keamanan akun gerai Anda</div>
        </div>

        <div class="profile-card">
            
            <div class="profile-top">
                <div class="profile-id">
                    <div class="profile-avatar">
                        <?php $avatar = $user->avatar ?? null; ?>
                        <?php if($avatar): ?>
                            <img src="<?php echo e($avatar); ?>" alt="Avatar">
                        <?php else: ?>
                            <div class="avatar-fallback">
                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="#6b7280" viewBox="0 0 24 24">
                                    <path d="M12 12c2.761 0 5-2.239 5-5s-2.239-5-5-5-5 2.239-5 5 2.239 5 5 5zm0 2c-4.418 0-8 2.239-8 5v1h16v-1c0-2.761-3.582-5-8-5z"/>
                                </svg>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="profile-id__text">
                        <div class="profile-name"><?php echo e($gerai->nama_gerai ?? 'Gerai'); ?></div>
                        <div class="profile-sub">
                            <?php echo e($gerai->lokasi_counter ?: 'Alamat belum diisi'); ?>

                        </div>
                    </div>
                </div>

                <div class="profile-status">
                    <span class="dot"></span>
                    Akun Aktif
                </div>
            </div>

            <div class="divider"></div>

            <form method="POST" action="<?php echo e(route('gerai.profile.update')); ?>">
                <?php echo csrf_field(); ?>

                
                <?php if($errors->any()): ?>
                    <div class="alert-error">
                        <b>Gagal menyimpan:</b>
                        <ul>
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($e); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>

                
                <div class="grid-2">
                    <div class="field">
                        <label class="label">Nama Gerai</label>
                        <input class="input" type="text" name="nama_gerai"
                               value="<?php echo e(old('nama_gerai', $gerai->nama_gerai)); ?>" required>
                        <div class="help">Nama gerai akan tampil pada sistem.</div>
                    </div>

                    <div class="field">
                        <label class="label">Username Gerai</label>
                        <input class="input" type="text" name="username"
                               value="<?php echo e(old('username', $user->username)); ?>" required>
                        <div class="help">Username digunakan untuk login.</div>
                    </div>
                </div>

                <div class="divider soft"></div>

                
                <div class="section-title">
                    <span class="sec-ic">🔒</span>
                    Keamanan Akun
                </div>

                <div class="grid-2">
                    <div class="field">
                        <label class="label">Password Baru</label>
                        <input class="input" type="password" name="password" placeholder="Masukkan password baru">
                        <div class="help">Kosongkan jika tidak ingin mengganti password.</div>
                    </div>

                    <div class="field">
                        <label class="label">Konfirmasi Password</label>
                        <input class="input" type="password" name="password_confirmation" placeholder="Ulangi password baru">
                    </div>
                </div>

                <div class="divider soft"></div>

                
                <div class="section-title">
                    <span class="sec-ic">📩</span>
                    Informasi Kontak
                </div>

                <div class="grid-2">
                    <div class="field">
                        <label class="label">Email Gerai</label>
                        <input class="input" type="email" name="email"
                               value="<?php echo e(old('email', $user->email)); ?>" placeholder="contoh@domain.com">
                    </div>

                    <div class="field">
                        <label class="label">Nomor Telepon</label>
                        <input class="input" type="text" name="no_telp"
                               value="<?php echo e(old('no_telp', $gerai->pic_kontak)); ?>" placeholder="08xxxxxxxxxx">
                    </div>
                </div>

                <div class="field" style="margin-top:10px;">
                    <label class="label">Alamat</label>
                    <input class="input" type="text" name="alamat"
                           value="<?php echo e(old('alamat', $gerai->lokasi_counter)); ?>"
                           placeholder="Masukkan alamat gerai (optional)">
                </div>

                
                <div class="actions">
                    <button type="submit" class="btn-save">
                        <span class="lock">🔒</span>
                        Simpan Perubahan
                    </button>

                    <button type="reset" class="btn-reset">
                        Reset
                    </button>
                </div>
            </form>
        </div>

        
        <div class="mini-cards">
            <div class="mini">
                <div class="mini-ic">📅</div>
                <div class="mini-txt">
                    <div class="mini-top">Terdaftar Sejak</div>
                    <div class="mini-val"><?php echo e(optional($registeredAt)->translatedFormat('d F Y')); ?></div>
                </div>
            </div>

            <div class="mini">
                <div class="mini-ic">🕘</div>
                <div class="mini-txt">
                    <div class="mini-top">Login Terakhir</div>
                    <div class="mini-val">
                        <?php if($lastLoginAt): ?>
                            <?php echo e(\Carbon\Carbon::parse($lastLoginAt)->translatedFormat('d F Y, H:i')); ?>

                        <?php else: ?>
                            <?php echo e(now()->translatedFormat('d F Y, H:i')); ?>

                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="mini">
                <div class="mini-ic">📄</div>
                <div class="mini-txt">
                    <div class="mini-top">Total Laporan</div>
                    <div class="mini-val"><?php echo e($totalLaporan); ?> Laporan</div>
                </div>
            </div>
        </div>

    </div>
</section>

<style>
:root{
    /* header kamu: linear-gradient(90deg, #F44545 0%, #7C1012 100%) */
    --headerGrad: linear-gradient(90deg, #F44545 0%, #7C1012 100%);
    /* footer kamu (yang kamu pakai di banyak tempat) */
    --footerGrad: linear-gradient(90deg, #F12424 0%, #791B91 50%, #0011FF 100%);
}

.gerai-shell{ display:flex; width:100%; align-items:stretch; }
.gerai-main{ flex:1; min-width:0; padding:18px; box-sizing:border-box; padding-bottom:40px; }

/* toast center */
.toast-center{
    position: fixed;
    left: 50%;
    top: 110px;
    transform: translateX(-50%);
    z-index: 9999;
}
.toast-center__box{
    background: rgba(34,197,94,.16);
    border: 1px solid rgba(34,197,94,.35);
    color:#0f5132;
    padding: 10px 16px;
    border-radius: 12px;
    font-weight: 700;
    box-shadow: 0 10px 26px rgba(0,0,0,.12);
    min-width: 260px;
    text-align:center;
}

/* page head */
.page-head{
    background: rgba(255,255,255,.85);
    border-radius: 10px;
    padding: 16px 18px;
    box-shadow: 0 10px 26px rgba(0,0,0,.10);
    margin-bottom: 14px;
}
.page-head__title{
    font-size: 22px;
    font-weight: 900;
    background: var(--footerGrad); /* sesuai request: title pakai warna footer */
    -webkit-background-clip:text;
    background-clip:text;
    color: transparent;
}
.page-head__sub{
    margin-top:4px;
    font-size: 13px;
    color: rgba(0,0,0,.65);
}

/* card */
.profile-card{
    background: rgba(255,255,255,.90);
    border-radius: 14px;
    box-shadow: 0 14px 34px rgba(0,0,0,.12);
    padding: 16px;
}

.profile-top{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap: 12px;
    padding: 10px;
    border-radius: 12px;
    background: rgba(255,255,255,.65);
}

.profile-id{ display:flex; align-items:center; gap: 12px; }
.profile-avatar{
    width:64px; height:64px; border-radius:999px;
    overflow:hidden;
    border: 3px solid transparent;
    background: var(--footerGrad);
    padding: 3px;
    box-sizing:border-box;
}
.profile-avatar img{ width:100%; height:100%; object-fit:cover; border-radius:999px; display:block; background:#fff; }
.avatar-fallback{
    width:100%; height:100%;
    border-radius:999px;
    background:#fff;
    display:flex; align-items:center; justify-content:center;
}

.profile-name{ font-size: 22px; font-weight: 900; color:#c01616; line-height:1.05; }
.profile-sub{ font-size: 13px; color: rgba(0,0,0,.62); margin-top: 2px; }

.profile-status{
    display:flex; align-items:center; gap:10px;
    font-weight:800;
    color:#1f2937;
}
.profile-status .dot{
    width:10px; height:10px; border-radius:999px;
    background:#22c55e;
    box-shadow: 0 0 0 4px rgba(34,197,94,.18);
}

.divider{ height:1px; background: rgba(0,0,0,.08); margin: 14px 0; }
.divider.soft{ background: rgba(0,0,0,.06); }

.alert-error{
    background: rgba(239,68,68,.12);
    border: 1px solid rgba(239,68,68,.25);
    color:#7f1d1d;
    padding: 12px 14px;
    border-radius: 12px;
    margin-bottom: 12px;
}
.alert-error ul{ margin: 8px 0 0 18px; }

/* typography: tidak terlalu besar & bold */
.label{
    display:block;
    font-weight: 700;
    font-size: 13px;
    color:#111;
    margin-bottom: 6px;
}
.help{
    margin-top:6px;
    font-size: 12px;
    color: rgba(0,0,0,.55);
}

.grid-2{
    display:grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
}
.field{ min-width:0; }

.input{
    width:100%;
    border: 1px solid rgba(0,0,0,.18);
    border-radius: 12px;
    padding: 10px 12px;
    outline:none;
    background: rgba(255,255,255,.92);
    box-sizing:border-box;
}
.input:focus{
    border-color: rgba(244,69,69,.65);
    box-shadow: 0 0 0 4px rgba(244,69,69,.12);
}

.section-title{
    display:flex; align-items:center; gap:10px;
    font-weight: 800;
    font-size: 16px;
    color: rgba(0,0,0,.72);
    margin: 6px 0 10px;
}
.sec-ic{ font-size: 16px; }

.actions{
    display:flex;
    gap: 12px;
    align-items:center;
    margin-top: 16px;
}
.btn-save{
    flex:1;
    border:0;
    border-radius: 12px;
    padding: 14px 14px;
    font-weight: 900;
    color:#fff;
    cursor:pointer;
    background: var(--headerGrad); /* sesuai request: tombol simpan pakai warna header */
    box-shadow: 0 12px 24px rgba(0,0,0,.16);
}
.btn-save:hover{ opacity:.97; }
.btn-reset{
    width: 180px;
    border: 1px solid rgba(0,0,0,.2);
    border-radius: 12px;
    padding: 14px 14px;
    font-weight: 800;
    cursor:pointer;
    background: rgba(255,255,255,.95);
}
.btn-reset:hover{ background: rgba(255,255,255,.98); }

.mini-cards{
    display:grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    margin-top: 16px;
}
.mini{
    background: rgba(255,255,255,.90);
    border-radius: 12px;
    padding: 14px;
    box-shadow: 0 10px 24px rgba(0,0,0,.10);
    display:flex;
    align-items:center;
    gap: 12px;
}
.mini-ic{
    width: 44px; height: 44px;
    border-radius: 10px;
    background: rgba(0,0,0,.05);
    display:flex; align-items:center; justify-content:center;
    font-size: 18px;
}
.mini-top{ font-size: 12px; color: rgba(0,0,0,.62); font-weight: 700; }
.mini-val{ margin-top:2px; font-size: 14px; font-weight: 900; color:#111; }

@media (max-width: 980px){
    .grid-2{ grid-template-columns: 1fr; }
    .mini-cards{ grid-template-columns: 1fr; }
    .btn-reset{ width: 140px; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const toast = document.getElementById('toastCenter');
    if(toast){
        setTimeout(() => {
            toast.style.transition = 'opacity .35s ease, transform .35s ease';
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(-50%) translateY(-8px)';
            setTimeout(() => toast.remove(), 400);
        }, 5000); // 5 detik
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
    <?php echo $__env->make('partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\KP_SIGERAI\resources\views/gerai/profile/index.blade.php ENDPATH**/ ?>