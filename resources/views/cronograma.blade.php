<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Meu Cronograma | Learn English with Fernanda Ceciliato</title>
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>

  <!-- HEADER -->
  <header class="header">
    <div class="container header__inner">
      <a href="{{ route('dashboard') }}" class="logo"><img src="{{ asset('images/logo.jpeg') }}" alt="Logo" width="120"></a>

      <nav class="nav" id="nav">
        <a href="{{ route('dashboard') }}" class="nav__link">Minha Área</a>
        <a href="{{ route('cronograma.index') }}" class="nav__link nav__link--active">Cronograma</a>
        <a href="{{ route('materiais.index') }}" class="nav__link">Materiais</a>
        <a href="{{ route('boletim.index') }}" class="nav__link">Boletim</a>
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
    <div class="container" style="max-width: 980px;">

      <div style="margin-bottom: 28px;">
        <h1 style="font-size: 1.6rem;">Meu cronograma</h1>
        <p style="color: var(--color-gray-text);">Suas próximas aulas e tarefas de casa.</p>
      </div>

      @if ($classes->isEmpty() && $tasks->isEmpty())
        <div class="highlight-card" style="text-align:center; padding: 40px;">
          <div class="highlight-card__icon">📅</div>
          <h3>Nada agendado por enquanto</h3>
          <p>Quando a professora marcar suas aulas ou tarefas, elas aparecem aqui.</p>
        </div>
      @endif

      <!-- PRÓXIMAS AULAS -->
      @if ($classes->isNotEmpty())
        <h2 style="font-size: 1.25rem; margin-bottom: 16px;">Próximas aulas</h2>
        <div style="display:grid; gap: 14px; margin-bottom: 36px;">
          @foreach ($classes as $item)
            <div class="highlight-card" style="display:flex; gap:20px; align-items:flex-start; flex-wrap:wrap;">
              <div style="min-width: 86px; text-align:center; background: rgba(191,51,38,0.08); border-radius: 12px; padding: 10px 12px;">
                <div style="font-size: 1.5rem; font-weight: 800; color: var(--color-red); line-height:1;">{{ $item->date->format('d') }}</div>
                <div style="font-size: 0.8rem; text-transform: uppercase; color: var(--color-gray-text);">{{ $item->date->locale('pt_BR')->isoFormat('MMM') }}</div>
              </div>
              <div style="flex:1; min-width: 200px;">
                <h3 style="margin-bottom: 4px;">{{ $item->title }}</h3>
                <p style="color: var(--color-gray-text); font-size: 0.9rem;">
                  {{ ucfirst($item->date->locale('pt_BR')->isoFormat('dddd')) }}
                  @if ($item->startLabel())
                    · {{ $item->startLabel() }}{{ $item->endLabel() ? ' às '.$item->endLabel() : '' }}
                  @endif
                </p>
                @if ($item->description)
                  <p style="margin-top: 8px; white-space: pre-line;">{{ $item->description }}</p>
                @endif
              </div>
            </div>
          @endforeach
        </div>
      @endif

      <!-- TAREFAS DE CASA -->
      @if ($tasks->isNotEmpty())
        <h2 style="font-size: 1.25rem; margin-bottom: 16px;">Tarefas de casa</h2>
        <div style="display:grid; gap: 14px; margin-bottom: 36px;">
          @foreach ($tasks as $item)
            <div class="highlight-card" style="border-left: 4px solid var(--color-orange);">
              <div style="display:flex; justify-content:space-between; gap:12px; flex-wrap:wrap;">
                <h3 style="margin-bottom: 4px;">{{ $item->title }}</h3>
                <span style="font-size: 0.85rem; font-weight:700; color: var(--color-orange-dark);">
                  Entrega: {{ $item->date->format('d/m/Y') }}{{ $item->startLabel() ? ' às '.$item->startLabel() : '' }}
                </span>
              </div>
              @if ($item->description)
                <p style="margin-top: 6px; white-space: pre-line;">{{ $item->description }}</p>
              @endif
            </div>
          @endforeach
        </div>
      @endif

      <!-- ANTERIORES -->
      @if ($past->isNotEmpty())
        <details>
          <summary style="cursor:pointer; font-weight:700; margin-bottom: 14px;">Itens anteriores ({{ $past->count() }})</summary>
          <div style="display:grid; gap: 10px; opacity: 0.7;">
            @foreach ($past as $item)
              <div class="highlight-card" style="padding: 14px 18px;">
                <strong>{{ $item->title }}</strong>
                <span style="color: var(--color-gray-text); font-size: 0.85rem;">
                  · {{ $item->isTask() ? 'Tarefa' : 'Aula' }} · {{ $item->date->format('d/m/Y') }}
                </span>
              </div>
            @endforeach
          </div>
        </details>
      @endif

    </div>
  </section>

  <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>