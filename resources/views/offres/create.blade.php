@extends('layouts.app')

@section('title', 'Nouvelle offre d\'emploi')

@section('content')
    <h1 class="h3 fw-bold mb-4">Nouvelle offre d'emploi</h1>

    <div class="card">
        <div class="card-body p-4">
            <form action="{{ route('offres.store') }}" method="POST">
                @csrf
                @include('offres._form')

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i>Publier l'offre
                </button>
                <a href="{{ route('offres.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </form>
        </div>
    </div>
@endsection