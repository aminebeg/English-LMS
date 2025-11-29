<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class EditorController extends Controller
{
    public function index()
    {
        $pendingTutors = User::role('tutor')->where('is_approved', false)->get();
        return view('editor.dashboard', compact('pendingTutors'));
    }

    public function approve(User $user)
    {
        $user->update(['is_approved' => true]);
        return back()->with('status', 'Tutor approved!');
    }
}
