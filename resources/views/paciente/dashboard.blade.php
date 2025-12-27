@extends('layouts.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    :root {
        --primary: #dc2626;
        --primary-dark: #b91c1c;
        --success: #0d9488;
        --gray-50: #f9fafb;
        --gray-100: #f3f4f6;
        --gray-200: #e5e7eb;
        --gray-300: #d1d5db;
        --gray-600: #4b5563;
        --gray-800: #1f2937;
        --gray-900: #111827;
        --white: #ffffff;
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
        background-color: var(--gray-50);
        color: var(--gray-900);
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        overflow-x: hidden;
    }

    /* Header Horizontal */
    .header {
        width: 100%;
        background: var(--white);
        padding: 0.75rem 1.5rem;
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
        gap: 1rem;
    }

    .logo-icon {
        width: 48px;
        height: 48px;
        background: var(--primary);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        font-size: 1.5rem;
        position: relative;
    }

    .logo-icon::before {
        content: '';
        position: absolute;
        width: 24px;
        height: 24px;
        background: var(--white);
        border-radius: 4px;
        left: 8px;
        top: 12px;
    }

    .logo-icon::after {
        content: '+';
        position: absolute;
        color: var(--primary);
        font-weight: 700;
        font-size: 1rem;
        left: 14px;
        top: 16px;
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

    .user-dropdown {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: var(--radius-sm);
        background: var(--gray-100);
        font-weight: 500;
        color: var(--gray-900);
        cursor: pointer;
        transition: background 0.2s;
    }

    .user-dropdown:hover {
        background: var(--gray-200);
    }

    .user-dropdown svg {
        width: 16px;
        height: 16px;
        fill: currentColor;
    }

    /* Menú Horizontal Centrado */
    .menu-container {
        background-color: #faf8f8ff;
        padding: 16px 0;
        box-shadow: 0 2px 6px rgba(211, 47, 47, 0.05);
        width: 100%;
    }

    .menu {
        display: flex;
        justify-content: center;
        gap: 24px;
        flex-wrap: wrap;
        max-width: 900px;
        margin: 0 auto;
        padding: 0 16px;
        list-style: none;
    }

    .menu-item {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        text-decoration: none;
        color: #555;
        font-size: 15px;
        font-weight: 500;
        border-radius: 10px;
        transition: all 0.25s ease;
        background-color: transparent;
    }

    .menu-item:hover {
        background-color: #f0f0f0;
        color: #333;
    }

    .menu-item.active {
        background-color: #ffebee;
        color: #d32f2f;
        font-weight: 600;
    }

    .menu-item span {
        font-size: 18px;
    }

    /* Contenido principal */
    .main-content {
        padding: 24px;
        max-width: 1000px;
        margin: 0 auto;
        flex: 1;
    }

    /* Bienvenida */
    .welcome-card {
        display: flex;
        gap: 20px;
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.06);
        margin-bottom: 32px;
        align-items: flex-start;
        border-left: 4px solid #d32f2f;
    }

    .welcome-icon {
        font-size: 32px;
        flex-shrink: 0;
    }

    .welcome-text h2 {
        margin: 0 0 12px;
        font-size: 24px;
        color: #333;
    }

    .welcome-body {
        margin: 0 0 16px;
        color: #666;
        line-height: 1.5;
    }

    .welcome-list {
        padding-left: 20px;
        margin: 0;
        color: #555;
        line-height: 1.6;
    }

    .welcome-list li {
        margin-bottom: 8px;
    }

    /* Encabezado de página */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .page-title {
        font-size: 28px;
        font-weight: 700;
        color: #333;
        margin: 0;
    }

    .btn-group {
        display: flex;
        gap: 12px;
    }

    .btn {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 12px 20px;
        border: none;
        border-radius: 10px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    .btn-primary {
        background-color: #d32f2f;
        color: white;
    }

    .btn-primary:hover {
        background-color: #b71c1c;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(211, 47, 47, 0.3);
    }

    .btn-secondary {
        background-color: #f5f5f5;
        color: #555;
    }

    .btn-secondary:hover {
        background-color: #e0e0e0;
        transform: translateY(-2px);
    }

    /* Tarjetas de estadísticas */
    .cards {
        display: flex;
        gap: 24px;
        margin-bottom: 32px;
        flex-wrap: wrap;
    }

    .card {
        flex: 1;
        min-width: 200px;
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.06);
        text-align: center;
        transition: transform 0.2s;
    }

    .card:hover {
        transform: translateY(-4px);
    }

    .card-header {
        margin-bottom: 12px;
    }

    .card-title {
        font-size: 14px;
        font-weight: 700;
        color: #666;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .card-value {
        font-size: 40px;
        font-weight: 800;
        color: #333;
        margin: 8px 0;
    }

    .card-footer {
        font-size: 14px;
        color: #888;
        font-weight: 500;
    }

    .card-today .card-value {
        color: #d32f2f;
    }

    .card-total .card-value {
        color: #1976d2;
    }

    /* Panel de Emergencia */
    .emergency-panel,
    .modal {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(6px);
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
    }

    .panel-header {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        padding: 1.75rem;
        text-align: center;
    }

    .panel-header h3 {
        font-size: 1.375rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }

    .panel-header p {
        opacity: 0.9;
        font-size: 0.875rem;
    }

    .panel-body {
        padding: 2rem;
    }

    .step { display: none; }
    .step.active { display: block; animation: fadeStep 0.3s ease; }

    @keyframes fadeStep {
        from { opacity: 0; transform: translateY(8px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .step-indicator {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        margin-bottom: 2rem;
    }

    .step-dot {
        width: 6px;
        height: 6px;
        background: var(--gray-300);
        border-radius: 50%;
        transition: var(--transition);
    }

    .step-dot.active {
        background: var(--primary);
        width: 20px;
        border-radius: 3px;
    }

    .info-box {
        background: var(--gray-50);
        border-radius: var(--radius-sm);
        padding: 1.25rem;
        margin-bottom: 1.5rem;
        border: 1px solid var(--gray-200);
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        padding: 0.5rem 0;
        font-size: 0.875rem;
    }

    .info-label { color: var(--gray-600); font-weight: 600; }
    .info-value { color: var(--gray-900); font-weight: 600; }

    .map-preview {
        height: 180px;
        border-radius: var(--radius-sm);
        overflow: hidden;
        margin: 1.25rem 0;
        border: 1px solid var(--gray-200);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #888;
        font-size: 0.875rem;
        background: #fafafa;
        position: relative;
    }

    .panel-actions {
        display: flex;
        gap: 1rem;
        margin-top: 1.75rem;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.375rem 0.875rem;
        background: #ecfdf5;
        color: var(--success);
        border-radius: var(--radius-sm);
        font-weight: 600;
        font-size: 0.875rem;
        border: 1px solid #a7f3d0;
    }

    .spinner {
        width: 16px;
        height: 16px;
        border: 2px solid rgba(0,0,0,0.1);
        border-top-color: currentColor;
        border-radius: 50%;
        animation: spin 0.6s linear infinite;
    }

    @keyframes spin { to { transform: rotate(360deg); } }

    .loading-spinner {
        text-align: center;
        padding: 2rem 0;
    }

    .success-icon {
        font-size: 3.5rem;
        text-align: center;
        margin: 1rem 0;
        color: var(--success);
    }

    /* Modal Ubicación */
    .map-container {
        height: 350px;
        border-radius: var(--radius-sm);
        overflow: hidden;
        margin-top: 1rem;
        border: 1px solid var(--gray-200);
        position: relative;
    }

    .coords-info {
        margin-top: 1.25rem;
        padding: 0.875rem;
        background: var(--gray-50);
        border-radius: var(--radius-sm);
        text-align: center;
        font-size: 0.875rem;
        font-weight: 500;
    }

    /* Footer */
    .footer {
        width: 100%;
        background: #f0f7ff;
        color: var(--gray-900);
        padding: 2rem 2rem 1rem;
        margin-top: auto;
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
        font-size: 0.875rem;
    }

    .footer-section a {
        color: var(--gray-600);
        text-decoration: none;
    }

    .footer-section a:hover {
        color: var(--primary);
        text-decoration: underline;
    }

    .footer-bottom {
        text-align: center;
        padding-top: 1rem;
        font-size: 0.875rem;
        color: var(--gray-600);
        border-top: 1px solid var(--gray-200);
        margin-top: 1.5rem;
    }

    @media (max-width: 768px) {
        .header { flex-direction: column; align-items: stretch; gap: 1rem; }
        .logo-container { width: 100%; justify-content: space-between; }
        .menu { flex-direction: column; gap: 0.5rem; }
        .welcome-card { flex-direction: column; gap: 0.5rem; }
        .page-header { flex-direction: column; align-items: stretch; }
        .btn-group { width: 100%; }
        .btn { width: 100%; justify-content: center; }
        .cards { grid-template-columns: 1fr; }
        .panel-actions { flex-direction: column; }
        .panel-content, .modal-content { width: 95%; }
        .footer-content { gap: 1rem; }
    }
</style>

<!-- Menú Horizontal Mejorado -->
<div class="menu-container">
    <div class="menu">
        <a href="#" class="menu-item active">
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
            <span>🩺</span> Mi Perfil Médico
        </a>
    </div>
</div>

<div class="main-content">
    <div class="welcome-card">
        <div class="welcome-icon">👋</div>
        <div class="welcome-text">
            <h2 class="welcome-title">¡Hola, {{ Auth::user()->name ?? 'Usuario' }}!</h2>
            <p class="welcome-body">
                Este es tu <strong>Dashboard de Emergencias</strong>. Aquí puedes:
            </p>
            <ul class="welcome-list">
                <li>📊 Reportar una emergencia con un solo clic (usando tu ubicación actual)</li>
                <li>📈 Ver cuántas emergencias se han registrado hoy y este mes</li>
                <li>📁 Revisar tu historial de reportes</li>
                <li>📍 Ver tu ubicación exacta en el mapa</li>
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
            <div class="card-header">
                <span class="card-title">HOY</span>
            </div>
            <div class="card-value">3</div>
            <div class="card-footer">+2 desde ayer</div>
        </div>
        <div class="card card-total">
            <div class="card-header">
                <span class="card-title">TOTAL</span>
            </div>
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
                        <span class="info-value" id="location-coords">Buscando con GPS de alta precisión…</span>
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
                    Cargando mapa de ubicación…
                </div>
                <div class="panel-actions">
                    <button class="btn btn-secondary" onclick="App.closePanel()">Cancelar</button>
                    <button class="btn btn-primary" id="btn-confirm" disabled>
                        <span>🔍</span> Localizando…
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
                    <div class="info-row">
                        <span class="info-label">Ubicación</span>
                        <span class="info-value" id="final-coords">--</span>
                    </div>
                </div>
                <div class="panel-actions">
                    <button class="btn btn-secondary" onclick="App.closePanel()">Cerrar</button>
                    <button class="btn btn-primary" onclick="window.location.href='{{ route('mis.emergencias') }}'">
                        Ver Historial
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ubicación -->
<div id="modal" class="modal">
    <div class="modal-content">
        <div class="panel-header" style="background: #1f2937;">
            <h3>📍 Tu Ubicación</h3>
            <p>Haz clic fuera para cerrar</p>
        </div>
        <div class="panel-body">
            <div id="map" class="map-container"></div>
            <div id="coords" class="coords-info">Cargando...</div>
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
        const confirmBtn = document.getElementById('btn-confirm');
        const mapBtn = document.getElementById('btn-map');
        const modal = document.getElementById('modal');
        const panel = document.getElementById('emergency-panel');

        if (emergencyBtn) {
            emergencyBtn.addEventListener('click', (e) => {
                e.preventDefault();
                this.sendEmergency();
            });
        }

        if (confirmBtn) {
            confirmBtn.addEventListener('click', (e) => {
                e.preventDefault();
                this.confirmEmergency();
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

        document.getElementById('location-coords').textContent = 'Buscando con GPS de alta precisión…';
        const btn = document.getElementById('btn-confirm');
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<span>🔍</span> Localizando…';
        }

        const options = {
            enableHighAccuracy: true,
            timeout: 15000,
            maximumAge: 10000
        };

        navigator.geolocation.getCurrentPosition(
            (position) => this.onPositionSuccess(position, btn),
            (error) => this.onPositionError(error, btn),
            options
        );
    },

    onPositionSuccess(position, btn) {
        const { latitude, longitude, accuracy } = position.coords;

        if (!this.isValidCoordinate(latitude, longitude)) {
            this.onPositionError({ message: 'Coordenadas inválidas (0,0).' }, btn);
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

        if (btn) {
            btn.disabled = false;
            btn.innerHTML = '<span>✅</span> Confirmar Emergencia';
        }
        this.isSubmitting = false;
    },

    onPositionError(error, btn) {
        console.error('Error GPS:', error);
        let msg = 'No se pudo obtener tu ubicación.';
        if (error.code === 1) msg = 'Acceso denegado. Activa la ubicación y reintenta.';
        else if (error.code === 2) msg = 'Ubicación no disponible (GPS apagado o sin señal).';
        else if (error.code === 3) msg = 'Tiempo de espera agotado.';
        else msg = error.message || 'Error desconocido.';

        document.getElementById('location-coords').textContent = `❌ ${msg}`;
        if (btn) {
            btn.disabled = false;
            btn.innerHTML = '<span>🔄</span> Reintentar';
            btn.onclick = () => this.retryLocation();
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
        const btn = document.getElementById('btn-confirm');
        if (!btn || btn.disabled || !this.currentPosition) return;

        btn.disabled = true;
        btn.innerHTML = '<span class="spinner" style="border-top-color:white;"></span> Enviando...';

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
            document.getElementById('final-coords').textContent = `${latitude.toFixed(6)}, ${longitude.toFixed(6)}`;
            document.getElementById('panel-title').textContent = '✅ ¡Emergencia Registrada!';
            document.getElementById('panel-subtitle').textContent = 'Tu alerta fue enviada con éxito';
            this.setStep(3);
        } catch (err) {
            alert('❌ Error al enviar emergencia. Inténtalo nuevamente.');
            console.error(err);
            this.closePanel();
        } finally {
            btn.disabled = false;
            btn.textContent = 'Confirmar Emergencia';
        }
    },

    showPreviewMap(lat, lng) {
        const el = document.getElementById('map-preview');
        if (this.previewMap) this.previewMap.remove();

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
            d.classList.toggle('active', i < stepNum);
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
            if (this.map) this.map.remove();

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