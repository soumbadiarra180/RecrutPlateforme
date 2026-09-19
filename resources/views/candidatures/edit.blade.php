@extends('layouts.app')

@section('title', 'Traiter la candidature')

@section('content')
    <h1 class="h3 fw-bold mb-4">Candidature de {{ $candidature->candidat->nom }} {{ $candidature->candidat->prenom }}</h1>

    <div class="card mb-4">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <small class="text-muted d-block">Offre concernée</small>
                    <span class="fw-semibold">{{ $candidature->offre->titre }}</span>
                </div>
                <div class="col-md-6">
                    <small class="text-muted d-block">Date de candidature</small>
                    <span class="fw-semibold">{{ \Carbon\Carbon::parse($candidature->date_candidature)->format('d/m/Y') }}</span>
                </div>
            </div>
            <hr>
            <small class="text-muted d-block mb-1">Lettre de motivation</small>
            <p class="mb-0">{{ $candidature->lettre_motivation ?? '—' }}</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-4">
            <form action="{{ route('candidatures.update', $candidature) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold">Statut de la candidature</label>
                    <select name="statut" class="form-select" required>
                        <option value="recue" {{ $candidature->statut == 'recue' ? 'selected' : '' }}>Reçue</option>
                        <option value="en_cours_examen" {{ $candidature->statut == 'en_cours_examen' ? 'selected' : '' }}>En cours d'examen</option>
                        <option value="entretien" {{ $candidature->statut == 'entretien' ? 'selected' : '' }}>Entretien programmé</option>
                        <option value="acceptee" {{ $candidature->statut == 'acceptee' ? 'selected' : '' }}>Acceptée</option>
                        <option value="refusee" {{ $candidature->statut == 'refusee' ? 'selected' : '' }}>Refusée</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Motif / commentaire (optionnel)</label>
                    <textarea name="motif_decision" class="form-control" rows="4" placeholder="Justification de la décision...">{{ old('motif_decision', $candidature->motif_decision) }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i>Mettre à jour le statut
                </button>
                <a href="{{ route('candidatures.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </form>
        </div>
    </div>
@endsection