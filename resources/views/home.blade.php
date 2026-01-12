<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PromptVault - Biblioteca de Prompts</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/LogoPestañaPrompt.jpg') }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background: linear-gradient(135deg, #0f0f23 0%, #1a1a2e 50%, #16213e 100%);
            min-height: 100vh;
            color: #fff;
        }
        
        .navbar {
            background: rgba(15, 15, 35, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(225, 29, 72, 0.3);
        }
        
        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 800;
            color: #e11d48 !important;
        }
        
        .hero {
            text-align: center;
            padding: 3rem 0;
        }
        
        .hero h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #fff 0%, #e11d48 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            transition: all 0.3s;
        }
        
        .card:hover {
            transform: translateY(-4px);
            border-color: rgba(225, 29, 72, 0.5);
            box-shadow: 0 8px 30px rgba(225, 29, 72, 0.15);
        }
    </style>
</head>
<body>
    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-bolt"></i> PromptVault
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('prompts.index') }}">
                                <i class="fas fa-folder"></i> Mis Prompts
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('perfil.index') }}">
                                <i class="fas fa-user"></i> Perfil
                            </a>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm ms-2">
                                    <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                                </button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="btn btn-primary btn-sm" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
    
    <main class="container py-5">
        {{-- Hero --}}
        <section class="hero">
            <h1>Biblioteca de Prompts</h1>
            <p class="lead text-muted">Descubre y comparte los mejores prompts para IA</p>
        </section>
        
        {{-- Filtros --}}
        <x-prompt.filters :etiquetas="$etiquetas" :showVisibility="false" />
        
        {{-- Grid de prompts --}}
        <x-prompt.grid 
            :prompts="$prompts" 
            emptyMessage="No hay prompts públicos disponibles" 
            emptyIcon="search"
        />
    </main>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
