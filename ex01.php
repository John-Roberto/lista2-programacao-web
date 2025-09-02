<?php

declare(strict_types=1);

// Ajuste caminhos conforme sua estrutura
require_once __DIR__ . '/includes/Template.php';
require_once __DIR__ . '/includes/Retangulo.php';

$template = new Template('Exercício 1 - Retângulo', 'Exercícios PHP OOP');
$template->renderHeader('Exercício 1 - Retângulo');

// Inicial valores
$largura = '1.0';
$altura  = '1.0';
$result  = null;
$error   = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Coleta e sanitiza (entrada bruta; convertendo para float com fallback)
    $largura = (string) (filter_input(INPUT_POST, 'largura', FILTER_UNSAFE_RAW) ?? '');
    $altura  = (string) (filter_input(INPUT_POST, 'altura', FILTER_UNSAFE_RAW) ?? '');

    // Limpeza básica
    $largura = trim($largura);
    $altura  = trim($altura);

    // tenta converter para float, trata se inválido
    $larguraFloat = is_numeric($largura) ? (float) $largura : NAN;
    $alturaFloat  = is_numeric($altura) ? (float) $altura  : NAN;

    try {
        if (!is_finite($larguraFloat) || !is_finite($alturaFloat)) {
            throw new InvalidArgumentException('Valores inválidos para largura/altura.');
        }

        $ret = new Retangulo($larguraFloat, $alturaFloat);

        $result = [
            'largura'   => $ret->getLargura(),
            'altura'    => $ret->getAltura(),
            'area'      => $ret->area(),
            'perimetro' => $ret->perimetro(),
            'ehQuadrado' => $ret->ehQuadrado() ? 'Sim' : 'Não',
        ];
    } catch (Throwable $ex) {
        $error = $ex->getMessage();
    }
}
?>

<div class="card mb-4">
    <div class="card-body">
        <h2 class="h5 card-title">Exercício 1 - Retângulo</h2>
        <p class="text-muted">Informe largura e altura (valores positivos). Valor padrão = 1.0</p>

        <form method="post" class="row g-2">
            <div class="col-6">
                <label class="form-label small">Largura</label>
                <input type="text" name="largura" class="form-control form-control-dark" value="<?= htmlspecialchars($largura, ENT_QUOTES, 'UTF-8') ?>">
            </div>
            <div class="col-6">
                <label class="form-label small">Altura</label>
                <input type="text" name="altura" class="form-control form-control-dark" value="<?= htmlspecialchars($altura, ENT_QUOTES, 'UTF-8') ?>">
            </div>
            <div class="col-12">
                <button class="btn btn-accent btn-sm">Calcular</button>
                <a href="index.php" class="btn btn-outline-light btn-sm">Voltar</a>
            </div>
        </form>

        <?php if ($error): ?>
            <div class="alert alert-danger mt-3"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>

        <?php if ($result !== null): ?>
            <div class="mt-3">
                <h6>Resultado</h6>
                <ul>
                    <li>Largura: <?= htmlspecialchars((string)$result['largura'], ENT_QUOTES, 'UTF-8') ?></li>
                    <li>Altura: <?= htmlspecialchars((string)$result['altura'], ENT_QUOTES, 'UTF-8') ?></li>
                    <li>Área: <?= htmlspecialchars((string)$result['area'], ENT_QUOTES, 'UTF-8') ?></li>
                    <li>Perímetro: <?= htmlspecialchars((string)$result['perimetro'], ENT_QUOTES, 'UTF-8') ?></li>
                    <li>É quadrado?: <?= htmlspecialchars((string)$result['ehQuadrado'], ENT_QUOTES, 'UTF-8') ?></li>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php $template->renderFooter(); ?>