<div class="mb-3">
    <label class="form-label fw-semibold">Titre du poste</label>
    <input type="text" name="titre" class="form-control" value="{{ old('titre', $offre->titre ?? '') }}" required maxlength="100" placeholder="Ex: Développeur Web Junior">
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Description</label>
    <textarea name="description" class="form-control" rows="4" required placeholder="Présentation générale du poste...">{{ old('description', $offre->description ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Missions principales <span class="text-muted fw-normal">(optionnel)</span></label>
    <textarea name="missions" class="form-control" rows="4" placeholder="Ex: Développer et maintenir les fonctionnalités du site, participer aux réunions d'équipe...">{{ old('missions', $offre->missions ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Compétences recherchées <span class="text-muted fw-normal">(optionnel)</span></label>
    <textarea name="competences" class="form-control" rows="3" placeholder="Ex: PHP, Laravel, MySQL, travail en équipe...">{{ old('competences', $offre->competences ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Profil recherché <span class="text-muted fw-normal">(optionnel)</span></label>
    <textarea name="profil_recherche" class="form-control" rows="3" placeholder="Ex: Bac+3 en informatique, 1 an d'expérience minimum...">{{ old('profil_recherche', $offre->profil_recherche ?? '') }}</textarea>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold">Type de contrat</label>
        <select name="type_contrat" class="form-select" required>
            <option value="">-- Choisir --</option>
            @foreach (['CDI', 'CDD', 'Stage', 'Freelance'] as $type)
                <option value="{{ $type }}" {{ old('type_contrat', $offre->type_contrat ?? '') == $type ? 'selected' : '' }}>
                    {{ $type }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold">Lieu</label>
        <input type="text" name="lieu" class="form-control" value="{{ old('lieu', $offre->lieu ?? '') }}" required maxlength="100" placeholder="Ex: Bamako">
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold">Date de publication</label>
        <input type="date" name="date_publication" class="form-control" value="{{ old('date_publication', isset($offre->date_publication) ? \Carbon\Carbon::parse($offre->date_publication)->format('Y-m-d') : '') }}" required>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold">Date limite de candidature</label>
        <input type="date" name="date_limite" class="form-control" value="{{ old('date_limite', isset($offre->date_limite) ? \Carbon\Carbon::parse($offre->date_limite)->format('Y-m-d') : '') }}" required>
    </div>
</div>

<div class="mb-4">
    <label class="form-label fw-semibold">Statut</label>
    <select name="statut" class="form-select" required>
        <option value="ouverte" {{ old('statut', $offre->statut ?? 'ouverte') == 'ouverte' ? 'selected' : '' }}>Ouverte</option>
        <option value="fermee" {{ old('statut', $offre->statut ?? '') == 'fermee' ? 'selected' : '' }}>Fermée</option>
    </select>
</div>