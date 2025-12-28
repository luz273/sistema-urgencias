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

    .alergia-list {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .alergia-tag {
        background: var(--warning);
        color: white;
        padding: 0.25rem 0.5rem;
        border-radius: 20px;
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .alergia-tag button {
        background: transparent;
        border: none;
        color: white;
        font-size: 0.75rem;
        cursor: pointer;
    }

    .alergia-input {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .alergia-input input {
        flex: 1;
        padding: 0.5rem;
        border: 2px solid var(--gray-200);
        border-radius: 8px;
        font-size: 0.875rem;
    }

    .alergia-input button {
        padding: 0.5rem 1rem;
        background: var(--info);
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
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

<div class="form-container">
    <h1 class="form-title">🩺 Mi Perfil Médico</h1>

    @if(session('success'))
        <div class="alert-success" style="background: #dcfce7; color: var(--success); padding: 0.75rem 1.25rem; border-radius: 10px; font-weight: 600; margin-bottom: 1.5rem; border-left: 4px solid var(--success);">
            ✅ {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('paciente.perfil.guardar') }}">
        @csrf

        <!-- Nombre y Email (solo lectura) -->
        <div class="form-group">
            <label class="form-label">Nombre Completo</label>
            <input type="text" value="{{ $user->name }}" class="form-control" readonly>
        </div>

        <div class="form-group">
            <label class="form-label">Email</label>
            <input type="email" value="{{ $user->email }}" class="form-control" readonly>
        </div>

        <!-- DNI -->
        <div class="form-group">
            <label class="form-label" for="dni">DNI / Documento</label>
            <input type="text" name="dni" id="dni" class="form-control" value="{{ old('dni', $user->dni) }}">
        </div>

        <!-- Teléfono -->
        <div class="form-group">
            <label class="form-label" for="telefono">Teléfono</label>
            <input type="text" name="telefono" id="telefono" class="form-control" value="{{ old('telefono', $user->telefono) }}">
        </div>

        <!-- Contacto de Emergencia -->
        <div class="form-group">
            <label class="form-label" for="contacto_emergencia">Contacto de Emergencia</label>
            <input type="text" name="contacto_emergencia" id="contacto_emergencia" class="form-control" value="{{ old('contacto_emergencia', $user->contacto_emergencia) }}">
        </div>

        <!-- Información Médica Básica -->
        <div class="form-group">
            <label class="form-label" for="informacion_medica">Información Médica Básica</label>
            <textarea name="informacion_medica" id="informacion_medica" class="form-control" rows="4">{{ old('informacion_medica', $user->informacion_medica) }}</textarea>
        </div>

        <!-- Alergias -->
        <div class="form-group">
            <label class="form-label">Alergias</label>
            <div class="alergia-list" id="alergias-list">
                @if($user->alergias && is_array(json_decode($user->alergias)))
                    @foreach(json_decode($user->alergias) as $alergia)
                        <div class="alergia-tag">
                            {{ $alergia }}
                            <button type="button" onclick="eliminarAlergia('{{ $alergia }}')">×</button>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="alergia-input">
                <input type="text" id="nueva-alergia" placeholder="Ej: Penicilina, Maní...">
                <button type="button" onclick="agregarAlergia()">+ Alergia</button>
            </div>
            <input type="hidden" name="alergias[]" id="alergias-hidden" value="{{ old('alergias', $user->alergias) }}">
        </div>

        <!-- Botones -->
        <div class="flex gap-3 flex-wrap">
            <button type="submit" class="btn btn-primary">
                💾 Guardar Cambios
            </button>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                ❌ Volver al Dashboard
            </a>
        </div>
    </form>
</div>

<script>
let alergias = @json(json_decode($user->alergias ?? '[]'));

function agregarAlergia() {
    const input = document.getElementById('nueva-alergia');
    const valor = input.value.trim();
    if (!valor) return;

    if (!alergias.includes(valor)) {
        alergias.push(valor);
        actualizarLista();
    }
    input.value = '';
}

function eliminarAlergia(alergia) {
    alergias = alergias.filter(a => a !== alergia);
    actualizarLista();
}

function actualizarLista() {
    const lista = document.getElementById('alergias-list');
    const hidden = document.getElementById('alergias-hidden');

    lista.innerHTML = alergias.map((alergia) => `
        <div class="alergia-tag">
            ${alergia}
            <button type="button" onclick="eliminarAlergia('${alergia}')">×</button>
        </div>
    `).join('');

    hidden.value = JSON.stringify(alergias);
}

// Inicializar lista al cargar
actualizarLista();
</script>
@endsection