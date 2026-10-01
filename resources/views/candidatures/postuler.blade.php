@extends('layouts.app')

@section('title', 'Postuler à l\'offre')

@section('content')
    @php $candidat = auth()->user()->candidat; @endphp

    <div class="ir-page-head">
        <div>
            <a href="{{ route('offres.show', $offre) }}" class="ir-back"><i class="bi bi-arrow-left"></i>Retour à l'offre</a>
            <h1>Postuler</h1>
            <p>Envoyez votre CV pour le poste de <strong>{{ $offre->titre }}</strong>.</p>
        </div>
    </div>

    <div class="row g-4 align-items-start">
        <div class="col-lg-8">
            <form action="{{ route('offres.postuler', $offre) }}" method="POST" enctype="multipart/form-data" class="ir-form-card" novalidate>
                @csrf

                @if ($errors->any())
                    <div class="ir-alert m-4 mb-0" role="alert">
                        <i class="bi bi-exclamation-circle-fill"></i>
                        <div>Votre candidature n'a pas été envoyée : corrigez les champs signalés ci-dessous.</div>
                    </div>
                @endif

                <section class="ir-form-section">
                    <div class="ir-form-section-head">
                        <span class="ir-step-badge">1</span>
                        <div><h2>Votre CV</h2><p>Au format PDF, 5 Mo maximum.</p></div>
                    </div>
                    <label class="ir-drop @error('cv') is-invalid @enderror" data-drop>
                        <input type="file" name="cv" accept=".pdf,application/pdf" required>
                        <span class="ir-drop-icon"><i class="bi bi-file-earmark-arrow-up"></i></span>
                        <span>
                            <strong data-drop-title>Glissez votre CV ici ou cliquez pour le choisir</strong>
                            <small data-drop-sub>PDF uniquement · 5 Mo maximum</small>
                        </span>
                    </label>
                    @error('cv')<div class="ir-error"><i class="bi bi-exclamation-circle"></i>{{ $message }}</div>@enderror
                </section>

                <section class="ir-form-section">
                    <div class="ir-form-section-head">
                        <span class="ir-step-badge">2</span>
                        <div><h2>Lettre de motivation <small class="text-muted fw-normal">(optionnel)</small></h2><p>Quelques lignes suffisent : pourquoi ce poste, et ce que vous apportez.</p></div>
                    </div>
                    <div class="ir-field">
                        <textarea id="lettre_motivation" name="lettre_motivation" rows="7" class="ir-input no-icon @error('lettre_motivation') is-invalid @enderror"
                                  placeholder="Bonjour, je souhaite rejoindre votre équipe en tant que…" data-count aria-label="Lettre de motivation">{{ old('lettre_motivation') }}</textarea>
                        <div class="ir-hint"><span>Conseil : citez une ou deux réalisations concrètes.</span><span data-counter="lettre_motivation"></span></div>
                        @error('lettre_motivation')<div class="ir-error"><i class="bi bi-exclamation-circle"></i>{{ $message }}</div>@enderror
                    </div>
                </section>

                <div class="ir-form-actions">
                    <a href="{{ route('offres.show', $offre) }}" class="ir-cancel">Annuler</a>
                    <button type="submit" class="ir-submit"><i class="bi bi-send"></i>Envoyer ma candidature</button>
                </div>
            </form>
        </div>

        <div class="col-lg-4">
            <aside class="ir-side">
                <div class="ir-side-card">
                    <h3>Le poste</h3>
                    <div class="d-flex gap-3 align-items-start mb-3">
                        <span class="ir-prev-logo">{{ strtoupper(mb_substr($offre->titre, 0, 1)) }}</span>
                        <div>
                            <strong class="d-block" style="color:var(--ir-ink)">{{ $offre->titre }}</strong>
                            <small class="text-muted"><i class="bi bi-geo-alt"></i> {{ $offre->lieu }} · {{ $offre->type_contrat }}</small>
                        </div>
                    </div>
                    <p class="small text-muted mb-3">{{ Str::limit($offre->description, 160) }}</p>
                    <div class="small d-flex align-items-center gap-2" style="color:#b45309">
                        <i class="bi bi-calendar-x"></i>Candidatures jusqu'au {{ \Carbon\Carbon::parse($offre->date_limite)->format('d/m/Y') }}
                    </div>
                </div>
                @if ($candidat)
                    <div class="ir-side-card">
                        <h3>Envoyé avec votre profil</h3>
                        <div class="d-grid gap-2 small">
                            <span><i class="bi bi-person me-2 text-muted"></i>{{ $candidat->nom }} {{ $candidat->prenom }}</span>
                            <span><i class="bi bi-envelope me-2 text-muted"></i>{{ $candidat->email }}</span>
                            @if ($candidat->telephone)<span><i class="bi bi-telephone me-2 text-muted"></i>{{ $candidat->telephone }}</span>@endif
                        </div>
                    </div>
                @endif
            </aside>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .ir-prev-logo { width: 42px; height: 42px; flex-shrink: 0; border-radius: 11px; display: grid; place-items: center; color: #fff; font-weight: 800; background: linear-gradient(135deg, var(--ir-sky), var(--ir-blue)); }
</style>
@endpush
