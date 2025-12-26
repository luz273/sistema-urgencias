<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedAlert - Plataforma de Emergencias Médicas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }
        @keyframes pulse-dot {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        .animate-fadeInUp { animation: fadeInUp 0.6s ease-out; }
        .animate-float { animation: float 3s ease-in-out infinite; }
    </style>
</head>

<body class="bg-gradient-to-br from-gray-50 to-gray-100 text-gray-900 antialiased">
    
    <!-- Navbar Fijo -->
    <nav class="fixed top-0 left-0 right-0 bg-white shadow-sm z-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="bg-red-600 p-2.5 rounded-xl shadow-md">
                        <span class="text-2xl">🚑</span>
                    </div>
                    <div>
                        <span class="text-2xl font-bold text-gray-900">MedAlert</span>
                        <p class="text-xs text-red-600 font-medium -mt-1">Emergencias Médicas</p>
                    </div>
                </div>
                
                <!-- Links de navegación -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-gray-600 hover:text-red-600 transition font-medium">Características</a>
                    <a href="#stats" class="text-gray-600 hover:text-red-600 transition font-medium">Estadísticas</a>
                    <a href="#contact" class="text-gray-600 hover:text-red-600 transition font-medium">Contacto</a>
                </div>

                <!-- Botones de Auth -->
                <div class="flex items-center space-x-3">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="bg-red-600 text-white px-6 py-2.5 rounded-lg hover:bg-red-700 transition font-medium shadow-md">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="text-gray-700 hover:text-red-600 px-5 py-2.5 rounded-lg hover:bg-gray-50 transition font-medium">
                                Ingresar
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="bg-red-600 text-white px-6 py-2.5 rounded-lg hover:bg-red-700 transition font-medium shadow-md">
                                    Registrarse
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-32 pb-20 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <!-- Contenido Izquierdo -->
                <div class="animate-fadeInUp">
                    <div class="inline-flex items-center bg-red-50 border border-red-200 text-red-700 px-4 py-2 rounded-full mb-6">
                        <span class="w-2 h-2 bg-red-600 rounded-full mr-2 animate-pulse"></span>
                        <span class="text-sm font-semibold">Sistema Activo 24/7</span>
                    </div>
                    
                    <h1 class="text-5xl lg:text-6xl font-extrabold text-gray-900 mb-6 leading-tight">
                        Emergencias Médicas
                        <span class="text-red-600 block mt-2">en Tiempo Real</span>
                    </h1>
                    
                    <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                        Sistema profesional de gestión de emergencias con GPS, comunicación en tiempo real 
                        y coordinación eficiente entre equipos médicos.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="inline-flex items-center justify-center bg-red-600 text-white px-8 py-4 rounded-xl hover:bg-red-700 transition font-semibold shadow-lg hover:shadow-xl transform hover:scale-105">
                                Ir al Dashboard
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </a>
                        @else
                            <a href="{{ route('register') }}"
                                class="inline-flex items-center justify-center bg-red-600 text-white px-8 py-4 rounded-xl hover:bg-red-700 transition font-semibold shadow-lg hover:shadow-xl transform hover:scale-105">
                                Comenzar Ahora
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </a>
                        @endauth
                        
                        <a href="#features"
                            class="inline-flex items-center justify-center border-2 border-gray-300 text-gray-700 px-8 py-4 rounded-xl hover:border-red-600 hover:text-red-600 transition font-semibold">
                            Conocer Más
                        </a>
                    </div>
                </div>

                <!-- Imagen Derecha -->
                <div class="relative animate-fadeInUp" style="animation-delay: 0.2s;">
                    <div class="bg-gradient-to-br from-red-50 to-pink-50 rounded-3xl p-12 shadow-2xl animate-float">
                        <div class="text-center">
                            <div class="mb-8">
                                <span class="text-9xl">🚑</span>
                            </div>
                            
                            <!-- Tarjetas de características -->
                            <div class="space-y-4">
                                <div class="bg-white rounded-2xl p-5 shadow-lg">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-14 h-14 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center shadow-md">
                                                <span class="text-2xl">⚡</span>
                                            </div>
                                            <div class="text-left">
                                                <p class="font-bold text-gray-900 text-lg">Respuesta Inmediata</p>
                                                <p class="text-sm text-gray-500">Menos de 3 minutos</p>
                                            </div>
                                        </div>
                                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-white rounded-2xl p-5 shadow-lg">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-md">
                                                <span class="text-2xl">📍</span>
                                            </div>
                                            <div class="text-left">
                                                <p class="font-bold text-gray-900 text-lg">GPS Preciso</p>
                                                <p class="text-sm text-gray-500">Ubicación en tiempo real</p>
                                            </div>
                                        </div>
                                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section id="stats" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="text-center p-6 bg-gradient-to-br from-red-50 to-red-100 rounded-2xl">
                    <div class="text-5xl font-black text-red-600 mb-2">< 3min</div>
                    <p class="text-sm text-gray-700 font-semibold">Tiempo de Respuesta</p>
                </div>
                <div class="text-center p-6 bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl">
                    <div class="text-5xl font-black text-blue-600 mb-2">24/7</div>
                    <p class="text-sm text-gray-700 font-semibold">Disponibilidad</p>
                </div>
                <div class="text-center p-6 bg-gradient-to-br from-green-50 to-green-100 rounded-2xl">
                    <div class="text-5xl font-black text-green-600 mb-2">100%</div>
                    <p class="text-sm text-gray-700 font-semibold">Cobertura GPS</p>
                </div>
                <div class="text-center p-6 bg-gradient-to-br from-purple-50 to-purple-100 rounded-2xl">
                    <div class="text-5xl font-black text-purple-600 mb-2">95%</div>
                    <p class="text-sm text-gray-700 font-semibold">Tasa de Éxito</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">
                    Características del Sistema
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Tecnología avanzada para salvar vidas de manera eficiente
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white p-8 rounded-2xl shadow-md hover:shadow-xl transition group">
                    <div class="w-16 h-16 bg-gradient-to-br from-red-500 to-red-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Dashboard en Tiempo Real</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Monitoreo centralizado de todas las emergencias activas con información actualizada al instante.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white p-8 rounded-2xl shadow-md hover:shadow-xl transition group">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Geolocalización GPS</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Ubicación precisa y automática de emergencias con navegación optimizada para equipos de rescate.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white p-8 rounded-2xl shadow-md hover:shadow-xl transition group">
                    <div class="w-16 h-16 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9l-5 4.74L18.18 22 12 18.77 5.82 22 7 13.74 2 9l6.91-.74L12 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Clasificación Inteligente</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Sistema de triaje que prioriza emergencias según severidad para optimizar recursos.
                    </p>
                </div>

                <!-- Feature 4 -->
                <div class="bg-white p-8 rounded-2xl shadow-md hover:shadow-xl transition group">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM9 11H7V9h2v2zm4 0h-2V9h2v2zm4 0h-2V9h2v2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Comunicación Directa</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Chat en tiempo real entre operadores, médicos y pacientes para coordinación eficiente.
                    </p>
                </div>

                <!-- Feature 5 -->
                <div class="bg-white p-8 rounded-2xl shadow-md hover:shadow-xl transition group">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Historial Completo</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Registro detallado de todas las emergencias con seguimiento y reportes personalizados.
                    </p>
                </div>

                <!-- Feature 6 -->
                <div class="bg-white p-8 rounded-2xl shadow-md hover:shadow-xl transition group">
                    <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Notificaciones Inteligentes</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Alertas instantáneas para todos los involucrados con actualizaciones de estado en tiempo real.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24 bg-gradient-to-r from-red-600 to-red-700 text-white">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h2 class="text-4xl md:text-5xl font-extrabold mb-6">
                ¿Listo para transformar la atención de emergencias?
            </h2>
            <p class="text-xl mb-10 opacity-95">
                Únete a la plataforma que está salvando vidas con tecnología de vanguardia
            </p>
            <div class="flex flex-col sm:flex-row gap-5 justify-center">
                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                        class="bg-white text-red-600 px-10 py-4 rounded-xl hover:bg-gray-50 transition font-bold shadow-2xl text-lg">
                        Crear Cuenta Gratuita
                    </a>
                @endif
                
                @if (Route::has('login'))
                    <a href="{{ route('login') }}"
                        class="border-2 border-white text-white px-10 py-4 rounded-xl hover:bg-white hover:text-red-600 transition font-bold text-lg">
                        Iniciar Sesión
                    </a>
                @endif
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact" class="bg-gray-900 text-gray-400 py-16">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid md:grid-cols-4 gap-12 mb-12">
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="bg-red-600 p-2.5 rounded-xl">
                            <span class="text-2xl">🚑</span>
                        </div>
                        <span class="text-xl font-bold text-white">MedAlert</span>
                    </div>
                    <p class="text-sm leading-relaxed">
                        Sistema profesional de gestión de emergencias médicas.
                    </p>
                </div>
                
                <div>
                    <h3 class="text-white font-bold mb-4">Producto</h3>
                    <ul class="space-y-3 text-sm">
                        <li><a href="#features" class="hover:text-white transition">Características</a></li>
                        <li><a href="#stats" class="hover:text-white transition">Estadísticas</a></li>
                        <li><a href="#" class="hover:text-white transition">Precios</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-white font-bold mb-4">Empresa</h3>
                    <ul class="space-y-3 text-sm">
                        <li><a href="#" class="hover:text-white transition">Sobre Nosotros</a></li>
                        <li><a href="#" class="hover:text-white transition">Blog</a></li>
                        <li><a href="#" class="hover:text-white transition">Carreras</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-white font-bold mb-4">Legal</h3>
                    <ul class="space-y-3 text-sm">
                        <li><a href="#" class="hover:text-white transition">Términos</a></li>
                        <li><a href="#" class="hover:text-white transition">Privacidad</a></li>
                        <li><a href="#" class="hover:text-white transition">Contacto</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 pt-8 text-center text-sm">
                <p>© {{ date('Y') }} MedAlert. Todos los derechos reservados. Salvando vidas con tecnología.</p>
            </div>
        </div>
    </footer>

</body>
</html>