<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EstudioController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MedicoController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\RecetaController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'create'])->name('login');
    Route::post('login', [LoginController::class, 'store'])->name('login.store');
});

Route::post('salir', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::middleware(['auth', 'role:admin,medico,recepcionista'])
    ->prefix('panel')
    ->name('panel.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('pacientes', PacienteController::class);
        Route::resource('citas', CitaController::class);
        Route::patch('citas/{cita}/estado', [CitaController::class, 'actualizarEstado'])->name('citas.estado');

        Route::get('estudios/{estudio}/descargar', [EstudioController::class, 'descargar'])->name('estudios.descargar');
        Route::resource('estudios', EstudioController::class);

        Route::middleware('role:admin,medico')->group(function () {
            Route::resource('consultas', ConsultaController::class);
            Route::get('recetas/{receta}/imprimir', [RecetaController::class, 'imprimir'])->name('recetas.imprimir');
            Route::resource('recetas', RecetaController::class);
        });

        Route::middleware('role:admin')->group(function () {
            Route::resource('medicos', MedicoController::class);
            Route::resource('usuarios', UsuarioController::class)->except('show');
        });
    });
