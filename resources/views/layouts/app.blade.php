<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@hasSection('title') @yield('title') · JobIT @else JobIT · Emplois tech au Mali @endif</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <meta name="theme-color" content="#0b1533">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
    <style>
    :root {
        --ir-navy: #0b1533;
        --ir-navy-2: #12224f;
        --ir-blue: #1e3a8a;
        --ir-sky: #3b82f6;
        --ir-cyan: #22d3ee;
        --ir-amber: #f59e0b;
        --ir-ink: #0f172a;
        --ir-muted: #64748b;
        --ir-line: #e2e8f0;
        --ir-soft: #f5f8ff;
        /* Hauteur occupée par la barre de navigation flottante (marges comprises) */
        --ir-nav-h: 92px;
    }
    body {
    font-family: 'Inter', sans-serif;
    background: linear-gradient(180deg, #eef3fc 0%, #f6f9fd 400px, #f6f9fd 100%);
    color: #2d2f36;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}
    .ir-main { flex: 1 0 auto; }

    /* ---------- Barre de navigation flottante ---------- */
    .ir-nav-wrap {
        position: sticky; top: 0; z-index: 1030;
        padding: 14px 0;
    }
    .ir-nav {
        min-height: 64px;
        padding: .55rem .6rem .55rem 1.1rem;
        border-radius: 18px;
        background: rgba(11, 21, 51, .9);
        backdrop-filter: blur(14px) saturate(140%);
        -webkit-backdrop-filter: blur(14px) saturate(140%);
        border: 1px solid rgba(255, 255, 255, .09);
        box-shadow: 0 14px 36px -14px rgba(2, 6, 23, .55);
        transition: background .25s ease, box-shadow .25s ease;
    }
    .ir-nav-wrap.is-scrolled .ir-nav {
        background: rgba(11, 21, 51, .94);
        box-shadow: 0 18px 40px -12px rgba(2, 6, 23, .6);
    }
    .ir-brand {
        display: inline-flex; align-items: center; gap: .6rem;
        font-family: 'Plus Jakarta Sans', 'Inter', sans-serif; font-weight: 800; font-size: 1.3rem;
        color: #fff; text-decoration: none; letter-spacing: -.035em;
        --logo-ink: #fff; --logo-knock: var(--ir-navy); --logo-accent: var(--ir-cyan);
    }
    .ir-brand:hover { color: #fff; }
    .ir-brand em { font-style: normal; color: var(--ir-cyan); }
    .ir-brand .ir-logo { flex-shrink: 0; transition: transform .3s cubic-bezier(.2,.8,.2,1); }
    .ir-brand:hover .ir-logo { transform: rotate(-8deg) scale(1.06); }
    .ir-links { list-style: none; margin: 0; padding: 0; display: flex; gap: .25rem; }
    .ir-link {
        position: relative; display: inline-flex; align-items: center; gap: .45rem;
        padding: .55rem .95rem; border-radius: 11px;
        color: #a9b7d6; font-weight: 500; font-size: .93rem; text-decoration: none;
        transition: color .2s ease, background .2s ease;
    }
    .ir-link:hover { color: #fff; background: rgba(255, 255, 255, .06); }
    .ir-link.active {
        color: #fff; background: rgba(255, 255, 255, .11);
        box-shadow: inset 0 0 0 1px rgba(255, 255, 255, .1);
    }
    .ir-link.active::after {
        content: ''; position: absolute; left: 50%; bottom: 3px; transform: translateX(-50%);
        width: 16px; height: 3px; border-radius: 3px; background: var(--ir-cyan);
        box-shadow: 0 0 10px var(--ir-cyan);
    }
    .ir-nav-right { display: flex; align-items: center; gap: .5rem; }
    .ir-icon-btn {
        position: relative; width: 42px; height: 42px; border-radius: 12px; display: grid; place-items: center;
        color: #c9d5f0; background: rgba(255, 255, 255, .06); text-decoration: none; font-size: 1.05rem;
        transition: background .2s ease, color .2s ease;
    }
    .ir-icon-btn:hover, .ir-icon-btn.active { color: #fff; background: rgba(255, 255, 255, .14); }
    .ir-icon-btn.active { box-shadow: inset 0 0 0 1px var(--ir-cyan); }
    .ir-dot {
        position: absolute; top: 6px; right: 6px; min-width: 17px; height: 17px; padding: 0 4px;
        border-radius: 999px; background: #ef4444; color: #fff; font-size: .62rem; font-weight: 700;
        display: grid; place-items: center; box-shadow: 0 0 0 2px var(--ir-navy);
    }
    .ir-user {
        display: flex; align-items: center; gap: .6rem; padding: .3rem .7rem .3rem .3rem;
        border-radius: 13px; background: rgba(255, 255, 255, .06); border: 0; color: #fff;
        transition: background .2s ease;
    }
    .ir-user:hover, .ir-user[aria-expanded="true"] { background: rgba(255, 255, 255, .13); }
    .ir-user-avatar {
        width: 34px; height: 34px; border-radius: 10px; display: grid; place-items: center;
        background: linear-gradient(135deg, var(--ir-cyan), var(--ir-sky)); color: var(--ir-navy);
        font-weight: 800; font-size: .8rem;
    }
    .ir-user-meta { text-align: left; line-height: 1.15; }
    .ir-user-meta strong { display: block; font-size: .86rem; font-weight: 600; }
    .ir-user-meta small { color: #8fa0c6; font-size: .72rem; text-transform: capitalize; }
    .ir-menu {
        border: 1px solid var(--ir-line); border-radius: 14px; padding: .4rem; min-width: 230px;
        box-shadow: 0 20px 40px -16px rgba(15, 23, 42, .35); margin-top: .6rem !important;
    }
    .ir-menu .dropdown-item { border-radius: 9px; padding: .55rem .75rem; font-size: .9rem; color: var(--ir-ink); }
    .ir-menu .dropdown-item i { width: 1.3rem; color: var(--ir-muted); }
    .ir-menu .dropdown-item:hover { background: var(--ir-soft); }
    .ir-menu .dropdown-item.active { background: #e8f0ff; color: var(--ir-blue); }
    .ir-menu .dropdown-item.active i { color: var(--ir-blue); }
    .ir-menu .ir-logout, .ir-menu .ir-logout i { color: #be123c; }
    .ir-btn-nav {
        display: inline-flex; align-items: center; gap: .4rem; padding: .6rem 1.1rem; border-radius: 12px;
        font-weight: 600; font-size: .92rem; text-decoration: none; color: #fff;
        background: linear-gradient(135deg, var(--ir-sky), #2563eb);
        box-shadow: 0 8px 22px -6px rgba(59, 130, 246, .7);
        transition: transform .2s ease;
    }
    .ir-btn-nav:hover { color: #fff; transform: translateY(-1px); }
    .ir-btn-nav.active { box-shadow: 0 0 0 2px var(--ir-cyan), 0 8px 22px -6px rgba(59, 130, 246, .7); }
    .ir-toggler {
        border: 0; width: 42px; height: 42px; border-radius: 12px; color: #fff; font-size: 1.4rem;
        background: rgba(255, 255, 255, .08);
    }
    .ir-toggler:focus { box-shadow: 0 0 0 2px rgba(34, 211, 238, .5); }
    @media (max-width: 991.98px) {
        .ir-nav .navbar-collapse { padding: .8rem 0 .3rem; }
        .ir-links { flex-direction: column; margin-bottom: .8rem !important; }
        .ir-link.active::after { left: auto; right: 14px; bottom: 50%; transform: translateY(50%); width: 6px; height: 6px; }
        .ir-nav-right { flex-wrap: wrap; padding-top: .8rem; border-top: 1px solid rgba(255,255,255,.08); }
    }

    /* ---------- Formulaires ---------- */
    .ir-page-head { display: flex; justify-content: space-between; align-items: flex-end; gap: 1rem; flex-wrap: wrap; margin-bottom: 1.8rem; }
    .ir-page-head h1 { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 800; letter-spacing: -.02em; font-size: clamp(1.6rem, 3vw, 2.1rem); color: var(--ir-ink); margin: .35rem 0 .3rem; }
    .ir-page-head p { color: var(--ir-muted); margin: 0; }
    .ir-back { display: inline-flex; align-items: center; gap: .4rem; font-size: .88rem; font-weight: 600; color: var(--ir-muted); text-decoration: none; }
    .ir-back:hover { color: var(--ir-blue); }
    .ir-kicker { font-size: .75rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: var(--ir-sky); }

    .ir-form-card { background: #fff; border: 1px solid var(--ir-line); border-radius: 22px; box-shadow: 0 24px 50px -32px rgba(15,23,42,.35); }
    .ir-form-section { padding: 1.7rem 1.8rem; display: grid; gap: 1.2rem; }
    .ir-form-section + .ir-form-section { border-top: 1px solid var(--ir-line); }
    .ir-form-section-head { display: flex; gap: .9rem; align-items: flex-start; }
    .ir-step-badge {
        width: 34px; height: 34px; flex-shrink: 0; border-radius: 10px; display: grid; place-items: center;
        background: #e8f0ff; color: var(--ir-blue); font-weight: 800; font-size: .9rem; font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .ir-form-section-head h2 { font-size: 1.05rem; font-weight: 700; color: var(--ir-ink); margin: 0; }
    .ir-form-section-head p { font-size: .88rem; color: var(--ir-muted); margin: .1rem 0 0; }
    .ir-form-actions { padding: 1.3rem 1.8rem; border-top: 1px solid var(--ir-line); background: #fafcff; border-radius: 0 0 22px 22px; display: flex; gap: .8rem; justify-content: flex-end; flex-wrap: wrap; }

    .ir-field { display: grid; gap: .45rem; }
    .ir-field > label, .ir-label { font-weight: 600; font-size: .88rem; color: var(--ir-ink); }
    .ir-field > label small, .ir-label small { font-weight: 400; color: var(--ir-muted); }
    .ir-control { position: relative; }
    .ir-control > i { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #94a3b8; pointer-events: none; transition: color .2s ease; }
    .ir-control.is-area > i { top: 15px; transform: none; }
    .ir-control:focus-within > i { color: var(--ir-sky); }
    .ir-input {
        width: 100%; height: 50px; border: 1.5px solid var(--ir-line); border-radius: 12px;
        padding: 0 14px 0 44px; background: #fbfcff; color: var(--ir-ink); font-size: .95rem;
        transition: border-color .2s ease, box-shadow .2s ease, background .2s ease;
    }
    .ir-input.no-icon { padding-left: 14px; }
    textarea.ir-input { height: auto; min-height: 110px; padding-top: 12px; padding-bottom: 12px; line-height: 1.55; resize: vertical; }
    select.ir-input {
        appearance: none; cursor: pointer; padding-right: 42px;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 16 16'%3E%3Cpath fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' d='m3 6 5 5 5-5'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 15px center;
    }
    .ir-input::placeholder { color: #a3b0c4; }
    .ir-input:hover { border-color: #cbd5e1; }
    .ir-input:focus { outline: 0; border-color: var(--ir-sky); background: #fff; box-shadow: 0 0 0 4px rgba(59,130,246,.14); }
    .ir-input.is-invalid { border-color: #f43f5e; background: #fff8f9; }
    .ir-input.is-invalid:focus { box-shadow: 0 0 0 4px rgba(244,63,94,.14); }
    .ir-error { display: flex; gap: .35rem; align-items: center; color: #be123c; font-size: .82rem; }
    .ir-hint { font-size: .8rem; color: var(--ir-muted); display: flex; justify-content: space-between; gap: .5rem; }
    .ir-prefix { position: absolute; left: 1px; top: 1px; bottom: 1px; display: flex; align-items: center; padding: 0 .9rem; border-right: 1.5px solid var(--ir-line); border-radius: 11px 0 0 11px; background: #f1f5fb; color: var(--ir-ink); font-weight: 600; font-size: .92rem; }
    .ir-input.has-prefix { padding-left: 5.2rem; }
    .ir-eye { position: absolute; right: 7px; top: 50%; transform: translateY(-50%); width: 36px; height: 36px; border: 0; border-radius: 9px; background: transparent; color: #94a3b8; }
    .ir-eye:hover { background: #f1f5fb; color: var(--ir-ink); }
    .ir-input.has-eye { padding-right: 48px; }
    .ir-grid-2 { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 1.1rem; }
    @media (max-width: 575.98px) { .ir-grid-2 { grid-template-columns: 1fr; } .ir-form-section, .ir-form-actions { padding-inline: 1.2rem; } }

    /* Choix en pastilles (radio) */
    .ir-choices { display: flex; flex-wrap: wrap; gap: .6rem; }
    .ir-choice input { position: absolute; opacity: 0; pointer-events: none; }
    .ir-choice > span {
        display: inline-flex; align-items: center; gap: .5rem; cursor: pointer;
        padding: .65rem 1rem; border-radius: 12px; border: 1.5px solid var(--ir-line); background: #fbfcff;
        font-weight: 600; font-size: .9rem; color: #475569; transition: all .2s ease;
    }
    .ir-choice > span:hover { border-color: #cbd5e1; }
    .ir-choice input:checked + span { border-color: var(--ir-sky); background: #eef4ff; color: var(--ir-blue); box-shadow: 0 0 0 3px rgba(59,130,246,.12); }
    .ir-choice input:focus-visible + span { outline: 2px solid var(--ir-sky); outline-offset: 2px; }
    .ir-dot-status { width: 9px; height: 9px; border-radius: 50%; }

    /* Zone de dépôt de fichier */
    .ir-drop {
        position: relative; display: flex; align-items: center; gap: 1rem; padding: 1.3rem 1.2rem;
        border: 2px dashed #c7d6f5; border-radius: 16px; background: #f7faff; cursor: pointer;
        transition: border-color .2s ease, background .2s ease;
    }
    .ir-drop:hover, .ir-drop.is-drag { border-color: var(--ir-sky); background: #eef4ff; }
    .ir-drop.has-file { border-style: solid; border-color: #86efac; background: #f0fdf4; }
    .ir-drop.is-invalid { border-color: #fda4af; background: #fff8f9; }
    .ir-drop input { position: absolute; inset: 0; opacity: 0; cursor: pointer; }
    .ir-drop-icon { width: 50px; height: 50px; flex-shrink: 0; border-radius: 14px; display: grid; place-items: center; font-size: 1.4rem; background: #fff; color: var(--ir-sky); box-shadow: 0 6px 14px -8px rgba(30,58,138,.4); }
    .ir-drop.has-file .ir-drop-icon { color: #15803d; }
    .ir-drop strong { display: block; color: var(--ir-ink); font-size: .95rem; }
    .ir-drop small { color: var(--ir-muted); }

    /* Boutons */
    .ir-submit {
        display: inline-flex; align-items: center; justify-content: center; gap: .5rem;
        height: 50px; padding: 0 1.6rem; border: 0; border-radius: 12px; font-weight: 600; color: #fff; text-decoration: none;
        background: linear-gradient(135deg, var(--ir-sky), #2563eb); box-shadow: 0 10px 24px -10px rgba(37,99,235,.7);
        transition: transform .2s ease, box-shadow .2s ease;
    }
    .ir-submit:hover { transform: translateY(-1px); box-shadow: 0 14px 28px -10px rgba(37,99,235,.8); color: #fff; }
    .ir-submit.w-full { width: 100%; }
    .ir-cancel {
        display: inline-flex; align-items: center; justify-content: center; height: 50px; padding: 0 1.4rem;
        border-radius: 12px; border: 1.5px solid var(--ir-line); background: #fff; color: #475569; font-weight: 600; text-decoration: none;
    }
    .ir-cancel:hover { border-color: #cbd5e1; color: var(--ir-ink); }

    .ir-alert { display: flex; gap: .7rem; padding: .9rem 1rem; border-radius: 12px; background: #fff1f3; border: 1px solid #fecdd3; color: #9f1239; font-size: .9rem; }
    .ir-alert ul { margin: 0; padding-left: 1rem; }

    /* Page d'authentification en deux panneaux */
    .ir-auth { display: grid; grid-template-columns: 1fr 1.1fr; background: #fff; border: 1px solid var(--ir-line); border-radius: 26px; overflow: hidden; box-shadow: 0 30px 60px -36px rgba(15,23,42,.45); max-width: 1040px; margin: 1rem auto 0; }
    .ir-auth-aside {
        position: relative; overflow: hidden; color: #fff; padding: 2.6rem; display: flex; flex-direction: column; gap: 1.6rem;
        background: radial-gradient(500px 300px at 100% 0%, rgba(59,130,246,.45), transparent 60%), radial-gradient(400px 300px at 0% 100%, rgba(34,211,238,.18), transparent 60%), linear-gradient(160deg, var(--ir-navy-2), var(--ir-navy));
        --logo-ink: #fff; --logo-knock: var(--ir-navy); --logo-accent: var(--ir-cyan);
    }
    .ir-auth-aside::after { content: ''; position: absolute; inset: 0; pointer-events: none; background-image: radial-gradient(rgba(255,255,255,.08) 1px, transparent 1px); background-size: 22px 22px; mask-image: linear-gradient(200deg, #000, transparent 70%); }
    .ir-auth-aside > * { position: relative; z-index: 1; }
    .ir-auth-aside h2 { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 800; font-size: 1.85rem; line-height: 1.15; letter-spacing: -.02em; margin: 0; }
    .ir-auth-aside h2 em { font-style: normal; color: var(--ir-cyan); }
    .ir-auth-aside p { color: #b9c6e4; margin: 0; }
    .ir-auth-list { list-style: none; padding: 0; margin: 0; display: grid; gap: .9rem; }
    .ir-auth-list li { display: flex; gap: .8rem; align-items: flex-start; color: #dbe5fa; font-size: .93rem; }
    .ir-auth-list i { width: 32px; height: 32px; flex-shrink: 0; border-radius: 9px; display: grid; place-items: center; background: rgba(255,255,255,.08); color: var(--ir-cyan); }
    .ir-auth-quote { margin-top: auto; padding: 1rem 1.1rem; border-radius: 14px; background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.1); font-size: .88rem; color: #c9d5f0; }
    .ir-auth-quote strong { color: #fff; }
    .ir-auth-main { padding: 2.6rem; display: grid; gap: 1.3rem; align-content: center; }
    .ir-auth-main h1 { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 800; font-size: 1.7rem; letter-spacing: -.02em; color: var(--ir-ink); margin: 0; }
    .ir-auth-main > header p { color: var(--ir-muted); margin: .3rem 0 0; }
    .ir-auth-switch { text-align: center; color: var(--ir-muted); font-size: .92rem; margin: 0; }
    .ir-auth-switch a { font-weight: 600; text-decoration: none; }
    @media (max-width: 991.98px) { .ir-auth { grid-template-columns: 1fr; } .ir-auth-aside { padding: 2rem; } .ir-auth-aside .ir-auth-list, .ir-auth-quote { display: none; } }
    @media (max-width: 575.98px) { .ir-auth-main { padding: 1.6rem 1.3rem; } }

    /* Panneau latéral (aperçu, conseils) */
    .ir-side { position: sticky; top: calc(var(--ir-nav-h) + 8px); display: grid; gap: 1rem; }
    .ir-side-card { background: #fff; border: 1px solid var(--ir-line); border-radius: 18px; padding: 1.3rem; }
    .ir-side-card h3 { font-size: .78rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: var(--ir-muted); margin: 0 0 1rem; }
    .ir-side-dark { background: linear-gradient(160deg, var(--ir-navy-2), var(--ir-navy)); color: #c9d5f0; border: 0; }
    .ir-side-dark h3 { color: var(--ir-cyan); }
    .ir-side-dark ul { margin: 0; padding-left: 1.1rem; display: grid; gap: .5rem; font-size: .88rem; }

    /* ---------- Listes : onglets, badges de statut, écrans vides ---------- */
    .ir-tabs-bar { display: flex; gap: .4rem; flex-wrap: wrap; padding: .35rem; margin-bottom: 1.4rem; background: #fff; border: 1px solid var(--ir-line); border-radius: 14px; }
    .ir-tab { display: inline-flex; align-items: center; gap: .45rem; padding: .55rem .9rem; border-radius: 10px; color: #475569; font-weight: 600; font-size: .9rem; text-decoration: none; transition: background .2s ease, color .2s ease; }
    .ir-tab:hover { background: var(--ir-soft); color: var(--ir-ink); }
    .ir-tab.active { background: var(--ir-navy); color: #fff; }
    .ir-tab-count { min-width: 22px; height: 22px; padding: 0 6px; border-radius: 999px; display: grid; place-items: center; font-size: .74rem; background: #eef2f8; color: #475569; }
    .ir-tab.active .ir-tab-count { background: var(--ir-cyan); color: var(--ir-navy); }

    .ir-status { display: inline-flex; align-items: center; gap: .35rem; font-size: .78rem; font-weight: 600; padding: .35rem .8rem; border-radius: 999px; white-space: nowrap; }
    .ir-st-recue, .ir-st-fermee { background: #f1f5f9; color: #475569; }
    .ir-st-en_cours_examen { background: #e0f2fe; color: #0369a1; }
    .ir-st-entretien, .ir-st-expiree { background: #fff4dc; color: #b45309; }
    .ir-st-acceptee, .ir-st-ouverte { background: #e3f8ee; color: #15803d; }
    .ir-st-refusee { background: #ffe8ee; color: #be123c; }

    .ir-panel { background: #fff; border: 1px solid var(--ir-line); border-radius: 18px; }
    .ir-empty-state { padding: 3rem 1.5rem; text-align: center; display: grid; justify-items: center; gap: .6rem; }
    .ir-empty-icon { width: 64px; height: 64px; border-radius: 18px; display: grid; place-items: center; font-size: 1.6rem; background: #e8f0ff; color: var(--ir-blue); margin-bottom: .4rem; }
    .ir-empty-state h2 { font-size: 1.2rem; font-weight: 700; color: var(--ir-ink); margin: 0; }
    .ir-empty-state p { color: var(--ir-muted); margin: 0 0 .6rem; }

    /* Barre de recherche */
    .ir-search { display: flex; gap: .6rem; flex-wrap: wrap; padding: .6rem; background: #fff; border: 1px solid var(--ir-line); border-radius: 16px; box-shadow: 0 16px 36px -30px rgba(15,23,42,.4); margin-bottom: 1.2rem; }
    .ir-search .ir-control { flex: 1 1 260px; }
    .ir-search .ir-input { border-color: transparent; background: var(--ir-soft); }
    .ir-search .ir-input:focus { border-color: var(--ir-sky); background: #fff; }
    .ir-search select.ir-input { flex: 0 1 200px; width: auto; }
    .ir-search .ir-submit, .ir-search .ir-cancel { height: 50px; }

    /* ---------- Pagination ---------- */
    .pagination { gap: .35rem; flex-wrap: wrap; margin: 0; }
    .pagination .page-link {
        border: 1px solid var(--ir-line); border-radius: 10px !important; min-width: 40px; height: 40px;
        display: grid; place-items: center; padding: 0 .8rem; color: #475569; font-weight: 600; background: #fff;
    }
    .pagination .page-link:hover { border-color: #c7d6f5; color: var(--ir-blue); background: var(--ir-soft); }
    .pagination .page-item.active .page-link { background: var(--ir-navy); border-color: var(--ir-navy); color: #fff; }
    .pagination .page-item.disabled .page-link { color: #cbd5e1; background: #fff; }
    nav[aria-label] .small.text-muted { color: var(--ir-muted) !important; }

    /* ---------- Messages flash ---------- */
    .ir-toasts {
        position: fixed; z-index: 1050; right: 16px; top: calc(var(--ir-nav-h) + 4px);
        display: grid; gap: .6rem; width: min(380px, calc(100vw - 32px));
    }
    .ir-toast {
        display: flex; gap: .75rem; align-items: flex-start; padding: .9rem 1rem; border-radius: 14px;
        background: #fff; border: 1px solid var(--ir-line); box-shadow: 0 18px 40px -16px rgba(15, 23, 42, .35);
        font-size: .92rem; color: var(--ir-ink); animation: ir-toast-in .35s cubic-bezier(.2,.8,.2,1);
        transition: opacity .3s ease, transform .3s ease;
    }
    .ir-toast.is-hiding { opacity: 0; transform: translateX(20px); }
    .ir-toast > i { font-size: 1.15rem; }
    .ir-toast-success > i { color: #15803d; }
    .ir-toast-error > i { color: #be123c; }
    .ir-toast button { margin-left: auto; border: 0; background: none; color: var(--ir-muted); padding: 0 0 0 .5rem; }
    @keyframes ir-toast-in { from { opacity: 0; transform: translateY(-8px); } }

    /* ---------- Pied de page arrondi ---------- */
    .ir-foot {
        margin: 5rem 0 1.25rem; border-radius: 24px; padding: 2.6rem 2.4rem 1.4rem;
        color: #93a3c8; position: relative; overflow: hidden;
        background:
            radial-gradient(500px 220px at 95% 0%, rgba(59,130,246,.3), transparent 60%),
            linear-gradient(160deg, var(--ir-navy-2), var(--ir-navy));
        box-shadow: 0 24px 50px -28px rgba(2, 6, 23, .6);
    }
    .ir-foot p { font-size: .9rem; max-width: 22rem; }
    .ir-foot h6 { color: #fff; font-size: .8rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; margin-bottom: 1rem; }
    .ir-foot ul { list-style: none; padding: 0; margin: 0; display: grid; gap: .55rem; font-size: .92rem; }
    .ir-foot a { color: #b9c6e4; text-decoration: none; transition: color .2s ease; }
    .ir-foot a:hover { color: #fff; }
    .ir-foot a.active { color: var(--ir-cyan); }
    .ir-foot-bottom {
        margin-top: 2.2rem; padding-top: 1.2rem; border-top: 1px solid rgba(255, 255, 255, .08);
        display: flex; justify-content: space-between; flex-wrap: wrap; gap: .5rem; font-size: .84rem;
    }

    .card {
        border: 1px solid transparent;
        border-radius: 16px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.06);
        transition: transform 0.28s cubic-bezier(0.2, 0.8, 0.2, 1), box-shadow 0.28s ease, border-color 0.28s ease;
    }
    .card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 18px 32px rgba(30,58,138,0.16);
        border-color: #dbe6fb;
    }
    .btn-primary {
        background-color: #1e3a8a;
        border-color: #1e3a8a;
        transition: transform 0.15s ease, background-color 0.15s ease;
    }
    .btn-primary:hover {
        background-color: #16305f;
        border-color: #16305f;
        transform: translateY(-1px);
    }
    a { color: #3b82f6; }
    a:hover { color: #1e3a8a; }
    table thead.table-dark th { background-color: #1e3a8a; }
    .badge { font-weight: 500; padding: 0.45em 0.8em; }

    .icon-wrapper {
        width: 72px;
        height: 72px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: #fff;
        transition: transform 0.3s cubic-bezier(0.2, 0.8, 0.2, 1);
    }
    .card:hover .icon-wrapper {
        transform: scale(1.15) rotate(-6deg);
    }
    .icon-blue { background: linear-gradient(135deg, #3b82f6, #1e3a8a); }
    .icon-green { background: linear-gradient(135deg, #52b788, #2d8659); }
    .icon-orange { background: linear-gradient(135deg, #ff9f5a, #e8772e); }

    .home-card {
        padding: 2.5rem 1.75rem !important;
        min-height: 260px;
    }
    .home-card .card-title {
        font-size: 1.35rem;
    }
    .home-card .card-text {
        font-size: 1rem;
    }
    .card-arrow {
        display: inline-flex;
        align-items: center;
        font-weight: 600;
        color: #1e3a8a;
        margin-top: 1rem;
        transition: transform 0.25s ease;
    }
    .card:hover .card-arrow {
        transform: translateX(6px);
    }

    .hero-banner {
        background: linear-gradient(135deg, #1e3a8a, #3b82f6);
        border-radius: 20px;
        padding: 5rem 3rem;
        position: relative;
        overflow: hidden;
    }
    .hero-overlay {
        max-width: 600px;
        position: relative;
        z-index: 2;
    }
    .hero-shape {
        position: absolute;
        border-radius: 50%;
        background: rgba(255,255,255,0.08);
        animation: floatShape 7s ease-in-out infinite;
    }
    .hero-shape.s1 { width: 220px; height: 220px; top: -60px; right: 60px; }
    .hero-shape.s2 { width: 140px; height: 140px; bottom: -40px; right: 220px; animation-delay: 1.5s; }
    .hero-shape.s3 { width: 90px; height: 90px; top: 40px; right: 320px; animation-delay: 3s; }
    @keyframes floatShape {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-18px); }
    }

    .stats-strip { background: #f4f8ff; margin-left: -1.5rem; margin-right: -1.5rem; padding: 2.5rem 1rem; }
    .stat-number { font-size: 2.5rem; font-weight: 800; color: #1e3a8a; }
    .stat-label { color: #6c757d; font-weight: 500; }
    .step-number {
        width: 42px; height: 42px; border-radius: 50%; background: #1e3a8a; color: #fff;
        display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1.1rem;
    }
    .illustration-card { overflow: hidden; border-radius: 16px; }

    .fade-in-up {
        opacity: 0;
        transform: translateY(28px);
        transition: opacity 0.6s ease, transform 0.6s ease;
    }
    .fade-in-up.is-visible {
        opacity: 1;
        transform: translateY(0);
    }
    .section-tint {
    background: #f4f8ff;
    margin-left: -1.5rem;
    margin-right: -1.5rem;
    padding: 3rem 1.5rem;
}
.auth-card {
    border-radius: 20px;
    box-shadow: 0 12px 40px rgba(30,58,138,0.12);
}
.auth-card:hover {
    transform: none;
    box-shadow: 0 12px 40px rgba(30,58,138,0.12);
}
.form-control {
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
}
.form-control:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 4px rgba(59,130,246,0.15);
}
.btn:active {
    transform: scale(0.96);
}
</style>
    @stack('styles')
</head>
<body>
    @php
        $user = auth()->user();
        $nbNonLues = ($user && $user->isCandidat())
            ? \App\Models\Notification::where('id_candidat', $user->id_candidat)->where('lu', false)->count()
            : 0;
        $initiales = $user
            ? collect(explode(' ', $user->name))->filter()->take(2)->map(fn ($m) => mb_strtoupper(mb_substr($m, 0, 1)))->implode('')
            : '';
    @endphp

    <header class="ir-nav-wrap" id="irNavWrap">
        <div class="container">
            <nav class="ir-nav navbar navbar-expand-lg navbar-dark">
                <a class="ir-brand" href="{{ url('/') }}">
                    @include('partials.logo-mark', ['size' => 34])<span>Job<em>IT</em></span>
                </a>

                <button class="navbar-toggler ir-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#irNavMenu" aria-controls="irNavMenu" aria-expanded="false" aria-label="Ouvrir le menu">
                    <i class="bi bi-list"></i>
                </button>

                <div class="collapse navbar-collapse" id="irNavMenu">
                    <ul class="ir-links mx-lg-auto">
                        <li><a class="ir-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}"><i class="bi bi-house"></i>Accueil</a></li>
                        <li><a class="ir-link {{ request()->routeIs('offres.*') ? 'active' : '' }}" href="{{ route('offres.index') }}"><i class="bi bi-briefcase"></i>Offres d'emploi</a></li>
                        @auth
                            @if ($user->isCandidat())
                                <li><a class="ir-link {{ request()->routeIs('candidatures.mes') ? 'active' : '' }}" href="{{ route('candidatures.mes') }}"><i class="bi bi-send"></i>Mes candidatures</a></li>
                            @else
                                <li><a class="ir-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><i class="bi bi-speedometer2"></i>Tableau de bord</a></li>
                                <li><a class="ir-link {{ request()->routeIs('candidats.*') ? 'active' : '' }}" href="{{ route('candidats.index') }}"><i class="bi bi-people"></i>Candidats</a></li>
                                <li><a class="ir-link {{ request()->routeIs('candidatures.*') && !request()->routeIs('candidatures.mes') ? 'active' : '' }}" href="{{ route('candidatures.index') }}"><i class="bi bi-file-earmark-text"></i>Candidatures</a></li>
                            @endif
                        @endauth
                    </ul>

                    <div class="ir-nav-right">
                        @auth
                            @if ($user->isCandidat())
                                <a class="ir-icon-btn {{ request()->routeIs('notifications.*') ? 'active' : '' }}" href="{{ route('notifications.index') }}" title="Notifications" aria-label="Notifications">
                                    <i class="bi bi-bell"></i>
                                    @if ($nbNonLues > 0)
                                        <span class="ir-dot">{{ $nbNonLues > 9 ? '9+' : $nbNonLues }}</span>
                                    @endif
                                </a>
                            @endif

                            <div class="dropdown">
                                <button class="ir-user" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="ir-user-avatar">{{ $initiales }}</span>
                                    <span class="ir-user-meta">
                                        <strong>{{ $user->name }}</strong>
                                        <small>{{ $user->role }}</small>
                                    </span>
                                    <i class="bi bi-chevron-down small ms-1 text-white-50"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end ir-menu">
                                    @if ($user->isCandidat())
                                        <li><a class="dropdown-item {{ request()->routeIs('candidatures.mes') ? 'active' : '' }}" href="{{ route('candidatures.mes') }}"><i class="bi bi-send"></i>Mes candidatures</a></li>
                                        <li><a class="dropdown-item {{ request()->routeIs('notifications.*') ? 'active' : '' }}" href="{{ route('notifications.index') }}"><i class="bi bi-bell"></i>Notifications</a></li>
                                    @else
                                        <li><a class="dropdown-item {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><i class="bi bi-speedometer2"></i>Tableau de bord</a></li>
                                        <li><a class="dropdown-item {{ request()->routeIs('offres.create') ? 'active' : '' }}" href="{{ route('offres.create') }}"><i class="bi bi-plus-lg"></i>Publier une offre</a></li>
                                    @endif
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item ir-logout"><i class="bi bi-box-arrow-right"></i>Déconnexion</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <a class="ir-link {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right"></i>Connexion</a>
                            <a class="ir-btn-nav {{ request()->routeIs('register') ? 'active' : '' }}" href="{{ route('register') }}">Inscription <i class="bi bi-arrow-right"></i></a>
                        @endauth
                    </div>
                </div>
            </nav>
        </div>
    </header>

    @if (session('success') || session('error'))
        <div class="ir-toasts">
            @if (session('success'))
                <div class="ir-toast ir-toast-success" role="status">
                    <i class="bi bi-check-circle-fill"></i><span>{{ session('success') }}</span>
                    <button type="button" aria-label="Fermer"><i class="bi bi-x-lg"></i></button>
                </div>
            @endif
            @if (session('error'))
                <div class="ir-toast ir-toast-error" role="alert">
                    <i class="bi bi-exclamation-circle-fill"></i><span>{{ session('error') }}</span>
                    <button type="button" aria-label="Fermer"><i class="bi bi-x-lg"></i></button>
                </div>
            @endif
        </div>
    @endif

    <main class="ir-main">
        <div class="container mt-4">
            @yield('content')
        </div>
    </main>

    <div class="container">
        <footer class="ir-foot">
            <div class="row g-4">
                <div class="col-lg-5">
                    <a class="ir-brand" href="{{ url('/') }}">
                        @include('partials.logo-mark', ['size' => 34])<span>Job<em>IT</em></span>
                    </a>
                    <p class="mt-3 mb-0">La plateforme de recrutement dédiée aux métiers de l'informatique au Mali. Candidats et recruteurs, au même endroit.</p>
                </div>
                <div class="col-6 col-lg-3">
                    <h6>Plateforme</h6>
                    <ul>
                        <li><a class="{{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Accueil</a></li>
                        <li><a class="{{ request()->routeIs('offres.*') ? 'active' : '' }}" href="{{ route('offres.index') }}">Offres d'emploi</a></li>
                        @auth
                            @if ($user->isCandidat())
                                <li><a class="{{ request()->routeIs('candidatures.mes') ? 'active' : '' }}" href="{{ route('candidatures.mes') }}">Mes candidatures</a></li>
                            @else
                                <li><a class="{{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Tableau de bord</a></li>
                            @endif
                        @endauth
                    </ul>
                </div>
                <div class="col-6 col-lg-4">
                    <h6>Compte</h6>
                    <ul>
                        @auth
                            @if ($user->isCandidat())
                                <li><a class="{{ request()->routeIs('notifications.*') ? 'active' : '' }}" href="{{ route('notifications.index') }}">Notifications</a></li>
                            @else
                                <li><a class="{{ request()->routeIs('candidatures.*') ? 'active' : '' }}" href="{{ route('candidatures.index') }}">Candidatures reçues</a></li>
                            @endif
                        @else
                            <li><a class="{{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">Connexion</a></li>
                            <li><a class="{{ request()->routeIs('register') ? 'active' : '' }}" href="{{ route('register') }}">Créer un compte</a></li>
                        @endauth
                        <li><span><i class="bi bi-geo-alt me-1"></i>Bamako, Mali</span></li>
                    </ul>
                </div>
            </div>
            <div class="ir-foot-bottom">
                <span>© {{ date('Y') }} JobIT. Tous droits réservés.</span>
                <span>Fait avec <i class="bi bi-heart-fill text-danger"></i> au Mali</span>
            </div>
        </footer>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const items = document.querySelectorAll('.fade-in-up');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.15 });
            items.forEach(item => observer.observe(item));

            // Navbar plus opaque au défilement
            const navWrap = document.getElementById('irNavWrap');
            const onScroll = () => navWrap.classList.toggle('is-scrolled', window.scrollY > 10);
            onScroll();
            window.addEventListener('scroll', onScroll, { passive: true });

            // Formulaires : afficher / masquer un mot de passe
            document.querySelectorAll('[data-eye]').forEach(btn => {
                btn.addEventListener('click', () => {
                    const input = document.getElementById(btn.dataset.eye);
                    const visible = input.type === 'text';
                    input.type = visible ? 'password' : 'text';
                    btn.innerHTML = visible ? '<i class="bi bi-eye"></i>' : '<i class="bi bi-eye-slash"></i>';
                    btn.setAttribute('aria-label', visible ? 'Afficher le mot de passe' : 'Masquer le mot de passe');
                });
            });

            // Formulaires : zone de dépôt de fichier (nom et taille du fichier choisi)
            document.querySelectorAll('[data-drop]').forEach(zone => {
                const input = zone.querySelector('input[type="file"]');
                const title = zone.querySelector('[data-drop-title]');
                const sub = zone.querySelector('[data-drop-sub]');
                const initial = [title.textContent, sub.textContent];
                ['dragenter', 'dragover'].forEach(ev => zone.addEventListener(ev, () => zone.classList.add('is-drag')));
                ['dragleave', 'drop'].forEach(ev => zone.addEventListener(ev, () => zone.classList.remove('is-drag')));
                input.addEventListener('change', () => {
                    const file = input.files[0];
                    zone.classList.toggle('has-file', !!file);
                    zone.classList.remove('is-invalid');
                    if (!file) { [title.textContent, sub.textContent] = initial; return; }
                    const mo = file.size / 1024 / 1024;
                    title.textContent = file.name;
                    sub.textContent = mo > 5
                        ? `${mo.toFixed(1)} Mo : trop lourd, 5 Mo maximum`
                        : `${mo < 1 ? Math.max(1, Math.round(file.size / 1024)) + ' Ko' : mo.toFixed(1) + ' Mo'} · cliquez pour changer de fichier`;
                    if (mo > 5) { zone.classList.remove('has-file'); zone.classList.add('is-invalid'); }
                });
            });

            // Formulaires : compteur de caractères
            document.querySelectorAll('[data-count]').forEach(area => {
                const counter = document.querySelector(`[data-counter="${area.id}"]`);
                if (!counter) return;
                const update = () => counter.textContent = `${area.value.length} caractères`;
                area.addEventListener('input', update);
                update();
            });

            // Messages flash : fermeture manuelle et automatique
            document.querySelectorAll('.ir-toast').forEach(toast => {
                const hide = () => { toast.classList.add('is-hiding'); setTimeout(() => toast.remove(), 300); };
                toast.querySelector('button').addEventListener('click', hide);
                setTimeout(hide, 6000);
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
