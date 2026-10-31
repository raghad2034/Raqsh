@extends('Layout.app')

@section('title', 'دخول | رَقْش')

@section('content')
<div class="min-h-screen flex items-center justify-center p-4 relative z-10">
  <div class="card w-full max-w-md rounded-3xl p-8 sm:p-10">
    <div class="text-center mb-7">
      <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-wine mb-2">
        <svg class="h-9 w-9"><use href="#rosette"/></svg>
        <span class="font-amiri text-4xl font-bold">رَقْش</span>
      </a>
      <h1 class="font-amiri text-3xl font-bold text-wine">تسجيل الدخول</h1>
      <p class="text-sm text-mute mt-1">عُد إلى محراب كلماتك</p>
    </div>

    <?php if ($errors->any()): ?>
      <div class="mb-5 rounded-2xl border border-rose/30 bg-rose/10 p-4 text-xs text-rose">
        <ul class="list-disc list-inside space-y-1">
          <?php foreach ($errors->all() as $error): ?>
            <li>{{ $error }}</li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <form action="{{ route('login') }}" method="POST" class="space-y-4">
      @csrf
      <div>
        <label class="block text-sm text-mute mb-1" for="email">البريد الإلكتروني</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="example@mail.com" required class="w-full rounded-xl border border-line bg-paper/60 p-3 text-ink outline-none focus:border-wine transition">
      </div>

      <div>
        <label class="block text-sm text-mute mb-1" for="password">كلمة المرور</label>
        <input id="password" type="password" name="password" placeholder="٨ أحرف على الأقل" required class="w-full rounded-xl border border-line bg-paper/60 p-3 text-ink outline-none focus:border-wine transition">
      </div>

      <button type="submit" class="wine-btn w-full rounded-full py-3 font-semibold shadow-lg transition hover:opacity-95 mt-2">دخول</button>
    </form>

    <p class="text-center text-sm text-mute mt-6">
      ليس لديك حساب؟ <a href="{{ route('signup') }}" class="font-semibold text-wine hover:underline">انضم إلينا</a>
    </p>
  </div>
</div>
@endsection