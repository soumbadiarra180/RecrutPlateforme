@extends('layouts.app')

@section('title', 'Détail du candidat')

@section('content')
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">{{ $candidat->nom }} {{ $candidat->prenom }}</h1>
            <p class="text-muted mb-0"><i class="bi bi-envelope me-1"></i>{{ $candidat->email }}</p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <small class="text-muted d-block">Téléphone</small>
                    <span class="fw-semibold">{{ $candidat->telephone ?? '—' }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h5 fw-bold mb-0">Candidatures soumises</h2>
        <span class="badge rounded-pill bg-primary-subtle text-primary-emphasis">{{ $candidat->candidatures->count() }}</span>
    </div>

    <div class="card mb-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Offre</th>
                        <th>Statut</th>
                        <th>Date de candidature</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($candidat->candidatures as $candidature)
                        <tr>
                            <td class="fw-semibold">{{ $candidature->offre->titre }}</td>
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
                            <td colspan="3" class="text-center text-muted py-4">Aucune candidature soumise.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <a href="{{ route('candidats.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Retour à la liste
    </a>
@endsection