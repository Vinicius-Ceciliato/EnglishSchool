<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Meus Materiais | English School</title>
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>

  <!-- HEADER -->
  <header class="header">
    <div class="container header__inner">
      <a href="{{ route('dashboard') }}" class="logo">English<span>School</span></a>

      <nav class="nav" id="nav">
        <a href="{{ route('dashboard') }}" class="nav__link">Minha Área</a>
        <a href="#" class="nav__link">Cronograma</a>
        <a href="{{ route('materiais.index') }}" class="nav__link nav__link--active">Materiais</a>
        <a href="#" class="nav__link">Boletim</a>
      </nav>

      <div class="header__actions">
        <a href="{{ route('profile.edit') }}" class="btn btn--outline">Meu perfil</a>
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

  <section class="highlights">
    <div class="container">

      <div style="margin-bottom: 28px;">
        <h1 style="font-size: 1.6rem;">Meus materiais</h1>
        <p style="color: var(--color-gray-text);">PDFs liberados pela escola para o seu curso.</p>
      </div>

      @if ($materials->isEmpty())
        <div class="highlight-card" style="text-align:center; padding: 40px;">
          <div class="highlight-card__icon">📚</div>
          <h3>Nenhum material por aqui ainda</h3>
          <p>Quando a escola liberar um PDF para você, ele aparece nesta página.</p>
        </div>
      @else
        <div class="highlights__grid">
          @foreach ($materials as $material)
            <div class="highlight-card">
              <div class="highlight-card__icon">📄</div>
              <h3>{{ $material->title }}</h3>
              @if ($material->description)
                <p>{{ $material->description }}</p>
              @endif
              <p style="color: var(--color-gray-text); font-size: 0.85rem; margin-top: 8px;">
                {{ $material->created_at->format('d/m/Y') }} · {{ number_format($material->size / 1048576, 2, ',', '.') }} MB
              </p>
              <a href="{{ route('materiais.download', $material) }}" target="_blank" class="btn btn--primary" style="margin-top: 16px; display:inline-block;">Abrir PDF</a>
            </div>
          @endforeach
        </div>
      @endif

    </div>
  </section>

  <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>