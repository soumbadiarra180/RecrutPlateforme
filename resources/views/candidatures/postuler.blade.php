@extends('layouts.app')

@section('title', 'Postuler à l\'offre')

@section('content')
    <h1 class="h3 fw-bold mb-4">Postuler à : {{ $offre->titre }}</h1>

    <div class="card mb-4">
        <div class="card-body">
            <p class="mb-1"><strong>Lieu :</strong> {{ $offre->lieu }}</p>
            <p class="mb-1"><strong>Type de contrat :</strong> {{ $offre->type_contrat }}</p>
            <p class="mb-0">{{ $offre->description }}</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-4">
            <form action="{{ route('offres.postuler', $offre) }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="form-label fw-semibold">Lettre de motivation</label>
                    <textarea name="lettre_motivation" class="form-control" rows="6" placeholder="Expliquez pourquoi ce poste vous intéresse...">{{ old('lettre_motivation') }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-send me-1"></i>Envoyer ma candidature
                </button>
                <a href="{{ route('offres.show', $offre) }}" class="btn btn-outline-secondary">Annuler</a>
            </form>
        </div>
    </div>
@endsection