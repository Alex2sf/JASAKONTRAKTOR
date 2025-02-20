<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class HomeController extends Controller
{
    // Tampilkan semua postingan tugas di homepage
    public function index()
    {
        $tasks = Task::with('user')->latest()->get(); // Ambil semua tugas beserta user yang memposting
        return view('home')->with('tasks', $tasks);
    }
}
