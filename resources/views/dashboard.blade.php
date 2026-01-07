@php
    // Determinar qué componente de dashboard mostrar según el rol del usuario
    $userRole = session('user_role', 'guest');
    
    $dashboardComponent = match($userRole) {
        'admin' => 'components.admin',
        'user' => 'components.user',
        'collaborator' => 'components.collaborator',
        default => 'components.guest',
    };
@endphp

@include($dashboardComponent, ['stats' => $stats ?? []])
