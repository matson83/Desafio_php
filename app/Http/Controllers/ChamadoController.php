<?php

namespace App\Http\Controllers;

use App\Models\Chamado;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Requests\StoreChamadoRequest;
use App\Http\Requests\UpdateChamadoRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class ChamadoController  extends Controller
{
    public function index()
    {
        $chamados = auth()->user()->chamados()->latest()->get();

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
        return Inertia::render('Chamados/Show', compact('chamado'));
    }

    public function edit(Chamado $chamado)
{
    return Inertia::render('Chamados/Edit', [
        'chamado' => $chamado->only('id', 'titulo', 'descricao', 'categoria', 'prioridade', 'anexo')
    ]);
}

public function update(UpdateChamadoRequest $request, Chamado $chamado)
{
    Log::info('Entrou no update');

    $data = $request->validated();

    if ($request->hasFile('anexo')) {
        $data['anexo'] = $request->file('anexo')->store('anexos', 'public');
    }

    $updated = $chamado->update($data);

    if ($updated) {
        return redirect()->route('chamados.show', $chamado)->with('success', 'Chamado atualizado com sucesso.');
    }

    return back()->with('error', 'Ocorreu um erro ao atualizar o chamado.');
}

public function destroy(Chamado $chamado)
{
    $chamado->delete();
    return redirect()->route('chamados.index')->with('success', 'Chamado excluído com sucesso.');
}
}

