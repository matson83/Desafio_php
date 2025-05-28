<?php

namespace App\Http\Controllers;

use App\Models\Chamado;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Requests\StoreChamadoRequest;
use App\Http\Requests\UpdateChamadoRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ChamadoController  extends Controller
{
    public function __construct()
    {
            if (auth()->user()->perfil !== 'colaborador') {
                abort(403, 'Acesso não autorizado.');
            }

    }

    public function index()
    {
        $chamados = auth()->user()
            ->chamados()
            ->with('categoria') // Carrega o relacionamento
            ->latest()
            ->get();

        return Inertia::render('Chamados/Index', compact('chamados'));
    }

    public function create()
    {
        return Inertia::render('Chamados/Create');
    }

    public function store(StoreChamadoRequest $request)
{
    $data = $request->validated();

    if ($request->hasFile('anexo')) {
        $data['anexo'] = $request->file('anexo')->store('anexos', 'public');
    }

    $request->user()->chamados()->create($data);

    return redirect()->route('chamados.index')->with('success', 'Chamado criado com sucesso.');
}

    public function show(Chamado $chamado)
    {
        $chamado->load('categoria');

        return Inertia::render('Chamados/Show', compact('chamado'));
    }

    public function edit(Chamado $chamado)
{
    $categorias = \App\Models\Categoria::all();

    return Inertia::render('Chamados/Edit', [
        'chamado' => $chamado,
        'categorias' => $categorias
    ]);
}

public function update(Request $request, Chamado $chamado)
{
    $validated = $request->validate([
        'titulo' => 'required|string|max:255',
        'descricao' => 'required|string',
        'categoria_id' => 'required|exists:categorias,id',
        'prioridade' => 'required|in:Baixa,Média,Alta',
        'anexo' => 'nullable|file|max:10240',
    ]);

    try {
        if ($request->hasFile('anexo')) {
            if ($chamado->anexo) {
                Storage::disk('public')->delete($chamado->anexo);
            }
            $validated['anexo'] = $request->file('anexo')->store('anexos', 'public');
        }

        $chamado->update($validated);

        return redirect()->route('chamados.index')
               ->with('success', 'Chamado atualizado com sucesso!');

    } catch (\Exception $e) {
        return back()->with('error', 'Erro ao atualizar chamado: ' . $e->getMessage());
    }
}

    public function destroy(Chamado $chamado)
    {
        try {
            if ($chamado->anexo) {
                Storage::disk('public')->delete($chamado->anexo);
            }
            $chamado->delete();

            return redirect()->route('chamados.index')
                   ->with('success', 'Chamado excluído com sucesso!');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao excluir chamado: ' . $e->getMessage());
        }
    }
}

