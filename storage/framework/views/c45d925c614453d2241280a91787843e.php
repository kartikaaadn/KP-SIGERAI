

<?php $__env->startSection('title', 'Profil Admin'); ?>

<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<section class="adminprof-shell">
    <?php echo $__env->make('partials.sidebar-admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="adminprof-main">

        
        <?php if(session('success')): ?>
            <div class="toast toast-success" id="toastMsg"><?php echo e(session('success')); ?></div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="toast toast-error" id="toastMsg"><?php echo e(session('error')); ?></div>
        <?php endif; ?>

        
        <div class="page-head">
            <div class="page-head__title">
                <span class="t-grad">Profil Admin</span>
            </div>
            <div class="page-head__sub">Kelola informasi profil dan pengaturan akun</div>
        </div>

        <div class="grid">
            
            <div class="card profile-card">
                <div class="profile-top grad-bg"></div>

                <div class="avatar-wrap">
                    <?php $avatar = $user->avatar ?? null; ?>

                    <?php if($avatar): ?>
                        <img class="avatar" src="<?php echo e($avatar); ?>" alt="Avatar">
                    <?php else: ?>
                        <div class="avatar avatar--fallback">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="none" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M12 12c2.761 0 5-2.239 5-5S14.761 2 12 2 7 4.239 7 7s2.239 5 5 5Zm0 2c-4.418 0-8 2.239-8 5v1h16v-1c0-2.761-3.582-5-8-5Z"/>
                            </svg>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="profile-body">
                    <div class="profile-name"><?php echo e($user->name ?? 'Admin MPP'); ?></div>
                    <div class="profile-role">Administrator MPP</div>

                    <div class="profile-info">
                        <div class="info-row">
                            <div class="k">Email</div>
                            <div class="v"><?php echo e($user->email ?? '-'); ?></div>
                        </div>
                        <div class="info-row">
                            <div class="k">Kontak</div>
                            <div class="v"><?php echo e($user->phone ?? '-'); ?></div>
                        </div>
                        <div class="info-row">
                            <div class="k">Instansi</div>
                            <div class="v">Mall Pelayanan Publik</div>
                        </div>
                    </div>

                    <button class="btn-grad" id="btnEdit">Edit Profil</button>

                    
                    <form class="edit-form" id="editForm" method="POST" action="<?php echo e(route('admin.profile.update')); ?>" style="display:none;">
                        <?php echo csrf_field(); ?>

                        <div class="f-group">
                            <label class="f-label">Nama</label>
                            <input class="f-input" type="text" name="name" value="<?php echo e(old('name', $user->name)); ?>" required>
                        </div>

                        <div class="f-group">
                            <label class="f-label">Username</label>
                            <input class="f-input" type="text" name="username" value="<?php echo e(old('username', $user->username)); ?>" required>
                        </div>

                        <div class="f-group">
                            <label class="f-label">Email</label>
                            <input class="f-input" type="email" name="email" value="<?php echo e(old('email', $user->email)); ?>" placeholder="optional">
                        </div>

                        <div class="f-group">
                            <label class="f-label">Kontak / No HP</label>
                            <input class="f-input" type="text" name="phone" value="<?php echo e(old('phone', $user->phone)); ?>" placeholder="optional">
                        </div>

                        <div class="row-btns">
                            <button class="btn-grad" type="submit">Simpan Perubahan</button>
                            <button class="btn-ghost" type="button" id="btnCancel">Batal</button>
                        </div>
                    </form>

                    
                    <form id="avatarForm" method="POST" action="<?php echo e(route('admin.profile.avatar')); ?>"
                          enctype="multipart/form-data" style="display:none; margin-top:10px;">
                        <?php echo csrf_field(); ?>
                        <label class="f-label">Ganti Foto Profil</label>
                        <input class="f-input" type="file" name="avatar" accept="image/*" required>
                        <button class="btn-ghost" style="margin-top:8px;" type="submit">Upload Foto</button>
                        <div class="hint">PNG/JPG/WebP max 2MB.</div>
                    </form>
                </div>
            </div>

            
            <div class="right-col">

                
                <div class="card">
                    <div class="card-head">
                        <span class="t-grad">Statistik Aktivitas</span>
                    </div>

                    <div class="stats">
                        <div class="stat stat-green">
                            <div class="stat-title">Total Gerai Aktif</div>
                            <div class="stat-row">
                                <div class="stat-value"><?php echo e($totalGeraiAktif ?? 0); ?></div>
                                <div class="stat-icon icon-green">
                                    
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24">
                                        <path fill="currentColor" d="M7 2a1 1 0 0 1 1 1v1h8V3a1 1 0 1 1 2 0v1h1.5A2.5 2.5 0 0 1 22 6.5v13A2.5 2.5 0 0 1 19.5 22h-15A2.5 2.5 0 0 1 2 19.5v-13A2.5 2.5 0 0 1 4.5 4H6V3a1 1 0 0 1 1-1Zm12.5 8H4.5v9.5c0 .276.224.5.5.5h14.5c.276 0 .5-.224.5-.5V10Z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="stat stat-red">
                            <div class="stat-title">Total Gerai Tidak Aktif</div>
                            <div class="stat-row">
                                <div class="stat-value"><?php echo e($totalGeraiTidakAktif ?? 0); ?></div>
                                <div class="stat-icon icon-red">
                                    
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24">
                                        <path fill="currentColor" d="M3 21h10a1 1 0 1 0 0-2H5V5h10v6a1 1 0 1 0 2 0V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14Zm18.707-2.293-1.32-1.32A4.5 4.5 0 0 0 16.5 13a4.5 4.5 0 0 0-3.183 7.683l-1.024 1.024A6.5 6.5 0 0 1 16.5 11a6.5 6.5 0 0 1 5.207 10.707ZM16.5 15a2.5 2.5 0 0 1 1.47 4.522l-3.492-3.492A2.49 2.49 0 0 1 16.5 15Zm-1.47 1.478 3.492 3.492A2.5 2.5 0 0 1 15.03 16.478ZM8 8h2v2H8V8Zm0 4h2v2H8v-2Zm4-4h2v2h-2V8Zm0 4h2v2h-2v-2Z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="stat stat-blue">
                            <div class="stat-title">Total Seluruh Layanan</div>
                            <div class="stat-row">
                                <div class="stat-value"><?php echo e($totalSeluruhLayanan ?? 0); ?></div>
                                <div class="stat-icon icon-blue">
                                    
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24">
                                        <path fill="currentColor" d="M9 2a1 1 0 0 0-1 1v1H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1V3a1 1 0 0 0-1-1H9Zm1 2h4v1h-4V4Zm-3 4h10v2H7V8Zm0 4h10v2H7v-2Zm0 4h7v2H7v-2Z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="card">
                    <div class="card-head">
                        <span class="t-grad">Aktivitas Terbaru</span>
                    </div>

                    <?php if(($aktivitasTerbaru ?? collect())->count() == 0): ?>
                        <div class="empty-activity">Belum ada aktivitas.</div>
                    <?php else: ?>
                        <div class="activity-list">
                            <?php $__currentLoopData = $aktivitasTerbaru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="activity-item">
                                    <div class="a-title">
                                        <?php echo e($a->gerai->nama_gerai ?? 'Gerai'); ?>

                                    </div>
                                    <div class="a-sub">
                                        Input Layanan Harian • <?php echo e($a->created_at?->format('d M Y, H:i')); ?>

                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endif; ?>
                </div>

                
                <div class="card">
                    <div class="card-head">
                        <span class="t-grad">Pengaturan Keamanan</span>
                    </div>

                    <div class="security-row" id="btnTogglePass">
                        <div>
                            <div class="sec-title">Ubah Password</div>
                            <div class="sec-sub">Klik untuk mengganti password akun</div>
                        </div>
                        <div class="sec-right">›</div>
                    </div>

                    <div class="pass-wrap" id="passWrap" style="display:none;">
                        <form method="POST" action="<?php echo e(route('admin.profile.password')); ?>">
                            <?php echo csrf_field(); ?>

                            <div class="pw-grid">
                                <div class="f-group">
                                    <label class="f-label">Password Lama Anda</label>
                                    <input class="f-input" type="password" name="current_password" required>
                                </div>

                                <div class="f-group">
                                    <label class="f-label">Password Baru</label>
                                    <input class="f-input" type="password" name="password" required>
                                </div>

                                <div class="f-group">
                                    <label class="f-label">Konfirmasi Password Baru</label>
                                    <input class="f-input" type="password" name="password_confirmation" required>
                                </div>
                            </div>

                            <div class="pw-actions">
                                <button class="btn-ghost" type="button" id="btnClosePass">Tutup</button>
                                <button class="btn-grad" type="submit">Simpan</button>
                            </div>
                        </form>
                    </div>

                    <div class="security-row muted">
                        <div>
                            <div class="sec-title">Riwayat Login</div>
                            <div class="sec-sub">Coming soon</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<style>
:root{
    --footerGrad: linear-gradient(90deg, #F12424 0%, #791B91 50%, #0011FF 100%);
    --shadow: 0 14px 34px rgba(0,0,0,.12);
}
.adminprof-shell{ display:flex; width:100%; }
.adminprof-main{ flex:1; min-width:0; padding:18px; box-sizing:border-box; padding-bottom:40px; }

.grad-bg{ background: var(--footerGrad); }

/* ✅ Gradient text AMAN (hanya span ini yang gradient) */
.t-grad{
    background: var(--footerGrad);
    -webkit-background-clip:text;
    background-clip:text;
    color: transparent;
    font-weight: 900;
}

.page-head{
    background: rgba(255,255,255,.85);
    border-radius: 10px;
    padding: 16px 18px;
    box-shadow: 0 10px 26px rgba(0,0,0,.10);
    margin-bottom: 14px;
}
.page-head__title{ font-size: 28px; }
.page-head__sub{ margin-top: 4px; font-size: 13px; color: rgba(0,0,0,.65); }

/* toast */
.toast{
    position: fixed;
    left: 50%;
    top: 110px;
    transform: translateX(-50%);
    padding: 12px 18px;
    border-radius: 10px;
    font-weight: 800;
    box-shadow: var(--shadow);
    z-index: 9999;
    background: rgba(255,255,255,.92);
    border: 1px solid rgba(0,0,0,.12);
}
.toast-success{ border-color: rgba(20,160,90,.35); }
.toast-error{ border-color: rgba(220,50,60,.35); }

.grid{ display:grid; grid-template-columns: 320px 1fr; gap: 18px; align-items:start; }
.card{
    background: rgba(255,255,255,.90);
    border-radius: 12px;
    overflow:hidden;
    box-shadow: var(--shadow);
    border: 1px solid rgba(0,0,0,.08);
}
.card-head{
    padding: 16px 18px;
    font-size: 22px;
    border-bottom: 1px solid rgba(0,0,0,.08);
    background: rgba(255,255,255,.85);
}

.profile-top{ height: 82px; }
.avatar-wrap{ display:flex; justify-content:center; margin-top: -40px; }
.avatar{
    width: 88px; height: 88px; border-radius: 999px;
    object-fit: cover; border: 4px solid #fff;
    box-shadow: 0 10px 22px rgba(0,0,0,.16);
    background:#fff;
}
.avatar--fallback{
    display:flex; align-items:center; justify-content:center;
    color:#6b21a8;
}
.profile-body{ padding: 14px 16px 16px; text-align:center; }
.profile-name{ font-weight: 900; font-size: 18px; margin-top: 4px; }
.profile-role{ font-size: 12px; color: rgba(0,0,0,.65); margin-top: 2px; }

.profile-info{ margin-top: 12px; text-align:left; display:grid; gap: 6px; }
.info-row{ display:flex; justify-content:space-between; gap:10px; font-size: 13px; }
.info-row .k{ color: rgba(0,0,0,.55); }
.info-row .v{ font-weight: 800; color: rgba(0,0,0,.8); }

.btn-grad{
    width:100%; border:0; cursor:pointer; color:#fff; font-weight: 900;
    padding: 12px 14px; border-radius: 10px; margin-top: 14px;
    background: var(--footerGrad);
}
.btn-ghost{
    width:100%;
    border: 1px solid rgba(0,0,0,.16);
    cursor:pointer;
    background: rgba(255,255,255,.95);
    font-weight: 900;
    padding: 10px 14px;
    border-radius: 10px;
}

.edit-form{ margin-top: 12px; text-align:left; }
.f-group{ margin-top: 10px; }
.f-label{ display:block; font-size: 12px; font-weight: 900; color: rgba(0,0,0,.72); margin-bottom: 6px; }
.f-input{
    width:100%;
    border: 1px solid rgba(0,0,0,.15);
    border-radius: 10px;
    padding: 10px 12px;
    outline:none;
    background: rgba(255,255,255,.92);
}
.hint{ font-size: 11px; color: rgba(0,0,0,.55); margin-top: 6px; }

.row-btns{ display:grid; grid-template-columns: 1fr 1fr; gap:10px; margin-top: 12px; }

.right-col{ display:grid; gap: 16px; }

.stats{ display:grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px; padding: 14px 16px 18px; }
.stat{ border-radius: 12px; padding: 14px; border: 1px solid rgba(0,0,0,.08); }
.stat-title{ font-weight: 900; font-size: 14px; color: rgba(0,0,0,.75); }
.stat-row{ margin-top: 8px; display:flex; align-items:center; justify-content:space-between; gap:10px; }
.stat-value{ font-weight: 950; font-size: 34px; }

.stat-icon{
    width: 40px; height: 40px; border-radius: 10px;
    display:flex; align-items:center; justify-content:center;
    border: 1px solid rgba(0,0,0,.08);
    background: rgba(255,255,255,.55);
}
.stat-green{ background: rgba(220, 252, 231, .9); }
.stat-red{ background: rgba(254, 226, 226, .9); }
.stat-blue{ background: rgba(219, 234, 254, .9); }
.icon-green{ color:#15803d; }
.icon-red{ color:#dc2626; }
.icon-blue{ color:#2563eb; }

.empty-activity{ padding: 18px; color: rgba(0,0,0,.55); font-weight: 800; }
.activity-list{ padding: 10px 0; }
.activity-item{ padding: 10px 16px; border-top: 1px solid rgba(0,0,0,.08); background: rgba(255,255,255,.75); }
.activity-item:nth-child(even){ background: rgba(245,245,245,.75); }
.a-title{ font-weight: 900; font-size: 13px; }
.a-sub{ font-size: 12px; color: rgba(0,0,0,.6); margin-top: 2px; }

.security-row{
    padding: 14px 16px;
    display:flex; align-items:center; justify-content:space-between;
    border-top: 1px solid rgba(0,0,0,.08);
    cursor:pointer;
    background: rgba(255,255,255,.82);
}
.security-row:hover{ background: rgba(245,245,245,.85); }
.security-row.muted{ cursor:default; opacity:.75; }
.security-row.muted:hover{ background: rgba(255,255,255,.82); }

.sec-title{ font-weight: 900; }
.sec-sub{ font-size: 12px; color: rgba(0,0,0,.6); margin-top: 2px; }
.sec-right{ font-weight: 900; font-size: 18px; color: rgba(0,0,0,.55); }

.pass-wrap{ padding: 14px 16px 16px; border-top: 1px solid rgba(0,0,0,.08); background: rgba(255,255,255,.75); }
.pw-grid{ display:grid; gap: 10px; }
.pw-actions{ margin-top: 12px; display:grid; grid-template-columns: 1fr 1fr; gap: 10px; }

@media (max-width: 1100px){
    .grid{ grid-template-columns: 1fr; }
    .stats{ grid-template-columns: 1fr; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function(){
    const toast = document.getElementById('toastMsg');
    if(toast){
        setTimeout(()=>{ toast.style.opacity='0'; toast.style.transition='opacity .3s ease'; }, 3500);
        setTimeout(()=>{ toast.remove(); }, 3900);
    }

    const btnEdit = document.getElementById('btnEdit');
    const btnCancel = document.getElementById('btnCancel');
    const editForm = document.getElementById('editForm');
    const avatarForm = document.getElementById('avatarForm');

    if(btnEdit){
        btnEdit.addEventListener('click', ()=>{
            editForm.style.display = 'block';
            avatarForm.style.display = 'block';
            btnEdit.style.display = 'none';
        });
    }
    if(btnCancel){
        btnCancel.addEventListener('click', ()=>{
            editForm.style.display = 'none';
            avatarForm.style.display = 'none';
            btnEdit.style.display = 'block';
        });
    }

    const btnTogglePass = document.getElementById('btnTogglePass');
    const passWrap = document.getElementById('passWrap');
    const btnClosePass = document.getElementById('btnClosePass');

    if(btnTogglePass){
        btnTogglePass.addEventListener('click', ()=>{
            passWrap.style.display = (passWrap.style.display === 'none' || passWrap.style.display === '') ? 'block' : 'none';
        });
    }
    if(btnClosePass){
        btnClosePass.addEventListener('click', ()=>{ passWrap.style.display='none'; });
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
    <?php echo $__env->make('partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\KP_SIGERAI\resources\views/admin/profile/index.blade.php ENDPATH**/ ?>