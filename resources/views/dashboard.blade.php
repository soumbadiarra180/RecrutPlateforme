@extends('layouts.app')

@section('title', 'Tableau de bord')

@php
    $statuts = [
        'recue' => ['Reçue', '#94a3b8'],
        'en_cours_examen' => ['En cours d\'examen', '#0ea5e9'],
        'entretien' => ['Entretien', '#f59e0b'],
        'acceptee' => ['Acceptée', '#16a34a'],
        'refusee' => ['Refusée', '#e11d48'],
    ];
    $variation = $cetteSemaine - $semainePrecedente;
    $maxTop = max(1, $topOffres->max('candidatures_count'));
@endphp

@section('content')
    <div class="ir-page-head">
        <div>
            <span class="ir-kicker">Espace recruteur</span>
            <h1>Tableau de bord</h1>
            <p>{{ ucfirst(now()->translatedFormat('l d F Y')) }} · l'essentiel de votre recrutement en un coup d'œil.</p>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('candidatures.index', ['statut' => 'recue']) }}" class="ir-cancel"><i class="bi bi-inbox me-2"></i>Candidatures reçues</a>
            <a href="{{ route('offres.create') }}" class="ir-submit"><i class="bi bi-plus-lg"></i>Publier une offre</a>
        </div>
    </div>

    {{-- ================= INDICATEURS ================= --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-xl-3">
            <a href="{{ route('candidatures.index') }}" class="ir-stat-card">
                <span class="ir-stat-ico ir-tint-blue"><i class="bi bi-file-earmark-text"></i></span>
                <span class="ir-stat-label">Candidatures</span>
                <strong>{{ $totalCandidatures }}</strong>
                <span class="ir-trend {{ $variation > 0 ? 'is-up' : ($variation < 0 ? 'is-down' : '') }}">
                    <i class="bi {{ $variation > 0 ? 'bi-arrow-up-right' : ($variation < 0 ? 'bi-arrow-down-right' : 'bi-dash') }}"></i>
                    {{ $cetteSemaine }} cette semaine
                </span>
            </a>
        </div>
        <div class="col-6 col-xl-3">
            <a href="{{ route('candidatures.index', ['statut' => 'recue']) }}" class="ir-stat-card {{ $aTraiterTotal ? 'is-alert' : '' }}">
                <span class="ir-stat-ico ir-tint-amber"><i class="bi bi-hourglass-split"></i></span>
                <span class="ir-stat-label">À traiter</span>
                <strong>{{ $aTraiterTotal }}</strong>
                <span class="ir-trend">{{ $aTraiterTotal ? 'reçues ou en examen' : 'tout est traité' }}</span>
            </a>
        </div>
        <div class="col-6 col-xl-3">
            <a href="{{ route('offres.index', ['etat' => 'ouvertes']) }}" class="ir-stat-card">
                <span class="ir-stat-ico ir-tint-green"><i class="bi bi-briefcase"></i></span>
                <span class="ir-stat-label">Offres ouvertes</span>
                <strong>{{ $offresOuvertes }}</strong>
                <span class="ir-trend">{{ $offresBientotClotures->count() }} se terminent sous 7 jours</span>
            </a>
        </div>
        <div class="col-6 col-xl-3">
            <a href="{{ route('candidats.index') }}" class="ir-stat-card">
                <span class="ir-stat-ico ir-tint-violet"><i class="bi bi-percent"></i></span>
                <span class="ir-stat-label">Taux d'acceptation</span>
                <strong>{{ $tauxAcceptation !== null ? $tauxAcceptation . ' %' : '—' }}</strong>
                <span class="ir-trend">{{ $totalCandidats }} candidats inscrits</span>
            </a>
        </div>
    </div>

    <div class="row g-4">
        {{-- ================= ÉVOLUTION ================= --}}
        <div class="col-xl-8">
            <section class="ir-card h-100">
                <div class="ir-card-head">
                    <div>
                        <h2>Candidatures reçues</h2>
                        <p>Par jour, sur les 30 derniers jours</p>
                    </div>
                    <div class="ir-card-figure">
                        <strong>{{ $serie->sum('total') }}</strong>
                        <span>sur 30 jours</span>
                    </div>
                </div>
                <div class="ir-chart-wrap">
                    <canvas id="chartJours" aria-label="Candidatures reçues par jour sur les 30 derniers jours" role="img"></canvas>
                </div>
                <details class="ir-table-toggle">
                    <summary>Voir les données en tableau</summary>
                    <div class="ir-table-scroll">
                        <table>
                            <thead><tr><th>Jour</th><th>Candidatures</th></tr></thead>
                            <tbody>
                                @foreach ($serie->where('total', '>', 0) as $j)
                                    <tr><td>{{ \Carbon\Carbon::parse($j['date'])->format('d/m/Y') }}</td><td>{{ $j['total'] }}</td></tr>
                                @endforeach
                                @if ($serie->sum('total') === 0)<tr><td colspan="2">Aucune candidature sur la période.</td></tr>@endif
                            </tbody>
                        </table>
                    </div>
                </details>
            </section>
        </div>

        {{-- ================= RÉPARTITION PAR STATUT ================= --}}
        <div class="col-xl-4">
            <section class="ir-card h-100">
                <div class="ir-card-head">
                    <div>
                        <h2>Par statut</h2>
                        <p>Toutes les candidatures</p>
                    </div>
                </div>
                <div class="ir-stack" role="img" aria-label="Répartition des candidatures par statut">
                    @foreach ($statuts as $cle => [$libelle, $couleur])
                        @if ($candidaturesParStatut[$cle] > 0)
                            <span style="flex: {{ $candidaturesParStatut[$cle] }}; background: {{ $couleur }}" title="{{ $libelle }} : {{ $candidaturesParStatut[$cle] }}"></span>
                        @endif
                    @endforeach
                    @if ($totalCandidatures === 0)<span style="flex:1;background:#eef2f8"></span>@endif
                </div>
                <ul class="ir-legend">
                    @foreach ($statuts as $cle => [$libelle, $couleur])
                        @php $n = $candidaturesParStatut[$cle]; @endphp
                        <li>
                            <a href="{{ route('candidatures.index', ['statut' => $cle]) }}">
                                <i style="background: {{ $couleur }}"></i>
                                <span>{{ $libelle }}</span>
                                <strong>{{ $n }}</strong>
                                <em>{{ $totalCandidatures ? round($n / $totalCandidatures * 100) : 0 }} %</em>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </section>
        </div>

        {{-- ================= À TRAITER ================= --}}
        <div class="col-lg-6">
            <section class="ir-card h-100 p-0 overflow-hidden">
                <div class="ir-card-head px-4 pt-4">
                    <div>
                        <h2>À traiter en priorité</h2>
                        <p>Les plus anciennes en attente d'abord</p>
                    </div>
                    <a href="{{ route('candidatures.index', ['statut' => 'recue']) }}" class="ir-link-more">Tout voir <i class="bi bi-arrow-right"></i></a>
                </div>
                @forelse ($aTraiter as $c)
                    <div class="ir-drow">
                        <span class="ir-davatar">{{ strtoupper(mb_substr($c->candidat->nom, 0, 1) . mb_substr($c->candidat->prenom, 0, 1)) }}</span>
                        <div class="ir-drow-main">
                            <strong>{{ $c->candidat->nom }} {{ $c->candidat->prenom }}</strong>
                            <small>{{ $c->offre->titre ?? 'Offre supprimée' }} · {{ \Carbon\Carbon::parse($c->date_candidature)->diffForHumans() }}</small>
                        </div>
                        <span class="ir-status ir-st-{{ $c->statut }}">{{ $statuts[$c->statut][0] }}</span>
                        <a href="{{ route('candidatures.edit', $c) }}" class="ir-btn-mini">Traiter</a>
                    </div>
                @empty
                    <div class="ir-empty-state py-4">
                        <span class="ir-empty-icon"><i class="bi bi-check2-all"></i></span>
                        <h2>Tout est à jour</h2>
                        <p>Aucune candidature en attente de traitement.</p>
                    </div>
                @endforelse
            </section>
        </div>

        {{-- ================= PROCHAINS ENTRETIENS ================= --}}
        <div class="col-lg-6">
            <section class="ir-card h-100 p-0 overflow-hidden">
                <div class="ir-card-head px-4 pt-4">
                    <div>
                        <h2>Prochains entretiens</h2>
                        <p>Planifiés à partir d'aujourd'hui</p>
                    </div>
                    <a href="{{ route('candidatures.index', ['statut' => 'entretien']) }}" class="ir-link-more">Tout voir <i class="bi bi-arrow-right"></i></a>
                </div>
                @forelse ($prochainsEntretiens as $c)
                    <div class="ir-drow">
                        <span class="ir-cal"><em>{{ $c->date_entretien->translatedFormat('M') }}</em><b>{{ $c->date_entretien->format('d') }}</b></span>
                        <div class="ir-drow-main">
                            <strong>{{ $c->candidat->nom }} {{ $c->candidat->prenom }}</strong>
                            <small>{{ $c->offre->titre ?? 'Offre supprimée' }}</small>
                        </div>
                        <span class="ir-time"><i class="bi bi-clock"></i>{{ $c->date_entretien->format('H:i') }}</span>
                    </div>
                @empty
                    <div class="ir-empty-state py-4">
                        <span class="ir-empty-icon"><i class="bi bi-calendar"></i></span>
                        <h2>Aucun entretien planifié</h2>
                        <p>Passez une candidature au statut « Entretien » pour en planifier un.</p>
                    </div>
                @endforelse
            </section>
        </div>

        {{-- ================= OFFRES LES PLUS DEMANDÉES ================= --}}
        <div class="col-lg-7">
            <section class="ir-card h-100">
                <div class="ir-card-head">
                    <div>
                        <h2>Offres les plus demandées</h2>
                        <p>Nombre de candidatures par offre</p>
                    </div>
                </div>
                <div class="ir-hbars">
                    @forelse ($topOffres as $o)
                        <a href="{{ route('offres.show', $o) }}" class="ir-hbar" title="{{ $o->titre }} : {{ $o->candidatures_count }} candidature(s)">
                            <span class="ir-hbar-label">{{ $o->titre }}</span>
                            <span class="ir-hbar-track"><i style="width: {{ $o->candidatures_count ? max(3, round($o->candidatures_count / $maxTop * 100)) : 0 }}%"></i></span>
                            <strong>{{ $o->candidatures_count }}</strong>
                        </a>
                    @empty
                        <p class="text-muted mb-0">Aucune offre publiée.</p>
                    @endforelse
                </div>
            </section>
        </div>

        {{-- ================= CLÔTURES PROCHES ================= --}}
        <div class="col-lg-5">
            <section class="ir-card h-100">
                <div class="ir-card-head">
                    <div>
                        <h2>Clôtures dans 7 jours</h2>
                        <p>Pensez à prolonger si besoin</p>
                    </div>
                </div>
                <div class="d-grid gap-2">
                    @forelse ($offresBientotClotures as $o)
                        @php $j = (int) now()->diffInDays(\Carbon\Carbon::parse($o->date_limite)->endOfDay(), false); @endphp
                        <a href="{{ route('offres.edit', $o) }}" class="ir-close-row">
                            <span class="ir-days {{ $j <= 2 ? 'is-hot' : '' }}">{{ $j < 1 ? 'Auj.' : 'J-' . $j }}</span>
                            <span class="ir-drow-main">
                                <strong>{{ $o->titre }}</strong>
                                <small>Jusqu'au {{ \Carbon\Carbon::parse($o->date_limite)->format('d/m/Y') }}</small>
                            </span>
                            <i class="bi bi-pencil"></i>
                        </a>
                    @empty
                        <div class="ir-empty-state py-3">
                            <span class="ir-empty-icon"><i class="bi bi-calendar-check"></i></span>
                            <p>Aucune offre ne se termine cette semaine.</p>
                        </div>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .ir-tint-blue { background: #e8f0ff; color: var(--ir-blue); }
    .ir-tint-amber { background: #fff4dc; color: #b45309; }
    .ir-tint-green { background: #e3f8ee; color: #15803d; }
    .ir-tint-violet { background: #efeaff; color: #6d28d9; }

    .ir-stat-card { display: grid; gap: .15rem; height: 100%; padding: 1.3rem 1.4rem; background: #fff; border: 1px solid var(--ir-line); border-radius: 18px; text-decoration: none; color: inherit; transition: border-color .2s ease, transform .2s ease; }
    .ir-stat-card:hover { border-color: #c7d6f5; transform: translateY(-3px); color: inherit; }
    .ir-stat-card.is-alert { border-color: #fcd9a0; background: linear-gradient(180deg, #fffaf0, #fff 60%); }
    .ir-stat-ico { width: 42px; height: 42px; border-radius: 12px; display: grid; place-items: center; font-size: 1.15rem; margin-bottom: .7rem; }
    .ir-stat-label { font-size: .85rem; color: var(--ir-muted); font-weight: 500; }
    .ir-stat-card strong { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 2rem; font-weight: 800; color: var(--ir-ink); line-height: 1.1; font-variant-numeric: tabular-nums; }
    .ir-trend { display: inline-flex; align-items: center; gap: .3rem; font-size: .8rem; color: var(--ir-muted); margin-top: .2rem; }
    .ir-trend.is-up { color: #15803d; }
    .ir-trend.is-down { color: #be123c; }

    .ir-card { background: #fff; border: 1px solid var(--ir-line); border-radius: 20px; padding: 1.5rem; }
    .ir-card-head { display: flex; justify-content: space-between; align-items: flex-start; gap: 1rem; margin-bottom: 1.2rem; }
    .ir-card-head h2 { font-size: 1.05rem; font-weight: 700; color: var(--ir-ink); margin: 0; }
    .ir-card-head p { font-size: .84rem; color: var(--ir-muted); margin: .15rem 0 0; }
    .ir-card-figure { text-align: right; }
    .ir-card-figure strong { display: block; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.6rem; font-weight: 800; color: var(--ir-ink); line-height: 1; font-variant-numeric: tabular-nums; }
    .ir-card-figure span { font-size: .78rem; color: var(--ir-muted); }
    .ir-link-more { font-size: .86rem; font-weight: 600; text-decoration: none; white-space: nowrap; }
    .ir-chart-wrap { position: relative; height: 260px; }
    .ir-table-toggle { margin-top: 1rem; font-size: .85rem; }
    .ir-table-toggle summary { cursor: pointer; color: var(--ir-muted); font-weight: 600; }
    .ir-table-scroll { max-height: 200px; overflow: auto; margin-top: .6rem; }
    .ir-table-toggle table { width: 100%; font-variant-numeric: tabular-nums; }
    .ir-table-toggle th, .ir-table-toggle td { padding: .35rem .5rem; border-bottom: 1px solid #f1f5f9; }
    .ir-table-toggle th { color: var(--ir-muted); font-weight: 600; }

    /* Barre empilée + légende */
    .ir-stack { display: flex; gap: 2px; height: 14px; border-radius: 7px; overflow: hidden; margin-bottom: 1.3rem; }
    .ir-stack span { min-width: 4px; }
    .ir-legend { list-style: none; padding: 0; margin: 0; display: grid; gap: .25rem; }
    .ir-legend a { display: grid; grid-template-columns: 12px 1fr auto 3rem; align-items: center; gap: .7rem; padding: .55rem .6rem; border-radius: 10px; text-decoration: none; color: #334155; font-size: .9rem; }
    .ir-legend a:hover { background: var(--ir-soft); }
    .ir-legend i { width: 12px; height: 12px; border-radius: 4px; }
    .ir-legend strong { color: var(--ir-ink); font-variant-numeric: tabular-nums; }
    .ir-legend em { font-style: normal; color: var(--ir-muted); font-size: .8rem; text-align: right; font-variant-numeric: tabular-nums; }

    /* Listes */
    .ir-drow { display: flex; align-items: center; gap: .9rem; padding: .85rem 1.5rem; border-top: 1px solid #f1f5f9; }
    .ir-davatar { width: 40px; height: 40px; flex-shrink: 0; border-radius: 50%; display: grid; place-items: center; background: #e8f0ff; color: var(--ir-blue); font-weight: 700; font-size: .82rem; }
    .ir-drow-main { flex-grow: 1; min-width: 0; display: grid; }
    .ir-drow-main strong { color: var(--ir-ink); font-size: .93rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .ir-drow-main small { color: var(--ir-muted); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .ir-btn-mini { padding: .45rem .85rem; border-radius: 10px; background: var(--ir-navy); color: #fff; font-weight: 600; font-size: .82rem; text-decoration: none; }
    .ir-btn-mini:hover { background: var(--ir-blue); color: #fff; }
    .ir-cal { width: 44px; flex-shrink: 0; border-radius: 10px; overflow: hidden; text-align: center; border: 1px solid var(--ir-line); }
    .ir-cal em { display: block; font-style: normal; font-size: .64rem; font-weight: 700; text-transform: uppercase; background: var(--ir-amber); color: #fff; padding: .1rem 0; }
    .ir-cal b { display: block; font-size: 1.05rem; color: var(--ir-ink); padding: .1rem 0; }
    .ir-time { display: inline-flex; align-items: center; gap: .35rem; font-weight: 600; font-size: .86rem; color: #b45309; background: #fff4dc; padding: .35rem .7rem; border-radius: 9px; }

    /* Barres horizontales */
    .ir-hbars { display: grid; gap: .5rem; }
    .ir-hbar { display: grid; grid-template-columns: minmax(0, 13rem) 1fr 2rem; align-items: center; gap: .9rem; padding: .45rem .5rem; border-radius: 10px; text-decoration: none; color: #334155; }
    .ir-hbar:hover { background: var(--ir-soft); }
    .ir-hbar-label { font-size: .88rem; font-weight: 500; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .ir-hbar-track { height: 10px; border-radius: 0 4px 4px 0; background: #f1f5f9; overflow: hidden; }
    .ir-hbar-track i { display: block; height: 100%; background: var(--ir-sky); border-radius: 0 4px 4px 0; transition: width .6s cubic-bezier(.2,.8,.2,1); }
    .ir-hbar strong { text-align: right; color: var(--ir-ink); font-variant-numeric: tabular-nums; }
    @media (max-width: 575.98px) { .ir-hbar { grid-template-columns: 1fr 2rem; } .ir-hbar-track { grid-column: 1 / -1; grid-row: 2; } }

    .ir-close-row { display: flex; align-items: center; gap: .9rem; padding: .7rem .8rem; border-radius: 12px; border: 1px solid var(--ir-line); text-decoration: none; color: inherit; }
    .ir-close-row:hover { border-color: #c7d6f5; background: var(--ir-soft); color: inherit; }
    .ir-close-row > i { color: #94a3b8; }
    .ir-days { min-width: 52px; text-align: center; font-weight: 700; font-size: .85rem; padding: .4rem .5rem; border-radius: 9px; background: #fff4dc; color: #b45309; }
    .ir-days.is-hot { background: #ffe8ee; color: #be123c; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const serie = @json($serie);
    const canvas = document.getElementById('chartJours');
    if (!canvas || typeof Chart === 'undefined') return;

    const ctx = canvas.getContext('2d');
    const fill = ctx.createLinearGradient(0, 0, 0, 260);
    fill.addColorStop(0, 'rgba(59,130,246,.22)');
    fill.addColorStop(1, 'rgba(59,130,246,0)');

    const max = Math.max(...serie.map(d => d.total));
    new Chart(canvas, {
        type: 'line',
        data: {
            labels: serie.map(d => d.label),
            datasets: [{
                data: serie.map(d => d.total),
                borderColor: '#3b82f6',
                borderWidth: 2,
                backgroundColor: fill,
                fill: true,
                tension: .35,
                pointRadius: 0,
                pointHoverRadius: 5,
                pointHoverBackgroundColor: '#3b82f6',
                pointHoverBorderColor: '#fff',
                pointHoverBorderWidth: 2,
            }]
        },
        options: {
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            animation: window.matchMedia('(prefers-reduced-motion: reduce)').matches ? false : { duration: 700 },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#0b1533', padding: 10, cornerRadius: 10, displayColors: false,
                    titleFont: { family: 'Inter', weight: '600' }, bodyFont: { family: 'Inter' },
                    callbacks: { label: c => c.parsed.y + (c.parsed.y > 1 ? ' candidatures' : ' candidature') }
                }
            },
            scales: {
                x: { grid: { display: false }, border: { display: false }, ticks: { color: '#94a3b8', font: { family: 'Inter', size: 11 }, maxTicksLimit: 8, maxRotation: 0 } },
                y: { beginAtZero: true, suggestedMax: Math.max(4, max + 1), grid: { color: '#f1f5f9' }, border: { display: false }, ticks: { color: '#94a3b8', font: { family: 'Inter', size: 11 }, precision: 0, maxTicksLimit: 5 } }
            }
        },
        plugins: [{
            // Ligne verticale de repère sous le curseur
            id: 'crosshair',
            afterDraw(chart) {
                const active = chart.tooltip?.getActiveElements?.();
                if (!active || !active.length) return;
                const x = active[0].element.x, { top, bottom } = chart.chartArea, c = chart.ctx;
                c.save(); c.strokeStyle = 'rgba(15,23,42,.18)'; c.lineWidth = 1; c.setLineDash([4, 4]);
                c.beginPath(); c.moveTo(x, top); c.lineTo(x, bottom); c.stroke(); c.restore();
            }
        }]
    });
});
</script>
@endpush
