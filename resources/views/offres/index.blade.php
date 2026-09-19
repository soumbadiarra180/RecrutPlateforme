@extends('layouts.app')

@section('title', 'Offres d\'emploi')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Offres d'emploi</h1>
            <p class="text-muted mb-0">{{ $offres->total() }} offre(s) au total</p>
        </div>
        <a href="{{ route('offres.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Nouvelle offre
        </a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Titre</th>
                        <th>Type</th>
                        <th>Lieu</th>
                        <th>Date limite</th>
                        <th>Statut</th>
                        <th class="text-center">Candidatures</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($offres as $offre)
                        <tr>
                            <td class="text-muted">#{{ $offre->id_offre }}</td>
                            <td class="fw-semibold">{{ $offre->titre }}</td>
                            <td><span class="badge bg-light text-dark border">{{ $offre->type_contrat }}</span></td>
                            <td>{{ $offre->lieu }}</td>
                            <td>{{ \Carbon\Carbon::parse($offre->date_limite)->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge {{ $offre->statut == 'ouverte' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $offre->statut == 'ouverte' ? 'Ouverte' : 'Fermée' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="badge rounded-pill bg-primary-subtle text-primary-emphasis">{{ $offre->candidatures_count }}</span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('offres.show', $offre) }}" class="btn btn-sm btn-outline-secondary" title="Voir">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('offres.edit', $offre) }}" class="btn btn-sm btn-outline-primary" title="Modifier">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('offres.destroy', $offre) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Supprimer cette offre ?');">
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
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                Aucune offre d'emploi publiée.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $offres->links() }}
    </div>
@endsection