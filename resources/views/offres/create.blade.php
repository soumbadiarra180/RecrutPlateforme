@extends('layouts.app')

@section('title', 'Nouvelle offre d\'emploi')

@section('content')
    <div class="ir-page-head">
        <div>
            <a href="{{ route('offres.index') }}" class="ir-back"><i class="bi bi-arrow-left"></i>Retour aux offres</a>
            <h1>Publier une offre</h1>
            <p>Décrivez le poste : il sera visible par tous les candidats dès sa publication.</p>
        </div>
    </div>

    <div class="row g-4 align-items-start">
        <div class="col-lg-8">
            <form action="{{ route('offres.store') }}" method="POST" class="ir-form-card" novalidate>
                @csrf
                @include('offres._form')
                <div class="ir-form-actions">
                    <a href="{{ route('offres.index') }}" class="ir-cancel">Annuler</a>
                    <button type="submit" class="ir-submit"><i class="bi bi-send"></i>Publier l'offre</button>
                </div>
            </form>
        </div>
        <div class="col-lg-4">
            @include('offres._preview')
        </div>
    </div>
@endsection
