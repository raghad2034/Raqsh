<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'رَقْش | Raqsh — أثَرُ الحرفِ حينَ يُزهِر')</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400&family=IBM+Plex+Sans+Arabic:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<script>
  tailwind = { config: { theme: { extend: {
    fontFamily: { amiri: ['Amiri','serif'], plex: ['"IBM Plex Sans Arabic"','sans-serif'] },
    colors: { bg:'var(--bg)', paper:'var(--paper)', ink:'var(--ink)', mute:'var(--mute)', wine:'var(--wine)', wine2:'var(--wine2)', rose:'var(--rose)', line:'var(--line)' }
  } } } };
</script>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<style>
  :root { --bg:#fffdfa; --paper:#fbf1f0; --ink:#2b0d13; --mute:#7d5a61; --wine:#6e0f22; --wine2:#9b1c34; --rose:#c0283a; --line:rgba(110,15,34,.16); }
  html { scroll-behavior:smooth; }
  body { background:var(--bg); color:var(--ink); font-family:'IBM Plex Sans Arabic',sans-serif; overflow-x:hidden; }
  body::before { content:""; position:fixed; inset:0; z-index:0; pointer-events:none;
    background:radial-gradient(900px 520px at 90% -10%,rgba(192,40,58,.12),transparent 70%),radial-gradient(800px 480px at 0% 105%,rgba(110,15,34,.10),transparent 70%); }
  .card { background:rgba(255,255,255,.86); border:1px solid var(--line); backdrop-filter:blur(10px); -webkit-backdrop-filter:blur(10px); box-shadow:0 14px 34px -22px rgba(110,15,34,.55); }
  .qt { font-family:'Amiri',serif; line-height:2.05; }
  .wine-btn { background:linear-gradient(135deg,var(--wine2),var(--wine)); color:#fff4f2; }
  .tab[aria-selected="true"] { background:var(--wine); color:#fff; border-color:var(--wine); }
  :focus-visible { outline:2px solid var(--rose); outline-offset:3px; border-radius:8px; }
  .masonry { column-gap:1.25rem; } .masonry > * { break-inside:avoid; margin-bottom:1.25rem; }
  .hero { background:rgba(255,255,255,0.35); backdrop-filter:blur(6px); -webkit-backdrop-filter:blur(6px); border:1px solid var(--line); }
  .oil { position:relative; overflow:hidden; background:linear-gradient(160deg,var(--rose),var(--wine)); }
  .oil img { width:100%; height:100%; object-fit:cover; filter:saturate(1.15) contrast(1.08) sepia(.12); }
  #petals { position:fixed; inset:0; z-index:1; pointer-events:none; }
  #floaters { position:fixed; inset:0; z-index:0; overflow:hidden; pointer-events:none; }
  .fq { position:absolute; top:0; width:16rem; text-align:center; font-family:'Amiri',serif; color:#9b1c34; opacity:.22; line-height:1.9;
        animation:drift var(--d) linear var(--delay) infinite; transform:translate3d(0,105vh,0); }
  @keyframes drift { from { transform:translate3d(0,105vh,0) rotate(var(--r)); } to { transform:translate3d(var(--dx),-30vh,0) rotate(calc(var(--r) * -1)); } }
  @keyframes bloom { from { transform:scale(.6) rotate(-30deg); opacity:0; } to { transform:scale(1) rotate(0); opacity:1; } }
  .bloom { animation:bloom 1.8s cubic-bezier(.2,.8,.2,1) both; }
  @keyframes pop { from { transform:scale(.96); opacity:0; } to { transform:scale(1); opacity:1; } }
  .pop { animation:pop .22s ease-out both; }
  @keyframes eq { 0%,100% { transform:scaleY(.25); } 50% { transform:scaleY(1); } }
  .eq i { display:block; width:3px; height:16px; border-radius:2px; background:var(--rose); transform:scaleY(.25); transform-origin:bottom; }
  .playing .eq i { animation:eq 1s ease-in-out infinite; }
  .playing .eq i:nth-child(2) { animation-delay:.2s; } .playing .eq i:nth-child(3) { animation-delay:.45s; } .playing .eq i:nth-child(4) { animation-delay:.1s; }
  .book{position:relative;width:8.2rem;height:11rem;border-radius:.3rem .5rem .5rem .3rem;border-right:8px solid rgba(0,0,0,.28);color:#fff4f2;display:flex;flex-direction:column;justify-content:space-between;padding:.8rem .7rem;text-align:right;box-shadow:0 8px 16px -10px rgba(43,13,19,.7);transition:transform .25s,box-shadow .25s}
  .book[aria-pressed="true"]{transform:translateY(-12px);box-shadow:0 20px 30px -12px rgba(110,15,34,.65)}
  .gf{display:flex;flex-direction:column;align-items:center;gap:.15rem;transition:transform .2s}
  .gf:hover{transform:translateY(-8px)}
  .gf svg{transform-origin:50% 100%;animation:sway 5s ease-in-out infinite}
  @keyframes sway{0%,100%{transform:rotate(-2.5deg)}50%{transform:rotate(2.5deg)}}
  .mockbox{height:12rem;display:grid;place-items:center}
  .mt{font-family:'Amiri',serif;font-size:.8rem;line-height:1.6;text-align:center;color:var(--wine);display:-webkit-box;-webkit-line-clamp:5;-webkit-box-orient:vertical;overflow:hidden}
  .mug{position:relative;width:8rem;height:7.5rem;background:#fff;border:2px solid var(--wine);border-radius:.4rem .4rem 1.6rem 1.6rem;display:grid;place-items:center;padding:.6rem;box-shadow:inset -10px 0 18px rgba(110,15,34,.08)}
  .mug::after{content:"";position:absolute;left:-1.7rem;top:1.2rem;width:2rem;height:3.4rem;border:5px solid var(--wine);border-right:0;border-radius:2rem 0 0 2rem}
  .tote{position:relative;width:8rem;height:9rem;background:#f3e6d6;border:2px solid #d9c3a5;display:grid;place-items:center;padding:.6rem;margin-top:1.8rem}
  .tote::before{content:"";position:absolute;top:-2.2rem;left:1.6rem;right:1.6rem;height:2.4rem;border:4px solid #d9c3a5;border-bottom:0;border-radius:2rem 2rem 0 0}
  .bmark{width:4.4rem;height:10rem;background:linear-gradient(180deg,var(--wine2),var(--wine));clip-path:polygon(0 0,100% 0,100% 100%,50% 92%,0 100%);display:grid;place-items:center;padding:.5rem .3rem 1.4rem}
  .bmark .mt{color:#fff4f2;font-size:.7rem}
</style>
</head>

<body class="min-h-screen antialiased relative">
<svg width="0" height="0" style="position:absolute" aria-hidden="true">
  <symbol id="rosette" viewBox="0 0 100 100"><g fill="none" stroke="currentColor" stroke-width="1.6">
    <path id="petal" d="M50 50 C38 34 38 14 50 4 C62 14 62 34 50 50Z"/>
    <use href="#petal" transform="rotate(45 50 50)"/><use href="#petal" transform="rotate(90 50 50)"/>
    <use href="#petal" transform="rotate(135 50 50)"/><use href="#petal" transform="rotate(180 50 50)"/>
    <use href="#petal" transform="rotate(225 50 50)"/><use href="#petal" transform="rotate(270 50 50)"/>
    <use href="#petal" transform="rotate(315 50 50)"/>
    <circle cx="50" cy="50" r="5" fill="currentColor"/></g></symbol>
</svg>

<div id="floaters" aria-hidden="true"></div>
<canvas id="petals" aria-hidden="true"></canvas>

@yield('content')

<script>
(function () {
  const box = document.getElementById('floaters');
  if (box) {
    const quotesList = [
      'أثَرُ الحرفِ حينَ يُزهِر',
      'كلُّ حرفٍ وردةٌ تنتظر قارئاً',
      'ما كُتب بصدقٍ لا يمحوه الزمن',
      'المعاني مطروحةٌ في الطريق',
      'الحبُّ أوَّلُه هزلٌ وآخرُه جِدّ',
      'ورَقَشَ الكتابَ: أي زيّنه وأتمّه'
    ];
    const n = innerWidth < 640 ? 5 : 9;
    for (let i = 0; i < n; i++) {
      const e = document.createElement('div');
      e.className = 'fq';
      e.textContent = quotesList[i % quotesList.length];
      e.style.left = (4 + (i * 96 / n) % 88) + '%';
      e.style.fontSize = (1.05 + Math.random() * 0.8) + 'rem';
      e.style.setProperty('--d', (35 + Math.random() * 25) + 's');
      e.style.setProperty('--delay', (-Math.random() * 50) + 's');
      e.style.setProperty('--r', (Math.random() * 8 - 4) + 'deg');
      e.style.setProperty('--dx', (Math.random() * 80 - 40) + 'px');
      box.appendChild(e);
    }
  }

  const cv = document.getElementById('petals');
  if (!cv) return;
  const cx = cv.getContext('2d'), D = Math.min(devicePixelRatio || 1, 2);
  let W, H, ps = [];
  
  const roseColors = [
    { c1: '#881337', c2: '#e11d48', c3: '#4c0519' },
    { c1: '#9f1239', c2: '#f43f5e', c3: '#58081f' },
    { c1: '#be123c', c2: '#fb7185', c3: '#700924' }
  ];

  function createVelvetRose(size, p) {
    const k = document.createElement('canvas');
    k.width = k.height = size;
    const x = k.getContext('2d'), m = size / 2;

    for (let i = 0; i < 7; i++) {
      x.save(); x.translate(m, m); x.rotate((i * Math.PI * 2) / 7);
      const g = x.createRadialGradient(0, -m * 0.45, m * 0.1, 0, -m * 0.45, m * 0.5);
      g.addColorStop(0, p.c2); g.addColorStop(0.7, p.c1); g.addColorStop(1, p.c3);
      x.fillStyle = g; x.beginPath();
      x.ellipse(0, -m * 0.42, m * 0.38, m * 0.45, 0, 0, Math.PI * 2);
      x.fill(); x.restore();
    }
    for (let i = 0; i < 5; i++) {
      x.save(); x.translate(m, m); x.rotate((i * Math.PI * 2) / 5 + 0.4);
      x.fillStyle = p.c1; x.beginPath();
      x.ellipse(0, -m * 0.28, m * 0.28, m * 0.35, 0, 0, Math.PI * 2);
      x.fill(); x.restore();
    }
    for (let r = 0.55; r > 0.1; r *= 0.72) {
      x.save(); x.translate(m, m); x.rotate(r * 5);
      x.fillStyle = p.c2; x.beginPath();
      x.ellipse(r * m * 0.25, 0, r * m * 0.55, r * m * 0.45, 0, 0, Math.PI * 2);
      x.fill(); x.restore();
    }
    return k;
  }

  function createPetal(size, p) {
    const k = document.createElement('canvas');
    k.width = size; k.height = size * 1.35;
    const x = k.getContext('2d');
    const g = x.createLinearGradient(0, 0, 0, k.height);
    g.addColorStop(0, p.c2); g.addColorStop(1, p.c1);
    x.fillStyle = g;
    x.beginPath();
    x.moveTo(size / 2, 0);
    x.bezierCurveTo(size * 1.1, size * 0.35, size * 0.92, size * 1.15, size / 2, size * 1.3);
    x.bezierCurveTo(size * 0.08, size * 1.15, -size * 0.1, size * 0.35, size / 2, 0);
    x.fill();
    return k;
  }

  const generatedRoses = roseColors.map(c => createVelvetRose(100, c));
  const generatedPetals = roseColors.map(c => createPetal(46, c));

  function mk(init) {
    const isRose = Math.random() < 0.38;
    const s = isRose 
      ? generatedRoses[Math.floor(Math.random() * generatedRoses.length)]
      : generatedPetals[Math.floor(Math.random() * generatedPetals.length)];
    const sc = isRose ? (0.28 + Math.random() * 0.35) : (0.35 + Math.random() * 0.45);
    return {
      s, w: s.width * sc, h: s.height * sc,
      x: Math.random() * W,
      y: init ? Math.random() * H : -80,
      vy: 0.65 + Math.random() * 0.85,
      amp: 0.5 + Math.random() * 1.1,
      f: 0.6 + Math.random() * 1.2,
      p: Math.random() * 6.28,
      r: Math.random() * 6.28,
      vr: (Math.random() - 0.5) * 0.025,
      a: 0.65 + Math.random() * 0.35
    };
  }

  function size() {
    W = innerWidth; H = innerHeight;
    cv.width = W * D; cv.height = H * D;
    cv.style.width = W + 'px'; cv.style.height = H + 'px';
    cx.setTransform(D, 0, 0, D, 0, 0);
    const n = Math.round(Math.min(48, Math.max(22, W / 30)));
    ps = Array.from({ length: n }, () => mk(true));
  }

  function draw() {
    cx.clearRect(0, 0, W, H);
    ps.forEach(q => {
      cx.save();
      cx.globalAlpha = q.a;
      cx.translate(q.x, q.y);
      cx.rotate(q.r);
      cx.drawImage(q.s, -q.w / 2, -q.h / 2, q.w, q.h);
      cx.restore();
    });
  }

  let t = 0;
  function tick() {
    t += 0.016;
    ps.forEach(q => {
      q.y += q.vy;
      q.x += Math.sin(t * q.f + q.p) * q.amp;
      q.r += q.vr;
      if (q.y > H + 80) Object.assign(q, mk(false));
    });
    draw();
    requestAnimationFrame(tick);
  }

  size();
  window.addEventListener('resize', size);
  tick();
})();
</script>

@yield('scripts')
</body>
</html>