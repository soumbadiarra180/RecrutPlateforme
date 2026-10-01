@extends('layouts.app')

@section('title', 'Postuler à l\'offre')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card mb-4 fade-in-up">
                <div class="card-body p-4">
                    <span class="badge bg-primary-subtle text-primary mb-2">{{ $offre->type_contrat }}</span>
                    <h4 class="fw-bold mb-1">{{ $offre->titre }}</h4>
                    <p class="text-muted mb-3"><i class="bi bi-geo-alt me-1"></i>{{ $offre->lieu }}</p>
                    <p class="mb-0">{{ $offre->description }}</p>
                </div>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card auth-card fade-in-up" style="transition-delay: 0.1s;">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <div class="icon-wrapper icon-orange mx-auto mb-3" style="width:64px;height:64px;font-size:1.7rem;">
                            <i class="bi bi-send-fill"></i>
                        </div>
                        <h1 class="h4 fw-bold mb-1">Postuler à ce poste</h1>
                        <p class="text-muted mb-0">Votre profil sera automatiquement lié à cette candidature</p>
                    </div>

                    <form action="{{ route('offres.postuler', $offre) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold">CV <span class="text-muted fw-normal">(PDF, max 5 Mo)</span></label>
                            <input type="file" name="cv" class="form-control" accept=".pdf" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Lettre de motivation</label>
                            <textarea name="lettre_motivation" class="form-control" rows="6" placeholder="Expliquez pourquoi ce poste vous intéresse...">{{ old('lettre_motivation') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold mb-2">
                            <i class="bi bi-send me-1"></i>Envoyer ma candidature
                        </button>
                        <a href="{{ route('offres.show', $offre) }}" class="btn btn-outline-secondary w-100">Annuler</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection