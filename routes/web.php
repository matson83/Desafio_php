<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ChamadoController;
use App\Http\Controllers\Tecnico\ChamadoTecnicoController;
use App\Http\Controllers\CategoriaController;
use App\Models\Categoria;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/welcome', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Todas as rotas autenticadas
Route::middleware(['auth', 'verified'])->group(function () {

    // Redirecionamento após login baseado no perfil
    Route::get('/dashboard', function () {
        if (Auth::user() && Auth::user()->isTecnico()) {
            return redirect()->route('tecnico.chamados.index');
        }

        return redirect()->route('chamados.index');
    })->name('dashboard');

    /**
     * Rotas do COLABORADOR
     */
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::resource('chamados', ChamadoController::class);
    });

    /**
     * Rotas do TÉCNICO
     */
    Route::prefix('tecnico')->name('tecnico.')->middleware(['auth', 'verified'])->group(function () {
        Route::get('chamados', [ChamadoTecnicoController::class, 'index'])->name('chamados.index');
        Route::get('chamados/{chamado}', [ChamadoTecnicoController::class, 'show'])->name('chamados.show');
        Route::post('chamados/{chamado}/resposta', [ChamadoTecnicoController::class, 'responder'])->name('chamados.responder');
        Route::patch('chamados/{chamado}/status', [ChamadoTecnicoController::class, 'alterarStatus'])->name('chamados.status');
        Route::get('usuarios', [\App\Http\Controllers\Tecnico\UsuarioController::class, 'index'])->name('usuarios.index');
        Route::patch('usuarios/{user}/toggle', [\App\Http\Controllers\Tecnico\UsuarioController::class, 'toggleAtivo'])->name('usuarios.toggle');
        Route::patch('usuarios/{user}/perfil', [\App\Http\Controllers\Tecnico\UsuarioController::class, 'alterarPerfil'])->name('usuarios.perfil');
    });

    /**
     * Rotas de CATEGORIAS
     */
    Route::resource('categorias', CategoriaController::class)->except(['show']);


    Route::get('/api/categorias', function () {
    return Categoria::all();
});

});
