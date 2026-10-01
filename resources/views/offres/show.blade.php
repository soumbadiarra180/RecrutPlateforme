@extends('layouts.app')

@section('title', 'Détail de l\'offre')

@section('content')
    @php
        $estExpiree = \Carbon\Carbon::parse($offre->date_limite)->isPast();
        $estOuverte = $offre->statut === 'ouverte' && !$estExpiree;

        $formaterEnListe = function ($texte) {
            $lignes = preg_split('/\r\n|\r|\n/', trim($texte));
            return array_values(array_filter(array_map(function ($ligne) {
                return trim($ligne, "*-• \t");
            }, $lignes), fn($l) => $l !== ''));
        };
    @endphp

    <div class="mb-4">
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
            <div>
                <h1 class="h3 fw-bold mb-1">{{ $offre->titre }}</h1>
                <div class="d-flex align-items-center gap-3 text-muted">
                    <span><i class="bi bi-geo-alt me-1"></i>{{ $offre->lieu }}</span>
                    <span><i class="bi bi-briefcase me-1"></i>{{ $offre->type_contrat }}</span>
                    <span class="{{ $estExpiree ? 'text-danger fw-semibold' : '' }}">
                        <i class="bi bi-calendar-event me-1"></i>Candidatures jusqu'au {{ \Carbon\Carbon::parse($offre->date_limite)->format('d/m/Y') }}
                    </span>
                </div>
            </div>
            <span class="badge {{ $estOuverte ? 'bg-success' : 'bg-secondary' }} fs-6">
                {{ $estOuverte ? 'Ouverte' : ($estExpiree ? 'Expirée' : 'Fermée') }}
            </span>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body p-4">
            <p class="mb-4">{{ $offre->description }}</p>

            @if ($offre->missions)
                <h6 class="fw-bold text-dark mb-2">Missions principales</h6>
                <ul class="mb-4 ps-3">
                    @foreach ($formaterEnListe($offre->missions) as $ligne)
                        <li class="mb-1">{{ $ligne }}</li>
                    @endforeach
                </ul>
            @endif

            @if ($offre->competences)
                <h6 class="fw-bold text-dark mb-2">Compétences recherchées</h6>
                <div class="mb-4">
                    @foreach ($formaterEnListe($offre->competences) as $ligne)
                        <span class="badge bg-light text-dark border me-1 mb-1">{{ $ligne }}</span>
                    @endforeach
                </div>
            @endif

            @if ($offre->profil_recherche)
                <h6 class="fw-bold text-dark mb-2">Profil recherché</h6>
                <ul class="mb-0 ps-3">
                    @foreach ($formaterEnListe($offre->profil_recherche) as $ligne)
                        <li class="mb-1">{{ $ligne }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    @if (auth()->user()->isRecruteur())
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h5 fw-bold mb-0">Candidatures reçues</h2>
            <span class="badge rounded-pill bg-primary-subtle text-primary-emphasis">{{ $offre->candidatures->count() }}</span>
        </div>

        <div class="card mb-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Candidat</th>
                            <th>Email</th>
                            <th>Statut</th>
                            <th>Date de candidature</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($offre->candidatures as $candidature)
                            <tr>
                                <td class="fw-semibold">{{ $candidature->candidat->nom }} {{ $candidature->candidat->prenom }}</td>
                                <td>{{ $candidature->candidat->email }}</td>
                                <td>
                                    @php
                                        $statutLabel = match($candidature->statut) {
                                            'recue' => 'Reçue',
                                            'en_cours_examen' => 'En cours d\'examen',
                                            'entretien' => 'Entretien',
                                            'acceptee' => 'Acceptée',
                                            'refusee' => 'Refusée',
                                            default => $candidature->statut,
                                        };
                                    @endphp
                                    {{ $statutLabel }}
                                </td>
                                <td>{{ \Carbon\Carbon::parse($candidature->date_candidature)->format('d/m/Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">Aucune candidature reçue pour cette offre.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    @if (auth()->user()->isCandidat())
        @if ($estOuverte)
            <a href="{{ route('offres.postuler.form', $offre) }}" class="btn btn-success">
                <i class="bi bi-send me-1"></i>Postuler
            </a>
        @else
            <button class="btn btn-secondary" disabled>
                <i class="bi bi-lock me-1"></i>Candidatures closes
            </button>
        @endif
    @endif
    @if (auth()->user()->isRecruteur())
        <a href="{{ route('offres.edit', $offre) }}" class="btn btn-primary">
            <i class="bi bi-pencil me-1"></i>Modifier
        </a>
    @endif
    <a href="{{ route('offres.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Retour à la liste
    </a>
@endsection