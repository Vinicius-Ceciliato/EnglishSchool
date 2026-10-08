<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Entrar | English School</title>
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>

  <!-- HEADER -->
  <header class="header">
    <div class="container header__inner">
      <a href="{{ url('/') }}" class="logo">English<span>School</span></a>

      <nav class="nav" id="nav">
        <a href="{{ url('/') }}" class="nav__link">Início</a>
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

  <!-- LOGIN -->
  <section class="registration">
    <div class="container registration__inner">

      <div class="registration__heading">
        <span class="eyebrow">Escola de inglês particular</span>
        <h1>Entrar na plataforma</h1>
        <p>Acesse seu cronograma, materiais e boletim.</p>
      </div>

      <form class="registration__form" method="POST" action="{{ route('login') }}" novalidate>
        @csrf

        @if (session('status'))
          <div class="form-status" role="status">
            {{ session('status') }}
          </div>
        @endif

        @if ($errors->any())
          <div class="form-status" role="alert">
            {{ $errors->first() }}
          </div>
        @endif

        <fieldset>
          <legend>Acesso à plataforma</legend>

          <div class="form-grid">
            <div class="field field--full">
              <label for="email">E-mail <span>*</span></label>
              <input
                type="email" id="email" name="email"
                value="{{ old('email') }}"
                placeholder="voce@email.com"
                aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}"
                required autofocus>
              <span class="field__error">@error('email'){{ $message }}@enderror</span>
            </div>

            <div class="field field--full">
              <label for="password">Senha <span>*</span></label>
              <div class="password-field">
                <input
                  type="password" id="password" name="password"
                  placeholder="Sua senha"
                  aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}"
                  required>
                <button type="button" class="password-toggle" data-password-toggle="password" aria-label="Mostrar senha" aria-pressed="false">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7Z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                  </svg>
                </button>
              </div>
              <span class="field__error">@error('password'){{ $message }}@enderror</span>
            </div>

            <div class="field field--full">
              <label for="remember" style="display:flex; align-items:center; gap:10px; font-weight:400;">
                <input type="checkbox" id="remember" name="remember" style="width:auto; height:auto; accent-color: var(--color-red);">
                <span>Lembrar de mim</span>
              </label>
            </div>
          </div>
        </fieldset>

        <button type="submit" class="btn btn--primary registration__submit">Entrar</button>

        <p class="registration__login">
          Ainda não tem conta? <a href="{{ route('register') }}">Cadastre-se</a>
        </p>
      </form>

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
  <script>
    document.querySelectorAll('[data-password-toggle]').forEach(function (btn) {
      btn.addEventListener('click', function () {
        var input = document.getElementById(btn.getAttribute('data-password-toggle'));
        var showing = input.type === 'text';
        input.type = showing ? 'password' : 'text';
        btn.setAttribute('aria-pressed', String(!showing));
        btn.setAttribute('aria-label', showing ? 'Mostrar senha' : 'Ocultar senha');
      });
    });
  </script>
</body>
</html>