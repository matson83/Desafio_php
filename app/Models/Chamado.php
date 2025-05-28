<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Categoria;;

class Chamado extends Model
{
    protected $fillable = [
        'user_id',
        'tecnico_id',
        'titulo',
        'descricao',
        'categoria_id',
        'prioridade',
        'status',
        'anexo',
    ];

    public function respostas() {
        return $this->hasMany(Resposta::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
