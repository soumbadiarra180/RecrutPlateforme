@extends('layouts.app')

@section('title', 'Accueil')

@push('styles')
<style>
    body { overflow-x: hidden; }

    /* Sections pleine largeur, malgré le .container du layout */
    .ir-bleed {
        width: 100vw;
        position: relative;
        left: 50%;
        margin-left: -50vw;
    }
    .ir-display {
        font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
        letter-spacing: -0.02em;
    }
    .ir-eyebrow {
        display: inline-flex; align-items: center; gap: .5rem;
        font-size: .78rem; font-weight: 600; letter-spacing: .08em; text-transform: uppercase;
        color: var(--ir-sky);
    }
    .ir-eyebrow::before { content: ''; width: 22px; height: 2px; background: currentColor; border-radius: 2px; }

    /* ---------- HERO ---------- */
    .ir-hero {
        margin-top: calc(-1 * (var(--ir-nav-h) + 1.5rem));
        background:
            radial-gradient(900px 500px at 85% 20%, rgba(59,130,246,.28), transparent 60%),
            radial-gradient(700px 400px at 10% 90%, rgba(34,211,238,.14), transparent 60%),
            linear-gradient(180deg, var(--ir-blue) 0%, var(--ir-navy) 38%, var(--ir-navy) 100%);
        color: #fff;
        padding: calc(var(--ir-nav-h) + 4rem) 0 6rem;
        overflow: hidden;
    }
    .ir-hero::after {
        content: ''; position: absolute; inset: 0; pointer-events: none;
        background-image: radial-gradient(rgba(255,255,255,.07) 1px, transparent 1px);
        background-size: 26px 26px;
        mask-image: linear-gradient(180deg, transparent, #000 30%, #000 70%, transparent);
    }
    .ir-hero .container { position: relative; z-index: 2; }
    .ir-pill {
        display: inline-flex; align-items: center; gap: .55rem;
        padding: .4rem .9rem .4rem .45rem; border-radius: 999px;
        background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.14);
        font-size: .85rem; color: #dbe6ff;
    }
    .ir-pill b {
        background: var(--ir-amber); color: var(--ir-navy);
        font-size: .7rem; padding: .2rem .55rem; border-radius: 999px; font-weight: 700;
    }
    .ir-hero h1 {
        font-size: clamp(2.2rem, 4.6vw, 3.6rem); font-weight: 800; line-height: 1.08;
        margin: 1.4rem 0 1.2rem;
    }
    .ir-grad {
        background: linear-gradient(90deg, var(--ir-cyan), var(--ir-sky) 50%, #a5b4fc);
        -webkit-background-clip: text; background-clip: text; color: transparent;
    }
    .ir-hero .lead { color: #b9c6e4; font-size: 1.12rem; max-width: 34rem; }
    .ir-btn {
        display: inline-flex; align-items: center; gap: .5rem;
        padding: .9rem 1.6rem; border-radius: 12px; font-weight: 600;
        text-decoration: none; transition: transform .2s ease, box-shadow .2s ease, background .2s ease;
    }
    .ir-btn-primary { background: linear-gradient(135deg, var(--ir-sky), #2563eb); color: #fff; box-shadow: 0 10px 30px rgba(59,130,246,.45); }
    .ir-btn-primary:hover { color: #fff; transform: translateY(-2px); box-shadow: 0 16px 36px rgba(59,130,246,.55); }
    .ir-btn-ghost { background: rgba(255,255,255,.06); color: #fff; border: 1px solid rgba(255,255,255,.2); }
    .ir-btn-ghost:hover { color: #fff; background: rgba(255,255,255,.12); transform: translateY(-2px); }
    .ir-btn-dark { background: var(--ir-navy); color: #fff; }
    .ir-btn-dark:hover { color: #fff; background: var(--ir-blue); transform: translateY(-2px); }
    .ir-btn-light { background: #fff; color: var(--ir-ink); border: 1px solid var(--ir-line); }
    .ir-btn-light:hover { color: var(--ir-blue); border-color: #c7d6f5; transform: translateY(-2px); }

    .ir-hero-proof { display: flex; gap: 2rem; flex-wrap: wrap; margin-top: 2.6rem; }
    .ir-hero-proof div { border-left: 2px solid rgba(255,255,255,.15); padding-left: 1rem; }
    .ir-hero-proof strong { display: block; font-size: 1.6rem; font-weight: 800; font-family: 'Plus Jakarta Sans', sans-serif; }
    .ir-hero-proof span { color: #93a3c8; font-size: .85rem; }

    .ir-visual { position: relative; }
    .ir-visual svg { width: 100%; height: auto; display: block; overflow: visible; }
    .ir-layer { transition: transform .4s cubic-bezier(.2,.8,.2,1); }

    /* Animations SVG */
    @keyframes ir-spin { to { transform: rotate(360deg); } }
    @keyframes ir-spin-rev { to { transform: rotate(-360deg); } }
    @keyframes ir-float { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
    @keyframes ir-dash { to { stroke-dashoffset: -40; } }
    @keyframes ir-blink { 0%,49% { opacity: 1; } 50%,100% { opacity: 0; } }
    @keyframes ir-bar { 0% { transform: scaleX(0); } 55%,100% { transform: scaleX(1); } }
    @keyframes ir-pop { 0%,100% { transform: scale(1); } 50% { transform: scale(1.08); } }
    .ir-orbit-a { transform-origin: 280px 250px; animation: ir-spin 60s linear infinite; }
    .ir-orbit-b { transform-origin: 280px 250px; animation: ir-spin-rev 90s linear infinite; }
    .ir-link { stroke-dasharray: 4 6; animation: ir-dash 1.6s linear infinite; }
    .ir-float-1 { animation: ir-float 6s ease-in-out infinite; }
    .ir-float-2 { animation: ir-float 7s ease-in-out -2s infinite; }
    .ir-float-3 { animation: ir-float 5.5s ease-in-out -1s infinite; }
    .ir-cursor { animation: ir-blink 1s step-end infinite; }
    .ir-bar-fill { transform-box: fill-box; transform-origin: left center; animation: ir-bar 4s cubic-bezier(.2,.8,.2,1) infinite; }
    .ir-node { transform-box: fill-box; transform-origin: center; animation: ir-pop 3s ease-in-out infinite; }
    @media (prefers-reduced-motion: reduce) {
        .ir-visual * { animation: none !important; }
        .ir-visual animate, .ir-visual animateMotion { display: none; }
    }

    /* ---------- SECTIONS ---------- */
    .ir-section { padding: 5.5rem 0; }
    .ir-section-head { max-width: 40rem; margin-bottom: 3rem; }
    .ir-section-head h2 { font-size: clamp(1.7rem, 3vw, 2.3rem); font-weight: 800; color: var(--ir-ink); margin: .6rem 0 .8rem; }
    .ir-section-head p { color: var(--ir-muted); font-size: 1.05rem; margin: 0; }

    .ir-stats {
        background: #fff; border: 1px solid var(--ir-line); border-radius: 20px;
        box-shadow: 0 24px 50px -24px rgba(15,23,42,.25);
        margin-top: -3.2rem; position: relative; z-index: 3;
    }
    .ir-stat { padding: 1.8rem 1.5rem; display: flex; align-items: center; gap: 1rem; }
    .ir-stat + .ir-stat { border-left: 1px solid var(--ir-line); }
    .ir-stat-icon {
        width: 52px; height: 52px; flex-shrink: 0; border-radius: 14px;
        display: grid; place-items: center; font-size: 1.35rem;
    }
    .ir-stat strong { display: block; font-size: 1.9rem; font-weight: 800; color: var(--ir-ink); line-height: 1; font-family: 'Plus Jakarta Sans', sans-serif; }
    .ir-stat span { color: var(--ir-muted); font-size: .9rem; }
    @media (max-width: 767.98px) { .ir-stat + .ir-stat { border-left: 0; border-top: 1px solid var(--ir-line); } }

    .ir-tint-blue { background: #e8f0ff; color: var(--ir-blue); }
    .ir-tint-cyan { background: #e0f9fd; color: #0e7490; }
    .ir-tint-amber { background: #fff4dc; color: #b45309; }
    .ir-tint-green { background: #e3f8ee; color: #15803d; }
    .ir-tint-violet { background: #efeaff; color: #6d28d9; }
    .ir-tint-rose { background: #ffe8ee; color: #be123c; }

    /* Cartes d'offres */
    .ir-job {
        display: flex; flex-direction: column; height: 100%;
        background: #fff; border: 1px solid var(--ir-line); border-radius: 18px; padding: 1.6rem;
        text-decoration: none; color: inherit;
        transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease;
    }
    .ir-job:hover { transform: translateY(-6px); border-color: #bfd3fb; box-shadow: 0 22px 40px -20px rgba(30,58,138,.35); color: inherit; }
    .ir-job-top { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.2rem; }
    .ir-job-logo {
        width: 48px; height: 48px; border-radius: 12px; display: grid; place-items: center;
        font-weight: 800; color: #fff; background: linear-gradient(135deg, var(--ir-sky), var(--ir-blue));
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .ir-chip { display: inline-flex; align-items: center; gap: .35rem; font-size: .78rem; font-weight: 600; padding: .3rem .7rem; border-radius: 999px; }
    .ir-job h3 { font-size: 1.12rem; font-weight: 700; color: var(--ir-ink); margin-bottom: .45rem; }
    .ir-job p { color: var(--ir-muted); font-size: .92rem; flex-grow: 1; }
    .ir-job-meta { display: flex; gap: 1rem; flex-wrap: wrap; font-size: .84rem; color: var(--ir-muted); padding-top: 1rem; border-top: 1px dashed var(--ir-line); }
    .ir-job-cta { color: var(--ir-sky); font-weight: 600; margin-left: auto; transition: transform .2s ease; }
    .ir-job:hover .ir-job-cta { transform: translateX(4px); }

    /* Défilement automatique des offres */
    .ir-marquee {
        overflow-x: auto; scrollbar-width: none; margin: -12px -8px; padding: 12px 8px 20px;
        mask-image: linear-gradient(90deg, transparent, #000 4%, #000 96%, transparent);
        -webkit-mask-image: linear-gradient(90deg, transparent, #000 4%, #000 96%, transparent);
    }
    .ir-marquee::-webkit-scrollbar { display: none; }
    .ir-marquee-track { display: flex; gap: 1.5rem; width: max-content; }
    .ir-slide { width: min(340px, 82vw); flex: 0 0 auto; height: auto; }
    .ir-arrow {
        width: 46px; height: 46px; border-radius: 12px; display: grid; place-items: center;
        border: 1px solid var(--ir-line); background: #fff; color: var(--ir-ink); font-size: 1.1rem;
        transition: background .2s ease, color .2s ease, border-color .2s ease, transform .2s ease;
    }
    .ir-arrow:hover { background: var(--ir-navy); border-color: var(--ir-navy); color: #fff; }
    .ir-arrow:active { transform: scale(.94); }
    .ir-arrow:focus-visible { outline: 2px solid var(--ir-sky); outline-offset: 2px; }
    .ir-marquee-hint { margin: .6rem 0 0; font-size: .82rem; color: var(--ir-muted); display: flex; align-items: center; gap: .4rem; transition: opacity .3s ease; }
    #irOffres.is-paused .ir-marquee-hint { opacity: .45; }
    @media (prefers-reduced-motion: reduce) { .ir-marquee-hint { display: none; } }

    /* Métiers */
    .ir-domain {
        background: #fff; border: 1px solid var(--ir-line); border-radius: 16px; padding: 1.4rem;
        display: flex; gap: 1rem; align-items: flex-start; height: 100%;
        transition: border-color .2s ease, transform .2s ease;
    }
    .ir-domain:hover { border-color: #bfd3fb; transform: translateY(-3px); }
    .ir-domain .ir-stat-icon { width: 46px; height: 46px; font-size: 1.2rem; }
    .ir-domain h4 { font-size: 1rem; font-weight: 700; margin: 0 0 .25rem; color: var(--ir-ink); }
    .ir-domain p { font-size: .87rem; color: var(--ir-muted); margin: 0; }

    /* Étapes */
    .ir-steps-wrap { background: var(--ir-soft); }
    .ir-tabs { display: inline-flex; background: #fff; border: 1px solid var(--ir-line); border-radius: 12px; padding: 4px; }
    .ir-tabs button {
        border: 0; background: transparent; padding: .6rem 1.2rem; border-radius: 9px;
        font-weight: 600; color: var(--ir-muted); transition: background .2s ease, color .2s ease;
    }
    .ir-tabs button.active { background: var(--ir-navy); color: #fff; }
    .ir-step { position: relative; padding-left: 4.2rem; padding-bottom: 2.2rem; }
    .ir-step:last-child { padding-bottom: 0; }
    .ir-step::before {
        content: ''; position: absolute; left: 1.35rem; top: 2.9rem; bottom: .2rem; width: 2px;
        background: linear-gradient(var(--ir-sky), transparent);
    }
    .ir-step:last-child::before { display: none; }
    .ir-step-num {
        position: absolute; left: 0; top: 0; width: 2.75rem; height: 2.75rem; border-radius: 12px;
        background: #fff; border: 1px solid #c7d6f5; color: var(--ir-blue);
        display: grid; place-items: center; font-weight: 800; font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .ir-step h4 { font-size: 1.08rem; font-weight: 700; color: var(--ir-ink); margin-bottom: .3rem; }
    .ir-step p { color: var(--ir-muted); margin: 0; }
    .ir-steps-card {
        background: linear-gradient(160deg, var(--ir-navy-2), var(--ir-navy)); color: #fff;
        border-radius: 22px; padding: 2.2rem; height: 100%; position: relative; overflow: hidden;
    }
    .ir-steps-card::after {
        content: ''; position: absolute; width: 260px; height: 260px; right: -80px; bottom: -80px;
        border-radius: 50%; background: radial-gradient(circle, rgba(59,130,246,.45), transparent 70%);
    }
    .ir-check { list-style: none; padding: 0; margin: 1.5rem 0 0; }
    .ir-check li { display: flex; gap: .7rem; margin-bottom: .85rem; color: #c9d5f0; }
    .ir-check i { color: var(--ir-cyan); }

    /* Bandeau final */
    .ir-cta {
        background:
            radial-gradient(600px 300px at 90% 10%, rgba(34,211,238,.25), transparent 60%),
            linear-gradient(135deg, var(--ir-blue), var(--ir-navy));
        border-radius: 26px; padding: 3.5rem; color: #fff; position: relative; overflow: hidden;
    }
    .ir-cta h2 { font-size: clamp(1.6rem, 3vw, 2.2rem); font-weight: 800; }
    .ir-cta p { color: #b9c6e4; }


    /* ---------- ESPACES CONNECTÉS ---------- */
    .ir-welcome {
        margin-top: calc(-1 * (var(--ir-nav-h) + 1.5rem)); color: #fff; padding: calc(var(--ir-nav-h) + 2.5rem) 0 5.5rem; overflow: hidden;
        background:
            radial-gradient(700px 300px at 90% 0%, rgba(59,130,246,.35), transparent 60%),
            linear-gradient(180deg, var(--ir-blue), var(--ir-navy));
    }
    .ir-welcome h1 { font-size: clamp(1.6rem, 3vw, 2.2rem); font-weight: 800; margin: .4rem 0; }
    .ir-welcome p { color: #b9c6e4; margin: 0; }
    .ir-welcome-art { position: absolute; right: 4%; top: 50%; transform: translateY(-50%); width: 260px; opacity: .9; }
    @media (max-width: 991.98px) { .ir-welcome-art { display: none; } }
    .ir-kpis { margin-top: -3.5rem; position: relative; z-index: 3; }
    .ir-kpi {
        display: block; background: #fff; border: 1px solid var(--ir-line); border-radius: 18px; padding: 1.4rem;
        text-decoration: none; color: inherit; height: 100%;
        box-shadow: 0 18px 40px -26px rgba(15,23,42,.35);
        transition: transform .2s ease, border-color .2s ease;
    }
    .ir-kpi:hover { transform: translateY(-4px); border-color: #bfd3fb; color: inherit; }
    .ir-kpi strong { display: block; font-size: 2rem; font-weight: 800; color: var(--ir-ink); font-family: 'Plus Jakarta Sans', sans-serif; line-height: 1.1; margin-top: 1rem; }
    .ir-kpi span { color: var(--ir-muted); font-size: .9rem; }
    .ir-panel { background: #fff; border: 1px solid var(--ir-line); border-radius: 18px; overflow: hidden; }
    .ir-panel-head { display: flex; justify-content: space-between; align-items: center; padding: 1.2rem 1.4rem; border-bottom: 1px solid var(--ir-line); }
    .ir-panel-head h2 { font-size: 1.05rem; font-weight: 700; margin: 0; color: var(--ir-ink); }
    .ir-panel-head a { font-size: .88rem; font-weight: 600; text-decoration: none; }
    .ir-row { display: flex; align-items: center; gap: 1rem; padding: 1rem 1.4rem; border-bottom: 1px solid #f1f5f9; }
    .ir-row:last-child { border-bottom: 0; }
    .ir-avatar {
        width: 40px; height: 40px; border-radius: 50%; flex-shrink: 0; display: grid; place-items: center;
        background: #e8f0ff; color: var(--ir-blue); font-weight: 700; font-size: .85rem;
    }
    .ir-row-main { flex-grow: 1; min-width: 0; }
    .ir-row-main strong { display: block; color: var(--ir-ink); font-size: .95rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .ir-row-main small { color: var(--ir-muted); }
    .ir-status { font-size: .76rem; font-weight: 600; padding: .3rem .7rem; border-radius: 999px; white-space: nowrap; }
    .ir-st-recue { background: #f1f5f9; color: #475569; }
    .ir-st-en_cours_examen { background: #e0f2fe; color: #0369a1; }
    .ir-st-entretien { background: #fff4dc; color: #b45309; }
    .ir-st-acceptee { background: #e3f8ee; color: #15803d; }
    .ir-st-refusee { background: #ffe8ee; color: #be123c; }
    .ir-empty { padding: 2.5rem 1.4rem; text-align: center; color: var(--ir-muted); }
    .ir-empty i { font-size: 2rem; color: #c7d6f5; display: block; margin-bottom: .6rem; }
    .ir-action {
        display: flex; align-items: center; gap: 1rem; padding: 1.1rem 1.2rem; border-radius: 14px;
        border: 1px solid var(--ir-line); background: #fff; text-decoration: none; color: var(--ir-ink);
        transition: border-color .2s ease, transform .2s ease;
    }
    .ir-action:hover { border-color: #bfd3fb; transform: translateX(4px); color: var(--ir-ink); }
    .ir-action .ir-stat-icon { width: 42px; height: 42px; font-size: 1.1rem; }
    .ir-action strong { display: block; font-size: .95rem; }
    .ir-action small { color: var(--ir-muted); }
    .ir-action > i:last-child { margin-left: auto; color: var(--ir-muted); }
</style>
@endpush

@php
    $statutLabels = [
        'recue' => 'Reçue',
        'en_cours_examen' => 'En cours d\'examen',
        'entretien' => 'Entretien',
        'acceptee' => 'Acceptée',
        'refusee' => 'Refusée',
    ];
    $contratTint = [
        'CDI' => 'ir-tint-green',
        'CDD' => 'ir-tint-blue',
        'Stage' => 'ir-tint-amber',
        'Freelance' => 'ir-tint-violet',
    ];
@endphp

@section('content')
@guest
    {{-- ================= HERO ================= --}}
    <section class="ir-bleed ir-hero">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <span class="ir-pill"><b>NOUVEAU</b> La plateforme de recrutement IT au Mali
                        <svg width="20" height="14" viewBox="0 0 3 2" style="border-radius:2px" aria-label="Mali"><rect width="1" height="2" fill="#14b53a"/><rect x="1" width="1" height="2" fill="#fcd116"/><rect x="2" width="1" height="2" fill="#ce1126"/></svg>
                    </span>
                    <h1 class="ir-display">
                        Le talent tech rencontre<br>
                        <span class="ir-grad">la bonne opportunité.</span>
                    </h1>
                    <p class="lead">
                        Développeurs, administrateurs systèmes, experts data et cybersécurité :
                        trouvez votre prochain poste, ou le profil qui fera grandir votre équipe.
                    </p>
                    <div class="d-flex gap-3 flex-wrap mt-4">
                        <a href="{{ route('register') }}" class="ir-btn ir-btn-primary">
                            Créer mon profil gratuit <i class="bi bi-arrow-right"></i>
                        </a>
                        <a href="{{ route('offres.index') }}" class="ir-btn ir-btn-ghost">
                            <i class="bi bi-search"></i> Explorer les offres
                        </a>
                    </div>
                    <div class="ir-hero-proof">
                        <div><strong data-count="{{ $stats['offres'] }}">{{ $stats['offres'] }}</strong><span>offres ouvertes</span></div>
                        <div><strong data-count="{{ $stats['candidats'] }}">{{ $stats['candidats'] }}</strong><span>talents inscrits</span></div>
                        <div><strong>24h</strong><span>pour une première réponse</span></div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="ir-visual" id="irVisual" aria-hidden="true">
                        <svg viewBox="0 0 560 500" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <linearGradient id="irHub" x1="0" y1="0" x2="1" y2="1">
                                    <stop offset="0" stop-color="#3b82f6"/>
                                    <stop offset="1" stop-color="#1e3a8a"/>
                                </linearGradient>
                                <linearGradient id="irBar" x1="0" y1="0" x2="1" y2="0">
                                    <stop offset="0" stop-color="#22d3ee"/>
                                    <stop offset="1" stop-color="#3b82f6"/>
                                </linearGradient>
                                <radialGradient id="irGlow">
                                    <stop offset="0" stop-color="#3b82f6" stop-opacity=".55"/>
                                    <stop offset="1" stop-color="#3b82f6" stop-opacity="0"/>
                                </radialGradient>
                                <filter id="irShadow" x="-20%" y="-20%" width="140%" height="160%">
                                    <feDropShadow dx="0" dy="12" stdDeviation="14" flood-color="#020617" flood-opacity=".55"/>
                                </filter>
                                <g id="irPerson">
                                    <circle cx="0" cy="-5" r="6" fill="#fff"/>
                                    <path d="M-10 12 a10 9 0 0 1 20 0 z" fill="#fff"/>
                                </g>
                                <path id="irP1" d="M280 250 L280 80"/>
                                <path id="irP2" d="M280 250 L427 165"/>
                                <path id="irP3" d="M280 250 L427 335"/>
                                <path id="irP4" d="M280 250 L280 420"/>
                                <path id="irP5" d="M280 250 L133 335"/>
                                <path id="irP6" d="M280 250 L133 165"/>
                            </defs>

                            {{-- Couche fond : halo + orbites --}}
                            <g class="ir-layer" data-depth="6">
                                <circle cx="280" cy="250" r="200" fill="url(#irGlow)"/>
                                <g class="ir-orbit-a">
                                    <circle cx="280" cy="250" r="170" fill="none" stroke="rgba(255,255,255,.12)" stroke-dasharray="2 8"/>
                                    <circle cx="450" cy="250" r="4" fill="#22d3ee"/>
                                </g>
                                <g class="ir-orbit-b">
                                    <circle cx="280" cy="250" r="225" fill="none" stroke="rgba(255,255,255,.07)"/>
                                    <circle cx="280" cy="25" r="3" fill="#f59e0b"/>
                                    <circle cx="80" cy="355" r="2.5" fill="#a5b4fc"/>
                                </g>
                            </g>

                            {{-- Couche réseau : liens, paquets, nœuds --}}
                            <g class="ir-layer" data-depth="14">
                                <g stroke="rgba(147,197,253,.45)" stroke-width="1.5" fill="none">
                                    <use href="#irP1" class="ir-link"/>
                                    <use href="#irP2" class="ir-link"/>
                                    <use href="#irP3" class="ir-link"/>
                                    <use href="#irP4" class="ir-link"/>
                                    <use href="#irP5" class="ir-link"/>
                                    <use href="#irP6" class="ir-link"/>
                                </g>

                                {{-- Paquets : candidatures qui arrivent / réponses qui repartent --}}
                                <circle r="4" fill="#22d3ee"><animateMotion dur="2.6s" repeatCount="indefinite" keyPoints="1;0" keyTimes="0;1" calcMode="linear"><mpath href="#irP1"/></animateMotion></circle>
                                <circle r="4" fill="#f59e0b"><animateMotion dur="3.2s" begin="-1s" repeatCount="indefinite"><mpath href="#irP2"/></animateMotion></circle>
                                <circle r="4" fill="#22d3ee"><animateMotion dur="2.9s" begin="-.5s" repeatCount="indefinite" keyPoints="1;0" keyTimes="0;1" calcMode="linear"><mpath href="#irP3"/></animateMotion></circle>
                                <circle r="4" fill="#a5b4fc"><animateMotion dur="3.6s" begin="-2s" repeatCount="indefinite" keyPoints="1;0" keyTimes="0;1" calcMode="linear"><mpath href="#irP4"/></animateMotion></circle>
                                <circle r="4" fill="#f59e0b"><animateMotion dur="3s" begin="-1.4s" repeatCount="indefinite"><mpath href="#irP5"/></animateMotion></circle>
                                <circle r="4" fill="#22d3ee"><animateMotion dur="2.7s" begin="-.8s" repeatCount="indefinite" keyPoints="1;0" keyTimes="0;1" calcMode="linear"><mpath href="#irP6"/></animateMotion></circle>

                                {{-- Nœuds candidats --}}
                                <g class="ir-node" style="animation-delay:0s"><circle cx="280" cy="80" r="24" fill="#12224f" stroke="#22d3ee" stroke-width="2"/><use href="#irPerson" x="280" y="80"/></g>
                                <g class="ir-node" style="animation-delay:-.5s"><circle cx="427" cy="165" r="24" fill="#12224f" stroke="#f59e0b" stroke-width="2"/><use href="#irPerson" x="427" y="165"/></g>
                                <g class="ir-node" style="animation-delay:-1s"><circle cx="427" cy="335" r="24" fill="#12224f" stroke="#3b82f6" stroke-width="2"/><use href="#irPerson" x="427" y="335"/></g>
                                <g class="ir-node" style="animation-delay:-1.5s"><circle cx="280" cy="420" r="24" fill="#12224f" stroke="#a5b4fc" stroke-width="2"/><use href="#irPerson" x="280" y="420"/></g>
                                <g class="ir-node" style="animation-delay:-2s"><circle cx="133" cy="335" r="24" fill="#12224f" stroke="#22d3ee" stroke-width="2"/><use href="#irPerson" x="133" y="335"/></g>
                                <g class="ir-node" style="animation-delay:-2.5s"><circle cx="133" cy="165" r="24" fill="#12224f" stroke="#f59e0b" stroke-width="2"/><use href="#irPerson" x="133" y="165"/></g>

                                {{-- Hub central : l'entreprise --}}
                                <circle cx="280" cy="250" r="48" fill="none" stroke="#3b82f6" stroke-width="2">
                                    <animate attributeName="r" values="48;105" dur="2.8s" repeatCount="indefinite"/>
                                    <animate attributeName="opacity" values=".7;0" dur="2.8s" repeatCount="indefinite"/>
                                </circle>
                                <circle cx="280" cy="250" r="48" fill="none" stroke="#22d3ee" stroke-width="1.5">
                                    <animate attributeName="r" values="48;105" dur="2.8s" begin="1.4s" repeatCount="indefinite"/>
                                    <animate attributeName="opacity" values=".6;0" dur="2.8s" begin="1.4s" repeatCount="indefinite"/>
                                </circle>
                                <rect x="238" y="208" width="84" height="84" rx="24" fill="url(#irHub)" filter="url(#irShadow)"/>
                                <rect x="238.5" y="208.5" width="83" height="83" rx="23.5" fill="none" stroke="rgba(255,255,255,.25)"/>
                                <g fill="none" stroke="#fff" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="261" y="238" width="38" height="28" rx="5"/>
                                    <path d="M271 238 v-5 a3 3 0 0 1 3 -3 h12 a3 3 0 0 1 3 3 v5"/>
                                    <path d="M261 250 h38"/>
                                </g>
                            </g>

                            {{-- Couche avant : cartes flottantes --}}
                            <g class="ir-layer" data-depth="26">
                                {{-- Carte code --}}
                                <g class="ir-float-1">
                                    <g filter="url(#irShadow)">
                                        <rect x="8" y="30" width="196" height="118" rx="14" fill="#0f1d45" stroke="rgba(255,255,255,.12)"/>
                                    </g>
                                    <circle cx="26" cy="48" r="4" fill="#f87171"/>
                                    <circle cx="40" cy="48" r="4" fill="#fbbf24"/>
                                    <circle cx="54" cy="48" r="4" fill="#34d399"/>
                                    <text x="120" y="52" fill="#64748b" font-size="10" font-family="monospace">profil.php</text>
                                    <rect x="24" y="68" width="38" height="7" rx="3.5" fill="#a5b4fc"/>
                                    <rect x="68" y="68" width="70" height="7" rx="3.5" fill="#22d3ee"/>
                                    <rect x="36" y="84" width="54" height="7" rx="3.5" fill="#f59e0b"/>
                                    <rect x="96" y="84" width="60" height="7" rx="3.5" fill="#475569"/>
                                    <rect x="36" y="100" width="90" height="7" rx="3.5" fill="#34d399"/>
                                    <rect x="24" y="116" width="28" height="7" rx="3.5" fill="#a5b4fc"/>
                                    <rect x="58" y="114" width="2" height="12" fill="#fff" class="ir-cursor"/>
                                </g>

                                {{-- Notification entretien --}}
                                <g class="ir-float-2">
                                    <g filter="url(#irShadow)">
                                        <rect x="360" y="28" width="192" height="54" rx="14" fill="#fff"/>
                                    </g>
                                    <circle cx="386" cy="55" r="15" fill="#fff4dc"/>
                                    <path d="M380 59 h12 l-1.5 -2 v-5 a4.5 4.5 0 0 0 -9 0 v5 z M384 61 a2 2 0 0 0 4 0" fill="none" stroke="#b45309" stroke-width="1.8" stroke-linejoin="round"/>
                                    <text x="410" y="51" fill="#0f172a" font-size="12.5" font-weight="700">Entretien confirmé</text>
                                    <text x="410" y="68" fill="#64748b" font-size="11">Demain · 10h00</text>
                                    <circle cx="540" cy="40" r="5" fill="#ef4444">
                                        <animate attributeName="opacity" values="1;.3;1" dur="1.6s" repeatCount="indefinite"/>
                                    </circle>
                                </g>

                                {{-- Carte compatibilité --}}
                                <g class="ir-float-3">
                                    <g filter="url(#irShadow)">
                                        <rect x="344" y="388" width="208" height="96" rx="16" fill="#fff"/>
                                    </g>
                                    <circle cx="372" cy="418" r="15" fill="#e8f0ff"/>
                                    <circle cx="372" cy="414" r="4.8" fill="#1e3a8a"/>
                                    <path d="M364 427.5 a8 7 0 0 1 16 0 z" fill="#1e3a8a"/>
                                    <text x="396" y="414" fill="#0f172a" font-size="12.5" font-weight="700">Aminata T.</text>
                                    <text x="396" y="430" fill="#64748b" font-size="11">Développeuse Laravel</text>
                                    <rect x="360" y="452" width="150" height="8" rx="4" fill="#e2e8f0"/>
                                    <rect x="360" y="452" width="144" height="8" rx="4" fill="url(#irBar)" class="ir-bar-fill"/>
                                    <text x="518" y="460" fill="#15803d" font-size="11.5" font-weight="700">96%</text>
                                    <text x="360" y="476" fill="#64748b" font-size="10">Compatibilité avec l'offre</text>
                                </g>

                                {{-- Étiquettes techno --}}
                                <g class="ir-float-2" font-size="11" font-weight="600">
                                    <rect x="14" y="232" width="70" height="26" rx="13" fill="rgba(34,211,238,.14)" stroke="rgba(34,211,238,.5)"/>
                                    <text x="49" y="249" text-anchor="middle" fill="#a5f3fc">Laravel</text>
                                </g>
                                <g class="ir-float-1" font-size="11" font-weight="600">
                                    <rect x="482" y="232" width="62" height="26" rx="13" fill="rgba(245,158,11,.14)" stroke="rgba(245,158,11,.5)"/>
                                    <text x="513" y="249" text-anchor="middle" fill="#fde68a">React</text>
                                </g>
                                <g class="ir-float-3" font-size="11" font-weight="600">
                                    <rect x="40" y="420" width="72" height="26" rx="13" fill="rgba(165,180,252,.14)" stroke="rgba(165,180,252,.5)"/>
                                    <text x="76" y="437" text-anchor="middle" fill="#c7d2fe">DevOps</text>
                                </g>
                            </g>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= STATISTIQUES ================= --}}
    <div class="ir-stats row g-0 fade-in-up">
        <div class="col-md-4 ir-stat">
            <div class="ir-stat-icon ir-tint-blue"><i class="bi bi-briefcase-fill"></i></div>
            <div><strong data-count="{{ $stats['offres'] }}">{{ $stats['offres'] }}</strong><span>Offres d'emploi ouvertes</span></div>
        </div>
        <div class="col-md-4 ir-stat">
            <div class="ir-stat-icon ir-tint-cyan"><i class="bi bi-people-fill"></i></div>
            <div><strong data-count="{{ $stats['candidats'] }}">{{ $stats['candidats'] }}</strong><span>Talents IT inscrits</span></div>
        </div>
        <div class="col-md-4 ir-stat">
            <div class="ir-stat-icon ir-tint-amber"><i class="bi bi-send-fill"></i></div>
            <div><strong data-count="{{ $stats['candidatures'] }}">{{ $stats['candidatures'] }}</strong><span>Candidatures envoyées</span></div>
        </div>
    </div>

    {{-- ================= OFFRES À LA UNE (défilement automatique) ================= --}}
    <section class="ir-section" id="irOffres">
        <div class="d-flex justify-content-between align-items-end flex-wrap gap-3 mb-5">
            <div class="ir-section-head mb-0">
                <span class="ir-eyebrow">Offres à la une</span>
                <h2 class="ir-display">Les dernières opportunités</h2>
                <p>Des postes 100&nbsp;% informatique, publiés par des recruteurs vérifiés.</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                @if ($offresAlaUne->count() > 0)
                    <button type="button" class="ir-arrow" data-dir="-1" aria-label="Offres précédentes"><i class="bi bi-arrow-left"></i></button>
                    <button type="button" class="ir-arrow" data-dir="1" aria-label="Offres suivantes"><i class="bi bi-arrow-right"></i></button>
                @endif
                <a href="{{ route('offres.index') }}" class="ir-btn ir-btn-light ms-2">Toutes les offres <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>

        @if ($offresAlaUne->count() > 0)
            <div class="ir-marquee" id="irMarquee">
                <div class="ir-marquee-track" id="irTrack">
                    @foreach ($offresAlaUne as $offre)
                        <a href="{{ route('login') }}" class="ir-job ir-slide">
                            <div class="ir-job-top">
                                <div class="ir-job-logo">{{ strtoupper(mb_substr($offre->titre, 0, 1)) }}</div>
                                <span class="ir-chip {{ $contratTint[$offre->type_contrat] ?? 'ir-tint-blue' }}">{{ $offre->type_contrat }}</span>
                            </div>
                            <h3>{{ $offre->titre }}</h3>
                            <p>{{ Str::limit($offre->description, 95) }}</p>
                            <div class="ir-job-meta">
                                <span><i class="bi bi-geo-alt me-1"></i>{{ $offre->lieu }}</span>
                                <span><i class="bi bi-calendar-event me-1"></i>{{ \Carbon\Carbon::parse($offre->date_limite)->format('d/m/Y') }}</span>
                                <span class="ir-job-cta">Postuler <i class="bi bi-arrow-right"></i></span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
            <p class="ir-marquee-hint"><i class="bi bi-pause-circle"></i> Survolez les offres pour mettre le défilement en pause</p>
        @else
            <div class="ir-panel ir-empty"><i class="bi bi-briefcase"></i>Aucune offre ouverte pour le moment, revenez bientôt.</div>
        @endif
    </section>

    {{-- ================= MÉTIERS ================= --}}
    <section class="pb-5 mb-4">
        <div class="ir-section-head">
            <span class="ir-eyebrow">Métiers</span>
            <h2 class="ir-display">Tous les métiers du numérique</h2>
            <p>Que vous codiez, sécurisiez ou fassiez tourner l'infrastructure, il y a une place pour vous.</p>
        </div>
        <div class="row g-3">
            @foreach ([
                ['bi-code-slash', 'ir-tint-blue', 'Développement web', 'Laravel, React, Vue, Node.js…'],
                ['bi-phone', 'ir-tint-cyan', 'Développement mobile', 'Android, iOS, Flutter'],
                ['bi-hdd-network', 'ir-tint-amber', 'Réseaux & systèmes', 'Administration, Linux, Windows Server'],
                ['bi-bar-chart-line', 'ir-tint-green', 'Data & IA', 'Analyse de données, BI, machine learning'],
                ['bi-shield-lock', 'ir-tint-rose', 'Cybersécurité', 'Audit, SOC, sécurité applicative'],
                ['bi-cloud-arrow-up', 'ir-tint-violet', 'Cloud & DevOps', 'CI/CD, Docker, AWS, Azure'],
            ] as [$icone, $teinte, $titre, $texte])
                <div class="col-md-6 col-lg-4">
                    <div class="ir-domain fade-in-up" style="transition-delay: {{ $loop->index * 0.05 }}s;">
                        <div class="ir-stat-icon {{ $teinte }}"><i class="bi {{ $icone }}"></i></div>
                        <div><h4>{{ $titre }}</h4><p>{{ $texte }}</p></div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ================= COMMENT ÇA MARCHE ================= --}}
    <section class="ir-bleed ir-steps-wrap ir-section">
        <div class="container">
            <div class="d-flex justify-content-between align-items-end flex-wrap gap-3 mb-5">
                <div class="ir-section-head mb-0">
                    <span class="ir-eyebrow">Comment ça marche</span>
                    <h2 class="ir-display">Simple, rapide, transparent</h2>
                    <p>Un parcours clair, que vous cherchiez un poste ou un talent.</p>
                </div>
                <div class="ir-tabs" role="tablist">
                    <button type="button" class="active" data-tab="candidat">Je suis candidat</button>
                    <button type="button" data-tab="recruteur">Je recrute</button>
                </div>
            </div>

            <div class="row g-5 align-items-stretch">
                <div class="col-lg-7">
                    <div data-panel="candidat">
                        <div class="ir-step"><div class="ir-step-num">1</div><h4>Créez votre profil</h4><p>Inscription en deux minutes : nom, pays, téléphone. C'est gratuit.</p></div>
                        <div class="ir-step"><div class="ir-step-num">2</div><h4>Postulez avec votre CV</h4><p>Parcourez les offres, joignez votre CV en PDF et une lettre de motivation si vous le souhaitez.</p></div>
                        <div class="ir-step"><div class="ir-step-num">3</div><h4>Suivez chaque étape</h4><p>Une notification à chaque changement de statut, jusqu'à la date d'entretien et la décision finale.</p></div>
                    </div>
                    <div data-panel="recruteur" hidden>
                        <div class="ir-step"><div class="ir-step-num">1</div><h4>Publiez votre offre</h4><p>Missions, compétences, profil recherché, type de contrat et date limite.</p></div>
                        <div class="ir-step"><div class="ir-step-num">2</div><h4>Recevez des candidatures qualifiées</h4><p>Consultez les CV et lettres de motivation depuis votre tableau de bord.</p></div>
                        <div class="ir-step"><div class="ir-step-num">3</div><h4>Décidez et informez</h4><p>Planifiez un entretien, acceptez ou refusez : le candidat est notifié automatiquement.</p></div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="ir-steps-card">
                        <span class="ir-eyebrow" style="color:#22d3ee">Pourquoi JobIT</span>
                        <h3 class="ir-display fw-bold mt-2 mb-0" style="font-size:1.5rem;">Une plateforme pensée pour la tech malienne</h3>
                        <ul class="ir-check">
                            <li><i class="bi bi-check-circle-fill"></i>Uniquement des offres en informatique</li>
                            <li><i class="bi bi-check-circle-fill"></i>Suivi en temps réel de vos candidatures</li>
                            <li><i class="bi bi-check-circle-fill"></i>Notifications à chaque décision</li>
                            <li><i class="bi bi-check-circle-fill"></i>Gratuit pour les candidats</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= APPEL À L'ACTION ================= --}}
    <section class="pt-5 mt-4">
        <div class="ir-cta fade-in-up">
            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <h2 class="ir-display mb-2">Votre prochain poste tech commence ici.</h2>
                    <p class="mb-0">Rejoignez les talents qui ont déjà franchi le pas.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="{{ route('register') }}" class="ir-btn ir-btn-primary">S'inscrire gratuitement <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </section>


@elseif (auth()->user()->isRecruteur())
    {{-- ================= ESPACE RECRUTEUR ================= --}}
    <section class="ir-bleed ir-welcome">
        <div class="container position-relative">
            <span class="ir-eyebrow" style="color:#22d3ee">Espace recruteur</span>
            <h1 class="ir-display">Bonjour, {{ auth()->user()->name }} 👋</h1>
            <p>Voici où en est votre recrutement aujourd'hui.</p>
            <div class="d-flex gap-3 flex-wrap mt-4">
                <a href="{{ route('offres.create') }}" class="ir-btn ir-btn-primary"><i class="bi bi-plus-lg"></i> Publier une offre</a>
                <a href="{{ route('dashboard') }}" class="ir-btn ir-btn-ghost"><i class="bi bi-speedometer2"></i> Tableau de bord</a>
            </div>
        </div>
        @include('partials.welcome-art')
    </section>

    <div class="row g-4 ir-kpis">
        <div class="col-md-4">
            <a href="{{ route('offres.index') }}" class="ir-kpi fade-in-up">
                <div class="ir-stat-icon ir-tint-blue"><i class="bi bi-briefcase-fill"></i></div>
                <strong data-count="{{ $stats['offres'] }}">{{ $stats['offres'] }}</strong><span>Offres ouvertes</span>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('candidats.index') }}" class="ir-kpi fade-in-up" style="transition-delay:.05s">
                <div class="ir-stat-icon ir-tint-cyan"><i class="bi bi-people-fill"></i></div>
                <strong data-count="{{ $stats['candidats'] }}">{{ $stats['candidats'] }}</strong><span>Candidats inscrits</span>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('candidatures.index') }}" class="ir-kpi fade-in-up" style="transition-delay:.1s">
                <div class="ir-stat-icon ir-tint-amber"><i class="bi bi-file-earmark-text-fill"></i></div>
                <strong data-count="{{ $stats['candidatures'] }}">{{ $stats['candidatures'] }}</strong><span>Candidatures reçues</span>
            </a>
        </div>
    </div>

    <div class="row g-4 mt-1 mb-5">
        <div class="col-lg-8">
            <div class="ir-panel fade-in-up">
                <div class="ir-panel-head">
                    <h2>Dernières candidatures</h2>
                    <a href="{{ route('candidatures.index') }}">Tout voir <i class="bi bi-arrow-right"></i></a>
                </div>
                @forelse ($dernieresCandidatures as $c)
                    <div class="ir-row">
                        <div class="ir-avatar">{{ strtoupper(mb_substr($c->candidat->nom, 0, 1) . mb_substr($c->candidat->prenom, 0, 1)) }}</div>
                        <div class="ir-row-main">
                            <strong>{{ $c->candidat->nom }} {{ $c->candidat->prenom }}</strong>
                            <small>{{ $c->offre->titre }}</small>
                        </div>
                        <span class="ir-status ir-st-{{ $c->statut }}">{{ $statutLabels[$c->statut] ?? $c->statut }}</span>
                        <a href="{{ route('candidatures.edit', $c) }}" class="btn btn-sm btn-outline-primary">Traiter</a>
                    </div>
                @empty
                    <div class="ir-empty"><i class="bi bi-inbox"></i>Aucune candidature reçue pour le moment.</div>
                @endforelse
            </div>
        </div>
        <div class="col-lg-4">
            <div class="d-grid gap-3 fade-in-up">
                <a href="{{ route('offres.create') }}" class="ir-action">
                    <div class="ir-stat-icon ir-tint-blue"><i class="bi bi-plus-lg"></i></div>
                    <div><strong>Nouvelle offre</strong><small>Publier un poste</small></div>
                    <i class="bi bi-chevron-right"></i>
                </a>
                <a href="{{ route('candidatures.index') }}" class="ir-action">
                    <div class="ir-stat-icon ir-tint-amber"><i class="bi bi-list-check"></i></div>
                    <div><strong>Traiter les candidatures</strong><small>Changer les statuts</small></div>
                    <i class="bi bi-chevron-right"></i>
                </a>
                <a href="{{ route('candidats.index') }}" class="ir-action">
                    <div class="ir-stat-icon ir-tint-cyan"><i class="bi bi-person-lines-fill"></i></div>
                    <div><strong>Vivier de talents</strong><small>Consulter les profils</small></div>
                    <i class="bi bi-chevron-right"></i>
                </a>
            </div>
        </div>
    </div>

@else
    {{-- ================= ESPACE CANDIDAT ================= --}}
    <section class="ir-bleed ir-welcome">
        <div class="container position-relative">
            <span class="ir-eyebrow" style="color:#22d3ee">Espace candidat</span>
            <h1 class="ir-display">Bonjour, {{ auth()->user()->name }} 👋</h1>
            <p>Trouvez votre prochaine opportunité et suivez vos candidatures.</p>
            <div class="d-flex gap-3 flex-wrap mt-4">
                <a href="{{ route('offres.index') }}" class="ir-btn ir-btn-primary"><i class="bi bi-search"></i> Explorer les offres</a>
                <a href="{{ route('notifications.index') }}" class="ir-btn ir-btn-ghost"><i class="bi bi-bell"></i> Mes notifications</a>
            </div>
        </div>
        @include('partials.welcome-art')
    </section>

    <div class="row g-4 ir-kpis">
        @foreach ([
            ['total', 'bi-send-fill', 'ir-tint-blue', 'Candidatures envoyées'],
            ['en_cours', 'bi-hourglass-split', 'ir-tint-cyan', 'En cours d\'examen'],
            ['entretien', 'bi-calendar-check', 'ir-tint-amber', 'Entretiens'],
            ['acceptee', 'bi-trophy-fill', 'ir-tint-green', 'Acceptées'],
        ] as [$cle, $icone, $teinte, $libelle])
            <div class="col-6 col-lg-3">
                <a href="{{ route('candidatures.mes') }}" class="ir-kpi fade-in-up" style="transition-delay: {{ $loop->index * 0.05 }}s;">
                    <div class="ir-stat-icon {{ $teinte }}"><i class="bi {{ $icone }}"></i></div>
                    <strong data-count="{{ $mesStats[$cle] ?? 0 }}">{{ $mesStats[$cle] ?? 0 }}</strong><span>{{ $libelle }}</span>
                </a>
            </div>
        @endforeach
    </div>

    <div class="row g-4 mt-1">
        <div class="col-lg-6">
            <div class="ir-panel h-100 fade-in-up">
                <div class="ir-panel-head">
                    <h2>Mes dernières candidatures</h2>
                    <a href="{{ route('candidatures.mes') }}">Tout voir <i class="bi bi-arrow-right"></i></a>
                </div>
                @forelse ($mesCandidatures as $c)
                    <div class="ir-row">
                        <div class="ir-avatar"><i class="bi bi-briefcase"></i></div>
                        <div class="ir-row-main">
                            <strong>{{ $c->offre->titre ?? 'Offre supprimée' }}</strong>
                            <small>Envoyée le {{ \Carbon\Carbon::parse($c->date_candidature)->format('d/m/Y') }}</small>
                        </div>
                        <span class="ir-status ir-st-{{ $c->statut }}">{{ $statutLabels[$c->statut] ?? $c->statut }}</span>
                    </div>
                @empty
                    <div class="ir-empty">
                        <i class="bi bi-send"></i>Vous n'avez pas encore postulé.
                        <div class="mt-3"><a href="{{ route('offres.index') }}" class="ir-btn ir-btn-dark">Voir les offres</a></div>
                    </div>
                @endforelse
            </div>
        </div>
        <div class="col-lg-6">
            <div class="ir-panel h-100 fade-in-up" style="transition-delay:.05s">
                <div class="ir-panel-head">
                    <h2>Offres récentes pour vous</h2>
                    <a href="{{ route('offres.index') }}">Tout voir <i class="bi bi-arrow-right"></i></a>
                </div>
                @forelse ($offresAlaUne->take(4) as $offre)
                    <a href="{{ route('offres.show', $offre) }}" class="ir-row text-decoration-none">
                        <div class="ir-job-logo" style="width:40px;height:40px;font-size:.9rem;">{{ strtoupper(mb_substr($offre->titre, 0, 1)) }}</div>
                        <div class="ir-row-main">
                            <strong>{{ $offre->titre }}</strong>
                            <small><i class="bi bi-geo-alt"></i> {{ $offre->lieu }}</small>
                        </div>
                        <span class="ir-chip {{ $contratTint[$offre->type_contrat] ?? 'ir-tint-blue' }}">{{ $offre->type_contrat }}</span>
                    </a>
                @empty
                    <div class="ir-empty"><i class="bi bi-briefcase"></i>Aucune offre ouverte pour le moment.</div>
                @endforelse
            </div>
        </div>
    </div>
    <div class="mb-5"></div>
@endguest
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    // Parallaxe du SVG du hero
    const visual = document.getElementById('irVisual');
    if (visual && !reduce) {
        const layers = visual.querySelectorAll('.ir-layer');
        visual.closest('.ir-hero').addEventListener('mousemove', function (e) {
            const r = visual.getBoundingClientRect();
            const x = (e.clientX - (r.left + r.width / 2)) / r.width;
            const y = (e.clientY - (r.top + r.height / 2)) / r.height;
            layers.forEach(l => {
                const d = parseFloat(l.dataset.depth);
                l.style.transform = `translate(${x * d}px, ${y * d}px)`;
            });
        });
    }

    // Compteurs animés
    const counters = document.querySelectorAll('[data-count]');
    const animate = el => {
        const target = parseInt(el.dataset.count, 10) || 0;
        if (reduce || target === 0) return;
        const start = performance.now(), dur = 1200;
        const step = now => {
            const p = Math.min((now - start) / dur, 1);
            el.textContent = Math.round(target * (1 - Math.pow(1 - p, 3)));
            if (p < 1) requestAnimationFrame(step);
        };
        requestAnimationFrame(step);
    };
    const io = new IntersectionObserver(entries => {
        entries.forEach(en => { if (en.isIntersecting) { animate(en.target); io.unobserve(en.target); } });
    }, { threshold: .6 });
    counters.forEach(c => io.observe(c));

    // Offres à la une : défilement continu de droite à gauche, pause au survol, flèches
    const marquee = document.getElementById('irMarquee');
    if (marquee) {
        const section = document.getElementById('irOffres');
        const track = document.getElementById('irTrack');
        const originals = Array.from(track.children);
        const speed = 0.5;          // pixels par image (~30 px/s)
        let paused = false, manualUntil = 0, loopWidth = 0;

        // Duplique les cartes pour une boucle sans coupure (les copies sont ignorées au clavier et par les lecteurs d'écran)
        function buildLoop() {
            track.querySelectorAll('[data-clone]').forEach(c => c.remove());
            const addSet = () => originals.forEach(o => {
                const c = o.cloneNode(true);
                c.dataset.clone = '';
                c.setAttribute('aria-hidden', 'true');
                c.tabIndex = -1;
                track.appendChild(c);
            });
            addSet();
            loopWidth = track.children[originals.length].offsetLeft - originals[0].offsetLeft;
            while (track.scrollWidth < loopWidth + marquee.clientWidth * 2) addSet();
        }
        buildLoop();
        window.addEventListener('resize', () => { buildLoop(); });

        // Ramène la position dans la première copie pour boucler à l'infini
        const wrap = () => {
            if (marquee.scrollLeft >= loopWidth) marquee.scrollLeft -= loopWidth;
            else if (marquee.scrollLeft < 0) marquee.scrollLeft += loopWidth;
        };

        let pos = marquee.scrollLeft;
        function tick() {
            if (!paused && !reduce && performance.now() > manualUntil) {
                pos += speed;
                if (pos >= loopWidth) pos -= loopWidth;
                marquee.scrollLeft = pos;
            } else {
                pos = marquee.scrollLeft;
            }
            requestAnimationFrame(tick);
        }
        requestAnimationFrame(tick);

        // Pause dès que la souris approche (section entière, flèches comprises) ou au clavier
        const setPaused = v => { paused = v; section.classList.toggle('is-paused', v); };
        section.addEventListener('mouseenter', () => setPaused(true));
        section.addEventListener('mouseleave', () => setPaused(false));
        section.addEventListener('focusin', () => setPaused(true));
        section.addEventListener('focusout', e => { if (!section.contains(e.relatedTarget)) setPaused(false); });
        // Sur mobile : le doigt fait défiler, l'auto reprend 3 s après le dernier contact
        let touching = false;
        marquee.addEventListener('touchstart', () => { touching = true; manualUntil = Infinity; }, { passive: true });
        marquee.addEventListener('touchend', () => { touching = false; manualUntil = performance.now() + 3000; }, { passive: true });
        marquee.addEventListener('scroll', () => { if (touching) wrap(); }, { passive: true });

        // Flèches : une carte à la fois. On recale la boucle AVANT l'animation pour ne jamais l'interrompre.
        section.querySelectorAll('.ir-arrow').forEach(btn => btn.addEventListener('click', () => {
            const gap = parseFloat(getComputedStyle(track).columnGap) || 24;
            const step = originals[0].getBoundingClientRect().width + gap;
            const dir = Number(btn.dataset.dir);
            if (dir < 0 && marquee.scrollLeft - step < 0) marquee.scrollLeft += loopWidth;
            if (dir > 0 && marquee.scrollLeft + step >= loopWidth) marquee.scrollLeft -= loopWidth;
            manualUntil = performance.now() + 800;
            marquee.scrollBy({ left: dir * step, behavior: reduce ? 'auto' : 'smooth' });
        }));
    }

    // Onglets candidat / recruteur
    document.querySelectorAll('.ir-tabs button').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.ir-tabs button').forEach(b => b.classList.toggle('active', b === btn));
            document.querySelectorAll('[data-panel]').forEach(p => p.hidden = p.dataset.panel !== btn.dataset.tab);
        });
    });
});
</script>
@endpush
