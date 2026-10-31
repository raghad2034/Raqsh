@extends('Layout.app')

@section('title', 'رَقْش | Raqsh — أثَرُ الحرفِ حينَ يُزهِر')

@section('content')
@php
  $all = collect($quotes);
  $savedIds = collect($savedQuoteIds ?? [])->all();
  $mineCount = auth()->check() ? $all->where('user_id', Auth::id())->count() : 0;
  $floaters = $all->pluck('content')->take(12)->map(fn($c) => \Illuminate\Support\Str::limit($c, 80))->values();
  $in = auth()->check();
  $books = [
    ['title' => 'طوق الحمامة', 'author' => 'ابن حزم الأندلسي', 'c' => ['#6e0f22', '#9b1c34'], 'quotes' => ['الحبُّ أوَّلُه هزلٌ وآخرُه جِدّ.']],
    ['title' => 'المقدّمة', 'author' => 'ابن خلدون', 'c' => ['#4a0a16', '#8e1730'], 'quotes' => ['الظلمُ مُؤذِنٌ بخرابِ العمران.']],
    ['title' => 'الحيوان', 'author' => 'الجاحظ', 'c' => ['#7a1024', '#c0283a'], 'quotes' => ['المعاني مطروحةٌ في الطريق.']],
  ];
@endphp

<style>
  html, body, main {
    direction: rtl !important;
    text-align: right !important;
  }
  .card, article {
    text-align: right !important;
  }
  @keyframes roseTinyGlow {
    0%, 100% {
      transform: scale(1);
      filter: drop-shadow(0 0 2px rgba(225, 29, 72, 0.4));
    }
    50% {
      transform: scale(1.1);
      filter: drop-shadow(0 0 6px rgba(244, 63, 94, 0.85));
    }
  }
  .garden-rose-node {
    animation: roseTinyGlow 3s ease-in-out infinite;
    transform-origin: center;
    transition: transform 0.2s ease, filter 0.2s ease;
  }
  .garden-rose-node:hover {
    transform: scale(1.35) !important;
    filter: drop-shadow(0 0 10px rgba(244, 63, 94, 1)) !important;
  }
</style>

<div id="floaters" aria-hidden="true"></div>

<header class="sticky top-0 z-40 border-b border-line bg-white/80 backdrop-blur-md">
  <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-3">
    <div class="flex items-center gap-6">
      <a href="{{ route('home') }}" class="flex items-center gap-2.5 text-wine" aria-label="رَقْش">
        <svg class="h-9 w-9 text-rose animate-[spin_10s_linear_infinite]"><use href="#rosette"/></svg>
        <span class="leading-none"><span class="font-amiri text-3xl font-bold">رَقْش</span><span class="block text-[11px] text-mute" dir="ltr">Raqsh</span></span>
      </a>
      
      <nav class="hidden sm:flex items-center gap-4 text-sm font-medium text-mute">
        <a href="#masters" class="transition hover:text-wine flex items-center gap-1.5"><i class="fa-solid fa-feather text-rose"></i> سِيَر وفنون</a>
        <a href="#books" class="transition hover:text-wine flex items-center gap-1.5"><i class="fa-solid fa-book text-rose"></i> الكتب</a>
        <a href="#store" class="transition hover:text-wine flex items-center gap-1.5"><i class="fa-solid fa-bag-shopping text-rose"></i> المتجر</a>
      </nav>
    </div>

    <div class="flex items-center gap-2 text-sm">
      <a href="#books" class="sm:hidden rounded-full border border-line px-3 py-1.5 text-xs text-wine"><i class="fa-solid fa-book"></i></a>
      <a href="#store" class="sm:hidden rounded-full border border-line px-3 py-1.5 text-xs text-wine"><i class="fa-solid fa-bag-shopping"></i></a>
      @auth
        <form action="{{ route('logout') }}" method="POST">@csrf<button class="rounded-full border border-line px-4 py-2 transition hover:bg-paper">خروج</button></form>
      @endauth
      @guest
        <a href="{{ route('login') }}" class="rounded-full border border-line px-4 py-2 transition hover:bg-paper">دخول</a>
        <a href="{{ route('signup') }}" class="wine-btn rounded-full px-4 py-2 font-semibold shadow">انضمام</a>
      @endguest
    </div>
  </div>
</header>

