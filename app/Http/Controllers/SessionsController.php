<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class SessionsController extends Controller
{
    public function create()
    {
        return view('session.login-session');
    }

    public function store()
    {

        $attributes = request()->validate([
            'username' => 'required|string',  // Ganti dari 'email' ke 'username'
            'passUser' => 'required'
        ]);
        $user = DB::table('user')->where('username', $attributes['username'])->first();

        if (!$user) {
            return back()->withErrors(['username' => 'Username tidak ditemukan.']);
        }

// Bandingkan password secara langsung
        if ($attributes['passUser'] === $user->passUser) {
            session()->regenerate();
            return redirect('/dashboard')->with(['success' => 'You are logged in.']);
        }

return back()->withErrors(['passUser' => 'Username atau password salah.']);
    }
    
    public function destroy()
    {

        Auth::logout();

        return redirect('/login')->with(['success'=>'You\'ve been logged out.']);
    }
}
