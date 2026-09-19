@extends('layouts.app')

@section('title', 'Détail de l\'offre')

@section('content')
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">{{ $offre->titre }}</h1>
            <p class="text-muted mb-0"><i class="bi bi-geo-alt me-1"></i>{{ $offre->lieu }}</p>
        </div>
        <span class="badge {{ $offre->statut == 'ouverte' ? 'bg-success' : 'bg-secondary' }} fs-6">
            {{ $offre->statut == 'ouverte' ? 'Ouverte' : 'Fermée' }}
        </span>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-4">
                    <small class="text-muted d-block">Type de contrat</small>
                    <span class="fw-semibold">{{ $offre->type_contrat }}</span>
                </div>
                <div class="col-md-4">
                    <small class="text-muted d-block">Date de publication</small>
                    <span class="fw-semibold">{{ \Carbon\Carbon::parse($offre->date_publication)->format('d/m/Y') }}</span>
                </div>
                <div class="col-md-4">
                    <small class="text-muted d-block">Date limite</small>
                    <span class="fw-semibold">{{ \Carbon\Carbon::parse($offre->date_limite)->format('d/m/Y') }}</span>
                </div>
            </div>
            <hr>
            <small class="text-muted d-block mb-1">Description</small>
            <p class="mb-0">{{ $offre->description }}</p>
        </div>
    </div>

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

    @if (auth()->user()->isCandidat() && $offre->statut === 'ouverte')
        <a href="{{ route('offres.postuler.form', $offre) }}" class="btn btn-success">
            <i class="bi bi-send me-1"></i>Postuler
        </a>
    @endif
    <a href="{{ route('offres.edit', $offre) }}" class="btn btn-primary">
        <i class="bi bi-pencil me-1"></i>Modifier
    </a>
    <a href="{{ route('offres.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Retour à la liste
    </a>
@endsection