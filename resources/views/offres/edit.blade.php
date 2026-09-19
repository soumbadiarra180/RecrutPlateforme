@extends('layouts.app')

@section('title', 'Modifier l\'offre')

@section('content')
    <h1 class="h3 fw-bold mb-4">Modifier l'offre #{{ $offre->id_offre }}</h1>

    <div class="card">
        <div class="card-body p-4">
            <form action="{{ route('offres.update', $offre) }}" method="POST">
                @csrf
                @method('PUT')
                @include('offres._form')

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i>Mettre à jour
                </button>
                <a href="{{ route('offres.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </form>
        </div>
    </div>
@endsection