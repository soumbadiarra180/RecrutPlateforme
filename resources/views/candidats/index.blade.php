@extends('layouts.app')

@section('title', 'Candidats')

@php $filtresActifs = $recherche !== '' || $pays; @endphp

@section('content')
    <div class="ir-page-head">
        <div>
            <span class="ir-kicker">Espace recruteur</span>
            <h1>Vivier de talents</h1>
            <p>{{ $totalCandidats }} {{ $totalCandidats > 1 ? 'candidats inscrits' : 'candidat inscrit' }}, dont {{ $actifs }} {{ $actifs > 1 ? 'ont' : 'a' }} déjà postulé à une offre.</p>
        </div>
    </div>

    <form method="GET" action="{{ route('candidats.index') }}" class="ir-search" role="search">
        <div class="ir-control">
            <i class="bi bi-search"></i>
            <input type="search" name="q" class="ir-input" value="{{ $recherche }}" placeholder="Nom, prénom, email ou téléphone" aria-label="Rechercher un candidat">
        </div>
        <select name="pays" class="ir-input no-icon" aria-label="Filtrer par pays">
            <option value="">Tous les pays</option>
            @foreach ($listePays as $p)
                <option value="{{ $p }}" {{ $pays === $p ? 'selected' : '' }}>{{ $p }}</option>
            @endforeach
        </select>
        <button type="submit" class="ir-submit"><i class="bi bi-search"></i>Rechercher</button>
        @if ($filtresActifs)
            <a href="{{ route('candidats.index') }}" class="ir-cancel">Effacer</a>
        @endif
    </form>

    @if ($filtresActifs)
        <p class="text-muted small mb-3">{{ $candidats->total() }} {{ $candidats->total() > 1 ? 'résultats' : 'résultat' }}</p>
    @endif

    <div class="row g-3">
        @forelse ($candidats as $candidat)
            <div class="col-md-6 col-xl-4">
                <a href="{{ route('candidats.show', $candidat) }}" class="ir-person fade-in-up" style="transition-delay: {{ ($loop->index % 3) * 0.05 }}s">
                    <div class="ir-person-top">
                        <span class="ir-pavatar">{{ strtoupper(mb_substr($candidat->nom, 0, 1) . mb_substr($candidat->prenom, 0, 1)) }}</span>
                        <div class="ir-person-name">
                            <strong>{{ $candidat->nom }} {{ $candidat->prenom }}</strong>
                            <small>Inscrit {{ $candidat->created_at?->diffForHumans() ?? '' }}</small>
                        </div>
                        @if ($candidat->candidatures_count)
                            <span class="ir-pcount" title="Candidatures envoyées">{{ $candidat->candidatures_count }}</span>
                        @endif
                    </div>
                    <ul class="ir-person-info">
                        <li><i class="bi bi-envelope"></i>{{ $candidat->email }}</li>
                        <li><i class="bi bi-telephone"></i>{{ $candidat->telephone ?: '—' }}</li>
                        <li><i class="bi bi-geo-alt"></i>{{ $candidat->pays ?: 'Pays non renseigné' }}</li>
                    </ul>
                    <div class="ir-person-foot">
                        @if ($candidat->candidatures_count)
                            <span>Dernière candidature le {{ \Carbon\Carbon::parse($candidat->candidatures_max_date_candidature)->format('d/m/Y') }}</span>
                        @else
                            <span class="text-muted">Aucune candidature</span>
                        @endif
                        <i class="bi bi-arrow-right"></i>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12">
                <div class="ir-panel ir-empty-state">
                    <span class="ir-empty-icon"><i class="bi bi-person-x"></i></span>
                    @if ($filtresActifs)
                        <h2>Aucun candidat ne correspond</h2>
                        <p>Vérifiez l'orthographe ou retirez le filtre de pays.</p>
                        <a href="{{ route('candidats.index') }}" class="ir-cancel">Voir tous les candidats</a>
                    @else
                        <h2>Aucun candidat inscrit</h2>
                        <p>Les candidats apparaîtront ici dès leur inscription sur JobIT.</p>
                    @endif
                </div>
            </div>
        @endforelse
    </div>

    @if ($candidats->hasPages())
        <div class="mt-4 d-flex justify-content-center">{{ $candidats->links() }}</div>
    @endif
@endsection

@push('styles')
<style>
    .ir-person { display: grid; gap: 1rem; height: 100%; padding: 1.3rem; background: #fff; border: 1px solid var(--ir-line); border-radius: 18px; text-decoration: none; color: inherit; transition: border-color .2s ease, transform .2s ease, box-shadow .2s ease; }
    .ir-person:hover { border-color: #bfd3fb; transform: translateY(-4px); box-shadow: 0 20px 36px -26px rgba(30,58,138,.45); color: inherit; }
    .ir-person-top { display: flex; align-items: center; gap: .9rem; }
    .ir-pavatar { width: 48px; height: 48px; flex-shrink: 0; border-radius: 14px; display: grid; place-items: center; font-weight: 800; color: #fff; background: linear-gradient(135deg, var(--ir-cyan), var(--ir-sky)); font-family: 'Plus Jakarta Sans', sans-serif; }
    .ir-person-name { flex-grow: 1; min-width: 0; display: grid; }
    .ir-person-name strong { color: var(--ir-ink); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .ir-person-name small { color: var(--ir-muted); }
    .ir-pcount { min-width: 30px; height: 30px; padding: 0 8px; border-radius: 999px; display: grid; place-items: center; background: #e8f0ff; color: var(--ir-blue); font-weight: 700; font-size: .85rem; }
    .ir-person-info { list-style: none; padding: 0; margin: 0; display: grid; gap: .45rem; font-size: .88rem; color: #475569; }
    .ir-person-info li { display: flex; gap: .6rem; align-items: center; min-width: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .ir-person-info i { color: #94a3b8; }
    .ir-person-foot { display: flex; justify-content: space-between; align-items: center; padding-top: .9rem; border-top: 1px dashed var(--ir-line); font-size: .82rem; color: #475569; }
    .ir-person-foot i { color: var(--ir-sky); transition: transform .2s ease; }
    .ir-person:hover .ir-person-foot i { transform: translateX(4px); }
</style>
@endpush
