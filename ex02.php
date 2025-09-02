<?php

declare(strict_types=1);

// <-- CORREÇÃO: carregar a definição da classe ANTES de iniciar a sessão
require_once __DIR__ . '/includes/Calculadora.php';

session_start();

// Carregar o template (não deve enviar saída antes do session_start)
require_once __DIR__ . '/includes/template.php';

use Exercises\Calculadora;

$template = new Template('Exercício 2 - Calculadora', 'Exercícios PHP OOP');
$template->renderHeader('Exercício 2 - Calculadora');

/**
 * Recupera o objeto da sessão (se já existir).
 * Observação: agora que a classe foi carregada ANTES do session_start,
 * a desserialização funciona corretamente e instanceof retornará true.
 */
if (isset($_SESSION['calc']) && $_SESSION['calc'] instanceof Calculadora) {
    $calc = $_SESSION['calc'];
} else {
    $calc = new Calculadora();
    $_SESSION['calc'] = $calc;
}

$op = (string) ($_POST['op'] ?? '');
$valor_raw = trim((string) ($_POST['valor'] ?? ''));
$message = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        switch ($op) {
            case 'soma':
                if ($valor_raw === '' || !is_numeric($valor_raw)) {
                    throw new InvalidArgumentException('Informe um valor numérico para soma.');
                }
                $calc->soma((float)$valor_raw);
                $message = "Soma realizada.";
                break;

            case 'subtrai':
                if ($valor_raw === '' || !is_numeric($valor_raw)) {
                    throw new InvalidArgumentException('Informe um valor numérico para subtração.');
                }
                $calc->subtrai((float)$valor_raw);
                $message = "Subtração realizada.";
                break;

            case 'multiplica':
                if ($valor_raw === '' || !is_numeric($valor_raw)) {
                    throw new InvalidArgumentException('Informe um valor numérico para multiplicação.');
                }
                $calc->multiplica((float)$valor_raw);
                $message = "Multiplicação realizada.";
                break;

            case 'divide':
                if ($valor_raw === '' || !is_numeric($valor_raw)) {
                    throw new InvalidArgumentException('Informe um valor numérico para divisão.');
                }
                $calc->divide((float)$valor_raw);
                $message = "Divisão realizada.";
                break;

            case 'potencia':
                if ($valor_raw === '' || !is_numeric($valor_raw)) {
                    throw new InvalidArgumentException('Informe um expoente inteiro.');
                }
                $exp = (int)$valor_raw;
                $calc->potencia($exp);
                $message = "Potência aplicada.";
                break;

            case 'porcentagem':
                if ($valor_raw === '' || !is_numeric($valor_raw)) {
                    throw new InvalidArgumentException('Informe uma porcentagem numérica.');
                }
                $calc->porcentagem((float)$valor_raw);
                $message = "Porcentagem aplicada.";
                break;

            case 'raiz':
                $calc->raiz();
                $message = "Raiz quadrada calculada.";
                break;

            case 'zerar':
                $calc->zerar();
                $message = "Calculadora zerada.";
                break;

            case 'desfaz':
                $calc->desfaz();
                $message = "Última operação desfeita.";
                break;

            default:
                $error = "Operação inválida.";
        }
    } catch (\Throwable $ex) {
        $error = $ex->getMessage();
    }

    // persiste o objeto na sessão
    $_SESSION['calc'] = $calc;
}

// Exibir estado atual
$res = $calc->getRes();
$mem = method_exists($calc, 'getMem') ? $calc->getMem() : 0.0;
?>

<div class="card mb-4">
    <div class="card-body">
        <h2 class="h5 card-title">Calculadora (Exercício 2)</h2>
        <p class="text-muted">Use as operações abaixo. A calculadora mantém o resultado em sessão (entre requisições).</p>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>

        <?php if ($message): ?>
            <div class="alert alert-success"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>

        <form method="post" class="row g-2 align-items-end">
            <div class="col-12 col-md-4">
                <label class="form-label small">Valor (use para soma, subtração, multiplicação, divisão, potência, porcentagem)</label>
                <input type="text" name="valor" class="form-control form-control-dark" value="<?= htmlspecialchars($valor_raw ?? '', ENT_QUOTES, 'UTF-8') ?>">
            </div>

            <div class="col-12 col-md-4">
                <label class="form-label small">Operação</label>
                <select name="op" class="form-select form-select-dark">
                    <option value="soma">Soma (+)</option>
                    <option value="subtrai">Subtrai (-)</option>
                    <option value="multiplica">Multiplica (×)</option>
                    <option value="divide">Divide (÷)</option>
                    <option value="potencia">Potência (exp)</option>
                    <option value="porcentagem">Porcentagem (%)</option>
                    <option value="raiz">Raiz quadrada (√)</option>
                    <option value="zerar">Zerar</option>
                    <option value="desfaz">Desfazer última</option>
                </select>
            </div>

            <div class="col-12 col-md-4">
                <button class="btn btn-accent btn-sm">Executar</button>
                <a href="index.php" class="btn btn-outline-light btn-sm">Voltar</a>
            </div>
        </form>

        <div class="mt-3">
            <h6>Estado atual</h6>
            <ul>
                <li>Resultado (Res): <strong><?= htmlspecialchars((string)$res, ENT_QUOTES, 'UTF-8') ?></strong></li>
                <li>Memória (Mem): <?= htmlspecialchars((string)$mem, ENT_QUOTES, 'UTF-8') ?></li>
            </ul>
        </div>

        <div class="mt-2">
            <small class="text-muted">Observação: 'desfaz' restaura apenas a última operação e limpa a memória.</small>
        </div>
    </div>
</div>

<?php $template->renderFooter(); ?>