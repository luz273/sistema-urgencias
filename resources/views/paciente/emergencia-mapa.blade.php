@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary-red: #dc2626;
        --success-green: #059669;
        --warning-orange: #ea580c;
        --info-blue: #2563eb;
        --bg-light: #f8fafc;
        --text-primary: #1e293b;
        --text-secondary: #64748b;
        --border-color: #e2e8f0;
        --shadow-sm: 0 1px 3px rgba(0,0,0,0.1);
        --shadow-md: 0 4px 6px rgba(0,0,0,0.1);
        --shadow-lg: 0 10px 15px rgba(0,0,0,0.1);
        --dark-bg: #111827; /* Fondo de la sidebar */
        --white: #ffffff;
    }

    body {
        font-family: 'Inter', sans-serif;
        background: var(--bg-light);
        display: flex;
        height: 100vh;
        overflow-x: hidden;
    }

    /* Sidebar */
    .sidebar {
        width: 260px;
        background: var(--dark-bg);
        color: var(--white);
        padding: 1.5rem 1rem;
        box-shadow: 2px 0 8px rgba(0,0,0,0.1);
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        z-index: 100;
    }

    .sidebar-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 1.125rem;
        font-weight: 700;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }

    .sidebar-menu {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .sidebar-menu li {
        margin: 0.5rem 0;
    }

    .sidebar-menu a {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        color: #cbd5e1;
        text-decoration: none;
        border-radius: 8px;
        transition: all 0.2s;
        position: relative;
        font-weight: 500;
    }

    .sidebar-menu a:hover,
    .sidebar-menu a.active {
        background: rgba(220, 38, 38, 0.15);
        color: white;
    }

    .sidebar-menu a.active::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: var(--primary-red);
        border-top-right-radius: 4px;
        border-bottom-right-radius: 4px;
    }

    /* Main Content */
    .main-content {
        flex: 1;
        padding: 2rem 2rem 2rem 280px; /* Ajuste para sidebar */
        overflow-y: auto;
    }

    /* Estilos originales del dashboard de emergencia (mantenidos) */
    .emergency-detail-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem 1rem;
        animation: fadeIn 0.5s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .page-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .page-header h1 {
        color: var(--text-primary);
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .emergency-badge {
        background: linear-gradient(135deg, var(--primary-red), #991b1b);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 1rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: var(--shadow-md);
    }

    .content-grid {
        display: grid;
        grid-template-columns: 1fr 350px;
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .map-section {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-color);
    }

    .map-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .map-header h3 {
        color: var(--text-primary);
        font-size: 1.25rem;
        font-weight: 600;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .map-controls {
        display: flex;
        gap: 0.5rem;
    }

    .map-control-btn {
        background: var(--bg-light);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 0.5rem 0.75rem;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 0.875rem;
        color: var(--text-secondary);
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .map-control-btn:hover {
        background: white;
        border-color: var(--info-blue);
        color: var(--info-blue);
        transform: translateY(-2px);
        box-shadow: var(--shadow-sm);
    }

    #map {
        height: 500px;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
        position: relative;
    }

    .map-loading {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: white;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: var(--shadow-lg);
        z-index: 1000;
        text-align: center;
    }

    .loading-spinner {
        display: inline-block;
        width: 40px;
        height: 40px;
        border: 4px solid var(--border-color);
        border-radius: 50%;
        border-top-color: var(--primary-red);
        animation: spin 1s linear infinite;
        margin-bottom: 1rem;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    .info-panel {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .info-card {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-color);
    }

    .info-card-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid var(--bg-light);
    }

    .info-card-header .icon {
        font-size: 1.5rem;
    }

    .info-card-header h4 {
        margin: 0;
        color: var(--text-primary);
        font-size: 1.1rem;
        font-weight: 600;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: start;
        padding: 0.75rem 0;
        border-bottom: 1px solid var(--bg-light);
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-label {
        color: var(--text-secondary);
        font-size: 0.875rem;
        font-weight: 500;
    }

    .info-value {
        color: var(--text-primary);
        font-weight: 600;
        text-align: right;
        max-width: 60%;
    }

    .status-badge {
        padding: 0.375rem 0.75rem;
        border-radius: 50px;
        font-size: 0.875rem;
        font-weight: 600;
        display: inline-block;
    }

    .status-active {
        background: #fef3c7;
        color: #92400e;
        border: 1px solid #fbbf24;
    }

    .status-attended {
        background: #d1fae5;
        color: #065f46;
        border: 1px solid var(--success-green);
    }

    .status-closed {
        background: #e2e8f0;
        color: #475569;
        border: 1px solid #94a3b8;
    }

    .action-buttons {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .btn-custom {
        padding: 0.875rem 1.25rem;
        border-radius: 10px;
        font-weight: 600;
        text-decoration: none;
        text-align: center;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        border: none;
        cursor: pointer;
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, var(--info-blue), #1d4ed8);
        color: white;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
    }

    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(37, 99, 235, 0.4);
        color: white;
    }

    .btn-secondary-custom {
        background: white;
        color: var(--text-secondary);
        border: 2px solid var(--border-color);
    }

    .btn-secondary-custom:hover {
        border-color: var(--text-secondary);
        color: var(--text-primary);
        transform: translateY(-2px);
        box-shadow: var(--shadow-sm);
    }

    .btn-danger-custom {
        background: linear-gradient(135deg, var(--primary-red), #991b1b);
        color: white;
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
    }

    .btn-danger-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(220, 38, 38, 0.4);
        color: white;
    }

    .coordinates-display {
        background: var(--bg-light);
        padding: 1rem;
        border-radius: 8px;
        font-family: 'Courier New', monospace;
        font-size: 0.875rem;
        color: var(--text-primary);
        margin-top: 1rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .copy-btn {
        background: white;
        border: 1px solid var(--border-color);
        border-radius: 6px;
        padding: 0.375rem 0.75rem;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 0.875rem;
    }

    .copy-btn:hover {
        background: var(--info-blue);
        color: white;
        border-color: var(--info-blue);
    }

    .alert-info {
        background: #dbeafe;
        border: 1px solid var(--info-blue);
        border-radius: 10px;
        padding: 1rem;
        color: #1e40af;
        display: flex;
        align-items: start;
        gap: 0.75rem;
    }

    .alert-info .icon {
        font-size: 1.25rem;
        margin-top: 0.125rem;
    }

    /* Estilos personalizados para el marcador del mapa */
    .custom-marker-icon {
        background: var(--primary-red);
        border: 3px solid white;
        border-radius: 50% 50% 50% 0;
        width: 40px;
        height: 40px;
        transform: rotate(-45deg);
        box-shadow: 0 4px 8px rgba(0,0,0,0.3);
    }

    @media (max-width: 968px) {
        .content-grid {
            grid-template-columns: 1fr;
        }

        .page-header h1 {
            font-size: 1.5rem;
        }

        #map {
            height: 400px;
        }

        .map-controls {
            flex-direction: column;
        }

        .map-control-btn {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 768px) {
        .sidebar { display: none; }
        .main-content { padding: 2rem; }
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

<style>
    .menu-container {
        background-color: #faf8f8ff; /* Fondo suave (blanco grisáceo) */
        padding: 16px 0;
        box-shadow: 0 2px 6px rgba(243, 32, 32, 0.05);
        margin: 0 auto;
        width: 100%;
    }

    .menu {
        display: flex;
        justify-content: center; /* Centrado */
        gap: 24px;
        flex-wrap: wrap;
        max-width: 900px;
        margin: 0 auto;
        padding: 0 16px;
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
        background-color: #ffebee; /* Rosa claro */
        color: #d32f2f; /* Rojo intenso */
        font-weight: 600;
    }

    .menu-item span {
        font-size: 18px;
    }
</style>


<!-- Main Content -->
<div class="main-content">
    <!-- Header -->
    <div class="page-header">
        <h1>
            <span>🗺️</span>
            Ubicación de Emergencia
            <span class="emergency-badge">
                <span>⚠️</span>
                ID #{{ $emergencia->id }}
            </span>
        </h1>
    </div>

    <!-- Grid Principal -->
    <div class="content-grid">
        <!-- Sección del Mapa -->
        <div class="map-section">
            <div class="map-header">
                <h3>
                    <span>📍</span>
                    Ubicación en Mapa
                </h3>
                <div class="map-controls">
                    <button class="map-control-btn" onclick="zoomIn()">
                        🔍 Acercar
                    </button>
                    <button class="map-control-btn" onclick="centerMap()">
                        🎯 Centrar
                    </button>
                    <button class="map-control-btn" onclick="openInGoogleMaps()">
                        🌐 Google Maps
                    </button>
                </div>
            </div>

            <div id="map">
                <div class="map-loading">
                    <div class="loading-spinner"></div>
                    <p>Cargando mapa...</p>
                </div>
            </div>

            <div class="coordinates-display">
                <div>
                    <strong>📐 Coordenadas:</strong><br>
                    <span id="coords-text">{{ $emergencia->latitud }}, {{ $emergencia->longitud }}</span>
                </div>
                <button class="copy-btn" onclick="copyCoordinates()">
                    📋 Copiar
                </button>
            </div>
        </div>

        <!-- Panel de Información -->
        <div class="info-panel">
            <!-- Detalles de la Emergencia -->
            <div class="info-card">
                <div class="info-card-header">
                    <span class="icon">📊</span>
                    <h4>Detalles de la Emergencia</h4>
                </div>

                <div class="info-item">
                    <span class="info-label">Estado</span>
                    <span class="info-value">
                        <span class="status-badge status-{{ strtolower($emergencia->estado ?? 'active') }}">
                            {{ ucfirst($emergencia->estado ?? 'Activa') }}
                        </span>
                    </span>
                </div>

                <div class="info-item">
                    <span class="info-label">Fecha y Hora</span>
                    <span class="info-value">
                        {{ \Carbon\Carbon::parse($emergencia->created_at)->format('d/m/Y H:i') }}
                    </span>
                </div>

                @if($emergencia->tipo)
                <div class="info-item">
                    <span class="info-label">Tipo</span>
                    <span class="info-value">{{ $emergencia->tipo }}</span>
                </div>
                @endif

                @if($emergencia->descripcion)
                <div class="info-item">
                    <span class="info-label">Descripción</span>
                    <span class="info-value">{{ $emergencia->descripcion }}</span>
                </div>
                @endif

                <div class="info-item">
                    <span class="info-label">Latitud</span>
                    <span class="info-value">{{ $emergencia->latitud }}</span>
                </div>

                <div class="info-item">
                    <span class="info-label">Longitud</span>
                    <span class="info-value">{{ $emergencia->longitud }}</span>
                </div>
            </div>

            <!-- Información Adicional -->
            @if($emergencia->contacto || $emergencia->telefono)
            <div class="info-card">
                <div class="info-card-header">
                    <span class="icon">📞</span>
                    <h4>Información de Contacto</h4>
                </div>

                @if($emergencia->contacto)
                <div class="info-item">
                    <span class="info-label">Contacto</span>
                    <span class="info-value">{{ $emergencia->contacto }}</span>
                </div>
                @endif

                @if($emergencia->telefono)
                <div class="info-item">
                    <span class="info-label">Teléfono</span>
                    <span class="info-value">{{ $emergencia->telefono }}</span>
                </div>
                @endif
            </div>
            @endif

            <!-- Botones de Acción -->
            <div class="info-card">
                <div class="info-card-header">
                    <span class="icon">⚡</span>
                    <h4>Acciones Rápidas</h4>
                </div>

                <div class="action-buttons">
                    <button class="btn-custom btn-primary-custom" onclick="shareLocation()">
                        <span>📤</span>
                        Compartir Ubicación
                    </button>

                    <button class="btn-custom btn-danger-custom" onclick="callEmergency()">
                        <span>📞</span>
                        Llamar a Emergencias
                    </button>

                    <a href="{{ route('mis.emergencias') }}" class="btn-custom btn-secondary-custom">
                        <span>←</span>
                        Volver a Mis Emergencias
                    </a>
                </div>
            </div>

            <!-- Alerta Informativa -->
            <div class="alert-info">
                <span class="icon">ℹ️</span>
                <div>
                    <strong>Información importante:</strong><br>
                    La ubicación mostrada corresponde al momento en que se registró la emergencia. La precisión puede variar según el dispositivo utilizado.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
class EmergencyMapViewer {
    constructor() {
        this.lat = parseFloat('{{ $emergencia->latitud }}');
        this.lng = parseFloat('{{ $emergencia->longitud }}');
        this.emergencyId = '{{ $emergencia->id }}';
        this.map = null;
        this.marker = null;
        this.init();
    }

    init() {
        this.initializeMap();
    }

    initializeMap() {
        // Ocultar loading
        setTimeout(() => {
            const loading = document.querySelector('.map-loading');
            if (loading) loading.remove();
        }, 500);

        // Crear mapa
        this.map = L.map('map').setView([this.lat, this.lng], 16);

        // Añadir capa de tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            maxZoom: 19,
            minZoom: 3
        }).addTo(this.map);

        // Crear icono personalizado
        const customIcon = L.divIcon({
            className: 'custom-marker',
            html: `
                <div style="position: relative;">
                    <div style="
                        background: linear-gradient(135deg, #dc2626, #991b1b);
                        width: 40px;
                        height: 40px;
                        border-radius: 50% 50% 50% 0;
                        transform: rotate(-45deg);
                        border: 3px solid white;
                        box-shadow: 0 4px 8px rgba(0,0,0,0.3);
                        display: flex;
                        align-items: center;
                        justify-content: center;
                    ">
                        <span style="transform: rotate(45deg); font-size: 20px;">⚠️</span>
                    </div>
                    <div style="
                        position: absolute;
                        bottom: -5px;
                        left: 50%;
                        transform: translateX(-50%);
                        width: 0;
                        height: 0;
                        border-left: 8px solid transparent;
                        border-right: 8px solid transparent;
                        border-top: 12px solid #991b1b;
                    "></div>
                </div>
            `,
            iconSize: [40, 40],
            iconAnchor: [20, 40],
            popupAnchor: [0, -40]
        });

        // Añadir marcador
        this.marker = L.marker([this.lat, this.lng], { icon: customIcon })
            .addTo(this.map)
            .bindPopup(`
                <div style="text-align: center; padding: 8px;">
                    <strong style="color: #dc2626; font-size: 16px;">⚠️ Emergencia #${this.emergencyId}</strong><br>
                    <span style="color: #64748b; font-size: 14px;">
                        ${this.lat.toFixed(6)}, ${this.lng.toFixed(6)}
                    </span><br>
                    <button onclick="openInGoogleMaps()" style="
                        margin-top: 8px;
                        padding: 6px 12px;
                        background: #2563eb;
                        color: white;
                        border: none;
                        border-radius: 6px;
                        cursor: pointer;
                        font-size: 12px;
                    ">
                        🌐 Abrir en Google Maps
                    </button>
                </div>
            `, {
                maxWidth: 300
            })
            .openPopup();

        // Añadir círculo de área
        L.circle([this.lat, this.lng], {
            color: '#dc2626',
            fillColor: '#ef4444',
            fillOpacity: 0.15,
            radius: 100
        }).addTo(this.map);

        // Ajustar vista para incluir el marcador y el círculo
        const bounds = L.latLngBounds([
            [this.lat - 0.002, this.lng - 0.002],
            [this.lat + 0.002, this.lng + 0.002]
        ]);
        this.map.fitBounds(bounds);
    }

    zoomIn() {
        this.map.setZoom(this.map.getZoom() + 1);
    }

    centerMap() {
        this.map.setView([this.lat, this.lng], 16);
        this.marker.openPopup();
    }

    openInGoogleMaps() {
        const url = `https://www.google.com/maps?q=  ${this.lat},${this.lng}`;
        window.open(url, '_blank');
    }

    copyCoordinates() {
        const coords = `${this.lat}, ${this.lng}`;
        navigator.clipboard.writeText(coords).then(() => {
            this.showNotification('✅ Coordenadas copiadas al portapapeles', 'success');
        }).catch(() => {
            this.showNotification('❌ Error al copiar las coordenadas', 'error');
        });
    }

    shareLocation() {
        const shareData = {
            title: `Emergencia #${this.emergencyId}`,
            text: `Ubicación de emergencia: ${this.lat}, ${this.lng}`,
            url: window.location.href
        };

        if (navigator.share) {
            navigator.share(shareData).catch(() => {});
        } else {
            // Fallback: copiar URL
            navigator.clipboard.writeText(window.location.href).then(() => {
                this.showNotification('✅ Enlace copiado al portapapeles', 'success');
            });
        }
    }

    callEmergency() {
        // Número de emergencias (ajustar según país)
        const emergencyNumber = '911'; // o '105' para Perú
        if (confirm(`¿Deseas llamar al ${emergencyNumber}?`)) {
            window.location.href = `tel:${emergencyNumber}`;
        }
    }

    showNotification(message, type) {
        const notification = document.createElement('div');
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: ${type === 'success' ? '#059669' : '#dc2626'};
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            z-index: 10000;
            animation: slideInRight 0.3s ease;
        `;
        notification.textContent = message;
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.style.animation = 'slideOutRight 0.3s ease';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
}

// Inicializar
let mapViewer;
document.addEventListener('DOMContentLoaded', () => {
    mapViewer = new EmergencyMapViewer();
});

// Funciones globales
function zoomIn() {
    mapViewer.zoomIn();
}

function centerMap() {
    mapViewer.centerMap();
}

function openInGoogleMaps() {
    mapViewer.openInGoogleMaps();
}

function copyCoordinates() {
    mapViewer.copyCoordinates();
}

function shareLocation() {
    mapViewer.shareLocation();
}

function callEmergency() {
    mapViewer.callEmergency();
}

// Animaciones CSS
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(400px);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);
</script>
@endsection