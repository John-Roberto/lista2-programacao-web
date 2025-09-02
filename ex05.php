<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/Data.php';
require_once __DIR__ . '/includes/Voo.php';
require_once __DIR__ . '/includes/template.php';

use Exercises\Data;
use Exercises\Voo;

$template = new Template('Exercício 5 - Voo', 'Exercícios PHP OOP');
$template->renderHeader('Exercício 5 - Classe Voo');

session_start();

// Inicializar voo na sessão se não existir
if (isset($_SESSION['voo']) && $_SESSION['voo'] instanceof Voo) {
    $voo = $_SESSION['voo'];
} else {
    // Cria voo padrão: número 123, data de hoje
    $hoje = new Data((int)date('d'), (int)date('m'), (int)date('Y'));
    $voo = new Voo(123, $hoje);
    $_SESSION['voo'] = $voo;
}

$error = null;
$message = null;

$acao = $_POST['acao'] ?? '';
$assento_raw = $_POST['assento'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        switch ($acao) {
            case 'proximo':
                $prox = $voo->getProximoAssento();
                $message = $prox ? "Próximo assento livre: {$prox}" : "Não há assentos livres.";
                break;

            case 'verificar':
                if ($assento_raw === '' || !is_numeric($assento_raw)) {
                    throw new InvalidArgumentException('Informe um número de assento.');
                }
                $num = (int)$assento_raw;
                $ocupado = $voo->verificaAssento($num);
                $message = $ocupado ? "Assento {$num} está ocupado." : "Assento {$num} está livre.";
                break;

            case 'ocupar':
                if ($assento_raw === '' || !is_numeric($assento_raw)) {
                    throw new InvalidArgumentException('Informe um número de assento.');
                }
                $num = (int)$assento_raw;
                $ok = $voo->ocupa($num);
                $message = $ok ? "Assento {$num} ocupado com sucesso." : "Assento {$num} já estava ocupado.";
                break;

            case 'vagas':
                $vagas = $voo->getVagas();
                $message = "Há {$vagas} assentos vagos.";
                break;

            default:
                $error = "Ação inválida.";
        }
    } catch (Throwable $ex) {
        $error = $ex->getMessage();
    }

    $_SESSION['voo'] = $voo;
}

$numeroVoo = $voo->getVoo();
$dataVoo = (string)$voo->getDataVoo();
$vagasAtuais = $voo->getVagas();
?>

<div class="card mb-4">
    <div class="card-body">
        <h2 class="h5 card-title">Classe Voo (Exercício 5)</h2>
        <p class="text-muted">Gerencie assentos de um voo com até 100 passageiros.</p>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>

        <?php if ($message): ?>
            <div class="alert alert-success"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>

        <p><strong>Número do voo:</strong> <?= htmlspecialchars((string)$numeroVoo, ENT_QUOTES, 'UTF-8') ?> |
            <strong>Data:</strong> <?= htmlspecialchars($dataVoo, ENT_QUOTES, 'UTF-8') ?> |
            <strong>Vagas disponíveis:</strong> <?= htmlspecialchars((string)$vagasAtuais, ENT_QUOTES, 'UTF-8') ?>
        </p>

        <form method="post" class="row g-2 align-items-end">
            <div class="col-md-4">
                <input type="text" name="assento" class="form-control form-control-dark" placeholder="Número do assento (1-100)">
            </div>

            <div class="col-md-4">
                <select name="acao" class="form-select form-select-dark">
                    <option value="proximo">Próximo assento livre</option>
                    <option value="verificar">Verificar assento</option>
                    <option value="ocupar">Ocupar assento</option>
                    <option value="vagas">Mostrar vagas</option>
                </select>
            </div>

            <div class="col-md-4">
                <button class="btn btn-accent btn-sm">Executar</button>
                <a href="index.php" class="btn btn-outline-light btn-sm">Voltar</a>
            </div>
        </form>
    </div>
</div>

<?php $template->renderFooter(); ?>