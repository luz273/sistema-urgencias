@extends('layouts.app')

@section('content')
<div class="admin-navbar">
    <div class="navbar-container">
        <a href="{{ route('admin.usuarios') }}" class="nav-item {{ request()->routeIs('admin.usuarios') ? 'active' : '' }}">
            <span class="nav-icon">👥</span> Usuarios
        </a>
        <a href="{{ route('admin.mapa') }}" class="nav-item {{ request()->routeIs('admin.mapa') ? 'active' : '' }}">
            <span class="nav-icon">🗺️</span> Mapa
        </a>
        <a href="{{ route('admin.estadisticas') }}" class="nav-item {{ request()->routeIs('admin.estadisticas') ? 'active' : '' }}">
            <span class="nav-icon">📈</span> Estadísticas
        </a>
         <a href="{{ route('admin.historial.emergencias') }}" class="nav-item">
    <span class="nav-icon">📋</span> Historial Completo
   </a>
    </div>
</div>

<style>
    .admin-navbar {
        background: white;
        padding: 0.75rem 2rem;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: center;
        gap: 2rem;
        font-weight: 600;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .navbar-container {
        display: flex;
        align-items: center;
        gap: 2rem;
    }

    .nav-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #475569;
        text-decoration: none;
        padding: 0.5rem 0;
        border-bottom: 2px solid transparent;
        transition: all 0.2s;
        font-size: 0.95rem;
    }

    .nav-item:hover,
    .nav-item.active {
        color: #dc2626;
        border-bottom-color: #dc2626;
    }

    .nav-icon {
        font-size: 1.125rem;
    }

    @media (max-width: 768px) {
        .admin-navbar {
            padding: 0.75rem 1rem;
            flex-wrap: wrap;
            justify-content: flex-start;
            gap: 1rem;
        }
        .nav-item {
            font-size: 0.875rem;
        }
    }
</style>
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-[#1B1B18] dark:text-[#EDEDEC]">🗺️ Mapa Global de Emergencias</h1>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary btn-sm">← Volver al Panel</a>
    </div>

    <div id="mapa-global" style="height: 500px; margin-bottom: 20px;"></div>

    <div class="bg-white dark:bg-[#161615] p-4 rounded-lg">
        <h3 class="font-medium mb-3">📌 Leyenda</h3>
        <div class="flex flex-wrap gap-4">
            <span class="inline-flex items-center gap-2">
                <span class="w-4 h-4 bg-green-500 rounded-full"></span>
                Leve
            </span>
            <span class="inline-flex items-center gap-2">
                <span class="w-4 h-4 bg-yellow-500 rounded-full"></span>
                Moderado
            </span>
            <span class="inline-flex items-center gap-2">
                <span class="w-4 h-4 bg-red-500 rounded-full"></span>
                Crítico
            </span>
            <span class="inline-flex items-center gap-2">
                <span class="w-4 h-4 bg-gray-500 rounded-full"></span>
                Finalizada
            </span>
        </div>
    </div>
</div>


<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
const map = L.map('mapa-global').setView([-15.746073, -70.054149], 5); // Centro de Perú

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

// Datos de emergencias desde el servidor
fetch("{{ route('admin.mapa.data') }}")
.then(res => res.json())
.then(data => {
    data.forEach(emergencia => {
        const color = emergencia.gravedad === 'critico' ? '#FF0000' :
                     emergencia.gravedad === 'moderado' ? '#FFA500' : '#00FF00';
        
        const marker = L.circleMarker([emergencia.latitud, emergencia.longitud], {
            radius: 10,
            fillColor: color,
            color: '#000',
            weight: 2,
            opacity: 1,
            fillOpacity: 0.8
        }).addTo(map);

        marker.bindPopup(`
            <strong>ID: ${emergencia.id}</strong><br>
            Paciente: ${emergencia.paciente_name}<br>
            Tipo: ${emergencia.tipo_emergencia}<br>
            Gravedad: ${emergencia.gravedad}<br>
            Estado: ${emergencia.estado}<br>
            <a href="/admin/emergencia/${emergencia.id}" target="_blank">Ver detalle</a>
        `);
    });
});
</script>
@endsection