<main class="relative z-10 mx-auto flex max-w-6xl flex-col gap-14 px-4 pb-40 pt-10">

  @guest
  <section class="hero relative order-1 overflow-hidden rounded-[2rem] px-6 py-16 sm:px-14 sm:py-24 shadow-sm">
    <svg class="pointer-events-none absolute -left-24 -top-24 h-[28rem] w-[28rem] text-rose opacity-25 animate-[spin_25s_linear_infinite]" aria-hidden="true"><use href="#rosette"/></svg>
    <h1 class="relative max-w-3xl font-amiri text-5xl font-bold leading-[1.5] text-wine sm:text-7xl">أثَرُ الحرفِ حينَ يُزهِر</h1>
    <p class="relative mt-6 max-w-xl font-amiri text-2xl leading-loose text-mute">كلُّ جملةٍ كتبتَها ذاتَ ليلٍ ما زالت تنتظرُ من يقرؤها. هنا تجد من سبقوك إلى الحرف، ومكاناً تترك فيه أثرك.</p>
    <div class="relative mt-8 flex flex-wrap gap-3">
      <a href="{{ route('signup') }}" class="wine-btn rounded-full px-7 py-3 font-semibold shadow-lg">انضم إلى رَقْش</a>
      <a href="#masters" class="rounded-full border border-wine/30 bg-white/70 px-7 py-3 text-wine transition hover:bg-white">تصفّح سِيَر الملهمين</a>
    </div>
    
    <div class="card relative mt-8 max-w-xl rounded-2xl p-5">
      <p class="font-amiri text-2xl font-bold text-wine">رَقْش <span class="font-plex text-sm font-normal text-mute">· اسم</span></p>
      <p class="mt-1 font-amiri text-xl leading-loose">النَّقشُ والكتابةُ المُنمَّقة؛ يُقال: رَقَشَ الكتابَ، أي كتبه وزيّنه</p>
    </div>
  </section>
  @endguest

  @auth
  <section class="hero relative order-1 overflow-hidden rounded-[2rem] p-8 sm:p-10 shadow-sm">
    <svg class="pointer-events-none absolute -left-12 -top-12 h-64 w-64 text-rose opacity-20 animate-[spin_20s_linear_infinite]" aria-hidden="true"><use href="#rosette"/></svg>
    <div class="relative flex flex-wrap items-center justify-between gap-4">
      <div>
        <h1 class="font-amiri text-3xl font-bold text-wine">مِحراب الكلمات</h1>
        <p class="text-sm text-mute mt-1">سجل ما يجول بخاطرك ليبقى أثراً لا يُمحى.</p>
      </div>
      <div class="flex gap-3">
        <div class="card rounded-2xl px-6 py-3 text-center"><p class="text-2xl font-bold text-wine">{{ $mineCount }}</p><p class="text-xs text-mute">آثارك</p></div>
        <div class="card rounded-2xl px-6 py-3 text-center"><p class="text-2xl font-bold text-wine">{{ count($savedIds) }}</p><p class="text-xs text-mute">خزانتك</p></div>
      </div>
    </div>
  </section>
  @endauth

  <section class="order-2" aria-label="الآثار">
    @auth
      <div id="tabs" role="tablist" class="mb-6 flex flex-wrap gap-2 text-sm">
        <button role="tab" data-tab="all" aria-selected="true" class="tab rounded-full border border-line bg-white/70 px-4 py-1.5 transition hover:border-wine">كل الآثار</button>
        <button role="tab" data-tab="mine" aria-selected="false" class="tab rounded-full border border-line bg-white/70 px-4 py-1.5 transition hover:border-wine">آثاري التي سطرتُها</button>
        <button role="tab" data-tab="saved" aria-selected="false" class="tab rounded-full border border-line bg-white/70 px-4 py-1.5 transition hover:border-wine">خزانتي المحفوظة</button>
      </div>
    @endauth
    @guest
      <h2 class="mb-6 font-amiri text-4xl font-bold text-wine">آخر ما أزهر</h2>
    @endguest

    <div id="views" role="tablist" class="mb-5 flex gap-2 text-sm">
      <button role="tab" data-view="list" aria-selected="true" class="tab rounded-full border border-line bg-white/70 px-4 py-1.5 transition hover:border-wine"><i class="fa-solid fa-table-cells-large ml-1"></i> القائمة</button>
      <button role="tab" data-view="garden" aria-selected="false" class="tab rounded-full border border-line bg-white/70 px-4 py-1.5 transition hover:border-wine"><i class="fa-solid fa-seedling ml-1"></i> حديقة الأثر</button>
    </div>
    
    <div id="garden" class="card hidden rounded-3xl p-6 sm:p-10" style="background:radial-gradient(120% 90% at 50% 10%, rgba(255,255,255,0.95), rgba(251,241,240,0.85))">
      <div class="text-center mb-6">
        <p class="font-amiri text-3xl font-bold text-wine">حديقة الأثر</p>
        <p class="mt-1 text-sm text-mute">اضغط على أي وردة لقراءة أثرها كاملاً.</p>
      </div>
      <div id="gardenField" class="flex flex-wrap items-center justify-center gap-5 py-6 min-h-[10rem]"></div>
    </div>

    <div id="grid" class="masonry columns-1 md:columns-2 lg:columns-3">
      <?php foreach($quotes as $quote): ?>
        <?php 
          $isSaved = in_array($quote->id, $savedIds); 
          $isMine = $in && Auth::id() === $quote->user_id;
          $hasAuthor = !empty($quote->author) && trim($quote->author) !== '' && $quote->author !== 'مجهول';
        ?>
        <article data-quote data-id="{{ $quote->id }}" data-content="{{ $quote->content }}" data-author="{{ $hasAuthor ? $quote->author : '' }}"
                 data-likes="{{ $quote->likes->count() }}" data-mine="{{ $isMine ? 1 : 0 }}" data-saved="{{ $isSaved ? 1 : 0 }}" class="card rounded-2xl p-6">

          <p class="qt text-xl">{{ $quote->content }}</p>
          <div class="mt-5 border-t border-line pt-4">
            @if($hasAuthor)
              <p class="text-sm text-wine font-medium">— {{ $quote->author }}</p>
            @endif
            <p class="mt-1 text-xs text-mute">بقلم {{ $quote->user->name ?? 'عضو' }} · {{ $quote->created_at->format('Y/m/d') }}</p>
            
            <div class="mt-4 flex items-center gap-2 text-sm">
              @auth
                @if(!$isMine)
                  <form action="{{ route('quotes.like', $quote) }}" method="POST">@csrf
                    <button class="flex items-center gap-1.5 rounded-full border border-line px-3 py-1.5 transition hover:border-wine hover:text-wine" aria-label="إعجاب">
                      <i class="{{ $quote->likes->contains('user_id', Auth::id()) ? 'fa-solid text-rose' : 'fa-regular' }} fa-heart"></i> {{ $quote->likes->count() }}
                    </button>
                  </form>
                @else
                  <span class="flex items-center gap-1.5 rounded-full border border-line/50 px-3 py-1.5 text-mute cursor-default" title="لا يمكنك الإعجاب بأثرك الخاص">
                    <i class="fa-solid fa-heart text-rose/60"></i> {{ $quote->likes->count() }}
                  </span>
                @endif

                <form action="{{ route('quotes.bookmark', $quote) }}" method="POST">@csrf
                  <button class="grid h-9 w-9 place-items-center rounded-full border transition hover:border-wine {{ $isSaved ? 'border-wine bg-wine text-white' : 'border-line' }}" aria-label="{{ $isSaved ? 'إزالة من الخزانة' : 'حفظ في الخزانة' }}">
                    <i class="{{ $isSaved ? 'fa-solid' : 'fa-regular' }} fa-bookmark"></i></button>
                </form>
              @endauth

              @guest
                <a href="{{ route('login') }}" class="flex items-center gap-1.5 rounded-full border border-line px-3 py-1.5 text-mute" title="سجّل الدخول للتفاعل"><i class="fa-regular fa-heart"></i> {{ $quote->likes->count() }}</a>
                <a href="{{ route('login') }}" class="grid h-9 w-9 place-items-center rounded-full border border-line text-mute" aria-label="احفظ"><i class="fa-regular fa-bookmark"></i></a>
              @endguest

              <button type="button" onclick="exportQuote(this)" class="flex items-center gap-1.5 rounded-full border border-line px-3 py-1.5 transition hover:border-wine hover:text-wine"><i class="fa-solid fa-image"></i> تصدير</button>
              
              @if($isMine)
                <button type="button" onclick="editQuote('{{ $quote->id }}', '{{ addslashes($quote->content) }}', '{{ addslashes($quote->author ?? '') }}')" class="grid h-8 w-8 place-items-center rounded-full text-mute transition hover:text-wine" title="تعديل الأثر">
                  <i class="fa-regular fa-pen-to-square"></i>
                </button>
                <form action="{{ route('quotes.destroy', $quote) }}" method="POST" class="mr-auto" onsubmit="return confirm('هل تريد حذف هذا الأثر نهائياً؟')">@csrf @method('DELETE')
                  <button class="grid h-8 w-8 place-items-center rounded-full text-mute transition hover:text-rose" aria-label="حذف"><i class="fa-regular fa-trash-can"></i></button>
                </form>
              @endif
            </div>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
    <p id="empty" class="{{ $all->isEmpty() ? '' : 'hidden' }} py-16 text-center font-amiri text-2xl text-mute">لا آثار هنا بعد.</p>
  </section>

  @if(!empty($masters) && count($masters))
  <section id="masters" class="order-3" aria-labelledby="mTitle">
    <div class="relative overflow-hidden rounded-3xl p-6 sm:p-8 mb-8 flex flex-col sm:flex-row items-center justify-between gap-4 border border-[#8e1730]/40 shadow-xl"
         style="background: radial-gradient(circle at 50% 50%, #7a1024 0%, #4a0513 100%);">
      
      <div class="pointer-events-none absolute inset-0 opacity-20 mix-blend-color-dodge" 
           style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" stroke=\"%23fbcfe8\" stroke-width=\"1.4\" stroke-opacity=\"0.65\"%3E%3Cpath d=\"M30 0 L60 30 L30 60 L0 30 Z\"/%3E%3Cpath d=\"M0 0 L30 30 L0 60 Z\"/%3E%3Cpath d=\"M60 0 L30 30 L60 60 Z\"/%3E%3Ccircle cx=\"30\" cy=\"30\" r=\"8\" fill=\"%23e11d48\" fill-opacity=\"0.3\"/%3E%3Ccircle cx=\"30\" cy=\"30\" r=\"16\"/%3E%3Cpath d=\"M0 0 L60 60 M60 0 L0 60\" stroke=\"%23fda4af\" stroke-width=\"0.8\"/%3E%3C/g%3E%3C/svg%3E'); background-repeat: repeat;">
      </div>

      <div class="relative z-10 text-center sm:text-right">
        <h2 id="mTitle" class="font-amiri text-4xl font-bold text-[#fff4f2] drop-shadow-md">سِيَر وفنون</h2>
        <p class="mt-1 text-[#ffdada] text-sm font-medium">حكايات من صنعوا الجمال بالحرف واللون والصوت والفكرة.</p>
      </div>
      
      <span class="relative z-10 font-amiri text-xl text-[#fff4f2] border border-[#f43f5e]/50 px-6 py-2 rounded-full bg-white/10 backdrop-blur-md shadow-inner">
        أثرٌ خالد
      </span>
    </div>

    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
      <?php foreach($masters as $m): ?>
        <?php 
          $mid = data_get($m,'id'); 
          $mname = data_get($m,'name'); 
          $myears = data_get($m,'years');
          $mtitle = data_get($m,'title');
          $mquote = data_get($m,'quote');
          $mstory = data_get($m,'story');
          $mimg = data_get($m,'image');
        ?>
        <article data-quote data-id="m{{ $mid }}" data-content="{{ $mquote }}" data-author="{{ $mname }}" class="card flex flex-col justify-between rounded-3xl p-6 text-right transition duration-300 hover:shadow-xl">
          <div>
            <div class="oil mx-auto h-44 w-36 rounded-[50%] border-2 border-wine/40 shadow-md mb-4 overflow-hidden">
              <img src="{{ $mimg }}" alt="{{ $mname }}" loading="lazy" onerror="this.style.display='none'">
            </div>
            
            <p class="text-[11px] text-mute font-medium text-center mb-1">{{ $myears }}</p>
            <h3 class="text-lg font-bold text-wine text-center leading-snug">{{ $mname }}</h3>
            <p class="font-amiri text-sm text-wine/80 text-center italic mt-1 font-semibold leading-relaxed">«{{ $mtitle }}»</p>
            
            <div class="mt-3 pt-3 border-t border-line/60">
              <p class="qt text-sm text-ink line-clamp-3 leading-relaxed">«{{ $mquote }}»</p>
            </div>
          </div>

          <div class="mt-5 pt-3 border-t border-line/40 flex flex-col gap-2">
            <button type="button" onclick="openMasterStory('{{ addslashes($mname) }}', '{{ addslashes($mtitle) }}', '{{ addslashes($myears) }}', '{{ addslashes($mstory) }}', '{{ $mimg }}')" class="w-full text-center text-xs font-semibold text-rose hover:text-wine transition py-1">
              اقرأ الحكاية ←
            </button>
            <div class="flex gap-2 text-xs w-full justify-center">
              <button type="button" onclick="exportQuote(this)" class="flex-1 flex items-center justify-center gap-1.5 rounded-full border border-line px-3 py-1.5 transition hover:border-wine hover:text-wine"><i class="fa-solid fa-image"></i> تصدير</button>
              @auth
              <button type="button" data-msave="{{ $mid }}" class="flex items-center justify-center gap-1.5 rounded-full border border-line px-3 py-1.5 transition hover:border-wine hover:text-wine"><i class="fa-regular fa-bookmark"></i> <span>احفظ</span></button>
              @endauth
            </div>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </section>
  @endif

  <section id="books" class="order-4" aria-labelledby="bTitle">
    <h2 id="bTitle" class="font-amiri text-4xl font-bold text-wine">رفّ الكتب</h2>
    <p class="mb-8 mt-2 text-mute">اختر كتاباً واقرأ ما التُقط من درره التراثية.</p>
    <div class="flex flex-wrap items-end gap-4" id="shelf">
      <?php foreach($books as $i => $bk): ?>
        <button type="button" data-book="{{ $i }}" aria-pressed="{{ $i === 0 ? 'true' : 'false' }}" class="book" style="background:linear-gradient(160deg,{{ $bk['c'][0] }},{{ $bk['c'][1] }})">
          <span class="font-amiri text-xl font-bold leading-snug">{{ $bk['title'] }}</span>
          <span class="text-xs opacity-80">{{ $bk['author'] }}</span>
        </button>
      <?php endforeach; ?>
    </div>
    <div class="mt-8">
      <?php foreach($books as $i => $bk): ?>
        <div data-bookpanel="{{ $i }}" class="{{ $i === 0 ? '' : 'hidden' }} grid gap-4 sm:grid-cols-2">
          <?php foreach($bk['quotes'] as $j => $bq): ?>
            <article data-quote data-id="b{{ $i }}-{{ $j }}" data-content="{{ $bq }}" data-author="{{ $bk['author'] }} — {{ $bk['title'] }}" class="card rounded-2xl p-6">
              <p class="qt text-2xl text-wine">«{{ $bq }}»</p>
              <p class="mt-3 text-sm text-mute">من كتاب «{{ $bk['title'] }}» — {{ $bk['author'] }}</p>
              <button type="button" onclick="exportQuote(this)" class="mt-4 flex items-center gap-1.5 rounded-full border border-line px-3 py-1.5 text-sm transition hover:border-wine hover:text-wine"><i class="fa-solid fa-image"></i> تصدير كأثر</button>
            </article>
          <?php endforeach; ?>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <section id="store" class="order-5" aria-labelledby="sTitle">
    <div class="card rounded-3xl p-6 sm:p-10 border border-line">
      <div class="max-w-xl">
        <h2 id="sTitle" class="font-amiri text-4xl font-bold text-wine">متجر الأثر</h2>
        <p class="mt-2 text-mute text-sm">اكتب أي جملة أو اقتباس تُحبه، شاهد معاينته فوراً على المنتج واطلبه بضغطة زر عبر واتساب.</p>
      </div>

      <div class="mt-6 max-w-xl">
        <label class="block text-sm font-medium text-mute mb-2">اكتب نصك الخاص للمعاينة والطلب:</label>
        <textarea id="customStoreText" rows="2" maxlength="120" placeholder="اكتب هنا ما يلامس قلبك..." class="qt w-full resize-none rounded-xl border border-line bg-paper/60 p-3 text-ink outline-none focus:border-wine">أثَرُ الحرفِ حينَ يُزهِر</textarea>
      </div>

      <div class="mt-8 grid gap-6 sm:grid-cols-3">
        <?php 
        $prods = [
          ['mug', 'كوب خزفي فاخر'],
          ['tote', 'حقيبة قماشية أنيقة'],
          ['bmark', 'فاصل كتاب مخملي']
        ];
        foreach($prods as $pr): ?>
          <div class="card flex flex-col items-center rounded-2xl p-5" data-prod="<?= $pr[1] ?>">
            <div class="mockbox"><div class="<?= $pr[0] ?>"><p class="mt"></p></div></div>
            <p class="mt-3 font-semibold text-wine"><?= $pr[1] ?></p>
            <a target="_blank" rel="noopener" class="store-wa-btn wine-btn mt-4 rounded-full px-5 py-2 text-sm font-semibold flex items-center gap-1.5"><i class="fa-brands fa-whatsapp"></i> اطلب الآن</a>
          </div>
        <?php endforeach; ?>
      </div>
      <p class="mt-6 text-xs text-mute">خدمة الطلب السريع: <span dir="ltr" class="font-semibold text-wine">0566334938</span></p>
    </div>
  </section>
