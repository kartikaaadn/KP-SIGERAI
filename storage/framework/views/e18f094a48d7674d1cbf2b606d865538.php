

<?php $__env->startSection('content'); ?>
<?php echo $__env->make('partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div class="page">
    <div class="sidebar">
        <?php echo $__env->make('partials.sidebar-gerai', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>

    <div class="main">
        
        <?php if(session('success')): ?>
            <div class="toast" id="toastSuccess"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <div class="headcard">
            <div class="h-title">Laporan Layanan Gerai</div>
            <div class="h-sub">Kelola seluruh layanan gerai Anda</div>
        </div>

        <div class="toolbar">
            <form method="GET" action="<?php echo e(route('gerai.laporan.index')); ?>" class="periode-form">
                <label>Periode</label>

                <select name="monday" class="inp" onchange="this.form.submit()">
                    <?php $__currentLoopData = $weeks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $w): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($w['monday']); ?>"
                            <?php echo e($w['monday'] === $selectedMonday->toDateString() ? 'selected' : ''); ?>>
                            <?php echo e($w['label']); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>

                <div class="periode-label"><?php echo e($labelPeriode); ?></div>
            </form>

            <div class="toolbar-actions">
                <a class="btn btn-ghost" href="<?php echo e(route('gerai.laporan.export', ['monday' => $start->toDateString()])); ?>">⬇ Ekspor</a>
                <a class="btn btn-blue" href="<?php echo e(route('gerai.laporan.create', ['monday' => $start->toDateString()])); ?>">＋ Input Data Baru</a>
            </div>
        </div>

        <div class="card">
            <div class="card-title">Data Layanan Per-Periode</div>

            <div class="table-wrap">
                <table class="tbl">
                    <thead>
                    <tr>
                        <th style="width:60px;">No</th>
                        <th style="width:120px;">Hari</th>
                        <th style="width:150px;">Tanggal</th>
                        <th>Jenis Layanan</th>
                        <th style="width:180px;">Jumlah Pengguna Layanan</th>
                        <th style="width:180px;">Keterangan</th>
                        <th style="width:120px;">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $no=1; ?>

                    <?php $__currentLoopData = $days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $data = $d['data'];
                            $items = $data?->items ?? collect();
                        ?>

                        <?php if(!$data): ?>
                            <tr>
                                <td><?php echo e($no++); ?></td>
                                <td style="text-transform:capitalize"><?php echo e($d['hari']); ?></td>
                                <td><?php echo e($d['date']->format('d M Y')); ?></td>
                                <td colspan="4" style="color:#777;">Belum ada data.</td>
                            </tr>
                        <?php else: ?>
                            <?php if($items->count() === 0): ?>
                                <tr>
                                    <td><?php echo e($no++); ?></td>
                                    <td style="text-transform:capitalize"><?php echo e($d['hari']); ?></td>
                                    <td><?php echo e($d['date']->format('d M Y')); ?></td>
                                    <td>-</td>
                                    <td>0</td>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>
                            <?php else: ?>
                                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $it): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <?php if($idx === 0): ?>
                                            <td rowspan="<?php echo e($items->count()+1); ?>"><?php echo e($no++); ?></td>
                                            <td rowspan="<?php echo e($items->count()+1); ?>" style="text-transform:capitalize"><?php echo e($d['hari']); ?></td>
                                            <td rowspan="<?php echo e($items->count()+1); ?>"><?php echo e($d['date']->format('d M Y')); ?></td>
                                        <?php endif; ?>

                                        <td><?php echo e($it->jenis_layanan); ?></td>
                                        <td style="text-align:center;"><?php echo e($it->jumlah); ?></td>
                                        <td><?php echo e($it->keterangan ?? '-'); ?></td>
                                        <td style="text-align:center;">
                                            <form method="POST" action="<?php echo e(route('gerai.laporan.item.destroy', $it->id)); ?>" onsubmit="return confirm('Hapus item ini?')">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button class="btn-del" type="submit">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <tr class="sumrow">
                                    <td colspan="2" style="text-align:center; font-weight:800;">
                                        Total jumlah pengguna layanan perhari
                                    </td>
                                    <td style="text-align:center; font-weight:900;">
                                        <?php echo e($data->total_layanan); ?>

                                    </td>
                                    <td colspan="2"></td>
                                </tr>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            <div class="totalbar">
                Total Jumlah Pengguna Layanan Mingguan:
                <span class="big"><?php echo e($totalMingguan); ?></span>
            </div>
        </div>

        <div class="card note">
            <div class="card-title">Keterangan</div>
            <ol>
                <li>Total jumlah pengguna layanan yaitu <b><?php echo e($totalMingguan); ?></b> pengguna</li>
                <li>Ekspor akan menghasilkan file CSV (bisa dibuka di Excel)</li>
                <li>Periode hanya Senin – Jumat</li>
            </ol>
        </div>
    </div>
