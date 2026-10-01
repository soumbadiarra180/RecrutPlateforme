@extends('layouts.app')

@section('title', 'Nouveau candidat')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card auth-card fade-in-up">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <div class="icon-wrapper icon-green mx-auto mb-3" style="width:64px;height:64px;font-size:1.7rem;">
                            <i class="bi bi-person-plus-fill"></i>
                        </div>
                        <h1 class="h3 fw-bold mb-1">Nouveau candidat</h1>
                        <p class="text-muted mb-0">Ajoutez un profil de candidat au système</p>
                    </div>

                    <form action="{{ route('candidats.store') }}" method="POST">
                        @csrf
                        @include('candidats._form')

                        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold mb-2">
                            <i class="bi bi-check-lg me-1"></i>Enregistrer
                        </button>
                        <a href="{{ route('candidats.index') }}" class="btn btn-outline-secondary w-100">Annuler</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection