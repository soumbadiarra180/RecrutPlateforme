<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use App\Models\OffreEmploi;
use Illuminate\Http\Request;

class OffreEmploiController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $recherche = trim((string) $request->query('q', ''));
        $type = in_array($request->query('type'), ['CDI', 'CDD', 'Stage', 'Freelance'], true) ? $request->query('type') : null;

        // Recherche texte (titre, lieu, description, compétences) et filtre par type de contrat
        $query = OffreEmploi::withCount('candidatures')
            ->when($recherche !== '', function ($q) use ($recherche) {
                $q->where(function ($w) use ($recherche) {
                    foreach (['titre', 'lieu', 'description', 'competences'] as $champ) {
                        $w->orWhere($champ, 'like', "%{$recherche}%");
                    }
                });
            })
            ->when($type, fn ($q, $t) => $q->where('type_contrat', $t));

        if ($user->isRecruteur()) {
            // Onglets d'état pour le recruteur
            $etats = [
                'toutes' => fn ($q) => $q,
                'ouvertes' => fn ($q) => $q->where('statut', 'ouverte')->whereDate('date_limite', '>=', today()),
                'expirees' => fn ($q) => $q->where('statut', 'ouverte')->whereDate('date_limite', '<', today()),
                'fermees' => fn ($q) => $q->where('statut', 'fermee'),
            ];
            $etat = array_key_exists($request->query('etat'), $etats) ? $request->query('etat') : 'toutes';
            $compteurs = collect($etats)->map(fn ($filtre) => $filtre(OffreEmploi::query())->count());

            $offres = $etats[$etat]($query)->latest()->paginate(10)->withQueryString();

            return view('offres.index', compact('offres', 'recherche', 'type', 'etat', 'compteurs'));
        }

        // Le candidat ne voit que les offres auxquelles il peut encore postuler
        $offres = $query->where('statut', 'ouverte')
            ->whereDate('date_limite', '>=', today())
            ->latest()
            ->paginate(9)
            ->withQueryString();

        $parType = OffreEmploi::where('statut', 'ouverte')
            ->whereDate('date_limite', '>=', today())
            ->selectRaw('type_contrat, count(*) as total')
            ->groupBy('type_contrat')
            ->pluck('total', 'type_contrat');

        $dejaPostule = Candidature::where('id_candidat', $user->id_candidat)->pluck('id_offre')->all();

        return view('offres.index', compact('offres', 'recherche', 'type', 'parType', 'dejaPostule'));
    }

    public function create()
    {
        return view('offres.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:100',
            'description' => 'required|string',
            'missions' => 'nullable|string',
            'competences' => 'nullable|string',
            'profil_recherche' => 'nullable|string',
            'type_contrat' => 'required|in:CDI,CDD,Stage,Freelance',
            'lieu' => 'required|string|max:100',
            'date_publication' => 'required|date',
            'date_limite' => 'required|date|after_or_equal:date_publication',
            'statut' => 'required|in:ouverte,fermee',
        ]);

        OffreEmploi::create($validated);

        return redirect()->route('offres.index')->with('success', 'Offre d\'emploi publiée avec succès.');
    }

    public function show(OffreEmploi $offre)
    {
        $offre->load(['candidatures' => fn ($q) => $q->latest(), 'candidatures.candidat']);
        $user = auth()->user();

        // Candidature du candidat connecté pour cette offre (s'il a déjà postulé)
        $maCandidature = $user->isCandidat()
            ? $offre->candidatures->firstWhere('id_candidat', $user->id_candidat)
            : null;

        // Offres similaires encore ouvertes : même type de contrat en priorité
        $similaires = $user->isCandidat()
            ? OffreEmploi::where('id_offre', '!=', $offre->id_offre)
                ->where('statut', 'ouverte')
                ->whereDate('date_limite', '>=', today())
                ->orderByRaw('type_contrat = ? desc', [$offre->type_contrat])
                ->latest()
                ->take(3)
                ->get()
            : collect();

        return view('offres.show', compact('offre', 'maCandidature', 'similaires'));
    }

    public function edit(OffreEmploi $offre)
    {
        return view('offres.edit', compact('offre'));
    }

    public function update(Request $request, OffreEmploi $offre)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:100',
            'description' => 'required|string',
            'missions' => 'nullable|string',
            'competences' => 'nullable|string',
            'profil_recherche' => 'nullable|string',
            'type_contrat' => 'required|in:CDI,CDD,Stage,Freelance',
            'lieu' => 'required|string|max:100',
            'date_publication' => 'required|date',
            'date_limite' => 'required|date|after_or_equal:date_publication',
            'statut' => 'required|in:ouverte,fermee',
        ]);

        $offre->update($validated);

        return redirect()->route('offres.index')->with('success', 'Offre d\'emploi modifiée avec succès.');
    }

    public function destroy(OffreEmploi $offre)
    {
        if ($offre->candidatures()->exists()) {
            return redirect()->route('offres.index')
                ->with('error', 'Impossible de supprimer : cette offre contient encore des candidatures.');
        }

        $offre->delete();
        return redirect()->route('offres.index')->with('success', 'Offre d\'emploi supprimée avec succès.');
    }
}