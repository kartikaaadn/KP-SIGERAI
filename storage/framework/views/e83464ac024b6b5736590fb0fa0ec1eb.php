

<?php $__env->startSection('title', 'Pesan Gerai'); ?>

<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<section class="gerai-shell">
    
    <?php echo $__env->make('partials.sidebar-gerai', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    
    <div class="gerai-main">
        <div class="page-head">
            <div class="page-head__title">Pesan Gerai DPMPTSP</div>
            <div class="page-head__sub">Komunikasi dengan admin terkait laporan</div>
        </div>

        <div class="chat-card">
            <div class="chat-top">
                <div class="chat-top__left">
                    <div class="chat-top__title">Daftar Pesan</div>
                    <div class="chat-top__sub">Pilih laporan untuk melihat pesan</div>
                </div>

                <div class="chat-top__right">
                    <div class="chat-top__title">Admin</div>
                    <div class="chat-top__sub">Chat terkait laporan</div>
                </div>
            </div>

            <div class="chat-body">
                
                <div class="chat-list">
                    <div class="chat-list__item is-active">
                        <div class="chat-list__name">Admin</div>
                        <div class="chat-list__msg">Oke Terimakasih</div>
                        <div class="chat-list__time">13.24</div>
                    </div>
                </div>

                
                <div class="chat-room">
                    <div class="chat-messages" id="chatMessages">
                        <?php $__empty_1 = true; $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                $isMe = $msg->sender_user_id === auth()->id();
                                $time = optional($msg->created_at)->format('H.i');
                            ?>

                            <div class="bubble-row <?php echo e($isMe ? 'me' : 'other'); ?>">
                                <div class="bubble <?php echo e($isMe ? 'bubble-me' : 'bubble-other'); ?>">
                                    <?php echo e($msg->message); ?>

                                    <div class="bubble-time"><?php echo e($time); ?></div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="empty-chat">Belum ada pesan. Mulai chat dengan admin.</div>
                        <?php endif; ?>
                    </div>

                    
                    <form class="chat-input" method="POST" action="<?php echo e(route('gerai.pesan.send')); ?>">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="conversation_id" value="<?php echo e($conversation->id); ?>">

                        <select class="chat-template" id="templateSelect">
                            <option value="">Pilih template...</option>
                            <?php $__currentLoopData = $templates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($t); ?>"><?php echo e($t); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>

                        <input class="chat-text" id="chatText" type="text" name="message" placeholder="Ketik pesan anda" required>

                        <button class="chat-send" type="submit" title="Kirim">➤</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

<style>
/* ✅ shell full tinggi main */
.gerai-shell{
    display:flex;
    width: 100%;
    height: 100%;        /* penting: full tinggi area main */
    overflow: hidden;    /* jangan scroll halaman */
}

/* konten kanan */
.gerai-main{
    flex:1;
    min-width: 0;
    padding: 18px;
    box-sizing: border-box;
    height: 100%;
    overflow: hidden;    /* jangan scroll */
}

/* header page */
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
    background: linear-gradient(90deg, #F12424 0%, #791B91 50%, #0011FF 100%);
    -webkit-background-clip:text;
    background-clip:text;
    color: transparent;
}
.page-head__sub{
    margin-top: 4px;
    font-size: 13px;
    color: rgba(0,0,0,.65);
}

/* ✅ chat-card harus bisa mengisi sisa tinggi */
.chat-card{
    background: rgba(255,255,255,.90);
    border-radius: 12px;
    overflow:hidden;
    box-shadow: 0 14px 34px rgba(0,0,0,.12);

    /* penting */
    height: calc(100% - 88px); /* kira-kira tinggi page-head + margin */
    display:flex;
    flex-direction:column;
}

/* header chat atas */
.chat-top{
    display:grid;
    grid-template-columns: 320px 1fr;
}
.chat-top__left,
.chat-top__right{
    padding: 14px 16px;
    color:#fff;
    background: linear-gradient(90deg, #F12424 0%, #791B91 50%, #0011FF 100%);
}
.chat-top__title{ font-weight:900; font-size:18px; }
.chat-top__sub{ opacity:.9; font-size:12px; margin-top:2px; }

/* ✅ body chat mengisi sisa tinggi card */
.chat-body{
    display:grid;
    grid-template-columns: 320px 1fr;
    flex:1;
    min-height: 0; /* WAJIB agar scroll internal bekerja benar */
}

/* list kiri */
.chat-list{
    border-right: 1px solid rgba(0,0,0,.08);
    background: rgba(245,248,255,.55);
    overflow:auto;
}
.chat-list__item{
    position:relative;
    padding: 14px 16px;
    cursor:pointer;
    border-bottom: 1px solid rgba(0,0,0,.06);
}
.chat-list__item.is-active{ background: rgba(232,238,255,.75); }
.chat-list__name{ font-weight:900; color:#c01616; }
.chat-list__msg{ font-size: 13px; color: rgba(0,0,0,.7); margin-top: 4px; }
.chat-list__time{
    position:absolute;
    right: 14px;
    top: 16px;
    font-size: 12px;
    color: rgba(0,0,0,.55);
}

/* ✅ chat kanan */
.chat-room{
    display:flex;
    flex-direction:column;
    background: rgba(255,255,255,.55);
    min-height: 0; /* WAJIB */
}

/* ✅ hanya ini yang scroll */
.chat-messages{
    flex:1;
    min-height: 0;     /* WAJIB */
    padding: 18px;
    overflow-y: auto;  /* scroll cuma di sini */
    overflow-x: hidden;
}

/* input tetap di bawah */
.chat-input{
    display:flex;
    gap:10px;
    padding: 12px;
    border-top: 1px solid rgba(0,0,0,.08);
    background: rgba(255,255,255,.75);
}

/* bubbles */
.bubble-row{ display:flex; margin: 10px 0; }
.bubble-row.me{ justify-content:flex-end; }
.bubble-row.other{ justify-content:flex-start; }

.bubble{
    max-width: 62%;
    padding: 12px 14px;
    border-radius: 10px;
    position:relative;
    font-weight:700;
    line-height:1.25;
}
.bubble-me{
    color:#fff;
    background: linear-gradient(90deg, #F12424 0%, #791B91 50%, #0011FF 100%);
    border-top-right-radius: 0;
}
.bubble-other{
    background: rgba(255,255,255,.95);
    border: 1px solid rgba(0,0,0,.18);
    border-top-left-radius: 0;
}
.bubble-time{
    font-size: 11px;
    opacity: .85;
    margin-top: 6px;
    text-align:right;
}

.empty-chat{
    text-align:center;
    color: rgba(0,0,0,.55);
    margin-top: 40px;
    font-weight: 700;
}

/* input */
.chat-template{
    width: 230px;
    border: 1px solid rgba(0,0,0,.15);
    border-radius: 10px;
    padding: 10px 12px;
    outline:none;
}
.chat-text{
    flex:1;
    border: 1px solid rgba(0,0,0,.15);
    border-radius: 10px;
    padding: 10px 12px;
    outline:none;
}
.chat-send{
    width: 52px;
    border: 0;
    border-radius: 12px;
    font-weight: 900;
    color:#fff;
    cursor:pointer;
    background: linear-gradient(90deg, #F12424 0%, #791B91 50%, #0011FF 100%);
    transition: transform .15s ease, opacity .15s ease;
}
.chat-send:hover{ transform: translateY(-2px); opacity:.96; }
.chat-send:active{ transform: translateY(-1px) scale(.99); }

@media (max-width: 980px){
    .chat-top, .chat-body{ grid-template-columns: 1fr; }
    .chat-list{ display:none; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const select = document.getElementById('templateSelect');
    const input  = document.getElementById('chatText');

    if(select && input){
        select.addEventListener('change', function(){
            if(this.value){
                input.value = this.value;
                input.focus();
            }
        });
    }

    const box = document.getElementById('chatMessages');
    if(box) box.scrollTop = box.scrollHeight;
});
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
    <?php echo $__env->make('partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\KP_SIGERAI\resources\views/gerai/pesan/index.blade.php ENDPATH**/ ?>