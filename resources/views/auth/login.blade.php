<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title>Connexion - {{ site_name() }}</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<script>
    // Thème initial : même clé que le reste du site (localStorage 'theme').
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
body{font-family:Inter,system-ui,sans-serif;background:var(--bg);color:var(--text);line-height:1.5;min-height:100vh;display:flex;flex-direction:column}
a{color:inherit;text-decoration:none}
button{font:inherit;cursor:pointer}
.wrap{max-width:1180px;margin:auto;padding:0 24px}
header{position:sticky;top:env(safe-area-inset-top,0px);z-index:50;background:var(--nav);backdrop-filter:blur(12px);border-bottom:1px solid var(--line)}
.bar{display:flex;align-items:center;justify-content:space-between;height:68px;gap:16px}
.logo{font-weight:800;font-size:24px;background:linear-gradient(90deg,#1d6fd6,#d99a1c);-webkit-background-clip:text;background-clip:text;color:transparent}
.tools{display:flex;align-items:center;gap:6px}
.ic{width:40px;height:40px;border-radius:50%;border:0;background:transparent;color:var(--text);display:grid;place-items:center}
.ic:hover{background:var(--line)}
.ic svg{width:20px;height:20px}
.back{font-size:14px;font-weight:500;color:var(--muted)}
.back:hover{color:var(--text)}
main{flex:1;display:flex;align-items:center;justify-content:center;padding:48px 18px}
.card{width:100%;max-width:440px;background:var(--surface);border:1px solid var(--line);border-radius:20px;overflow:hidden;box-shadow:0 22px 44px rgba(15,23,42,.16)}
.banner{background:linear-gradient(150deg,var(--navy),#10204f 55%,var(--navy2));color:#fff;padding:32px;text-align:center}
.banner h1{font-size:26px;font-weight:800;letter-spacing:-.02em}
.banner h1 em{font-style:normal;color:var(--yellow)}
.banner p{margin-top:6px;font-size:14px;color:#c7d6ee}
.form{padding:28px}
.alert{background:rgba(225,29,72,.1);border:1px solid rgba(225,29,72,.35);color:var(--red);font-size:14px;border-radius:12px;padding:12px 16px;margin-bottom:20px}
.alert ul{padding-left:18px}
.field{margin-bottom:18px}
.field label{display:block;font-size:14px;font-weight:600;margin-bottom:8px}
.field input{width:100%;border:1.5px solid var(--line);background:var(--bg);color:var(--text);border-radius:12px;padding:13px 16px;font:inherit;font-size:15px}
.field input:focus{outline:none;border-color:var(--blue);box-shadow:0 0 0 3px rgba(10,132,198,.15)}
.check{display:flex;align-items:center;gap:8px;font-size:14px;color:var(--muted);margin-bottom:20px}
.check input{width:16px;height:16px;accent-color:var(--yellow)}
.submit{width:100%;border:0;background:var(--yellow);color:#111;font-weight:700;padding:14px;border-radius:12px;transition:transform .2s,box-shadow .2s}
.submit:hover{transform:translateY(-2px);box-shadow:0 10px 24px rgba(251,191,36,.4)}
footer{background:var(--navy);color:#9fb0cf;padding:24px 0;font-size:14px;text-align:center;margin-top:auto}
:focus-visible{outline:3px solid var(--blue);outline-offset:2px}
@media (prefers-reduced-motion:reduce){*{animation:none!important;transition:none!important}}
</style>
</head>
<body>

<header>
<div class="wrap bar">
<a href="{{ route('home') }}" class="logo">{{ site_name() }}</a>
<div class="tools">
<button class="ic" id="theme" aria-label="Changer de thème"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8z"/></svg></button>
<a href="{{ route('home') }}" class="back">&larr; Retour à l'accueil</a>
</div>
</div>
</header>

<main>
<div class="card">
<div class="banner">
<h1>Bon <em>retour</em> !</h1>
<p>Connectez-vous à votre compte {{ site_name() }}</p>
</div>
<div class="form">
@if ($errors->any())
<div class="alert">
<ul>
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif
<form method="POST" action="{{ route('login.post') }}">
@csrf
<div class="field">
<label for="email">Adresse email</label>
<input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="vous@exemple.com">
</div>
<div class="field">
<label for="password">Mot de passe</label>
<input type="password" id="password" name="password" required placeholder="Votre mot de passe">
</div>
<label class="check"><input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}> Se souvenir de moi</label>
<button type="submit" class="submit">Se connecter</button>
</form>
</div>
</div>
</main>

<footer>
<div class="wrap">&copy; {{ date('Y') }} {{ site_name() }}. Tous droits réservés.</div>
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
