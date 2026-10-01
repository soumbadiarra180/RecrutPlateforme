@extends('layouts.app')

@section('title', 'Mes candidatures')

@php
    $statuts = [
        'recue' => ['Reçue', 'ir-st-recue'],
        'en_cours_examen' => ['En cours d\'examen', 'ir-st-en_cours_examen'],
        'entretien' => ['Entretien', 'ir-st-entretien'],
        'acceptee' => ['Acceptée', 'ir-st-acceptee'],
        'refusee' => ['Refusée', 'ir-st-refusee'],
    ];
    $onglets = [
        'toutes' => ['Toutes', 'bi-grid'],
        'en_cours' => ['En cours', 'bi-hourglass-split'],
        'entretien' => ['Entretiens', 'bi-calendar-check'],
        'acceptee' => ['Acceptées', 'bi-trophy'],
        'refusee' => ['Refusées', 'bi-x-circle'],
    ];
    // Étape atteinte dans le suivi : 0 reçue, 1 examen, 2 entretien, 3 décision
    $etape = ['recue' => 0, 'en_cours_examen' => 1, 'entretien' => 2, 'acceptee' => 3, 'refusee' => 3];
@endphp

@section('content')
    <div class="ir-page-head">
        <div>
            <span class="ir-kicker">Espace candidat</span>
            <h1>Mes candidatures</h1>
            <p>Suivez l'avancement de chaque candidature, de l'envoi à la décision du recruteur.</p>
        </div>
        <a href="{{ route('offres.index') }}" class="ir-submit"><i class="bi bi-search"></i>Trouver une offre</a>
    </div>

    @if ($prochainEntretien)
        <div class="ir-next fade-in-up">
            <div class="ir-next-date">
                <span>{{ $prochainEntretien->date_entretien->translatedFormat('M') }}</span>
                <strong>{{ $prochainEntretien->date_entretien->format('d') }}</strong>
            </div>
            <div class="ir-next-body">
                <span class="ir-next-kicker"><i class="bi bi-stars"></i> Prochain entretien</span>
                <strong>{{ $prochainEntretien->offre->titre ?? 'Offre supprimée' }}</strong>
                <span>{{ ucfirst($prochainEntretien->date_entretien->translatedFormat('l d F Y')) }} à {{ $prochainEntretien->date_entretien->format('H:i') }}
                    · {{ $prochainEntretien->date_entretien->diffForHumans() }}</span>
            </div>
            <i class="bi bi-calendar-heart ir-next-art" aria-hidden="true"></i>
        </div>
    @endif

    <nav class="ir-tabs-bar" aria-label="Filtrer par statut">
        @foreach ($onglets as $cle => [$libelle, $icone])
            <a href="{{ route('candidatures.mes', $cle === 'toutes' ? [] : ['statut' => $cle]) }}"
               class="ir-tab {{ $filtre === $cle ? 'active' : '' }}" @if ($filtre === $cle) aria-current="page" @endif>
                <i class="bi {{ $icone }}"></i>{{ $libelle }}<span class="ir-tab-count">{{ $nombres[$cle] }}</span>
            </a>
        @endforeach
    </nav>

    <div class="d-grid gap-3">
        @forelse ($candidatures as $candidature)
            @php
                [$statutLabel, $statutClass] = $statuts[$candidature->statut] ?? [$candidature->statut, 'ir-st-recue'];
                $niveau = $etape[$candidature->statut] ?? 0;
                $refusee = $candidature->statut === 'refusee';
                $offre = $candidature->offre;
            @endphp
            <article class="ir-app fade-in-up" style="transition-delay: {{ $loop->index * 0.04 }}s">
                <div class="ir-app-head">
                    <span class="ir-app-logo">{{ $offre ? strtoupper(mb_substr($offre->titre, 0, 1)) : '?' }}</span>
                    <div class="ir-app-title">
                        @if ($offre)
                            <a href="{{ route('offres.show', $offre) }}">{{ $offre->titre }}</a>
                            <small><i class="bi bi-geo-alt"></i> {{ $offre->lieu }} · {{ $offre->type_contrat }} · envoyée le {{ \Carbon\Carbon::parse($candidature->date_candidature)->format('d/m/Y') }}</small>
                        @else
                            <span>Offre supprimée</span>
                            <small>Envoyée le {{ \Carbon\Carbon::parse($candidature->date_candidature)->format('d/m/Y') }}</small>
                        @endif
                    </div>
                    <span class="ir-status {{ $statutClass }}">{{ $statutLabel }}</span>
                </div>

                <ol class="ir-track {{ $refusee ? 'is-refused' : '' }}" aria-label="Avancement : {{ $statutLabel }}">
                    @foreach (['Reçue', 'Examen', 'Entretien', $refusee ? 'Refusée' : ($candidature->statut === 'acceptee' ? 'Acceptée' : 'Décision')] as $i => $nom)
                        <li class="{{ $i < $niveau ? 'done' : '' }} {{ $i === $niveau ? 'current' : '' }}">
                            <span class="ir-track-dot">
                                @if ($i < $niveau || ($i === $niveau && $candidature->statut === 'acceptee'))<i class="bi bi-check-lg"></i>
                                @elseif ($i === $niveau && $refusee)<i class="bi bi-x-lg"></i>
                                @endif
                            </span>
                            <span class="ir-track-label">{{ $nom }}</span>
                        </li>
                    @endforeach
                </ol>

                @if ($candidature->date_entretien || $candidature->motif_decision || $candidature->cv_path)
                    <div class="ir-app-foot">
                        @if ($candidature->date_entretien && $candidature->statut === 'entretien')
                            <span class="ir-app-info is-amber"><i class="bi bi-calendar-event"></i>Entretien le {{ $candidature->date_entretien->format('d/m/Y à H:i') }}</span>
                        @endif
                        @if ($candidature->cv_path)
                            <a href="{{ asset('storage/' . $candidature->cv_path) }}" target="_blank" rel="noopener" class="ir-app-info"><i class="bi bi-file-earmark-pdf"></i>CV envoyé</a>
                        @endif
                        @if ($candidature->motif_decision)
                            <blockquote class="ir-app-quote"><i class="bi bi-chat-left-quote"></i><span><strong>Le recruteur :</strong> {{ $candidature->motif_decision }}</span></blockquote>
                        @endif
                    </div>
                @endif
            </article>
        @empty
            <div class="ir-panel ir-empty-state">
                <span class="ir-empty-icon"><i class="bi bi-send"></i></span>
                @if ($filtre === 'toutes')
                    <h2>Aucune candidature pour le moment</h2>
                    <p>Parcourez les offres et postulez en quelques clics avec votre CV.</p>
                    <a href="{{ route('offres.index') }}" class="ir-submit"><i class="bi bi-search"></i>Voir les offres</a>
                @else
                    <h2>Aucune candidature dans « {{ $onglets[$filtre][0] }} »</h2>
                    <p>Essayez un autre filtre pour retrouver vos candidatures.</p>
                    <a href="{{ route('candidatures.mes') }}" class="ir-cancel">Voir toutes mes candidatures</a>
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
    /* Prochain entretien */
    .ir-next {
        position: relative; overflow: hidden; display: flex; align-items: center; gap: 1.2rem;
        padding: 1.3rem 1.5rem; border-radius: 20px; margin-bottom: 1.6rem; color: #fff;
        background: radial-gradient(400px 200px at 100% 0%, rgba(245,158,11,.35), transparent 60%), linear-gradient(135deg, var(--ir-navy-2), var(--ir-navy));
    }
    .ir-next-date { width: 64px; flex-shrink: 0; border-radius: 14px; overflow: hidden; text-align: center; background: #fff; color: var(--ir-ink); }
    .ir-next-date span { display: block; background: var(--ir-amber); color: #fff; font-size: .72rem; font-weight: 700; text-transform: uppercase; padding: .2rem 0; }
    .ir-next-date strong { display: block; font-size: 1.6rem; font-weight: 800; padding: .15rem 0 .25rem; font-family: 'Plus Jakarta Sans', sans-serif; }
    .ir-next-body { display: grid; gap: .1rem; position: relative; z-index: 1; }
    .ir-next-kicker { font-size: .75rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: #fcd34d; }
    .ir-next-body strong { font-size: 1.1rem; }
    .ir-next-body > span:last-child { color: #b9c6e4; font-size: .9rem; }
    .ir-next-art { position: absolute; right: 1.5rem; font-size: 4.5rem; color: rgba(255,255,255,.07); }

    /* Carte candidature */
    .ir-app { background: #fff; border: 1px solid var(--ir-line); border-radius: 18px; padding: 1.3rem 1.4rem; display: grid; gap: 1.2rem; transition: border-color .2s ease, box-shadow .2s ease; }
    .ir-app:hover { border-color: #c7d6f5; box-shadow: 0 18px 36px -26px rgba(30,58,138,.45); }
    .ir-app-head { display: flex; align-items: center; gap: 1rem; }
    .ir-app-logo { width: 46px; height: 46px; flex-shrink: 0; border-radius: 12px; display: grid; place-items: center; color: #fff; font-weight: 800; background: linear-gradient(135deg, var(--ir-sky), var(--ir-blue)); font-family: 'Plus Jakarta Sans', sans-serif; }
    .ir-app-title { flex-grow: 1; min-width: 0; display: grid; }
    .ir-app-title a, .ir-app-title > span { font-weight: 700; font-size: 1.05rem; color: var(--ir-ink); text-decoration: none; }
    .ir-app-title a:hover { color: var(--ir-sky); }
    .ir-app-title small { color: var(--ir-muted); }

    /* Suivi en 4 étapes */
    .ir-track { list-style: none; margin: 0; padding: 0; display: grid; grid-template-columns: repeat(4, 1fr); }
    .ir-track li { position: relative; display: grid; justify-items: center; gap: .4rem; text-align: center; }
    .ir-track li::before { content: ''; position: absolute; top: 13px; left: -50%; width: 100%; height: 3px; background: var(--ir-line); z-index: 0; }
    .ir-track li:first-child::before { display: none; }
    .ir-track li.done::before, .ir-track li.current::before { background: var(--ir-sky); }
    .ir-track-dot { position: relative; z-index: 1; width: 28px; height: 28px; border-radius: 50%; display: grid; place-items: center; background: #fff; border: 3px solid var(--ir-line); color: #fff; font-size: .8rem; }
    .ir-track li.done .ir-track-dot { background: var(--ir-sky); border-color: var(--ir-sky); }
    .ir-track li.current .ir-track-dot { border-color: var(--ir-sky); box-shadow: 0 0 0 5px rgba(59,130,246,.15); }
    .ir-track li.current .ir-track-dot::after { content: ''; width: 9px; height: 9px; border-radius: 50%; background: var(--ir-sky); }
    .ir-track li.current .ir-track-dot:has(i)::after { display: none; }
    .ir-track li.current .ir-track-dot:has(i) { background: #16a34a; border-color: #16a34a; box-shadow: 0 0 0 5px rgba(22,163,74,.15); }
    .ir-track.is-refused li.current .ir-track-dot { background: #e11d48; border-color: #e11d48; box-shadow: 0 0 0 5px rgba(225,29,72,.15); }
    .ir-track.is-refused li.current::before { background: #fda4af; }
    .ir-track-label { font-size: .8rem; font-weight: 600; color: #94a3b8; }
    .ir-track li.done .ir-track-label, .ir-track li.current .ir-track-label { color: var(--ir-ink); }

    .ir-app-foot { display: flex; flex-wrap: wrap; gap: .6rem; padding-top: 1rem; border-top: 1px dashed var(--ir-line); }
    .ir-app-info { display: inline-flex; align-items: center; gap: .4rem; font-size: .84rem; font-weight: 600; padding: .4rem .75rem; border-radius: 10px; background: var(--ir-soft); color: #475569; text-decoration: none; }
    a.ir-app-info:hover { color: var(--ir-blue); background: #e8f0ff; }
    .ir-app-info.is-amber { background: #fff4dc; color: #b45309; }
    .ir-app-quote { flex-basis: 100%; display: flex; gap: .6rem; margin: 0; padding: .8rem 1rem; border-radius: 12px; background: #f8fafc; border-left: 3px solid var(--ir-sky); font-size: .9rem; color: #334155; }
    .ir-app-quote i { color: var(--ir-sky); }


    @media (max-width: 575.98px) {
        .ir-app-head { flex-wrap: wrap; }
        .ir-app-head .ir-status { margin-left: calc(46px + 1rem); }
        .ir-track-label { font-size: .7rem; }
        .ir-next-art { display: none; }
    }
</style>
@endpush
