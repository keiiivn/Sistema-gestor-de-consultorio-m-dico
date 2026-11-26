<?php

namespace App\Http\Controllers;

use App\Models\Medico;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $medicos = Medico::with('usuario')
            ->where('activo', true)
            ->orderBy('especialidad')
            ->get();

        return view('home', compact('medicos'));
    }
}
