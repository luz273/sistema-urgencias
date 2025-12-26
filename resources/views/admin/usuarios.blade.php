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

    .usuarios-container {
        max-width: 1400px;
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

    .alert-success {
        background: #dcfce7;
        color: var(--success);
        padding: 0.75rem 1.25rem;
        border-radius: 10px;
        font-weight: 600;
        margin-bottom: 1.5rem;
        border-left: 4px solid var(--success);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .usuarios-table {
        width: 100%;
        background: white;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.04);
        border: 1px solid var(--gray-200);
    }

    .table-header {
        background: var(--gray-100);
        padding: 1.25rem 1.5rem;
        font-weight: 700;
        color: var(--gray-900);
        text-align: left;
        border-bottom: 1px solid var(--gray-200);
    }

    .table-row {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--gray-200);
        display: grid;
        grid-template-columns: 1fr 1fr 1fr 200px;
        align-items: center;
        gap: 1rem;
    }

    .table-row:last-child {
        border-bottom: none;
    }

    .role-badge {
        display: inline-block;
        padding: 0.375rem 0.75rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
    }

    .role-paciente {
        background: var(--info);
        color: white;
    }

    .role-administrador {
        background: var(--primary);
        color: white;
    }

    .role-select {
        width: 100%;
        padding: 0.5rem;
        border-radius: 8px;
        border: 2px solid var(--gray-200);
        font-weight: 600;
        background: white;
        cursor: pointer;
        transition: border-color 0.2s;
    }

    .role-select:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .usuarios-container {
            padding: 1rem;
        }
        .page-title {
            font-size: 1.5rem;
        }
        .table-row {
            grid-template-columns: 1fr;
            text-align: left;
        }
        .table-header {
            display: none;
        }
        .mobile-label {
            font-weight: 600;
            color: var(--gray-600);
            font-size: 0.875rem;
            margin-bottom: 0.25rem;
        }
        .role-cell {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 0.75rem;
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

<div class="usuarios-container">
    <div class="page-header">
        <h1 class="page-title">👥 Usuarios del Sistema</h1>
    </div>

    @if(session('success'))
        <div class="alert-success">
            ✅ {{ session('success') }}
        </div>
    @endif

    <div class="usuarios-table">
        <div class="table-header" style="display: grid; grid-template-columns: 1fr 1fr 1fr 200px;">
            <span>Nombre</span>
            <span>Email</span>
            <span>Rol actual</span>
            <span>Cambiar rol</span>
        </div>

        @foreach($usuarios as $user)
            <div class="table-row">
                <div>
                    <div class="mobile-label">Nombre</div>
                    {{ $user->name }}
                </div>
                <div>
                    <div class="mobile-label">Email</div>
                    <a href="mailto:{{ $user->email }}" class="text-blue-600 hover:underline">{{ $user->email }}</a>
                </div>
                <div>
                    <div class="mobile-label">Rol actual</div>
                    <span class="role-badge {{ $user->role === 'administrador' ? 'role-administrador' : 'role-paciente' }}">
                        {{ ucfirst($user->role) }}
                    </span>
                </div>
                <div class="role-cell">
                    <div class="mobile-label">Cambiar rol</div>
                    <form method="POST" action="{{ route('admin.usuarios.rol', $user->id) }}" style="width: 100%;">
                        @csrf
                        @method('PATCH')
                        <select name="role" class="role-select" onchange="this.form.submit()">
                            <option value="paciente" {{ $user->role === 'paciente' ? 'selected' : '' }}>
                                Paciente
                            </option>
                            <option value="administrador" {{ $user->role === 'administrador' ? 'selected' : '' }}>
                                Administrador
                            </option>
                        </select>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection