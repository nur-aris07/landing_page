<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login() {
        return view('admin.login');
    }

    public function auth() {}

    public function logout() {}
}
