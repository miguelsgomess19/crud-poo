<?php
require_once __DIR__ . '/../repositories/SerieRepository.php';

$repo = new SerieRepository();
$erros = [];
$serie = null;

$id = $_POST['id'] ?? $_GET['id'] ?? null;
if ($id === null || $id === '' || filter_var($id, FILTER_VALIDATE_INT) === false || (int) $id < 1) {
    $erros[] = 'ID inválido. Selecione uma série válida na listagem.';
} else {
    $serie = $repo->buscarPorId((int) $id);
    if (!$serie) {
        $erros[] = 'Série não encontrada.';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $serie) {
    try {
        $repo->excluir((int) $id);
        header('Location: index.php');
        exit;
    } catch (Exception $e) {
        $erros[] = 'Erro ao excluir a série. Tente novamente.';
    }
}

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
    <title>Excluir Série</title>
    <style>
        body { font-family: Arial, Helvetica, sans-serif; margin: 40px; }
        .erros { background: #fdecea; border: 1px solid #f5c2c7; color: #842029; padding: 12px; margin-bottom: 16px; max-width: 520px; }
        .erros ul { margin: 0; padding-left: 20px; }
        .card { border: 1px solid #ccc; padding: 16px; max-width: 520px; }
        .acoes { margin-top: 16px; }
        .acoes button, .acoes a { margin-right: 10px; }
        nav a { margin-right: 15px; text-decoration: none; font-weight: bold; }
        .aviso { color: #842029; font-weight: bold; }
    </style>
</head>
<body>
    <h1>Excluir Série</h1>
    <nav>
        <a href="index.php">Listar Séries</a>
        <a href="criar.php">Nova Série</a>
    </nav>

    <?php if (!empty($erros)): ?>
        <div class="erros">
            <strong>Não foi possível concluir a operação:</strong>
            <ul>
                <?php foreach ($erros as $erro): ?>
                    <li><?= e($erro) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if ($serie): ?>
        <div class="card">
            <p class="aviso">Tem certeza que deseja excluir esta série? Esta ação não pode ser desfeita.</p>
            <p><strong>ID:</strong> <?= e($serie['id']) ?></p>
            <p><strong>Título:</strong> <?= e($serie['titulo']) ?></p>
            <p><strong>Gênero:</strong> <?= e($serie['genero']) ?></p>
            <p><strong>Temporadas:</strong> <?= e($serie['temporadas']) ?></p>
            <p><strong>Plataforma:</strong> <?= e($serie['plataforma']) ?></p>

            <form method="post" action="" class="acoes">
                <input type="hidden" name="id" value="<?= e($serie['id']) ?>">
                <button type="submit">Confirmar exclusão</button>
                <a href="index.php">Cancelar</a>
            </form>
        </div>
    <?php else: ?>
        <p><a href="index.php">Voltar para a listagem</a></p>
    <?php endif; ?>
</body>
</html>
