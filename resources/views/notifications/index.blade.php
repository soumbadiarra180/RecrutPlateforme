@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
    <div class="mb-4">
        <h1 class="h3 fw-bold mb-1">Notifications</h1>
        <p class="text-muted mb-0">{{ $notifications->total() }} notification(s)</p>
    </div>

    @forelse ($notifications as $notification)
        <div class="card mb-3 {{ !$notification->lu ? 'border-primary' : '' }}">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <h6 class="fw-bold mb-1">
                        @if (!$notification->lu)
                            <span class="badge bg-primary me-1">Nouveau</span>
                        @endif
                        {{ $notification->titre }}
                    </h6>
                    <small class="text-muted">{{ $notification->created_at->format('d/m/Y à H:i') }}</small>
                </div>
                <p class="mb-2">{{ $notification->message }}</p>
                @if ($notification->candidature)
                    <a href="{{ route('candidatures.mes') }}" class="fw-semibold small">Voir mes candidatures <i class="bi bi-arrow-right"></i></a>
                @endif
            </div>
        </div>
    @empty
        <div class="text-center text-muted py-5">
            <i class="bi bi-bell-slash fs-1 d-block mb-2"></i>
            Aucune notification pour le moment.
        </div>
    @endforelse

    <div class="mt-3">
        {{ $notifications->links() }}
    </div>
@endsection