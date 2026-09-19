<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold">Nom</label>
        <input type="text" name="nom" class="form-control" value="{{ old('nom', $candidat->nom ?? '') }}" required maxlength="50" placeholder="Ex: Traoré">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold">Prénom</label>
        <input type="text" name="prenom" class="form-control" value="{{ old('prenom', $candidat->prenom ?? '') }}" required maxlength="50" placeholder="Ex: Koura">
    </div>
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Email</label>
    <input type="email" name="email" class="form-control" value="{{ old('email', $candidat->email ?? '') }}" required maxlength="100" placeholder="exemple@email.com">
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Téléphone</label>
    <input type="text" name="telephone" class="form-control" value="{{ old('telephone', $candidat->telephone ?? '') }}" maxlength="20" placeholder="Ex: 70123456">
</div>

<div class="mb-4">
    <label class="form-label fw-semibold">CV (résumé texte)</label>
    <textarea name="cv" class="form-control" rows="5" placeholder="Résumé du parcours, compétences...">{{ old('cv', $candidat->cv ?? '') }}</textarea>
</div>