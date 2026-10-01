@extends('layouts.app')

@section('title', 'Traiter la candidature')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card mb-4 fade-in-up">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-3">{{ $candidature->candidat->nom }} {{ $candidature->candidat->prenom }}</h4>
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
                    <small class="text-muted d-block mb-1">CV du candidat</small>
                    @if ($candidature->cv_path)
                        <a href="{{ asset('storage/' . $candidature->cv_path) }}" target="_blank" class="btn btn-outline-primary btn-sm mb-3">
                            <i class="bi bi-file-earmark-pdf me-1"></i>Consulter le CV (PDF)
                        </a>
                    @else
                        <p class="text-muted mb-3">Aucun CV fourni.</p>
                    @endif
                    <hr>
                    <small class="text-muted d-block mb-1">Lettre de motivation</small>
                    <p class="mb-0">{{ $candidature->lettre_motivation ?? '—' }}</p>
                </div>
            </div>

            <div class="card auth-card fade-in-up" style="transition-delay: 0.1s;">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <div class="icon-wrapper icon-blue mx-auto mb-3" style="width:64px;height:64px;font-size:1.7rem;">
                            <i class="bi bi-arrow-repeat"></i>
                        </div>
                        <h1 class="h4 fw-bold mb-1">Traiter cette candidature</h1>
                        <p class="text-muted mb-0">Mettez à jour le statut et informez le candidat</p>
                    </div>

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

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Date et heure d'entretien (si applicable)</label>
                            <input type="datetime-local" name="date_entretien" class="form-control"
                                value="{{ old('date_entretien', $candidature->date_entretien ? \Carbon\Carbon::parse($candidature->date_entretien)->format('Y-m-d\TH:i') : '') }}">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Motif / commentaire (optionnel)</label>
                            <textarea name="motif_decision" class="form-control" rows="4" placeholder="Justification de la décision...">{{ old('motif_decision', $candidature->motif_decision) }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold mb-2">
                            <i class="bi bi-check-lg me-1"></i>Mettre à jour le statut
                        </button>
                        <a href="{{ route('candidatures.index') }}" class="btn btn-outline-secondary w-100">Annuler</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection