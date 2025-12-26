@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary-red: #dc2626;
        --primary-red-hover: #b91c1c;
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

    .emergency-form-container {
        max-width: 800px;
        margin: 2rem auto;
        padding: 0 1rem;
        animation: fadeIn 0.5s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .form-header {
        text-align: center;
        margin-bottom: 2.5rem;
    }

    .form-header h1 {
        color: var(--text-primary);
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .form-header p {
        color: var(--text-secondary);
        font-size: 1rem;
    }

    .form-card {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: var(--shadow-lg);
        border: 1px solid var(--border-color);
    }

    .alert-custom {
        padding: 1rem 1.25rem;
        border-radius: 10px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: start;
        gap: 0.75rem;
        animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .alert-success {
        background: #d1fae5;
        color: #065f46;
        border: 2px solid var(--success-green);
    }

    .alert-danger {
        background: #fee2e2;
        color: #991b1b;
        border: 2px solid var(--primary-red);
    }

    .alert-custom .icon {
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .form-section {
        margin-bottom: 2rem;
    }

    .form-section:last-of-type {
        margin-bottom: 0;
    }

    .section-title {
        color: var(--text-primary);
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--bg-light);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group:last-child {
        margin-bottom: 0;
    }

    .form-label {
        display: block;
        color: var(--text-primary);
        font-weight: 600;
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }

    .form-label .required {
        color: var(--primary-red);
        margin-left: 0.25rem;
    }

    .form-label .optional {
        color: var(--text-secondary);
        font-weight: 400;
        font-size: 0.875rem;
        margin-left: 0.25rem;
    }

    .form-control-custom {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 2px solid var(--border-color);
        border-radius: 10px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: white;
        color: var(--text-primary);
    }

    .form-control-custom:focus {
        outline: none;
        border-color: var(--info-blue);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .form-control-custom:disabled {
        background: var(--bg-light);
        cursor: not-allowed;
        opacity: 0.6;
    }

    textarea.form-control-custom {
        resize: vertical;
        min-height: 120px;
        font-family: inherit;
    }

    .form-select-custom {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 16 16'%3E%3Cpath fill='%2364748b' d='M8 11L3 6h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 12px;
        padding-right: 3rem;
    }

    .form-text {
        display: block;
        margin-top: 0.5rem;
        color: var(--text-secondary);
        font-size: 0.875rem;
    }

    .file-upload-area {
        border: 2px dashed var(--border-color);
        border-radius: 10px;
        padding: 2rem;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
        background: var(--bg-light);
    }

    .file-upload-area:hover {
        border-color: var(--info-blue);
        background: white;
    }

    .file-upload-area.dragover {
        border-color: var(--success-green);
        background: #d1fae5;
    }

    .file-upload-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .file-upload-text {
        color: var(--text-secondary);
        margin-bottom: 0.5rem;
    }

    .file-upload-text strong {
        color: var(--info-blue);
        cursor: pointer;
    }

    .file-input-hidden {
        display: none;
    }

    .file-preview {
        margin-top: 1rem;
        padding: 1rem;
        background: white;
        border: 2px solid var(--success-green);
        border-radius: 10px;
        display: none;
        align-items: center;
        gap: 1rem;
    }

    .file-preview.active {
        display: flex;
    }

    .file-preview-icon {
        font-size: 2rem;
    }

    .file-preview-info {
        flex: 1;
    }

    .file-preview-name {
        color: var(--text-primary);
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .file-preview-size {
        color: var(--text-secondary);
        font-size: 0.875rem;
    }

    .file-preview-remove {
        background: var(--primary-red);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.5rem 1rem;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .file-preview-remove:hover {
        background: var(--primary-red-hover);
        transform: scale(1.05);
    }

    .severity-options {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
    }

    .severity-option {
        position: relative;
    }

    .severity-option input[type="radio"] {
        display: none;
    }

    .severity-label {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        padding: 1.25rem 0.5rem;
        border: 2px solid var(--border-color);
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
        background: white;
        text-align: center;
    }

    .severity-label:hover {
        border-color: var(--info-blue);
        transform: translateY(-2px);
        box-shadow: var(--shadow-sm);
    }

    .severity-option input[type="radio"]:checked + .severity-label {
        border-width: 3px;
        background: var(--bg-light);
    }

    .severity-option input[type="radio"]:checked + .severity-label.leve {
        border-color: #10b981;
        background: #d1fae5;
    }

    .severity-option input[type="radio"]:checked + .severity-label.moderado {
        border-color: #f59e0b;
        background: #fef3c7;
    }

    .severity-option input[type="radio"]:checked + .severity-label.critico {
        border-color: var(--primary-red);
        background: #fee2e2;
    }

    .severity-icon {
        font-size: 2rem;
    }

    .severity-text {
        font-weight: 600;
        color: var(--text-primary);
    }

    .location-status {
        padding: 1rem;
        border-radius: 10px;
        margin-top: 1rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-weight: 600;
    }

    .location-status.loading {
        background: #fef3c7;
        color: #92400e;
        border: 2px solid #f59e0b;
    }

    .location-status.success {
        background: #d1fae5;
        color: #065f46;
        border: 2px solid var(--success-green);
    }

    .location-status.error {
        background: #fee2e2;
        color: #991b1b;
        border: 2px solid var(--primary-red);
    }

    .location-status .spinner {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 3px solid rgba(0,0,0,0.1);
        border-radius: 50%;
        border-top-color: currentColor;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    .location-coords {
        margin-top: 0.5rem;
        padding: 0.75rem;
        background: white;
        border-radius: 8px;
        font-family: 'Courier New', monospace;
        font-size: 0.875rem;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 2px solid var(--bg-light);
    }

    .btn-custom {
        flex: 1;
        padding: 1rem 1.5rem;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, var(--primary-red), #991b1b);
        color: white;
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
    }

    .btn-primary-custom:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(220, 38, 38, 0.4);
    }

    .btn-primary-custom:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none;
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

    .char-counter {
        text-align: right;
        color: var(--text-secondary);
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    .char-counter.warning {
        color: var(--warning-orange);
    }

    @media (max-width: 768px) {
        .emergency-form-container {
            padding: 0 0.5rem;
        }

        .form-card {
            padding: 1.5rem;
        }

        .form-header h1 {
            font-size: 1.5rem;
        }

        .severity-options {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn-custom {
            width: 100%;
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

<div class="emergency-form-container">
    <!-- Header -->
    <div class="form-header">
        <h1>
            <span>📝</span>
            Registrar Nueva Emergencia
        </h1>
        <p>Completa la información para que podamos asistirte rápidamente</p>
    </div>

    <!-- Alertas -->
    @if(session('error'))
        <div class="alert-custom alert-danger">
            <span class="icon">❌</span>
            <div>{{ session('error') }}</div>
        </div>
    @endif

    @if(session('success'))
        <div class="alert-custom alert-success">
            <span class="icon">✅</span>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    <!-- Formulario -->
    <div class="form-card">
        <form method="POST" action="{{ route('emergencia.guardar') }}" id="form-emergencia" enctype="multipart/form-data">
            @csrf

            <!-- Sección: Información de la Emergencia -->
            <div class="form-section">
                <h3 class="section-title">
                    <span>🚨</span>
                    Información de la Emergencia
                </h3>

                <div class="form-group">
                    <label class="form-label">
                        Tipo de emergencia
                        <span class="required">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="tipo_emergencia" 
                        class="form-control-custom" 
                        placeholder="Ej: Accidente, Incendio, Asalto, Médica..."
                        required
                        maxlength="100"
                        value="{{ old('tipo_emergencia') }}"
                    >
                    <span class="form-text">Describe brevemente el tipo de situación</span>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        Descripción detallada
                        <span class="required">*</span>
                    </label>
                    <textarea 
                        name="sintomas" 
                        id="sintomas"
                        class="form-control-custom" 
                        rows="6" 
                        placeholder="Describe lo que está sucediendo con el mayor detalle posible..."
                        required
                        maxlength="1000"
                    >{{ old('sintomas') }}</textarea>
                    <div class="char-counter" id="char-counter">0 / 1000 caracteres</div>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        Nivel de gravedad
                        <span class="required">*</span>
                    </label>
                    <div class="severity-options">
                        <div class="severity-option">
                            <input type="radio" name="gravedad" value="leve" id="leve" required>
                            <label for="leve" class="severity-label leve">
                                <span class="severity-icon">🟢</span>
                                <span class="severity-text">Leve</span>
                            </label>
                        </div>
                        <div class="severity-option">
                            <input type="radio" name="gravedad" value="moderado" id="moderado">
                            <label for="moderado" class="severity-label moderado">
                                <span class="severity-icon">🟡</span>
                                <span class="severity-text">Moderado</span>
                            </label>
                        </div>
                        <div class="severity-option">
                            <input type="radio" name="gravedad" value="critico" id="critico">
                            <label for="critico" class="severity-label critico">
                                <span class="severity-icon">🔴</span>
                                <span class="severity-text">Crítico</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sección: Archivo Multimedia -->
            <div class="form-section">
                <h3 class="section-title">
                    <span>📎</span>
                    Archivo Multimedia
                    <span class="optional">(opcional)</span>
                </h3>

                <div class="form-group">
                    <div class="file-upload-area" id="file-upload-area">
                        <div class="file-upload-icon">📁</div>
                        <div class="file-upload-text">
                            <strong>Haz clic para seleccionar</strong> o arrastra un archivo aquí
                        </div>
                        <div class="form-text">
                            Fotos, videos o audios • Máximo 10MB
                        </div>
                    </div>
                    <input 
                        type="file" 
                        name="archivo" 
                        id="archivo"
                        class="file-input-hidden" 
                        accept="image/*,video/*,audio/*"
                    >
                    <div class="file-preview" id="file-preview">
                        <span class="file-preview-icon">📄</span>
                        <div class="file-preview-info">
                            <div class="file-preview-name" id="file-name"></div>
                            <div class="file-preview-size" id="file-size"></div>
                        </div>
                        <button type="button" class="file-preview-remove" id="file-remove">
                            🗑️ Eliminar
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sección: Ubicación -->
            <div class="form-section">
                <h3 class="section-title">
                    <span>📍</span>
                    Ubicación Automática
                </h3>

                <div class="form-group">
                    <input type="hidden" id="lat" name="latitud" required>
                    <input type="hidden" id="lng" name="longitud" required>
                    
                    <div id="ubicacion-status" class="location-status loading">
                        <span class="spinner"></span>
                        <span>Obteniendo tu ubicación...</span>
                    </div>
                </div>
            </div>

            <!-- Acciones -->
            <div class="form-actions">
                <button type="submit" id="btn-enviar" class="btn-custom btn-primary-custom" disabled>
                    <span>🚨</span>
                    Enviar Emergencia
                </button>
                <a href="{{ route('dashboard') }}" class="btn-custom btn-secondary-custom">
                    <span>←</span>
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<script>
class EmergencyFormHandler {
    constructor() {
        this.form = document.getElementById('form-emergencia');
        this.fileInput = document.getElementById('archivo');
        this.fileUploadArea = document.getElementById('file-upload-area');
        this.filePreview = document.getElementById('file-preview');
        this.submitBtn = document.getElementById('btn-enviar');
        this.locationStatus = document.getElementById('ubicacion-status');
        this.latInput = document.getElementById('lat');
        this.lngInput = document.getElementById('lng');
        this.sintomasTextarea = document.getElementById('sintomas');
        this.charCounter = document.getElementById('char-counter');
        
        this.init();
    }

    init() {
        this.setupFileUpload();
        this.setupCharCounter();
        this.getLocation();
        this.setupFormValidation();
    }

    setupFileUpload() {
        // Click en el área de carga
        this.fileUploadArea.addEventListener('click', () => {
            this.fileInput.click();
        });

        // Cambio de archivo
        this.fileInput.addEventListener('change', (e) => {
            this.handleFileSelect(e.target.files[0]);
        });

        // Drag and drop
        this.fileUploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            this.fileUploadArea.classList.add('dragover');
        });

        this.fileUploadArea.addEventListener('dragleave', () => {
            this.fileUploadArea.classList.remove('dragover');
        });

        this.fileUploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            this.fileUploadArea.classList.remove('dragover');
            const file = e.dataTransfer.files[0];
            if (file) {
                this.fileInput.files = e.dataTransfer.files;
                this.handleFileSelect(file);
            }
        });

        // Botón de eliminar
        document.getElementById('file-remove').addEventListener('click', () => {
            this.clearFile();
        });
    }

    handleFileSelect(file) {
        if (!file) return;

        // Validar tamaño (10MB)
        const maxSize = 10 * 1024 * 1024;
        if (file.size > maxSize) {
            this.showNotification('❌ El archivo es demasiado grande. Máximo 10MB', 'error');
            this.clearFile();
            return;
        }

        // Validar tipo
        const validTypes = ['image/', 'video/', 'audio/'];
        const isValid = validTypes.some(type => file.type.startsWith(type));
        if (!isValid) {
            this.showNotification('❌ Tipo de archivo no permitido', 'error');
            this.clearFile();
            return;
        }

        // Mostrar preview
        const icon = this.getFileIcon(file.type);
        document.getElementById('file-name').textContent = file.name;
        document.getElementById('file-size').textContent = this.formatFileSize(file.size);
        document.querySelector('.file-preview-icon').textContent = icon;
        this.filePreview.classList.add('active');
        this.fileUploadArea.style.display = 'none';
    }

    clearFile() {
        this.fileInput.value = '';
        this.filePreview.classList.remove('active');
        this.fileUploadArea.style.display = 'block';
    }

    getFileIcon(type) {
        if (type.startsWith('image/')) return '🖼️';
        if (type.startsWith('video/')) return '🎥';
        if (type.startsWith('audio/')) return '🎵';
        return '📄';
    }

    formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
    }

    setupCharCounter() {
        this.sintomasTextarea.addEventListener('input', () => {
            const length = this.sintomasTextarea.value.length;
            const maxLength = 1000;
            this.charCounter.textContent = `${length} / ${maxLength} caracteres`;
            
            if (length > maxLength * 0.9) {
                this.charCounter.classList.add('warning');
            } else {
                this.charCounter.classList.remove('warning');
            }
        });
    }

    getLocation() {
        if (!navigator.geolocation) {
            this.showLocationError('Tu navegador no soporta geolocalización');
            return;
        }

        navigator.geolocation.getCurrentPosition(
            (position) => {
                this.latInput.value = position.coords.latitude.toFixed(6);
                this.lngInput.value = position.coords.longitude.toFixed(6);
                this.showLocationSuccess(position.coords);
                this.submitBtn.disabled = false;
            },
            (error) => {
                let message = 'No se pudo obtener tu ubicación';
                if (error.code === error.PERMISSION_DENIED) {
                    message = 'Permiso de ubicación denegado. Por favor, actívalo en tu navegador';
                }
                this.showLocationError(message);
            },
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            }
        );
    }

    showLocationSuccess(coords) {
        this.locationStatus.className = 'location-status success';
        this.locationStatus.innerHTML = `
            <span>✅</span>
            <div>
                <div>Ubicación obtenida correctamente</div>
                <div class="location-coords">
                    📍 ${coords.latitude.toFixed(6)}, ${coords.longitude.toFixed(6)}
                    <br>
                    <small>Precisión: ±${Math.round(coords.accuracy)} metros</small>
                </div>
            </div>
        `;
    }

    showLocationError(message) {
        this.locationStatus.className = 'location-status error';
        this.locationStatus.innerHTML = `
            <span>❌</span>
            <span>${message}</span>
        `;
    }

    setupFormValidation() {
        this.form.addEventListener('submit', (e) => {
            if (!this.latInput.value || !this.lngInput.value) {
                e.preventDefault();
                this.showNotification('❌ Se requiere la ubicación para enviar la emergencia', 'error');
                return false;
            }

            this.submitBtn.disabled = true;
            this.submitBtn.innerHTML = '<span class="spinner"></span> Enviando...';
        });
    }

    showNotification(message, type) {
        const notification = document.createElement('div');
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: ${type === 'error' ? '#dc2626' : '#059669'};
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            z-index: 10000;
            animation: slideIn 0.3s ease;
            max-width: 400px;
        `;
        notification.textContent = message;
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => notification.remove(), 300);
        }, 4000);
    }
}

// Inicializar
document.addEventListener('DOMContentLoaded', () => {
    new EmergencyFormHandler();
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