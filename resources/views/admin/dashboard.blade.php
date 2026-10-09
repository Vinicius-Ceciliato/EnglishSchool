<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Painel do Administrador | English School</title>
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>

  <!-- HEADER -->
  <header class="header">
    <div class="container header__inner">
      <a href="{{ route('admin.dashboard') }}" class="logo">English<span>School</span></a>

      <nav class="nav" id="nav">
        <a href="{{ route('admin.dashboard') }}" class="nav__link nav__link--active">Painel</a>
        <a href="#" class="nav__link">Alunos</a>
        <a href="#" class="nav__link">Materiais</a>
        <a href="#" class="nav__link">Cronograma</a>
        <a href="#" class="nav__link">Boletins</a>
      </nav>

      <div class="header__actions">
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="btn btn--outline">Sair</button>
        </form>
        <button class="nav__toggle" id="navToggle" aria-label="Abrir menu">
          <span></span><span></span><span></span>
        </button>
      </div>
    </div>
  </header>

  <!-- CONTEÚDO -->
  <section class="hero" style="padding: 48px 0;">
    <div class="container">
      <span class="eyebrow">Área restrita</span>
      <h1 style="font-size: 2rem;">Olá, {{ auth()->user()->name }}</h1>
      <p class="hero__text">Painel de administração da English School.</p>
    </div>
  </section>

  <section class="highlights">
    <div class="container highlights__grid">
      <a href="#" class="highlight-card" style="text-decoration:none; color:inherit;">
        <div class="highlight-card__icon">👥</div>
        <h3>Controle de alunos</h3>
        <p>Cadastre, edite ou remova alunos. Veja status de pagamento e dados básicos.</p>
      </a>
      <a href="#" class="highlight-card" style="text-decoration:none; color:inherit;">
        <div class="highlight-card__icon">📄</div>
        <h3>Materiais</h3>
        <p>Faça upload de PDFs e organize por nível de curso.</p>
      </a>
      <a href="#" class="highlight-card" style="text-decoration:none; color:inherit;">
        <div class="highlight-card__icon">📅</div>
        <h3>Cronograma</h3>
        <p>Defina quando e para quem as aulas acontecem.</p>
      </a>
      <a href="#" class="highlight-card" style="text-decoration:none; color:inherit;">
        <div class="highlight-card__icon">📊</div>
        <h3>Boletins</h3>
        <p>Lance notas e acompanhamento de cada aluno.</p>
      </a>
    </div>
  </section>

  <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>