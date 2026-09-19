<div class="mb-3">
    <label class="form-label fw-semibold">Titre du poste</label>
    <input type="text" name="titre" class="form-control" value="{{ old('titre', $offre->titre ?? '') }}" required maxlength="100" placeholder="Ex: Développeur Web Junior">
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Description</label>
    <textarea name="description" class="form-control" rows="5" required placeholder="Décrivez les missions, compétences requises...">{{ old('description', $offre->description ?? '') }}</textarea>
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