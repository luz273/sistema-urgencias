@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    :root {
        --primary: #dc2626; /* 🔴 ROJO PRINCIPAL */
        --primary-dark: #b91c1c;
        --primary-light: #fee2e2;
        --success: #0d9488;
        --success-light: #ecfdf5;
        --white: #ffffff;
        --bg-color: #f0f4f8;
        --gray-50: #f9fafb;
        --gray-100: #f3f4f6;
        --gray-200: #f4bfc43f;
        --gray-300: #d1d5db;
        --gray-600: #4b5563;
        --gray-800: #1f2937;
        --gray-900: #111827;
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1);
        --radius: 12px;
        --radius-sm: 8px;
        --transition: all 0.2s ease;
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        background-color: #f0f4f8;
        color: var(--gray-900);
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        overflow-x: hidden;
        line-height: 1.5;
    }

    /* Header Horizontal */
    .header {
        width: 100%;
        background: var(--white);
        padding: 0.6rem 1.25rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: var(--shadow-sm);
        z-index: 99;
        position: sticky;
        top: 0;
        border-bottom: 1px solid var(--gray-200);
    }

    .logo-container {
        display: flex;
        align-items: center;
        gap: 0.85rem;
    }

    .logo-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 3px 8px rgba(220, 38, 38, 0.15);
        position: relative;
    }

    .logo-icon::before {
        content: '';
        position: absolute;
        width: 20px;
        height: 20px;
        background: var(--white);
        border-radius: 5px;
    }

    .logo-icon::after {
        content: '+';
        position: absolute;
        color: var(--primary);
        font-weight: 700;
        font-size: 1rem;
        z-index: 1;
    }

    .logo-text {
        display: flex;
        flex-direction: column;
    }

    .logo-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--gray-900);
    }

    .logo-subtitle {
        font-size: 0.85rem;
        color: var(--primary);
        font-weight: 500;
    }

    .user-dropdown {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.6rem 1.2rem;
        border-radius: var(--radius-sm);
        background: var(--white);
        border: 1px solid var(--gray-200);
        font-weight: 600;
        color: var(--gray-900);
        cursor: pointer;
        transition: all 0.25s ease;
        box-shadow: var(--shadow-sm);
    }

    .user-dropdown:hover {
        box-shadow: var(--shadow);
        transform: translateY(-2px);
        border-color: var(--primary-light);
    }

    /* Menú Horizontal Centrado */
    .menu-container {
        background-color: #ffffff;
        padding: 0.9rem 0;
        box-shadow: var(--shadow-sm);
        border-bottom: 1px solid var(--gray-200);
        width: 100%;
    }

    .menu {
        display: flex;
        justify-content: center;
        gap: 14px;
        flex-wrap: wrap;
        max-width: 900px;
        margin: 0 auto;
        padding: 0 1rem;
        list-style: none;
    }

    .menu-item {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        text-decoration: none;
        color: var(--gray-600);
        font-size: 0.95rem;
        font-weight: 600;
        border-radius: 10px;
        transition: all 0.25s ease;
        background: var(--gray-50);
        border: 2px solid transparent;
    }

    .menu-item:hover {
        background: var(--gray-200);
        color: var(--gray-900);
        transform: translateY(-2px);
        box-shadow: var(--shadow);
    }

    .menu-item.active {
        background: var(--primary);
        color: var(--white);
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
        font-weight: 600;
    }

    .menu-item span {
        font-size: 1.2rem;
    }

    /* Contenido principal */
    .main-content {
        padding: 1.5rem;
        max-width: 1000px;
        margin: 0 auto;
        flex: 1;
        width: 100%;
    }

    /* Bienvenida */
    .welcome-card {
        display: flex;
        gap: 16px;
        background: white;
        border-radius: 14px;
        padding: 1.5rem;
        box-shadow: 0 3px 10px rgba(247, 120, 120, 0.94);
        margin-bottom: 1.5rem;
        align-items: flex-start;
        border-left: 4px solid var(--primary);
    }

    .welcome-icon {
        font-size: 28px;
        flex-shrink: 0;
        animation: wave 2s ease-in-out infinite;
    }

    @keyframes wave {
        0%, 100% { transform: rotate(0deg); }
        25% { transform: rotate(18deg); }
        75% { transform: rotate(-18deg); }
    }

    .welcome-text h2 {
        margin: 0 0 12px;
        font-size: 1.6rem;
        color: var(--gray-900);
        font-weight: 700;
    }

    .welcome-body {
        margin: 0 0 14px;
        color: var(--gray-700);
        line-height: 1.6;
        font-size: 1rem;
    }

    .welcome-list {
        padding-left: 20px;
        margin: 0;
        color: var(--gray-700);
        line-height: 1.7;
        font-size: 1rem;
    }

    .welcome-list li {
        margin-bottom: 8px;
    }

    /* Encabezado de página */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .page-title {
        font-size: 1.85rem;
        font-weight: 800;
        color: var(--gray-900);
    }

    .btn-group {
        display: flex;
        gap: 12px;
    }

    .btn {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        border: none;
        border-radius: 10px;
        font-size: 1rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.25s ease;
        box-shadow: var(--shadow);
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: var(--white);
    }

    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 18px rgba(220, 38, 38, 0.35);
    }

    .btn-secondary {
        background: var(--white);
        color: var(--gray-800);
        border: 2px solid var(--gray-200);
    }

    .btn-secondary:hover {
        background: var(--gray-50);
        transform: translateY(-3px);
        border-color: var(--gray-300);
    }

    /* Tarjetas de estadísticas */
    .cards {
        display: flex;
        gap: 18px;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }

    .card {
        flex: 1;
        min-width: 180px;
        background: var(--white);
        border-radius: 14px;
        padding: 1.5rem;
        box-shadow: var(--shadow);
        text-align: center;
        transition: all 0.25s ease;
        border: 1px solid var(--gray-200);
        position: relative;
        overflow: hidden;
    }

    .card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary), var(--primary-dark));
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }

    .card-today::before {
        background: linear-gradient(90deg, #dc2626, #f97316);
    }

    .card-total::before {
        background: linear-gradient(90deg, #2563eb, #7c3aed);
    }

    .card-title {
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--gray-600);
        text-transform: uppercase;
        letter-spacing: 1.2px;
        margin-bottom: 12px;
    }

    .card-value {
        font-size: 2.4rem;
        font-weight: 800;
        margin: 8px 0;
        background: linear-gradient(135deg, var(--gray-900), var(--primary));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .card-today .card-value {
        background: linear-gradient(135deg, #dc2626, #f97316);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .card-total .card-value {
        background: linear-gradient(135deg, #2563eb, #7c3aed);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .card-footer {
        font-size: 0.95rem;
        color: var(--gray-600);
        font-weight: 600;
    }

    /* Panel de Emergencia */
    .emergency-panel,
    .modal {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(8px);
        align-items: center;
        justify-content: center;
        z-index: 1000;
    }

    .emergency-panel.active,
    .modal.active {
        display: flex;
    }

    .panel-content,
    .modal-content {
        background: var(--white);
        border-radius: var(--radius);
        width: 90%;
        max-width: 560px;
        box-shadow: var(--shadow-lg);
        overflow: hidden;
        animation: slideUp 0.3s ease;
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .panel-header {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: var(--white);
        padding: 1.75rem;
        text-align: center;
    }

    .panel-header h3 {
        font-size: 1.4rem;
        font-weight: 800;
        margin-bottom: 0.4rem;
    }

    .panel-header p {
        opacity: 0.95;
        font-size: 1rem;
    }

    .panel-body {
        padding: 1.75rem;
    }

    .step {
        display: none;
    }

    .step.active {
        display: block;
        animation: fadeIn 0.4s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .step-indicator {
        display: flex;
        justify-content: center;
        gap: 0.6rem;
        margin-bottom: 1.8rem;
    }

    .step-dot {
        width: 7px;
        height: 7px;
        background: var(--gray-300);
        border-radius: 50%;
        transition: var(--transition);
    }

    .step-dot.active {
        background: var(--primary);
        width: 22px;
        border-radius: 4px;
    }

    .info-box {
        background: linear-gradient(135deg, var(--gray-50), var(--white));
        border-radius: var(--radius-sm);
        padding: 1.4rem;
        margin-bottom: 1.4rem;
        border: 1px solid var(--gray-200);
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        padding: 0.7rem 0;
        font-size: 1rem;
        border-bottom: 1px solid var(--gray-200);
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        color: var(--gray-600);
        font-weight: 600;
    }

    .info-value {
        color: var(--gray-900);
        font-weight: 700;
    }

    .map-preview {
        height: 170px;
        border-radius: var(--radius-sm);
        overflow: hidden;
        margin: 1.3rem 0;
        border: 2px solid var(--gray-200);
        box-shadow: var(--shadow-sm);
    }

    .panel-actions {
        display: flex;
        gap: 1.1rem;
        margin-top: 1.8rem;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: var(--success-light);
        color: var(--success);
        border-radius: var(--radius-sm);
        font-weight: 700;
        font-size: 0.9rem;
        border: 2px solid #a7f3d0;
    }

    .success-icon {
        font-size: 3.2rem;
        text-align: center;
        margin: 1rem 0;
        color: var(--success);
    }

    .spinner {
        width: 16px;
        height: 16px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-top-color: var(--white);
        border-radius: 50%;
        animation: spin 0.6s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* Modal Ubicación */
    .map-container {
        height: 300px;
        border-radius: var(--radius-sm);
        overflow: hidden;
        margin-top: 1rem;
        border: 1px solid var(--gray-200);
    }

    .coords-info {
        margin-top: 1.2rem;
        text-align: center;
        font-size: 0.95rem;
        font-weight: 600;
        color: var(--gray-600);
    }

    /* Footer */
    .footer {
        background: #1e293b;
        color: #94a3b8;
        padding: 2rem 1.5rem 1rem;
        margin-top: auto;
        width: 100%;
        border-top: 1px solid var(--gray-200);
    }

    .footer-content {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 2rem;
    }

    .footer-section h3 {
        font-size: 1.1rem;
        font-weight: 800;
        color: #ffffff;
        margin-bottom: 1rem;
    }

    .footer-section p,
    .footer-section a {
        color: var(--gray-700);
        text-decoration: none;
        font-weight: 500;
        line-height: 1.6;
        transition: color 0.2s;
        font-size: 0.95rem;
    }

    .footer-section a:hover {
        color: var(--primary);
    }

    .footer-section ul {
        list-style: none;
        padding: 0;
    }

    .footer-section li {
        margin: 0.6rem 0;
    }

    .footer-bottom {
        text-align: center;
        padding-top: 1.5rem;
        margin-top: 1.5rem;
        font-size: 0.95rem;
        color: var(--gray-600);
        border-top: 1px solid var(--gray-200);
        font-weight: 500;
    }

    @media (max-width: 768px) {
        .header {
            flex-direction: column;
            gap: 1rem;
        }
        .menu {
            flex-direction: column;
            gap: 0.7rem;
        }
        .welcome-card {
            flex-direction: column;
        }
        .page-header {
            flex-direction: column;
            align-items: stretch;
        }
        .btn-group {
            flex-direction: column;
        }
        .cards {
            grid-template-columns: 1fr;
        }
        .panel-actions {
            flex-direction: column;
        }
    }
</style>

<!-- Menú Horizontal Mejorado -->
<div class="menu-container">
    <div class="menu">
        <a href="{{ route('dashboard') }}" class="menu-item active">
            <span>📊</span> Dashboard
        </a>
        <a href="{{ route('emergencia.nueva') }}" class="menu-item">
            <span>📝</span> Reportar
        </a>
        <a href="{{ route('mis.emergencias') }}" class="menu-item">
            <span>📋</span> Historial
        </a>
        <a href="#" id="btn-map" class="menu-item">
            <span>🗺️</span> Ubicación
        </a>
        <a href="{{ route('paciente.perfil') }}" class="menu-item {{ request()->routeIs('paciente.perfil') ? 'active' : '' }}">
            <span>🩺</span> Mi Perfil 
        </a>
    </div>
</div>

<div class="main-content">
    <div class="welcome-card">
        <div class="welcome-icon">👋</div>
        <div class="welcome-text">
            <h2>¡Hola, {{ Auth::user()->name ?? 'Usuario' }}!</h2>
            <p class="welcome-body">
                Este es tu <strong>Dashboard de Emergencias</strong>. Aquí puedes:
            </p>
            <ul class="welcome-list">
                <li>📊 Reportar una emergencia con un solo clic</li>
                <li>📈 Ver estadísticas de tus reportes</li>
                <li>📁 Revisar tu historial completo</li>
                <li>📍 Ver tu ubicación en tiempo real</li>
            </ul>
        </div>
    </div>

    <div class="page-header">
        <h1 class="page-title">Dashboard de Emergencias</h1>
        <div class="btn-group">
            <button id="btn-emergency" class="btn btn-primary">
                <span>⚠️</span> Emergencia Rápida
            </button>
            <button class="btn btn-secondary" onclick="location.reload()">
                <span>🔄</span> Actualizar
            </button>
        </div>
    </div>

    <div class="cards">
        <div class="card card-today">
            <div class="card-title">Hoy</div>
            <div class="card-value">3</div>
            <div class="card-footer">+2 desde ayer</div>
        </div>
        <div class="card card-total">
            <div class="card-title">Total</div>
            <div class="card-value">27</div>
            <div class="card-footer">Este mes</div>
        </div>
    </div>
</div>

<!-- Panel de Emergencia -->
<div id="emergency-panel" class="emergency-panel">
    <div class="panel-content">
        <div class="panel-header">
            <h3 id="panel-title">🚨 Emergencia Rápida</h3>
            <p id="panel-subtitle">Confirma tu ubicación para enviar la alerta</p>
        </div>
        <div class="panel-body">
            <div class="step-indicator">
                <div class="step-dot active"></div>
                <div class="step-dot"></div>
                <div class="step-dot"></div>
            </div>

            <div id="step-2" class="step active">
                <div class="info-box">
                    <div class="info-row">
                        <span class="info-label">📍 Ubicación</span>
                        <span class="info-value" id="location-coords">Buscando GPS...</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">⏰ Hora</span>
                        <span class="info-value" id="current-time">{{ now()->format('H:i') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">👤 Usuario</span>
                        <span class="info-value">{{ Auth::user()->name ?? 'Usuario' }}</span>
                    </div>
                </div>
                <div id="map-preview" class="map-preview">
                    Cargando mapa...
                </div>
                <div class="panel-actions">
                    <button class="btn btn-secondary" onclick="App.closePanel()">Cancelar</button>
                    <button class="btn btn-primary" id="btn-confirm" disabled>
                        <span>🔍</span> Localizando...
                    </button>
                </div>
            </div>

            <div id="step-3" class="step">
                <div class="success-icon">✅</div>
                <div class="info-box">
                    <div class="info-row">
                        <span class="info-label">ID Emergencia</span>
                        <span class="info-value" id="emergency-id">#----</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Estado</span>
                        <span class="info-value">
                            <span class="status-badge">✓ Registrada</span>
                        </span>
                    </div>
                </div>
                <div class="panel-actions">
                    <button class="btn btn-secondary" onclick="App.closePanel()">Cerrar</button>
                    <button class="btn btn-primary" onclick="window.location.href='{{ route('mis.emergencias') }}'">Ver Historial</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ubicación -->
<div id="modal" class="modal">
    <div class="modal-content">
        <div class="panel-header" style="background: linear-gradient(135deg, #1f2937, #374151);">
            <h3>📍 Tu Ubicación</h3>
            <p>Haz clic fuera para cerrar</p>
        </div>
        <div class="panel-body">
            <div id="map" class="map-container"></div>
            <div id="coords" class="coords-info">Cargando ubicación...</div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
const App = {
    csrf: document.querySelector('meta[name="csrf-token"]')?.content,
    map: null,
    previewMap: null,
    currentPosition: null,
    isSubmitting: false,

    init() {
        const emergencyBtn = document.getElementById('btn-emergency');
        const mapBtn = document.getElementById('btn-map');
        const modal = document.getElementById('modal');
        const panel = document.getElementById('emergency-panel');

        if (emergencyBtn) {
            emergencyBtn.addEventListener('click', (e) => {
                e.preventDefault();
                this.sendEmergency();
            });
        }

        if (mapBtn) {
            mapBtn.addEventListener('click', (e) => {
                e.preventDefault();
                this.showMap();
            });
        }

        if (modal) {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) this.closeMapModal();
            });
        }

        if (panel) {
            panel.addEventListener('click', (e) => {
                if (e.target === panel) this.closePanel();
            });
        }
    },

    sendEmergency() {
        if (this.isSubmitting) return;
        this.isSubmitting = true;
        this.showPanel();
        this.setStep(2);

        if (!navigator.geolocation) {
            this.showErrorAndClose('Geolocalización no soportada en este dispositivo.');
            return;
        }

        const locationEl = document.getElementById('location-coords');
        const btn = document.getElementById('btn-confirm');
        if (locationEl) locationEl.textContent = 'Buscando con GPS...';
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<span>🔍</span> Localizando...';
        }

        const options = {
            enableHighAccuracy: true,
            timeout: 15000,
            maximumAge: 10000
        };

        navigator.geolocation.getCurrentPosition(
            (position) => this.onPositionSuccess(position),
            (error) => this.onPositionError(error),
            options
        );
    },

    onPositionSuccess(position) {
        const { latitude, longitude, accuracy } = position.coords;

        if (!this.isValidCoordinate(latitude, longitude)) {
            this.onPositionError({ code: 0, message: 'Coordenadas inválidas (0,0).' });
            return;
        }

        if (!this.isLocationInPeru(latitude, longitude)) {
            const confirmed = confirm(
                `⚠️ La ubicación detectada está FUERA DE PERÚ:\n` +
                `Lat: ${latitude.toFixed(6)}\nLng: ${longitude.toFixed(6)}\n\n` +
                `¿Estás realmente en esta ubicación?`
            );
            if (!confirmed) {
                this.closePanel();
                this.isSubmitting = false;
                return;
            }
        }

        if (accuracy > 500) {
            const confirmed = confirm(
                `⚠️ Precisión baja: ${Math.round(accuracy)} metros.\n` +
                `¿Enviar de todos modos?\n\n` +
                `Lat: ${latitude.toFixed(6)}, Lng: ${longitude.toFixed(6)}`
            );
            if (!confirmed) {
                this.closePanel();
                this.isSubmitting = false;
                return;
            }
        }

        this.currentPosition = position;
        document.getElementById('location-coords').textContent = `${latitude.toFixed(6)}, ${longitude.toFixed(6)} (${Math.round(accuracy)} m)`;
        document.getElementById('current-time').textContent = new Date().toLocaleTimeString('es-PE', {
            hour: '2-digit', minute: '2-digit'
        });

        this.showPreviewMap(latitude, longitude);

        const btn = document.getElementById('btn-confirm');
        if (btn) {
            btn.disabled = false;
            btn.innerHTML = '<span>✅</span> Confirmar Emergencia';
            btn.onclick = (e) => {
                e.preventDefault();
                this.confirmEmergency();
            };
        }
        this.isSubmitting = false;
    },

    onPositionError(error) {
        console.error('Error GPS:', error);
        let msg = 'No se pudo obtener tu ubicación.';
        if (error.code === 1) msg = 'Acceso denegado. Activa la ubicación y reintenta.';
        else if (error.code === 2) msg = 'Ubicación no disponible (GPS apagado o sin señal).';
        else if (error.code === 3) msg = 'Tiempo de espera agotado.';
        else msg = error.message || 'Error desconocido.';

        document.getElementById('location-coords').textContent = `❌ ${msg}`;
        const btn = document.getElementById('btn-confirm');
        if (btn) {
            btn.disabled = false;
            btn.innerHTML = '<span>🔄</span> Reintentar';
            btn.onclick = (e) => {
                e.preventDefault();
                this.retryLocation();
            };
        }
        this.isSubmitting = false;
    },

    retryLocation() {
        this.sendEmergency();
    },

    isValidCoordinate(lat, lng) {
        return (
            typeof lat === 'number' &&
            typeof lng === 'number' &&
            lat >= -90 && lat <= 90 &&
            lng >= -180 && lng <= 180 &&
            (Math.abs(lat) > 0.0001 || Math.abs(lng) > 0.0001)
        );
    },

    isLocationInPeru(lat, lng) {
        return (
            lat >= -18.5 && lat <= -0.1 &&
            lng >= -81.5 && lng <= -68.5
        );
    },

    async confirmEmergency() {
        if (this.isSubmitting || !this.currentPosition) return;
        this.isSubmitting = true;

        const btn = document.getElementById('btn-confirm');
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner" style="border-top-color:white;"></span> Enviando...';
        }

        try {
            const { latitude, longitude, accuracy } = this.currentPosition.coords;
            const response = await fetch("{{ route('emergencia.rapida') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": this.csrf
                },
                body: JSON.stringify({
                    lat: parseFloat(latitude.toFixed(6)),
                    lng: parseFloat(longitude.toFixed(6)),
                    accuracy: accuracy || null
                })
            });

            const data = await response.json();
            if (!response.ok) throw new Error(data.message || 'Error al registrar emergencia');

            document.getElementById('emergency-id').textContent = `#${data.id || '----'}`;
            document.getElementById('panel-title').textContent = '✅ ¡Emergencia Registrada!';
            document.getElementById('panel-subtitle').textContent = 'Tu alerta fue enviada con éxito';
            this.setStep(3);
        } catch (err) {
            alert('❌ Error al enviar emergencia. Inténtalo nuevamente.');
            console.error(err);
            this.closePanel();
        } finally {
            this.isSubmitting = false;
        }
    },

    showPreviewMap(lat, lng) {
        const el = document.getElementById('map-preview');
        if (this.previewMap) {
            this.previewMap.remove();
            this.previewMap = null;
        }

        el.textContent = '';

        this.previewMap = L.map(el, {
            zoomControl: false,
            dragging: false,
            scrollWheelZoom: false,
            doubleClickZoom: false,
            touchZoom: false,
            boxZoom: false,
            keyboard: false
        }).setView([lat, lng], 16);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(this.previewMap);

        L.marker([lat, lng]).addTo(this.previewMap);
    },

    setStep(stepNum) {
        document.querySelectorAll('.step').forEach(s => s.classList.remove('active'));
        document.querySelectorAll('.step-dot').forEach((d, i) => {
            d.classList.toggle('active', i === stepNum - 1);
        });
        const step = document.getElementById(`step-${stepNum}`);
        if (step) step.classList.add('active');
    },

    showPanel() {
        document.getElementById('emergency-panel').classList.add('active');
    },

    closePanel() {
        document.getElementById('emergency-panel').classList.remove('active');
        if (this.previewMap) {
            this.previewMap.remove();
            this.previewMap = null;
        }
        this.currentPosition = null;
        this.isSubmitting = false;
        const btn = document.getElementById('btn-confirm');
        if (btn) {
            btn.innerHTML = '<span>🔍</span> Localizando...';
            btn.disabled = true;
            btn.onclick = null;
        }
    },

    async showMap() {
        const modal = document.getElementById('modal');
        modal.classList.add('active');
        const coordsEl = document.getElementById('coords');
        coordsEl.textContent = 'Cargando ubicación...';

        try {
            const options = { enableHighAccuracy: true, timeout: 10000, maximumAge: 10000 };
            const position = await new Promise((resolve, reject) => {
                navigator.geolocation.getCurrentPosition(resolve, reject, options);
            });

            const { latitude, longitude } = position.coords;
            if (this.map) {
                this.map.remove();
                this.map = null;
            }

            this.map = L.map('map').setView([latitude, longitude], 15);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap'
            }).addTo(this.map);
            L.marker([latitude, longitude]).addTo(this.map).bindPopup('Tu ubicación').openPopup();
            coordsEl.textContent = `Coordenadas: ${latitude.toFixed(6)}, ${longitude.toFixed(6)}`;
        } catch (err) {
            coordsEl.textContent = '❌ No se pudo cargar la ubicación';
        }
    },

    closeMapModal() {
        document.getElementById('modal').classList.remove('active');
        if (this.map) {
            this.map.remove();
            this.map = null;
        }
    },

    showErrorAndClose(message) {
        alert(`❌ ${message}`);
        this.closePanel();
        this.isSubmitting = false;
    }
};

document.addEventListener('DOMContentLoaded', () => App.init());
</script>

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
@endsection