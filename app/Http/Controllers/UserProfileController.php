<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Storage;

class UserProfileController extends Controller
{
    // Tampilkan form profil user
    public function showProfileForm()
    {
        $user = Auth::user();
        $profile = $user->profile; // Ambil data profil user
        return view('user.profile', compact('profile'));
    }

    public function saveProfile(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'alamat_lengkap' => 'required|string|max:500',
            'nomor_telepon' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi upload gambar
        ]);

        $user = Auth::user();

        // Upload foto profil (jika ada)
        $fotoProfilPath = null;
        if ($request->hasFile('foto_profil')) {
            $fotoProfilPath = $request->file('foto_profil')->store('foto_profil', 'public');
        }

        // Update atau simpan profil user
        $profile = UserProfile::where('user_id', $user->id)->first();

        if ($profile) {
            // Jika profil sudah ada, update data
            $profile->update([
                'nama_lengkap' => $request->nama_lengkap,
                'alamat_lengkap' => $request->alamat_lengkap,
                'nomor_telepon' => $request->nomor_telepon,
                'email' => $request->email,
                'foto_profil' => $fotoProfilPath,
            ]);
        } else {
            // Jika profil belum ada, buat profil baru
            UserProfile::create([
                'user_id' => $user->id,
                'nama_lengkap' => $request->nama_lengkap,
                'alamat_lengkap' => $request->alamat_lengkap,
                'nomor_telepon' => $request->nomor_telepon,
                'email' => $request->email,
                'foto_profil' => $fotoProfilPath,
            ]);
        }

        return redirect()->route('user.profile')->with('success', 'Profil berhasil disimpan!');
    }

}
