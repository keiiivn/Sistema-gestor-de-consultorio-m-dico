<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Consulta;
use App\Models\Paciente;
use App\Models\Receta;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $inicioMes = now()->startOfMonth();

        $estadisticas = [
            'pacientes' => Paciente::where('activo', true)->count(),
            'citas_hoy' => Cita::hoy()->count(),
            'consultas_mes' => Consulta::where('fecha', '>=', $inicioMes)->count(),
            'recetas_mes' => Receta::where('fecha_registro', '>=', $inicioMes)->count(),
        ];

        $citasHoy = Cita::hoy()
            ->with(['paciente', 'medico.usuario'])
            ->orderBy('fecha')
            ->get();

        $proximasCitas = Cita::proximas()
            ->whereDate('fecha', '>', today())
            ->with(['paciente', 'medico.usuario'])
            ->take(5)
            ->get();

        $pacientesRecientes = Paciente::with('medico.usuario')
            ->orderByDesc('fecha_registro')
            ->take(5)
            ->get();

        return view('panel.dashboard', compact(
            'estadisticas',
            'citasHoy',
            'proximasCitas',
            'pacientesRecientes'
        ));
    }
}
