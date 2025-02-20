<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    // Tampilkan form posting tugas
    public function showTaskForm()
    {
        return view('user.task');
    }

    // Simpan tugas yang diposting
    public function postTask(Request $request)
    {
        $request->validate([
            'lokasi_proyek' => 'required|string|max:255',
            'estimasi_anggaran' => 'nullable|numeric',
            'tanggal_mulai' => 'required|date',
            'durasi_proyek' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi upload gambar
        ]);

        // Upload gambar (jika ada)
        $imagePath = $request->hasFile('image')
            ? $request->file('image')->store('task_images', 'public')
            : null;

        // Simpan tugas langsung ke database
        Task::create([
            'user_id' => Auth::id(), // Pastikan tabel Task memiliki kolom user_id
            'lokasi_proyek' => $request->lokasi_proyek,
            'estimasi_anggaran' => $request->estimasi_anggaran,
            'tanggal_mulai' => $request->tanggal_mulai,
            'durasi_proyek' => $request->durasi_proyek,
            'image' => $imagePath,
        ]);

        return redirect()->route('user.task')->with('success', 'Tugas berhasil diposting!');
    }
}
