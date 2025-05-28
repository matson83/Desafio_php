<?php

namespace App\Exports;

use App\Models\Chamado;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ChamadosExport implements FromCollection, WithHeadings
{
    protected $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = Chamado::with(['categoria', 'user']);

        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }
        if (!empty($this->filters['prioridade'])) {
            $query->where('prioridade', $this->filters['prioridade']);
        }
        // Adicione outros filtros conforme necessário

        return $query->get()->map(function ($chamado) {
            return [
                'Título' => $chamado->titulo,
                'Descrição' => $chamado->descricao,
                'Responsável' => $chamado->user->name ?? '',
                'Prioridade' => $chamado->prioridade,
                'Categoria' => $chamado->categoria->nome ?? '',
                'Status' => $chamado->status,
                'Criado em' => $chamado->created_at,
                'Atualizado em' => $chamado->updated_at,
            ];
        });
    }

    public function headings(): array
    {
        return ['Título', 'Descrição', 'Responsável', 'Prioridade', 'Categoria', 'Status', 'Criado em', 'Atualizado em'];
    }
}
