<?php

declare(strict_types=1);

class Template
{
    private string $title;
    private string $brand;

    public function __construct(string $title = 'Exercícios PHP', string $brand = 'PHP')
    {
        $this->title = $title;
        $this->brand = $brand;
    }

    public function renderHeader(string $pageTitle = ''): void
    {
        $fullTitle = $pageTitle ? "{$pageTitle} - {$this->title}" : $this->title;
        echo <<<HTML
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
  <title>{$this->escape($fullTitle)}</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
</head>
<body class="theme-dark d-flex flex-column min-vh-100">
  <!-- Decorative gradient blobs (purely visual) -->
  <div class="bg-blob blob-top" aria-hidden="true"></div>
  <div class="bg-blob blob-bottom" aria-hidden="true"></div>

<header class="position-relative z-top">
<nav class="navbar navbar-expand-lg navbar-dark nav-glass border-bottom border-2" style="border-color: rgba(0,216,204,0.14) !important;">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center gap-2 text-truncate brand-gradient" href="index.php">
      <span class="bi bi-code-slash fs-3" aria-hidden="true"></span>
      <span class="brand-text">{$this->escape($this->brand)}</span>
    </a>

    <!-- Toggler / hamburger -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Alternar navegação">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Collapsible content (links, actions) -->
    <div class="collapse navbar-collapse" id="mainNavbar">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">
        <li class="nav-item">
          <a class="nav-link" href="index.php"><i class="bi bi-house-door-fill"></i> Início</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="ex01.php">Exercício 1</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="ex02.php">Exercício 2</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="ex03.php">Exercício 3</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="moreDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Mais
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="moreDropdown">
            <li><a class="dropdown-item" href="ex04.php">Exercício 4</a></li>
            <li><a class="dropdown-item" href="ex05.php">Exercício 5</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#" onclick="location.reload()">Atualizar</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
</header>

<main class="container-fluid flex-fill py-4">
  <div class="container">
HTML;
    }

    public function renderFooter(): void
    {
        $year = date('Y');
        echo <<<HTML
  </div>
</main>

<footer class="py-4 footer-glass text-center border-top" style="border-color: rgba(0,216,204,0.10) !important;">
  <div class="container">
    <small class="text-muted">Desenvolvido por João Roberto Peres Lanza — {$year}</small>
  </div>
</footer>

<!-- Bootstrap JS (Popper + Bootstrap) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
HTML;
    }

    private function escape(string $s): string
    {
        return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}