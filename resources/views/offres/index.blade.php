@extends('layouts.app')

@section('title', 'Offres d\'emploi')

@php
    $estRecruteur = auth()->user()->isRecruteur();
    $contratTint = ['CDI' => 'ir-tint-green', 'CDD' => 'ir-tint-blue', 'Stage' => 'ir-tint-amber', 'Freelance' => 'ir-tint-violet'];
    $filtresActifs = $recherche !== '' || $type;
@endphp

@section('content')
    <div class="ir-page-head">
        <div>
            <span class="ir-kicker">{{ $estRecruteur ? 'Espace recruteur' : 'Emplois tech au Mali' }}</span>
            <h1>{{ $estRecruteur ? 'Mes offres d\'emploi' : 'Trouvez votre prochain poste' }}</h1>
            <p>
                @if ($estRecruteur)
                    Gérez vos offres et suivez le nombre de candidatures reçues.
                @else
                    {{ $offres->total() }} {{ $offres->total() > 1 ? 'offres ouvertes' : 'offre ouverte' }} aux candidatures{{ $filtresActifs ? ' pour cette recherche' : '' }}.
                @endif
            </p>
        </div>
        @if ($estRecruteur)
            <a href="{{ route('offres.create') }}" class="ir-submit"><i class="bi bi-plus-lg"></i>Publier une offre</a>
        @endif
    </div>

    {{-- Recherche (envoyée au serveur, fonctionne sur toutes les pages) --}}
    <form method="GET" action="{{ route('offres.index') }}" class="ir-search" role="search">
        @if ($estRecruteur && $etat !== 'toutes')<input type="hidden" name="etat" value="{{ $etat }}">@endif
        <div class="ir-control">
            <i class="bi bi-search"></i>
            <input type="search" name="q" id="q" class="ir-input" value="{{ $recherche }}" placeholder="Poste, technologie ou ville (ex : Laravel, Bamako)" aria-label="Rechercher une offre">
        </div>
        <select name="type" id="type" class="ir-input no-icon" aria-label="Type de contrat">
            <option value="">Tous les contrats</option>
            @foreach (['CDI', 'CDD', 'Stage', 'Freelance'] as $t)
                <option value="{{ $t }}" {{ $type === $t ? 'selected' : '' }}>{{ $t }}</option>
            @endforeach
        </select>
        <button type="submit" class="ir-submit"><i class="bi bi-search"></i>Rechercher</button>
        @if ($filtresActifs)
            <a href="{{ route('offres.index', $estRecruteur && $etat !== 'toutes' ? ['etat' => $etat] : []) }}" class="ir-cancel">Effacer</a>
        @endif
    </form>

    @if ($estRecruteur)
        {{-- ================= VUE RECRUTEUR ================= --}}
        @php
            $onglets = ['toutes' => 'Toutes', 'ouvertes' => 'Ouvertes', 'expirees' => 'Date dépassée', 'fermees' => 'Fermées'];
        @endphp
        <nav class="ir-tabs-bar" aria-label="Filtrer par état">
            @foreach ($onglets as $cle => $libelle)
                <a href="{{ route('offres.index', array_filter(['etat' => $cle === 'toutes' ? null : $cle, 'q' => $recherche ?: null, 'type' => $type])) }}"
                   class="ir-tab {{ $etat === $cle ? 'active' : '' }}" @if ($etat === $cle) aria-current="page" @endif>
                    {{ $libelle }}<span class="ir-tab-count">{{ $compteurs[$cle] }}</span>
                </a>
            @endforeach
        </nav>

        <div class="ir-panel overflow-hidden">
            @forelse ($offres as $offre)
                @php
                    $limite = \Carbon\Carbon::parse($offre->date_limite);
                    $etatOffre = $offre->statut === 'fermee' ? 'fermee' : ($limite->isPast() && !$limite->isToday() ? 'expiree' : 'ouverte');
                    $etatLabel = ['ouverte' => 'Ouverte', 'expiree' => 'Date dépassée', 'fermee' => 'Fermée'][$etatOffre];
                @endphp
                <div class="ir-orow">
                    <span class="ir-olog">{{ strtoupper(mb_substr($offre->titre, 0, 1)) }}</span>
                    <div class="ir-orow-main">
                        <a href="{{ route('offres.show', $offre) }}" class="ir-orow-title">{{ $offre->titre }}</a>
                        <small><i class="bi bi-geo-alt"></i> {{ $offre->lieu }} · {{ $offre->type_contrat }} · publiée le {{ \Carbon\Carbon::parse($offre->date_publication)->format('d/m/Y') }}</small>
                    </div>
                    <div class="ir-orow-col">
                        <span class="ir-orow-label">Date limite</span>
                        <span class="{{ $etatOffre === 'expiree' ? 'text-danger' : '' }}">{{ $limite->format('d/m/Y') }}</span>
                    </div>
                    <div class="ir-orow-col">
                        <span class="ir-orow-label">Candidatures</span>
                        <span class="ir-count {{ $offre->candidatures_count ? 'has' : '' }}"><i class="bi bi-people"></i>{{ $offre->candidatures_count }}</span>
                    </div>
                    <span class="ir-status ir-st-{{ $etatOffre }}"><span class="ir-dot-status" style="background:currentColor"></span>{{ $etatLabel }}</span>
                    <div class="ir-orow-actions">
                        <a href="{{ route('offres.show', $offre) }}" class="ir-icon-action" title="Voir l'offre" aria-label="Voir l'offre"><i class="bi bi-eye"></i></a>
                        <a href="{{ route('offres.edit', $offre) }}" class="ir-icon-action" title="Modifier" aria-label="Modifier l'offre"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('offres.destroy', $offre) }}" method="POST"
                              onsubmit="return confirm('Supprimer l\'offre « {{ addslashes($offre->titre) }} » et ses candidatures ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="ir-icon-action is-danger" title="Supprimer" aria-label="Supprimer l'offre"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="ir-empty-state">
                    <span class="ir-empty-icon"><i class="bi bi-briefcase"></i></span>
                    @if ($filtresActifs || $etat !== 'toutes')
                        <h2>Aucune offre ne correspond</h2>
                        <p>Modifiez la recherche ou changez d'onglet.</p>
                        <a href="{{ route('offres.index') }}" class="ir-cancel">Voir toutes les offres</a>
                    @else
                        <h2>Vous n'avez publié aucune offre</h2>
                        <p>Publiez votre première offre : elle sera visible immédiatement par les candidats.</p>
                        <a href="{{ route('offres.create') }}" class="ir-submit"><i class="bi bi-plus-lg"></i>Publier une offre</a>
                    @endif
                </div>
            @endforelse
        </div>
    @else
        {{-- ================= VUE CANDIDAT ================= --}}
        <div class="ir-type-chips" aria-label="Filtrer par contrat">
            <a href="{{ route('offres.index', array_filter(['q' => $recherche ?: null])) }}" class="ir-tchip {{ !$type ? 'active' : '' }}">Tous <span>{{ $parType->sum() }}</span></a>
            @foreach (['CDI', 'CDD', 'Stage', 'Freelance'] as $t)
                <a href="{{ route('offres.index', array_filter(['q' => $recherche ?: null, 'type' => $t])) }}" class="ir-tchip {{ $type === $t ? 'active' : '' }}">{{ $t }} <span>{{ $parType[$t] ?? 0 }}</span></a>
            @endforeach
        </div>

        <div class="row g-4">
            @forelse ($offres as $offre)
                @php
                    $limite = \Carbon\Carbon::parse($offre->date_limite)->endOfDay();
                    $jours = (int) now()->diffInDays($limite, false);
                    $postule = in_array($offre->id_offre, $dejaPostule);
                    $competences = collect(preg_split('/[,;\n]+/', (string) $offre->competences))->map(fn ($c) => trim(preg_replace('/^[\s*•·-]+/u', '', $c)))->filter()->take(3);
                @endphp
                <div class="col-md-6 col-xl-4">
                    <a href="{{ route('offres.show', $offre) }}" class="ir-job fade-in-up" style="transition-delay: {{ ($loop->index % 3) * 0.06 }}s">
                        <div class="ir-job-top">
                            <span class="ir-olog">{{ strtoupper(mb_substr($offre->titre, 0, 1)) }}</span>
                            <span class="ir-chip {{ $contratTint[$offre->type_contrat] ?? 'ir-tint-blue' }}">{{ $offre->type_contrat }}</span>
                        </div>
                        <h3>{{ $offre->titre }}</h3>
                        <p>{{ Str::limit($offre->description, 110) }}</p>
                        @if ($competences->isNotEmpty())
                            <div class="ir-skills">
                                @foreach ($competences as $c)<span>{{ Str::limit($c, 22) }}</span>@endforeach
                            </div>
                        @endif
                        <div class="ir-job-meta">
                            <span><i class="bi bi-geo-alt"></i> {{ $offre->lieu }}</span>
                            <span class="{{ $jours <= 7 ? 'ir-urgent' : '' }}"><i class="bi bi-clock"></i>
                                {{ $jours < 1 ? 'Dernier jour' : ($jours <= 7 ? "Plus que {$jours} j" : 'Jusqu\'au ' . $limite->format('d/m')) }}
                            </span>
                            @if ($postule)
                                <span class="ir-applied"><i class="bi bi-check-circle-fill"></i> Déjà postulé</span>
                            @else
                                <span class="ir-job-cta">Voir l'offre <i class="bi bi-arrow-right"></i></span>
                            @endif
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12">
                    <div class="ir-panel ir-empty-state">
                        <span class="ir-empty-icon"><i class="bi bi-search"></i></span>
                        @if ($filtresActifs)
                            <h2>Aucune offre pour cette recherche</h2>
                            <p>Essayez un autre mot-clé, ou retirez le filtre de contrat.</p>
                            <a href="{{ route('offres.index') }}" class="ir-cancel">Voir toutes les offres</a>
                        @else
                            <h2>Aucune offre ouverte pour le moment</h2>
                            <p>De nouvelles offres sont publiées régulièrement, revenez bientôt.</p>
                        @endif
                    </div>
                </div>
            @endforelse
        </div>
    @endif

    @if ($offres->hasPages())
        <div class="mt-4 d-flex justify-content-center">{{ $offres->links() }}</div>
    @endif
