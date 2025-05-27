<?php

namespace App\Http\Controllers\Tecnico;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UsuarioController extends Controller
{
    public function __construct()
    {

            if (auth()->user()?->perfil !== 'tecnico') {
                abort(403, 'Acesso não autorizado.');
            }

    }

    public function index()
    {
        $usuarios = User::all();
        return Inertia::render('Tecnico/Usuarios/Index', [
            'usuarios' => $usuarios,
        ]);
    }

    public function toggleAtivo(User $user)
    {
        $user->ativo = !$user->ativo;
        $user->save();

        return back()->with('success', 'Status do usuário atualizado.');
    }

    public function alterarPerfil(Request $request, User $user)
    {
        $request->validate([
            'perfil' => 'required|in:colaborador,tecnico',
        ]);
        $user->perfil = $request->perfil;
        $user->save();

        return back()->with('success', 'Perfil do usuário atualizado.');
    }
}
