<?php
// index.php
declare(strict_types=1);
require_once __DIR__ . '/includes/Template.php';

$template = new Template('Lista de Exercícios', 'Exercícios PHP');
$template->renderHeader('Início');
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">Lista de Exercícios</h1>
    </div>
    <div>
        <a href="#" class="btn btn-sm btn-outline-light" onclick="location.reload()">Atualizar</a>
    </div>
</div>

<div class="row g-3">
    <?php
    $exercises = [
        ['file' => 'ex01.php', 'title' => 'Exercício 1', 'desc' => 'Retângulo - cálculo de área, perímetro e verificação de quadrado.'],
        ['file' => 'ex02.php', 'title' => 'Exercício 2', 'desc' => 'Placeholder - lógica do exercício 2.'],
        ['file' => 'ex03.php', 'title' => 'Exercício 3', 'desc' => 'Placeholder - lógica do exercício 3.'],
        ['file' => 'ex04.php', 'title' => 'Exercício 4', 'desc' => 'Placeholder - lógica do exercício 4.'],
        ['file' => 'ex05.php', 'title' => 'Exercício 5', 'desc' => 'Placeholder - lógica do exercício 5.'],
    ];

    foreach ($exercises as $ex): ?>
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?= htmlspecialchars($ex['title']) ?></h5>
                    <p class="card-text text-muted"><?= htmlspecialchars($ex['desc']) ?></p>
                    <div class="mt-auto d-flex gap-2">
                        <a href="<?= htmlspecialchars($ex['file']) ?>" class="btn btn-accent btn-sm">
                            Abrir
                        </a>
                        <a href="<?= htmlspecialchars($ex['file']) ?>" class="btn btn-outline-light btn-sm" aria-label="Abrir em nova aba" target="_blank">
                            Abrir em uma nova guia
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php $template->renderFooter(); ?>