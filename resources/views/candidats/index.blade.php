@extends('layouts.app')

@section('title', 'Candidats')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Candidats</h1>
            <p class="text-muted mb-0">{{ $candidats->total() }} candidat(s) enregistré(s)</p>
        </div>
        <a href="{{ route('candidats.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Nouveau candidat
        </a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th class="text-center">Candidatures</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($candidats as $candidat)
                        <tr>
                            <td class="text-muted">#{{ $candidat->id_candidat }}</td>
                            <td class="fw-semibold">{{ $candidat->nom }}</td>
                            <td>{{ $candidat->prenom }}</td>
                            <td><i class="bi bi-envelope me-1 text-muted"></i>{{ $candidat->email }}</td>
                            <td>{{ $candidat->telephone ?? '—' }}</td>
                            <td class="text-center">
                                <span class="badge rounded-pill bg-primary-subtle text-primary-emphasis">{{ $candidat->candidatures_count }}</span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('candidats.show', $candidat) }}" class="btn btn-sm btn-outline-secondary" title="Voir">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('candidats.edit', $candidat) }}" class="btn btn-sm btn-outline-primary" title="Modifier">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('candidats.destroy', $candidat) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Supprimer ce candidat ?');">
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
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="bi bi-person-x fs-3 d-block mb-2"></i>
                                Aucun candidat enregistré.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $candidats->links() }}
    </div>
@endsection