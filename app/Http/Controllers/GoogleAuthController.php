<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')
            ->with(['prompt' => 'select_account']) // ✅ selalu pilih akun
            ->redirect();
    }

    public function callback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        // 1) Cari user: prioritas google_id, kalau belum ada cari by email
        $user = User::where('google_id', $googleUser->getId())
            ->orWhere('email', $googleUser->getEmail())
            ->first();

        // 2) Kalau belum ada, buat user baru
        if (!$user) {
            $baseUsername = Str::slug(Str::before($googleUser->getEmail(), '@'));
            $username = $baseUsername;
            $i = 1;

            // pastikan username unik
            while (User::where('username', $username)->exists()) {
                $username = $baseUsername . $i;
                $i++;
            }

            $user = User::create([
                'name'      => $googleUser->getName() ?: $username,
                'email'     => $googleUser->getEmail(),
                'username'  => $username,
                // karena kolom password NOT NULL, isi random
                'password'  => bcrypt(Str::random(32)),
                'google_id' => $googleUser->getId(),
                'avatar'    => $googleUser->getAvatar(),
                'role'      => 'gerai',
                'is_active' => true,
            ]);
        } else {
            // 3) Kalau user ada tapi belum punya google_id, isi
            if (!$user->google_id) $user->google_id = $googleUser->getId();
            if (!$user->avatar) $user->avatar = $googleUser->getAvatar();
            if (!$user->is_active) $user->is_active = true; // kalau kamu mau auto-aktifkan
            $user->save();
        }

        // 4) (Opsional) kalau user dinonaktifkan, stop di sini
        if (!$user->is_active) {
            return redirect()->route('login.gerai')->with('error', 'Akun Anda nonaktif.');
        }

        // 5) Login ke sistem
        Auth::login($user, true);

        // 6) Redirect sesuai role
        if ($user->role === 'admin') {
            return redirect('/admin/dashboard');
        }

        return redirect('/gerai/dashboard');
    }
}
