<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Like, Comment, Interest, Task};
use Illuminate\Support\Facades\Auth;

class TaskInteractionController extends Controller
{
    // Like atau Unlike
    public function likeTask(Request $request, Task $task)
    {
        $like = Like::where('user_id', Auth::id())->where('task_id', $task->id)->first();

        if ($like) {
            $like->delete();
            return response()->json(['status' => 'unliked']);
        } else {
            Like::create(['user_id' => Auth::id(), 'task_id' => $task->id]);
            return response()->json(['status' => 'liked']);
        }
    }

    // Tambah Komentar
    public function commentTask(Request $request, Task $task)
    {
        $request->validate(['comment' => 'required|string|max:500']);

        Comment::create([
            'user_id' => Auth::id(),
            'task_id' => $task->id,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan!');
    }

    // Tertarik (Hanya untuk Kontraktor)
    public function interestTask(Request $request, Task $task)
    {
        if (Auth::user()->role !== 'kontraktor') {
            return response()->json(['status' => 'error', 'message' => 'Hanya kontraktor yang bisa menekan tombol ini.']);
        }

        $interest = Interest::where('user_id', Auth::id())->where('task_id', $task->id)->first();

        if ($interest) {
            $interest->delete();
            return response()->json(['status' => 'uninterested']);
        } else {
            Interest::create(['user_id' => Auth::id(), 'task_id' => $task->id]);
            return response()->json(['status' => 'interested']);
        }
    }
}
