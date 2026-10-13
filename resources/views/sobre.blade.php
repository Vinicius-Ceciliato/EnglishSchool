<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sobre Nós | English School</title>
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>

  <!-- HEADER -->
  <header class="header">
    <div class="container header__inner">
      <a href="{{ url('/') }}" class="logo">English<span>School</span></a>

      <nav class="nav" id="nav">
        <a href="{{ url('/') }}" class="nav__link">Início</a>
        <a href="{{ route('sobre') }}" class="nav__link nav__link--active">Sobre Nós</a>
        <a href="{{ route('avaliacoes') }}" class="nav__link">Avaliações</a>
        <a href="{{ route('register') }}" class="nav__link">Cadastre-se</a>
      </nav>

      <div class="header__actions">
        <a href="{{ route('login') }}" class="btn btn--outline">Entrar</a>
        <button class="nav__toggle" id="navToggle" aria-label="Abrir menu">
          <span></span><span></span><span></span>
        </button>
      </div>
    </div>
  </header>

  <!-- INTRO -->
  <section class="hero">
    <div class="container hero__inner" style="grid-template-columns: 1fr;">
      <div class="hero__content" style="max-width: 720px;">
        <span class="eyebrow">Nossa história</span>
        <h1>Ensinamos inglês há anos, sempre no ritmo de cada aluno.</h1>
        <p class="hero__text" style="max-width: 640px;">
          A English School nasceu para ser diferente das escolas de idiomas tradicionais:
          sem turmas lotadas, sem conteúdo genérico. Aqui, cada aluno tem seu próprio
          cronograma, seus próprios materiais e acompanhamento individual do início ao fim.
        </p>
      </div>
    </div>
  </section>

  <!-- VALORES -->
  <section class="highlights">
    <div class="container">
      <div style="text-align:center; max-width: 620px; margin: 0 auto 40px;">
        <h2 style="font-size: 1.75rem; margin-bottom: 10px;">O que nos move</h2>
        <p style="color: var(--color-gray-text);">Os princípios por trás de cada aula.</p>
      </div>

      <div class="highlights__grid">
        <div class="highlight-card">
          <div class="highlight-card__icon">🎯</div>
          <h3>Ensino individualizado</h3>
          <p>Nada de turmas padronizadas. Cada aluno avança no seu próprio ritmo, com conteúdo adequado ao seu nível.</p>
        </div>
        <div class="highlight-card">
          <div class="highlight-card__icon">🤝</div>
          <h3>Acompanhamento próximo</h3>
          <p>Professores presentes em cada etapa, com retorno constante sobre a evolução do aluno.</p>
        </div>
        <div class="highlight-card">
          <div class="highlight-card__icon">📚</div>
          <h3>Material de qualidade</h3>
          <p>Conteúdos selecionados e organizados por nível, sempre disponíveis para consulta.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- MISSÃO -->
  <section class="highlights" style="padding-top: 0;">
    <div class="container">
      <div class="highlight-card" style="padding: 40px;">
        <h3 style="font-size: 1.3rem; margin-bottom: 14px;">Nossa missão</h3>
        <p style="color: var(--color-gray-text); font-size: 1rem; line-height: 1.7;">
          Tornar o aprendizado de inglês acessível, próximo e eficaz — sem fórmulas prontas.
          Acreditamos que aprender um idioma é um processo pessoal, e por isso construímos
          uma escola onde o aluno é acompanhado de verdade, da matrícula à fluência.
        </p>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="cta-band">
    <div class="container cta-band__inner">
      <div>
        <h2>Pronto para começar?</h2>
        <p>Faça parte da English School e comece sua jornada hoje mesmo.</p>
      </div>
      <a href="{{ route('register') }}" class="btn btn--outline-light">Quero me cadastrar</a>
    </div>
  </section>

  <!-- FOOTER -->
  <footer class="footer">
    <div class="container footer__inner">
      <div>
        <a href="{{ url('/') }}" class="logo logo--footer">English<span>School</span></a>
        <p>Escola particular de inglês. Aulas pensadas para o seu ritmo.</p>
      </div>

      <div class="footer__col">
        <h4>Navegação</h4>
        <a href="{{ route('sobre') }}">Sobre Nós</a>
        <a href="{{ route('avaliacoes') }}">Avaliações</a>
        <a href="{{ route('register') }}">Cadastre-se</a>
        <a href="{{ route('login') }}">Entrar</a>
      </div>

      <div class="footer__col">
        <h4>Contato</h4>
        <a href="mailto:contato@englishschool.com">contato@englishschool.com</a>
        <a href="tel:+5500000000000">(00) 00000-0000</a>
      </div>
    </div>
    <div class="footer__bottom">
      <div class="container">
        <p>&copy; <span id="year"></span> English School. Todos os direitos reservados.</p>
      </div>
    </div>
  </footer>

  <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>