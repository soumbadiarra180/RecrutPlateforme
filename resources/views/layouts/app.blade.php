<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ITRecrute')</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
    body {
    font-family: 'Inter', sans-serif;
    background: linear-gradient(180deg, #eef3fc 0%, #f6f9fd 400px, #f6f9fd 100%);
    color: #2d2f36;
    min-height: 100vh;
}
    .navbar {
        background-color: #1e3a8a !important;
        box-shadow: 0 2px 6px rgba(0,0,0,0.15);
    }
    .navbar-brand {
        font-weight: 700;
        letter-spacing: 0.3px;
    }
    .nav-link {
        font-weight: 500;
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
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="bi bi-briefcase-fill me-2"></i>ITRecrute
            </a>

            <div class="navbar-nav">
                <a class="nav-link" href="{{ url('/') }}"><i class="bi bi-house-fill me-1"></i>Accueil</a>
                <a class="nav-link" href="{{ route('offres.index') }}">Offres d'emploi</a>
                @auth
                    @if (auth()->user()->isCandidat())
                        <a class="nav-link" href="{{ route('candidatures.mes') }}">Mes candidatures</a>
                        <a class="nav-link position-relative" href="{{ route('notifications.index') }}">
                            <i class="bi bi-bell-fill"></i>
                            @php
                                $nbNonLues = \App\Models\Notification::where('id_candidat', auth()->user()->id_candidat)->where('lu', false)->count();
                            @endphp
                            @if ($nbNonLues > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size:0.6rem;">
                                    {{ $nbNonLues }}
                                </span>
                            @endif
                        </a>
                    @else
                        <a class="nav-link" href="{{ route('dashboard') }}"><i class="bi bi-speedometer2 me-1"></i>Tableau de bord</a>
                        <a class="nav-link" href="{{ route('candidats.index') }}">Candidats</a>
                        <a class="nav-link" href="{{ route('candidatures.index') }}">Candidatures</a>
                    @endif
                @endauth
            </div>

            <div class="navbar-nav ms-auto">
                @auth
                    <span class="nav-link text-white-50">
                        <i class="bi bi-person-circle me-1"></i>{{ auth()->user()->name }}
                        <span class="badge bg-secondary ms-1">{{ auth()->user()->role }}</span>
                    </span>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link text-decoration-none">
                            <i class="bi bi-box-arrow-right me-1"></i>Déconnexion
                        </button>
                    </form>
                @else
                    <a class="nav-link" href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right me-1"></i>Connexion</a>
                    <a class="nav-link" href="{{ route('register') }}"><i class="bi bi-person-plus me-1"></i>Inscription</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @yield('content')
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
        });
    </script>
</body>
</html>