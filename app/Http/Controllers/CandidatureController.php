<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use App\Models\Candidat;
use App\Models\OffreEmploi;
use Illuminate\Http\Request;

class CandidatureController extends Controller
{
    public function index()
    {
        $candidatures = Candidature::with(['candidat', 'offre'])->paginate(10);
        return view('candidatures.index', compact('candidatures'));
    }

    public function create()
    {
        $candidats = Candidat::all();
        $offres = OffreEmploi::where('statut', 'ouverte')->get();
        return view('candidatures.create', compact('candidats', 'offres'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_candidat' => 'required|exists:candidats,id_candidat',
            'id_offre' => 'required|exists:offres_emploi,id_offre',
            'lettre_motivation' => 'nullable|string',
            'date_candidature' => 'required|date',
        ]);

        $validated['statut'] = 'recue';

        Candidature::create($validated);

        return redirect()->route('candidatures.index')->with('success', 'Candidature enregistrée avec succès.');
    }

    public function show(Candidature $candidature)
    {
        $candidature->load(['candidat', 'offre']);
        return view('candidatures.show', compact('candidature'));
    }

    public function edit(Candidature $candidature)
    {
        return view('candidatures.edit', compact('candidature'));
    }

    public function update(Request $request, Candidature $candidature)
    {
        $validated = $request->validate([
            'statut' => 'required|in:recue,en_cours_examen,entretien,acceptee,refusee',
            'motif_decision' => 'nullable|string',
        ]);

        $candidature->update($validated);

        return redirect()->route('candidatures.index')->with('success', 'Statut de la candidature mis à jour.');
    }

    public function destroy(Candidature $candidature)
    {
        $candidature->delete();
        return redirect()->route('candidatures.index')->with('success', 'Candidature supprimée avec succès.');
    }
    public function postulerForm(\App\Models\OffreEmploi $offre)
{
    if (!auth()->user()->isCandidat() || !auth()->user()->id_candidat) {
        return redirect('/')->with('error', 'Seul un candidat peut postuler à une offre.');
    }

    return view('candidatures.postuler', compact('offre'));
}

public function postuler(Request $request, \App\Models\OffreEmploi $offre)
{
    if (!auth()->user()->isCandidat() || !auth()->user()->id_candidat) {
        return redirect('/')->with('error', 'Seul un candidat peut postuler à une offre.');
    }

    $validated = $request->validate([
        'lettre_motivation' => 'nullable|string',
    ]);

    Candidature::create([
        'id_candidat' => auth()->user()->id_candidat,
        'id_offre' => $offre->id_offre,
        'lettre_motivation' => $validated['lettre_motivation'] ?? null,
        'statut' => 'recue',
        'date_candidature' => now()->format('Y-m-d'),
    ]);

    return redirect()->route('candidatures.mes')->with('success', 'Candidature soumise avec succès.');
}

public function mesCandidatures()
{
    $candidatures = Candidature::with('offre')
        ->where('id_candidat', auth()->user()->id_candidat)
        ->paginate(10);

    return view('candidatures.mes', compact('candidatures'));
}
}