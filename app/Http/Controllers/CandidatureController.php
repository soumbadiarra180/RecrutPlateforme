<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use App\Models\Candidat;
use App\Models\OffreEmploi;
use App\Models\Notification;
use Illuminate\Http\Request;

class CandidatureController extends Controller
{
    public function index(Request $request)
    {
        $statuts = ['recue', 'en_cours_examen', 'entretien', 'acceptee', 'refusee'];
        $statut = in_array($request->query('statut'), $statuts, true) ? $request->query('statut') : null;
        $recherche = trim((string) $request->query('q', ''));
        $idOffre = $request->query('offre');

        // Recherche par nom / email du candidat ou titre de l'offre, filtre par offre
        $base = Candidature::query()
            ->when($recherche !== '', function ($q) use ($recherche) {
                $q->where(function ($w) use ($recherche) {
                    $w->whereHas('candidat', fn ($c) => $c->where('nom', 'like', "%{$recherche}%")
                            ->orWhere('prenom', 'like', "%{$recherche}%")
                            ->orWhere('email', 'like', "%{$recherche}%"))
                        ->orWhereHas('offre', fn ($o) => $o->where('titre', 'like', "%{$recherche}%"));
                });
            })
            ->when($idOffre, fn ($q, $id) => $q->where('id_offre', $id));

        $compteurs = (clone $base)->selectRaw('statut, count(*) as total')->groupBy('statut')->pluck('total', 'statut');

        $candidatures = (clone $base)->with(['candidat', 'offre'])
            ->when($statut, fn ($q, $s) => $q->where('statut', $s))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $offres = OffreEmploi::orderBy('titre')->get(['id_offre', 'titre']);

        return view('candidatures.index', compact('candidatures', 'compteurs', 'statut', 'recherche', 'idOffre', 'offres'));
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
            'date_entretien' => 'nullable|date',
        ]);

        $candidature->update($validated);
        $candidature->load(['candidat', 'offre']);

        $statutLabel = match ($validated['statut']) {
            'recue' => 'Reçue',
            'en_cours_examen' => 'En cours d\'examen',
            'entretien' => 'Entretien',
            'acceptee' => 'Acceptée',
            'refusee' => 'Refusée',
            default => $validated['statut'],
        };

        $message = "Le statut de votre candidature pour le poste \"{$candidature->offre->titre}\" est maintenant : {$statutLabel}.";

        if ($validated['statut'] === 'entretien' && !empty($validated['date_entretien'])) {
            $dateEntretien = \Carbon\Carbon::parse($validated['date_entretien'])->format('d/m/Y à H:i');
            $message .= " Votre entretien est prévu le {$dateEntretien}.";
        }

        if (!empty($validated['motif_decision'])) {
            $message .= " Commentaire du recruteur : {$validated['motif_decision']}";
        }

        Notification::create([
            'id_candidat' => $candidature->id_candidat,
            'id_candidature' => $candidature->id_candidature,
            'titre' => 'Mise à jour de votre candidature',
            'message' => $message,
            'lu' => false,
        ]);

        return redirect()->route('candidatures.index')->with('success', 'Statut de la candidature mis à jour.');
    }

    public function destroy(Candidature $candidature)
    {
        $candidature->delete();
        return redirect()->route('candidatures.index')->with('success', 'Candidature supprimée avec succès.');
    }

    public function postulerForm(OffreEmploi $offre)
    {
        if (!auth()->user()->isCandidat() || !auth()->user()->id_candidat) {
            return redirect('/')->with('error', 'Seul un candidat peut postuler à une offre.');
        }

        if ($offre->statut !== 'ouverte' || \Carbon\Carbon::parse($offre->date_limite)->isPast()) {
            return redirect()->route('offres.show', $offre)->with('error', 'Cette offre n\'accepte plus de candidatures, la date limite est dépassée.');
        }

        return view('candidatures.postuler', compact('offre'));
    }

    public function postuler(Request $request, OffreEmploi $offre)
    {
        if (!auth()->user()->isCandidat() || !auth()->user()->id_candidat) {
            return redirect('/')->with('error', 'Seul un candidat peut postuler à une offre.');
        }

        if ($offre->statut !== 'ouverte' || \Carbon\Carbon::parse($offre->date_limite)->isPast()) {
            return redirect()->route('offres.show', $offre)->with('error', 'Cette offre n\'accepte plus de candidatures, la date limite est dépassée.');
        }

        $validated = $request->validate([
            'cv' => 'required|file|mimes:pdf|max:5120',
            'lettre_motivation' => 'nullable|string',
        ]);

        $cheminCv = $request->file('cv')->store('cv', 'public');

        Candidature::create([
            'id_candidat' => auth()->user()->id_candidat,
            'id_offre' => $offre->id_offre,
            'lettre_motivation' => $validated['lettre_motivation'] ?? null,
            'cv_path' => $cheminCv,
            'statut' => 'recue',
            'date_candidature' => now()->format('Y-m-d'),
        ]);

        return redirect()->route('candidatures.mes')->with('success', 'Candidature soumise avec succès.');
    }

    public function mesCandidatures(Request $request)
    {
        $idCandidat = auth()->user()->id_candidat;

        // Filtres proposés en onglets : clé => statuts correspondants
        $filtres = [
            'toutes' => null,
            'en_cours' => ['recue', 'en_cours_examen'],
            'entretien' => ['entretien'],
            'acceptee' => ['acceptee'],
            'refusee' => ['refusee'],
        ];
        $filtre = array_key_exists($request->query('statut'), $filtres) ? $request->query('statut') : 'toutes';

        $compteurs = Candidature::where('id_candidat', $idCandidat)
            ->selectRaw('statut, count(*) as total')
            ->groupBy('statut')
            ->pluck('total', 'statut');
        $nombres = collect($filtres)->map(fn ($statuts) => $statuts
            ? collect($statuts)->sum(fn ($s) => $compteurs[$s] ?? 0)
            : $compteurs->sum());

        $prochainEntretien = Candidature::with('offre')
            ->where('id_candidat', $idCandidat)
            ->where('statut', 'entretien')
            ->where('date_entretien', '>=', now())
            ->orderBy('date_entretien')
            ->first();

        $candidatures = Candidature::with('offre')
            ->where('id_candidat', $idCandidat)
            ->when($filtres[$filtre], fn ($q, $statuts) => $q->whereIn('statut', $statuts))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('candidatures.mes', compact('candidatures', 'filtre', 'nombres', 'prochainEntretien'));
    }
}