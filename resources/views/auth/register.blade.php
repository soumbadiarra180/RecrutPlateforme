@extends('layouts.app')

@section('title', 'Inscription')

@section('content')
    <div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="col-md-6 col-sm-9 col-11">
            <div class="card auth-card fade-in-up">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <div class="icon-wrapper icon-green mx-auto mb-3" style="width:64px;height:64px;font-size:1.7rem;">
                            <i class="bi bi-person-plus-fill"></i>
                        </div>
                        <h1 class="h3 fw-bold mb-1">Créer un compte</h1>
                        <p class="text-muted mb-0">Rejoignez ITRecrute en quelques secondes</p>
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

                    <form action="{{ route('register') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nom complet</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required maxlength="100" placeholder="Ex: Traoré Koura" autofocus>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required maxlength="100">
                        </div>

                      <div class="mb-3">
    <label class="form-label fw-semibold">Pays</label>
    <select name="pays" id="paysSelect" class="form-select" required>
        <option value="">-- Choisir un pays --</option>
        <option value="Mali" data-code="+223" {{ old('pays') == 'Mali' ? 'selected' : '' }}>Mali</option>
        <option value="Sénégal" data-code="+221" {{ old('pays') == 'Sénégal' ? 'selected' : '' }}>Sénégal</option>
        <option value="Côte d'Ivoire" data-code="+225" {{ old('pays') == "Côte d'Ivoire" ? 'selected' : '' }}>Côte d'Ivoire</option>
        <option value="Burkina Faso" data-code="+226" {{ old('pays') == 'Burkina Faso' ? 'selected' : '' }}>Burkina Faso</option>
        <option value="Guinée" data-code="+224" {{ old('pays') == 'Guinée' ? 'selected' : '' }}>Guinée</option>
        <option value="Niger" data-code="+227" {{ old('pays') == 'Niger' ? 'selected' : '' }}>Niger</option>
        <option value="Mauritanie" data-code="+222" {{ old('pays') == 'Mauritanie' ? 'selected' : '' }}>Mauritanie</option>
        <option value="France" data-code="+33" {{ old('pays') == 'France' ? 'selected' : '' }}>France</option>
        <option value="Autre" data-code="+" {{ old('pays') == 'Autre' ? 'selected' : '' }}>Autre</option>
    </select>
</div> 

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Téléphone</label>
                            <div class="input-group">
                                <span class="input-group-text" id="indicatifDisplay">+223</span>
                                <input type="text" name="telephone" class="form-control" value="{{ old('telephone') }}" required placeholder="Ex: 70123456" maxlength="20">
                            </div>
                            <input type="hidden" name="indicatif" id="indicatifInput" value="{{ old('indicatif', '+223') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Mot de passe</label>
                            <input type="password" name="password" class="form-control" required minlength="6">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Confirmer le mot de passe</label>
                            <input type="password" name="password_confirmation" class="form-control" required minlength="6">
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                            <i class="bi bi-person-plus me-1"></i>S'inscrire
                        </button>
                    </form>

                    <p class="text-center text-muted mt-4 mb-0">
                        Déjà un compte ? <a href="{{ route('login') }}" class="fw-semibold">Se connecter</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('paysSelect').addEventListener('change', function () {
            const code = this.options[this.selectedIndex].dataset.code || '+';
            document.getElementById('indicatifDisplay').textContent = code;
            document.getElementById('indicatifInput').value = code;
        });
    </script>
@endsection