@endsection

@push('styles')
<style>
    .ir-olog { width: 46px; height: 46px; flex-shrink: 0; border-radius: 12px; display: grid; place-items: center; color: #fff; font-weight: 800; background: linear-gradient(135deg, var(--ir-sky), var(--ir-blue)); font-family: 'Plus Jakarta Sans', sans-serif; }
    .ir-tint-blue { background: #e8f0ff; color: var(--ir-blue); }
    .ir-tint-amber { background: #fff4dc; color: #b45309; }
    .ir-tint-green { background: #e3f8ee; color: #15803d; }
    .ir-tint-violet { background: #efeaff; color: #6d28d9; }

    /* Recruteur : lignes d'offres */
    .ir-orow { display: flex; align-items: center; gap: 1.2rem; padding: 1.1rem 1.4rem; border-bottom: 1px solid #f1f5f9; transition: background .2s ease; }
    .ir-orow:last-child { border-bottom: 0; }
    .ir-orow:hover { background: #fafcff; }
    .ir-orow-main { flex-grow: 1; min-width: 0; display: grid; }
    .ir-orow-title { font-weight: 700; color: var(--ir-ink); text-decoration: none; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .ir-orow-title:hover { color: var(--ir-sky); }
    .ir-orow-main small { color: var(--ir-muted); }
    .ir-orow-col { display: grid; min-width: 104px; font-size: .9rem; color: var(--ir-ink); font-weight: 600; font-variant-numeric: tabular-nums; }
    .ir-orow-label { font-size: .72rem; font-weight: 600; letter-spacing: .05em; text-transform: uppercase; color: #94a3b8; }
    .ir-count { display: inline-flex; align-items: center; gap: .35rem; color: #94a3b8; }
    .ir-count.has { color: var(--ir-blue); }
    .ir-orow .ir-status { min-width: 128px; justify-content: center; }
    .ir-orow-actions { display: flex; gap: .35rem; }
    .ir-orow-actions form { margin: 0; }
    .ir-icon-action { width: 38px; height: 38px; border-radius: 10px; display: grid; place-items: center; border: 1px solid var(--ir-line); background: #fff; color: #475569; text-decoration: none; transition: all .2s ease; }
    .ir-icon-action:hover { border-color: #c7d6f5; background: var(--ir-soft); color: var(--ir-blue); }
    .ir-icon-action.is-danger:hover { border-color: #fecdd3; background: #fff1f3; color: #be123c; }
    @media (max-width: 991.98px) {
        .ir-orow { flex-wrap: wrap; }
        .ir-orow-main { flex-basis: calc(100% - 46px - 1.2rem); }
        .ir-orow-col { min-width: 0; }
        .ir-orow-actions { margin-left: auto; }
    }

    /* Candidat : pastilles de contrat */
    .ir-type-chips { display: flex; gap: .5rem; flex-wrap: wrap; margin-bottom: 1.4rem; }
    .ir-tchip { display: inline-flex; align-items: center; gap: .45rem; padding: .5rem .95rem; border-radius: 999px; border: 1px solid var(--ir-line); background: #fff; color: #475569; font-weight: 600; font-size: .88rem; text-decoration: none; transition: all .2s ease; }
    .ir-tchip span { font-size: .75rem; color: #94a3b8; }
    .ir-tchip:hover { border-color: #c7d6f5; color: var(--ir-blue); }
    .ir-tchip.active { background: var(--ir-navy); border-color: var(--ir-navy); color: #fff; }
    .ir-tchip.active span { color: var(--ir-cyan); }

    /* Candidat : cartes d'offres */
    .ir-job { display: flex; flex-direction: column; height: 100%; background: #fff; border: 1px solid var(--ir-line); border-radius: 18px; padding: 1.5rem; text-decoration: none; color: inherit; transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease; }
    .ir-job:hover { transform: translateY(-5px); border-color: #bfd3fb; box-shadow: 0 22px 40px -22px rgba(30,58,138,.35); color: inherit; }
    .ir-job-top { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.1rem; }
    .ir-chip { display: inline-flex; align-items: center; font-size: .78rem; font-weight: 600; padding: .3rem .7rem; border-radius: 999px; }
    .ir-job h3 { font-size: 1.1rem; font-weight: 700; color: var(--ir-ink); margin-bottom: .45rem; }
    .ir-job p { color: var(--ir-muted); font-size: .9rem; flex-grow: 1; margin-bottom: .9rem; }
    .ir-skills { display: flex; flex-wrap: wrap; gap: .35rem; margin-bottom: 1rem; }
    .ir-skills span { font-size: .76rem; font-weight: 600; padding: .25rem .6rem; border-radius: 7px; background: var(--ir-soft); color: var(--ir-blue); border: 1px solid #e3ebfb; }
    .ir-job-meta { display: flex; gap: .9rem; flex-wrap: wrap; align-items: center; font-size: .82rem; color: var(--ir-muted); padding-top: .9rem; border-top: 1px dashed var(--ir-line); }
    .ir-urgent { color: #b45309; font-weight: 600; }
    .ir-job-cta { margin-left: auto; color: var(--ir-sky); font-weight: 600; transition: transform .2s ease; }
    .ir-job:hover .ir-job-cta { transform: translateX(4px); }
    .ir-applied { margin-left: auto; color: #15803d; font-weight: 600; }
</style>
@endpush
