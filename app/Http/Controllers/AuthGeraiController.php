<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Gerai;
use Illuminate\Support\Facades\DB;


class AuthGeraiController extends Controller
{
    // =========================
    // GET VIEW
    // =========================
    public function showLogin()
    {
        return view('auth.login-gerai');
    }

    public function showRegister()
    {
        return view('auth.register-gerai');
    }

    // =========================
    // POST ACTION
    // =========================
    public function login(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // login pakai default guard "web"
        if (Auth::attempt([
            'username' => $request->username,
            'password' => $request->password,
        ])) {
            $request->session()->regenerate();

            // redirect sesuai role
            $role = Auth::user()->role;

            if ($role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('gerai.dashboard');
        }

        return back()->with('error', 'Login gagal. Username atau password salah.');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'], // ini akan jadi nama_gerai
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $email = $request->username . '@local.sigera';

        DB::transaction(function () use ($request, $email) {

            // 1) Buat data GERAI otomatis
            $gerai = Gerai::create([
                'nama_gerai' => $request->name,
                'status_aktif' => true,
            ]);

            // 2) Buat USER dan link ke gerai_id
            User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $email,
                'password' => Hash::make($request->password),
                'role' => 'gerai',
                'gerai_id' => $gerai->id,      // ✅ ini kunci biar chat muncul
                'is_active' => true,
                'remember_token' => Str::random(60),
             ]);
        });

        return redirect()->route('login.gerai')
            ->with('success', 'Akun berhasil dibuat. Silakan login.');
    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.gerai');
    }
}
