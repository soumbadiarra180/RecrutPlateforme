<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use Illuminate\Http\Request;

class CandidatController extends Controller
{
    public function index()
    {
        $candidats = Candidat::withCount('candidatures')->paginate(10);
        return view('candidats.index', compact('candidats'));
    }

    public function create()
    {
        return view('candidats.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:50',
            'prenom' => 'required|string|max:50',
            'email' => 'required|email|max:100|unique:candidats,email',
            'telephone' => 'nullable|string|max:20',
            'cv' => 'nullable|string',
        ]);

        Candidat::create($validated);

        return redirect()->route('candidats.index')->with('success', 'Candidat ajouté avec succès.');
    }

    public function show(Candidat $candidat)
    {
        $candidat->load('candidatures.offre');
        return view('candidats.show', compact('candidat'));
    }

    public function edit(Candidat $candidat)
    {
        return view('candidats.edit', compact('candidat'));
    }

    public function update(Request $request, Candidat $candidat)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:50',
            'prenom' => 'required|string|max:50',
            'email' => 'required|email|max:100|unique:candidats,email,' . $candidat->id_candidat . ',id_candidat',
            'telephone' => 'nullable|string|max:20',
            'cv' => 'nullable|string',
        ]);

        $candidat->update($validated);

        return redirect()->route('candidats.index')->with('success', 'Candidat modifié avec succès.');
    }

    public function destroy(Candidat $candidat)
    {
        if ($candidat->candidatures()->exists()) {
            return redirect()->route('candidats.index')
                ->with('error', 'Impossible de supprimer : ce candidat a encore des candidatures enregistrées.');
        }

        $candidat->delete();
        return redirect()->route('candidats.index')->with('success', 'Candidat supprimé avec succès.');
    }
}