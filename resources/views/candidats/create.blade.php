@extends('layouts.app')

@section('title', 'Nouveau candidat')

@section('content')
    <h1 class="h3 fw-bold mb-4">Nouveau candidat</h1>

    <div class="card">
        <div class="card-body p-4">
            <form action="{{ route('candidats.store') }}" method="POST">
                @csrf
                @include('candidats._form')

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i>Enregistrer
                </button>
                <a href="{{ route('candidats.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </form>
        </div>
    </div>
@endsection