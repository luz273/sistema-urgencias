@if($emergencias->isNotEmpty())
    <div class="space-y-4">
        @foreach($emergencias as $e)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 hover:shadow-md transition-shadow">
                <div class="flex flex-col lg:flex-row lg:justify-between lg:items-start gap-4">
                    <!-- Información principal -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-2">
                            <h3 class="text-lg font-bold text-gray-900 truncate">
                                🆔 #{{ $e->id }} — {{ $e->tipo_emergencia }}
                            </h3>
                            @if($e->created_at)
                                <span class="text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full">
                                    {{ $e->created_at->format('d/m/Y H:i') }}
                                </span>
                            @endif
                        </div>

                        <p class="text-sm text-gray-600 mb-2">
                            👤 <strong>Paciente:</strong>
                            {{ optional($e->paciente)->name ?? '—' }}
                            @if($e->paciente?->email)
                                (<a href="mailto:{{ $e->paciente->email }}" class="text-blue-600 hover:underline">{{ $e->paciente->email }}</a>)
                            @endif
                        </p>

                        <p class="text-gray-800 mb-2">
                            <strong>Síntomas:</strong> {{ $e->sintomas ?? '—' }}
                        </p>

                        <p class="text-sm text-gray-600 flex items-center gap-1">
                            📍 <strong>Ubicación:</strong>
                            {{ $e->latitud && $e->longitud ? "{$e->latitud}, {$e->longitud}" : 'No disponible' }}
                        </p>
                    </div>

                    <!-- Badges de estado y gravedad -->
                    <div class="flex flex-wrap gap-2 justify-start lg:justify-end">
                        <!-- Gravedad -->
                        <span class="px-3 py-1 rounded-full text-xs font-semibold whitespace-nowrap
                            @if($e->gravedad === 'critico')
                                bg-red-100 text-red-800
                            @elseif($e->gravedad === 'moderado')
                                bg-yellow-100 text-yellow-800
                            @else
                                bg-green-100 text-green-800
                            @endif">
                            {{ ucfirst($e->gravedad) }}
                        </span>

                        <!-- Estado -->
                        <span class="px-3 py-1 rounded-full text-xs font-semibold whitespace-nowrap
                            @if($e->estado === 'pendiente')
                                bg-gray-100 text-gray-800
                            @elseif($e->estado === 'atendida')
                                bg-green-100 text-green-800
                            @else
                                bg-blue-100 text-blue-800
                            @endif">
                            {{ ucfirst(str_replace('_', ' ', $e->estado)) }}
                        </span>
                    </div>
                </div>

                <!-- Acciones -->
                <div class="mt-4 flex flex-wrap gap-2">
                    @if(!empty($e->archivo))
                        <button
                            class="btn btn-outline-secondary btn-sm flex items-center gap-1"
                            onclick="openModal('{{ asset('storage/' . $e->archivo) }}')">
                            📎 Ver Archivo
                        </button>
                    @endif

                    <a href="{{ route('admin.emergencia.edit', $e->id) }}"
                       class="btn btn-primary btn-sm flex items-center gap-1">
                        ✏️ Editar
                    </a>

                    @if($e->estado !== 'atendida')
                        <form method="POST" action="{{ route('admin.emergencias.confirmar', $e->id) }}" class="inline-block">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    class="btn btn-success btn-sm flex items-center gap-1"
                                    onclick="return confirm('¿Confirmar atención de esta emergencia?')">
                                ✅ Confirmar Atención
                            </button>
                        </form>
                    @else
                        <span class="px-3 py-1.5 rounded-lg bg-green-50 text-green-700 text-sm font-medium flex items-center gap-1">
                            ✅ Atención confirmada
                        </span>
                    @endif

                    <!-- Botón Mapa -->
                    @if($e->latitud && $e->longitud)
                        <a href="{{ route('emergencia.mapa', $e->id) }}"
                           class="btn btn-info btn-sm flex items-center gap-1"
                           target="_blank">
                            🗺️ Ver en Mapa
                        </a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="text-center py-12">
        <div class="text-4xl mb-4">📭</div>
        <h3 class="text-lg font-medium text-gray-700">No se encontraron emergencias</h3>
        <p class="text-gray-500 mt-1">Intenta ajustar los filtros o crea una nueva emergencia.</p>
    </div>
@endif

<!-- Modal para archivos -->
<div id="archivo-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl max-w-4xl w-full max-h-[90vh] overflow-auto">
        <div class="flex justify-between items-center p-4 border-b">
            <h3 class="font-bold">Archivo Adjunto</h3>
            <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
        </div>
        <div class="p-4" id="modal-content">
            <!-- Aquí se carga dinámicamente -->
        </div>
    </div>
</div>

<script>
function openModal(url) {
    const modal = document.getElementById('archivo-modal');
    const content = document.getElementById('modal-content');

    const ext = url.split('.').pop().toLowerCase();
    if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext)) {
        content.innerHTML = `<img src="${url}" alt="Archivo adjunto" class="max-w-full max-h-[70vh] object-contain">`;
    } else if (ext === 'pdf') {
        content.innerHTML = `<iframe src="${url}" class="w-full h-[70vh]" title="PDF"></iframe>`;
    } else {
        content.innerHTML = `<a href="${url}" target="_blank" class="text-blue-600 hover:underline text-lg">📄 Abrir: ${url.split('/').pop()}</a>`;
    }

    modal.classList.remove('hidden');
}

function closeModal() {
    document.getElementById('archivo-modal').classList.add('hidden');
}

document.getElementById('archivo-modal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});
</script>

<style>
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    font-weight: 600;
    font-size: 0.875rem;
    text-decoration: none;
    transition: all 0.2s;
    border: 1px solid transparent;
}

.btn-primary {
    background: #dc2626;
    color: white;
}
.btn-primary:hover {
    background: #b91c1c;
    transform: translateY(-1px);
}

.btn-success {
    background: #059669;
    color: white;
}
.btn-success:hover {
    background: #047857;
}

.btn-info {
    background: #3b82f6;
    color: white;
}
.btn-info:hover {
    background: #2563eb;
}

.btn-outline-secondary {
    background: transparent;
    border-color: #e2e8f0;
    color: #475569;
}
.btn-outline-secondary:hover {
    background: #f1f5f9;
}

.btn-sm {
    padding: 0.375rem 0.75rem;
    font-size: 0.8125rem;
}
</style>