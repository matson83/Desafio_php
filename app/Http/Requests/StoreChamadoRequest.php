<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreChamadoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'titulo' => 'required|string|max:255',
            'descricao' => 'required',
            'categoria_id' => 'required|exists:categorias,id',
            'prioridade' => 'required|in:Baixa,Média,Alta',
            'anexo' => 'nullable|file|max:2048',
        ];
    }
}
