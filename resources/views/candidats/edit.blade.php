@extends('layouts.app')

@section('title', 'Modifier le candidat')

@section('content')
    <h1 class="h3 fw-bold mb-4">Modifier le candidat #{{ $candidat->id_candidat }}</h1>

    <div class="card">
        <div class="card-body p-4">
            <form action="{{ route('candidats.update', $candidat) }}" method="POST">
                @csrf
                @method('PUT')
                @include('candidats._form')

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i>Mettre à jour
                </button>
                <a href="{{ route('candidats.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </form>
        </div>
    </div>
@endsection