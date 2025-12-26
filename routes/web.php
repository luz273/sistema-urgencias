<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Emergencia;

// Ruta pública
Route::get('/', function () {
    return view('welcome');
});

// Autenticación
require __DIR__.'/auth.php';

// === RUTAS PROTEGIDAS POR AUTENTICACIÓN ===
Route::middleware(['auth'])->group(function () {

    // Dashboard según rol
    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'administrador') {
            return redirect()->route('admin.dashboard');
        }
        return view('paciente.dashboard');
    })->name('dashboard');

    // 🚨 Emergencia rápida (botón SOS)
    Route::post('/emergencia/rapida', function () {
        $data = request()->validate([
            'lat' => 'required',
            'lng' => 'required'
        ]);

        $emergencia = auth()->user()->emergencias()->create([
            'tipo_emergencia' => 'Emergencia Rápida',
            'sintomas'        => 'Botón de emergencia activado',
            'gravedad'        => 'critico',
            'latitud'         => $data['lat'],
            'longitud'        => $data['lng'],
            'estado'          => 'pendiente'
        ]);

        return response()->json(['id' => $emergencia->id]);
    })->name('emergencia.rapida');

    // 📝 Formulario de emergencia manual (paciente)
    Route::get('/emergencia/nueva', function () {
        return view('paciente.emergencia-nueva');
    })->name('emergencia.nueva');

    Route::post('/emergencia/guardar', function () {
        $data = request()->validate([
            'tipo_emergencia' => 'required|string',
            'sintomas'        => 'required|string',
            'gravedad'        => 'required|in:leve,moderado,critico',
            'latitud'         => 'required|string',
            'longitud'        => 'required|string',
        ]);

        auth()->user()->emergencias()->create($data + ['estado' => 'pendiente']);

        return redirect()
            ->route('mis.emergencias')
            ->with('success', 'Emergencia registrada correctamente');
    })->name('emergencia.guardar');

    // 📋 Mis emergencias (paciente)
    Route::get('/mis-emergencias', function () {
        $emergencias = auth()->user()->emergencias;
        return view('paciente.emergencias', compact('emergencias'));
    })->name('mis.emergencias');

    // 🗺️ Mapa de una emergencia (paciente)
    Route::get('/emergencia/{id}/mapa', function ($id) {
        $emergencia = auth()->user()->emergencias()->findOrFail($id);
        return view('paciente.emergencia-mapa', compact('emergencia'));
    })->name('emergencia.mapa');

    // 👤 Perfil del paciente
    Route::get('/paciente/perfil', function () {
        return view('paciente.perfil', ['user' => auth()->user()]);
    })->name('paciente.perfil');

    Route::post('/paciente/perfil/guardar', function () {
        $data = request()->validate([
            'dni' => 'nullable|string|max:20',
            'telefono' => 'nullable|string',
            'contacto_emergencia' => 'nullable|string',
            'informacion_medica' => 'nullable|string',
            'alergias' => 'nullable|array',
            'alergias.*' => 'string',
        ]);

        $user = auth()->user();
        $user->update([
            'dni' => $data['dni'] ?? null,
            'telefono' => $data['telefono'] ?? null,
            'contacto_emergencia' => $data['contacto_emergencia'] ?? null,
            'informacion_medica' => $data['informacion_medica'] ?? null,
            'alergias' => json_encode($data['alergias'] ?? []),
        ]);

        return back()->with('success', '✅ Tu perfil médico ha sido actualizado correctamente');
    })->name('paciente.perfil.guardar');
});

