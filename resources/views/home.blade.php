@extends('layouts.app')

@section('title', 'Accueil - RecrutPlateforme')

@section('content')
@guest
    <div class="hero-banner mb-5">
        <div class="hero-overlay text-center mx-auto">
            <h1 class="display-5 fw-bold text-white mb-4">Trouvez l'emploi de vos rêves en informatique</h1>
            <a href="{{ route('register') }}" class="btn btn-light btn-lg fw-bold px-5 py-3">
                Inscription gratuite
            </a>
        </div>
    </div>

    <div class="row g-4 mb-5 pb-3">
        <div class="col-md-4">
            <div class="card h-100 text-center p-4 d-flex flex-column">
                <div class="icon-wrapper icon-blue mx-auto mb-3">
                    <i class="bi bi-briefcase-fill"></i>
                </div>
                <h5 class="card-title fw-bold mb-2">Offres d'emploi</h5>
                <p class="card-text text-muted flex-grow-1">Publiez et gérez facilement toutes les offres d'emploi.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 text-center p-4 d-flex flex-column">
                <div class="icon-wrapper icon-green mx-auto mb-3">
                    <i class="bi bi-people-fill"></i>
                </div>
                <h5 class="card-title fw-bold mb-2">Candidats</h5>
                <p class="card-text text-muted flex-grow-1">Centralisez les profils de tous les candidats.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 text-center p-4 d-flex flex-column">
                <div class="icon-wrapper icon-orange mx-auto mb-3">
                    <i class="bi bi-file-earmark-text-fill"></i>
                </div>
                <h5 class="card-title fw-bold mb-2">Candidatures</h5>
                <p class="card-text text-muted flex-grow-1">Suivez chaque candidature, du dépôt à la décision finale.</p>
            </div>
        </div>
    </div>

@elseif (auth()->user()->isRecruteur())
    <div class="mb-4">
        <h1 class="h4 fw-bold mb-1">Bonjour, {{ auth()->user()->name }} 👋</h1>
        <p class="text-muted mb-0">Voici un accès rapide à vos outils de recrutement.</p>
    </div>

    <div class="row g-3">
        <div class="col-md-3 col-6">
            <a href="{{ route('dashboard') }}" class="text-decoration-none">
                <div class="card h-100 text-center p-3">
                    <div class="icon-wrapper icon-blue mx-auto mb-2" style="width:48px;height:48px;font-size:1.3rem;">
                        <i class="bi bi-speedometer2"></i>
                    </div>
                    <h6 class="fw-bold mb-0 text-dark">Tableau de bord</h6>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-6">
            <a href="{{ route('offres.index') }}" class="text-decoration-none">
                <div class="card h-100 text-center p-3">
                    <div class="icon-wrapper icon-orange mx-auto mb-2" style="width:48px;height:48px;font-size:1.3rem;">
                        <i class="bi bi-briefcase-fill"></i>
                    </div>
                    <h6 class="fw-bold mb-0 text-dark">Offres d'emploi</h6>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-6">
            <a href="{{ route('candidats.index') }}" class="text-decoration-none">
                <div class="card h-100 text-center p-3">
                    <div class="icon-wrapper icon-green mx-auto mb-2" style="width:48px;height:48px;font-size:1.3rem;">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <h6 class="fw-bold mb-0 text-dark">Candidats</h6>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-6">
            <a href="{{ route('candidatures.index') }}" class="text-decoration-none">
                <div class="card h-100 text-center p-3">
                    <div class="icon-wrapper icon-blue mx-auto mb-2" style="width:48px;height:48px;font-size:1.3rem;">
                        <i class="bi bi-file-earmark-text-fill"></i>
                    </div>
                    <h6 class="fw-bold mb-0 text-dark">Candidatures</h6>
                </div>
            </a>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('offres.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Publier une nouvelle offre
        </a>
    </div>

@else
    <div class="mb-4">
        <h1 class="h4 fw-bold mb-1">Bonjour, {{ auth()->user()->name }} 👋</h1>
        <p class="text-muted mb-0">Trouvez votre prochaine opportunité et suivez vos candidatures.</p>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <a href="{{ route('offres.index') }}" class="text-decoration-none">
                <div class="card h-100 text-center p-4">
                    <div class="icon-wrapper icon-blue mx-auto mb-2">
                        <i class="bi bi-briefcase-fill"></i>
                    </div>
                    <h5 class="fw-bold mb-1 text-dark">Voir les offres d'emploi</h5>
                    <p class="text-muted small mb-0">Parcourez les offres ouvertes et postulez en quelques clics.</p>
                </div>
            </a>
        </div>
        <div class="col-md-6">
            <a href="{{ route('candidatures.mes') }}" class="text-decoration-none">
                <div class="card h-100 text-center p-4">
                    <div class="icon-wrapper icon-orange mx-auto mb-2">
                        <i class="bi bi-file-earmark-text-fill"></i>
                    </div>
                    <h5 class="fw-bold mb-1 text-dark">Mes candidatures</h5>
                    <p class="text-muted small mb-0">Suivez le statut de toutes vos candidatures soumises.</p>
                </div>
            </a>
        </div>
    </div>
@endguest
@endsection