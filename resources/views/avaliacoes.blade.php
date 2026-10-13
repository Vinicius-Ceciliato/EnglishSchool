<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Avaliações | English School</title>
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>

  <!-- HEADER -->
  <header class="header">
    <div class="container header__inner">
      <a href="{{ url('/') }}" class="logo">English<span>School</span></a>

      <nav class="nav" id="nav">
        <a href="{{ url('/') }}" class="nav__link">Início</a>
        <a href="{{ route('sobre') }}" class="nav__link">Sobre Nós</a>
        <a href="{{ route('avaliacoes') }}" class="nav__link nav__link--active">Avaliações</a>
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
        <span class="eyebrow">Depoimentos</span>
        <h1>O que nossos alunos dizem sobre a English School</h1>
        <p class="hero__text" style="max-width: 640px;">
          Histórias reais de quem já está aprendendo inglês no seu próprio ritmo.
        </p>
      </div>
    </div>
  </section>

  <!-- AVALIAÇÕES -->
  <section class="highlights">
    <div class="container">

      @php
        // Dados de exemplo — futuramente virão da tabela "reviews"
        $avaliacoes = [
          ['nome' => 'Marina Souza', 'nivel' => 'Intermediário', 'nota' => 5, 'texto' => 'O acompanhamento é muito próximo. Sinto que realmente evoluí no meu ritmo, sem pressão de turma.'],
          ['nome' => 'Rafael Lima', 'nivel' => 'Avançado', 'nota' => 5, 'texto' => 'Os materiais são muito bem organizados e o cronograma individual facilita demais a rotina.'],
          ['nome' => 'Camila Torres', 'nivel' => 'Básico', 'nota' => 4, 'texto' => 'Comecei do zero e hoje já consigo manter uma conversa simples. Recomendo muito!'],
        ];
      @endphp

      <div class="highlights__grid">
        @foreach ($avaliacoes as $avaliacao)
          <div class="highlight-card">
            <div style="color: var(--color-orange); font-size: 1.1rem; margin-bottom: 12px;">
              {{ str_repeat('★', $avaliacao['nota']) }}{{ str_repeat('☆', 5 - $avaliacao['nota']) }}
            </div>
            <p style="color: var(--color-ink); font-size: 0.95rem; margin-bottom: 18px; line-height: 1.6;">
              "{{ $avaliacao['texto'] }}"
            </p>
            <strong style="display:block;">{{ $avaliacao['nome'] }}</strong>
            <span style="color: var(--color-gray-text); font-size: 0.85rem;">Nível {{ $avaliacao['nivel'] }}</span>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  @auth
  <section class="highlights" style="padding-top: 0;">
    <div class="container">
      <div class="highlight-card" style="max-width: 600px; margin: 0 auto;">
        <h3 style="margin-bottom: 16px;">Deixe sua avaliação</h3>

        @if (session('status'))
          <div class="form-status">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('avaliacoes.store') }}">
          @csrf
          <div class="field">
            <label for="rating">Sua nota</label>
            <select id="rating" name="rating" required>
              <option value="5">5 — Excelente</option>
              <option value="4">4 — Muito bom</option>
              <option value="3">3 — Bom</option>
              <option value="2">2 — Regular</option>
              <option value="1">1 — Ruim</option>
            </select>
          </div>
          <div class="field">
            <label for="comment">Comentário</label>
            <textarea id="comment" name="comment" rows="4" required
              style="width:100%; padding:12px; border:1.5px solid var(--color-border); border-radius:var(--radius-sm); font-family:inherit;"></textarea>
          </div>
          <button type="submit" class="btn btn--primary">Enviar avaliação</button>
        </form>
      </div>
    </div>
  </section>
@else
  <section class="highlights" style="padding-top: 0; text-align:center;">
    <p>Quer deixar sua avaliação? <a href="{{ route('login') }}" style="color: var(--color-red); font-weight:600;">Faça login</a> primeiro.</p>
  </section>
@endauth

  <!-- CTA -->
  <section class="cta-band">
    <div class="container cta-band__inner">
      <div>
        <h2>Quer ser o próximo depoimento?</h2>
        <p>Cadastre-se e comece sua jornada no inglês hoje mesmo.</p>
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