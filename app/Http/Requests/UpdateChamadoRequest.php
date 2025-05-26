<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Chamado;

class UpdateChamadoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
{
    return [
        'titulo' => 'required|string|max:255',
        'descricao' => 'required|string',
        'categoria' => 'required|string|max:255',
        'prioridade' => 'required|string|in:Baixa,Média,Alta',
        'anexo' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
    ];
}


}
