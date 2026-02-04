<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gerai;
use App\Models\LayananHarian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Schema;

class AdminProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $totalGeraiAktif = Gerai::where('status_aktif', 1)->count();
        $totalGeraiTidakAktif = Gerai::where('status_aktif', 0)->count();
        $totalSeluruhLayanan = (int) LayananHarian::sum('total_layanan');

        $aktivitasTerbaru = LayananHarian::with('gerai')
            ->latest('created_at')
            ->take(8)
            ->get();

        return view('admin.profile.index', compact(
            'user',
            'totalGeraiAktif',
            'totalGeraiTidakAktif',
            'totalSeluruhLayanan',
            'aktivitasTerbaru'
        ));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required','string','max:120'],
            'username' => [
                'required','string','max:60',
                Rule::unique('users', 'username')->ignore($user->id),
            ],
            'email' => [
                'nullable','email','max:120',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'phone' => ['nullable','string','max:30'],
        ]);

        $user->name = $validated['name'];
        $user->username = $validated['username'];
        $user->email = $validated['email'] ?? null;

        // ✅ hanya set kalau kolom ada
        if (Schema::hasColumn('users', 'phone')) {
            $user->phone = $validated['phone'] ?? null;
        }

        $user->save();

        // ✅ biar header ikut berubah tanpa login ulang
        Auth::setUser($user->fresh());

        return back()->with('success', 'Profil admin berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => ['required','string'],
            'password' => ['required','string','min:8','confirmed'],
        ]);

        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->with('error', 'Password lama Anda salah.');
        }

        $user->password = Hash::make($validated['password']);
        $user->save();

        return back()->with('success', 'Password berhasil diubah.');
    }

    public function updateAvatar(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'avatar' => ['required','image','mimes:jpg,jpeg,png,webp','max:2048'],
        ]);

        $path = $request->file('avatar')->store('avatars', 'public');

        $user->avatar = '/storage/' . $path;
        $user->save();

        Auth::setUser($user->fresh());

        return back()->with('success', 'Foto profil berhasil diperbarui.');
    }
}
