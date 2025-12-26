<?php

namespace App\Http\Controllers;

use App\Models\Emergencia;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $emergencias = Emergencia::with('paciente')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.dashboard', compact('emergencias'));
    }

    public function filtrar(Request $request)
    {
        $query = Emergencia::with('paciente');

        if ($request->estado) {
            $query->where('estado', $request->estado);
        }

        if ($request->gravedad) {
            $query->where('gravedad', $request->gravedad);
        }

        if ($request->fecha_desde) {
            $query->whereDate('created_at', '>=', $request->fecha_desde);
        }

        if ($request->paciente) {
            $query->whereHas('paciente', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->paciente . '%')
                  ->orWhere('email', 'like', '%' . $request->paciente . '%');
            });
        }

        $emergencias = $query->orderBy('created_at', 'desc')->get();

        return view('admin.emergencias-lista', compact('emergencias'));
    }

    // 👇 Método que faltaba para la ruta /admin/mapa
    public function mapa()
    {
        // Puedes pasar datos de emergencias con coordenadas si las tienes
        $emergencias = Emergencia::with('paciente')
            ->whereNotNull('latitud')
            ->whereNotNull('longitud')
            ->get();

        return view('admin.mapa', compact('emergencias'));
    }
}