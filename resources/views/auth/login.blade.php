<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Iniciar Sesión - MedAlert</title>

    <!-- Bunny.net Inter Font - CORREGIDO (sin espacios) -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <style>
        :root {
            --primary: #dc2626; /* Rojo de emergencia */
            --primary-dark: #b91c1c;
            --blue-bg: #f0f7ff; /* Azul suave profesional (fondo) */
            --white: #ffffff;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-600: #4b5563;
            --gray-900: #111827;
            --radius: 12px;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.06);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--blue-bg); /* FONDO AZUL SUAVE */
            color: var(--gray-900);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 0;
        }

        /* Header */
        .header {
            width: 100%;
            background: var(--white);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(216, 149, 149, 0.83);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .logo-img {
            width: 48px;
            height: 48px;
            background: var(--primary);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
        }

        .logo-text {
            display: flex;
            flex-direction: column;
        }

        .logo-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--gray-900);
        }

        .logo-subtitle {
            font-size: 0.875rem;
            color: var(--primary);
            font-weight: 600;
        }

        .header-actions {
            display: flex;
            gap: 1rem;
        }

        .btn-header {
            padding: 0.5rem 1rem;
            border-radius: var(--radius);
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-login {
            background: var(--primary);
            color: white;
            border: none;
        }

        .btn-login:hover {
            background: var(--primary-dark);
        }

        .btn-register {
            background: transparent;
            color: var(--gray-900);
            border: 2px solid var(--gray-200);
        }

        .btn-register:hover {
            background: var(--gray-50);
            border-color: var(--gray-600);
        }

        /* Main Content */
        .main-content {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 80px 1rem 2rem;
            width: 100%;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            background: var(--white);
            border-radius: var(--radius);
            padding: 2.5rem;
            box-shadow: var(--shadow);
            border: 1px solid var(--gray-200);
        }

        .login-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--primary);
            text-align: center;
            margin-bottom: 0.5rem;
        }

        .login-subtitle {
            font-size: 0.875rem;
            color: var(--gray-600);
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        label {
            display: block;
            font-weight: 600;
            font-size: 0.875rem;
            color: var(--gray-800);
            margin-bottom: 0.5rem;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--gray-200);
            border-radius: var(--radius);
            font-size: 1rem;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 0.5rem;
            font-size: 0.875rem;
        }

        .remember-forgot label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin: 0;
            cursor: pointer;
        }

        .remember-forgot input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: var(--primary);
        }

        .remember-forgot a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }

        .remember-forgot a:hover {
            text-decoration: underline;
        }

        .btn-submit {
            width: 100%;
            background: var(--primary);
            color: white;
            border: none;
            padding: 0.75rem;
            font-size: 1rem;
            font-weight: 600;
            border-radius: var(--radius);
            cursor: pointer;
            margin-top: 1rem;
            transition: background 0.2s, transform 0.2s;
        }

        .btn-submit:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }

        .alert {
            padding: 0.75rem 1rem;
            border-radius: var(--radius);
            margin-bottom: 1.5rem;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        /* Footer */
        .footer {
            width: 100%;
            background: var(--white);
            color: var(--gray-900);
            padding: 2rem 2rem 1rem;
            border-top: 1px solid var(--gray-200);
            margin-top: auto;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
        }

        .footer-section h3 {
            font-size: 1rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 1rem;
        }

        .footer-section ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-section li {
            margin: 0.5rem 0;
        }

        .footer-section a {
            color: var(--gray-600);
            text-decoration: none;
            transition: color 0.2s;
        }

        .footer-section a:hover {
            color: var(--primary);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 1rem;
            font-size: 0.875rem;
            color: var(--gray-600);
            border-top: 1px solid var(--gray-200);
            margin-top: 1.5rem;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="logo-container">
            <div class="logo-img">🚑</div>
            <div class="logo-text">
                <span class="logo-title">MedAlert</span>
                <span class="logo-subtitle">Emergencias Médicas</span>
            </div>
        </div>
        <div class="header-actions">
            <a href="#" class="btn-header btn-register">Ingresar</a>
            <a href="#" class="btn-header btn-login">Registrarse</a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <div class="login-container">
            <h1 class="login-title">Iniciar Sesión</h1>
            <p class="login-subtitle">Accede a tu panel de gestión de urgencias médicas</p>

            <!-- Mensajes de sesión (status) -->
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required 
                        autofocus
                        autocomplete="username"
                    >
                    @error('email')
                        <div class="alert alert-error" style="margin-top: 0.5rem;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Contraseña -->
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required 
                        autocomplete="current-password"
                    >
                    @error('password')
                        <div class="alert alert-error" style="margin-top: 0.5rem;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Recordar y olvidé contraseña -->
                <div class="remember-forgot">
                    <label>
                        <input type="checkbox" name="remember" id="remember_me">
                        Recordarme
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
                    @endif
                </div>

                <!-- Botón de login -->
                <button type="submit" class="btn-submit">
                    Iniciar Sesión
                </button>
            </form>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>MedAlert</h3>
                <p>Sistema profesional de gestión de emergencias médicas.</p>
            </div>
            <div class="footer-section">
                <h3>Producto</h3>
                <ul>
                    <li><a href="#">Características</a></li>
                    <li><a href="#">Estadísticas</a></li>
                    <li><a href="#">Precios</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Soporte</h3>
                <ul>
                    <li><a href="#">Contacto</a></li>
                    <li><a href="#">Ayuda</a></li>
                    <li><a href="#">Documentación</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Legal</h3>
                <ul>
                    <li><a href="#">Términos</a></li>
                    <li><a href="#">Privacidad</a></li>
                    <li><a href="#">Cookies</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            © {{ date('Y') }} MedAlert. Todos los derechos reservados.
        </div>
    </footer>
</body>
</html>