@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('content')
    <h1 class="h3 fw-bold mb-4">Tableau de bord</h1>

    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card text-center p-3">
                <div class="icon-wrapper icon-blue mx-auto mb-2">
                    <i class="bi bi-briefcase-fill"></i>
                </div>
                <h3 class="fw-bold mb-0">{{ $totalOffres }}</h3>
                <small class="text-muted">Offres au total</small>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center p-3">
                <div class="icon-wrapper icon-green mx-auto mb-2">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
                <h3 class="fw-bold mb-0">{{ $offresOuvertes }}</h3>
                <small class="text-muted">Offres ouvertes</small>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center p-3">
                <div class="icon-wrapper icon-orange mx-auto mb-2">
                    <i class="bi bi-people-fill"></i>
                </div>
                <h3 class="fw-bold mb-0">{{ $totalCandidats }}</h3>
                <small class="text-muted">Candidats enregistrés</small>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center p-3">
                <div class="icon-wrapper icon-blue mx-auto mb-2">
                    <i class="bi bi-file-earmark-text-fill"></i>
                </div>
                <h3 class="fw-bold mb-0">{{ $totalCandidatures }}</h3>
                <small class="text-muted">Candidatures reçues</small>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h2 class="h5 fw-bold mb-3">Répartition des candidatures par statut</h2>
            <canvas id="statutChart" height="100"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
        const ctx = document.getElementById('statutChart');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Reçue', 'En cours d\'examen', 'Entretien', 'Acceptée', 'Refusée'],
                datasets: [{
                    label: 'Nombre de candidatures',
                    data: [
                        {{ $candidaturesParStatut['recue'] }},
                        {{ $candidaturesParStatut['en_cours_examen'] }},
                        {{ $candidaturesParStatut['entretien'] }},
                        {{ $candidaturesParStatut['acceptee'] }},
                        {{ $candidaturesParStatut['refusee'] }}
                    ],
                    backgroundColor: ['#6c757d', '#0dcaf0', '#ffc107', '#198754', '#dc3545']
                }]
            },
            options: {
                scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } },
                plugins: { legend: { display: false } }
            }
        });
    </script>
@endsection