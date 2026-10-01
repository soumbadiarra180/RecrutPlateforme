@extends('layouts.app')

@section('title', 'Notifications')

@php
    // Type de notification déduit du statut annoncé dans le message
    $types = [
        'Acceptée' => ['bi-trophy-fill', 'is-green', 'Acceptée'],
        'Refusée' => ['bi-x-circle-fill', 'is-rose', 'Refusée'],
        'Entretien' => ['bi-calendar-check-fill', 'is-amber', 'Entretien'],
        'En cours d\'examen' => ['bi-search', 'is-sky', 'En examen'],
        'Reçue' => ['bi-inbox-fill', 'is-slate', 'Reçue'],
    ];
    $typeDe = function ($notification) use ($types) {
        foreach ($types as $mot => $type) {
            if (str_contains($notification->message, ': ' . $mot)) return $type;
        }
        return ['bi-bell-fill', 'is-sky', null];
    };
    // Regroupement par période
    $groupeDe = function ($date) {
        if ($date->isToday()) return 'Aujourd\'hui';
        if ($date->isYesterday()) return 'Hier';
        if ($date->greaterThan(now()->subDays(7))) return 'Cette semaine';
        return 'Plus ancien';
    };
    $groupes = $notifications->getCollection()->groupBy(fn ($n) => $groupeDe($n->created_at));
    $nouvelles = $notifications->getCollection()->where('lu', false)->count();
@endphp

@section('content')
    <div class="ir-page-head">
        <div>
            <span class="ir-kicker">Espace candidat</span>
            <h1>Notifications</h1>
            <p>
                @if ($nouvelles > 0)
                    <strong style="color:var(--ir-blue)">{{ $nouvelles }} {{ $nouvelles > 1 ? 'nouvelles notifications' : 'nouvelle notification' }}</strong> depuis votre dernière visite.
                @else
                    Vous êtes à jour. Chaque décision d'un recruteur apparaît ici.
                @endif
            </p>
        </div>
        <a href="{{ route('candidatures.mes') }}" class="ir-cancel"><i class="bi bi-send me-2"></i>Mes candidatures</a>
    </div>

    <div class="row justify-content-center">
        <div class="col-xl-9">
            @forelse ($groupes as $periode => $liste)
                <section class="ir-ngroup">
                    <h2 class="ir-ngroup-title">{{ $periode }}</h2>
                    <div class="ir-panel overflow-hidden">
                        @foreach ($liste as $notification)
                            @php
                                [$icone, $teinte, $libelle] = $typeDe($notification);
                                $offre = $notification->candidature?->offre;
                            @endphp
                            <article class="ir-notif-row {{ !$notification->lu ? 'is-new' : '' }}">
                                <span class="ir-notif-ico {{ $teinte }}"><i class="bi {{ $icone }}"></i></span>
                                <div class="ir-notif-main">
                                    <div class="ir-notif-top">
                                        <strong>{{ $notification->titre }}</strong>
                                        @if (!$notification->lu)<span class="ir-new">Nouveau</span>@endif
                                        <time datetime="{{ $notification->created_at->toIso8601String() }}" title="{{ $notification->created_at->format('d/m/Y à H:i') }}">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </time>
                                    </div>
                                    <p>{{ $notification->message }}</p>
                                    <div class="ir-notif-links">
                                        @if ($libelle)<span class="ir-notif-tag {{ $teinte }}">{{ $libelle }}</span>@endif
                                        @if ($offre)
                                            <a href="{{ route('offres.show', $offre) }}"><i class="bi bi-briefcase"></i>{{ $offre->titre }}</a>
                                        @endif
                                        @if ($notification->candidature)
                                            <a href="{{ route('candidatures.mes') }}"><i class="bi bi-diagram-3"></i>Suivre la candidature</a>
                                        @endif
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>
            @empty
                <div class="ir-panel ir-empty-state">
                    <span class="ir-empty-icon"><i class="bi bi-bell-slash"></i></span>
                    <h2>Aucune notification pour le moment</h2>
                    <p>Dès qu'un recruteur traite une de vos candidatures, vous serez prévenu ici.</p>
                    <a href="{{ route('offres.index') }}" class="ir-submit"><i class="bi bi-search"></i>Voir les offres</a>
                </div>
            @endforelse

            @if ($notifications->hasPages())
                <div class="mt-4 d-flex justify-content-center">{{ $notifications->links() }}</div>
            @endif
        </div>
    </div>
@endsection

@push('styles')
<style>
    .ir-ngroup + .ir-ngroup { margin-top: 1.8rem; }
    .ir-ngroup-title { font-size: .78rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: var(--ir-muted); margin: 0 0 .7rem .2rem; }
    .ir-notif-row { position: relative; display: flex; gap: 1rem; padding: 1.2rem 1.4rem; border-bottom: 1px solid #f1f5f9; }
    .ir-notif-row:last-child { border-bottom: 0; }
    .ir-notif-row.is-new { background: linear-gradient(90deg, #f0f6ff, #fff 60%); }
    .ir-notif-row.is-new::before { content: ''; position: absolute; left: 0; top: 14px; bottom: 14px; width: 3px; border-radius: 0 3px 3px 0; background: var(--ir-sky); }
    .ir-notif-ico { width: 44px; height: 44px; flex-shrink: 0; border-radius: 12px; display: grid; place-items: center; font-size: 1.1rem; }
    .is-green { background: #e3f8ee; color: #15803d; }
    .is-rose { background: #ffe8ee; color: #be123c; }
    .is-amber { background: #fff4dc; color: #b45309; }
    .is-sky { background: #e0f2fe; color: #0369a1; }
    .is-slate { background: #f1f5f9; color: #475569; }
    .ir-notif-main { flex-grow: 1; min-width: 0; }
    .ir-notif-top { display: flex; align-items: center; gap: .6rem; flex-wrap: wrap; }
    .ir-notif-top strong { color: var(--ir-ink); font-size: .98rem; }
    .ir-notif-top time { margin-left: auto; font-size: .8rem; color: #94a3b8; white-space: nowrap; }
    .ir-new { font-size: .68rem; font-weight: 700; letter-spacing: .05em; text-transform: uppercase; padding: .2rem .5rem; border-radius: 6px; background: var(--ir-sky); color: #fff; }
    .ir-notif-main p { margin: .35rem 0 .7rem; color: #475569; font-size: .92rem; line-height: 1.55; }
    .ir-notif-links { display: flex; flex-wrap: wrap; gap: .5rem; align-items: center; }
    .ir-notif-tag { font-size: .74rem; font-weight: 600; padding: .25rem .6rem; border-radius: 999px; }
    .ir-notif-links a { display: inline-flex; align-items: center; gap: .35rem; font-size: .82rem; font-weight: 600; color: #475569; text-decoration: none; padding: .25rem .6rem; border-radius: 8px; border: 1px solid var(--ir-line); background: #fff; }
    .ir-notif-links a:hover { color: var(--ir-blue); border-color: #c7d6f5; background: var(--ir-soft); }
    @media (max-width: 575.98px) { .ir-notif-top time { margin-left: 0; flex-basis: 100%; } }
</style>
@endpush
