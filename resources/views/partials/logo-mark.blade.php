{{-- Symbole JobIT : la mallette (le job) avec une balise </> (l'IT).
     Couleurs pilotées par CSS : --logo-ink (mallette), --logo-knock (chevrons), --logo-accent (barre oblique). --}}
<svg class="ir-logo {{ $class ?? '' }}" viewBox="0 0 64 64" width="{{ $size ?? 36 }}" height="{{ $size ?? 36 }}" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
    <path d="M24 19 V15 a5 5 0 0 1 5 -5 h6 a5 5 0 0 1 5 5 v4" fill="none" stroke="var(--logo-ink, #fff)" stroke-width="4.5" stroke-linecap="round"/>
    <rect x="7" y="19" width="50" height="36" rx="10" fill="var(--logo-ink, #fff)"/>
    <path d="M25 29.5 L18.5 37 L25 44.5 M39 29.5 L45.5 37 L39 44.5" fill="none" stroke="var(--logo-knock, #0b1533)" stroke-width="4.2" stroke-linecap="round" stroke-linejoin="round"/>
    <path d="M35 27.5 L29 46.5" stroke="var(--logo-accent, #22d3ee)" stroke-width="4.2" stroke-linecap="round"/>
</svg>
