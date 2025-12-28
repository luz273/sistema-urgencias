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
    }

    .emergency-list-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 2rem 1rem;
        animation: fadeIn 0.5s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .page-title {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .page-title h1 {
        color: var(--text-primary);
        font-size: 2rem;
        font-weight: 700;
        margin: 0;
    }

    .page-title .count-badge {
        background: linear-gradient(135deg, var(--primary-red), #991b1b);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 1rem;
        font-weight: 600;
        box-shadow: var(--shadow-md);
    }

    .header-actions {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .btn-custom {
        padding: 0.75rem 1.25rem;
        border-radius: 10px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border: none;
        cursor: pointer;
        font-size: 0.95rem;
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, var(--primary-red), #991b1b);
        color: white;
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
    }

    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(220, 38, 38, 0.4);
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

    .filters-section {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-color);
    }

    .filters-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        align-items: end;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .filter-label {
        font-weight: 600;
        color: var(--text-primary);
        font-size: 0.875rem;
    }

    .filter-select {
        padding: 0.75rem 1rem;
        border: 2px solid var(--border-color);
        border-radius: 8px;
        font-size: 0.95rem;
        background: white;
        color: var(--text-primary);
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .filter-select:focus {
        outline: none;
        border-color: var(--info-blue);
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 16px;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-color);
    }

    .empty-state-icon {
        font-size: 5rem;
        opacity: 0.3;
        margin-bottom: 1rem;
    }

    .empty-state h3 {
        color: var(--text-primary);
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: var(--text-secondary);
        font-size: 1.1rem;
        margin-bottom: 2rem;
    }

    .emergency-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
        gap: 1.5rem;
    }

    .emergency-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
        position: relative;
        animation: slideUp 0.5s ease;
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .emergency-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
    }

    .card-header-custom {
        padding: 1.25rem;
        background: linear-gradient(135deg, #f8fafc, #e2e8f0);
        border-bottom: 2px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: start;
    }

    .card-id {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .card-id-label {
        font-size: 0.75rem;
        color: var(--text-secondary);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .card-id-number {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-primary);
        font-family: 'Courier New', monospace;
    }

    .card-badges {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        align-items: end;
    }

    .badge-custom {
        padding: 0.375rem 0.875rem;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        white-space: nowrap;
    }

    .badge-severity-leve {
        background: #d1fae5;
        color: #065f46;
        border: 1.5px solid #10b981;
    }

    .badge-severity-moderado {
        background: #fef3c7;
        color: #92400e;
        border: 1.5px solid #f59e0b;
    }

    .badge-severity-critico {
        background: #fee2e2;
        color: #991b1b;
        border: 1.5px solid var(--primary-red);
    }

    .badge-status-pendiente {
        background: #e0e7ff;
        color: #3730a3;
        border: 1.5px solid #6366f1;
    }

    .badge-status-atendida {
        background: #d1fae5;
        color: #065f46;
        border: 1.5px solid var(--success-green);
    }

    .badge-status-cerrada {
        background: #e2e8f0;
        color: #475569;
        border: 1.5px solid #94a3b8;
    }

    .card-body-custom {
        padding: 1.25rem;
    }

    .card-type {
        color: var(--text-primary);
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .card-description {
        color: var(--text-secondary);
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 1rem;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .card-location {
        background: var(--bg-light);
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1rem;
    }

    .location-title {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.375rem;
    }

    .location-coords {
        font-family: 'Courier New', monospace;
        font-size: 0.875rem;
        color: var(--text-secondary);
        line-height: 1.5;
    }

    .card-media {
        margin-bottom: 1rem;
        border-radius: 8px;
        overflow: hidden;
        border: 2px solid var(--border-color);
        position: relative;
        background: #000;
    }

    .media-label {
        position: absolute;
        top: 0.5rem;
        left: 0.5rem;
        background: rgba(0, 0, 0, 0.7);
        color: white;
        padding: 0.375rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        z-index: 10;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .card-media img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        display: block;
    }

    .card-media video {
        width: 100%;
        height: 200px;
        display: block;
    }

    .card-media audio {
        width: 100%;
        display: block;
        background: white;
        padding: 0.5rem;
    }

    .media-download {
        background: white;
        padding: 1rem;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
    }

    .media-download-icon {
        font-size: 2rem;
    }

    .media-download-link {
        color: var(--info-blue);
        text-decoration: none;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .media-download-link:hover {
        text-decoration: underline;
    }

    .card-footer-custom {
        padding: 1rem 1.25rem;
        background: var(--bg-light);
        border-top: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
    }

    .card-timestamp {
        display: flex;
        align-items: center;
        gap: 0.375rem;
        color: var(--text-secondary);
        font-size: 0.875rem;
    }

    .card-actions {
        display: flex;
        gap: 0.5rem;
    }

    .btn-icon {
        padding: 0.5rem;
        border-radius: 8px;
        background: white;
        border: 1px solid var(--border-color);
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-secondary);
        text-decoration: none;
    }

    .btn-icon:hover {
        transform: scale(1.1);
        border-color: var(--info-blue);
        color: var(--info-blue);
        background: #eff6ff;
    }

    .stats-section {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-color);
        text-align: center;
    }

    .stat-icon {
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
    }

    .stat-label {
        font-size: 0.875rem;
        color: var(--text-secondary);
        font-weight: 600;
    }

    /* Modal de imagen */
    .image-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.9);
        z-index: 10000;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        animation: fadeIn 0.3s ease;
    }

    .image-modal.active {
        display: flex;
    }

    .image-modal img {
        max-width: 90%;
        max-height: 90%;
        border-radius: 8px;
        box-shadow: 0 25px 50px rgba(0,0,0,0.5);
    }

    .image-modal-close {
        position: absolute;
        top: 2rem;
        right: 2rem;
        background: white;
        color: var(--text-primary);
        border: none;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        font-size: 1.5rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .image-modal-close:hover {
        transform: scale(1.1);
        background: var(--primary-red);
        color: white;
    }

    @media (max-width: 968px) {
        .emergency-grid {
            grid-template-columns: 1fr;
        }

        .page-header {
            flex-direction: column;
            align-items: stretch;
        }

        .page-title h1 {
            font-size: 1.5rem;
        }

        .header-actions {
            width: 100%;
        }

        .btn-custom {
            flex: 1;
            justify-content: center;
        }

        .filters-grid {
            grid-template-columns: 1fr;
        }

        .stats-section {
            grid-template-columns: repeat(2, 1fr);
        }

        .card-header-custom {
            flex-direction: column;
            gap: 1rem;
        }

        .card-badges {
            align-items: start;
            flex-direction: row;
            flex-wrap: wrap;
        }

        .card-media img,
        .card-media video {
            height: 180px;
        }
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
            <span>🩺</span> Mi Perfil 
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

<div class="emergency-list-container">
    <!-- Header -->
    <div class="page-header">
        <div class="page-title">
            <h1>📅 Mis Emergencias</h1>
            @if(!$emergencias->isEmpty())
                <span class="count-badge">{{ $emergencias->count() }}</span>
            @endif
        </div>
        <div class="header-actions">
            <a href="{{ route('emergencia.nueva') }}" class="btn-custom btn-primary-custom">
                <span>➕</span>
                Nueva Emergencia
            </a>
            <a href="{{ route('dashboard') }}" class="btn-custom btn-secondary-custom">
                <span>←</span>
                Dashboard
            </a>
        </div>
    </div>

    @if(!$emergencias->isEmpty())
        <!-- Estadísticas -->
        <div class="stats-section">
            <div class="stat-card">
                <div class="stat-icon">📊</div>
                <div class="stat-value">{{ $emergencias->count() }}</div>
                <div class="stat-label">Total</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">🔴</div>
                <div class="stat-value">{{ $emergencias->where('gravedad', 'critico')->count() }}</div>
                <div class="stat-label">Críticas</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">⏳</div>
                <div class="stat-value">{{ $emergencias->where('estado', 'pendiente')->count() }}</div>
                <div class="stat-label">Pendientes</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">✅</div>
                <div class="stat-value">{{ $emergencias->where('estado', 'atendida')->count() }}</div>
                <div class="stat-label">Atendidas</div>
            </div>
        </div>

        <!-- Filtros -->
        <div class="filters-section">
            <div class="filters-grid">
                <div class="filter-group">
                    <label class="filter-label">Gravedad</label>
                    <select class="filter-select" id="filter-gravedad">
                        <option value="">Todas</option>
                        <option value="leve">Leve</option>
                        <option value="moderado">Moderado</option>
                        <option value="critico">Crítico</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">Estado</label>
                    <select class="filter-select" id="filter-estado">
                        <option value="">Todos</option>
                        <option value="pendiente">Pendiente</option>
                        <option value="atendida">Atendida</option>
                        <option value="cerrada">Cerrada</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">Ordenar por</label>
                    <select class="filter-select" id="filter-orden">
                        <option value="reciente">Más reciente</option>
                        <option value="antigua">Más antigua</option>
                        <option value="gravedad">Gravedad</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Grid de Emergencias -->
        <div class="emergency-grid" id="emergency-grid">
            @foreach($emergencias as $e)
            <div class="emergency-card" 
                 data-gravedad="{{ $e->gravedad }}" 
                 data-estado="{{ $e->estado }}"
                 data-fecha="{{ $e->created_at->timestamp }}">
                
                <!-- Header -->
                <div class="card-header-custom">
                    <div class="card-id">
                        <span class="card-id-label">Emergencia</span>
                        <span class="card-id-number">#{{ str_pad($e->id, 4, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <div class="card-badges">
                        <span class="badge-custom badge-severity-{{ $e->gravedad }}">
                            @if($e->gravedad == 'critico')
                                🔴 Crítico
                            @elseif($e->gravedad == 'moderado')
                                🟡 Moderado
                            @else
                                🟢 Leve
                            @endif
                        </span>
                        <span class="badge-custom badge-status-{{ $e->estado }}">
                            @if($e->estado == 'pendiente')
                                ⏳ Pendiente
                            @elseif($e->estado == 'atendida')
                                ✅ Atendida
                            @else
                                🔒 Cerrada
                            @endif
                        </span>
                    </div>
                </div>

                <!-- Body -->
                <div class="card-body-custom">
                    <div class="card-type">
                        <span>🚨</span>
                        {{ $e->tipo_emergencia }}
                    </div>

                    <div class="card-description">
                        {{ $e->sintomas }}
                    </div>

                    <!-- Archivo Multimedia -->
                    @if($e->archivo)
                        @php
                            $ext = strtolower(pathinfo($e->archivo, PATHINFO_EXTENSION));
                        @endphp

                        <div class="card-media">
                            @if(in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                <span class="media-label">🖼️ Imagen</span>
                                <img src="{{ asset('storage/' . $e->archivo) }}" 
                                     alt="Imagen de emergencia"
                                     onclick="openImageModal(this.src)"
                                     style="cursor: pointer;">

                            @elseif(in_array($ext, ['mp4', 'mov', 'avi', 'webm']))
                                <span class="media-label">🎥 Video</span>
                                <video controls>
                                    <source src="{{ asset('storage/' . $e->archivo) }}" type="video/{{ $ext }}">
                                    Tu navegador no soporta video.
                                </video>

                            @elseif(in_array($ext, ['mp3', 'wav', 'ogg', 'm4a']))
                                <span class="media-label">🎵 Audio</span>
                                <audio controls>
                                    <source src="{{ asset('storage/' . $e->archivo) }}" type="audio/{{ $ext }}">
                                    Tu navegador no soporta audio.
                                </audio>

                            @else
                                <div class="media-download">
                                    <span class="media-download-icon">📄</span>
                                    <a href="{{ asset('storage/' . $e->archivo) }}" 
                                       target="_blank"
                                       class="media-download-link">
                                        📥 Descargar archivo
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endif

                    <div class="card-location">
                        <div class="location-title">
                            <span>📍</span>
                            Ubicación registrada
                        </div>
                        <div class="location-coords">
                            Lat: {{ number_format($e->latitud, 6) }}<br>
                            Lng: {{ number_format($e->longitud, 6) }}
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="card-footer-custom">
                    <div class="card-timestamp">
                        <span>🕐</span>
                        {{ $e->created_at->format('d/m/Y H:i') }}
                    </div>
                    <div class="card-actions">
                        <a href="{{ route('emergencia.mapa', $e->id) }}" 
                           class="btn-icon" 
                           title="Ver en mapa">
                            🗺️
                        </a>
                        <button class="btn-icon" 
                                onclick="shareEmergency({{ $e->id }})" 
                                title="Compartir">
                            📤
                        </button>
                        @if($e->archivo)
                        <a href="{{ asset('storage/' . $e->archivo) }}" 
                           class="btn-icon" 
                           title="Descargar archivo"
                           download>
                            📥
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <!-- Estado Vacío -->
        <div class="empty-state">
            <div class="empty-state-icon">📭</div>
            <h3>No hay emergencias registradas</h3>
            <p>Aún no has reportado ninguna emergencia. Cuando lo hagas, aparecerán aquí.</p>
            <a href="{{ route('emergencia.nueva') }}" class="btn-custom btn-primary-custom">
                <span>➕</span>
                Registrar Primera Emergencia
            </a>
        </div>
    @endif
</div>

<!-- Modal para ver imágenes en grande -->
<div id="image-modal" class="image-modal" onclick="closeImageModal()">
    <button class="image-modal-close" onclick="closeImageModal()">✕</button>
    <img id="modal-image" src="" alt="Imagen ampliada">
</div>

<script>
class EmergencyListManager {
    constructor() {
        this.cards = document.querySelectorAll('.emergency-card');
        this.filterGravedad = document.getElementById('filter-gravedad');
        this.filterEstado = document.getElementById('filter-estado');
        this.filterOrden = document.getElementById('filter-orden');
        this.init();
    }

    init() {
        if (this.filterGravedad) {
            this.filterGravedad.addEventListener('change', () => this.applyFilters());
            this.filterEstado.addEventListener('change', () => this.applyFilters());
            this.filterOrden.addEventListener('change', () => this.applyFilters());
        }
    }

    applyFilters() {
        const gravedad = this.filterGravedad.value;
        const estado = this.filterEstado.value;
        const orden = this.filterOrden.value;

        let visibleCards = Array.from(this.cards);

        // Filtrar por gravedad
        if (gravedad) {
            visibleCards = visibleCards.filter(card => 
                card.dataset.gravedad === gravedad
            );
        }

        // Filtrar por estado
        if (estado) {
            visibleCards = visibleCards.filter(card => 
                card.dataset.estado === estado
            );
        }

        // Ordenar
        if (orden === 'reciente') {
            visibleCards.sort((a, b) => 
                parseInt(b.dataset.fecha) - parseInt(a.dataset.fecha)
            );
        } else if (orden === 'antigua') {
            visibleCards.sort((a, b) => 
                parseInt(a.dataset.fecha) - parseInt(b.dataset.fecha)
            );
        } else if (orden === 'gravedad') {
            const gravedadOrder = { 'critico': 3, 'moderado': 2, 'leve': 1 };
            visibleCards.sort((a, b) => 
                gravedadOrder[b.dataset.gravedad] - gravedadOrder[a.dataset.gravedad]
            );
        }

        // Ocultar todas las tarjetas
        this.cards.forEach(card => {
            card.style.display = 'none';
        });

        // Mostrar tarjetas filtradas en el orden correcto
        const grid = document.getElementById('emergency-grid');
        visibleCards.forEach(card => {
            card.style.display = 'block';
            grid.appendChild(card);
        });

        // Animar entrada
        visibleCards.forEach((card, index) => {
            card.style.animation = 'none';
            setTimeout(() => {
                card.style.animation = `slideUp 0.5s ease ${index * 0.05}s`;
            }, 10);
        });
    }
}

function openImageModal(src) {
    const modal = document.getElementById('image-modal');
    const modalImage = document.getElementById('modal-image');
    modalImage.src = src;
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    const modal = document.getElementById('image-modal');
    modal.classList.remove('active');
    document.body.style.overflow = 'auto';
}

function shareEmergency(id) {
    const shareData = {
        title: `Emergencia #${id}`,
        text: `Detalles de la emergencia #${id}`,
        url: window.location.origin + '/emergencia/' + id + '/mapa'
    };

    if (navigator.share) {
        navigator.share(shareData).catch(() => {});
    } else {
        // Fallback: copiar enlace
        const url = window.location.origin + '/emergencia/' + id + '/mapa';
        navigator.clipboard.writeText(url).then(() => {
            showNotification('✅ Enlace copiado al portapapeles', 'success');
        }).catch(() => {
            showNotification('❌ Error al compartir', 'error');
        });
    }
}

function showNotification(message, type) {
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
        animation: slideIn 0.3s ease;
    `;
    notification.textContent = message;
    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Inicializar
document.addEventListener('DOMContentLoaded', () => {
    new EmergencyListManager();
});

// Animaciones
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from { transform: translateX(400px); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes slideOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(400px); opacity: 0; }
    }
`;
document.head.appendChild(style);
</script>
@endsection