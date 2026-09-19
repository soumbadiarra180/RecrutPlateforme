<?php

namespace App\Http\Controllers;

use App\Models\OffreEmploi;
use App\Models\Candidat;
use App\Models\Candidature;

class DashboardController extends Controller
{
    public function index()
    {
        $totalOffres = OffreEmploi::count();
        $offresOuvertes = OffreEmploi::where('statut', 'ouverte')->count();
        $offresFermees = OffreEmploi::where('statut', 'fermee')->count();

        $totalCandidats = Candidat::count();
        $totalCandidatures = Candidature::count();

        $candidaturesParStatut = [
            'recue' => Candidature::where('statut', 'recue')->count(),
            'en_cours_examen' => Candidature::where('statut', 'en_cours_examen')->count(),
            'entretien' => Candidature::where('statut', 'entretien')->count(),
            'acceptee' => Candidature::where('statut', 'acceptee')->count(),
            'refusee' => Candidature::where('statut', 'refusee')->count(),
        ];

        return view('dashboard', compact(
            'totalOffres',
            'offresOuvertes',
            'offresFermees',
            'totalCandidats',
            'totalCandidatures',
            'candidaturesParStatut'
        ));
    }
}