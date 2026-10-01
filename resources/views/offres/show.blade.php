@extends('layouts.app')

@section('title', $offre->titre)

@php
    $user = auth()->user();
    $publication = \Carbon\Carbon::parse($offre->date_publication)->startOfDay();
    $limite = \Carbon\Carbon::parse($offre->date_limite)->endOfDay();
    $estExpiree = $limite->isPast();
    $estOuverte = $offre->statut === 'ouverte' && !$estExpiree;
    $joursRestants = (int) now()->diffInDays($limite, false);
    // Part du délai de candidature déjà écoulée (barre de progression)
    $dureeTotale = max(1, $publication->diffInSeconds($limite));
    $ecoule = min(100, max(0, round($publication->diffInSeconds(now(), false) / $dureeTotale * 100)));

    $etat = $offre->statut === 'fermee' ? ['fermee', 'Fermée'] : ($estExpiree ? ['expiree', 'Date dépassée'] : ['ouverte', 'Ouverte aux candidatures']);
    $contratTint = ['CDI' => 'ir-tint-green', 'CDD' => 'ir-tint-blue', 'Stage' => 'ir-tint-amber', 'Freelance' => 'ir-tint-violet'];

    $statuts = [
        'recue' => 'Reçue', 'en_cours_examen' => 'En cours d\'examen', 'entretien' => 'Entretien',
        'acceptee' => 'Acceptée', 'refusee' => 'Refusée',
    ];

    // Transforme un texte saisi en liste (une ligne = un élément, puces retirées)
    $enListe = fn ($texte) => collect(preg_split('/\r\n|\r|\n|;/', trim((string) $texte)))
        ->map(fn ($l) => trim(preg_replace('/^[\s*•·-]+/u', '', $l)))
        ->filter()
        ->values();
    $missions = $enListe($offre->missions);
    $competences = $enListe($offre->competences);
    $profil = $enListe($offre->profil_recherche);
@endphp

