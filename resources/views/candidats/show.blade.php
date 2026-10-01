@extends('layouts.app')

@section('title', $candidat->nom . ' ' . $candidat->prenom)

@php
    $statutLabel = [
        'recue' => 'Reçue', 'en_cours_examen' => 'En cours d\'examen', 'entretien' => 'Entretien',
        'acceptee' => 'Acceptée', 'refusee' => 'Refusée',
    ];
    $candidatures = $candidat->candidatures;
    $dernierCv = $candidatures->firstWhere('cv_path')?->cv_path;
@endphp

@section('content')
    <div class="ir-page-head">
        <div>
            <a href="{{ route('candidats.index') }}" class="ir-back"><i class="bi bi-arrow-left"></i>Retour aux candidats</a>
        </div>
    </div>

    <div class="row g-4 align-items-start">
        <div class="col-lg-4">
            <aside class="ir-side">
                <div class="ir-profile">
                    <span class="ir-profile-avatar">{{ strtoupper(mb_substr($candidat->nom, 0, 1) . mb_substr($candidat->prenom, 0, 1)) }}</span>
                    <h1>{{ $candidat->nom }} {{ $candidat->prenom }}</h1>
                    <p>Candidat{{ $candidat->created_at ? ' · inscrit ' . $candidat->created_at->diffForHumans() : '' }}</p>
                    <ul class="ir-profile-info">
                        <li><i class="bi bi-envelope"></i><a href="mailto:{{ $candidat->email }}">{{ $candidat->email }}</a></li>
                        <li><i class="bi bi-telephone"></i>{{ $candidat->telephone ?: 'Non renseigné' }}</li>
                        <li><i class="bi bi-geo-alt"></i>{{ $candidat->pays ?: 'Non renseigné' }}</li>
                    </ul>
                    @if ($dernierCv)
                        <a href="{{ asset('storage/' . $dernierCv) }}" target="_blank" rel="noopener" class="ir-submit w-full"><i class="bi bi-file-earmark-pdf"></i>Dernier CV envoyé</a>
                    @endif
                </div>
            </aside>
        </div>

        <div class="col-lg-8">
            <div class="row g-3 mb-4">
                @foreach ([
                    ['Candidatures', $candidatures->count(), 'bi-send', '#e8f0ff', 'var(--ir-blue)'],
                    ['En cours', $candidatures->whereIn('statut', ['recue', 'en_cours_examen', 'entretien'])->count(), 'bi-hourglass-split', '#fff4dc', '#b45309'],
                    ['Acceptées', $candidatures->where('statut', 'acceptee')->count(), 'bi-trophy', '#e3f8ee', '#15803d'],
                ] as [$libelle, $n, $icone, $fond, $couleur])
                    <div class="col-4">
                        <div class="ir-mini-stat">
                            <span style="background: {{ $fond }}; color: {{ $couleur }}"><i class="bi {{ $icone }}"></i></span>
                            <strong>{{ $n }}</strong>
                            <small>{{ $libelle }}</small>
                        </div>
                    </div>
                @endforeach
            </div>

            <section class="ir-panel overflow-hidden">
                <div class="ir-panel-title">
                    <h2>Historique des candidatures</h2>
                </div>
                @forelse ($candidatures as $candidature)
                    <div class="ir-hrow">
                        <span class="ir-hlogo">{{ $candidature->offre ? strtoupper(mb_substr($candidature->offre->titre, 0, 1)) : '?' }}</span>
                        <div class="ir-hrow-main">
                            @if ($candidature->offre)
                                <a href="{{ route('offres.show', $candidature->offre) }}">{{ $candidature->offre->titre }}</a>
                            @else
                                <span>Offre supprimée</span>
                            @endif
                            <small>
                                Envoyée le {{ \Carbon\Carbon::parse($candidature->date_candidature)->format('d/m/Y') }}
                                @if ($candidature->statut === 'entretien' && $candidature->date_entretien)
                                    · <span style="color:#b45309">entretien le {{ $candidature->date_entretien->format('d/m/Y à H:i') }}</span>
                                @endif
                            </small>
                        </div>
                        <span class="ir-status ir-st-{{ $candidature->statut }}">{{ $statutLabel[$candidature->statut] ?? $candidature->statut }}</span>
                        <a href="{{ route('candidatures.edit', $candidature) }}" class="ir-btn-mini">Traiter</a>
                    </div>
                @empty
                    <div class="ir-empty-state">
                        <span class="ir-empty-icon"><i class="bi bi-send"></i></span>
                        <h2>Aucune candidature</h2>
                        <p>Ce candidat n'a encore postulé à aucune offre.</p>
                    </div>
                @endforelse
            </section>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .ir-profile { background: #fff; border: 1px solid var(--ir-line); border-radius: 22px; padding: 2rem 1.6rem 1.6rem; text-align: center; position: relative; overflow: hidden; }
    .ir-profile::before { content: ''; position: absolute; inset: 0 0 auto; height: 86px; background: radial-gradient(300px 120px at 100% 0%, rgba(59,130,246,.45), transparent 60%), linear-gradient(150deg, var(--ir-navy-2), var(--ir-navy)); }
    .ir-profile > * { position: relative; }
    .ir-profile-avatar { width: 84px; height: 84px; margin: 0 auto 1rem; border-radius: 24px; display: grid; place-items: center; font-size: 1.8rem; font-weight: 800; color: #fff; background: linear-gradient(135deg, var(--ir-cyan), var(--ir-sky)); border: 4px solid #fff; font-family: 'Plus Jakarta Sans', sans-serif; }
    .ir-profile h1 { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.35rem; font-weight: 800; color: var(--ir-ink); margin: 0; }
    .ir-profile > p { color: var(--ir-muted); font-size: .88rem; margin: .2rem 0 1.3rem; }
    .ir-profile-info { list-style: none; padding: 1.1rem 0 0; margin: 0 0 1.3rem; border-top: 1px dashed var(--ir-line); display: grid; gap: .65rem; text-align: left; font-size: .9rem; color: #334155; }
    .ir-profile-info li { display: flex; gap: .7rem; align-items: center; min-width: 0; }
    .ir-profile-info i { width: 32px; height: 32px; flex-shrink: 0; border-radius: 9px; display: grid; place-items: center; background: var(--ir-soft); color: var(--ir-blue); }
    .ir-profile-info a { color: #334155; text-decoration: none; overflow: hidden; text-overflow: ellipsis; }
    .ir-profile-info a:hover { color: var(--ir-sky); }

    .ir-mini-stat { display: grid; gap: .1rem; padding: 1.1rem 1.2rem; background: #fff; border: 1px solid var(--ir-line); border-radius: 16px; height: 100%; }
    .ir-mini-stat > span { width: 36px; height: 36px; border-radius: 10px; display: grid; place-items: center; margin-bottom: .5rem; }
    .ir-mini-stat strong { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.6rem; font-weight: 800; color: var(--ir-ink); line-height: 1.1; }
    .ir-mini-stat small { color: var(--ir-muted); }

    .ir-panel-title { padding: 1.2rem 1.4rem; border-bottom: 1px solid var(--ir-line); }
    .ir-panel-title h2 { font-size: 1.05rem; font-weight: 700; color: var(--ir-ink); margin: 0; }
    .ir-hrow { display: flex; align-items: center; gap: .9rem; padding: 1rem 1.4rem; border-bottom: 1px solid #f1f5f9; }
    .ir-hrow:last-child { border-bottom: 0; }
    .ir-hlogo { width: 42px; height: 42px; flex-shrink: 0; border-radius: 12px; display: grid; place-items: center; color: #fff; font-weight: 800; background: linear-gradient(135deg, var(--ir-sky), var(--ir-blue)); }
    .ir-hrow-main { flex-grow: 1; min-width: 0; display: grid; }
    .ir-hrow-main a, .ir-hrow-main > span { font-weight: 700; color: var(--ir-ink); text-decoration: none; }
    .ir-hrow-main a:hover { color: var(--ir-sky); }
    .ir-hrow-main small { color: var(--ir-muted); }
    .ir-btn-mini { padding: .45rem .85rem; border-radius: 10px; background: var(--ir-navy); color: #fff; font-weight: 600; font-size: .82rem; text-decoration: none; }
    .ir-btn-mini:hover { background: var(--ir-blue); color: #fff; }
    @media (max-width: 575.98px) { .ir-hrow { flex-wrap: wrap; } .ir-hrow-main { flex-basis: calc(100% - 42px - .9rem); } }
</style>
@endpush
