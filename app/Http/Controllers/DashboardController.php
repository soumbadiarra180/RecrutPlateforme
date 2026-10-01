<?php

namespace App\Http\Controllers;

use App\Models\OffreEmploi;
use App\Models\Candidat;
use App\Models\Candidature;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $offresOuvertes = OffreEmploi::where('statut', 'ouverte')->whereDate('date_limite', '>=', today())->count();
        $totalCandidats = Candidat::count();
        $totalCandidatures = Candidature::count();

        $candidaturesParStatut = collect(['recue', 'en_cours_examen', 'entretien', 'acceptee', 'refusee'])
            ->mapWithKeys(fn ($s) => [$s => Candidature::where('statut', $s)->count()]);

        $aTraiterTotal = $candidaturesParStatut['recue'] + $candidaturesParStatut['en_cours_examen'];
        $decisions = $candidaturesParStatut['acceptee'] + $candidaturesParStatut['refusee'];
        $tauxAcceptation = $decisions ? round($candidaturesParStatut['acceptee'] / $decisions * 100) : null;

        // Candidatures reçues par jour sur les 30 derniers jours (jours sans candidature = 0)
        $debut = today()->subDays(29);
        $parJour = Candidature::whereDate('date_candidature', '>=', $debut)
            ->selectRaw('date(date_candidature) as jour, count(*) as total')
            ->groupBy('jour')
            ->pluck('total', 'jour');
        $serie = collect(range(0, 29))->map(function ($i) use ($debut, $parJour) {
            $jour = $debut->copy()->addDays($i);
            return ['date' => $jour->format('Y-m-d'), 'label' => $jour->translatedFormat('d M'), 'total' => (int) ($parJour[$jour->format('Y-m-d')] ?? 0)];
        });
        $cetteSemaine = $serie->slice(23)->sum('total');
        $semainePrecedente = $serie->slice(16, 7)->sum('total');

        $topOffres = OffreEmploi::withCount('candidatures')
            ->orderByDesc('candidatures_count')
            ->latest()
            ->take(5)
            ->get();

        $prochainsEntretiens = Candidature::with(['candidat', 'offre'])
            ->where('statut', 'entretien')
            ->where('date_entretien', '>=', now())
            ->orderBy('date_entretien')
            ->take(5)
            ->get();

        $aTraiter = Candidature::with(['candidat', 'offre'])
            ->whereIn('statut', ['recue', 'en_cours_examen'])
            ->oldest('date_candidature')
            ->take(5)
            ->get();

        $offresBientotClotures = OffreEmploi::where('statut', 'ouverte')
            ->whereBetween('date_limite', [today(), today()->addDays(7)])
            ->orderBy('date_limite')
            ->get();

        return view('dashboard', compact(
            'offresOuvertes',
            'totalCandidats',
            'totalCandidatures',
            'candidaturesParStatut',
            'aTraiterTotal',
            'tauxAcceptation',
            'serie',
            'cetteSemaine',
            'semainePrecedente',
            'topOffres',
            'prochainsEntretiens',
            'aTraiter',
            'offresBientotClotures'
        ));
    }
}
