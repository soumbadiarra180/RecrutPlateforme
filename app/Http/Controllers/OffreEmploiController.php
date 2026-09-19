<?php

namespace App\Http\Controllers;

use App\Models\OffreEmploi;
use Illuminate\Http\Request;

class OffreEmploiController extends Controller
{
    public function index()
    {
        $offres = OffreEmploi::withCount('candidatures')->paginate(10);
        return view('offres.index', compact('offres'));
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
        $offre->load('candidatures.candidat');
        return view('offres.show', compact('offre'));
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