@extends('layouts.app')

@section('title', 'Accueil - ITRecrute')

@section('content')
@guest
    <div class="hero-banner mb-5">
        <div class="hero-shape s1"></div>
        <div class="hero-shape s2"></div>
        <div class="hero-shape s3"></div>
        <div class="hero-overlay text-center mx-auto">
            <span class="badge bg-white text-primary fw-semibold mb-3 px-3 py-2">🇲🇱 La plateforme IT au Mali</span>
            <h1 class="display-5 fw-bold text-white mb-3">Trouvez l'emploi de vos rêves en informatique</h1>
            <p class="text-white-50 fs-5 mb-4">Développeurs, programmeurs, administrateurs systèmes... publiez ou trouvez l'offre qu'il vous faut.</p>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <a href="{{ route('register') }}" class="btn btn-light btn-lg fw-bold px-5 py-3">
                    Inscription gratuite
                </a>
                <a href="{{ route('offres.index') }}" class="btn btn-outline-light btn-lg fw-bold px-5 py-3">
                    Voir les offres
                </a>
            </div>
        </div>
    </div>

    <div class="section-tint mb-5">
        <div class="row text-center g-4 mb-5">
            <div class="col-md-4">
                <div class="stat-number">{{ $stats['offres'] }}+</div>
                <div class="stat-label">Offres ouvertes</div>
            </div>
            <div class="col-md-4">
                <div class="stat-number">{{ $stats['candidats'] }}+</div>
                <div class="stat-label">Candidats inscrits</div>
            </div>
            <div class="col-md-4">
                <div class="stat-number">100%</div>
                <div class="stat-label">Dédié à l'informatique</div>
            </div>
        </div>

        @if ($offresAlaUne->count() > 0)
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="h4 fw-bold mb-0">Offres à la une</h2>
                <a href="{{ route('offres.index') }}" class="fw-semibold">Voir tout <i class="bi bi-arrow-right"></i></a>
            </div>
            <div class="row g-4">
                @foreach ($offresAlaUne as $offre)
                    <div class="col-md-4">
                        <a href="{{ route('login') }}" class="text-decoration-none">
                            <div class="card home-card h-100 fade-in-up" style="transition-delay: {{ $loop->index * 0.1 }}s;">
                                <span class="badge bg-success-subtle text-success mb-2 align-self-start">{{ $offre->type_contrat }}</span>
                                <h5 class="fw-bold text-dark mb-1">{{ $offre->titre }}</h5>
                                <p class="text-muted small mb-2"><i class="bi bi-geo-alt me-1"></i>{{ $offre->lieu }}</p>
                                <p class="text-muted small flex-grow-1">{{ Str::limit($offre->description, 80) }}</p>
                                <span class="card-arrow">Postuler <i class="bi bi-arrow-right ms-1"></i></span>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="mb-4 text-center">
        <h2 class="h4 fw-bold mb-1">Comment ça marche ?</h2>
        <p class="text-muted mb-0">Trois étapes simples pour décrocher votre prochain poste en informatique.</p>
    </div>
    <div class="row g-4 mb-5 pb-3">
        <div class="col-md-4">
            <a href="{{ route('register') }}" class="text-decoration-none">
                <div class="card home-card h-100 text-center d-flex flex-column fade-in-up">
                    <div class="step-number mx-auto mb-3">1</div>
                    <h5 class="card-title fw-bold mb-2 text-dark">Créez votre profil</h5>
                    <p class="card-text text-muted flex-grow-1">Inscrivez-vous en quelques minutes et rejoignez la communauté des candidats IT.</p>
                    <span class="card-arrow">S'inscrire <i class="bi bi-arrow-right ms-1"></i></span>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('offres.index') }}" class="text-decoration-none">
                <div class="card home-card h-100 text-center d-flex flex-column fade-in-up" style="transition-delay: 0.1s;">
                    <div class="step-number mx-auto mb-3">2</div>
                    <h5 class="card-title fw-bold mb-2 text-dark">Postulez aux offres</h5>
                    <p class="card-text text-muted flex-grow-1">Parcourez les offres informatiques disponibles et postulez en un clic avec votre CV.</p>
                    <span class="card-arrow">Voir les offres <i class="bi bi-arrow-right ms-1"></i></span>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('login') }}" class="text-decoration-none">
                <div class="card home-card h-100 text-center d-flex flex-column fade-in-up" style="transition-delay: 0.2s;">
                    <div class="step-number mx-auto mb-3">3</div>
                    <h5 class="card-title fw-bold mb-2 text-dark">Suivez votre candidature</h5>
                    <p class="card-text text-muted flex-grow-1">Recevez une notification à chaque étape, jusqu'à la décision finale.</p>
                    <span class="card-arrow">Se connecter <i class="bi bi-arrow-right ms-1"></i></span>
                </div>
            </a>
        </div>
    </div>