</main>

<div id="player" class="card fixed bottom-6 right-6 z-40 flex items-center gap-3 rounded-full py-2 pl-4 pr-2 shadow-xl">
  <audio id="ambient" loop preload="none" src="{{ asset('audio/piano.mp3') }}"></audio>
  <button id="playBtn" type="button" aria-label="تشغيل الموسيقى" class="wine-btn grid h-10 w-10 place-items-center rounded-full"><i class="fa-solid fa-play"></i></button>
  <span class="hidden text-sm sm:inline font-medium text-wine"> </span>
  <span class="eq flex h-4 items-end gap-[3px]" aria-hidden="true"><i></i><i></i><i></i><i></i></span>
</div>

@auth
  <button id="fab" type="button" aria-label="إضافة اقتباس" class="wine-btn fixed bottom-6 left-6 z-40 grid h-14 w-14 place-items-center rounded-full text-2xl shadow-xl transition hover:scale-105"><i class="fa-solid fa-plus"></i></button>
  <div id="modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-wine/40 p-4 backdrop-blur-sm" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
    <form id="quoteForm" action="{{ route('quotes.store') }}" method="POST" novalidate class="pop max-h-[92vh] w-full max-w-lg overflow-y-auto rounded-3xl border border-line bg-white p-6 shadow-2xl sm:p-8">
      @csrf

      <div class="mb-5 flex items-center justify-between">
        <h2 id="modalTitle" class="text-xl font-semibold text-wine">أضف أثراً جديداً</h2>
        <button type="button" id="closeModal" class="grid h-9 w-9 place-items-center rounded-full text-mute hover:text-ink" aria-label="إغلاق"><i class="fa-solid fa-xmark"></i></button>
      </div>

      <label class="mb-1 block text-sm text-mute" for="content">النص <span class="text-rose">*</span></label>
      <textarea id="content" name="content" rows="4" minlength="3" maxlength="155" placeholder="من ٣ إلى ١٥٥ حرفاً" required class="qt w-full resize-none rounded-xl border border-line bg-paper p-4 text-lg outline-none focus:border-wine">{{ old('content') }}</textarea>
      <div class="mb-1 mt-1 flex justify-between text-xs"><span id="contentErr" class="text-rose">@error('content') {{ $message }} @enderror</span><span id="count" class="text-mute">0 / 155</span></div>
      
      <label class="mb-1 mt-3 block text-sm text-mute" for="author">القائل (اختياري)</label>
      <input id="author" name="author" value="{{ old('author') }}" maxlength="100" placeholder="اتركه فارغاً إن لم ترغب بذكره" class="w-full rounded-xl border border-line bg-paper p-3 outline-none focus:border-wine">
      
      <button class="wine-btn mt-6 w-full rounded-full py-3 font-semibold shadow">انشر الأثر</button>
    </form>
  </div>

  <div id="editModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-wine/40 p-4 backdrop-blur-sm" role="dialog" aria-modal="true">
    <form id="editQuoteForm" method="POST" class="pop w-full max-w-lg rounded-3xl border border-line bg-white p-6 shadow-2xl sm:p-8">
      @csrf @method('PUT')
      <div class="mb-4 flex items-center justify-between">
        <h2 class="text-xl font-semibold text-wine">تعديل الأثر</h2>
        <button type="button" onclick="closeEditModal()" class="grid h-9 w-9 place-items-center rounded-full text-mute hover:text-ink"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <label class="mb-1 block text-sm text-mute">النص</label>
      <textarea id="editContent" name="content" rows="4" minlength="3" maxlength="155" required class="qt w-full resize-none rounded-xl border border-line bg-paper p-4 text-lg outline-none focus:border-wine"></textarea>
      <label class="mb-1 mt-3 block text-sm text-mute">القائل (اختياري)</label>
      <input id="editAuthor" name="author" maxlength="100" class="w-full rounded-xl border border-line bg-paper p-3 outline-none focus:border-wine">
      <button class="wine-btn mt-6 w-full rounded-full py-3 font-semibold shadow">حفظ التعديلات</button>
    </form>
  </div>
