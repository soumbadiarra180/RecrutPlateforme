@php
    $valeur = fn ($champ, $defaut = '') => old($champ, $offre->$champ ?? $defaut);
    $date = fn ($champ, $defaut = '') => old($champ, isset($offre->$champ) ? \Carbon\Carbon::parse($offre->$champ)->format('Y-m-d') : $defaut);
@endphp

@if ($errors->any())
    <div class="ir-alert m-4 mb-0" role="alert">
        <i class="bi bi-exclamation-circle-fill"></i>
        <div>Certains champs sont à corriger, ils sont signalés en rouge ci-dessous.</div>
    </div>
@endif

{{-- 1. Le poste --}}
<section class="ir-form-section">
    <div class="ir-form-section-head">
        <span class="ir-step-badge">1</span>
        <div><h2>Le poste</h2><p>Ce que les candidats voient en premier dans la liste des offres.</p></div>
    </div>

    <div class="ir-field">
        <label for="titre">Titre du poste</label>
        <div class="ir-control">
            <i class="bi bi-briefcase"></i>
            <input type="text" id="titre" name="titre" class="ir-input @error('titre') is-invalid @enderror"
                   value="{{ $valeur('titre') }}" required maxlength="100" placeholder="Ex : Développeur Web Laravel" data-preview="titre">
        </div>
        @error('titre')<div class="ir-error"><i class="bi bi-exclamation-circle"></i>{{ $message }}</div>@enderror
    </div>

    <div class="ir-field">
        <span class="ir-label">Type de contrat</span>
        <div class="ir-choices" role="radiogroup" aria-label="Type de contrat">
            @foreach (['CDI' => 'bi-shield-check', 'CDD' => 'bi-hourglass-split', 'Stage' => 'bi-mortarboard', 'Freelance' => 'bi-laptop'] as $type => $icone)
                <label class="ir-choice">
                    <input type="radio" name="type_contrat" value="{{ $type }}" {{ $valeur('type_contrat') === $type ? 'checked' : '' }} required data-preview="type">
                    <span><i class="bi {{ $icone }}"></i>{{ $type }}</span>
                </label>
            @endforeach
        </div>
        @error('type_contrat')<div class="ir-error"><i class="bi bi-exclamation-circle"></i>{{ $message }}</div>@enderror
    </div>

    <div class="ir-field">
        <label for="lieu">Lieu</label>
        <div class="ir-control">
            <i class="bi bi-geo-alt"></i>
            <input type="text" id="lieu" name="lieu" class="ir-input @error('lieu') is-invalid @enderror"
                   value="{{ $valeur('lieu') }}" required maxlength="100" placeholder="Ex : Bamako, ACI 2000" data-preview="lieu">
        </div>
        @error('lieu')<div class="ir-error"><i class="bi bi-exclamation-circle"></i>{{ $message }}</div>@enderror
    </div>
</section>

{{-- 2. Description --}}
<section class="ir-form-section">
    <div class="ir-form-section-head">
        <span class="ir-step-badge">2</span>
        <div><h2>Description</h2><p>Plus l'offre est précise, plus les candidatures sont pertinentes.</p></div>
    </div>

    <div class="ir-field">
        <label for="description">Présentation du poste</label>
        <textarea id="description" name="description" rows="4" class="ir-input no-icon @error('description') is-invalid @enderror"
                  required placeholder="Présentez l'entreprise, l'équipe et le contexte du poste…" data-preview="description" data-count>{{ $valeur('description') }}</textarea>
        <div class="ir-hint"><span>Les 95 premiers caractères apparaissent dans la carte de l'offre.</span><span data-counter="description"></span></div>
        @error('description')<div class="ir-error"><i class="bi bi-exclamation-circle"></i>{{ $message }}</div>@enderror
    </div>

    <div class="ir-field">
        <label for="missions">Missions principales <small>(optionnel)</small></label>
        <textarea id="missions" name="missions" rows="4" class="ir-input no-icon @error('missions') is-invalid @enderror"
                  placeholder="Une mission par ligne. Ex : Développer de nouvelles fonctionnalités">{{ $valeur('missions') }}</textarea>
    </div>

    <div class="ir-grid-2">
        <div class="ir-field">
            <label for="competences">Compétences recherchées <small>(optionnel)</small></label>
            <textarea id="competences" name="competences" rows="3" class="ir-input no-icon"
                      placeholder="Ex : PHP, Laravel, MySQL, Git">{{ $valeur('competences') }}</textarea>
        </div>
        <div class="ir-field">
            <label for="profil_recherche">Profil recherché <small>(optionnel)</small></label>
            <textarea id="profil_recherche" name="profil_recherche" rows="3" class="ir-input no-icon"
                      placeholder="Ex : Bac+3 en informatique, 1 an d'expérience">{{ $valeur('profil_recherche') }}</textarea>
        </div>
    </div>
</section>

{{-- 3. Publication --}}
<section class="ir-form-section">
    <div class="ir-form-section-head">
        <span class="ir-step-badge">3</span>
        <div><h2>Publication</h2><p>Après la date limite, les candidats ne peuvent plus postuler.</p></div>
    </div>

    <div class="ir-grid-2">
        <div class="ir-field">
            <label for="date_publication">Date de publication</label>
            <div class="ir-control">
                <i class="bi bi-calendar"></i>
                <input type="date" id="date_publication" name="date_publication" class="ir-input @error('date_publication') is-invalid @enderror"
                       value="{{ $date('date_publication', now()->format('Y-m-d')) }}" required>
            </div>
            @error('date_publication')<div class="ir-error"><i class="bi bi-exclamation-circle"></i>{{ $message }}</div>@enderror
        </div>
        <div class="ir-field">
            <label for="date_limite">Date limite de candidature</label>
            <div class="ir-control">
                <i class="bi bi-calendar-x"></i>
                <input type="date" id="date_limite" name="date_limite" class="ir-input @error('date_limite') is-invalid @enderror"
                       value="{{ $date('date_limite') }}" required data-preview="limite">
            </div>
            @error('date_limite')<div class="ir-error"><i class="bi bi-exclamation-circle"></i>{{ $message }}</div>@enderror
        </div>
    </div>

    <div class="ir-field">
        <span class="ir-label">Statut</span>
        <div class="ir-choices">
            <label class="ir-choice">
                <input type="radio" name="statut" value="ouverte" {{ $valeur('statut', 'ouverte') === 'ouverte' ? 'checked' : '' }}>
                <span><span class="ir-dot-status" style="background:#16a34a"></span>Ouverte aux candidatures</span>
            </label>
            <label class="ir-choice">
                <input type="radio" name="statut" value="fermee" {{ $valeur('statut') === 'fermee' ? 'checked' : '' }}>
                <span><span class="ir-dot-status" style="background:#94a3b8"></span>Fermée</span>
            </label>
        </div>
    </div>
</section>
