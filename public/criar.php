<?php
require_once __DIR__ . '/../repositories/SerieRepository.php';

$erros = [];
$titulo = '';
$genero = '';
$temporadas = '';
$plataforma = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo'] ?? '');
    $genero = trim($_POST['genero'] ?? '');
    $temporadas = trim($_POST['temporadas'] ?? '');
    $plataforma = trim($_POST['plataforma'] ?? '');

    if ($titulo === '') {
        $erros[] = 'O título é obrigatório.';
    }
    if ($genero === '') {
        $erros[] = 'O gênero é obrigatório.';
    }
    if ($temporadas === '' || filter_var($temporadas, FILTER_VALIDATE_INT) === false || (int) $temporadas < 1) {
        $erros[] = 'O número de temporadas deve ser um inteiro maior que zero.';
    }
    if ($plataforma === '') {
        $erros[] = 'A plataforma é obrigatória.';
    }

    if (empty($erros)) {
        try {
            $serie = new Serie($titulo, $genero, (int) $temporadas, $plataforma);
            (new SerieRepository())->criar($serie);
            header('Location: index.php');
            exit;
        } catch (Exception $e) {
            $erros[] = 'Erro ao salvar a série. Verifique os dados e tente novamente.';
        }
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
    <title>Nova Série</title>
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
    <h1>Cadastrar Nova Série</h1>
    <nav>
        <a href="index.php">Listar Séries</a>
        <a href="criar.php">Nova Série</a>
    </nav>

    <?php if (!empty($erros)): ?>
        <div class="erros">
            <strong>Corrija os erros abaixo:</strong>
            <ul>
                <?php foreach ($erros as $erro): ?>
                    <li><?= e($erro) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" action="">
        <label for="titulo">Título</label>
        <input type="text" name="titulo" id="titulo" value="<?= e($titulo) ?>" required>

        <label for="genero">Gênero</label>
        <input type="text" name="genero" id="genero" value="<?= e($genero) ?>" required>

        <label for="temporadas">Temporadas</label>
        <input type="number" name="temporadas" id="temporadas" min="1" step="1" value="<?= e($temporadas) ?>" required>

        <label for="plataforma">Plataforma</label>
        <input type="text" name="plataforma" id="plataforma" value="<?= e($plataforma) ?>" required>

        <button type="submit">Salvar</button>
    </form>
</body>
</html>
