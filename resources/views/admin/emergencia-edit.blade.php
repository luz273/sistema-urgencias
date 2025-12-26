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
    }

    .form-container {
        max-width: 800px;
        margin: 2rem auto;
        background: white;
        padding: 2rem;
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        border: 1px solid var(--gray-200);
    }

    .form-title {
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--gray-900);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        font-weight: 600;
        color: var(--gray-900);
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid var(--gray-200);
        border-radius: 10px;
        font-size: 1rem;
        transition: all 0.2s;
        background: white;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        text-decoration: none;
        border: none;
        transition: all 0.2s;
    }

    .btn-primary {
        background: var(--primary);
        color: white;
        box-shadow: 0 2px 6px rgba(220, 38, 38, 0.2);
    }

    .btn-primary:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
    }

    .btn-secondary {
        background: var(--gray-600);
        color: white;
    }

    .btn-secondary:hover {
        background: var(--gray-900);
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--info);
        text-decoration: none;
        font-weight: 600;
        margin-bottom: 1.5rem;
        transition: opacity 0.2s;
    }

    .back-link:hover {
        opacity: 0.8;
    }

    @media (max-width: 640px) {
        .form-container {
            padding: 1.5rem;
            margin: 1rem;
        }
        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
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
<div class="form-container">
    <a href="{{ route('admin.dashboard') }}" class="back-link">
        ← Volver al Panel
    </a>

    <h1 class="form-title">
        ✏️ Editar Emergencia #{{ $emergencia->id }}
    </h1>

    <form method="POST" action="{{ route('admin.emergencia.update', $emergencia->id) }}">
        @csrf
        @method('PUT')

        <!-- Estado -->
        <div class="form-group">
            <label class="form-label" for="estado">Estado</label>
            <select name="estado" id="estado" class="form-control">
                <option value="pendiente" {{ $emergencia->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="en_curso" {{ $emergencia->estado == 'en_curso' ? 'selected' : '' }}>En curso</option>
                <option value="finalizada" {{ $emergencia->estado == 'finalizada' ? 'selected' : '' }}>Finalizada</option>
                <option value="atendida" {{ $emergencia->estado == 'atendida' ? 'selected' : '' }}>Atendida</option>
            </select>
        </div>

        <!-- Gravedad -->
        <div class="form-group">
            <label class="form-label" for="gravedad">Gravedad</label>
            <select name="gravedad" id="gravedad" class="form-control">
                <option value="leve" {{ $emergencia->gravedad == 'leve' ? 'selected' : '' }}>Leve</option>
                <option value="moderado" {{ $emergencia->gravedad == 'moderado' ? 'selected' : '' }}>Moderado</option>
                <option value="critico" {{ $emergencia->gravedad == 'critico' ? 'selected' : '' }}>Crítico</option>
            </select>
        </div>

        <!-- Botones -->
        <div class="flex gap-3 flex-wrap">
            <button type="submit" class="btn btn-primary">
                💾 Guardar Cambios
            </button>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                ❌ Cancelar
            </a>
        </div>
    </form>
</div>
@endsection