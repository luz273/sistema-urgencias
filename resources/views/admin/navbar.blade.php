<nav class="bg-white shadow-sm border-b">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <span class="text-xl font-bold text-gray-800">🏥 Panel Admin</span>
            </div>

            <div class="flex items-center space-x-6">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-900 font-medium">Dashboard</a>
                <a href="{{ route('admin.usuarios') }}" class="text-gray-600 hover:text-gray-900 font-medium">👥 Usuarios</a>
                <a href="{{ route('admin.mapa') }}" class="text-gray-600 hover:text-gray-900 font-medium">🗺️ Mapa</a>
                <a href="{{ route('admin.estadisticas') }}" class="text-gray-600 hover:text-gray-900 font-medium">📈 Estadísticas</a>
                <a href="{{ route('admin.emergencia.nueva') }}" class="text-gray-600 hover:text-gray-900 font-medium">🚨 Nueva Emergencia</a>
                <a href="{{ route('admin.reporte.pdf') }}" class="text-gray-600 hover:text-gray-900 font-medium">📄 PDF</a>
                
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-sm text-gray-600 hover:text-red-600 font-medium">Cerrar sesión</button>
                </form>
            </div>
        </div>
    </div>
</nav>