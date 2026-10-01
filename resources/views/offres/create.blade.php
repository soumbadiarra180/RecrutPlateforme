@extends('layouts.app')

@section('title', 'Nouvelle offre d\'emploi')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card auth-card fade-in-up">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <div class="icon-wrapper icon-orange mx-auto mb-3" style="width:64px;height:64px;font-size:1.7rem;">
                            <i class="bi bi-briefcase-fill"></i>
                        </div>
                        <h1 class="h3 fw-bold mb-1">Nouvelle offre d'emploi</h1>
                        <p class="text-muted mb-0">Décrivez le poste que vous recherchez</p>
                    </div>

                    <form action="{{ route('offres.store') }}" method="POST">
                        @csrf
                        @include('offres._form')

                        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold mb-2">
                            <i class="bi bi-check-lg me-1"></i>Publier l'offre
                        </button>
                        <a href="{{ route('offres.index') }}" class="btn btn-outline-secondary w-100">Annuler</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection