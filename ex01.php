<?php
// ex01.php
declare(strict_types=1);
require_once __DIR__ . '/includes/Template.php';

$template = new Template('Exercício 1', 'Exercícios PHP OOP');
$template->renderHeader('Exercício 1');
?>

<div class="card mb-4">
    <div class="card-body">
        <h2 class="h5 card-title">Exercício 1 — Título do exercício</h2>
        <p class="text-muted">Descrição curta: aqui vai o que o exercício deve fazer. Substitua por seu requisito.</p>

        <!-- Área de resultado / formulário -->
        <div class="mt-3">
            <form method="post" class="row gy-2 gx-2 align-items-end">
                <div class="col-12 col-md-6">
                    <label class="form-label small text-muted">Valor A</label>
                    <input name="a" type="text" class="form-control form-control-dark" placeholder="Digite A">
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label small text-muted">Valor B</label>
                    <input name="b" type="text" class="form-control form-control-dark" placeholder="Digite B">
                </div>
                <div class="col-12">
                    <button class="btn btn-accent btn-sm">Executar</button>
                    <a href="index.php" class="btn btn-outline-light btn-sm">Voltar</a>
                </div>
            </form>
        </div>

        <?php
        // Exemplo simples de uso OOP: cria uma pequena classe local que processa entrada
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            class Ex1Processor
            {
                public function sumStrings(string $a, string $b): string
                {
                    // exemplo: concatena com separador e mostra tipos
                    return sprintf("A: %s | B: %s | resultado (concat): %s", $a, $b, $a . $b);
                }
            }

            $proc = new Ex1Processor();
            $a = $_POST['a'] ?? '';
            $b = $_POST['b'] ?? '';
            $result = $proc->sumStrings((string)$a, (string)$b);
            echo '<div class="mt-3"><pre class="p-3 bg-black text-light small" style="border:1px solid rgba(64,224,208,0.06);">' . htmlspecialchars($result) . '</pre></div>';
        }
        ?>
    </div>
</div>

<?php $template->renderFooter(); ?>