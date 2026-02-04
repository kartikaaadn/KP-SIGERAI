<?php

namespace App\Http\Controllers\Gerai;

use App\Http\Controllers\Controller;
use App\Models\Gerai;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class GeraiProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user || !$user->gerai_id) {
            abort(403, 'Akun ini belum terhubung ke gerai.');
        }

        $gerai = Gerai::findOrFail($user->gerai_id);

        // untuk 3 kotak bawah (kalau mau tampil)
        $registeredAt = $user->created_at;
        $lastLoginAt  = $user->last_login_at ?? null; // kalau kamu belum punya kolom ini, aman (null)

        // total laporan (pakai layanan_harians sebagai "laporan" harian gerai)
        $totalLaporan = \DB::table('layanan_harians')->count();

        return view('gerai.profile.index', compact('user', 'gerai', 'registeredAt', 'lastLoginAt', 'totalLaporan'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        if (!$user || !$user->gerai_id) {
            abort(403, 'Akun ini belum terhubung ke gerai.');
        }

        $gerai = Gerai::findOrFail($user->gerai_id);

        $request->validate([
            'nama_gerai' => ['required', 'string', 'max:255'],
            'username'   => [
                'required', 'string', 'max:50',
                Rule::unique('users', 'username')->ignore($user->id),
            ],
            'email'      => ['nullable', 'email', 'max:255'],
            'no_telp'    => ['nullable', 'string', 'max:30'],
            'alamat'     => ['nullable', 'string', 'max:255'],

            // password opsional
            'password'   => ['nullable', 'string', 'min:8'],
            'password_confirmation' => ['same:password'],
        ]);

        // update data user
        $user->username = $request->username;
        $user->email    = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        // update data gerai
        $gerai->nama_gerai      = $request->nama_gerai;
        $gerai->pic_kontak      = $request->no_telp;         // NOMOR TELEPON
        $gerai->lokasi_counter  = $request->alamat;          // ALAMAT
        $gerai->save();

        $user->load('gerai');
        auth()->setUser($user);
        $request->session()->regenerate();


        return redirect()
            ->route('gerai.profile.index')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}