@elseif (auth()->user()->isRecruteur())
    <div class="mb-4">
        <h1 class="h4 fw-bold mb-1">Bonjour, {{ auth()->user()->name }} 👋</h1>
        <p class="text-muted mb-0">Voici un accès rapide à vos outils de recrutement.</p>
    </div>

    <div class="row g-4">
        <div class="col-md-3 col-6">
            <a href="{{ route('dashboard') }}" class="text-decoration-none">
                <div class="card home-card h-100 text-center fade-in-up" style="min-height:200px;">
                    <div class="icon-wrapper icon-blue mx-auto mb-2" style="width:56px;height:56px;font-size:1.5rem;">
                        <i class="bi bi-speedometer2"></i>
                    </div>
                    <h6 class="fw-bold mb-0 text-dark">Tableau de bord</h6>
                    <small class="text-muted">Vue d'ensemble</small>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-6">
            <a href="{{ route('offres.index') }}" class="text-decoration-none">
                <div class="card home-card h-100 text-center fade-in-up" style="min-height:200px; transition-delay: 0.05s;">
                    <div class="icon-wrapper icon-orange mx-auto mb-2" style="width:56px;height:56px;font-size:1.5rem;">
                        <i class="bi bi-briefcase-fill"></i>
                    </div>
                    <h3 class="fw-bold mb-0" style="color:#e8772e;">{{ $stats['offres'] }}</h3>
                    <h6 class="fw-bold mb-0 text-dark">Offres ouvertes</h6>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-6">
            <a href="{{ route('candidats.index') }}" class="text-decoration-none">
                <div class="card home-card h-100 text-center fade-in-up" style="min-height:200px; transition-delay: 0.1s;">
                    <div class="icon-wrapper icon-green mx-auto mb-2" style="width:56px;height:56px;font-size:1.5rem;">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <h3 class="fw-bold mb-0" style="color:#2d8659;">{{ $stats['candidats'] }}</h3>
                    <h6 class="fw-bold mb-0 text-dark">Candidats inscrits</h6>
                </div>
            </a>
        </div>
        <div class="col-md-3 col-6">
            <a href="{{ route('candidatures.index') }}" class="text-decoration-none">
                <div class="card home-card h-100 text-center fade-in-up" style="min-height:200px; transition-delay: 0.15s;">
                    <div class="icon-wrapper icon-blue mx-auto mb-2" style="width:56px;height:56px;font-size:1.5rem;">
                        <i class="bi bi-file-earmark-text-fill"></i>
                    </div>
                    <h3 class="fw-bold mb-0" style="color:#1e3a8a;">{{ $stats['candidatures'] }}</h3>
                    <h6 class="fw-bold mb-0 text-dark">Candidatures reçues</h6>
                </div>
            </a>
        </div>
    </div>

    <div class="d-flex gap-3 mt-4 mb-5 flex-wrap">
        <a href="{{ route('offres.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Publier une nouvelle offre
        </a>
        <a href="{{ route('candidatures.index') }}" class="btn btn-outline-primary">
            Voir toutes les candidatures <i class="bi bi-arrow-right ms-1"></i>
        </a>
    </div>

    @if ($dernieresCandidatures->count() > 0)
        <h2 class="h5 fw-bold mb-3">Dernières candidatures reçues</h2>
        <div class="card fade-in-up">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Candidat</th>
                            <th>Offre</th>
                            <th>Statut</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dernieresCandidatures as $c)
                            @php
                                $badgeClass = match($c->statut) {
                                    'recue' => 'bg-secondary',
                                    'en_cours_examen' => 'bg-info text-dark',
                                    'entretien' => 'bg-warning text-dark',
                                    'acceptee' => 'bg-success',
                                    'refusee' => 'bg-danger',
                                    default => 'bg-secondary',
                                };
                                $statutLabel = match($c->statut) {
                                    'recue' => 'Reçue',
                                    'en_cours_examen' => 'En cours d\'examen',
                                    'entretien' => 'Entretien',
                                    'acceptee' => 'Acceptée',
                                    'refusee' => 'Refusée',
                                    default => $c->statut,
                                };
                            @endphp
                            <tr>
                                <td class="fw-semibold">{{ $c->candidat->nom }} {{ $c->candidat->prenom }}</td>
                                <td>{{ $c->offre->titre }}</td>
                                <td><span class="badge {{ $badgeClass }}">{{ $statutLabel }}</span></td>
                                <td class="text-end">
                                    <a href="{{ route('candidatures.edit', $c) }}" class="btn btn-sm btn-outline-primary">Traiter</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

@else
    <div class="mb-4">
        <h1 class="h4 fw-bold mb-1">Bonjour, {{ auth()->user()->name }} 👋</h1>
        <p class="text-muted mb-0">Trouvez votre prochaine opportunité et suivez vos candidatures.</p>
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <a href="{{ route('offres.index') }}" class="text-decoration-none">
                <div class="card home-card h-100 text-center fade-in-up">
                    <div class="icon-wrapper icon-blue mx-auto mb-2">
                        <i class="bi bi-briefcase-fill"></i>
                    </div>
                    <h5 class="fw-bold mb-1 text-dark">Voir les offres d'emploi</h5>
                    <p class="text-muted small mb-0">Parcourez les offres ouvertes et postulez en quelques clics.</p>
                    <span class="card-arrow">Explorer <i class="bi bi-arrow-right ms-1"></i></span>
                </div>
            </a>
        </div>
        <div class="col-md-6">
            <a href="{{ route('candidatures.mes') }}" class="text-decoration-none">
                <div class="card home-card h-100 text-center fade-in-up" style="transition-delay: 0.1s;">
                    <div class="icon-wrapper icon-orange mx-auto mb-2">
                        <i class="bi bi-file-earmark-text-fill"></i>
                    </div>
                    <h5 class="fw-bold mb-1 text-dark">Mes candidatures</h5>
                    <p class="text-muted small mb-0">Suivez le statut de toutes vos candidatures soumises.</p>
                    <span class="card-arrow">Consulter <i class="bi bi-arrow-right ms-1"></i></span>
                </div>
            </a>
        </div>
    </div>
@endguest
@endsection