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

$titulo = $serie['titulo'] ?? '';
$genero = $serie['genero'] ?? '';
$temporadas = $serie['temporadas'] ?? '';
$plataforma = $serie['plataforma'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $serie) {
    $titulo = trim($_POST['titulo'] ?? '');
    $genero = trim($_POST['genero'] ?? '');
    $temporadas = trim($_POST['temporadas'] ?? '');
    $plataforma = trim($_POST['plataforma'] ?? '');

    $errosValidacao = [];
    if ($titulo === '') {
        $errosValidacao[] = 'O título é obrigatório.';
    }
    if ($genero === '') {
        $errosValidacao[] = 'O gênero é obrigatório.';
    }
    if ($temporadas === '' || filter_var($temporadas, FILTER_VALIDATE_INT) === false || (int) $temporadas < 1) {
        $errosValidacao[] = 'O número de temporadas deve ser um inteiro maior que zero.';
    }
    if ($plataforma === '') {
        $errosValidacao[] = 'A plataforma é obrigatória.';
    }

    if (empty($errosValidacao)) {
        try {
            $serieAtualizada = new Serie($titulo, $genero, (int) $temporadas, $plataforma);
            $repo->atualizar((int) $id, $serieAtualizada);
            header('Location: index.php');
            exit;
        } catch (Exception $e) {
            $erros[] = 'Erro ao atualizar a série. Verifique os dados e tente novamente.';
        }
    } else {
        $erros = array_merge($erros, $errosValidacao);
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
    <title>Editar Série</title>
    <style>
        body { font-family: Arial, Helvetica, sans-serif; margin: 40px; }
        form { max-width: 420px; }
        label { display: block; margin-top: 12px; font-weight: bold; }
        input { width: 100%; padding: 8px; box-sizing: border-box; margin-top: 4px; }
        button { margin-top: 16px; padding: 10px 16px; }
        .erros { background: #fdecea; border: 1px solid #f5c2c7; color: #842029; padding: 12px; margin-bottom: 16px; max-width: 420px; }
        .erros ul { margin: 0; padding-left: 20px; }
        nav a { margin-right: 15px; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>
    <h1>Editar Série</h1>
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
        <form method="post" action="">
            <input type="hidden" name="id" value="<?= e($serie['id']) ?>">

            <label for="titulo">Título</label>
            <input type="text" name="titulo" id="titulo" value="<?= e($titulo) ?>" required>

            <label for="genero">Gênero</label>
            <input type="text" name="genero" id="genero" value="<?= e($genero) ?>" required>

            <label for="temporadas">Temporadas</label>
            <input type="number" name="temporadas" id="temporadas" min="1" step="1" value="<?= e($temporadas) ?>" required>

            <label for="plataforma">Plataforma</label>
            <input type="text" name="plataforma" id="plataforma" value="<?= e($plataforma) ?>" required>

            <button type="submit">Atualizar</button>
        </form>
    <?php else: ?>
        <p><a href="index.php">Voltar para a listagem</a></p>
    <?php endif; ?>
</body>
</html>
