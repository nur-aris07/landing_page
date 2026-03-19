<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login() {
        return view('admin.login');
    }

    public function auth(Request $request) {
        $validator = Validator::make($request->all(), [
            'username'  => 'required|string',
            'password'  => 'required|string|max:15',
            'captcha'   => '',
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->with('error', 'Validasi gagal, silakan cek kembali input.');
        }

        $user = User::where('username', $request->username)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Kombinasi Email dan Password tidak ditemukan.');
        }

        Auth::login($user);
        $request->session()->regenerate();
        return redirect()->intended('/dashboard');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->regenerate();
        return redirect('/login');
    }
}
