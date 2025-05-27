<?php

namespace App\Http\Controllers\Tecnico;

use App\Http\Controllers\Controller;
use App\Models\Chamado;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChamadoTecnicoController extends Controller
{
    public function __construct()
    {
            if (auth()->user()->perfil !== 'tecnico') {
                abort(403, 'Acesso não autorizado.');
            }

    }

    public function index(Request $request)
    {
        $query = Chamado::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('prioridade')) {
            $query->where('prioridade', $request->prioridade);
        }

        $chamados = $query->latest()->get();

        return Inertia::render('Tecnico/Chamados/Index', [
            'chamados' => $chamados,
        ]);
    }

    public function show(Chamado $chamado)
    {
        return Inertia::render('Tecnico/Chamados/Show', [
            'chamado' => $chamado->only('id', 'titulo', 'descricao', 'categoria', 'status', 'responsavel', 'created_at', 'updated_at'),
        ]);
    }

    public function responder(Request $request, Chamado $chamado)
    {
        $request->validate([
            'mensagem' => 'required|string',
        ]);

        $chamado->respostas()->create([
            'user_id' => auth()->id(),
            'mensagem' => $request->mensagem,
        ]);

        return back()->with('success', 'Resposta enviada.');
    }

    public function alterarStatus(Request $request, Chamado $chamado)
    {
        $request->validate([
            'status' => 'required|in:Aberto,Em atendimento,Resolvido,Fechado',
        ]);

        $chamado->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Status atualizado.');
    }
}

