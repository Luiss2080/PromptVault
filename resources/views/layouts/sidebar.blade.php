@php
    // Obtener el rol del usuario autenticado
    $user = Auth::user();
    $userRole = 'guest';
    
    if ($user && $user->role) {
        $userRole = $user->role->nombre;
    } elseif (session()->has('user_role')) {
        $userRole = session('user_role');
    }
    
    // Determinar qué sidebar incluir según el rol
    $sidebarComponent = match($userRole) {
        'admin' => 'layouts.sidebarAdmin',
        'user' => 'layouts.sidebarUser',
        'collaborator' => 'layouts.sidebarCollaborator',
        default => 'layouts.sidebarGuest',
    };
@endphp

@include($sidebarComponent)