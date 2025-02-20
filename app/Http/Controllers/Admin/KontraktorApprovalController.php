<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KontraktorProfile;
use Illuminate\Http\Request;

class KontraktorApprovalController extends Controller
{
    // Tampilkan form approve/reject
    public function showApprovalForm($id)
    {
        $kontraktor = KontraktorProfile::findOrFail($id);
        return view('admin.approve_kontraktor', compact('kontraktor'));
    }

    public function approve(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:0,1',
            'catatan_admin' => 'nullable|string',
        ]);

        $kontraktor = KontraktorProfile::find($id);

        if (!$kontraktor) {
            return redirect()->back()->with('error', 'Profil kontraktor tidak ditemukan.');
        }

        $kontraktor->update([
            'status' => $request->status,
            'catatan_admin' => $request->catatan_admin,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Profil kontraktor berhasil diperbarui.');
    }
}