@section('content')
    {{-- ================= EN-TÊTE ================= --}}
    <header class="ir-offer-hero fade-in-up">
        <a href="{{ route('offres.index') }}" class="ir-offer-back"><i class="bi bi-arrow-left"></i>Toutes les offres</a>
        <div class="ir-offer-hero-main">
            <span class="ir-offer-logo">{{ strtoupper(mb_substr($offre->titre, 0, 1)) }}</span>
            <div class="ir-offer-hero-text">
                <span class="ir-status ir-st-{{ $etat[0] }}"><span class="ir-dot-status" style="background:currentColor"></span>{{ $etat[1] }}</span>
                <h1>{{ $offre->titre }}</h1>
                <div class="ir-offer-facts">
                    <span><i class="bi bi-briefcase"></i>{{ $offre->type_contrat }}</span>
                    <span><i class="bi bi-geo-alt"></i>{{ $offre->lieu }}</span>
                    <span><i class="bi bi-clock-history"></i>Publiée {{ $publication->diffForHumans() }}</span>
                    @if ($user->isRecruteur())
                        <span><i class="bi bi-people"></i>{{ $offre->candidatures->count() }} {{ $offre->candidatures->count() > 1 ? 'candidatures' : 'candidature' }}</span>
                    @endif
                </div>
            </div>
        </div>
        <svg class="ir-offer-art" viewBox="0 0 200 200" aria-hidden="true">
            <g fill="none" stroke="rgba(255,255,255,.14)" stroke-width="1.5" stroke-dasharray="3 6">
                <circle cx="100" cy="100" r="60"/><circle cx="100" cy="100" r="92"/>
            </g>
            <g stroke="rgba(147,197,253,.35)" stroke-width="1.5"><path d="M100 100 L100 40 M100 100 L152 130 M100 100 L48 130"/></g>
            <circle cx="100" cy="40" r="7" fill="#22d3ee"/><circle cx="152" cy="130" r="6" fill="#f59e0b"/><circle cx="48" cy="130" r="6" fill="#a5b4fc"/>
            <circle cx="100" cy="100" r="16" fill="#3b82f6"/>
        </svg>
    </header>

    <div class="row g-4 align-items-start">
        {{-- ================= CONTENU ================= --}}
        <div class="col-lg-8 d-grid gap-4">
            <section class="ir-block fade-in-up">
                <h2><span class="ir-block-ico ir-tint-blue"><i class="bi bi-info-circle"></i></span>À propos du poste</h2>
                <p class="ir-prose">{{ $offre->description }}</p>
            </section>

            @if ($missions->isNotEmpty())
                <section class="ir-block fade-in-up">
                    <h2><span class="ir-block-ico ir-tint-cyan"><i class="bi bi-list-check"></i></span>Missions principales</h2>
                    <ul class="ir-checklist">
                        @foreach ($missions as $m)<li><i class="bi bi-check2"></i><span>{{ $m }}</span></li>@endforeach
                    </ul>
                </section>
            @endif

            @if ($competences->isNotEmpty())
                <section class="ir-block fade-in-up">
                    <h2><span class="ir-block-ico ir-tint-violet"><i class="bi bi-code-slash"></i></span>Compétences recherchées</h2>
                    <div class="ir-tags">
                        @foreach ($competences as $c)<span>{{ $c }}</span>@endforeach
                    </div>
                </section>
            @endif

            @if ($profil->isNotEmpty())
                <section class="ir-block fade-in-up">
                    <h2><span class="ir-block-ico ir-tint-amber"><i class="bi bi-person-check"></i></span>Profil recherché</h2>
                    <ul class="ir-checklist is-profile">
                        @foreach ($profil as $p)<li><i class="bi bi-dot"></i><span>{{ $p }}</span></li>@endforeach
                    </ul>
                </section>
            @endif

            {{-- Recruteur : candidatures reçues --}}
            @if ($user->isRecruteur())
                <section class="ir-block fade-in-up p-0 overflow-hidden">
                    <div class="ir-block-head">
                        <h2 class="mb-0"><span class="ir-block-ico ir-tint-green"><i class="bi bi-people"></i></span>Candidatures reçues</h2>
                        <span class="ir-tab-count">{{ $offre->candidatures->count() }}</span>
                    </div>
                    @forelse ($offre->candidatures as $candidature)
                        @php $c = $candidature->candidat; @endphp
                        <div class="ir-crow">
                            <span class="ir-cavatar">{{ strtoupper(mb_substr($c->nom, 0, 1) . mb_substr($c->prenom, 0, 1)) }}</span>
                            <div class="ir-crow-main">
                                <strong>{{ $c->nom }} {{ $c->prenom }}</strong>
                                <small>{{ $c->email }} · le {{ \Carbon\Carbon::parse($candidature->date_candidature)->format('d/m/Y') }}</small>
                            </div>
                            <span class="ir-status ir-st-{{ $candidature->statut }}">{{ $statuts[$candidature->statut] ?? $candidature->statut }}</span>
                            @if ($candidature->cv_path)
                                <a href="{{ asset('storage/' . $candidature->cv_path) }}" target="_blank" rel="noopener" class="ir-icon-action" title="Ouvrir le CV" aria-label="Ouvrir le CV"><i class="bi bi-file-earmark-pdf"></i></a>
                            @endif
                            <a href="{{ route('candidatures.edit', $candidature) }}" class="ir-btn-mini">Traiter</a>
                        </div>
                    @empty
                        <div class="ir-empty-state py-5">
                            <span class="ir-empty-icon"><i class="bi bi-inbox"></i></span>
                            <h2>Aucune candidature pour l'instant</h2>
                            <p>Les candidatures apparaîtront ici dès leur envoi.</p>
                        </div>
                    @endforelse
                </section>
            @endif
        </div>

        {{-- ================= BARRE LATÉRALE ================= --}}
        <div class="col-lg-4">
            <aside class="ir-side">
                @if ($user->isCandidat())
                    <div class="ir-side-card ir-apply">
                        @if ($maCandidature)
                            <span class="ir-apply-ico is-done"><i class="bi bi-check2-circle"></i></span>
                            <h3 class="ir-apply-title">Vous avez postulé</h3>
                            <p>Envoyée le {{ \Carbon\Carbon::parse($maCandidature->date_candidature)->format('d/m/Y') }}. Statut actuel :</p>
                            <span class="ir-status ir-st-{{ $maCandidature->statut }} mb-3">{{ $statuts[$maCandidature->statut] ?? $maCandidature->statut }}</span>
                            <a href="{{ route('candidatures.mes') }}" class="ir-submit w-full"><i class="bi bi-diagram-3"></i>Suivre ma candidature</a>
                        @elseif ($estOuverte)
                            <span class="ir-apply-ico"><i class="bi bi-send"></i></span>
                            <h3 class="ir-apply-title">Ce poste vous intéresse ?</h3>
                            <p>Envoyez votre CV en PDF, la lettre de motivation est facultative.</p>
                            <a href="{{ route('offres.postuler.form', $offre) }}" class="ir-submit w-full"><i class="bi bi-send"></i>Postuler maintenant</a>
                        @else
                            <span class="ir-apply-ico is-closed"><i class="bi bi-lock"></i></span>
                            <h3 class="ir-apply-title">Candidatures closes</h3>
                            <p>Cette offre n'accepte plus de candidatures.</p>
                            <a href="{{ route('offres.index') }}" class="ir-cancel w-100">Voir les offres ouvertes</a>
                        @endif
                    </div>
                @else
                    <div class="ir-side-card">
                        <h3>Gestion de l'offre</h3>
                        <div class="d-grid gap-2">
                            <a href="{{ route('offres.edit', $offre) }}" class="ir-submit w-full"><i class="bi bi-pencil"></i>Modifier l'offre</a>
                            <form action="{{ route('offres.destroy', $offre) }}" method="POST" onsubmit="return confirm('Supprimer cette offre et toutes ses candidatures ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="ir-danger-btn w-100"><i class="bi bi-trash"></i>Supprimer</button>
                            </form>
                        </div>
                        @if ($offre->candidatures->isNotEmpty())
                            <div class="ir-breakdown">
                                @foreach ($statuts as $cle => $libelle)
                                    @php $n = $offre->candidatures->where('statut', $cle)->count(); @endphp
                                    <div class="ir-breakdown-row">
                                        <span>{{ $libelle }}</span>
                                        <div class="ir-bar"><i class="ir-st-{{ $cle }}" style="width: {{ round($n / $offre->candidatures->count() * 100) }}%"></i></div>
                                        <strong>{{ $n }}</strong>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif

                <div class="ir-side-card">
                    <h3>Résumé</h3>
                    <dl class="ir-facts">
                        <div><dt><i class="bi bi-briefcase"></i>Contrat</dt><dd><span class="ir-chip {{ $contratTint[$offre->type_contrat] ?? 'ir-tint-blue' }}">{{ $offre->type_contrat }}</span></dd></div>
                        <div><dt><i class="bi bi-geo-alt"></i>Lieu</dt><dd>{{ $offre->lieu }}</dd></div>
                        <div><dt><i class="bi bi-calendar"></i>Publiée le</dt><dd>{{ $publication->format('d/m/Y') }}</dd></div>
                        <div><dt><i class="bi bi-calendar-x"></i>Date limite</dt><dd>{{ $limite->format('d/m/Y') }}</dd></div>
                    </dl>
                    @if ($estOuverte)
                        <div class="ir-deadline">
                            <div class="d-flex justify-content-between small mb-1">
                                <span class="text-muted">Délai de candidature</span>
                                <strong class="{{ $joursRestants <= 7 ? 'text-warning-emphasis' : '' }}">
                                    {{ $joursRestants < 1 ? 'Dernier jour' : 'Plus que ' . $joursRestants . ' ' . ($joursRestants > 1 ? 'jours' : 'jour') }}
                                </strong>
                            </div>
                            <div class="ir-bar"><i style="width: {{ $ecoule }}%; background: {{ $joursRestants <= 7 ? 'var(--ir-amber)' : 'var(--ir-sky)' }}"></i></div>
                        </div>
                    @endif
                    <button type="button" class="ir-share" id="irShare" data-url="{{ url()->current() }}">
                        <i class="bi bi-link-45deg"></i><span>Copier le lien de l'offre</span>
                    </button>
                </div>
            </aside>
        </div>
    </div>

    {{-- ================= OFFRES SIMILAIRES (candidat) ================= --}}
    @if ($similaires->isNotEmpty())
        <section class="mt-5">
            <div class="d-flex justify-content-between align-items-end mb-3">
                <h2 class="ir-similar-title">Offres similaires</h2>
                <a href="{{ route('offres.index') }}" class="ir-back">Toutes les offres <i class="bi bi-arrow-right"></i></a>
            </div>
            <div class="row g-3">
                @foreach ($similaires as $s)
                    <div class="col-md-4">
                        <a href="{{ route('offres.show', $s) }}" class="ir-similar">
                            <span class="ir-offer-logo is-small">{{ strtoupper(mb_substr($s->titre, 0, 1)) }}</span>
                            <span class="ir-similar-main">
                                <strong>{{ $s->titre }}</strong>
                                <small><i class="bi bi-geo-alt"></i> {{ $s->lieu }} · {{ $s->type_contrat }}</small>
                            </span>
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    </div>
                @endforeach
            </div>
        </section>
    @endif
