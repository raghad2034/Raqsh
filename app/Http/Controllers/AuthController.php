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
            'name' => 'required|string|min:2|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ], [
            'name.required' => 'يرجى كتابة الاسم.',
            'name.min' => 'الاسم يجب ألا يقل عن حرفين.',
            'name.max' => 'الاسم يجب ألا يزيد عن 50 حرفاً.',
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.email' => 'يرجى كتابة بريد إلكتروني صالح.',
            'email.unique' => 'هذا البريد مسجل مسبقاً لدينا.',
            'password.required' => 'كلمة المرور مطلوبة.',
            'password.min' => 'كلمة المرور يجب أن تتكون من 8 خانات على الأقل.',
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
        ], [
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.email' => 'يرجى إدخال بريد صالح.',
            'password.required' => 'كلمة المرور مطلوبة.',
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