@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
    <div class="ir-auth fade-in-up">
        <aside class="ir-auth-aside">
            <a class="ir-brand" href="{{ url('/') }}">
                @include('partials.logo-mark', ['size' => 34])<span>Job<em>IT</em></span>
            </a>
            <div>
                <h2>Content de vous <em>revoir</em>.</h2>
                <p class="mt-2">Reprenez là où vous en étiez : vos candidatures, vos entretiens et vos notifications vous attendent.</p>
            </div>
            <ul class="ir-auth-list">
                <li><i class="bi bi-bell"></i><span>Une notification à chaque changement de statut</span></li>
                <li><i class="bi bi-calendar-check"></i><span>Vos dates d'entretien, au même endroit</span></li>
                <li><i class="bi bi-briefcase"></i><span>Les nouvelles offres IT dès leur publication</span></li>
            </ul>
            <div class="ir-auth-quote">
                <strong>Recruteur ?</strong> Connectez-vous avec votre compte pour publier des offres et traiter les candidatures.
            </div>
        </aside>

        <div class="ir-auth-main">
            <header>
                <span class="ir-kicker">Connexion</span>
                <h1 class="mt-1">Accédez à votre espace</h1>
                <p>Entrez l'email et le mot de passe de votre compte.</p>
            </header>

            @if ($errors->any())
                <div class="ir-alert" role="alert">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <div>
                        @if ($errors->count() === 1)
                            {{ $errors->first() }}
                        @else
                            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                        @endif
                    </div>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="d-grid gap-3" novalidate>
                @csrf

                <div class="ir-field">
                    <label for="email">Email</label>
                    <div class="ir-control">
                        <i class="bi bi-envelope"></i>
                        <input type="email" id="email" name="email" class="ir-input @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" placeholder="vous@exemple.com" required autofocus autocomplete="email">
                    </div>
                </div>

                <div class="ir-field">
                    <label for="password">Mot de passe</label>
                    <div class="ir-control">
                        <i class="bi bi-lock"></i>
                        <input type="password" id="password" name="password" class="ir-input has-eye @error('password') is-invalid @enderror"
                               placeholder="Votre mot de passe" required autocomplete="current-password">
                        <button type="button" class="ir-eye" data-eye="password" aria-label="Afficher le mot de passe"><i class="bi bi-eye"></i></button>
                    </div>
                </div>

                <button type="submit" class="ir-submit w-full mt-2">
                    Se connecter <i class="bi bi-arrow-right"></i>
                </button>
            </form>

            <p class="ir-auth-switch">
                Pas encore de compte ? <a href="{{ route('register') }}">Créer un compte gratuit</a>
            </p>
        </div>
    </div>
@endsection