@endsection

@push('styles')
<style>
    .ir-tint-blue { background: #e8f0ff; color: var(--ir-blue); }
    .ir-tint-cyan { background: #e0f9fd; color: #0e7490; }
    .ir-tint-amber { background: #fff4dc; color: #b45309; }
    .ir-tint-green { background: #e3f8ee; color: #15803d; }
    .ir-tint-violet { background: #efeaff; color: #6d28d9; }
    .ir-chip { display: inline-flex; font-size: .78rem; font-weight: 600; padding: .3rem .7rem; border-radius: 999px; }

    /* En-tête */
    .ir-offer-hero {
        position: relative; overflow: hidden; border-radius: 24px; padding: 1.6rem 2rem 2.2rem; margin-bottom: 1.8rem; color: #fff;
        background: radial-gradient(600px 300px at 100% 0%, rgba(59,130,246,.45), transparent 60%), linear-gradient(150deg, var(--ir-navy-2), var(--ir-navy));
    }
    .ir-offer-back { display: inline-flex; align-items: center; gap: .4rem; color: #a9b7d6; font-size: .88rem; font-weight: 600; text-decoration: none; margin-bottom: 1.4rem; }
    .ir-offer-back:hover { color: #fff; }
    .ir-offer-hero-main { display: flex; gap: 1.3rem; align-items: flex-start; position: relative; z-index: 1; max-width: 46rem; }
    .ir-offer-logo { width: 68px; height: 68px; flex-shrink: 0; border-radius: 18px; display: grid; place-items: center; font-size: 1.7rem; font-weight: 800; color: #fff; font-family: 'Plus Jakarta Sans', sans-serif; background: linear-gradient(135deg, var(--ir-sky), var(--ir-blue)); box-shadow: inset 0 0 0 1px rgba(255,255,255,.2), 0 12px 24px -10px rgba(0,0,0,.5); }
    .ir-offer-logo.is-small { width: 44px; height: 44px; font-size: 1rem; border-radius: 12px; box-shadow: none; }
    .ir-offer-hero h1 { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 800; font-size: clamp(1.6rem, 3.4vw, 2.4rem); letter-spacing: -.02em; margin: .6rem 0 .8rem; text-transform: none; }
    .ir-offer-hero .ir-status { background: rgba(255,255,255,.1); color: #fff; }
    .ir-offer-hero .ir-st-ouverte { color: #86efac; }
    .ir-offer-hero .ir-st-expiree { color: #fcd34d; }
    .ir-offer-hero .ir-st-fermee { color: #cbd5e1; }
    .ir-offer-facts { display: flex; flex-wrap: wrap; gap: .5rem; }
    .ir-offer-facts span { display: inline-flex; align-items: center; gap: .4rem; padding: .4rem .8rem; border-radius: 10px; background: rgba(255,255,255,.07); border: 1px solid rgba(255,255,255,.1); color: #dbe5fa; font-size: .86rem; }
    .ir-offer-art { position: absolute; right: -10px; bottom: -30px; width: 230px; opacity: .9; }
    @media (max-width: 767.98px) { .ir-offer-art { display: none; } .ir-offer-hero { padding: 1.4rem 1.3rem 1.6rem; } .ir-offer-hero-main { flex-direction: column; } }

    /* Blocs de contenu */
    .ir-block { background: #fff; border: 1px solid var(--ir-line); border-radius: 20px; padding: 1.6rem 1.7rem; }
    .ir-block h2 { display: flex; align-items: center; gap: .7rem; font-size: 1.08rem; font-weight: 700; color: var(--ir-ink); margin-bottom: 1.1rem; }
    .ir-block-ico { width: 36px; height: 36px; border-radius: 10px; display: grid; place-items: center; font-size: 1rem; }
    .ir-block-head { display: flex; justify-content: space-between; align-items: center; padding: 1.3rem 1.7rem; border-bottom: 1px solid var(--ir-line); }
    .ir-prose { color: #334155; line-height: 1.75; margin: 0; white-space: pre-line; max-width: 70ch; }
    .ir-checklist { list-style: none; padding: 0; margin: 0; display: grid; gap: .7rem; }
    .ir-checklist li { display: flex; gap: .75rem; align-items: flex-start; color: #334155; line-height: 1.55; }
    .ir-checklist li i { width: 24px; height: 24px; flex-shrink: 0; border-radius: 7px; display: grid; place-items: center; background: #e0f9fd; color: #0e7490; font-size: .95rem; margin-top: 1px; }
    .ir-checklist.is-profile li i { background: #fff4dc; color: #b45309; font-size: 1.4rem; }
    .ir-tags { display: flex; flex-wrap: wrap; gap: .5rem; }
    .ir-tags span { padding: .5rem .9rem; border-radius: 10px; background: var(--ir-soft); border: 1px solid #e0e9fb; color: var(--ir-blue); font-weight: 600; font-size: .88rem; }

    /* Candidatures (recruteur) */
    .ir-crow { display: flex; align-items: center; gap: .9rem; padding: 1rem 1.7rem; border-bottom: 1px solid #f1f5f9; }
    .ir-crow:last-child { border-bottom: 0; }
    .ir-cavatar { width: 42px; height: 42px; flex-shrink: 0; border-radius: 50%; display: grid; place-items: center; background: #e8f0ff; color: var(--ir-blue); font-weight: 700; font-size: .85rem; }
    .ir-crow-main { flex-grow: 1; min-width: 0; display: grid; }
    .ir-crow-main strong { color: var(--ir-ink); }
    .ir-crow-main small { color: var(--ir-muted); overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .ir-icon-action { width: 38px; height: 38px; border-radius: 10px; display: grid; place-items: center; border: 1px solid var(--ir-line); background: #fff; color: #be123c; text-decoration: none; }
    .ir-icon-action:hover { background: #fff1f3; border-color: #fecdd3; }
    .ir-btn-mini { padding: .5rem .9rem; border-radius: 10px; background: var(--ir-navy); color: #fff; font-weight: 600; font-size: .85rem; text-decoration: none; }
    .ir-btn-mini:hover { background: var(--ir-blue); color: #fff; }
    @media (max-width: 575.98px) { .ir-crow { flex-wrap: wrap; padding-inline: 1.2rem; } .ir-crow-main { flex-basis: calc(100% - 42px - .9rem); } }

    /* Barre latérale */
    .ir-apply { text-align: center; padding: 1.8rem 1.5rem; }
    .ir-apply p { color: var(--ir-muted); font-size: .9rem; margin: 0 0 1.1rem; }
    .ir-apply-ico { width: 58px; height: 58px; border-radius: 16px; display: inline-grid; place-items: center; font-size: 1.5rem; background: #e8f0ff; color: var(--ir-sky); margin-bottom: .9rem; }
    .ir-apply-ico.is-done { background: #e3f8ee; color: #15803d; }
    .ir-apply-ico.is-closed { background: #f1f5f9; color: #64748b; }
    .ir-apply .ir-apply-title { font-size: 1.15rem; font-weight: 700; color: var(--ir-ink); text-transform: none; letter-spacing: 0; margin: 0 0 .4rem; }
    .ir-danger-btn { display: inline-flex; align-items: center; justify-content: center; gap: .5rem; height: 46px; border-radius: 12px; border: 1.5px solid #fecdd3; background: #fff; color: #be123c; font-weight: 600; }
    .ir-danger-btn:hover { background: #fff1f3; }
    .ir-breakdown { display: grid; gap: .55rem; margin-top: 1.3rem; padding-top: 1.1rem; border-top: 1px dashed var(--ir-line); }
    .ir-breakdown-row { display: grid; grid-template-columns: 7.5rem 1fr 1.5rem; align-items: center; gap: .6rem; font-size: .82rem; color: #475569; }
    .ir-breakdown-row strong { text-align: right; color: var(--ir-ink); font-variant-numeric: tabular-nums; }
    .ir-bar { height: 7px; border-radius: 99px; background: #eef2f8; overflow: hidden; }
    .ir-bar i { display: block; height: 100%; border-radius: 99px; }
    .ir-breakdown .ir-bar i.ir-st-recue { background: #94a3b8; }
    .ir-breakdown .ir-bar i.ir-st-en_cours_examen { background: #0ea5e9; }
    .ir-breakdown .ir-bar i.ir-st-entretien { background: #f59e0b; }
    .ir-breakdown .ir-bar i.ir-st-acceptee { background: #16a34a; }
    .ir-breakdown .ir-bar i.ir-st-refusee { background: #e11d48; }
    .ir-facts { margin: 0; display: grid; gap: .75rem; }
    .ir-facts div { display: flex; justify-content: space-between; align-items: center; gap: 1rem; }
    .ir-facts dt { font-weight: 500; color: var(--ir-muted); font-size: .88rem; display: flex; align-items: center; gap: .5rem; }
    .ir-facts dd { margin: 0; font-weight: 600; color: var(--ir-ink); font-size: .9rem; text-align: right; }
    .ir-deadline { margin-top: 1.2rem; padding-top: 1rem; border-top: 1px dashed var(--ir-line); }
    .ir-share { margin-top: 1.1rem; width: 100%; display: flex; align-items: center; justify-content: center; gap: .5rem; height: 44px; border-radius: 12px; border: 1px dashed #c7d6f5; background: var(--ir-soft); color: var(--ir-blue); font-weight: 600; font-size: .9rem; transition: background .2s ease; }
    .ir-share:hover { background: #e8f0ff; }
    .ir-share.is-copied { border-style: solid; border-color: #86efac; background: #f0fdf4; color: #15803d; }

    /* Offres similaires */
    .ir-similar-title { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 800; font-size: 1.3rem; color: var(--ir-ink); margin: 0; }
    .ir-similar { display: flex; align-items: center; gap: .9rem; padding: 1rem 1.1rem; border-radius: 16px; background: #fff; border: 1px solid var(--ir-line); text-decoration: none; color: inherit; transition: border-color .2s ease, transform .2s ease; }
    .ir-similar:hover { border-color: #bfd3fb; transform: translateY(-3px); color: inherit; }
    .ir-similar-main { flex-grow: 1; min-width: 0; display: grid; }
    .ir-similar-main strong { color: var(--ir-ink); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .ir-similar-main small { color: var(--ir-muted); }
    .ir-similar > i { color: #94a3b8; }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('irShare');
    if (!btn) return;
    btn.addEventListener('click', async () => {
        const label = btn.querySelector('span');
        try {
            await navigator.clipboard.writeText(btn.dataset.url);
            btn.classList.add('is-copied');
            label.textContent = 'Lien copié';
            btn.querySelector('i').className = 'bi bi-check2';
        } catch (e) {
            label.textContent = btn.dataset.url;
        }
        setTimeout(() => {
            btn.classList.remove('is-copied');
            label.textContent = 'Copier le lien de l\'offre';
            btn.querySelector('i').className = 'bi bi-link-45deg';
        }, 2500);
    });
});
</script>
@endpush