@endauth

<div id="storyModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-wine/40 p-4 backdrop-blur-sm" role="dialog" aria-modal="true">
  <div class="pop relative w-full max-w-lg overflow-hidden rounded-3xl border border-line bg-white p-6 shadow-2xl sm:p-8 text-center">
    <button type="button" onclick="closeMasterStory()" class="absolute top-4 left-4 grid h-8 w-8 place-items-center rounded-full text-mute hover:text-wine" aria-label="إغلاق"><i class="fa-solid fa-xmark"></i></button>
    
    <div class="oil mx-auto h-32 w-28 rounded-[50%] border-2 border-wine/40 shadow-md mb-3 overflow-hidden">
      <img id="modalStoryImg" src="" alt="" class="w-full h-full object-cover">
    </div>
    <p id="modalStoryYears" class="text-xs text-mute font-medium"></p>
    <h3 id="modalStoryName" class="font-amiri text-2xl font-bold text-wine mt-1"></h3>
    <p id="modalStoryTitle" class="text-xs text-rose font-semibold italic mt-0.5 mb-4"></p>
    
    <div class="rounded-2xl bg-paper/60 p-4 border border-line text-right">
      <p id="modalStoryBody" class="font-amiri text-base leading-loose text-ink"></p>
    </div>
    
    <button type="button" onclick="closeMasterStory()" class="wine-btn mt-5 rounded-full px-8 py-2 text-sm font-semibold shadow">إغلاق الحكاية</button>
  </div>