// === RUTAS EXCLUSIVAS DE ADMINISTRADOR ===
Route::middleware(['auth', 'role:administrador'])->group(function () {

    // 🏠 Dashboard
    Route::get('/admin/dashboard', function () {
        $emergencias = Emergencia::with('paciente')->orderBy('created_at', 'desc')->get();
        return view('admin.dashboard', compact('emergencias'));
    })->name('admin.dashboard');

    // 👥 Gestión de usuarios
    Route::get('/admin/usuarios', function () {
        $usuarios = User::all();
        return view('admin.usuarios', compact('usuarios'));
    })->name('admin.usuarios');

    Route::patch('/admin/usuarios/{id}/rol', function ($id) {
        $user = User::findOrFail($id);
        request()->validate([
            'role' => 'required|in:paciente,administrador',
        ]);
        $user->update(['role' => request('role')]);
        return back()->with('success', 'Rol actualizado correctamente');
    })->name('admin.usuarios.rol');

    // 🗺️ Mapa de emergencias
    Route::get('/admin/mapa', function () {
        return view('admin.mapa');
    })->name('admin.mapa');

    Route::get('/admin/mapa/data', function () {
        $emergencias = Emergencia::with('paciente')->get()->map(function ($e) {
            return [
                'id' => $e->id,
                'latitud' => $e->latitud,
                'longitud' => $e->longitud,
                'tipo_emergencia' => $e->tipo_emergencia,
                'gravedad' => $e->gravedad,
                'estado' => $e->estado,
                'paciente_name' => $e->paciente->name ?? 'N/A'
            ];
        });
        return response()->json($emergencias);
    })->name('admin.mapa.data');

    // 🔍 Filtrado de emergencias
    Route::post('/admin/emergencias/filtrar', function () {
        $query = Emergencia::with('paciente');

        if (request('estado')) $query->where('estado', request('estado'));
        if (request('gravedad')) $query->where('gravedad', request('gravedad'));
        if (request('fecha_desde')) $query->whereDate('created_at', '>=', request('fecha_desde'));
        if (request('paciente')) {
            $query->whereHas('paciente', function ($q) {
                $q->where('name', 'like', '%' . request('paciente') . '%')
                  ->orWhere('email', 'like', '%' . request('paciente') . '%');
            });
        }

        $emergencias = $query->orderBy('created_at', 'desc')->get();
        return view('admin.emergencias-lista', compact('emergencias'));
    })->name('admin.emergencias.filtrar');

    // ➕ Crear nueva emergencia (desde admin)
    Route::get('/admin/emergencias/nueva', function () {
        return view('admin.emergencia-nueva');
    })->name('admin.emergencia.nueva');

    Route::post('/admin/emergencias/guardar', function () {
        $data = request()->validate([
            'tipo_emergencia' => 'required|string',
            'sintomas' => 'required|string',
            'gravedad' => 'required|in:leve,moderado,critico',
            'latitud' => 'required|string',
            'longitud' => 'required|string',
        ]);

        Emergencia::create($data + ['estado' => 'pendiente']);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Emergencia registrada correctamente');
    })->name('admin.emergencia.guardar');

    // ✏️ Editar emergencia
    Route::get('/admin/emergencias/{id}/editar', function ($id) {
        $emergencia = Emergencia::findOrFail($id);
        return view('admin.emergencia-edit', compact('emergencia'));
    })->name('admin.emergencia.edit');

    // ✅ Actualizar emergencia (estado y gravedad)
    Route::put('/admin/emergencias/{id}', function ($id) {
        $data = request()->validate([
            'estado' => 'required|in:pendiente,en_curso,finalizada,atendida',
            'gravedad' => 'required|in:leve,moderado,critico',
        ]);

        Emergencia::findOrFail($id)->update($data);

        return redirect()->route('admin.dashboard')
            ->with('success', '✅ Emergencia actualizada correctamente');
    })->name('admin.emergencia.update');

    // ✅ Confirmar atención (marca como finalizada)
    Route::patch('/admin/emergencias/{id}/confirmar', function ($id) {
        $emergencia = Emergencia::findOrFail($id);
        $emergencia->update(['estado' => 'finalizada']);
        return back()->with('success', 'Atención confirmada correctamente');
    })->name('admin.emergencias.confirmar');

    // 📊 Estadísticas
    Route::get('/admin/estadisticas', function () {
        $total = Emergencia::count();
        $pendientes = Emergencia::where('estado', 'pendiente')->count();
        $criticas = Emergencia::where('gravedad', 'critico')->count();
        $pacientes = User::where('role', 'paciente')->count();

        return view('admin.estadisticas', compact('total','pendientes','criticas','pacientes'));
    })->name('admin.estadisticas');

    // 📥 Exportar reporte PDF
    Route::get('/admin/reporte.pdf', function () {
        $emergencias = Emergencia::with('paciente')->latest()->get();

        if (!class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            abort(500, 'PDF no disponible. Instala barryvdh/laravel-dompdf.');
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.reporte', compact('emergencias'));
        return $pdf->download('reporte_emergencias_' . now()->format('Y-m-d') . '.pdf');
    })->name('admin.reporte.pdf');

     Route::get('/admin/historial-emergencias', function () {
    $emergencias = \App\Models\Emergencia::with('paciente')
        ->orderBy('created_at', 'desc')
        ->get();
    return view('admin.historial-emergencias', compact('emergencias'));
    })->name('admin.historial.emergencias');
    

});
