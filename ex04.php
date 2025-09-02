<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/Data.php';
require_once __DIR__ . '/includes/template.php';

use Exercises\Data;

$template = new Template('Exercício 4 - Data', 'Exercícios PHP OOP');
$template->renderHeader('Exercício 4 - Classe Data');

$error = null;
$message = null;
$resultado = null;

$dia = $_POST['dia'] ?? '';
$mes = $_POST['mes'] ?? '';
$ano = $_POST['ano'] ?? '';

$acao = $_POST['acao'] ?? '';
$outroDia = $_POST['outro_dia'] ?? '';
$outroMes = $_POST['outro_mes'] ?? '';
$outroAno = $_POST['outro_ano'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $data = new Data((int)$dia, (int)$mes, (int)$ano);

        switch ($acao) {
            case 'mostrar':
                $resultado = "Data atual: " . (string)$data;
                break;

            case 'incrementar':
                $data->incrementarDia();
                $resultado = "Após incrementar: " . (string)$data;
                break;

            case 'decrementar':
                $data->decrementarDia();
                $resultado = "Após decrementar: " . (string)$data;
                break;

            case 'bissexto':
                $resultado = $data->isBissexto() ? "Ano bissexto." : "Ano não bissexto.";
                break;

            case 'comparar':
                $outra = new Data((int)$outroDia, (int)$outroMes, (int)$outroAno);
                $cmp = $data->comparar($outra);
                if ($cmp === 0) {
                    $resultado = "Datas iguais.";
                } elseif ($cmp === 1) {
                    $resultado = "Data atual é maior que a outra.";
                } else {
                    $resultado = "Data atual é menor que a outra.";
                }
                break;

            case 'diferenca':
                $outra = new Data((int)$outroDia, (int)$outroMes, (int)$outroAno);
                $dias = $data->diferenca($outra);
                $resultado = "Diferença de {$dias} dia(s).";
                break;

            default:
                $error = "Ação inválida.";
        }
    } catch (Throwable $ex) {
        $error = $ex->getMessage();
    }
}
?>

<div class="card mb-4">
    <div class="card-body">
        <h2 class="h5 card-title">Classe Data (Exercício 4)</h2>
        <p class="text-muted">Informe uma data e execute operações.</p>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>

        <?php if ($resultado): ?>
            <div class="alert alert-info"><?= htmlspecialchars($resultado, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>

        <form method="post" class="row g-2">
            <div class="col-md-2">
                <input type="text" name="dia" class="form-control form-control-dark" placeholder="Dia" value="<?= htmlspecialchars($dia, ENT_QUOTES, 'UTF-8') ?>">
            </div>
            <div class="col-md-2">
                <input type="text" name="mes" class="form-control form-control-dark" placeholder="Mês" value="<?= htmlspecialchars($mes, ENT_QUOTES, 'UTF-8') ?>">
            </div>
            <div class="col-md-2">
                <input type="text" name="ano" class="form-control form-control-dark" placeholder="Ano" value="<?= htmlspecialchars($ano, ENT_QUOTES, 'UTF-8') ?>">
            </div>

            <div class="col-md-6">
                <select name="acao" class="form-select form-select-dark">
                    <option value="mostrar">Mostrar</option>
                    <option value="incrementar">Incrementar dia</option>
                    <option value="decrementar">Decrementar dia</option>
                    <option value="bissexto">Verificar bissexto</option>
                    <option value="comparar">Comparar com outra</option>
                    <option value="diferenca">Diferença entre datas</option>
                </select>
            </div>

            <div class="col-md-12">
                <label class="form-label small text-muted">Outra data (para comparar/diferença):</label>
            </div>
            <div class="col-md-2">
                <input type="text" name="outro_dia" class="form-control form-control-dark" placeholder="Dia" value="<?= htmlspecialchars($outroDia, ENT_QUOTES, 'UTF-8') ?>">
            </div>
            <div class="col-md-2">
                <input type="text" name="outro_mes" class="form-control form-control-dark" placeholder="Mês" value="<?= htmlspecialchars($outroMes, ENT_QUOTES, 'UTF-8') ?>">
            </div>
            <div class="col-md-2">
                <input type="text" name="outro_ano" class="form-control form-control-dark" placeholder="Ano" value="<?= htmlspecialchars($outroAno, ENT_QUOTES, 'UTF-8') ?>">
            </div>

            <div class="col-md-12 mt-2">
                <button class="btn btn-accent btn-sm">Executar</button>
                <a href="index.php" class="btn btn-outline-light btn-sm">Voltar</a>
            </div>
        </form>
    </div>
</div>

<?php $template->renderFooter(); ?>