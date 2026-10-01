@extends('layouts.app')

@section('title', 'Candidatures')

@section('content')
    <div class="mb-4">
        <h1 class="h3 fw-bold mb-1">Candidatures</h1>
        <p class="text-muted mb-0">{{ $candidatures->total() }} candidature(s) enregistrée(s)</p>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Candidat</th>
                        <th>Offre</th>
                        <th>Statut</th>
                        <th>Entretien</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($candidatures as $candidature)
                        <tr>
                            <td class="fw-semibold">{{ $candidature->candidat->nom }} {{ $candidature->candidat->prenom }}</td>
                            <td>{{ $candidature->offre->titre }}</td>
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
                            <td class="text-end">
                                <a href="{{ route('candidatures.show', $candidature) }}" class="btn btn-sm btn-outline-secondary" title="Voir">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('candidatures.edit', $candidature) }}" class="btn btn-sm btn-outline-primary" title="Traiter">
                                    <i class="bi bi-arrow-repeat"></i>
                                </a>
                                <form action="{{ route('candidatures.destroy', $candidature) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Supprimer cette candidature ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="bi bi-file-earmark-x fs-3 d-block mb-2"></i>
                                Aucune candidature enregistrée.
                            </td>
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