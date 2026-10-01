<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OffreEmploiController;
use App\Http\Controllers\CandidatController;
use App\Http\Controllers\CandidatureController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;
use App\Models\OffreEmploi;
use App\Models\Candidat;
use App\Models\Candidature;

Route::get('/', function () {
    $stats = [
        'offres' => OffreEmploi::where('statut', 'ouverte')->count(),
        'candidats' => Candidat::count(),
        'candidatures' => Candidature::count(),
    ];
    $offresAlaUne = OffreEmploi::where('statut', 'ouverte')->whereDate('date_limite', '>=', today())->latest()->take(8)->get();
    $dernieresCandidatures = Candidature::with(['candidat', 'offre'])->latest()->take(5)->get();

    // Données personnelles du candidat connecté (tableau de bord d'accueil)
    $mesStats = null;
    $mesCandidatures = collect();
    if (auth()->check() && auth()->user()->isCandidat()) {
        $idCandidat = auth()->user()->id_candidat;
        $base = Candidature::where('id_candidat', $idCandidat);
        $mesStats = [
            'total' => (clone $base)->count(),
            'en_cours' => (clone $base)->whereIn('statut', ['recue', 'en_cours_examen'])->count(),
            'entretien' => (clone $base)->where('statut', 'entretien')->count(),
            'acceptee' => (clone $base)->where('statut', 'acceptee')->count(),
        ];
        $mesCandidatures = Candidature::with('offre')->where('id_candidat', $idCandidat)->latest()->take(4)->get();
    }

    return view('home', compact('stats', 'offresAlaUne', 'dernieresCandidatures', 'mesStats', 'mesCandidatures'));
});

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {

    Route::get('/offres', [OffreEmploiController::class, 'index'])->name('offres.index');

    // Routes réservées au recruteur : DOIVENT être déclarées avant /offres/{offre}
    Route::middleware('recruteur')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/offres/create', [OffreEmploiController::class, 'create'])->name('offres.create');
        Route::post('/offres', [OffreEmploiController::class, 'store'])->name('offres.store');
        Route::get('/offres/{offre}/edit', [OffreEmploiController::class, 'edit'])->name('offres.edit');
        Route::put('/offres/{offre}', [OffreEmploiController::class, 'update'])->name('offres.update');
        Route::delete('/offres/{offre}', [OffreEmploiController::class, 'destroy'])->name('offres.destroy');
    });

    // Consultation libre pour tout connecté (déclarée après create pour éviter le conflit)
    Route::get('/offres/{offre}', [OffreEmploiController::class, 'show'])->name('offres.show');
    Route::get('/offres/{offre}/postuler', [CandidatureController::class, 'postulerForm'])->name('offres.postuler.form');
    Route::post('/offres/{offre}/postuler', [CandidatureController::class, 'postuler'])->name('offres.postuler');

    // Candidats : le recruteur peut seulement consulter (création/modification/suppression réservées au candidat lui-même via son compte)
    Route::middleware('recruteur')->group(function () {
        Route::resource('candidats', CandidatController::class)->only(['index', 'show']);
    });

    // Candidatures : le candidat consulte les siennes et postule ; le recruteur gère tout
    Route::get('/mes-candidatures', [CandidatureController::class, 'mesCandidatures'])->name('candidatures.mes');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');

    Route::middleware('recruteur')->group(function () {
        Route::resource('candidatures', CandidatureController::class)->except(['create', 'store']);
    });
});