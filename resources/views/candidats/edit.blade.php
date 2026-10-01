@extends('layouts.app')

@section('title', 'Modifier le candidat')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card auth-card fade-in-up">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <div class="icon-wrapper icon-blue mx-auto mb-3" style="width:64px;height:64px;font-size:1.7rem;">
                            <i class="bi bi-pencil-fill"></i>
                        </div>
                        <h1 class="h3 fw-bold mb-1">Modifier le candidat #{{ $candidat->id_candidat }}</h1>
                        <p class="text-muted mb-0">Mettez à jour les informations du candidat</p>
                    </div>

                    <form action="{{ route('candidats.update', $candidat) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @include('candidats._form')

                        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold mb-2">
                            <i class="bi bi-check-lg me-1"></i>Mettre à jour
                        </button>
                        <a href="{{ route('candidats.index') }}" class="btn btn-outline-secondary w-100">Annuler</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection