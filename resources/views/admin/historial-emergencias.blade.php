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
    }

    .container {
        max-width: 1600px;
        margin: 0 auto;
        padding: 2rem;
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
        font-size: 1.875rem;
        font-weight: 800;
        color: var(--gray-900);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.625rem 1rem;
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
        box-shadow: 0 2px 4px rgba(220, 38, 38, 0.2);
    }

    .btn-primary:hover {
        background: var(--primary-dark);
        transform: translateY(-1px);
    }

    .btn-secondary {
        background: var(--gray-600);
        color: white;
    }

    .btn-secondary:hover {
        background: var(--gray-900);
    }

    .filter-section {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        margin-bottom: 1.5rem;
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

    .emergencias-container {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .emergencia-card {
        background: var(--gray-50);
        padding: 1.25rem;
        border-radius: 10px;
        margin-bottom: 1rem;
        border-left: 4px solid var(--info);
    }

    .emergencia-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .emergencia-id {
        font-weight: 700;
        color: var(--gray-900);
    }

    .emergencia-meta {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .badge {
        padding: 0.25rem 0.5rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .badge-gravedad.critico { background: var(--primary); color: white; }
    .badge-gravedad.moderado { background: var(--warning); color: white; }
    .badge-gravedad.leve { background: var(--success); color: white; }

    .badge-estado.pendiente { background: var(--gray-200); color: var(--gray-900); }
    .badge-estado.atendida { background: var(--success); color: white; }
    .badge-estado.en_curso { background: var(--info); color: white; }

    .emergencia-paciente {
        color: var(--gray-700);
        margin: 0.5rem 0;
    }

    .emergencia-sintomas {
        background: white;
        padding: 0.75rem;
        border-radius: 8px;
        margin: 0.75rem 0;
        font-style: italic;
    }

    .emergencia-ubicacion {
        font-size: 0.875rem;
        color: var(--gray-600);
        margin-top: 0.5rem;
    }

    .no-results {
        text-align: center;
        padding: 2rem;
        color: var(--gray-600);
    }

    @media (max-width: 768px) {
        .container {
            padding: 1rem;
        }
        .page-header {
            flex-direction: column;
            align-items: stretch;
        }
        .filter-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="container">
    <div class="page-header">
        <h1 class="page-title">📋 Historial de Emergencias</h1>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
            ← Volver al Panel
        </a>
    </div>

    <!-- Filtros -->
    <div class="filter-section">
        <h3 class="form-label" style="margin-bottom: 1rem;">Filtrar historial</h3>
        <form id="filter-form" class="filter-grid">
            <div class="form-group">
                <label class="form-label">Paciente</label>
                <input type="text" name="paciente" placeholder="Nombre o email" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">Estado</label>
                <select name="estado" class="form-control">
                    <option value="">Todos</option>
                    <option value="pendiente">Pendiente</option>
                    <option value="en_curso">En curso</option>
                    <option value="atendida">Atendida</option>
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
                <label class="form-label">Fecha desde</label>
                <input type="date" name="fecha_desde" class="form-control">
            </div>
        </form>
    </div>
    

    <!-- Lista de emergencias -->
    <div class="emergencias-container">
        <div id="emergencias-list">
            @if($emergencias->isEmpty())
                <div class="no-results">
                    <p>📭 No se encontraron emergencias.</p>
                </div>
            @else
                @foreach($emergencias as $e)
                    <div class="emergencia-card">
                        <div class="emergencia-header">
                            <div class="emergencia-id">ID: {{ $e->id }} — {{ $e->tipo_emergencia }}</div>
                            <div class="emergencia-meta">
                                <span class="badge badge-gravedad {{ $e->gravedad }}">{{ ucfirst($e->gravedad) }}</span>
                                <span class="badge badge-estado {{ $e->estado }}">{{ ucfirst(str_replace('_', ' ', $e->estado)) }}</span>
                            </div>
                        </div>
                        <div class="emergencia-paciente">
                            👤 <strong>Paciente:</strong> {{ optional($e->paciente)->name ?? '—' }}
                            @if($e->paciente?->email)
                                (<a href="mailto:{{ $e->paciente->email }}" style="color: var(--info);">{{ $e->paciente->email }}</a>)
                            @endif
                        </div>
                        <div class="emergencia-sintomas">
                            "{{ $e->sintomas }}"
                        </div>
                        <div class="emergencia-ubicacion">
                            📍 Ubicación: {{ $e->latitud ?? '—' }}, {{ $e->longitud ?? '—' }}
                        </div>
                        <div style="font-size: 0.875rem; color: var(--gray-600); margin-top: 0.5rem;">
                            📅 {{ $e->created_at->format('d/m/Y H:i') }}
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>

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
        document.getElementById('emergencias-list').innerHTML = html;
    })
    .catch(err => console.error('Error:', err));
});
</script>
@endsection