@extends('layouts.app')

@section('title', 'Mes candidatures')

@section('content')
    <div class="mb-4">
        <h1 class="h3 fw-bold mb-1">Mes candidatures</h1>
        <p class="text-muted mb-0">{{ $candidatures->total() }} candidature(s) soumise(s)</p>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Offre</th>
                        <th>Statut</th>
                        <th>Entretien / Date de candidature</th>
                        <th>Commentaire du recruteur</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($candidatures as $candidature)
                        <tr>
                            <td class="fw-semibold">{{ $candidature->offre->titre }}</td>
                            <td>
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
                            </td>
                            <td>
                                @if ($candidature->date_entretien)
                                    <i class="bi bi-calendar-event me-1 text-warning"></i>
                                    <span class="fw-semibold">{{ \Carbon\Carbon::parse($candidature->date_entretien)->format('d/m/Y à H:i') }}</span>
                                @else
                                    <span class="text-muted">Candidature du {{ \Carbon\Carbon::parse($candidature->date_candidature)->format('d/m/Y') }}</span>
                                @endif
                            </td>
                            <td class="text-muted">{{ $candidature->motif_decision ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">Vous n'avez soumis aucune candidature pour le moment.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $candidatures->links() }}
    </div>
@endsection