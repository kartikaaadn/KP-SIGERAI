{{-- resources/views/admin/pesan/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Pesan Admin')

@section('header')
    @include('partials.header')
@endsection

@section('content')
<section class="admin-shell">
    {{-- Sidebar Admin --}}
    @include('partials.sidebar-admin')

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
                        {{ $activeConversation?->gerai?->nama_gerai ?? 'Pilih Gerai' }}
                    </div>
                    <div class="chat-top__sub">Chat terkait laporan</div>
                </div>
            </div>

            <div class="chat-body">
                {{-- LEFT --}}
                <div class="chat-list">
                    @php $convs = $conversations ?? collect(); @endphp

                    @forelse($convs as $c)
                        @php
                            $isActive = isset($activeConversation) && $activeConversation->id === $c->id;
                            $nm = $c->gerai?->nama_gerai ?? 'Gerai';
                            $tm = optional($c->last_message_at ?? $c->updated_at)->format('H.i');
                        @endphp

                        <a class="chat-list__item {{ $isActive ? 'is-active' : '' }}"
                           href="{{ route('admin.pesan.index', ['c' => $c->id]) }}">
                            <div class="chat-list__name">{{ $nm }}</div>
                            <div class="chat-list__msg">Klik untuk buka percakapan</div>
                            <div class="chat-list__time">{{ $tm }}</div>
                        </a>
                    @empty
                        <div class="chat-list__empty">Belum ada percakapan dari gerai.</div>
                    @endforelse
                </div>

                {{-- RIGHT --}}
                <div class="chat-room">
                    <div class="chat-messages" id="chatMessages">
                        @if(!isset($activeConversation) || !$activeConversation)
                            <div class="empty-chat">Pilih gerai di sebelah kiri untuk membuka chat.</div>
                        @else
                            @php $msgs = $messages ?? collect(); @endphp

                            @forelse($msgs as $msg)
                                @php
                                    $isMe = $msg->sender_user_id === auth()->id();
                                    $time = optional($msg->created_at)->format('H.i');
                                @endphp

                                <div class="bubble-row {{ $isMe ? 'me' : 'other' }}">
                                    <div class="bubble {{ $isMe ? 'bubble-me' : 'bubble-other' }}">
                                        {{ $msg->message }}
                                        <div class="bubble-time">{{ $time }}</div>
                                    </div>
                                </div>
                            @empty
                                <div class="empty-chat">Belum ada pesan di percakapan ini.</div>
                            @endforelse
                        @endif
                    </div>

                    @if(isset($activeConversation) && $activeConversation)
                        <form class="chat-input" method="POST" action="{{ route('admin.pesan.send') }}">
                            @csrf
                            <input type="hidden" name="conversation_id" value="{{ $activeConversation->id }}">

                            {{-- ✅ Template dropdown (ADMIN) --}}
                            <select class="chat-template" id="templateSelectAdmin">
                                <option value="">Pilih template...</option>
                                @foreach(($templates ?? []) as $t)
                                    <option value="{{ $t }}">{{ $t }}</option>
                                @endforeach
                            </select>

                            <input class="chat-text" id="chatTextAdmin" type="text" name="message"
                                   placeholder="Ketik pesan untuk gerai..." required>

                            <button class="chat-send" type="submit" title="Kirim">➤</button>
                        </form>
                    @endif
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
@endsection

@section('footer')
    @include('partials.footer')
@endsection