</div>

<div id="viewer" class="fixed inset-0 z-50 hidden items-center justify-center bg-wine/40 p-4 backdrop-blur-sm">
  <div class="pop relative w-full max-w-md">
    <button type="button" id="closeViewer" class="absolute -top-3 left-0 z-10 grid h-9 w-9 place-items-center rounded-full bg-white text-wine shadow" aria-label="إغلاق"><i class="fa-solid fa-xmark"></i></button>
    <div id="viewerBody"></div>
  </div>
</div>

<div aria-hidden="true" style="position:fixed;left:-10000px;top:0;">
  <div id="story" style="width:1080px;height:1920px;position:relative;overflow:hidden;direction:rtl;display:flex;flex-direction:column;justify-content:center;align-items:center;padding:140px 110px;box-sizing:border-box;background:radial-gradient(900px 700px at 80% 5%,rgba(192,40,58,.18),transparent 65%),radial-gradient(800px 700px at 10% 100%,rgba(110,15,34,.14),transparent 65%),#fffdfa;color:#2b0d13;">
    <div style="position:absolute;inset:48px;border:2px solid rgba(110,15,34,.55);border-radius:36px;"></div>
    <div style="position:absolute;inset:66px;border:1px solid rgba(110,15,34,.22);border-radius:24px;"></div>
    <svg width="150" height="150" class="text-rose animate-[spin_20s_linear_infinite]" style="margin-bottom:60px"><use href="#rosette"/></svg>
    <p id="storyText" style="font-family:'Amiri',serif;line-height:2.1;text-align:center;margin:0;color:#4a0a16;"></p>
    <div style="width:140px;height:2px;background:#9b1c34;margin:70px 0 36px;"></div>
    <p id="storyAuthor" style="font-family:'IBM Plex Sans Arabic',sans-serif;font-size:42px;color:#9b1c34;margin:0;"></p>
    <div style="position:absolute;bottom:130px;text-align:center;">
      <div style="font-family:'Amiri',serif;font-size:64px;font-weight:700;line-height:1;color:#6e0f22;">رَقْش</div>
      <div style="font-family:'IBM Plex Sans Arabic',sans-serif;font-size:26px;color:#7d5a61;margin-top:14px;">أثَرُ الحرفِ حينَ يُزهِر</div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
