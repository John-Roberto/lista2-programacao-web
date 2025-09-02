<?php

declare(strict_types=1);

// Carregar classe antes de session_start para evitar __PHP_Incomplete_Class
require_once __DIR__ . '/includes/Carro.php';

session_start();

// carregar template (separado para evitar saída antes de session_start)
require_once __DIR__ . '/includes/template.php';

use Exercises\Carro;

$template = new Template('Exercício 3 - Carro', 'Exercícios PHP OOP');
$template->renderHeader('Exercício 3 - Carro');

// Inicializa ou recupera o carro da sessão
if (isset($_SESSION['carro']) && $_SESSION['carro'] instanceof Carro) {
    $carro = $_SESSION['carro'];
} else {
    // consumo padrão: 12 km/l (pode ser alterado pelo usuário)
    $carro = new Carro(12.0);
    $_SESSION['carro'] = $carro;
}

$error = null;
$message = null;

// Valores do formulário
$acao = (string) ($_POST['acao'] ?? '');
$valor_raw = trim((string) ($_POST['valor'] ?? ''));
$consumo_raw = trim((string) ($_POST['consumo'] ?? ''));

// Se o usuário atualizou o consumo, recria o carro com o novo consumo mantendo o tanque
if ($consumo_raw !== '') {
    if (is_numeric($consumo_raw) && (float)$consumo_raw > 0.0) {
        $oldTanque = $carro->getCombustivel();
        $carro = new Carro((float)$consumo_raw);
        $carro->setCombustivel($oldTanque);
        $_SESSION['carro'] = $carro;
        $message = "Consumo atualizado para " . htmlspecialchars($consumo_raw) . " km/l.";
    } else {
        $error = "Consumo inválido.";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $acao !== '') {
    try {
        switch ($acao) {
            case 'abastecer':
                if ($valor_raw === '' || !is_numeric($valor_raw)) {
                    throw new \InvalidArgumentException('Informe quantidade de litros para abastecer.');
                }
                $litros = (float) $valor_raw;
                $carro->setCombustivel($litros);
                $message = "Abastecido {$litros} litros.";
                break;

            case 'andar':
                if ($valor_raw === '' || !is_numeric($valor_raw)) {
                    throw new \InvalidArgumentException('Informe distância a percorrer em km.');
                }
                $distancia = (float) $valor_raw;
                $percorrida = $carro->andar($distancia);
                if (abs($percorrida - $distancia) < 1e-9) {
                    $message = "Percorridos {$percorrida} km.";
                } else {
                    $message = "Tanque insuficiente: percorreu apenas {$percorrida} km e o tanque está vazio.";
                }
                break;

            default:
                $error = "Ação inválida.";
        }
    } catch (\Throwable $ex) {
        $error = $ex->getMessage();
    }

    // persiste na sessão
    $_SESSION['carro'] = $carro;
}

// Estado atual
$combustivel = $carro->getCombustivel();
$consumo = $carro->getConsumo();
?>

<div class="card mb-4">
    <div class="card-body">
        <h2 class="h5 card-title">Carro (Exercício 3)</h2>
        <p class="text-muted">Simule abastecimento e dirigir um veículo. Consumo em km/l.</p>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>

        <?php if ($message): ?>
            <div class="alert alert-success"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>

        <form method="post" class="row g-2 align-items-end">
            <div class="col-12 col-md-3">
                <label class="form-label small">Consumo (km/l) — alterar recria o carro mantendo tanque</label>
                <input type="text" name="consumo" class="form-control form-control-dark" placeholder="<?= htmlspecialchars((string)$consumo, ENT_QUOTES, 'UTF-8') ?>">
            </div>

            <div class="col-12 col-md-3">
                <label class="form-label small">Valor (litros ou km)</label>
                <input type="text" name="valor" class="form-control form-control-dark" value="">
            </div>

            <div class="col-12 col-md-3">
                <label class="form-label small">Ação</label>
                <select name="acao" class="form-select form-select-dark">
                    <option value="abastecer">Abastecer (litros)</option>
                    <option value="andar">Andar (km)</option>
                </select>
            </div>

            <div class="col-12 col-md-3">
                <button class="btn btn-accent btn-sm">Executar</button>
                <a href="index.php" class="btn btn-outline-light btn-sm">Voltar</a>
            </div>
        </form>

        <div class="mt-3">
            <h6>Estado atual</h6>
            <ul>
                <li>Consumo: <strong><?= htmlspecialchars((string)$consumo, ENT_QUOTES, 'UTF-8') ?> km/l</strong></li>
                <li>Combustível no tanque: <strong><?= htmlspecialchars((string)$combustivel, ENT_QUOTES, 'UTF-8') ?> litros</strong></li>
                <li>Autonomia aproximada: <strong><?= htmlspecialchars((string)($combustivel * $consumo), ENT_QUOTES, 'UTF-8') ?> km</strong></li>
            </ul>
        </div>
    </div>
</div>

<?php $template->renderFooter(); ?>