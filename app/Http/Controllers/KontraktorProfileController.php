<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KontraktorProfile;
use Illuminate\Support\Facades\Auth;

class KontraktorProfileController extends Controller
{
    // Tampilkan form profil kontraktor
    public function showProfileForm()
    {
        return view('kontraktor.profile');
    }

    public function show()
    {
        $kontraktor = KontraktorProfile::where('user_id', Auth::id())->first(); // Ambil data sesuai ID user login

        if (!$kontraktor) {
            return redirect()->route('kontraktor.dashboard')->with('error', 'Data tidak ditemukan.');
        }

        return view('kontraktor.show', compact('kontraktor'));
    }

    // Simpan atau update profil kontraktor
    public function saveProfile(Request $request)
    {
        $request->validate([
            'foto_profile' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'nama_depan' => 'required|string|max:255',
            'nama_belakang' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:15',
            'email' => 'required|email|unique:kontraktor_profiles,email,' . Auth::id() . ',user_id',
            'alamat' => 'required|string|regex:/^[\pL\s\d\-.,]+$/u',
            'nama_perusahaan' => 'required|string|max:255',
            'nomor_npwp' => 'nullable|string|max:20',
            'bidang_usaha' => 'required|string|max:255',
            'dokumen_pendukung' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'portofolio' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        // Ambil atau buat profil berdasarkan user_id
        $kontraktorProfile = KontraktorProfile::updateOrCreate(
            ['user_id' => Auth::id()],
            $request->except('foto_profile', 'dokumen_pendukung', 'portofolio') // Tidak perlu json_encode()
        );// Upload foto profil
        if ($request->hasFile('foto_profile')) {
            $fotoPath = $request->file('foto_profile')->store('foto_profil', 'public');
            $kontraktorProfile->foto_profile = strval($fotoPath); // Pastikan disimpan sebagai string
        }

        // Upload dokumen pendukung
        if ($request->hasFile('dokumen_pendukung')) {
            $dokumenPath = $request->file('dokumen_pendukung')->store('dokumen', 'public');
            $kontraktorProfile->dokumen_pendukung = strval($dokumenPath); // Pastikan disimpan sebagai string
        }

        // Upload portofolio
        if ($request->hasFile('portofolio')) {
            $portofolioPath = $request->file('portofolio')->store('portofolio', 'public');
            $kontraktorProfile->portofolio = strval($portofolioPath); // Pastikan disimpan sebagai string
        }


        // Simpan perubahan
        $kontraktorProfile->save();

        return redirect()->route('kontraktor.dashboard')->with('success', 'Profil berhasil disimpan!');
    }
}
