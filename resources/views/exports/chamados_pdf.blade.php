<!-- filepath: resources/views/exports/chamados_pdf.blade.php -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Chamados</title>
    <style>
        body {
            font-family: DejaVu Sans, Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #333;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin: 0 auto;
        }
        th, td {
            border: 1px solid #bbb;
            padding: 8px 6px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background: #f2f2f2;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background: #fafafa;
        }
    </style>
</head>
<body>
    <h2>Relatório de Chamados</h2>
    <table>
        <thead>
            <tr>
                <th>Título</th>
                <th>Descrição</th>
                <th>Responsável</th>
                <th>Prioridade</th>
                <th>Categoria</th>
                <th>Status</th>
                <th>Criado em</th>
                <th>Atualizado em</th>
            </tr>
        </thead>
        <tbody>
            @foreach($chamados as $chamado)
                <tr>
                    <td>{{ $chamado->titulo }}</td>
                    <td>{{ $chamado->descricao }}</td>
                    <td>{{ $chamado->user->name ?? '' }}</td>
                    <td>{{ $chamado->prioridade }}</td>
                    <td>{{ $chamado->categoria->nome ?? '' }}</td>
                    <td>{{ $chamado->status }}</td>
                    <td>{{ \Carbon\Carbon::parse($chamado->created_at)->format('d/m/Y H:i') }}</td>
                    <td>{{ \Carbon\Carbon::parse($chamado->updated_at)->format('d/m/Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
