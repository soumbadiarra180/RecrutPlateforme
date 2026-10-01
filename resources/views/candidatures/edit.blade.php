@extends('layouts.app')

@section('title', 'Traiter la candidature')

@php
    $statuts = [
        'recue' => ['Reçue', '#64748b'],
        'en_cours_examen' => ['En cours d\'examen', '#0284c7'],
        'entretien' => ['Entretien', '#d97706'],
        'acceptee' => ['Acceptée', '#16a34a'],
        'refusee' => ['Refusée', '#e11d48'],
    ];
    $statutActuel = old('statut', $candidature->statut);
    $c = $candidature->candidat;
@endphp

@section('content')
    <div class="ir-page-head">
        <div>
            <a href="{{ route('candidatures.index') }}" class="ir-back"><i class="bi bi-arrow-left"></i>Retour aux candidatures</a>
            <h1>Traiter la candidature</h1>
            <p>{{ $c->nom }} {{ $c->prenom }} · {{ $candidature->offre->titre }}</p>
        </div>
    </div>

    <div class="row g-4 align-items-start">
        <div class="col-lg-8">
            <form action="{{ route('candidatures.update', $candidature) }}" method="POST" class="ir-form-card" novalidate>
                @csrf
                @method('PUT')

                @if ($errors->any())
                    <div class="ir-alert m-4 mb-0" role="alert">
                        <i class="bi bi-exclamation-circle-fill"></i>
                        <div>La mise à jour n'a pas été enregistrée : corrigez les champs signalés ci-dessous.</div>
                    </div>
                @endif

                <section class="ir-form-section">
                    <div class="ir-form-section-head">
                        <span class="ir-step-badge">1</span>
                        <div><h2>Nouveau statut</h2><p>Le candidat reçoit une notification dès l'enregistrement.</p></div>
                    </div>
                    <div class="ir-choices" role="radiogroup" aria-label="Statut de la candidature">
                        @foreach ($statuts as $valeur => [$libelle, $couleur])
                            <label class="ir-choice">
                                <input type="radio" name="statut" value="{{ $valeur }}" data-label="{{ $libelle }}" {{ $statutActuel === $valeur ? 'checked' : '' }} required>
                                <span><span class="ir-dot-status" style="background:{{ $couleur }}"></span>{{ $libelle }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('statut')<div class="ir-error"><i class="bi bi-exclamation-circle"></i>{{ $message }}</div>@enderror

                    <div class="ir-field" id="entretienField" @if ($statutActuel !== 'entretien') hidden @endif>
                        <label for="date_entretien">Date et heure de l'entretien</label>
                        <div class="ir-control">
                            <i class="bi bi-calendar-event"></i>
                            <input type="datetime-local" id="date_entretien" name="date_entretien" class="ir-input @error('date_entretien') is-invalid @enderror"
                                   value="{{ old('date_entretien', $candidature->date_entretien ? \Carbon\Carbon::parse($candidature->date_entretien)->format('Y-m-d\TH:i') : '') }}">
                        </div>
                        @error('date_entretien')<div class="ir-error"><i class="bi bi-exclamation-circle"></i>{{ $message }}</div>@enderror
                    </div>
                </section>

                <section class="ir-form-section">
                    <div class="ir-form-section-head">
                        <span class="ir-step-badge">2</span>
                        <div><h2>Message au candidat <small class="text-muted fw-normal">(optionnel)</small></h2><p>Ajouté à la notification. Un motif clair est apprécié, surtout en cas de refus.</p></div>
                    </div>
                    <div class="ir-field">
                        <textarea id="motif_decision" name="motif_decision" rows="4" class="ir-input no-icon @error('motif_decision') is-invalid @enderror"
                                  placeholder="Ex : Merci pour votre candidature, nous aimerions vous rencontrer…" aria-label="Message au candidat">{{ old('motif_decision', $candidature->motif_decision) }}</textarea>
                    </div>

                    <div class="ir-notif-preview">
                        <span class="ir-label d-block mb-2">Aperçu de la notification envoyée</span>
                        <div class="ir-notif">
                            <span class="ir-notif-icon"><i class="bi bi-bell-fill"></i></span>
                            <div>
                                <strong>Mise à jour de votre candidature</strong>
                                <p id="notifText"></p>
                            </div>
                        </div>
                    </div>
                </section>

                <div class="ir-form-actions">
                    <a href="{{ route('candidatures.index') }}" class="ir-cancel">Annuler</a>
                    <button type="submit" class="ir-submit"><i class="bi bi-send-check"></i>Enregistrer et notifier</button>
                </div>
            </form>
        </div>

        <div class="col-lg-4">
            <aside class="ir-side">
                <div class="ir-side-card">
                    <h3>Le candidat</h3>
                    <div class="d-flex gap-3 align-items-center mb-3">
                        <span class="ir-cand-avatar">{{ strtoupper(mb_substr($c->nom, 0, 1) . mb_substr($c->prenom, 0, 1)) }}</span>
                        <div>
                            <strong class="d-block" style="color:var(--ir-ink)">{{ $c->nom }} {{ $c->prenom }}</strong>
                            <small class="text-muted">Candidature du {{ \Carbon\Carbon::parse($candidature->date_candidature)->format('d/m/Y') }}</small>
                        </div>
                    </div>
                    <div class="d-grid gap-2 small mb-3">
                        <span><i class="bi bi-envelope me-2 text-muted"></i>{{ $c->email }}</span>
                        @if ($c->telephone)<span><i class="bi bi-telephone me-2 text-muted"></i>{{ $c->telephone }}</span>@endif
                        @if ($c->pays)<span><i class="bi bi-geo-alt me-2 text-muted"></i>{{ $c->pays }}</span>@endif
                    </div>
                    @if ($candidature->cv_path)
                        <a href="{{ asset('storage/' . $candidature->cv_path) }}" target="_blank" rel="noopener" class="ir-cv-link">
                            <i class="bi bi-file-earmark-pdf-fill"></i><span><strong>Ouvrir le CV</strong><small>PDF · nouvel onglet</small></span><i class="bi bi-box-arrow-up-right ms-auto"></i>
                        </a>
                    @else
                        <p class="small text-muted mb-0">Aucun CV fourni.</p>
                    @endif
                </div>
                <div class="ir-side-card">
                    <h3>Lettre de motivation</h3>
                    <p class="small mb-0" style="white-space:pre-line;color:#334155">{{ $candidature->lettre_motivation ?: 'Aucune lettre de motivation.' }}</p>
                </div>
            </aside>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .ir-cand-avatar { width: 46px; height: 46px; flex-shrink: 0; border-radius: 50%; display: grid; place-items: center; background: #e8f0ff; color: var(--ir-blue); font-weight: 700; }
    .ir-cv-link { display: flex; align-items: center; gap: .8rem; padding: .8rem 1rem; border-radius: 12px; border: 1.5px solid #fecdd3; background: #fff7f8; color: #be123c; text-decoration: none; }
    .ir-cv-link:hover { background: #ffe8ee; color: #9f1239; }
    .ir-cv-link > i:first-child { font-size: 1.5rem; }
    .ir-cv-link strong { display: block; font-size: .9rem; }
    .ir-cv-link small { color: #9f1239; opacity: .75; }
    .ir-notif { display: flex; gap: .8rem; padding: 1rem; border-radius: 14px; background: var(--ir-soft); border: 1px solid var(--ir-line); }
    .ir-notif-icon { width: 38px; height: 38px; flex-shrink: 0; border-radius: 10px; display: grid; place-items: center; background: #fff4dc; color: #b45309; }
    .ir-notif strong { display: block; font-size: .92rem; color: var(--ir-ink); }
    .ir-notif p { margin: .2rem 0 0; font-size: .88rem; color: #475569; }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const titre = @json($candidature->offre->titre);
    const radios = document.querySelectorAll('input[name="statut"]');
    const entretienField = document.getElementById('entretienField');
    const dateInput = document.getElementById('date_entretien');
    const motif = document.getElementById('motif_decision');
    const out = document.getElementById('notifText');

    // Même message que celui construit par CandidatureController@update
    function render() {
        const checked = document.querySelector('input[name="statut"]:checked');
        const isEntretien = checked && checked.value === 'entretien';
        entretienField.hidden = !isEntretien;

        let msg = `Le statut de votre candidature pour le poste "${titre}" est maintenant : ${checked ? checked.dataset.label : '…'}.`;
        if (isEntretien && dateInput.value) {
            const d = new Date(dateInput.value);
            const pad = n => String(n).padStart(2, '0');
            msg += ` Votre entretien est prévu le ${pad(d.getDate())}/${pad(d.getMonth() + 1)}/${d.getFullYear()} à ${pad(d.getHours())}:${pad(d.getMinutes())}.`;
        }
        if (motif.value.trim()) msg += ` Commentaire du recruteur : ${motif.value.trim()}`;
        out.textContent = msg;
    }
    radios.forEach(r => r.addEventListener('change', render));
    dateInput.addEventListener('input', render);
    motif.addEventListener('input', render);
    render();
});
</script>
@endpush
