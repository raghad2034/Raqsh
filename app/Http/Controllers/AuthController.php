<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    // عرض صفحة إنشاء الحساب
    public function showSignup()
    {
        if (Auth::check()) return redirect()->route('home');
        return view('Authentication.signup');
    }

    // معالجة تسجيل الحساب الجديد
    public function signup(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        Auth::login($user);
        return redirect()->route('home')->with('success', 'تم إنشاء الحساب بنجاح!');
    }

    // عرض صفحة تسجيل الدخول
    public function showLogin()
    {
        if (Auth::check()) return redirect()->route('home');
        return view('Authentication.login');
    }

    // معالجة تسجيل الدخول
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('home')->with('success', 'تم تسجيل الدخول بنجاح!');
        }

        return back()->withErrors([
            'email' => 'بيانات الدخول غير صحيحة.',
        ])->onlyInput('email');
    }

    // تسجيل الخروج
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('success', 'تم تسجيل الخروج بنجاح.');
    }
}