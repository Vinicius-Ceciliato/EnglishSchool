<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>English School | Aprenda inglês com quem entende</title>
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>

  <!-- HEADER -->
  <header class="header">
    <div class="container header__inner">
      <a href="{{ url('/') }}" class="logo">English<span>School</span></a>

      <nav class="nav" id="nav">
        <a href="{{ url('/') }}" class="nav__link nav__link--active">Início</a>
        <a href="{{ url('/sobre') }}" class="nav__link">Sobre Nós</a>
        <a href="{{ url('/avaliacoes') }}" class="nav__link">Avaliações</a>
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

  <!-- HERO -->
  <section class="hero">
    <div class="container hero__inner">
      <div class="hero__content">
        <span class="eyebrow">Escola de inglês particular</span>
        <h1>Aprenda inglês no seu ritmo, <br> com acompanhamento de verdade.</h1>
        <p class="hero__text">
          Aulas particulares com cronograma individual, materiais exclusivos
          e acompanhamento completo da sua evolução — do primeiro "hello"
          à fluência.
        </p>
        <div class="hero__actions">
          <a href="{{ route('register') }}" class="btn btn--primary">Quero me cadastrar</a>
          <a href="{{ url('/sobre') }}" class="btn btn--ghost">Conhecer a escola</a>
        </div>
      </div>

      <div class="hero__visual" aria-hidden="true">
        <div class="hero__card hero__card--1">
          <strong>Nível B2</strong>
          <span>Upper Intermediate</span>
        </div>
        <div class="hero__card hero__card--2">
          <strong>★ 4.9</strong>
          <span>Avaliação dos alunos</span>
        </div>
      </div>
    </div>
  </section>

  <!-- DESTAQUES -->
  <section class="highlights">
    <div class="container highlights__grid">
      <div class="highlight-card">
        <div class="highlight-card__icon">📅</div>
        <h3>Cronograma individual</h3>
        <p>Cada aluno acompanha suas próprias aulas, dias e horários, sem depender de turma fechada.</p>
      </div>
      <div class="highlight-card">
        <div class="highlight-card__icon">📄</div>
        <h3>Materiais exclusivos</h3>
        <p>Conteúdos em PDF organizados por nível, disponíveis a qualquer momento no seu perfil.</p>
      </div>
      <div class="highlight-card">
        <div class="highlight-card__icon">📊</div>
        <h3>Boletim transparente</h3>
        <p>Acompanhe sua evolução com boletins detalhados a cada etapa do curso.</p>
      </div>
    </div>
  </section>

  <!-- CHAMADA AVALIAÇÕES -->
  <section class="cta-band">
    <div class="container cta-band__inner">
      <div>
        <h2>O que nossos alunos dizem</h2>
        <p>Veja depoimentos de quem já estuda com a gente.</p>
      </div>
      <a href="{{ url('/avaliacoes') }}" class="btn btn--outline-light">Ver avaliações</a>
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
        <a href="{{ url('/sobre') }}">Sobre Nós</a>
        <a href="{{ url('/avaliacoes') }}">Avaliações</a>
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