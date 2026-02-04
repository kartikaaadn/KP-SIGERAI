
<?php echo $__env->make('partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div class="page">
    <?php echo $__env->make('partials.sidebar-gerai', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <main class="content">
        <?php if($errors->any()): ?>
            <div class="errbox">
                <b>Terjadi kesalahan:</b>
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($e); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="title-card">
            <h1 class="grad-title">Input Data Layanan Gerai</h1>
            <p>Masukkan data layanan harian per periode</p>
        </div>

        <div class="filter-card">
            <div class="filter-title">Filter Periode</div>

            <form class="filter-row" method="GET" action="<?php echo e(route('gerai.laporan.create')); ?>">
                <div class="f">
                    <div class="f-lbl">Tanggal Mulai (Senin)</div>
                    <input class="f-in" type="date" name="start" value="<?php echo e($monday->toDateString()); ?>">
                </div>

                <button class="btn red" type="submit">🔻 Filter Data</button>

                <div class="range"><?php echo e($rangeText); ?></div>
            </form>
        </div>

        <form id="mainForm" method="POST" action="<?php echo e(route('gerai.laporan.store')); ?>">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="start" value="<?php echo e($monday->toDateString()); ?>">

            <div class="card">
                <div class="card-title">Tabel Input Data Layanan</div>

                <div class="table-wrap">
                    <table class="tbl">
                        <thead>
                            <tr>
                                <th style="width:60px;">No</th>
                                <th style="width:120px;">Hari</th>
                                <th style="width:160px;">Tanggal</th>
                                <th>Jenis Layanan</th>
                                <th style="width:180px;">Jumlah</th>
                                <th style="width:260px;">Keterangan</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $no = 1; ?>

                            <?php $__currentLoopData = $dates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $key = $d->toDateString();
                                    $row = $harian->get($key);
                                    $details = $row ? $row->details : collect();
                                    if($details->count() === 0){
                                        // default 1 row kosong
                                        $details = collect([
                                            (object)['jenis_layanan'=>'', 'jumlah_pengguna'=>0, 'keterangan'=>'']
                                        ]);
                                    }
                                ?>

                                
                                <tr class="day-head">
                                    <td colspan="6">
                                        <b><?php echo e($no); ?>.</b>
                                        <?php echo e($d->translatedFormat('l')); ?> — <?php echo e($d->translatedFormat('d M Y')); ?>

                                        <span class="right">
                                            <button type="button" class="addRowBtn" data-date="<?php echo e($key); ?>">＋ Tambah Jenis Layanan</button>
                                        </span>
                                    </td>
                                </tr>

                                
                                <tr>
                                    <td colspan="6" style="padding:0;">
                                        <table class="subtbl" id="tbl-<?php echo e($key); ?>">
                                            <tbody>
                                                <?php $__currentLoopData = $details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $det): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr class="subrow">
                                                        <td style="width:60px; text-align:center; font-weight:900;"><?php echo e($no); ?></td>
                                                        <td style="width:120px;"></td>
                                                        <td style="width:160px;"></td>

                                                        <td>
                                                            <input class="in"
                                                                   name="items[<?php echo e($key); ?>][<?php echo e($i); ?>][jenis]"
                                                                   value="<?php echo e($det->jenis_layanan ?? ''); ?>"
                                                                   placeholder="Isi layanan disini">
                                                        </td>

                                                        <td class="qty">
                                                            <button type="button" class="qbtn minus">-</button>
                                                            <input class="in num"
                                                                   name="items[<?php echo e($key); ?>][<?php echo e($i); ?>][jumlah]"
                                                                   value="<?php echo e((int)($det->jumlah_pengguna ?? 0)); ?>"
                                                                   inputmode="numeric">
                                                            <button type="button" class="qbtn plus">+</button>
                                                        </td>

                                                        <td>
                                                            <input class="in"
                                                                   name="items[<?php echo e($key); ?>][<?php echo e($i); ?>][ket]"
                                                                   value="<?php echo e($det->keterangan ?? ''); ?>"
                                                                   placeholder="Keterangan...">
                                                        </td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>

                                <?php $no++; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <div class="save-row">
                    <button class="btn big" type="submit">🔒 Simpan Data Layanan</button>
                </div>
            </div>
        </form>
    </main>
</div>


<div id="leaveModal" class="modal">
    <div class="modal-box">
        <div class="modal-title">Apakah Anda yakin ingin keluar?</div>
        <div class="modal-sub">Data yang belum disimpan akan hilang.<br>Silakan klik Simpan terlebih dahulu agar data tersimpan dengan benar.</div>
        <div class="modal-actions">
            <button id="btnYes" class="mbtn yes">YA</button>
            <button id="btnNo" class="mbtn no">TIDAK</button>
        </div>
    </div>
</div>

<?php echo $__env->make('partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<style>
:root{
    --footerGrad: linear-gradient(90deg, #F12424 0%, #791B91 50%, #0011FF 100%);
}
.page{ display:flex; min-height: calc(100vh - 90px); }
.content{ flex:1; padding: 22px; background: url('<?php echo e(asset('assets/bg-mpp.png')); ?>') center/cover fixed no-repeat; }

.title-card{
    background: rgba(255,255,255,.88);
    border-radius: 12px;
    padding: 18px 18px;
    box-shadow: 0 10px 25px rgba(0,0,0,.10);
    margin-bottom: 16px;
}
.grad-title{
    margin:0;
    font-size: 26px;
    font-weight: 900;
    background: var(--footerGrad);
    -webkit-background-clip:text;
    background-clip:text;
    color: transparent;
}
.title-card p{ margin: 2px 0 0; opacity:.75; }

.filter-card{
    background: rgba(255,255,255,.88);
    border-radius: 12px;
    padding: 14px;
    box-shadow: 0 10px 25px rgba(0,0,0,.10);
    margin-bottom: 14px;
}
.filter-title{ font-weight:900; margin-bottom: 10px; }
.filter-row{ display:flex; gap:12px; align-items:flex-end; flex-wrap:wrap; }
.f{ display:flex; flex-direction:column; gap:6px; }
.f-lbl{ font-weight:800; font-size:12px; opacity:.8; }
.f-in{ height:38px; border-radius:10px; border:1px solid rgba(0,0,0,.15); padding:0 10px; }
.range{ font-weight:900; opacity:.7; padding-bottom:6px; }

.btn{ border:0; border-radius:10px; padding:10px 14px; font-weight:900; cursor:pointer; }
.btn.red{ background:#d33; color:#fff; }
.btn.big{ background: var(--footerGrad); color:#fff; padding: 14px 18px; min-width: 360px; }

.card{
    background: rgba(255,255,255,.88);
    border-radius: 14px;
    padding: 14px;
    box-shadow: 0 12px 28px rgba(0,0,0,.12);
}
.card-title{ font-weight:900; margin-bottom: 10px; }

.table-wrap{ overflow:auto; border-radius: 12px; }
.tbl{ width:100%; border-collapse:separate; border-spacing:0; min-width: 980px; }
.tbl thead th{
    background: rgba(132, 176, 255, .20);
    padding: 12px;
    text-align:center;
    font-weight:900;
    border-top: 1px solid rgba(0,0,0,.08);
    border-bottom: 1px solid rgba(0,0,0,.08);
}
.day-head td{
    background: rgba(255, 230, 230, .45);
    padding: 10px 12px;
    font-weight:900;
}
.day-head .right{ float:right; }
.addRowBtn{
    border:0;
    background: transparent;
    color:#b00;
    font-weight:900;
    cursor:pointer;
}
.subtbl{ width:100%; border-collapse:collapse; }
.subrow td{ padding: 10px 12px; border-bottom: 1px solid rgba(0,0,0,.06); }

.in{
    width:100%;
    height: 36px;
    border-radius: 8px;
    border: 1px solid rgba(0,0,0,.15);
    padding: 0 10px;
    box-sizing:border-box;
}
.in.num{ text-align:center; font-weight:900; }
.qty{
    display:flex;
    align-items:center;
    gap:8px;
}
.qbtn{
    width:32px; height:32px;
    border-radius:8px;
    border:0;
    background: rgba(0,0,0,.08);
    cursor:pointer;
    font-weight:900;
}
.save-row{ display:flex; justify-content:center; padding: 18px 0 6px; }

.errbox{
    background: rgba(255,0,0,.08);
    border:1px solid rgba(255,0,0,.25);
    padding: 10px 12px;
    border-radius: 12px;
    margin-bottom: 12px;
}
.errbox ul{ margin: 6px 0 0; }

.modal{
    position: fixed;
    inset:0;
    background: rgba(0,0,0,.35);
    display:none;
    align-items:center;
    justify-content:center;
    z-index: 9999;
}
.modal.show{ display:flex; }
.modal-box{
    width: 520px;
    max-width: calc(100vw - 30px);
    background: #fff;
    border-radius: 12px;
    padding: 18px;
    box-shadow: 0 12px 28px rgba(0,0,0,.25);
    text-align:center;
}
.modal-title{ font-weight:900; font-size:16px; margin-bottom: 6px; }
.modal-sub{ opacity:.8; margin-bottom: 14px; }
.modal-actions{ display:flex; justify-content:center; gap:12px; }
.mbtn{
    border:0; border-radius:10px; padding: 10px 18px; font-weight:900; cursor:pointer;
}
.mbtn.yes{ background:#2d7dff; color:#fff; }
.mbtn.no{ background:#ff4d4d; color:#fff; }
</style>

<script>
(function(){
    let dirty = false;
    const form = document.getElementById('mainForm');
    const modal = document.getElementById('leaveModal');
    let pendingUrl = null;

    // mark dirty kalau input berubah
    form.addEventListener('input', () => dirty = true);

    // kalau submit -> tidak dianggap "keluar"
    form.addEventListener('submit', () => dirty = false);

    // plus/minus qty
    document.addEventListener('click', function(e){
        if(e.target.classList.contains('plus') || e.target.classList.contains('minus')){
            dirty = true;
            const row = e.target.closest('tr');
            const input = row.querySelector('input.in.num');
            let val = parseInt(input.value || '0', 10);
            if(e.target.classList.contains('plus')) val++;
            else val = Math.max(0, val-1);
            input.value = val;
        }
    });

    // tambah baris layanan
    document.querySelectorAll('.addRowBtn').forEach(btn => {
        btn.addEventListener('click', () => {
            dirty = true;
            const date = btn.getAttribute('data-date');
            const tbl = document.getElementById('tbl-' + date).querySelector('tbody');
            const idx = tbl.querySelectorAll('tr').length;

            const tr = document.createElement('tr');
            tr.className = 'subrow';
            tr.innerHTML = `
                <td style="width:60px; text-align:center; font-weight:900;"></td>
                <td style="width:120px;"></td>
                <td style="width:160px;"></td>
                <td><input class="in" name="items[${date}][${idx}][jenis]" placeholder="Isi layanan disini"></td>
                <td class="qty">
                    <button type="button" class="qbtn minus">-</button>
                    <input class="in num" name="items[${date}][${idx}][jumlah]" value="0" inputmode="numeric">
                    <button type="button" class="qbtn plus">+</button>
                </td>
                <td><input class="in" name="items[${date}][${idx}][ket]" placeholder="Keterangan..."></td>
            `;
            tbl.appendChild(tr);
        });
    });

    function showLeaveModal(url){
        pendingUrl = url;
        modal.classList.add('show');
    }
    function hideLeaveModal(){
        pendingUrl = null;
        modal.classList.remove('show');
    }

    // intercept klik link jika dirty
    document.addEventListener('click', function(e){
        const a = e.target.closest('a');
        if(!a) return;
        const href = a.getAttribute('href');
        if(!href || href.startsWith('#') || href.startsWith('javascript:')) return;

        if(dirty){
            e.preventDefault();
            showLeaveModal(href);
        }
    });

    document.getElementById('btnYes').addEventListener('click', () => {
        if(pendingUrl) window.location.href = pendingUrl;
    });

    document.getElementById('btnNo').addEventListener('click', () => hideLeaveModal());

    // kalau user close tab / refresh
    window.addEventListener('beforeunload', function(e){
        if(!dirty) return;
        e.preventDefault();
        e.returnValue = '';
    });
})();
</script>
<?php /**PATH C:\laragon\www\KP_SIGERAI\resources\views/gerai/laporan/input.blade.php ENDPATH**/ ?>