(function () {
  const $ = (s, r = document) => r.querySelector(s);

  const storeInput = $('#customStoreText');
  const WA = '966566334938';
  function updateStore() {
    const val = (storeInput ? storeInput.value.trim() : '') || 'أثَرُ الحرفِ حينَ يُزهِر';
    document.querySelectorAll('[data-prod]').forEach(p => {
      p.querySelector('.mt').textContent = val;
      p.querySelector('.store-wa-btn').href = 'https://wa.me/' + WA + '?text=' + encodeURIComponent('مرحباً، أرغب بطلب (' + p.dataset.prod + ') مطبوعٍ عليه هذا النص:\n«' + val + '»');
    });
  }
  if (storeInput) { storeInput.addEventListener('input', updateStore); updateStore(); }

  const cards = [...document.querySelectorAll('#grid [data-quote]')], empty = $('#empty');
  let tab = 'all', view = 'list';
  try { tab = sessionStorage.getItem('raqsh-tab') || 'all'; } catch (e) {}
  try { view = sessionStorage.getItem('raqsh-view') || 'list'; } catch (e) {}

  function apply() {
    let n = 0;
    cards.forEach(c => {
      const ok = tab === 'all' || (tab === 'mine' && c.dataset.mine === '1') || (tab === 'saved' && c.dataset.saved === '1');
      c.classList.toggle('hidden', !ok); if (ok) n++;
    });
    if (cards.length && empty) empty.classList.toggle('hidden', n > 0);
    
    if (view === 'garden') {
      renderGarden();
    }
  }

  document.querySelectorAll('#tabs [data-tab]').forEach(b => {
    b.setAttribute('aria-selected', b.dataset.tab === tab ? 'true' : 'false');
    b.addEventListener('click', () => {
      tab = b.dataset.tab; 
      try { sessionStorage.setItem('raqsh-tab', tab); } catch (e) {}
      document.querySelectorAll('#tabs [data-tab]').forEach(x => x.setAttribute('aria-selected', x === b ? 'true' : 'false')); 
      apply();
    });
  });

  function tinyRoseSvg(likes) {
    const size = 15 + Math.min(likes, 8) * 1.2;
    return `
      <svg class="garden-rose-node cursor-pointer" viewBox="0 0 100 100" width="${size}" height="${size}" style="animation-delay: ${(Math.random() * -3).toFixed(1)}s">
        <g transform="translate(50,50)">
          <circle cx="0" cy="0" r="46" fill="#881337" />
          <circle cx="-16" cy="-16" r="22" fill="#be123c" />
          <circle cx="16" cy="-16" r="22" fill="#9f1239" />
          <circle cx="16" cy="16" r="22" fill="#e11d48" />
          <circle cx="-16" cy="16" r="22" fill="#be123c" />
          <circle cx="0" cy="0" r="20" fill="#f43f5e" />
          <circle cx="0" cy="0" r="10" fill="#fb7185" />
          <circle cx="0" cy="0" r="4" fill="#ffffff" opacity="0.85" />
        </g>
      </svg>
    `;
  }

  function renderGarden() {
    const f = $('#gardenField'); f.replaceChildren();
    const vis = cards.filter(c => !c.classList.contains('hidden'));
    if (!vis.length) { f.innerHTML = '<p class="py-10 font-amiri text-2xl text-mute">الحديقة فارغة في هذا التبويب.</p>'; return; }
    
    vis.forEach((c) => {
      const l = +c.dataset.likes || 0;
      const b = document.createElement('div');
      b.className = 'flex flex-col items-center gap-1 transition';
      b.title = c.dataset.content.slice(0, 50);
      
      b.innerHTML = tinyRoseSvg(l) + `
        <span class="inline-flex items-center gap-0.5 text-[9px] font-medium px-1.5 py-0.2 rounded-full bg-rose/10 text-rose border border-rose/20 leading-none">
          <i class="fa-solid fa-heart text-[8px]"></i> ${l}
        </span>
      `;

      b.querySelector('svg').addEventListener('click', () => {
        const cl = c.cloneNode(true); cl.classList.remove('hidden'); cl.classList.add('bg-white');
        $('#viewerBody').replaceChildren(cl); $('#viewer').classList.remove('hidden'); $('#viewer').classList.add('flex');
      });

      f.appendChild(b);
    });
  }

  function setView(v) {
    view = v; try { sessionStorage.setItem('raqsh-view', v); } catch (e) {}
    $('#grid').classList.toggle('hidden', v === 'garden'); 
    $('#garden').classList.toggle('hidden', v !== 'garden');
    document.querySelectorAll('#views [data-view]').forEach(x => x.setAttribute('aria-selected', x.dataset.view === v ? 'true' : 'false'));
    apply();
  }
  document.querySelectorAll('#views [data-view]').forEach(x => x.addEventListener('click', () => setView(x.dataset.view)));
  
  setView(view);

  if ($('#closeViewer')) $('#closeViewer').addEventListener('click', () => { $('#viewer').classList.add('hidden'); $('#viewer').classList.remove('flex'); });

  document.querySelectorAll('[data-book]').forEach(b => b.addEventListener('click', () => {
    document.querySelectorAll('[data-book]').forEach(x => x.setAttribute('aria-pressed', x === b ? 'true' : 'false'));
    document.querySelectorAll('[data-bookpanel]').forEach(p => p.classList.toggle('hidden', p.dataset.bookpanel !== b.dataset.book));
  }));

  const modal = $('#modal');
  if (modal) {
    const content = $('#content'), count = $('#count');
    $('#fab').addEventListener('click', () => { modal.classList.remove('hidden'); modal.classList.add('flex'); content.focus(); });
    $('#closeModal').addEventListener('click', () => { modal.classList.add('hidden'); modal.classList.remove('flex'); });
    content.addEventListener('input', () => { count.textContent = content.value.length + ' / 155'; });
  }

  window.editQuote = function(id, content, author) {
    const em = $('#editModal');
    $('#editQuoteForm').action = '/quotes/' + id;
    $('#editContent').value = content;
    $('#editAuthor').value = (!author || author === 'مجهول') ? '' : author;
    em.classList.remove('hidden'); em.classList.add('flex');
  };
  window.closeEditModal = function() {
    $('#editModal').classList.add('hidden'); $('#editModal').classList.remove('flex');
  };

  window.openMasterStory = function(name, title, years, story, img) {
    const sm = $('#storyModal');
    $('#modalStoryName').textContent = name;
    $('#modalStoryTitle').textContent = '«' + title + '»';
    $('#modalStoryYears').textContent = years;
    $('#modalStoryBody').textContent = story;
    $('#modalStoryImg').src = img;
    sm.classList.remove('hidden'); sm.classList.add('flex');
  };
  window.closeMasterStory = function() {
    $('#storyModal').classList.add('hidden'); $('#storyModal').classList.remove('flex');
  };

  const audio = $('#ambient'), player = $('#player'), btn = $('#playBtn');
  if (btn) {
    btn.addEventListener('click', () => {
      if (audio.paused) { audio.play(); player.classList.add('playing'); btn.innerHTML = '<i class="fa-solid fa-pause"></i>'; }
      else { audio.pause(); player.classList.remove('playing'); btn.innerHTML = '<i class="fa-solid fa-play"></i>'; }
    });
  }

  window.exportQuote = async function (b) {
    const card = b.closest('[data-quote]'), text = card.dataset.content, author = card.dataset.author, t = $('#storyText');
    t.textContent = text; 
    $('#storyAuthor').textContent = author ? '— ' + author : '';
    const old = b.innerHTML; b.disabled = true; b.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';
    try {
      const c = await html2canvas($('#story'), { scale: 1, backgroundColor: '#fffdfa', useCORS: true });
      const a = document.createElement('a'); a.href = c.toDataURL('image/png'); a.download = 'raqsh.png'; a.click();
    } catch (err) { alert('تعذّر تصدير الصورة.'); }
    finally { b.disabled = false; b.innerHTML = old; }
  };
})();
</script>
@endsection