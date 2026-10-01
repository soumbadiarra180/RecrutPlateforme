@extends('layouts.app')

@section('title', 'Candidatures')

@php
    $libelles = [
        'recue' => 'Reçues', 'en_cours_examen' => 'En examen', 'entretien' => 'Entretiens',
        'acceptee' => 'Acceptées', 'refusee' => 'Refusées',
    ];
    $statutLabel = [
        'recue' => 'Reçue', 'en_cours_examen' => 'En cours d\'examen', 'entretien' => 'Entretien',
        'acceptee' => 'Acceptée', 'refusee' => 'Refusée',
    ];
    $filtresActifs = $recherche !== '' || $idOffre;
    $params = fn ($extra = []) => array_filter(array_merge(['q' => $recherche ?: null, 'offre' => $idOffre], $extra));
@endphp

@section('content')
    <div class="ir-page-head">
        <div>
            <span class="ir-kicker">Espace recruteur</span>
            <h1>Candidatures</h1>
            <p>Examinez les profils, planifiez les entretiens et informez les candidats de votre décision.</p>
        </div>
    </div>

    <form method="GET" action="{{ route('candidatures.index') }}" class="ir-search" role="search">
        @if ($statut)<input type="hidden" name="statut" value="{{ $statut }}">@endif
        <div class="ir-control">
            <i class="bi bi-search"></i>
            <input type="search" name="q" class="ir-input" value="{{ $recherche }}" placeholder="Nom, email du candidat ou titre de l'offre" aria-label="Rechercher une candidature">
        </div>
        <select name="offre" class="ir-input no-icon" aria-label="Filtrer par offre">
            <option value="">Toutes les offres</option>
            @foreach ($offres as $o)
                <option value="{{ $o->id_offre }}" {{ (string) $idOffre === (string) $o->id_offre ? 'selected' : '' }}>{{ Str::limit($o->titre, 40) }}</option>
            @endforeach
        </select>
        <button type="submit" class="ir-submit"><i class="bi bi-funnel"></i>Filtrer</button>
        @if ($filtresActifs)
            <a href="{{ route('candidatures.index', $statut ? ['statut' => $statut] : []) }}" class="ir-cancel">Effacer</a>
        @endif
    </form>

    <nav class="ir-tabs-bar" aria-label="Filtrer par statut">
        <a href="{{ route('candidatures.index', $params()) }}" class="ir-tab {{ !$statut ? 'active' : '' }}">
            Toutes<span class="ir-tab-count">{{ $compteurs->sum() }}</span>
        </a>
        @foreach ($libelles as $cle => $libelle)
            <a href="{{ route('candidatures.index', $params(['statut' => $cle])) }}" class="ir-tab {{ $statut === $cle ? 'active' : '' }}">
                <span class="ir-dot-status ir-dot-{{ $cle }}"></span>{{ $libelle }}<span class="ir-tab-count">{{ $compteurs[$cle] ?? 0 }}</span>
            </a>
        @endforeach
    </nav>

    <div class="ir-panel overflow-hidden">
        @if ($candidatures->count())
            <div class="ir-thead" aria-hidden="true">
                <span>Candidat</span><span>Offre</span><span>Date</span><span>Statut</span><span></span>
            </div>
        @endif
        @forelse ($candidatures as $candidature)
            @php $c = $candidature->candidat; $o = $candidature->offre; @endphp
            <div class="ir-arow">
                <div class="ir-arow-who">
                    <span class="ir-aavatar">{{ strtoupper(mb_substr($c->nom, 0, 1) . mb_substr($c->prenom, 0, 1)) }}</span>
                    <div class="ir-arow-text">
                        <a href="{{ route('candidats.show', $c) }}">{{ $c->nom }} {{ $c->prenom }}</a>
                        <small>{{ $c->email }}</small>
                    </div>
                </div>
                <div class="ir-arow-text">
                    @if ($o)
                        <a href="{{ route('offres.show', $o) }}" class="is-offer">{{ $o->titre }}</a>
                        <small>{{ $o->type_contrat }} · {{ $o->lieu }}</small>
                    @else
                        <span class="text-muted">Offre supprimée</span>
                    @endif
                </div>
                <div class="ir-arow-text">
                    @if ($candidature->statut === 'entretien' && $candidature->date_entretien)
                        <span class="ir-arow-date is-amber"><i class="bi bi-calendar-event"></i>{{ $candidature->date_entretien->format('d/m · H:i') }}</span>
                        <small>Entretien</small>
                    @else
                        <span class="ir-arow-date">{{ \Carbon\Carbon::parse($candidature->date_candidature)->format('d/m/Y') }}</span>
                        <small>{{ \Carbon\Carbon::parse($candidature->date_candidature)->diffForHumans() }}</small>
                    @endif
                </div>
                <div><span class="ir-status ir-st-{{ $candidature->statut }}">{{ $statutLabel[$candidature->statut] ?? $candidature->statut }}</span></div>
                <div class="ir-arow-actions">
                    @if ($candidature->cv_path)
                        <a href="{{ asset('storage/' . $candidature->cv_path) }}" target="_blank" rel="noopener" class="ir-icon-action" title="Ouvrir le CV" aria-label="Ouvrir le CV"><i class="bi bi-file-earmark-pdf"></i></a>
                    @endif
                    <a href="{{ route('candidatures.edit', $candidature) }}" class="ir-btn-mini">Traiter</a>
                    <form action="{{ route('candidatures.destroy', $candidature) }}" method="POST" onsubmit="return confirm('Supprimer la candidature de {{ addslashes($c->nom . ' ' . $c->prenom) }} ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="ir-icon-action is-danger" title="Supprimer" aria-label="Supprimer la candidature"><i class="bi bi-trash"></i></button>
                    </form>
                </div>
            </div>
        @empty
            <div class="ir-empty-state">
                <span class="ir-empty-icon"><i class="bi bi-inbox"></i></span>
                @if ($filtresActifs || $statut)
                    <h2>Aucune candidature ne correspond</h2>
                    <p>Modifiez la recherche ou choisissez un autre statut.</p>
                    <a href="{{ route('candidatures.index') }}" class="ir-cancel">Voir toutes les candidatures</a>
                @else
                    <h2>Aucune candidature pour le moment</h2>
                    <p>Les candidatures apparaîtront ici dès que des candidats postuleront à vos offres.</p>
                @endif
            </div>
        @endforelse
    </div>

    @if ($candidatures->hasPages())
        <div class="mt-4 d-flex justify-content-center">{{ $candidatures->links() }}</div>
    @endif
