@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary: #dc2626;
        --primary-dark: #b91c1c;
        --success: #059669;
        --warning: #ea580c;
        --info: #3b82f6;
        --gray-50: #f8fafc;
        --gray-100: #f1f5f9;
        --gray-200: #e2e8f0;
        --gray-600: #64748b;
        --gray-900: #1e293b;
        --border: #e2e8f0;
    }

    * { box-sizing: border-box; }

    body {
        background: var(--gray-50);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        margin: 0;
        padding: 0;
    }

    /* HEADER PRINCIPAL */
    .admin-header {
        background: white;
        padding: 1rem 2rem;
        border-bottom: 1px solid var(--border);
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 2rem;
    }

    .header-logo {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-weight: 800;
        font-size: 1.125rem;
        color: var(--gray-900);
    }

    .header-logo img {
        width: 32px;
        height: 32px;
    }

    .header-title {
        font-size: 0.875rem;
        color: var(--primary);
        font-weight: 600;
    }

    .header-actions {
        display: flex;
        gap: 1rem;
        align-items: center;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.875rem;
        cursor: pointer;
        text-decoration: none;
        border: none;
        transition: all 0.2s;
    }

    .btn-primary {
        background: var(--primary);
        color: white;
    }

    .btn-secondary {
        background: var(--gray-600);
        color: white;
    }

    .btn-danger {
        background: #ef4444;
        color: white;
    }

    .btn-outline {
        background: transparent;
        border: 2px solid var(--gray-300);
        color: var(--gray-700);
    }

    .btn-outline:hover {
        background: var(--gray-100);
    }

    /* NAVBAR HORIZONTAL */
    .admin-navbar {
        background: white;
        padding: 0.75rem 2rem;
        border-bottom: 1px solid var(--border);
        display: flex;
        justify-content: center;
        gap: 2rem;
        font-weight: 600;
    }

    .nav-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--gray-600);
        text-decoration: none;
        padding: 0.5rem 0;
        border-bottom: 2px solid transparent;
        transition: all 0.2s;
    }

    .nav-item:hover,
    .nav-item.active {
        color: var(--primary);
        border-bottom-color: var(--primary);
    }

    .nav-icon {
        font-size: 1.125rem;
    }

    /* CONTENIDO PRINCIPAL */
    .container {
        max-width: 1600px;
        margin: 2rem auto;
        padding: 0 2rem;
    }

    .page-header {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .page-title {
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--gray-900);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    /* STATS CARDS */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .stat-card {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        position: relative;
        overflow: hidden;
        border-left: 4px solid transparent;
    }

    .stat-card.blue { border-left-color: var(--info); }
    .stat-card.orange { border-left-color: var(--warning); }
    .stat-card.red { border-left-color: var(--primary); }
    .stat-card.green { border-left-color: var(--success); }

    .stat-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.75rem;
    }

    .stat-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--gray-600);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-icon {
        font-size: 1.5rem;
        opacity: 0.8;
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 800;
        color: var(--gray-900);
        margin-bottom: 0.25rem;
    }

    .stat-footer {
        font-size: 0.75rem;
        color: var(--gray-600);
    }

    /* FILTERS */
    .filter-section {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        margin-bottom: 1.5rem;
    }

    .filter-title {
        font-weight: 700;
        font-size: 1rem;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .filter-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--gray-900);
        margin-bottom: 0.5rem;
    }

    .form-control {
        padding: 0.625rem;
        border: 2px solid var(--gray-200);
        border-radius: 8px;
        font-size: 0.875rem;
        transition: all 0.2s;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
    }

    /* EMERGENCIES LIST */
    .emergencias-container {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    /* RESPONSIVE */
    @media (max-width: 1024px) {
        .admin-header {
            flex-direction: column;
            align-items: stretch;
            gap: 1rem;
        }
        .admin-navbar {
            flex-wrap: wrap;
            justify-content: flex-start;
            gap: 1rem;
        }
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .filter-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 640px) {
        .container {
            padding: 0 1rem;
        }
        .admin-header {
            padding: 1rem;
        }
        .admin-navbar {
            padding: 0.5rem 1rem;
        }
        .page-header {
            padding: 1rem;
        }
        .header-actions {
            width: 100%;
            justify-content: space-between;
        }
        .btn {
            flex: 1;
            justify-content: center;
        }
        .stats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>



<!-- NAVBAR HORIZONTAL -->
<div class="admin-navbar">
 
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

<!-- CONTENIDO PRINCIPAL -->
<div class="container">
    <!-- PAGE HEADER -->
    <div class="page-header">
        <h1 class="page-title">
            👨‍💼 Panel de Administrador
        </h1>
        <div class="btn-group">
            <a href="{{ route('admin.reporte.pdf') }}" class="btn btn-secondary">
                📤 Exportar PDF
            </a>
        </div>
    </div>

    <!-- ESTADÍSTICAS -->
    @php
        $total = \App\Models\Emergencia::count();
        $pendientes = \App\Models\Emergencia::where('estado', 'pendiente')->count();
        $criticas = \App\Models\Emergencia::where('gravedad', 'critico')->count();
        $pacientes = \App\Models\User::where('role', 'paciente')->count();
    @endphp

    <div class="stats-grid">
        <div class="stat-card blue">
            <div class="stat-header">
                <span class="stat-label">TOTAL</span>
                <span class="stat-icon">📊</span>
            </div>
            <div class="stat-value">{{ $total }}</div>
            <div class="stat-footer">Emergencias registradas</div>
        </div>

        <div class="stat-card orange">
            <div class="stat-header">
                <span class="stat-label">PENDIENTES</span>
                <span class="stat-icon">⏳</span>
            </div>
            <div class="stat-value">{{ $pendientes }}</div>
            <div class="stat-footer">Requieren atención</div>
        </div>

        <div class="stat-card red">
            <div class="stat-header">
                <span class="stat-label">CRÍTICAS</span>
                <span class="stat-icon">🚨</span>
            </div>
            <div class="stat-value">{{ $criticas }}</div>
            <div class="stat-footer">Alta prioridad</div>
        </div>

        <div class="stat-card green">
            <div class="stat-header">
                <span class="stat-label">PACIENTES</span>
                <span class="stat-icon">👥</span>
            </div>
            <div class="stat-value">{{ $pacientes }}</div>
            <div class="stat-footer">Usuarios activos</div>
        </div>
    </div>

    <!-- FILTROS -->
    <div class="filter-section">
        <h3 class="filter-title">🔍 Filtrar Emergencias</h3>
        <form id="filter-form" class="filter-grid">
            <div class="form-group">
                <label class="form-label">Estado</label>
                <select name="estado" class="form-control">
                    <option value="">Todos</option>
                    <option value="pendiente">Pendiente</option>
                    <option value="en_curso">En curso</option>
                    <option value="finalizada">Finalizada</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Gravedad</label>
                <select name="gravedad" class="form-control">
                    <option value="">Todas</option>
                    <option value="leve">Leve</option>
                    <option value="moderado">Moderado</option>
                    <option value="critico">Crítico</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Fecha Desde</label>
                <input type="date" name="fecha_desde" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">Buscar Paciente</label>
                <input type="text" name="paciente" placeholder="Nombre o email" class="form-control">
            </div>
        </form>
    </div>

    <!-- LISTA DE EMERGENCIAS -->
    <div class="emergencias-container">
        <div id="emergencias-lista">
            @include('admin.emergencias-lista', ['emergencias' => $emergencias])
        </div>
    </div>
</div>

<!-- SCRIPTS -->
<script>
document.getElementById('filter-form').addEventListener('input', function () {
    const formData = new FormData(this);
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

    fetch("{{ route('admin.emergencias.filtrar') }}", {
        method: 'POST',
        body: formData
    })
    .then(res => res.text())
    .then(html => {
        document.getElementById('emergencias-lista').innerHTML = html;
    })
    .catch(err => console.error('Error al filtrar:', err));
});
</script>
@endsection
