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
        dd($user);
        if (Hash::check($attributes['passUser'], $user->passUser)) {
            // Auth::loginUsingId($user->idUser); // Ganti dengan ID pengguna jika perlu
            session()->regenerate();
            return redirect('/dashboard')->with(['success' => 'You are logged in.']);
        }

        return back()->withErrors(['passUser' => 'Username or password is invalid.']);
    }
    
    public function destroy()
    {

        Auth::logout();

        return redirect('/login')->with(['success'=>'You\'ve been logged out.']);
    }
}
