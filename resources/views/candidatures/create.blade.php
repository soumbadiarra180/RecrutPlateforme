@extends('layouts.app')

@section('title', 'Nouvelle candidature')

@section('content')
    <h1 class="h3 fw-bold mb-4">Nouvelle candidature</h1>

    <div class="card">
        <div class="card-body p-4">
            <form action="{{ route('candidatures.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">Candidat</label>
                    <select name="id_candidat" class="form-select" required>
                        <option value="">-- Choisir un candidat --</option>
                        @foreach ($candidats as $candidat)
                            <option value="{{ $candidat->id_candidat }}" {{ old('id_candidat') == $candidat->id_candidat ? 'selected' : '' }}>
                                {{ $candidat->nom }} {{ $candidat->prenom }} ({{ $candidat->email }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Offre d'emploi</label>
                    <select name="id_offre" class="form-select" required>
                        <option value="">-- Choisir une offre --</option>
                        @foreach ($offres as $offre)
                            <option value="{{ $offre->id_offre }}" {{ old('id_offre') == $offre->id_offre ? 'selected' : '' }}>
                                {{ $offre->titre }} ({{ $offre->lieu }})
                            </option>
                        @endforeach
                    </select>
                    @if ($offres->isEmpty())
                        <small class="text-danger"><i class="bi bi-exclamation-circle me-1"></i>Aucune offre ouverte actuellement.</small>
                    @endif
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Lettre de motivation</label>
                    <textarea name="lettre_motivation" class="form-control" rows="5" placeholder="Rédigez la lettre de motivation...">{{ old('lettre_motivation') }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Date de candidature</label>
                    <input type="date" name="date_candidature" class="form-control" value="{{ old('date_candidature', date('Y-m-d')) }}" required>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-send me-1"></i>Soumettre la candidature
                </button>
                <a href="{{ route('candidatures.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </form>
        </div>
    </div>
@endsection