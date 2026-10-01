@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
    <div class="d-flex justify-content-center align-items-center" style="min-height: 75vh;">
        <div class="col-md-5 col-sm-8 col-11">
            <div class="card auth-card fade-in-up">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <div class="icon-wrapper icon-blue mx-auto mb-3" style="width:64px;height:64px;font-size:1.7rem;">
                            <i class="bi bi-box-arrow-in-right"></i>
                        </div>
                        <h1 class="h3 fw-bold mb-1">Content de vous revoir</h1>
                        <p class="text-muted mb-0">Connectez-vous pour accéder à votre espace</p>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('login') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Mot de passe</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                            <i class="bi bi-box-arrow-in-right me-1"></i>Se connecter
                        </button>
                    </form>

                    <p class="text-center text-muted mt-4 mb-0">
                        Pas encore de compte ? <a href="{{ route('register') }}" class="fw-semibold">S'inscrire</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection