<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Meu Boletim | Learn English with Fernanda Ceciliato</title>
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>

  <!-- HEADER -->
  <header class="header">
    <div class="container header__inner">
      <a href="{{ route('dashboard') }}" class="logo"><img src="{{ asset('images/logo.jpeg') }}" alt="Logo" width="120"></a>

      <nav class="nav" id="nav">
        <a href="{{ route('dashboard') }}" class="nav__link">Minha Área</a>
        <a href="{{ route('cronograma.index') }}" class="nav__link">Cronograma</a>
        <a href="{{ route('materiais.index') }}" class="nav__link">Materiais</a>
        <a href="{{ route('boletim.index') }}" class="nav__link nav__link--active">Boletim</a>
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
        <h1 style="font-size: 1.6rem;">Meu boletim</h1>
        <p style="color: var(--color-gray-text);">Seus conceitos em cada habilidade e as notas das provas.</p>
      </div>

      @if ($grades->isEmpty())
        <div class="highlight-card" style="text-align:center; padding: 40px;">
          <div class="highlight-card__icon">📊</div>
          <h3>Nenhum boletim lançado ainda</h3>
          <p>Quando a professora lançar uma avaliação, ela aparece aqui.</p>
        </div>
      @else

        <!-- RESUMO -->
        <div class="highlight-card" style="display:flex; gap: 32px; flex-wrap:wrap; align-items:center; margin-bottom: 28px;">
          <div>
            <div style="font-size: 0.85rem; text-transform:uppercase; letter-spacing:0.4px; color: var(--color-gray-text);">Média das provas</div>
            <div style="font-size: 2.4rem; font-weight: 800; line-height: 1.1; color: {{ \App\Models\Grade::scoreColor($average) }};">
              {{ \App\Models\Grade::percent($average) }}
            </div>
          </div>
          <div>
            <div style="font-size: 0.85rem; text-transform:uppercase; letter-spacing:0.4px; color: var(--color-gray-text);">Avaliações</div>
            <div style="font-size: 2.4rem; font-weight: 800; line-height: 1.1;">{{ $grades->count() }}</div>
          </div>
        </div>

        <!-- BOLETINS -->
        <div style="display:grid; gap: 18px;">
          @foreach ($grades as $grade)
            <div class="highlight-card">
              <div style="display:flex; justify-content:space-between; gap: 12px; flex-wrap:wrap; margin-bottom: 16px;">
                <div>
                  <h3 style="margin-bottom: 2px;">{{ $grade->title }}</h3>
                  <span style="color: var(--color-gray-text); font-size: 0.88rem;">{{ $grade->assessed_on->format('d/m/Y') }}</span>
                </div>
              </div>

              <!-- Conceitos -->
              <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 12px; margin-bottom: 18px;">
                @foreach (\App\Models\Grade::SKILLS as $skillKey => $skillLabel)
                  <div style="border: 1px solid var(--color-border); border-radius: 12px; padding: 12px 14px;">
                    <div style="font-size: 0.8rem; text-transform:uppercase; letter-spacing:0.4px; color: var(--color-gray-text); margin-bottom: 8px;">{{ $skillLabel }}</div>
                    <span style="display:inline-block; padding:4px 12px; border-radius:999px; font-size:0.85rem; font-weight:700; {{ \App\Models\Grade::conceptStyle($grade->{$skillKey}) }}">
                      {{ $grade->conceptLabel($skillKey) }}
                    </span>
                  </div>
                @endforeach
              </div>

              <!-- Nota da prova -->
              <div>
                <div style="display:flex; justify-content:space-between; align-items:baseline; margin-bottom: 6px;">
                  <span style="font-size: 0.85rem; text-transform:uppercase; letter-spacing:0.4px; color: var(--color-gray-text);">Nota da prova</span>
                  <strong style="font-size: 1.3rem; color: {{ \App\Models\Grade::scoreColor($grade->exam_score) }};">{{ $grade->scoreLabel() }}</strong>
                </div>
                <div style="height: 10px; background: #ececec; border-radius: 999px; overflow:hidden;">
                  <div style="height: 100%; width: {{ $grade->exam_score }}%; background: {{ \App\Models\Grade::scoreColor($grade->exam_score) }}; border-radius: 999px;"></div>
                </div>
              </div>

              @if ($grade->comments)
                <p style="margin-top: 16px; padding-top: 14px; border-top: 1px solid var(--color-border); white-space: pre-line;">
                  <strong>Observações da professora:</strong><br>{{ $grade->comments }}
                </p>
              @endif
            </div>
          @endforeach
        </div>

      @endif

    </div>
  </section>

  <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>