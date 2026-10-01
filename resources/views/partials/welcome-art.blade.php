<svg class="ir-welcome-art" viewBox="0 0 260 180" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
    <defs>
        <linearGradient id="irWelHub" x1="0" y1="0" x2="1" y2="1">
            <stop offset="0" stop-color="#3b82f6"/>
            <stop offset="1" stop-color="#1e3a8a"/>
        </linearGradient>
        <path id="irW1" d="M130 90 L40 40"/>
        <path id="irW2" d="M130 90 L220 40"/>
        <path id="irW3" d="M130 90 L40 145"/>
        <path id="irW4" d="M130 90 L220 145"/>
    </defs>
    <g stroke="rgba(147,197,253,.4)" stroke-width="1.5" fill="none" stroke-dasharray="4 6">
        <use href="#irW1"/><use href="#irW2"/><use href="#irW3"/><use href="#irW4"/>
    </g>
    <circle r="3.5" fill="#22d3ee"><animateMotion dur="2.4s" repeatCount="indefinite" keyPoints="1;0" keyTimes="0;1" calcMode="linear"><mpath href="#irW1"/></animateMotion></circle>
    <circle r="3.5" fill="#f59e0b"><animateMotion dur="2.8s" begin="-1s" repeatCount="indefinite"><mpath href="#irW2"/></animateMotion></circle>
    <circle r="3.5" fill="#a5b4fc"><animateMotion dur="3.1s" begin="-.6s" repeatCount="indefinite" keyPoints="1;0" keyTimes="0;1" calcMode="linear"><mpath href="#irW3"/></animateMotion></circle>
    <circle r="3.5" fill="#22d3ee"><animateMotion dur="2.6s" begin="-1.6s" repeatCount="indefinite"><mpath href="#irW4"/></animateMotion></circle>
    @foreach ([[40, 40, '#22d3ee'], [220, 40, '#f59e0b'], [40, 145, '#a5b4fc'], [220, 145, '#3b82f6']] as [$x, $y, $c])
        <circle cx="{{ $x }}" cy="{{ $y }}" r="16" fill="#12224f" stroke="{{ $c }}" stroke-width="2"/>
        <circle cx="{{ $x }}" cy="{{ $y - 3 }}" r="4" fill="#fff"/>
        <path d="M{{ $x - 7 }} {{ $y + 9 }} a7 6 0 0 1 14 0 z" fill="#fff"/>
    @endforeach
    <circle cx="130" cy="90" r="32" fill="none" stroke="#3b82f6" stroke-width="1.5">
        <animate attributeName="r" values="32;70" dur="2.8s" repeatCount="indefinite"/>
        <animate attributeName="opacity" values=".7;0" dur="2.8s" repeatCount="indefinite"/>
    </circle>
    <rect x="102" y="62" width="56" height="56" rx="16" fill="url(#irWelHub)"/>
    <g fill="none" stroke="#fff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
        <rect x="117" y="82" width="26" height="19" rx="3.5"/>
        <path d="M124 82 v-3.5 a2 2 0 0 1 2 -2 h8 a2 2 0 0 1 2 2 v3.5"/>
        <path d="M117 90 h26"/>
    </g>
</svg>
