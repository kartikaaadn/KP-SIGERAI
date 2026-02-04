<div style="
    height: 90px;
    background: linear-gradient(90deg, #F44545 0%, #7C1012 100%);
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding: 0 40px;
    box-sizing:border-box;
">

    {{-- KIRI: logo + teks --}}
    <div style="display:flex; align-items:center; gap:10px; color:#fff;">
        <img src="{{ asset('assets/logo-dpmptsp.png') }}"
             alt="DPMPTSP"
             style="height:56px; object-fit:contain; margin-top:7px;">

        <img src="{{ asset('assets/logo-sigera.png') }}"
             alt="SIGERA"
             style="height:56px; object-fit:contain;">

        <div style="display:flex; flex-direction:column; justify-content:center; line-height:1.1;">
            <div style="font-weight:800; font-size:26px; letter-spacing:0.5px;">
                SIGERAIMPP
            </div>
            <div style="font-size:12px; opacity:0.9;">
                Sistem Informasi Gerai Mal Pelayanan Publik
            </div>
        </div>
    </div>

    {{-- KANAN: profil (klik avatar ke halaman profile sesuai role) --}}
    @auth
        @php
            $user = auth()->user();
            $role = $user->role ?? 'gerai';
            $displayRole = $role === 'admin' ? 'Admin' : 'Gerai';

            // Nama yang ditampilkan
            $geraiName = optional($user->gerai)->nama_gerai;
            $displayName = $role === 'admin'
                ? ($user->name ?? 'Admin SIGERAIMPP')
                : ($geraiName ?: ($user->username ?? 'Gerai'));

            $avatar = $user->avatar ?? null;

            // ✅ Link klik profil (FIX):
            // - Admin -> halaman profile admin
            // - Gerai -> halaman profile gerai
            $profileUrl = '#';
            if ($role === 'admin') {
                $profileUrl = Route::has('admin.profile.index')
                    ? route('admin.profile.index')
                    : (Route::has('admin.dashboard') ? route('admin.dashboard') : '#');
            } else {
                $profileUrl = Route::has('gerai.profile.index')
                    ? route('gerai.profile.index')
                    : '#';
            }
        @endphp

        <a href="{{ $profileUrl }}" style="display:flex; align-items:center; gap:12px; color:#fff; text-decoration:none;">
            @if($avatar)
                <img src="{{ $avatar }}"
                     alt="Avatar"
                     style="width:38px; height:38px; border-radius:999px; object-fit:cover; border:2px solid rgba(255,255,255,.7);">
            @else
                <div style="
                    width:38px; height:38px;
                    border-radius:999px;
                    background: rgba(255,255,255,.18);
                    display:flex; align-items:center; justify-content:center;
                    border:2px solid rgba(255,255,255,.55);
                ">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="white" viewBox="0 0 24 24">
                        <path d="M12 12c2.761 0 5-2.239 5-5s-2.239-5-5-5-5 2.239-5 5 2.239 5 5 5zm0 2c-4.418 0-8 2.239-8 5v1h16v-1c0-2.761-3.582-5-8-5z"/>
                    </svg>
                </div>
            @endif

            <div style="display:flex; flex-direction:column; line-height:1.1;">
                <div style="font-weight:800; font-size:14px;">{{ $displayName }}</div>
                <div style="font-size:12px; opacity:.9;">{{ $displayRole }}</div>
            </div>
        </a>
    @endauth

</div>
