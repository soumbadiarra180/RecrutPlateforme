@extends('layouts.app')

@section('title', 'Modifier l\'offre')

@section('content')
    <div class="ir-page-head">
        <div>
            <a href="{{ route('offres.show', $offre) }}" class="ir-back"><i class="bi bi-arrow-left"></i>Retour à l'offre</a>
            <h1>Modifier l'offre</h1>
            <p>{{ $offre->titre }} · publiée le {{ \Carbon\Carbon::parse($offre->date_publication)->format('d/m/Y') }}</p>
        </div>
    </div>

    <div class="row g-4 align-items-start">
        <div class="col-lg-8">
            <form action="{{ route('offres.update', $offre) }}" method="POST" class="ir-form-card" novalidate>
                @csrf
                @method('PUT')
                @include('offres._form')
                <div class="ir-form-actions">
                    <a href="{{ route('offres.index') }}" class="ir-cancel">Annuler</a>
                    <button type="submit" class="ir-submit"><i class="bi bi-check-lg"></i>Enregistrer les modifications</button>
                </div>
            </form>
        </div>
        <div class="col-lg-4">
            @include('offres._preview')
        </div>
    </div>
@endsection
