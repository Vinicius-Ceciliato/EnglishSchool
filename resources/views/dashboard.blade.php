<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Minha Área | Learn English with Fernanda Ceciliato</title>
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>

  @php
    $user = auth()->user();
    $profile = $user->studentProfile;

    $niveis = [
      'iniciante' => 'Iniciante',
      'basico' => 'Básico',
      'intermediario' => 'Intermediário',
      'avancado' => 'Avançado',
      'nao-sei' => 'A definir',
    ];
    $nivelLabel = $profile && isset($niveis[$profile->english_level])
      ? $niveis[$profile->english_level]
      : 'A definir';
  @endphp

  <!-- HEADER -->
  <header class="header">
    <div class="container header__inner">
      <a href="{{ route('dashboard') }}" class="logo"><img src="{{ asset('images/logo.jpeg') }}" alt="Logo" width="120"></a>

      <nav class="nav" id="nav">
        <a href="{{ route('dashboard') }}" class="nav__link nav__link--active">Minha Área</a>
        <a href="{{ route('cronograma.index') }}" class="nav__link">Cronograma</a>
        <a href="{{ route('materiais.index') }}" class="nav__link">Materiais</a>
        <a href="{{ route('boletim.index') }}" class="nav__link">Boletim</a>
      </nav>

      <div class="header__actions">
        <a href="{{ route('profile.edit') }}" class="btn btn--outline">Meu perfil</a>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="btn btn--ghost">Sair</button>
        </form>
        <button class="nav__toggle" id="navToggle" aria-label="Abrir menu">
          <span></span><span></span><span></span>
        </button>
      </div>
    </div>
  </header>

  <!-- BOAS-VINDAS -->
  <section class="hero" style="padding: 48px 0;">
    <div class="container hero__inner" style="grid-template-columns: 1fr;">
      <div class="hero__content">
        <span class="eyebrow">Área do aluno</span>
        <h1 style="font-size: 2rem;">Olá, {{ explode(' ', $user->name)[0] }}! 👋</h1>
        <p class="hero__text">
          Aqui você acompanha seu cronograma, acessa os materiais do seu curso e confere seu boletim.
        </p>
      </div>
    </div>
  </section>

  <!-- RESUMO DO ALUNO -->
  <section class="highlights" style="padding-top: 0;">
    <div class="container">
      <div class="highlight-card" style="margin-bottom: 32px;">
        <h3 style="margin-bottom: 16px;">Meu resumo</h3>
        <div class="form-grid">
          <div>
            <span class="field__hint" style="display:block; margin-bottom:2px;">Nível de inglês</span>
            <strong>{{ $nivelLabel }}</strong>
          </div>
          <div>
            <span class="field__hint" style="display:block; margin-bottom:2px;">E-mail</span>
            <strong>{{ $user->email }}</strong>
          </div>
          <div>
            <span class="field__hint" style="display:block; margin-bottom:2px;">Status da mensalidade</span>
            @if ($profile && $profile->payment_up_to_date)
              <strong style="color: #2e7d32;">Em dia</strong>
            @else
              <strong style="color: var(--color-red);">Pendente</strong>
            @endif
          </div>
        </div>
      </div>

      <!-- MÓDULOS -->
      <div class="highlights__grid">
        <a id="cronograma" href="{{ route('cronograma.index') }}" class="highlight-card" style="text-decoration:none; color:inherit;">
          <div class="highlight-card__icon">📅</div>
          <h3>Meu cronograma</h3>
          <p>Veja os dias e horários das suas próximas aulas.</p>
        </a>

        <a id="materiais" href="{{ route('materiais.index') }}" class="highlight-card" style="text-decoration:none; color:inherit;">
          <div class="highlight-card__icon">📄</div>
          <h3>Materiais do curso</h3>
          <p>Acesse os PDFs disponibilizados para o seu nível.</p>
        </a>

        <a id="boletim" href="{{ route('boletim.index') }}" class="highlight-card" style="text-decoration:none; color:inherit;">
          <div class="highlight-card__icon">📊</div>
          <h3>Meu boletim</h3>
          <p>Acompanhe suas notas e avaliações por etapa.</p>
        </a>
      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <footer class="footer">
    <div class="container footer__inner">
      <div>
        <a href="{{ url('/') }}" class="logo logo--footer">Learn English <span>with Fernanda Ceciliato</span></a>
        <p>Aulas particulares de inglês. Aulas pensadas para o seu ritmo.</p>
      </div>

      <div class="footer__col">
        <h4>Minha conta</h4>
        <a href="{{ route('dashboard') }}">Minha Área</a>
        <a href="{{ route('profile.edit') }}">Meu perfil</a>
      </div>

      <div class="footer__col">
        <h4>Contato</h4>
        <a href="mailto:teacher.fernandaceciliato@gmail.com">teacher.fernandaceciliato@gmail.com</a>
        <a href="tel:+5515997677833">(15) 99767-7833</a>
      </div>
    </div>
    <div class="footer__bottom">
      <div class="container">
        <p>&copy; <span id="year"></span> Learn English with Fernanda Ceciliato. Todos os direitos reservados.</p>
      </div>
    </div>
  </footer>

  <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>