@endsection

@push('styles')
<style>
    .ir-dot-recue { background: #94a3b8; }
    .ir-dot-en_cours_examen { background: #0ea5e9; }
    .ir-dot-entretien { background: #f59e0b; }
    .ir-dot-acceptee { background: #16a34a; }
    .ir-dot-refusee { background: #e11d48; }

    .ir-thead, .ir-arow { display: grid; grid-template-columns: minmax(0, 1.4fr) minmax(0, 1.3fr) minmax(0, .8fr) 9.5rem 9.5rem; gap: 1rem; align-items: center; padding: .9rem 1.4rem; }
    .ir-thead { padding-block: .7rem; background: #fafcff; border-bottom: 1px solid var(--ir-line); font-size: .72rem; font-weight: 700; letter-spacing: .06em; text-transform: uppercase; color: #94a3b8; }
    .ir-arow { border-bottom: 1px solid #f1f5f9; transition: background .2s ease; }
    .ir-arow:last-child { border-bottom: 0; }
    .ir-arow:hover { background: #fafcff; }
    .ir-arow-who { display: flex; align-items: center; gap: .8rem; min-width: 0; }
    .ir-aavatar { width: 40px; height: 40px; flex-shrink: 0; border-radius: 50%; display: grid; place-items: center; background: #e8f0ff; color: var(--ir-blue); font-weight: 700; font-size: .82rem; }
    .ir-arow-text { display: grid; min-width: 0; }
    .ir-arow-text a { font-weight: 700; color: var(--ir-ink); text-decoration: none; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .ir-arow-text a.is-offer { font-weight: 600; color: #334155; }
    .ir-arow-text a:hover { color: var(--ir-sky); }
    .ir-arow-text small { color: var(--ir-muted); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .ir-arow-date { font-weight: 600; color: var(--ir-ink); font-size: .9rem; font-variant-numeric: tabular-nums; display: inline-flex; align-items: center; gap: .35rem; }
    .ir-arow-date.is-amber { color: #b45309; }
    .ir-arow-actions { display: flex; gap: .35rem; justify-content: flex-end; }
    .ir-arow-actions form { margin: 0; }
    .ir-icon-action { width: 36px; height: 36px; border-radius: 10px; display: grid; place-items: center; border: 1px solid var(--ir-line); background: #fff; color: #475569; text-decoration: none; transition: all .2s ease; }
    .ir-icon-action:hover { border-color: #c7d6f5; background: var(--ir-soft); color: var(--ir-blue); }
    .ir-icon-action.is-danger:hover { border-color: #fecdd3; background: #fff1f3; color: #be123c; }
    .ir-btn-mini { display: inline-flex; align-items: center; padding: 0 .85rem; height: 36px; border-radius: 10px; background: var(--ir-navy); color: #fff; font-weight: 600; font-size: .82rem; text-decoration: none; }
    .ir-btn-mini:hover { background: var(--ir-blue); color: #fff; }

    @media (max-width: 991.98px) {
        .ir-thead { display: none; }
        .ir-arow { grid-template-columns: 1fr auto; gap: .6rem 1rem; }
        .ir-arow > :nth-child(2), .ir-arow > :nth-child(3) { grid-column: 1; padding-left: calc(40px + .8rem); }
        .ir-arow > :nth-child(4) { grid-column: 2; grid-row: 1; justify-self: end; }
        .ir-arow-actions { grid-column: 2; grid-row: 2 / span 2; align-self: end; }
    }
</style>
@endpush
