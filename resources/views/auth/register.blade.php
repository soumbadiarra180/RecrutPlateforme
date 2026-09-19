@extends('layouts.app')

@section('title', 'Inscription')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="h3 fw-bold mb-4 text-center">Créer un compte</h1>

            <div class="card">
                <div class="card-body p-4">
                    <form action="{{ route('register') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nom complet</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required maxlength="100" placeholder="Ex: Traoré Koura">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required maxlength="100">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Mot de passe</label>
                            <input type="password" name="password" class="form-control" required minlength="6">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Confirmer le mot de passe</label>
                            <input type="password" name="password_confirmation" class="form-control" required minlength="6">
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-person-plus me-1"></i>S'inscrire
                        </button>
                    </form>

                    <p class="text-center text-muted mt-3 mb-0">
                        Déjà un compte ? <a href="{{ route('login') }}">Se connecter</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection