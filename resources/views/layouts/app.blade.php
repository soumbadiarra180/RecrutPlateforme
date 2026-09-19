<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'RecrutPlateforme')</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
    body {
        font-family: 'Inter', sans-serif;
        background-color: #ffffff;
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
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.06);
        transition: transform 0.15s ease, box-shadow 0.15s ease;
    }
    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(0,0,0,0.1);
    }
    .btn-primary {
        background-color: #1e3a8a;
        border-color: #1e3a8a;
    }
    .btn-primary:hover {
        background-color: #16305f;
        border-color: #16305f;
    }
    a {
        color: #3b82f6;
    }
    a:hover {
        color: #1e3a8a;
    }
    table thead.table-dark th {
        background-color: #1e3a8a;
    }
    .badge {
        font-weight: 500;
        padding: 0.45em 0.8em;
    }
    .hero-section {
        padding: 2.5rem 1rem;
    }
    .icon-wrapper {
        width: 64px;
        height: 64px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        color: #fff;
    }
    .icon-blue { background: linear-gradient(135deg, #3b82f6, #1e3a8a); }
    .icon-green { background: linear-gradient(135deg, #52b788, #2d8659); }
    .icon-orange { background: linear-gradient(135deg, #ff9f5a, #e8772e); }
    .hero-banner {
        background: linear-gradient(135deg, #1e3a8a, #3b82f6);
        border-radius: 16px;
        padding: 4rem 3rem;
        position: relative;
        overflow: hidden;
    }
    .hero-overlay {
        max-width: 600px;
        position: relative;
        z-index: 2;
    }
    .step-number {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: #1e3a8a;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.1rem;
    }
    .illustration-card {
        overflow: hidden;
        border-radius: 16px;
    }
</style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="bi bi-briefcase-fill me-2"></i>RecrutPlateforme
            </a>

            <div class="navbar-nav">
                <a class="nav-link" href="{{ url('/') }}"><i class="bi bi-house-fill me-1"></i>Accueil</a>
                <a class="nav-link" href="{{ route('offres.index') }}">Offres d'emploi</a>
                @auth
                    @if (auth()->user()->isCandidat())
                        <a class="nav-link" href="{{ route('candidatures.mes') }}">Mes candidatures</a>
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
</body>
</html>