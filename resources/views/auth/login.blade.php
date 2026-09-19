@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="h3 fw-bold mb-4 text-center">Connexion</h1>

            <div class="card">
                <div class="card-body p-5">
                    <form action="{{ route('login') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" class="form-control form-control-lg" value="{{ old('email') }}" required>
                        </div>

                        <div class="mb-5">
                            <label class="form-label fw-semibold">Mot de passe</label>
                            <input type="password" name="password" class="form-control form-control-lg" required>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="bi bi-box-arrow-in-right me-1"></i>Se connecter
                        </button>
                    </form>

                    <p class="text-center text-muted mt-4 mb-0">
                        Pas encore de compte ? <a href="{{ route('register') }}">S'inscrire</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection