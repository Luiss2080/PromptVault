<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Sistema - PromptVault</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    <!-- Precargar fuentes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- CSS del login -->
    <link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">

    <!-- Meta tags para SEO -->
    <meta name="description" content="Accede a tu cuenta en PromptVault. Sistema de gestión centralizada de prompts de IA con versionado, organización y colaboración.">
    <meta name="keywords" content="login, prompts, IA, inteligencia artificial, gestión, versionado">
    <meta name="robots" content="noindex, nofollow">

    <!-- Open Graph -->
    <meta property="og:title" content="Iniciar Sesión - PromptVault">
    <meta property="og:description" content="Accede a tu cuenta en PromptVault">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
</head>

<body>
    <!-- Background animado -->
    <div class="login-background">
        <div class="bg-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
            <div class="shape shape-4"></div>
        </div>
        <div class="bg-grid"></div>
        <!-- Elementos robóticos -->
        <div class="tech-elements">
            <div class="robot-parts">
                <div class="gear gear-1"></div>
                <div class="gear gear-2"></div>
                <div class="gear gear-3"></div>
                <div class="gear gear-4"></div>
                <div class="circuit-board cb-1"></div>
                <div class="circuit-board cb-2"></div>
                <div class="circuit-board cb-3"></div>
                <div class="circuit-board cb-4"></div>
                <div class="led-indicator led-1"></div>
                <div class="led-indicator led-2"></div>
                <div class="led-indicator led-3"></div>
                <div class="led-indicator led-4"></div>
                <div class="led-indicator led-5"></div>
                <div class="led-indicator led-6"></div>
                <!-- Nuevos elementos robóticos -->
                <div class="robot-eye re-1"></div>
                <div class="robot-eye re-2"></div>
                <div class="robot-eye re-3"></div>
                <div class="data-stream ds-1"></div>
                <div class="data-stream ds-2"></div>
                <div class="data-stream ds-3"></div>
                <div class="tech-particle tp-1"></div>
                <div class="tech-particle tp-2"></div>
                <div class="tech-particle tp-3"></div>
                <div class="tech-particle tp-4"></div>
                <div class="tech-particle tp-5"></div>
            </div>
        </div>
    </div>

    <!-- Contenedor principal flotante -->
    <div class="main-login-wrapper">
        <div class="floating-container">

            <!-- Panel Izquierdo - Branding Profesional -->
            <div class="login-branding">
                <!-- Efectos de background -->
                <div class="branding-effects">
                    <div class="gradient-mesh"></div>
                    <div class="floating-elements">
                        <div class="float-element element-1"></div>
                        <div class="float-element element-2"></div>
                        <div class="float-element element-3"></div>
                    </div>
                </div>

                <div class="branding-content">
                    <!-- Logo completo -->
                    <div class="brand-section" style="margin-bottom: 20px;">
                        <div class="logo-container">
                            <img src="{{ asset('images/LogoCompletoLogin.png') }}" alt="PromptVault" class="brand-logo" style="max-width: 85%; height: auto; margin: 0 auto; display: block;">
                        </div>
                    </div>

                    <!-- Mensaje profesional -->
                    <div class="welcome-section" style="margin-bottom: 25px;">
                        <p class="welcome-description" style="font-size: 0.9rem; line-height: 1.4; text-align: center; color: #e0e0e0;">
                            Sistema de gestión centralizada de prompts de IA con versionado automático, colaboración en tiempo real y organización inteligente por categorías y etiquetas.
                        </p>
                    </div>

                    <!-- Sección de redes sociales -->
                    <div class="social-section">
                        <p class="social-text" style="font-size: 0.85rem; margin-bottom: 3px;">¿Necesitas ayuda con la plataforma?</p>
                        <p class="social-title" style="font-size: 1rem; margin-bottom: 12px;">¡Contáctanos!</p>
                        <div class="social-media-links">
                            <a href="#" class="social-link tiktok" title="TikTok">
                                <div class="social-icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="white">
                                        <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/>
                                    </svg>
                                </div>
                                <span>TikTok</span>
                            </a>
                            <a href="#" class="social-link facebook" title="Facebook">
                                <div class="social-icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="white">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                </div>
                                <span>Facebook</span>
                            </a>
                            <a href="#" class="social-link instagram" title="Instagram">
                                <div class="social-icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="white">
                                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                    </svg>
                                </div>
                                <span>Instagram</span>
                            </a>
                            <a href="#" class="social-link whatsapp" title="WhatsApp">
                                <div class="social-icon">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="white">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.465 3.488"/>
                                    </svg>
                                </div>
                                <span>WhatsApp</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sección derecha - Formulario de login -->
            <div class="login-form-section">
                <!-- Líneas decorativas -->
                <div class="form-lines">
                    <div class="line line-1"></div>
                    <div class="line line-2"></div>
                    <div class="line line-3"></div>
                </div>

                <!-- Partículas decorativas -->
                <div class="form-particles">
                    <div class="particle particle-1"></div>
                    <div class="particle particle-2"></div>
                    <div class="particle particle-3"></div>
                    <div class="particle particle-4"></div>
                </div>

                <div class="form-container"> <!-- Header del formulario -->
                    <div class="form-header">
                        <h2 class="form-title">Iniciar Sesión</h2>
                        <p class="form-subtitle">Ingresa tus credenciales para continuar</p>
                    </div>

                    <!-- Mensajes de error/éxito -->
                    @if($errors->any())
                    <div class="alert alert-error">
                        <div class="alert-icon">⚠️</div>
                        <div class="alert-message">{{ $errors->first() }}</div>
                    </div>
                    @endif

                    @if(session('success'))
                    <div class="alert alert-success">
                        <div class="alert-icon">✅</div>
                        <div class="alert-message">{{ session('success') }}</div>
                    </div>
                    @endif

                    <!-- Formulario de login -->
                    <form class="login-form" method="POST" action="{{ route('login') }}" id="loginForm">
                        @csrf

                        <!-- Campo Email -->
                        <div class="input-group">
                            <label for="email" class="input-label">Correo Electrónico</label>
                            <div class="input-wrapper">
                                <div class="input-icon">✉</div>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    class="form-input"
                                    placeholder="Escribe tu email aquí..."
                                    value="{{ old('email') }}"
                                    required
                                    autocomplete="email">
                            </div>
                            <div class="input-error" id="emailError"></div>
                        </div>

                        <!-- Campo Contraseña -->
                        <div class="input-group">
                            <label for="password" class="input-label">Contraseña</label>
                            <div class="input-wrapper">
                                <div class="input-icon">🔒</div>
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    class="form-input"
                                    placeholder="Escribe tu contraseña aquí..."
                                    required
                                    autocomplete="current-password">
                            </div>
                            <div class="input-error" id="passwordError"></div>
                        </div>

                        <!-- Recordar y Olvidé contraseña -->
                        <div class="form-options">
                            <label class="checkbox-label">
                                <input type="checkbox" name="remember" id="remember" class="checkbox-input">
                                <span class="checkbox-custom"></span>
                                <span class="checkbox-text">Recordarme</span>
                            </label>
                            <a href="{{ route('password.request') }}" class="forgot-password" id="forgotPasswordLink">¿Olvidaste tu contraseña?</a>
                        </div>

                        <!-- Botón de submit -->
                        <button type="submit" class="login-button btn-nexorium" id="loginButton">
                            <span class="button-text">ACCESO SISTEMA</span>
                            <span class="button-loader" id="buttonLoader">
                                <div class="loader-spinner"></div>
                            </span>
                        </button>

                    </form>

                    <!-- Footer del formulario -->
                    <div class="form-footer">
                        <!-- Sección de funcionalidades -->
                        <div style="margin-top: 10px;">
                            <p style="font-size: 0.9rem; margin-bottom: 5px; text-align: center; color: #ccc;">¿Qué puedes hacer en la plataforma?</p>
                            <p style="font-size: 1.1rem; margin-bottom: 15px; text-align: center; color: #fff; font-weight: 600;">¡Explora nuestras funcionalidades!</p>
                            
                            <!-- Funcionalidades Cards -->
                            <div class="social-media-links" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                                <a href="#" class="social-link tiktok" title="Biblioteca de Prompts">
                                    <div class="social-icon">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="white">
                                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/>
                                        </svg>
                                    </div>
                                    <span>Biblioteca</span>
                                </a>
                                <a href="#" class="social-link facebook" title="Versionado">
                                    <div class="social-icon">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="white">
                                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                        </svg>
                                    </div>
                                    <span>Versionado</span>
                                </a>
                                <a href="#" class="social-link instagram" title="Colaboración">
                                    <div class="social-icon">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="white">
                                            <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
                                        </svg>
                                    </div>
                                    <span>Colaboración</span>
                                </a>
                                <a href="#" class="social-link whatsapp" title="IA Integrada">
                                    <div class="social-icon">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="white">
                                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                                            <circle cx="12" cy="12" r="3"/>
                                        </svg>
                                    </div>
                                    <span>IA Integrada</span>
                                </a>
                            </div>
                        </div>

                        <!-- Pregunta de registro -->
                        <p class="register-text" style="margin-top: 25px; text-align: center;">
                            ¿No tienes una cuenta?
                            <span class="highlight"><a href="{{ route('register') }}" class="register-link" id="registerLink">¡Regístrate aquí!</a></span>
                        </p>

                    </div>
                </div>

            </div>
        </div>

    </div>

    <!-- JavaScript -->
    <script src="{{ asset('js/auth/login.js') }}"></script>

    <!-- Analytics (opcional) -->
    <script>
        // Google Analytics o similar
        console.log('🔐 PROMPTVAULT Login: Página cargada correctamente');
    </script>

</body>

</html>