</div>

<?php echo $__env->make('partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<style>
:root{
    --headerGrad: linear-gradient(90deg, #F44545 0%, #7C1012 100%);
    --footerGrad: linear-gradient(90deg, #F12424 0%, #791B91 50%, #0011FF 100%);
}

.page{ display:flex; gap:16px; padding:16px; background:rgba(255,255,255,.0); }
.sidebar{ width:260px; flex:0 0 260px; }
.main{ flex:1; min-width:0; }

.headcard{
    background: rgba(255,255,255,.92);
    border-radius: 10px;
    padding: 16px 18px;
    margin-bottom: 14px;
    box-shadow: 0 12px 24px rgba(0,0,0,.08);
}
.h-title{ font-size:18px; font-weight:900; background:var(--footerGrad); -webkit-background-clip:text; color:transparent; }
.h-sub{ font-size:12px; opacity:.8; }

.toolbar{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:12px;
    margin-bottom: 14px;
}
.periode-form{ display:flex; align-items:center; gap:10px; }
.periode-form label{ font-weight:800; }
.inp{
    height:38px;
    border-radius: 8px;
    border:1px solid rgba(0,0,0,.15);
    padding: 0 10px;
    background: #fff;
    min-width: 230px;
}
.periode-label{ font-size:12px; opacity:.75; }

.toolbar-actions{ display:flex; gap:10px; }
.btn{
    height:38px;
    padding: 0 14px;
    border-radius: 8px;
    border:1px solid rgba(0,0,0,.15);
    display:inline-flex;
    align-items:center;
    gap:8px;
    text-decoration:none;
    font-weight:800;
}
.btn-ghost{ background:#fff; color:#111; }
.btn-blue{ background:#3b82f6; color:#fff; border-color:#3b82f6; }

.card{
    background: rgba(255,255,255,.92);
    border-radius: 12px;
    padding: 14px;
    box-shadow: 0 12px 24px rgba(0,0,0,.08);
    margin-bottom: 14px;
}
.card-title{ font-weight:900; margin-bottom:10px; }

.table-wrap{ overflow:auto; }
.tbl{ width:100%; border-collapse:collapse; background:#fff; border-radius:10px; overflow:hidden; }
.tbl th{
    background:#cfe6ff;
    padding: 10px;
    font-size:12px;
    text-align:center;
}
.tbl td{
    border-top:1px solid rgba(0,0,0,.06);
    padding: 9px 10px;
    font-size:12px;
    vertical-align:top;
}
.sumrow td{
    background:#cfe6ff;
    font-weight:800;
}

.btn-del{
    background:#ef4444;
    color:#fff;
    border:0;
    border-radius: 6px;
    padding: 6px 10px;
    font-weight:800;
    cursor:pointer;
}

.totalbar{
    margin-top: 12px;
    background:#4da3ff;
    color:#fff;
    border-radius: 10px;
    padding: 12px 14px;
    font-weight:900;
    display:flex;
    justify-content:center;
    gap:8px;
}
.totalbar .big{ font-size:18px; }

.note ol{ margin:0; padding-left:18px; }
.note li{ margin:6px 0; }

.toast{
    position:fixed;
    top: 110px;
    left: 50%;
    transform: translateX(-50%);
    background: rgba(16,185,129,.95);
    color:#fff;
    padding: 12px 16px;
    border-radius: 10px;
    font-weight:900;
    z-index:9999;
    box-shadow: 0 18px 28px rgba(0,0,0,.2);
}
</style>

<script>
(() => {
    const t = document.getElementById('toastSuccess');
    if(!t) return;
    setTimeout(() => t.remove(), 3500);
})();
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\KP_SIGERAI\resources\views/gerai/laporan/create.blade.php ENDPATH**/ ?>