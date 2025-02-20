<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KontraktorProfile;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $kontraktors = KontraktorProfile::where('status', 0)->get();
        return view('admin.dashboard', compact('kontraktors'));
    }
}
