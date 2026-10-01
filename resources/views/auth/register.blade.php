@extends('layouts.app')

@section('title', 'Inscription')

@php
    $pays = [
        'Mali' => '+223', 'Sénégal' => '+221', "Côte d'Ivoire" => '+225', 'Burkina Faso' => '+226',
        'Guinée' => '+224', 'Niger' => '+227', 'Mauritanie' => '+222', 'France' => '+33', 'Autre' => '+',
    ];
    $paysChoisi = old('pays', 'Mali');
@endphp

@section('content')
    <div class="ir-auth fade-in-up">
        <aside class="ir-auth-aside">
            <a class="ir-brand" href="{{ url('/') }}">
                @include('partials.logo-mark', ['size' => 34])<span>Job<em>IT</em></span>
            </a>
            <div>
                <h2>Votre prochain poste tech <em>commence ici</em>.</h2>
                <p class="mt-2">Créez votre profil en deux minutes et postulez aux offres informatiques du Mali.</p>
            </div>
            <ul class="ir-auth-list">
                <li><i class="bi bi-lightning-charge"></i><span>Inscription gratuite, sans engagement</span></li>
                <li><i class="bi bi-file-earmark-pdf"></i><span>Postulez en un clic avec votre CV en PDF</span></li>
                <li><i class="bi bi-bell"></i><span>Suivez chaque étape jusqu'à la décision finale</span></li>
            </ul>
            <div class="ir-auth-quote">
                Vos informations ne sont visibles que par les recruteurs des offres auxquelles vous postulez.
            </div>
        </aside>

        <div class="ir-auth-main">
            <header>
                <span class="ir-kicker">Inscription candidat</span>
                <h1 class="mt-1">Créer votre compte</h1>
                <p>Tous les champs sont obligatoires.</p>
            </header>

            @if ($errors->any())
                <div class="ir-alert" role="alert">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <div>Certains champs sont à corriger, ils sont signalés en rouge ci-dessous.</div>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" class="d-grid gap-3" novalidate>
                @csrf

                <div class="ir-field">
                    <label for="name">Nom complet</label>
                    <div class="ir-control">
                        <i class="bi bi-person"></i>
                        <input type="text" id="name" name="name" class="ir-input @error('name') is-invalid @enderror"
                               value="{{ old('name') }}" placeholder="Ex : Traoré Koura" required maxlength="100" autofocus autocomplete="name">
                    </div>
                    @error('name')<div class="ir-error"><i class="bi bi-exclamation-circle"></i>{{ $message }}</div>@enderror
                </div>

                <div class="ir-field">
                    <label for="email">Email</label>
                    <div class="ir-control">
                        <i class="bi bi-envelope"></i>
                        <input type="email" id="email" name="email" class="ir-input @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" placeholder="vous@exemple.com" required maxlength="100" autocomplete="email">
                    </div>
                    @error('email')
                        <div class="ir-error"><i class="bi bi-exclamation-circle"></i>{{ $message }} <a href="{{ route('login') }}" class="ms-1">Se connecter</a></div>
                    @enderror
                </div>

                <div class="ir-grid-2">
                    <div class="ir-field">
                        <label for="paysSelect">Pays</label>
                        <div class="ir-control">
                            <i class="bi bi-globe-europe-africa"></i>
                            <select id="paysSelect" name="pays" class="ir-input @error('pays') is-invalid @enderror" required>
                                @foreach ($pays as $nom => $code)
                                    <option value="{{ $nom }}" data-code="{{ $code }}" {{ $paysChoisi === $nom ? 'selected' : '' }}>{{ $nom }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('pays')<div class="ir-error"><i class="bi bi-exclamation-circle"></i>{{ $message }}</div>@enderror
                    </div>

                    <div class="ir-field">
                        <label for="telephone">Téléphone</label>
                        <div class="ir-control">
                            <span class="ir-prefix" id="indicatifDisplay">{{ old('indicatif', $pays[$paysChoisi] ?? '+223') }}</span>
                            <input type="tel" id="telephone" name="telephone" class="ir-input has-prefix @error('telephone') is-invalid @enderror"
                                   value="{{ old('telephone') }}" placeholder="70 12 34 56" required maxlength="20" autocomplete="tel-national">
                        </div>
                        <input type="hidden" name="indicatif" id="indicatifInput" value="{{ old('indicatif', $pays[$paysChoisi] ?? '+223') }}">
                        @error('telephone')<div class="ir-error"><i class="bi bi-exclamation-circle"></i>{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="ir-grid-2">
                    <div class="ir-field">
                        <label for="password">Mot de passe</label>
                        <div class="ir-control">
                            <i class="bi bi-lock"></i>
                            <input type="password" id="password" name="password" class="ir-input has-eye @error('password') is-invalid @enderror"
                                   placeholder="6 caractères min." required minlength="6" autocomplete="new-password">
                            <button type="button" class="ir-eye" data-eye="password" aria-label="Afficher le mot de passe"><i class="bi bi-eye"></i></button>
                        </div>
                        <div class="ir-strength" aria-hidden="true"><span></span><span></span><span></span><span></span></div>
                        @error('password')<div class="ir-error"><i class="bi bi-exclamation-circle"></i>{{ $message }}</div>@enderror
                    </div>

                    <div class="ir-field">
                        <label for="password_confirmation">Confirmation</label>
                        <div class="ir-control">
                            <i class="bi bi-shield-check"></i>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="ir-input has-eye"
                                   placeholder="Retapez-le" required minlength="6" autocomplete="new-password">
                            <button type="button" class="ir-eye" data-eye="password_confirmation" aria-label="Afficher le mot de passe"><i class="bi bi-eye"></i></button>
                        </div>
                        <div class="ir-hint" id="confirmHint"></div>
                    </div>
                </div>

                <button type="submit" class="ir-submit w-full mt-2">
                    Créer mon compte <i class="bi bi-arrow-right"></i>
                </button>
            </form>

            <p class="ir-auth-switch">
                Déjà un compte ? <a href="{{ route('login') }}">Se connecter</a>
            </p>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .ir-strength { display: grid; grid-template-columns: repeat(4, 1fr); gap: 4px; }
    .ir-strength span { height: 4px; border-radius: 4px; background: var(--ir-line); transition: background .25s ease; }
    .ir-strength[data-level="1"] span:nth-child(-n+1) { background: #f43f5e; }
    .ir-strength[data-level="2"] span:nth-child(-n+2) { background: #f59e0b; }
    .ir-strength[data-level="3"] span:nth-child(-n+3) { background: #3b82f6; }
    .ir-strength[data-level="4"] span { background: #16a34a; }
</style>
@endpush

@push('scripts')
<script>
    // Indicatif téléphonique selon le pays
    document.getElementById('paysSelect').addEventListener('change', function () {
        const code = this.options[this.selectedIndex].dataset.code || '+';
        document.getElementById('indicatifDisplay').textContent = code;
        document.getElementById('indicatifInput').value = code;
    });

    // Force du mot de passe et vérification de la confirmation
    const pwd = document.getElementById('password');
    const confirmField = document.getElementById('password_confirmation');
    const meter = document.querySelector('.ir-strength');
    const hint = document.getElementById('confirmHint');
    function checkPasswords() {
        const v = pwd.value;
        let level = 0;
        if (v.length >= 6) level++;
        if (v.length >= 10) level++;
        if (/[A-Z]/.test(v) && /[a-z]/.test(v)) level++;
        if (/\d/.test(v) && /[^A-Za-z0-9]/.test(v)) level++;
        meter.dataset.level = v ? Math.max(level, 1) : 0;

        if (!confirmField.value) { hint.textContent = ''; return; }
        const ok = confirmField.value === v;
        hint.innerHTML = ok
            ? '<span style="color:#15803d"><i class="bi bi-check-circle"></i> Les mots de passe correspondent</span>'
            : '<span style="color:#be123c"><i class="bi bi-x-circle"></i> Les mots de passe sont différents</span>';
    }
    pwd.addEventListener('input', checkPasswords);
    confirmField.addEventListener('input', checkPasswords);
</script>
@endpush
