@extends('layouts.app')

@php
    // Definir TODAS las variables al inicio, ANTES de <style>
    $total = \App\Models\Emergencia::count();
    $pendientes = \App\Models\Emergencia::where('estado', 'pendiente')->count();
    $criticas = \App\Models\Emergencia::where('gravedad', 'critico')->count();
    $pacientes = \App\Models\User::where('role', 'paciente')->count();
    $en_curso = \App\Models\Emergencia::where('estado', 'en_curso')->count();
    $finalizadas = \App\Models\Emergencia::where('estado', 'finalizada')->count();
    $atendidas = \App\Models\Emergencia::where('estado', 'atendida')->count();
@endphp

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

    .stats-container {
        max-width: 1600px;
        margin: 0 auto;
        padding: 2rem;
    }

    .page-title {
        font-size: 1.875rem;
        font-weight: 800;
        color: var(--gray-900);
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2.5rem;
    }

    .stat-card {
        background: white;
        border-radius: 14px;
        padding: 1.75rem 1.5rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.04);
        border: 1px solid var(--gray-200);
        transition: transform 0.2s, box-shadow 0.2s;
        position: relative;
        overflow: hidden;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(0,0,0,0.08);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
    }

    .stat-card.total::before { background: var(--info); }
    .stat-card.pending::before { background: var(--warning); }
    .stat-card.critical::before { background: var(--primary); }
    .stat-card.users::before { background: var(--success); }

    .stat-icon {
        font-size: 2rem;
        margin-bottom: 1rem;
        opacity: 0.85;
    }

    .stat-value {
        font-size: 2.25rem;
        font-weight: 800;
        color: var(--gray-900);
        margin-bottom: 0.25rem;
        line-height: 1;
    }

    .stat-label {
        font-size: 1rem;
        font-weight: 600;
        color: var(--gray-600);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .chart-section {
        background: white;
        border-radius: 14px;
        padding: 2rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.04);
        border: 1px solid var(--gray-200);
        margin-top: 1rem;
    }

    .chart-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--gray-900);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .chart-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 1.5rem;
        margin-top: 1rem;
    }

    .chart-item {
        text-align: center;
    }

    .chart-bar {
        height: 100px;
        display: flex;
        align-items: flex-end;
        justify-content: center;
        margin-bottom: 0.75rem;
        gap: 0.4rem;
    }

    .bar {
        width: 28px;
        border-radius: 4px 4px 0 0;
        transition: height 0.5s ease;
    }

    /* Valores calculados en PHP → pasados a CSS personalizado */
    .bar.pendiente { 
        background: var(--warning); 
        height: {{ max(20, ($pendientes / max($total, 1)) * 100) }}%;
    }
    .bar.en_curso { 
        background: var(--info); 
        height: {{ max(20, ($en_curso / max($total, 1)) * 100) }}%;
    }
    .bar.finalizada { 
        background: var(--success); 
        height: {{ max(20, ($finalizadas / max($total, 1)) * 100) }}%;
    }
    .bar.atendida { 
        background: #8b5cf6; 
        height: {{ max(20, ($atendidas / max($total, 1)) * 100) }}%;
    }

    .chart-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--gray-700);
    }

    .chart-value {
        font-size: 1.125rem;
        font-weight: 800;
        color: var(--gray-900);
        margin-top: 0.25rem;
    }

    @media (max-width: 768px) {
        .stats-container {
            padding: 1rem;
        }
        .page-title {
            font-size: 1.5rem;
        }
        .stat-value {
            font-size: 1.75rem;
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

<div class="stats-container">
    <h1 class="page-title">📊 Estadísticas de Emergencias</h1>

    <!-- Tarjetas principales -->
    <div class="stats-grid">
        <div class="stat-card total">
            <div class="stat-icon">📊</div>
            <div class="stat-value">{{ $total }}</div>
            <div class="stat-label">Total Emergencias</div>
        </div>

        <div class="stat-card pending">
            <div class="stat-icon">⏳</div>
            <div class="stat-value">{{ $pendientes }}</div>
            <div class="stat-label">Pendientes</div>
        </div>

        <div class="stat-card critical">
            <div class="stat-icon">🚨</div>
            <div class="stat-value">{{ $criticas }}</div>
            <div class="stat-label">Críticas</div>
        </div>

        <div class="stat-card users">
            <div class="stat-icon">👤</div>
            <div class="stat-value">{{ $pacientes }}</div>
            <div class="stat-label">Pacientes Activos</div>
        </div>
    </div>

    <!-- Gráfico de estados -->
    <div class="chart-section">
        <h2 class="chart-title">📈 Distribución por Estado</h2>
        <div class="chart-grid">
            <div class="chart-item">
                <div class="chart-bar">
                    <div class="bar pendiente"></div>
                </div>
                <div class="chart-label">Pendiente</div>
                <div class="chart-value">{{ $pendientes }}</div>
            </div>
            <div class="chart-item">
                <div class="chart-bar">
                    <div class="bar en_curso"></div>
                </div>
                <div class="chart-label">En Curso</div>
                <div class="chart-value">{{ $en_curso }}</div>
            </div>
            <div class="chart-item">
                <div class="chart-bar">
                    <div class="bar finalizada"></div>
                </div>
                <div class="chart-label">Finalizada</div>
                <div class="chart-value">{{ $finalizadas }}</div>
            </div>
            <div class="chart-item">
                <div class="chart-bar">
                    <div class="bar atendida"></div>
                </div>
                <div class="chart-label">Atendida</div>
                <div class="chart-value">{{ $atendidas }}</div>
            </div>
        </div>
    </div>
</div>
@endsection