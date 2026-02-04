


<?php $__env->startSection('title', 'Pesan Admin'); ?>

<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<section class="admin-shell">
    
    <?php echo $__env->make('partials.sidebar-admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="admin-main">
        <div class="page-head">
            <div class="page-head__title">Pesan Admin</div>
            <div class="page-head__sub">Komunikasi dengan seluruh gerai</div>
        </div>

        <div class="chat-card">
            <div class="chat-top">
                <div class="chat-top__left">
                    <div class="chat-top__title">Daftar Gerai</div>
                    <div class="chat-top__sub">Klik gerai untuk melihat pesan</div>
                </div>

                <div class="chat-top__right">
                    <div class="chat-top__title">
                        <?php echo e($activeConversation?->gerai?->nama_gerai ?? 'Pilih Gerai'); ?>

                    </div>
                    <div class="chat-top__sub">Chat terkait laporan</div>
                </div>
            </div>

            <div class="chat-body">
                
                <div class="chat-list">
                    <?php $convs = $conversations ?? collect(); ?>

                    <?php $__empty_1 = true; $__currentLoopData = $convs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $isActive = isset($activeConversation) && $activeConversation->id === $c->id;
                            $nm = $c->gerai?->nama_gerai ?? 'Gerai';
                            $tm = optional($c->last_message_at ?? $c->updated_at)->format('H.i');
                        ?>

                        <a class="chat-list__item <?php echo e($isActive ? 'is-active' : ''); ?>"
                           href="<?php echo e(route('admin.pesan.index', ['c' => $c->id])); ?>">
                            <div class="chat-list__name"><?php echo e($nm); ?></div>
                            <div class="chat-list__msg">Klik untuk buka percakapan</div>
                            <div class="chat-list__time"><?php echo e($tm); ?></div>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="chat-list__empty">Belum ada percakapan dari gerai.</div>
                    <?php endif; ?>
                </div>

                
                <div class="chat-room">
                    <div class="chat-messages" id="chatMessages">
                        <?php if(!isset($activeConversation) || !$activeConversation): ?>
                            <div class="empty-chat">Pilih gerai di sebelah kiri untuk membuka chat.</div>
                        <?php else: ?>
                            <?php $msgs = $messages ?? collect(); ?>

                            <?php $__empty_1 = true; $__currentLoopData = $msgs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
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
                                <div class="empty-chat">Belum ada pesan di percakapan ini.</div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>

                    <?php if(isset($activeConversation) && $activeConversation): ?>
                        <form class="chat-input" method="POST" action="<?php echo e(route('admin.pesan.send')); ?>">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="conversation_id" value="<?php echo e($activeConversation->id); ?>">

                            
                            <select class="chat-template" id="templateSelectAdmin">
                                <option value="">Pilih template...</option>
                                <?php $__currentLoopData = ($templates ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($t); ?>"><?php echo e($t); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>

                            <input class="chat-text" id="chatTextAdmin" type="text" name="message"
                                   placeholder="Ketik pesan untuk gerai..." required>

                            <button class="chat-send" type="submit" title="Kirim">➤</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>
</section>

<style>
:root{
    --footerGrad: linear-gradient(90deg, #F12424 0%, #791B91 50%, #0011FF 100%);
}

.admin-shell{ display:flex; width:100%; align-items:stretch; }
.admin-main{ flex:1; min-width:0; padding:18px; box-sizing:border-box; padding-bottom:40px; }

.page-head{
    background: rgba(255,255,255,.85);
    border-radius: 10px;
    padding: 16px 18px;
    box-shadow: 0 10px 26px rgba(0,0,0,.10);
    margin-bottom: 14px;
}
.page-head__title{ font-size: 28px; font-weight: 900; color:#d61e1e; }
.page-head__sub{ margin-top: 4px; font-size: 13px; color: rgba(0,0,0,.65); }

.chat-card{
    background: rgba(255,255,255,.90);
    border-radius: 12px;
    overflow:hidden;
    box-shadow: 0 14px 34px rgba(0,0,0,.12);
}
.chat-top{ display:grid; grid-template-columns: 380px 1fr; }
.chat-top__left, .chat-top__right{
    padding: 14px 16px;
    color:#fff;
    background: var(--footerGrad);
}
.chat-top__title{ font-weight:900; font-size:20px; }
.chat-top__sub{ opacity:.95; font-size:12px; margin-top:2px; }

.chat-body{ display:grid; grid-template-columns: 380px 1fr; min-height: 560px; }

.chat-list{
    border-right: 1px solid rgba(0,0,0,.08);
    background: rgba(245,248,255,.55);
}
.chat-list__item{
    display:block;
    position:relative;
    padding: 14px 16px;
    text-decoration:none;
    border-bottom: 1px solid rgba(0,0,0,.06);
    color:#111;
}
.chat-list__item:hover{ background: rgba(232,238,255,.70); }
.chat-list__item.is-active{ background: rgba(232,238,255,.90); }
.chat-list__name{ font-weight:900; color:#b81414; font-size:18px; }
.chat-list__msg{ font-size: 13px; color: rgba(0,0,0,.70); margin-top: 4px; }
.chat-list__time{ position:absolute; right: 14px; top: 16px; font-size: 12px; color: rgba(0,0,0,.55); }
.chat-list__empty{ padding: 18px; color: rgba(0,0,0,.55); font-weight: 700; }

.chat-room{ display:flex; flex-direction:column; background: rgba(255,255,255,.55); }
.chat-messages{ flex:1; padding: 18px; overflow:auto; }
.empty-chat{ text-align:center; color: rgba(0,0,0,.55); margin-top: 40px; font-weight: 700; }

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
.bubble-me{ color:#fff; background: var(--footerGrad); border-top-right-radius: 0; }
.bubble-other{ background: rgba(255,255,255,.95); border: 1px solid rgba(0,0,0,.18); border-top-left-radius: 0; }
.bubble-time{ font-size: 11px; opacity: .85; margin-top: 6px; text-align:right; }

.chat-input{
    display:flex;
    gap:10px;
    padding: 12px;
    border-top: 1px solid rgba(0,0,0,.08);
    background: rgba(255,255,255,.75);
}

/* ✅ dropdown template admin */
.chat-template{
    width: 260px;
    border: 1px solid rgba(0,0,0,.15);
    border-radius: 10px;
    padding: 10px 12px;
    outline:none;
    background:#fff;
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
    background: var(--footerGrad);
}
.chat-send:hover{ opacity:.96; transform: translateY(-1px); }
.chat-send:active{ transform: translateY(0px); }

@media (max-width: 980px){
    .chat-top, .chat-body{ grid-template-columns: 1fr; }
    .chat-list{ display:none; }
    .chat-template{ width: 200px; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // auto scroll ke bawah
    const box = document.getElementById('chatMessages');
    if(box) box.scrollTop = box.scrollHeight;

    // template -> input
    const select = document.getElementById('templateSelectAdmin');
    const input  = document.getElementById('chatTextAdmin');

    if(select && input){
        select.addEventListener('change', function(){
            if(this.value){
                input.value = this.value;
                input.focus();
            }
        });
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer'); ?>
    <?php echo $__env->make('partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\KP_SIGERAI\resources\views/admin/pesan/index.blade.php ENDPATH**/ ?>