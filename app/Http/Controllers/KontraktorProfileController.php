<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KontraktorProfile;
use Illuminate\Support\Facades\Auth;
use App\Models\KontraktorFile;

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
        $kontraktor = KontraktorProfile::with('files')->where('user_id', Auth::id())->first(); // Ambil data beserta file-file terkait

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
            'dokumen_pendukung.*' => 'nullable|file|mimes:pdf,doc,docx|max:5120', // Validasi untuk banyak file
            'portofolio.*' => 'nullable|image|mimes:jpeg,png,jpg|max:5120', // Validasi untuk banyak file
        ]);

        // Simpan atau update profil kontraktor
        $kontraktorProfile = KontraktorProfile::updateOrCreate(
            ['user_id' => Auth::id()],
            $request->except('foto_profile', 'dokumen_pendukung', 'portofolio')
        );

        // Upload foto profil (jika ada)
        if ($request->hasFile('foto_profile')) {
            $fotoPath = $request->file('foto_profile')->store('foto_profil', 'public');
            $kontraktorProfile->foto_profile = strval($fotoPath);
        }

        // Upload banyak dokumen pendukung
        if ($request->hasFile('dokumen_pendukung')) {
            foreach ($request->file('dokumen_pendukung') as $file) {
                $filePath = $file->store('dokumen', 'public');
                KontraktorFile::create([
                    'kontraktor_profile_id' => $kontraktorProfile->id,
                    'file_path' => $filePath,
                    'file_type' => 'dokumen_pendukung',
                ]);
            }
        }

        // Upload banyak portofolio
        if ($request->hasFile('portofolio')) {
            foreach ($request->file('portofolio') as $file) {
                $filePath = $file->store('portofolio', 'public');
                KontraktorFile::create([
                    'kontraktor_profile_id' => $kontraktorProfile->id,
                    'file_path' => $filePath,
                    'file_type' => 'portofolio',
                ]);
            }
        }


        // Simpan perubahan
        $kontraktorProfile->save();

        return redirect()->route('kontraktor.dashboard')->with('success', 'Profil berhasil disimpan!');
    }
}
