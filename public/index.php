<?php
require_once __DIR__ . '/../repositories/SerieRepository.php';

$repo = new SerieRepository();
$series = $repo->listar();

function e($valor)
{
    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Séries</title>
    <style>
        body { font-family: Arial, Helvetica, sans-serif; margin: 40px; }
        nav a { margin-right: 15px; text-decoration: none; font-weight: bold; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #eee; }
        .acoes a { margin-right: 10px; }
        .vazio { margin-top: 20px; color: #555; }
    </style>
</head>
<body>
    <h1>Sistema de Cadastro de Séries</h1>
    <nav>
        <a href="index.php">Listar Séries</a>
        <a href="criar.php">Nova Série</a>
    </nav>

    <?php if (empty($series)): ?>
        <p class="vazio">Nenhuma série cadastrada.</p>
    <?php else: ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Gênero</th>
                <th>Temporadas</th>
                <th>Plataforma</th>
                <th>Ações</th>
            </tr>
            <?php foreach ($series as $s): ?>
                <tr>
                    <td><?= e($s['id']) ?></td>
                    <td><?= e($s['titulo']) ?></td>
                    <td><?= e($s['genero']) ?></td>
                    <td><?= e($s['temporadas']) ?></td>
                    <td><?= e($s['plataforma']) ?></td>
                    <td class="acoes">
                        <a href="editar.php?id=<?= e($s['id']) ?>">Editar</a>
                        <a href="excluir.php?id=<?= e($s['id']) ?>">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</body>
</html>
