@extends('layouts.app')

@section('title', 'Daftar Gerai')

@section('header')
    @include('partials.header')
@endsection

@section('content')
<section class="register-page">
    <div class="register-page__bg"></div>
    <div class="register-page__overlay"></div>

    <div class="register-card">
        <div class="register-title">
            <span class="register-title__grad">DAFTAR</span>
            <span class="register-title__grad">GERAI</span>
        </div>

        <div class="register-subtitle">(Buat akun untuk gerai Anda)</div>

        {{-- kalau mau tampil error validasi --}}
        @if ($errors->any())
            <div class="alert-err">
                <ul>
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form class="register-form" method="POST" action="{{ route('gerai.register.submit') }}">
            @csrf

            <div class="field">
                <label>Nama Gerai</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Silahkan masukkan nama gerai" required>
            </div>

            <div class="field">
                <label>Username Gerai</label>
                <input type="text" name="username" value="{{ old('username') }}" placeholder="Silahkan masukkan username gerai" required>
            </div>

            <div class="field">
                <label>Password Gerai</label>
                <input type="password" name="password" placeholder="Silahkan masukkan password gerai" required>
            </div>

            <div class="field">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation" placeholder="Silahkan masukkan konfirmasi password" required>
            </div>

            <button class="btn-submit" type="submit">Daftar</button>

            <div class="login-link">
                Sudah punya akun? <a href="{{ route('login.gerai') }}">Masuk di sini</a>
            </div>
        </form>
    </div>
</section>

<style>
/* background page */
.register-page{
    position: relative;
    min-height: calc(100vh - 90px); /* tinggi header */
    display:flex;
    align-items:center;
    justify-content:center;
    overflow:hidden;
    padding: 40px 18px;
    box-sizing: border-box;
}

/* gedung background */
.register-page__bg{
    position:absolute;
    inset:0;
    background: url('{{ asset('assets/gedung.jpg') }}') center/cover no-repeat;
    transform: scale(1.02);
}

/* overlay soft */
.register-page__overlay{
    position:absolute;
    inset:0;
    background: radial-gradient(circle at center, rgba(255,255,255,.35), rgba(255,255,255,.15));
}

/* card */
.register-card{
    position:relative;
    width: min(720px, 100%);
    background: rgba(255,255,255,.92);
    border-radius: 10px;
    padding: 44px 42px;
    box-shadow: 0 18px 50px rgba(0,0,0,.22);
    backdrop-filter: blur(2px);
}

.register-title{
    text-align:center;
    font-weight:900;
    font-size: 34px;
    letter-spacing: .5px;
    margin-bottom: 6px;
}

/* gradien footer */
.register-title__grad{
    background: linear-gradient(90deg, #F12424 0%, #791B91 50%, #0011FF 100%);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
}

.register-subtitle{
    text-align:center;
    font-size: 13px;
    color: rgba(0,0,0,.65);
    margin-bottom: 26px;
}

.alert-err{
    width: min(430px, 100%);
    margin: 0 auto 14px;
    background: rgba(241, 36, 36, .08);
    border: 1px solid rgba(241, 36, 36, .25);
    border-radius: 10px;
    padding: 12px 14px;
    color: rgba(0,0,0,.75);
}
.alert-err ul{ margin:0; padding-left: 18px; }

.register-form{
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

/* tombol daftar gradien footer */
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

.login-link{
    text-align:center;
    margin-top: 12px;
    font-size: 13px;
    color: rgba(0,0,0,.6);
}
.login-link a{
    color: #5b3df2;
    font-weight:800;
    text-decoration:none;
}

@media (max-width: 520px){
    .register-card{ padding: 34px 18px; }
    .register-title{ font-size: 28px; }
}
</style>
@endsection

@section('footer')
    @include('partials.footer')
@endsection
