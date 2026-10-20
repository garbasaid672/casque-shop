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
.nav-theme-toggle{display:none}
.mobile-menu-toggle{display:none;width:40px;height:40px;border:1px solid var(--line);border-radius:12px;background:var(--surface);color:var(--text);place-items:center}
.mobile-menu-toggle svg{width:20px;height:20px}
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
.stage{position:relative;display:grid;place-items:center;width:100%;margin:0}
.client-dashboard{width:min(100%,600px);padding:14px;border:1px solid rgba(255,255,255,.4);border-radius:24px;background:rgba(255,255,255,.18);box-shadow:0 28px 70px rgba(0,0,0,.3);backdrop-filter:blur(14px);transform:perspective(1200px) rotateY(-5deg) rotateX(2deg)}
.dashboard-browser{display:flex;align-items:center;gap:8px;margin-bottom:8px;padding:7px 10px;border:1px solid #d1d5db;border-radius:10px;background:#e5e7eb;color:#0284c7;font-size:9px}
.dashboard-browser-dots{display:flex;gap:3px;flex:none}
.dashboard-browser-dots i{width:6px;height:6px;border-radius:50%;background:#fb7185}
.dashboard-browser-dots i:nth-child(2){background:#fbbf24}.dashboard-browser-dots i:nth-child(3){background:#34d399}
.dashboard-browser-address{display:flex;align-items:center;gap:5px;min-width:0;flex:1;padding:4px 8px;border:1px solid #d1d5db;border-radius:6px;background:#f8fafc}
.dashboard-browser-address svg{width:10px;height:10px;flex:none;color:#64748b}
.dashboard-browser-url{overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.dashboard-window{overflow:hidden;padding:17px;border:1px solid #e4e9f1;border-radius:17px;background:#fff;color:#0f172a;box-shadow:0 12px 36px rgba(2,6,23,.14)}
.dashboard-layout{display:grid;grid-template-columns:130px minmax(0,1fr);gap:12px}
.dashboard-sidebar{padding:9px 8px;border:1px solid #e8edf3;border-radius:12px;background:#f8fafc}
.dashboard-side-brand{display:flex;align-items:center;gap:5px;margin:0 0 12px 2px;font-size:9px;font-weight:800}
.dashboard-side-brand .dashboard-brand-mark{width:20px;height:20px;flex:none}
.dashboard-menu-group{margin-top:10px}
.dashboard-menu-title{margin:0 0 4px 6px;color:#94a3b8;font-size:7px;font-weight:800;letter-spacing:.08em;text-transform:uppercase}
.dashboard-menu-item{display:flex;align-items:center;gap:6px;margin:2px 0;padding:5px 6px;border-radius:6px;color:#475569;font-size:8px;font-weight:600;white-space:nowrap}
.dashboard-menu-item svg{width:12px;height:12px;flex:none;color:#64748b}
.dashboard-menu-item.active{background:#e0f2fe;color:#0369a1}
.dashboard-menu-item.active svg{color:#0284c7}
.dashboard-main{min-width:0}
.dashboard-topbar,.dashboard-greeting,.dashboard-card-heading,.dashboard-order-row,.dashboard-order-item{display:flex;align-items:center;justify-content:space-between;gap:10px}
.dashboard-brand{display:flex;align-items:center;gap:8px;font-size:12px;font-weight:800}
.dashboard-brand-mark{display:grid;place-items:center;width:25px;height:25px;border-radius:8px;background:#e0f2fe;color:#0284c7}
.dashboard-brand-mark svg{width:15px;height:15px}
.dashboard-greeting{align-items:end;margin-top:14px}
.dashboard-greeting p{color:#64748b;font-size:10px}
.dashboard-greeting h2{margin-top:2px;font-size:16px;font-weight:800}
.dashboard-heading{margin-top:9px;font-size:12px;font-weight:800}
.dashboard-greeting a{padding:7px 10px;border-radius:8px;background:#0284c7;color:#fff;font-size:10px;font-weight:700}
.dashboard-kpis{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:8px;margin-top:13px}
.dashboard-kpi{padding:9px;border:1px solid #e8edf3;border-radius:10px;background:#f9fbfd}
.dashboard-kpi.compact{padding:6px;border-radius:8px}
.dashboard-kpi span{display:block;color:#64748b;font-size:9px}
.dashboard-kpi strong{display:block;margin-top:4px;font-size:13px;font-weight:800}
.dashboard-kpi.compact span{font-size:7px}
.dashboard-kpi.compact strong{margin-top:2px;font-size:9px}
.dashboard-content{display:grid;grid-template-columns:1.12fr .88fr;gap:9px;margin-top:9px}
.dashboard-panel{min-width:0;padding:10px;border:1px solid #e8edf3;border-radius:11px;background:#fff}
.dashboard-card-heading{font-size:10px;font-weight:800}
.dashboard-period{color:#64748b;font-size:8px;font-weight:500}
.dashboard-chart{display:block;width:100%;height:88px;margin-top:7px}
.dashboard-chart-line{animation:dashboardChartDraw 2.2s ease-out .3s forwards}
@keyframes dashboardChartDraw{to{stroke-dashoffset:0}}
.dashboard-chart-labels{display:flex;justify-content:space-between;color:#94a3b8;font-size:8px}
.dashboard-order-row{margin-top:9px;justify-content:flex-start;align-items:flex-start}
.dashboard-product-thumb{display:grid;flex:none;place-items:center;width:32px;height:32px;border-radius:9px;background:#eff6ff;color:#0284c7}
.dashboard-product-thumb svg{width:22px;height:22px}
.dashboard-order-item{min-width:0;flex:1;align-items:flex-start}
.dashboard-order-name{overflow:hidden;text-overflow:ellipsis;white-space:nowrap;font-size:9px;font-weight:700}
.dashboard-order-meta{margin-top:3px;color:#64748b;font-size:8px}
.dashboard-status{flex:none;padding:4px 6px;border-radius:99px;background:#dcfce7;color:#166534;font-size:8px;font-weight:800}
.dashboard-footer{display:flex;justify-content:space-between;gap:8px;margin-top:9px;padding-top:8px;border-top:1px solid #eef2f7;color:#64748b;font-size:8px}
.dashboard-footer strong{color:#0f172a}
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
.how-section{margin-top:34px;padding:38px;background:linear-gradient(145deg,rgba(10,132,198,.08),rgba(251,191,36,.12));border:1px solid var(--line);border-radius:26px;overflow:hidden}
.how-intro{max-width:680px;margin-bottom:30px}
.how-kicker{display:inline-flex;align-items:center;gap:8px;color:var(--blue);font-size:13px;font-weight:700;letter-spacing:.06em;text-transform:uppercase}
.how-intro h2,.reviews-intro h2{margin-top:8px;font-size:clamp(26px,4vw,36px);font-weight:800;line-height:1.15;letter-spacing:-.02em}
.how-intro p,.reviews-intro p{margin-top:10px;color:var(--muted)}
.how-grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:14px}
.how-step{position:relative;min-height:248px;padding:22px 18px;background:var(--surface);border:1px solid var(--line);border-radius:18px;box-shadow:0 8px 24px rgba(15,23,42,.06);transition:transform .25s,border-color .25s,box-shadow .25s}
.how-step:hover{transform:translateY(-4px);border-color:var(--blue);box-shadow:0 16px 32px rgba(15,23,42,.12)}
.how-step-number{display:grid;place-items:center;width:38px;height:38px;border-radius:12px;background:var(--yellow);color:#111;font-size:17px;font-weight:800}
.how-step-icon{display:grid;place-items:center;width:54px;height:54px;margin:18px 0 14px;border-radius:16px;background:rgba(10,132,198,.1);color:var(--blue)}
.how-step-icon svg{width:27px;height:27px}
.how-step h3{font-size:17px;font-weight:800;line-height:1.3}
.how-step p{margin-top:8px;color:var(--muted);font-size:14px}
.delivery-callout{margin-top:10px;padding:9px 10px;border-radius:10px;background:rgba(34,197,94,.1);color:#166534;font-size:12px;font-weight:700}
:root[data-theme="dark"] .delivery-callout{color:#86efac}
.how-step a{display:inline-block;margin-top:10px;color:var(--blue);font-size:13px;font-weight:700}
.how-step a:hover{text-decoration:underline}
.how-grid.is-playing .how-step{animation:stepGlow 12s ease-in-out infinite;animation-delay:var(--step-delay)}
.how-step:nth-child(1){--step-delay:0s}.how-step:nth-child(2){--step-delay:3s}.how-step:nth-child(3){--step-delay:6s}.how-step:nth-child(4){--step-delay:9s}
@keyframes stepGlow{0%,22%,100%{transform:translateY(0);border-color:var(--line);box-shadow:0 8px 24px rgba(15,23,42,.06)}8%,16%{transform:translateY(-4px);border-color:var(--blue);box-shadow:0 16px 32px rgba(10,132,198,.18)}}
.payment-phone{position:absolute;top:18px;right:18px;width:38px;height:56px;padding:4px;border:2px solid var(--blue);border-radius:9px;color:var(--blue);animation:phoneNudge 3s ease-in-out infinite}
.payment-phone::before{content:"";display:block;width:10px;height:2px;margin:0 auto 5px;border-radius:9px;background:currentColor}
.payment-phone::after{content:"";display:block;height:31px;border-radius:3px;background:linear-gradient(180deg,rgba(10,132,198,.12),rgba(251,191,36,.45))}
.payment-badge{position:absolute;top:27px;right:20px;border-radius:999px;background:#e6f4ff;padding:6px 9px;color:#075985;font-size:11px;font-weight:800}
@keyframes phoneNudge{50%{transform:translateY(-5px) rotate(3deg)}}
.reviews-section{padding-top:58px}
.reviews-intro{display:flex;align-items:end;justify-content:space-between;gap:24px;margin-bottom:24px}
.reviews-average{flex:none;padding:12px 16px;border:1px solid var(--line);border-radius:14px;background:var(--surface);text-align:center}
.reviews-average strong{display:block;font-size:23px}
.reviews-average>span{color:var(--muted);font-size:13px}
.review-stars{color:#d99000;letter-spacing:2px}
.review-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:18px}
.review-card{padding:22px;background:var(--surface);border:1px solid var(--line);border-radius:18px;box-shadow:0 8px 24px rgba(15,23,42,.05)}
.review-card blockquote{margin:12px 0 18px;font-size:15px;line-height:1.65}
.review-author{display:flex;justify-content:space-between;gap:12px;align-items:center;padding-top:14px;border-top:1px solid var(--line);font-size:13px}
.review-author strong{display:block}
.review-author span{color:var(--muted)}
.reviews-empty{padding:28px;border:1px dashed var(--line);border-radius:16px;color:var(--muted);text-align:center;background:var(--surface)}
.reviews-invite{margin-top:18px;color:var(--muted);font-size:13px}
.how-note{display:block;margin-top:5px;font-size:12px}
.video-section{margin-top:34px;padding:38px;border:1px solid var(--line);border-radius:26px;background:linear-gradient(145deg,rgba(10,132,198,.08),rgba(251,191,36,.12));overflow:hidden}
.video-intro{max-width:700px;margin-bottom:24px}
.video-intro h2{margin-top:8px;font-size:clamp(26px,4vw,36px);font-weight:800;line-height:1.15;letter-spacing:-.02em}
.video-intro p{margin-top:10px;color:var(--muted)}
.story-player{overflow:hidden;border:1px solid rgba(255,255,255,.6);border-radius:20px;background:#fff;box-shadow:0 20px 54px rgba(15,23,42,.15)}
.story-stage{position:relative;min-height:330px;aspect-ratio:16/7;overflow:hidden;background:linear-gradient(135deg,#071533,#0b4a6f 65%,#0a84c6)}
.story-stage::before,.story-stage::after{position:absolute;content:"";pointer-events:none}
.story-stage::before{inset:0;opacity:.12;background-image:linear-gradient(rgba(255,255,255,.5) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.5) 1px,transparent 1px);background-size:34px 34px}
.story-stage::after{width:310px;height:310px;right:8%;top:-170px;border-radius:50%;background:rgba(251,191,36,.28);filter:blur(22px)}
.flow-scene{position:absolute;inset:0;z-index:1;display:grid;grid-template-columns:.9fr 1.1fr;align-items:center;gap:15px;padding:24px 5%;opacity:0;animation:flowScene 24s linear infinite}
.flow-scene:nth-child(2){animation-delay:-18s}
.flow-scene:nth-child(3){animation-delay:-12s}
.flow-scene:nth-child(4){animation-delay:-6s}
@keyframes flowScene{0%,23%{opacity:1}25%,98%{opacity:0}100%{opacity:1}}
.scene-copy{position:relative;z-index:1;color:#fff}
.scene-index{display:inline-flex;padding:5px 9px;border:1px solid rgba(255,255,255,.3);border-radius:99px;background:rgba(255,255,255,.09);color:#fde68a;font-size:10px;font-weight:800;letter-spacing:.1em}
.scene-copy h3{margin-top:12px;font-size:clamp(20px,3vw,30px);font-weight:800;line-height:1.12}
.scene-copy p{max-width:330px;margin-top:9px;color:#d8e5f7;font-size:13px;line-height:1.55}
.scene-visual{position:relative;z-index:1;display:grid;place-items:center;width:100%;height:100%;min-height:240px;overflow:hidden;border:1px solid rgba(255,255,255,.24);border-radius:16px;background:#0b2748;box-shadow:0 14px 35px rgba(0,0,0,.22)}
.scene-visual::after{position:absolute;inset:0;content:"";pointer-events:none;background:linear-gradient(180deg,rgba(4,17,38,.03) 35%,rgba(4,17,38,.56))}
.scene-visual img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;animation:photoPush 6s ease-in-out infinite alternate}
.flow-scene:nth-child(1) .scene-visual img{object-position:center 48%}
.flow-scene:nth-child(2) .scene-visual img{object-position:center 44%}
.flow-scene:nth-child(3) .scene-visual img{object-position:center 45%}
.flow-scene:nth-child(4) .scene-visual img{object-position:center}
@keyframes photoPush{from{transform:scale(1)}to{transform:scale(1.08)}}
.scene-visual.photo-pair{grid-template-columns:1fr 1fr;gap:4px}
.scene-visual.photo-pair img{position:relative;inset:auto;width:100%;height:100%;min-height:240px}
.scene-callout{position:absolute;z-index:2;right:12px;bottom:12px;left:12px;display:flex;align-items:center;gap:8px;padding:9px 11px;border:1px solid rgba(255,255,255,.45);border-radius:12px;background:rgba(255,255,255,.94);color:#0f172a;font-size:10px;font-weight:700;box-shadow:0 8px 20px rgba(0,0,0,.2)}
.scene-callout-mark{display:grid;flex:none;place-items:center;width:24px;height:24px;border-radius:50%;background:#dcfce7;color:#15803d}
.scene-callout-mark svg{width:14px;height:14px}
.story-controls{display:flex;align-items:center;gap:14px;padding:12px 16px;background:#fff}
.story-play{display:grid;flex:none;place-items:center;width:36px;height:36px;border:0;border-radius:50%;background:#e0f2fe;color:#0369a1;font-size:15px}
.story-play:hover{background:#bae6fd}
.story-player.is-paused .story-pause-icon,.story-player:not(.is-paused) .story-resume-icon{display:none}
.story-play-label{position:absolute;width:1px;height:1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap}
.story-progress{flex:1;min-width:0;height:6px;margin:0;appearance:none;border-radius:99px;background:#e2e8f0;cursor:pointer}
.story-progress::-webkit-slider-runnable-track{height:6px;border-radius:99px;background:transparent}
.story-progress::-moz-range-track{height:6px;border-radius:99px;background:transparent}
.story-progress::-webkit-slider-thumb{width:16px;height:16px;margin-top:-5px;appearance:none;border:2px solid #fff;border-radius:50%;background:#0284c7;box-shadow:0 1px 4px rgba(15,23,42,.3)}
.story-progress::-moz-range-thumb{width:12px;height:12px;border:2px solid #fff;border-radius:50%;background:#0284c7;box-shadow:0 1px 4px rgba(15,23,42,.3)}
.story-caption{color:#64748b;font-size:11px;font-weight:700;white-space:nowrap}
.sr-only{position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0}
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
@media (max-width:980px){.products,.perks{grid-template-columns:repeat(2,1fr)}.hero .wrap{grid-template-columns:1fr}.stage{max-width:640px;margin:auto}.fg{grid-template-columns:1fr 1fr}.bar{position:relative}.main-nav{display:none;position:absolute;top:100%;left:0;right:0;z-index:55;flex-direction:column;gap:0;padding:10px;background:var(--surface);border:1px solid var(--line);border-radius:14px;box-shadow:0 16px 36px rgba(15,23,42,.18)}.main-nav.nav-open{display:flex}.main-nav a{padding:12px 14px;border-radius:9px}.main-nav a:hover{background:var(--bg)}.main-nav a::after{display:none}.nav-theme-toggle{display:flex;align-items:center;gap:10px;width:100%;padding:12px 14px;border:0;border-radius:9px;background:transparent;color:var(--text);font-weight:600;text-align:left}.nav-theme-toggle:hover{background:var(--bg)}.nav-theme-toggle svg{width:20px;height:20px}.tools .desktop-theme-toggle{display:none}.mobile-menu-toggle{display:grid}.cats{grid-template-columns:repeat(2,minmax(0,1fr))}.how-grid{grid-template-columns:repeat(2,minmax(0,1fr))}.review-grid{grid-template-columns:repeat(2,minmax(0,1fr))}}
@media (max-width:560px){.products,.perks,.cats,.how-grid,.review-grid{grid-template-columns:1fr}.hero{padding:50px 0 120px}.wrap{padding:0 18px}.fg{grid-template-columns:1fr}.logo{font-size:19px}.hello{display:none}.login{padding:7px 10px;font-size:12px;margin-left:0}.bar{gap:6px}.mobile-menu-toggle{width:36px;height:36px;flex:none}.tools{gap:2px}.tools .ic:first-child{display:none}.tools .ic{width:36px;height:36px}.head h2{font-size:24px}.how-section{padding:24px 18px;border-radius:20px}.how-step{min-height:0;padding:18px}.how-step-icon{margin:14px 0 10px}.reviews-intro{align-items:start;flex-direction:column}.reviews-average{display:flex;align-items:center;gap:10px;text-align:left;padding:8px 12px}.reviews-average strong{font-size:18px}}
@media (prefers-reduced-motion:reduce){*{animation:none!important;transition:none!important;scroll-behavior:auto!important}}
@media (max-width:980px){.stage{width:100%;max-width:640px;margin:12px auto 0}.client-dashboard{transform:none}}
@media (max-width:700px){.dashboard-content{grid-template-columns:1fr}.dashboard-chart{height:75px}}
@media (max-width:560px){.client-dashboard{padding:7px;border-radius:18px}.dashboard-window{padding:12px}.dashboard-kpis{gap:5px}.dashboard-kpi{padding:7px}.dashboard-kpi strong{font-size:11px}.dashboard-greeting h2{font-size:14px}.video-section{padding:22px 14px;border-radius:20px}.video-intro{margin-bottom:17px}.story-stage{min-height:455px;aspect-ratio:auto}.flow-scene{grid-template-columns:1fr;grid-template-rows:auto 1fr;align-items:start;gap:0;padding:18px 20px}.scene-copy h3{margin-top:8px;font-size:22px}.scene-copy p{margin-top:6px;font-size:12px}.scene-visual{min-height:210px;align-self:end}.scene-visual.photo-pair img{min-height:210px}.story-controls{gap:9px;padding:10px 12px}.story-caption{font-size:9px}}
@media (prefers-reduced-motion:reduce){.flow-scene{opacity:0;animation:none!important}.flow-scene:first-child{opacity:1}.dashboard-chart-line{stroke-dashoffset:0}.story-play,#story-seek{display:none}}
@media (max-width:560px){.dashboard-layout{grid-template-columns:minmax(0,1fr);gap:8px}.dashboard-sidebar{display:flex;gap:8px;overflow-x:auto;padding:6px}.dashboard-side-brand{display:none}.dashboard-menu-group{display:flex;flex:none;align-items:center;gap:3px;margin:0}.dashboard-menu-title{display:none}.dashboard-menu-item{flex:none;margin:0;padding:5px 6px;font-size:7px}.dashboard-menu-item svg{width:10px;height:10px}.dashboard-main{min-width:0}.dashboard-window{padding:9px}.scene-visual{min-height:210px}.scene-visual.photo-pair img{min-height:210px}.scene-callout{right:7px;bottom:7px;left:7px;padding:7px;font-size:9px}}
@media (max-width:980px){.dashboard-welcome-kpis{grid-template-columns:1fr 1fr 1fr}.dashboard-welcome{grid-column:1/-1}}
@media (max-width:560px){.dashboard-browser{margin-bottom:6px;font-size:8px}.dashboard-welcome-kpis{gap:4px}.dashboard-kpi.compact{padding:5px}.dashboard-kpi.compact span{font-size:6px}.dashboard-kpi.compact strong{font-size:8px}}
@media (min-width:561px) and (max-width:980px){.dashboard-layout{grid-template-columns:120px minmax(0,1fr)}.dashboard-content{grid-template-columns:1fr}}
.story-player:not(.is-in-view) .flow-scene,.story-player:not(.is-in-view) .scene-visual img{animation-play-state:paused}
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
<nav class="main-nav" id="main-nav" aria-label="Navigation principale"><a class="on" href="{{ route('home') }}">Accueil</a><a href="{{ route('shop.index') }}">Boutique</a><a href="{{ route('categories.index') }}">Catégories</a><a href="{{ route('support.faq') }}">FAQ</a><a href="{{ route('contact') }}">Contact</a><button class="nav-theme-toggle" type="button" data-theme-toggle aria-label="Changer de thème"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8z"/></svg><span>Changer de thème</span></button></nav>
<button class="mobile-menu-toggle" id="mobile-menu-toggle" type="button" aria-label="Ouvrir le menu" aria-controls="main-nav" aria-expanded="false">
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
</button>
<div class="tools">
<a class="ic" href="{{ route('shop.index') }}" aria-label="Rechercher"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg></a>
<button class="ic desktop-theme-toggle" type="button" data-theme-toggle aria-label="Changer de thème"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8z"/></svg></button>
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
<figure class="stage">
<div class="client-dashboard">
<div class="dashboard-browser" aria-label="Adresse du tableau de bord"><span class="dashboard-browser-dots" aria-hidden="true"><i></i><i></i><i></i></span><span class="dashboard-browser-address"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="5" y="10" width="14" height="11" rx="2"/><path d="M8 10V7a4 4 0 1 1 8 0v3"/></svg><span class="dashboard-browser-url">https://casque-shop-1.onrender.com/dashbord</span></span></div>
<div class="dashboard-window">
<div class="dashboard-layout">
<aside class="dashboard-sidebar" aria-label="Menus du tableau de bord">
<div class="dashboard-side-brand"><span class="dashboard-brand-mark" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 12a8 8 0 0 1 16 0"/><rect x="3" y="11" width="5" height="8" rx="2"/><rect x="16" y="11" width="5" height="8" rx="2"/></svg></span>{{ site_name() }}</div>
<div class="dashboard-menu-item active"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="8" height="8" rx="1"/><rect x="13" y="3" width="8" height="5" rx="1"/><rect x="13" y="10" width="8" height="11" rx="1"/><rect x="3" y="13" width="8" height="8" rx="1"/></svg>Tableau de bord</div>
<div class="dashboard-menu-group"><p class="dashboard-menu-title">Boutique</p>
<div class="dashboard-menu-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9h18l-2 12H5L3 9Z"/><path d="M8 9a4 4 0 0 1 8 0"/></svg>Produits</div>
<div class="dashboard-menu-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="20" r="1"/><circle cx="18" cy="20" r="1"/><path d="M2 3h2l3 13h12l3-9H6"/></svg>Commandes</div>
<div class="dashboard-menu-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 5h16M4 12h16M4 19h16"/></svg>Catégories</div>
</div>
<div class="dashboard-menu-group"><p class="dashboard-menu-title">Clients</p>
<div class="dashboard-menu-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8ZM20 8v6m3-3h-6"/></svg>Clients</div>
<div class="dashboard-menu-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg>Messages</div>
<div class="dashboard-menu-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m12 3 2.8 5.7 6.2.9-4.5 4.4 1.1 6.2L12 17.3l-5.6 2.9 1.1-6.2L3 9.6l6.2-.9L12 3Z"/></svg>Avis clients</div>
</div>
<div class="dashboard-menu-group"><p class="dashboard-menu-title">Gestion</p>
<div class="dashboard-menu-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20M6 15h4"/></svg>Wallet</div>
<div class="dashboard-menu-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3v18M3 12h18"/></svg>Accueil du site</div>
<div class="dashboard-menu-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 21a8 8 0 0 1 16 0"/></svg>Compte</div>
</div>
</aside>
<div class="dashboard-main">
<div class="dashboard-greeting">
<div><p>Bienvenue</p><h2>Administrateur</h2></div>
<a href="{{ route('shop.index') }}">Boutique</a>
</div>
<h2 class="dashboard-heading">Tableau de bord</h2>
<div class="dashboard-kpis dashboard-welcome-kpis">
<div class="dashboard-kpi compact"><span>Chiffre d’affaires</span><strong>— FCFA</strong></div>
<div class="dashboard-kpi compact"><span>Paiements reçus</span><strong>—</strong></div>
<div class="dashboard-kpi compact"><span>Commandes</span><strong>—</strong></div>
</div>
<div class="dashboard-content">
<div class="dashboard-panel">
<div class="dashboard-card-heading">Activité des commandes</div>
<svg class="dashboard-chart" viewBox="0 0 300 100" role="img" aria-label="Graphique d’activité du tableau de bord">
<path d="M16 18H290M16 48H290M16 78H290" fill="none" stroke="#e8edf3" stroke-width="1"/>
<path d="M18 75C48 70 55 53 82 58S124 74 151 46 191 60 218 33 261 42 286 18V88H18Z" fill="rgba(2,132,199,.12)"/>
<path class="dashboard-chart-line" d="M18 75C48 70 55 53 82 58S124 74 151 46 191 60 218 33 261 42 286 18" fill="none" stroke="#0284c7" stroke-width="3" stroke-linecap="round" stroke-dasharray="380" stroke-dashoffset="380"/>
<circle cx="286" cy="18" r="4" fill="#f59e0b"/>
</svg>
<div class="dashboard-chart-labels"><span>Sem. 1</span><span>Sem. 2</span><span>Sem. 3</span><span>Sem. 4</span></div>
</div>
<div class="dashboard-panel">
<div class="dashboard-card-heading">Dernières commandes</div>
<div class="dashboard-order-row"><span class="dashboard-product-thumb" aria-hidden="true"><svg viewBox="0 0 200 200"><use href="#hp"/></svg></span><div class="dashboard-order-item"><div class="dashboard-order-name">Suivi des commandes</div><div class="dashboard-order-meta">Statuts et paiements</div></div></div>
<div class="dashboard-footer"><span>Gestion</span><span class="dashboard-status">En temps réel</span></div>
</div>
</div>
</div>
</div>
</figure>
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

<section id="comment-commander" class="video-section" aria-labelledby="how-heading">
<div class="video-intro">
<span class="how-kicker"><span aria-hidden="true">✦</span> Simple et sécurisé</span>
<h2 id="how-heading">Du téléphone à la livraison</h2>
<p>Découvrez le parcours d’une commande : le client choisit son produit, règle sa commande et reçoit son casque.</p>
@unless($kkiapayConfigured)
<p class="how-note">KkiaPay n’est pas activé actuellement. Le moyen de paiement en ligne ne sera proposé que lorsqu’il sera configuré.</p>
@endunless
</div>
<div class="story-player" id="order-story">
<div class="story-stage" aria-hidden="true">
<article class="flow-scene">
<div class="scene-copy"><span class="scene-index">ÉTAPE 01 · DÉCOUVERTE</span><h3>Elle prend son téléphone</h3><p>Elle ouvre la boutique en ligne et découvre les casques depuis chez elle.</p></div>
<div class="scene-visual"><img src="{{ asset('images/purchase-story/shopping-phone.jpg') }}" alt="" loading="eager" decoding="async"></div>
</article>
<article class="flow-scene">
<div class="scene-copy"><span class="scene-index">ÉTAPE 02 · CHOIX</span><h3>Elle choisit son casque</h3><p>Elle compare les modèles disponibles puis ouvre la fiche du produit qui la plaît.</p></div>
<div class="scene-visual"><img src="{{ asset('images/purchase-story/headphones-customer.jpg') }}" alt="" loading="eager" decoding="async"></div>
</article>
<article class="flow-scene">
<div class="scene-copy"><span class="scene-index">ÉTAPE 03 · PAIEMENT</span><h3>@if($kkiapayConfigured) Elle paie avec KkiaPay @else Elle confirme sa commande @endif</h3><p>@if($kkiapayConfigured) Elle confirme le paiement sur son téléphone et reçoit un message de confirmation. @else La scène illustre le paiement et le message de confirmation. KkiaPay sera proposé une fois activé. @endif</p></div>
<div class="scene-visual">
<img src="{{ asset('images/purchase-story/payment-at-counter.jpg') }}" alt="" loading="eager" decoding="async">
<div class="scene-callout"><span class="scene-callout-mark" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m5 12 4 4L19 6"/></svg></span>@if($kkiapayConfigured) Paiement confirmé avec KkiaPay @else Commande confirmée @endif</div>
</div>
</article>
<article class="flow-scene">
<div class="scene-copy"><span class="scene-index">ÉTAPE 04 · LIVRAISON</span><h3>Le livreur prend la route</h3><p>Après confirmation et préparation, le livreur rejoint le client à moto et lui remet son colis.</p></div>
<div class="scene-visual photo-pair">
<img src="{{ asset('images/purchase-story/courier-motorcycle.jpg') }}" alt="" loading="eager" decoding="async">
<img src="{{ asset('images/purchase-story/package-handover.jpg') }}" alt="" loading="eager" decoding="async">
</div>
</article>
</div>
<div class="story-controls">
<button class="story-play" id="story-play" type="button" aria-label="Mettre l’animation en pause">
<svg class="story-pause-icon" viewBox="0 0 24 24" width="17" height="17" aria-hidden="true"><path d="M8 5v14M16 5v14" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"/></svg>
<svg class="story-resume-icon" viewBox="0 0 24 24" width="17" height="17" aria-hidden="true"><path d="m8 5 12 7-12 7z" fill="currentColor"/></svg>
<span class="sr-only">Mettre l’animation en pause</span>
</button>
<input
    class="story-progress"
    id="story-seek"
    type="range"
    min="0"
    max="24000"
    step="100"
    value="0"
    aria-label="Avancer ou reculer dans l’animation"
/>
<span class="story-caption" aria-hidden="true">PHOTOS STOCK · UNSPLASH</span>
</div>
<p class="sr-only">Animation illustrative en quatre étapes : le client ouvre la boutique sur son téléphone, choisit un casque, règle sa commande, puis reçoit son colis des mains du livreur à moto. Les scènes et les données du tableau de bord sont des exemples.</p>
</div>
</section>

<section class="reviews-section" id="avis-clients" aria-labelledby="reviews-heading">
<div class="reviews-intro">
<div>
<span class="how-kicker"><span aria-hidden="true">✦</span> Avis vérifiés</span>
<h2 id="reviews-heading">Leur expérience après commande</h2>
<p>Chaque avis provient d’une commande livrée et est vérifié par notre équipe avant publication.</p>
</div>
@if($reviews->isNotEmpty())
<div class="reviews-average" aria-label="Note moyenne des clients">
<strong>{{ number_format($reviewAverage, 1, ',', ' ') }} <span class="review-stars" aria-hidden="true">★</span></strong>
<span>{{ $reviewCount }} avis publié(s)</span>
</div>
@endif
</div>
@if($reviews->isNotEmpty())
<div class="review-grid">
@foreach($reviews as $review)
<article class="review-card">
<div class="review-stars" aria-label="Note : {{ $review->rating }} sur 5">
    @for($star = 1; $star <= 5; $star++)
        <span aria-hidden="true">{{ $star <= $review->rating ? '★' : '☆' }}</span>
    @endfor
</div>
<blockquote>{{ $review->comment }}</blockquote>
<div class="review-author">
<div><strong>{{ $review->author_name }}</strong><span>{{ $review->city }}</span></div>
<span>Commande livrée</span>
</div>
</article>
@endforeach
</div>
@else
<p class="reviews-empty">Les premiers avis vérifiés apparaîtront ici après livraison et validation par notre équipe.</p>
@endif
<p class="reviews-invite">Vous avez déjà payé ou reçu une commande ? Le lien pour partager votre expérience se trouve sur votre page de confirmation.</p>
</section>

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
    document.querySelectorAll('[data-theme-toggle]').forEach(function (button) {
        button.addEventListener('click', function () {
            apply(root.dataset.theme !== 'dark');
            closeMenu();
        });
    });

    var menu = document.getElementById('main-nav');
    var menuToggle = document.getElementById('mobile-menu-toggle');
    //Fonction pour fermer le menu et mettre à jour les attributs ARIA
    function closeMenu() {
        menu.classList.remove('nav-open');
        menuToggle.setAttribute('aria-expanded', 'false');
        menuToggle.setAttribute('aria-label', 'Ouvrir le menu');
    }
    menuToggle.addEventListener('click', function () {
        var isOpen = menu.classList.toggle('nav-open');
        menuToggle.setAttribute('aria-expanded', String(isOpen));
        menuToggle.setAttribute('aria-label', isOpen ? 'Fermer le menu' : 'Ouvrir le menu');
    });
    menu.addEventListener('click', function (event) {
        if (event.target.closest('a')) closeMenu();
    });
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') closeMenu();
    });

    var storyPlayer = document.getElementById('order-story');
    var storyPlay = document.getElementById('story-play');
    var storySeek = document.getElementById('story-seek');
    var reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
    if (storyPlayer && storyPlay && storySeek) {
        var storyDuration = 24000;
        var storyTime = 0;
        var storyPaused = false;
        var storyInView = true;
        var storyFrame = null;
        var lastStoryFrameTime = null;
        var storyAnimations = Array.from(storyPlayer.querySelectorAll('*'))
            .flatMap(function (element) {
                return element.getAnimations();
            });

        function renderStoryTime(time) {
            storyTime = Math.max(0, Math.min(time, storyDuration));
            storyAnimations.forEach(function (animation) {
                animation.currentTime = storyTime;
            });
            storySeek.value = String(storyTime);
            var progress = storyTime / storyDuration * 100;
            storySeek.style.background =
                'linear-gradient(90deg, #0284c7, #fbbf24) 0 / ' + progress + '% 100% no-repeat, #e2e8f0';
        }

        function syncStoryPlayback() {
            var shouldPlay = !storyPaused && storyInView && !reducedMotion.matches;
            if (shouldPlay && storyFrame === null) {
                storyAnimations.forEach(function (animation) {
                    animation.play();
                });
                lastStoryFrameTime = null;
                storyFrame = requestAnimationFrame(tickStory);
            } else if (!shouldPlay && storyFrame !== null) {
                cancelAnimationFrame(storyFrame);
                storyFrame = null;
                lastStoryFrameTime = null;
                storyAnimations.forEach(function (animation) {
                    animation.pause();
                });
            }
        }

        function tickStory(timestamp) {
            if (storyPaused || !storyInView || reducedMotion.matches) {
                storyFrame = null;
                return;
            }
            if (lastStoryFrameTime !== null) {
                renderStoryTime((storyTime + timestamp - lastStoryFrameTime) % storyDuration);
            }
            lastStoryFrameTime = timestamp;
            storyFrame = requestAnimationFrame(tickStory);
        }

        renderStoryTime(0);

        // Gestion de l'état de pause de l'animation
        function setStoryPaused(paused) {
            storyPaused = paused;
            storyPlayer.classList.toggle('is-paused', storyPaused);
            var label = paused ? 'Reprendre l’animation' : 'Mettre l’animation en pause';
            storyPlay.setAttribute('aria-label', label);
            storyPlay.querySelector('.sr-only').textContent = label;
            syncStoryPlayback();
        }

        storyPlay.addEventListener('click', function () {
            setStoryPaused(!storyPaused);
        });

        storySeek.addEventListener('input', function () {
            renderStoryTime(Number(storySeek.value));
        });

        function applyMotionPreference() {
            storyPlay.hidden = reducedMotion.matches;
            storySeek.hidden = reducedMotion.matches;
            syncStoryPlayback();
        }

        if ('IntersectionObserver' in window) {
            var storyObserver = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    storyInView = entry.isIntersecting;
                    storyPlayer.classList.toggle('is-in-view', storyInView);
                    syncStoryPlayback();
                });
            }, { threshold: 0.2 });
            storyObserver.observe(storyPlayer);
        } else {
            storyPlayer.classList.add('is-in-view');
        }

        applyMotionPreference();
        reducedMotion.addEventListener('change', applyMotionPreference);
    }
})();
</script>
</body>
</html>
