@extends('layouts.app')

@section('title', 'Détail de la candidature')

@section('content')
    <h1 class="h3 fw-bold mb-4">Candidature #{{ $candidature->id_candidature }}</h1>

    <div class="card mb-4">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <small class="text-muted d-block">Candidat</small>
                    <a href="{{ route('candidats.show', $candidature->candidat) }}" class="fw-semibold text-decoration-none">
                        {{ $candidature->candidat->nom }} {{ $candidature->candidat->prenom }}
                    </a>
                </div>
                <div class="col-md-6">
                    <small class="text-muted d-block">Offre concernée</small>
                    <a href="{{ route('offres.show', $candidature->offre) }}" class="fw-semibold text-decoration-none">
                        {{ $candidature->offre->titre }}
                    </a>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <small class="text-muted d-block">Statut</small>
                    @php
                        $badgeClass = match($candidature->statut) {
                            'recue' => 'bg-secondary',
                            'en_cours_examen' => 'bg-info text-dark',
                            'entretien' => 'bg-warning text-dark',
                            'acceptee' => 'bg-success',
                            'refusee' => 'bg-danger',
                            default => 'bg-secondary',
                        };
                        $statutLabel = match($candidature->statut) {
                            'recue' => 'Reçue',
                            'en_cours_examen' => 'En cours d\'examen',
                            'entretien' => 'Entretien',
                            'acceptee' => 'Acceptée',
                            'refusee' => 'Refusée',
                            default => $candidature->statut,
                        };
                    @endphp
                    <span class="badge {{ $badgeClass }}">{{ $statutLabel }}</span>
                </div>
                <div class="col-md-6">
                    <small class="text-muted d-block">Date de candidature</small>
                    <span class="fw-semibold">{{ \Carbon\Carbon::parse($candidature->date_candidature)->format('d/m/Y') }}</span>
                </div>
            </div>

            <hr>
            <small class="text-muted d-block mb-1">Lettre de motivation</small>
            <p class="mb-3">{{ $candidature->lettre_motivation ?? '—' }}</p>

            <small class="text-muted d-block mb-1">Motif / commentaire</small>
            <p class="mb-0">{{ $candidature->motif_decision ?? '—' }}</p>
        </div>
    </div>

    <a href="{{ route('candidatures.edit', $candidature) }}" class="btn btn-primary">
        <i class="bi bi-arrow-repeat me-1"></i>Traiter cette candidature
    </a>
    <a href="{{ route('candidatures.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Retour à la liste
    </a>
@endsection