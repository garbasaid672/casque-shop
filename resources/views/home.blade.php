<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title>{{ site_name() }}</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<script>
    // Thème initial : même clé que le reste du site (localStorage 'theme'),
    // appliquée avant peinture pour éviter tout flash.
    (function () {
        try {
            var theme = localStorage.getItem('theme');
            var dark = theme === 'dark' || (!theme && window.matchMedia('(prefers-color-scheme: dark)').matches);
            document.documentElement.dataset.theme = dark ? 'dark' : 'light';
            document.documentElement.classList.toggle('dark', dark);
        } catch (e) {}
    })();
</script>
<style>
:root{--bg:#f1f4f9;--surface:#fff;--text:#0f172a;--muted:#5b6478;--line:#e3e8f0;--nav:rgba(255,255,255,.8);--yellow:#fbbf24;--blue:#0a84c6;--red:#e11d48;--navy:#050b24;--navy2:#0b4a6f;box-sizing:border-box;padding-top:env(safe-area-inset-top,0px);padding-bottom:env(safe-area-inset-bottom,0px)}
@media (prefers-color-scheme:dark){:root:not([data-theme="light"]){--bg:#0b1020;--surface:#141b30;--text:#f1f5f9;--muted:#9aa5bd;--line:#252e48;--nav:rgba(11,16,32,.8);color-scheme:dark}}
:root[data-theme="dark"]{--bg:#0b1020;--surface:#141b30;--text:#f1f5f9;--muted:#9aa5bd;--line:#252e48;--nav:rgba(11,16,32,.8);color-scheme:dark}
*{box-sizing:border-box;margin:0}
html{scroll-padding-top:env(safe-area-inset-top,0px);scroll-behavior:smooth}
html,body{overflow-x:clip}
img{max-width:100%}
body{font-family:Inter,system-ui,sans-serif;background:var(--bg);color:var(--text);line-height:1.5}
body::before{content:"";position:fixed;inset:0 0 auto;height:env(safe-area-inset-top,0px);background:var(--nav);backdrop-filter:blur(10px);z-index:60}
a{color:inherit;text-decoration:none}
button{font:inherit;cursor:pointer}
.wrap{max-width:1180px;margin:auto;padding:0 24px}
header{position:sticky;top:env(safe-area-inset-top,0px);z-index:50;background:var(--nav);backdrop-filter:blur(12px);border-bottom:1px solid var(--line)}
.bar{display:flex;align-items:center;justify-content:space-between;height:68px;gap:16px}
.logo{font-weight:800;font-size:24px;background:linear-gradient(90deg,#1d6fd6,#d99a1c);-webkit-background-clip:text;background-clip:text;color:transparent}
nav{display:flex;gap:30px}
nav a{position:relative;font-weight:500;color:var(--muted);padding:4px 0}
nav a::after{content:"";position:absolute;left:0;bottom:-2px;height:2px;width:0;background:var(--yellow);transition:width .25s}
nav a:hover,nav a.on{color:var(--text)}
nav a:hover::after,nav a.on::after{width:100%}
.tools{display:flex;align-items:center;gap:6px}
.ic{width:40px;height:40px;border-radius:50%;border:0;background:transparent;color:var(--text);display:grid;place-items:center;position:relative}
.ic:hover{background:var(--line)}
.ic svg{width:20px;height:20px}
.login{margin-left:6px;border:1.5px solid var(--text);background:transparent;color:var(--text);padding:8px 18px;border-radius:10px;font-weight:600;display:inline-block}
.login:hover{background:var(--text);color:var(--bg)}
.hello{font-size:14px;color:var(--muted);margin-right:4px}
.hero{position:relative;overflow:hidden;background:linear-gradient(150deg,var(--navy),#10204f 55%,var(--navy2));color:#fff;padding:90px 0 150px}
.blob{position:absolute;border-radius:50%;filter:blur(80px);pointer-events:none}
.b1{width:420px;height:420px;background:rgba(251,191,36,.3);right:6%;top:6%}
.b2{width:380px;height:380px;background:rgba(10,132,198,.45);left:-80px;bottom:-60px}
.grid{position:absolute;inset:0;opacity:.07;background-image:linear-gradient(#fff 1px,transparent 1px),linear-gradient(90deg,#fff 1px,transparent 1px);background-size:48px 48px;mask-image:radial-gradient(ellipse at 70% 40%,#000,transparent 70%)}
.hero .wrap{position:relative;display:grid;grid-template-columns:1.05fr .95fr;align-items:center;gap:40px}
.hero h1{font-size:clamp(38px,5.2vw,62px);line-height:1.08;font-weight:800;letter-spacing:-.025em}
.hero h1 em{font-style:normal;color:var(--yellow)}
.hero p.lead{margin-top:22px;font-size:19px;color:#c7d6ee;max-width:480px}
.cta{display:flex;gap:12px;margin-top:32px;flex-wrap:wrap}
.btn{padding:14px 26px;border-radius:12px;font-weight:700;border:2px solid transparent;transition:transform .2s,box-shadow .2s;display:inline-block}
.btn.y{background:var(--yellow);color:#111}
.btn.y:hover{transform:translateY(-2px);box-shadow:0 10px 24px rgba(251,191,36,.4)}
.btn.o{border-color:rgba(255,255,255,.4);color:#fff;background:transparent}
.btn.o:hover{background:rgba(255,255,255,.12)}
.trust{display:flex;gap:22px;margin-top:34px;flex-wrap:wrap;font-size:14px;color:#b8c8e4}
.trust span{display:flex;align-items:center;gap:8px}
.trust svg{width:18px;height:18px;color:var(--yellow)}
.stage{position:relative;display:grid;place-items:center}
.stage .hp{width:min(100%,430px);color:#e9eef7;filter:drop-shadow(0 30px 40px rgba(0,0,0,.5));animation:float 6s ease-in-out infinite}
.ring{position:absolute;border:1.5px solid rgba(251,191,36,.35);border-radius:50%;animation:pulse 3.6s ease-out infinite}
.ring:nth-child(2){animation-delay:1.2s}
.price-tag{position:absolute;right:2%;bottom:6%;background:#fff;color:#111;padding:10px 16px;border-radius:14px;box-shadow:0 14px 30px rgba(0,0,0,.35);font-size:13px}
.price-tag b{display:block;font-size:20px}
@keyframes float{50%{transform:translateY(-14px) rotate(-1.5deg)}}
@keyframes pulse{from{width:260px;height:260px;opacity:.9}to{width:520px;height:520px;opacity:0}}
.wave{position:absolute;bottom:-1px;left:0;width:100%;height:80px;display:block}
.wave path{fill:var(--bg)}
section{padding:56px 0 8px}
.head{display:flex;justify-content:space-between;align-items:end;margin-bottom:28px}
.head h2{font-size:32px;font-weight:800;letter-spacing:-.02em}
.head a{color:var(--blue);font-weight:600}
.head a:hover{text-decoration:underline}
.products{display:grid;grid-template-columns:repeat(4,1fr);gap:22px}
.card{background:var(--surface);border:1px solid var(--line);border-radius:18px;overflow:hidden;transition:transform .3s,box-shadow .3s}
.card:hover{transform:translateY(-6px);box-shadow:0 22px 44px rgba(15,23,42,.16)}
.pic{position:relative;aspect-ratio:1/1;display:grid;place-items:center;overflow:hidden}
.pic svg{width:70%;transition:transform .4s;filter:drop-shadow(0 14px 14px rgba(0,0,0,.25))}
.card:hover .pic svg{transform:scale(1.08) rotate(-2deg)}
.pic img{width:100%;height:100%;object-fit:cover}
.tag{position:absolute;top:12px;left:12px;background:var(--red);color:#fff;font-size:12px;font-weight:700;padding:4px 10px;border-radius:999px;z-index:2}
.info{padding:16px 18px 18px}
.info small{color:var(--muted);font-size:13px}
.info h3{font-size:17px;font-weight:700;margin:2px 0 6px}
.buy{display:flex;align-items:center;justify-content:space-between;margin-top:12px}
.pr{font-size:20px;font-weight:800}
.pr s{font-size:14px;color:var(--muted);font-weight:500;margin-left:6px}
.add{border:0;background:var(--text);color:var(--bg);width:42px;height:42px;border-radius:12px;display:grid;place-items:center;transition:background .2s,transform .2s}
.add:hover{background:var(--yellow);color:#111;transform:scale(1.08)}
.add svg{width:20px;height:20px;filter:none}
.cats{display:grid;grid-template-columns:repeat(3,1fr);gap:22px}
.cat{position:relative;height:240px;border-radius:20px;overflow:hidden;color:#fff;padding:24px;display:flex;flex-direction:column;justify-content:flex-end;transition:transform .3s}
.cat:hover{transform:translateY(-4px)}
.cat svg.bg{position:absolute;right:-20px;top:10px;width:62%;opacity:.9}
.cat img.ph{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;opacity:.45}
.cat h3{position:relative;font-size:24px;font-weight:800}
.cat p{position:relative;opacity:.85;font-size:14px}
.perks{display:grid;grid-template-columns:repeat(4,1fr);gap:18px}
.perk{display:flex;gap:14px;align-items:center;background:var(--surface);border:1px solid var(--line);border-radius:16px;padding:18px;transition:transform .2s}
.perk:hover{transform:translateY(-3px)}
.perk i{flex:none;width:46px;height:46px;border-radius:14px;background:rgba(251,191,36,.18);color:#b97d00;display:grid;place-items:center}
.perk svg{width:22px;height:22px}
.perk b{display:block;font-size:15px}
.perk span{font-size:13px;color:var(--muted)}
.empty{text-align:center;padding:48px 0;color:var(--muted)}
footer{margin-top:64px;background:var(--navy);color:#9fb0cf;padding:56px 0 28px;font-size:14px}
.fg{display:grid;grid-template-columns:1.6fr 1fr 1fr;gap:32px}
footer h4{color:#fff;margin-bottom:12px;font-size:15px}
footer li{list-style:none;margin:8px 0}
footer ul{padding:0}
footer a:hover{color:var(--yellow)}
.copy{margin-top:40px;padding-top:20px;border-top:1px solid rgba(255,255,255,.12);display:flex;justify-content:space-between;flex-wrap:wrap;gap:10px}
.copy a:hover{color:var(--yellow)}
.news-mini{margin-top:12px}
.news-mini p{font-size:13px;margin-bottom:8px}
.news-mini form{display:flex;gap:8px}
.news-mini input{flex:1;min-width:0;border:1px solid rgba(255,255,255,.2);background:rgba(255,255,255,.06);border-radius:10px;padding:10px 12px;font:inherit;color:#fff;font-size:13px}
.news-mini input::placeholder{color:#7d8db1}
.news-mini button{border:0;background:var(--yellow);color:#111;border-radius:10px;padding:0 16px;font-weight:700;font-size:13px}
:focus-visible{outline:3px solid var(--blue);outline-offset:2px}
@media (max-width:980px){.products,.perks{grid-template-columns:repeat(2,1fr)}.hero .wrap{grid-template-columns:1fr}.stage{order:-1;max-width:320px;margin:auto}.fg{grid-template-columns:1fr 1fr}nav{display:none}.cats{grid-template-columns:1fr}}
@media (max-width:560px){.products,.perks{grid-template-columns:1fr}.hero{padding:50px 0 120px}.wrap{padding:0 18px}.fg{grid-template-columns:1fr}.logo{font-size:19px}.login{padding:7px 12px;font-size:13px;margin-left:0}.bar{gap:8px}.head h2{font-size:24px}.price-tag{right:0}}
@media (prefers-reduced-motion:reduce){*{animation:none!important;transition:none!important}}
</style>
@php
// Réglages admin (Admin > Gestion > Accueil du site), valeurs sûres uniquement.
$homeBg = setting('home_bg', '#f1f4f9');
$heroFrom = setting('hero_from', '#050b24');
$heroTo = setting('hero_to', '#0b4a6f');
if (! preg_match('/^#[0-9a-fA-F]{6}$/', $homeBg)) { $homeBg = '#f1f4f9'; }
if (! preg_match('/^#[0-9a-fA-F]{6}$/', $heroFrom)) { $heroFrom = '#050b24'; }
if (! preg_match('/^#[0-9a-fA-F]{6}$/', $heroTo)) { $heroTo = '#0b4a6f'; }
$heroTitle = (string) setting('hero_title', 'Découvrez nos casques audio premium');
$heroHl = (string) setting('hero_highlight', 'casques audio');
$heroSub = (string) setting('hero_subtitle', 'Qualité sonore exceptionnelle, confort optimal et design moderne pour tous les audiophiles.');
$escHl = e($heroHl);
$heroH1 = ($escHl !== '') ? str_replace($escHl, '<em>'.$escHl.'</em>', e($heroTitle)) : e($heroTitle);
@endphp
<style>
/* Couleurs choisies par l'admin (mode clair ; le mode sombre garde son fond) */
:root{--bg:{{ $homeBg }};}
@media (prefers-color-scheme:dark){:root:not([data-theme="light"]){--bg:#0b1020;}}
</style>
</head>
<body>
<svg width="0" height="0" style="position:absolute" aria-hidden="true">
<defs>
<symbol id="hp" viewBox="0 0 200 200"><path d="M42 118V96a58 58 0 0 1 116 0v22" fill="none" stroke="currentColor" stroke-width="12" stroke-linecap="round"/><rect x="26" y="106" width="40" height="64" rx="20" fill="currentColor"/><rect x="134" y="106" width="40" height="64" rx="20" fill="currentColor"/><rect x="36" y="118" width="20" height="40" rx="10" fill="#000" opacity=".18"/><rect x="144" y="118" width="20" height="40" rx="10" fill="#000" opacity=".18"/></symbol>
<symbol id="bud" viewBox="0 0 200 200"><g fill="currentColor"><circle cx="70" cy="70" r="26"/><rect x="62" y="80" width="16" height="80" rx="8"/><circle cx="130" cy="70" r="26"/><rect x="122" y="80" width="16" height="80" rx="8"/></g></symbol>
<symbol id="spk" viewBox="0 0 200 200"><rect x="50" y="20" width="100" height="160" rx="20" fill="currentColor"/><circle cx="100" cy="70" r="16" fill="#000" opacity=".25"/><circle cx="100" cy="128" r="30" fill="#000" opacity=".25"/></symbol>
</defs>
</svg>

<header>
<div class="wrap bar">
<a href="{{ route('home') }}" class="logo">{{ site_name() }}</a>
<nav aria-label="Navigation principale"><a class="on" href="{{ route('home') }}">Accueil</a><a href="{{ route('shop.index') }}">Boutique</a><a href="{{ route('categories.index') }}">Catégories</a></nav>
<div class="tools">
<a class="ic" href="{{ route('shop.index') }}" aria-label="Rechercher"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg></a>
<button class="ic" id="theme" aria-label="Changer de thème"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8z"/></svg></button>
@auth
<span class="hello">Bonjour, {{ Auth::user()->name }}</span>
<form method="POST" action="{{ route('logout') }}" style="display:inline">
@csrf
<button type="submit" class="login">Déconnexion</button>
</form>
@else
<a class="login" href="{{ route('filament.admin.auth.login') }}">Connexion</a>
@endauth
</div>
</div>
</header>

<div class="hero" style="background:linear-gradient(150deg,{{ $heroFrom }},#10204f 55%,{{ $heroTo }})">
<div class="blob b1"></div><div class="blob b2"></div><div class="grid"></div>
<div class="wrap">
<div>
<h1>{!! $heroH1 !!}</h1>
<p class="lead">{{ $heroSub }}</p>
<div class="cta"><a href="#produits" class="btn y">Voir nos produits</a><a href="{{ route('shop.index') }}" class="btn o">Toute la boutique</a></div>
<div class="trust">
<span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 6h13v11H1zM14 10h5l3 3v4h-8z"/><circle cx="6" cy="18" r="2"/><circle cx="18" cy="18" r="2"/></svg>Livraison rapide</span>
<span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3 4 6v6c0 5 3.5 8 8 9 4.500-1 8-4 8-9V6z"/><path d="m9 12 2 2 4-4"/></svg>Garantie 2 ans</span>
<span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="10" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>Paiement sécurisé</span>
</div>
</div>
<div class="stage" aria-hidden="true">
<div class="ring"></div><div class="ring"></div>
<svg class="hp"><use href="#hp"/></svg>
@if($featuredProducts->isNotEmpty())
<div class="price-tag">Nouveau<b>{{ $featuredProducts->first()->name }}</b></div>
@endif
</div>
</div>
<svg class="wave" viewBox="0 0 1440 80" preserveAspectRatio="none" aria-hidden="true"><path d="M0 80V40C240 0 480 0 720 30s480 40 720 0v50z"/></svg>
</div>

<main class="wrap">
<section id="produits">
<div class="head"><h2>Produits vedettes</h2><a href="{{ route('shop.index') }}">Voir tout</a></div>
@if($featuredProducts->isEmpty())
<p class="empty">Aucun produit vedette pour le moment.</p>
@else
<div class="products">
@foreach($featuredProducts as $product)
<article class="card">
<div class="pic" style="background:#e9ecef;color:#8a93a6">
@if($product->compare_at_price && $product->compare_at_price > $product->price)
<span class="tag">-{{ $product->discount_percentage }} %</span>
@endif
@if($product->images && count($product->images) > 0)
<img src="{{ product_image_url($product->images[0]) }}" alt="{{ $product->name }}" loading="lazy">
@else
<svg><use href="#hp"/></svg>
@endif
</div>
<div class="info">
@if($product->category)
<small>{{ $product->category->name }}</small>
@endif
<h3>{{ $product->name }}</h3>
<div class="buy">
<div class="pr">{{ $product->price_fcfa }}@if($product->compare_at_price && $product->compare_at_price > $product->price)<s>{{ $product->compare_at_price_fcfa }}</s>@endif</div>
<a class="add" href="{{ route('product.show', $product) }}" aria-label="Voir {{ $product->name }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
</div>
</div>
</article>
@endforeach
</div>
@endif
</section>

@if($categories->isNotEmpty())
<section id="categories">
<div class="head"><h2>Nos catégories</h2><a href="{{ route('categories.index') }}">Tout voir</a></div>
<div class="cats">
@php
$grads = [
    'background:linear-gradient(135deg,#1d4ed8,#0b2a6f);color:#cfe0ff',
    'background:linear-gradient(135deg,#d99a1c,#a15c00);color:#fff2cf',
    'background:linear-gradient(135deg,#0e7490,#083a4d);color:#c9f1fb',
];
$icons = ['#hp', '#bud', '#spk'];
@endphp
@foreach($categories as $i => $category)
<a href="{{ route('category.show', $category) }}" class="cat" style="{{ $grads[$i % 3] }};background-blend-mode:normal">
@if($category->display_image)
<img class="ph" src="{{ product_image_url($category->display_image) }}" alt="{{ $category->name }}" loading="lazy">
@endif
<svg class="bg" style="color:inherit;opacity:.35"><use href="{{ $icons[$i % 3] }}"/></svg>
<h3>{{ $category->name }}</h3>
<p>{{ $category->products_count }} produit(s)</p>
</a>
@endforeach
</div>
</section>
@endif

@if($newProducts->isNotEmpty())
<section id="nouveautes">
<div class="head"><h2>Nouveautés</h2><a href="{{ route('shop.index') }}">Voir tout</a></div>
<div class="products">
@foreach($newProducts as $product)
<article class="card">
<div class="pic" style="background:#e9ecef;color:#8a93a6">
@if($product->compare_at_price && $product->compare_at_price > $product->price)
<span class="tag">-{{ $product->discount_percentage }} %</span>
@else
<span class="tag">Nouveau</span>
@endif
@if($product->images && count($product->images) > 0)
<img src="{{ product_image_url($product->images[0]) }}" alt="{{ $product->name }}" loading="lazy">
@else
<svg><use href="#hp"/></svg>
@endif
</div>
<div class="info">
@if($product->category)
<small>{{ $product->category->name }}</small>
@endif
<h3>{{ $product->name }}</h3>
<div class="buy">
<div class="pr">{{ $product->price_fcfa }}@if($product->compare_at_price && $product->compare_at_price > $product->price)<s>{{ $product->compare_at_price_fcfa }}</s>@endif</div>
<a class="add" href="{{ route('product.show', $product) }}" aria-label="Voir {{ $product->name }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
</div>
</div>
</article>
@endforeach
</div>
</section>
@endif

<section>
<div class="perks">
<a class="perk" href="{{ route('support.shipping') }}"><i><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 6h13v11H1zM14 10h5l3 3v4h-8z"/><circle cx="6" cy="18" r="2"/><circle cx="18" cy="18" r="2"/></svg></i><div><b>Livraison rapide</b><span>En savoir plus</span></div></a>
<a class="perk" href="{{ route('support.returns') }}"><i><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 1 0 3-6.700L3 8M3 3v5h5"/></svg></i><div><b>Retours 30 jours</b><span>En savoir plus</span></div></a>
<a class="perk" href="{{ route('support.warranty') }}"><i><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3 4 6v6c0 5 3.500 8 8 9 4.500-1 8-4 8-9V6z"/></svg></i><div><b>Garantie 2 ans</b><span>En savoir plus</span></div></a>
<a class="perk" href="{{ route('support.faq') }}"><i><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12a8 8 0 0 1-11.500 7.200L3 21l1.800-6A8 8 0 1 1 21 12z"/></svg></i><div><b>Support 7j/7</b><span>On vous répond vite</span></div></a>
</div>
</section>
</main>

<footer>
<div class="wrap">
<div class="fg">
<div>
<div class="logo" style="font-size:22px;display:inline-block">{{ site_name() }}</div>
<p style="margin-top:10px;max-width:280px">Votre spécialiste casques audio de qualité.</p>
<div class="news-mini">
<p>Inscrivez-vous pour nos offres exclusives.</p>
<form><input type="email" placeholder="Votre email" aria-label="Votre email"><button>S'inscrire</button></form>
</div>
</div>
<div><h4>Liens rapides</h4><ul><li><a href="{{ route('home') }}">Accueil</a></li><li><a href="{{ route('shop.index') }}">Boutique</a></li><li><a href="{{ route('categories.index') }}">Catégories</a></li><li><a href="{{ route('contact') }}">Contact</a></li></ul></div>
<div><h4>Support</h4><ul><li><a href="{{ route('support.faq') }}">FAQ</a></li><li><a href="{{ route('support.shipping') }}">Livraison</a></li><li><a href="{{ route('support.returns') }}">Retours</a></li><li><a href="{{ route('support.warranty') }}">Garantie</a></li></ul></div>
</div>
<div class="copy"><span>&copy; {{ date('Y') }} {{ site_name() }}. Tous droits réservés. · <a href="{{ route('filament.admin.auth.login') }}">Admin</a></span></div>
</div>
</footer>

<script>
// Thème : même clé 'theme' que le reste du site (clair/sombre persisté partout).
(function () {
    var root = document.documentElement;
    function apply(dark) {
        root.dataset.theme = dark ? 'dark' : 'light';
        root.classList.toggle('dark', dark);
        try { localStorage.setItem('theme', dark ? 'dark' : 'light'); } catch (e) {}
    }
    document.getElementById('theme').onclick = function () {
        apply(root.dataset.theme !== 'dark');
    };
})();
</script>
</body>
</html>
