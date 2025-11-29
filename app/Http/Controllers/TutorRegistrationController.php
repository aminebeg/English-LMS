<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class TutorRegistrationController extends Controller
{
    public function create()
    {
        return view('auth.tutor-register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'bio' => ['nullable', 'string', 'max:500'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'tutor',
            'is_approved' => false,
        ]);

        event(new Registered($user));

        return redirect()->route('login')->with('status', 'Your tutor application has been submitted for review. You will receive access once approved by an editor.');
    }
}
