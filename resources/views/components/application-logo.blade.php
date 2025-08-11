@props(['class' => 'h-8 w-auto'])

<div {{ $attributes->merge(['class' => 'flex items-center']) }}>
    <svg {{ $attributes->merge(['class' => $class]) }} viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
        <!-- Background circle -->
        <circle cx="50" cy="50" r="45" fill="#1e40af" stroke="#3b82f6" stroke-width="2"/>
        
        <!-- School building -->
        <rect x="25" y="35" width="50" height="40" fill="white" stroke="#1e40af" stroke-width="1"/>
        
        <!-- Roof -->
        <polygon points="20,35 50,20 80,35" fill="#dc2626" stroke="#b91c1c" stroke-width="1"/>
        
        <!-- Door -->
        <rect x="45" y="55" width="10" height="20" fill="#1e40af"/>
        
        <!-- Windows -->
        <rect x="30" y="45" width="8" height="8" fill="#1e40af"/>
        <rect x="62" y="45" width="8" height="8" fill="#1e40af"/>
        
        <!-- Flag pole -->
        <line x1="75" y1="25" x2="75" y2="45" stroke="#374151" stroke-width="2"/>
        
        <!-- Flag -->
        <rect x="75" y="25" width="8" height="6" fill="#dc2626"/>
        
        <!-- Text "SMP 5" -->
        <text x="50" y="90" text-anchor="middle" font-family="Arial, sans-serif" font-size="8" font-weight="bold" fill="white">SMP 5</text>
    </svg>
</div>
