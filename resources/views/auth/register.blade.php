<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastre-se | English School</title>
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
        <a href="{{ route('register') }}" class="nav__link nav__link--active">Cadastre-se</a>
      </nav>

      <div class="header__actions">
        <a href="{{ route('login') }}" class="btn btn--outline">Entrar</a>
        <button class="nav__toggle" id="navToggle" aria-label="Abrir menu">
          <span></span><span></span><span></span>
        </button>
      </div>
    </div>
  </header>

  <!-- CADASTRO -->
  <section class="registration">
    <div class="container registration__inner">

      <div class="registration__heading">
        <span class="eyebrow">Escola de inglês particular</span>
        <h1>Criar conta de aluno</h1>
        <p>Preencha seus dados para solicitar matrícula na English School.</p>
      </div>

      <form class="registration__form" method="POST" action="{{ route('register') }}" novalidate>
        @csrf

        @if ($errors->any())
          <div class="form-status" role="alert">
            Encontramos {{ $errors->count() === 1 ? '1 problema' : $errors->count().' problemas' }} no formulário. Confira os campos destacados abaixo.
          </div>
        @endif

        <!-- DADOS PESSOAIS -->
        <fieldset>
          <legend>Dados pessoais</legend>

          <div class="form-grid">
            <div class="field field--full">
              <label for="name">Nome completo <span>*</span></label>
              <input
                type="text" id="name" name="name"
                value="{{ old('name') }}"
                placeholder="Seu nome completo"
                aria-invalid="{{ $errors->has('name') ? 'true' : 'false' }}"
                required autofocus>
              <span class="field__error">@error('name'){{ $message }}@enderror</span>
            </div>

            <div class="field">
              <label for="email">E-mail <span>*</span></label>
              <input
                type="email" id="email" name="email"
                value="{{ old('email') }}"
                placeholder="voce@email.com"
                aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}"
                required>
              <span class="field__error">@error('email'){{ $message }}@enderror</span>
            </div>

            <div class="field">
              <label for="telefone">Telefone / WhatsApp <span>*</span></label>
              <input
                type="tel" id="telefone" name="telefone"
                value="{{ old('telefone') }}"
                placeholder="(00) 00000-0000"
                aria-invalid="{{ $errors->has('telefone') ? 'true' : 'false' }}"
                required>
              <span class="field__error">@error('telefone'){{ $message }}@enderror</span>
            </div>
          </div>
        </fieldset>

        <!-- DADOS DO CURSO -->
        <fieldset>
          <legend>Dados do curso</legend>

          <div class="form-grid">
            <div class="field">
              <label for="idade">Idade <span>*</span></label>
              <input
                type="number" id="idade" name="idade"
                value="{{ old('idade') }}"
                placeholder="Ex: 22" min="4" max="99"
                aria-invalid="{{ $errors->has('idade') ? 'true' : 'false' }}"
                required>
              <span class="field__error">@error('idade'){{ $message }}@enderror</span>
            </div>

            <div class="field">
              <label for="nivel">Nível de inglês <span>*</span></label>
              <select
                id="nivel" name="nivel"
                aria-invalid="{{ $errors->has('nivel') ? 'true' : 'false' }}"
                required>
                <option value="" disabled {{ old('nivel') ? '' : 'selected' }}>Selecione</option>
                <option value="iniciante" {{ old('nivel') == 'iniciante' ? 'selected' : '' }}>Iniciante</option>
                <option value="basico" {{ old('nivel') == 'basico' ? 'selected' : '' }}>Básico</option>
                <option value="intermediario" {{ old('nivel') == 'intermediario' ? 'selected' : '' }}>Intermediário</option>
                <option value="avancado" {{ old('nivel') == 'avancado' ? 'selected' : '' }}>Avançado</option>
                <option value="nao-sei" {{ old('nivel') == 'nao-sei' ? 'selected' : '' }}>Não sei / nunca estudei</option>
              </select>
              <span class="field__error">@error('nivel'){{ $message }}@enderror</span>
            </div>
          </div>
        </fieldset>

        <!-- ACESSO -->
        <fieldset>
          <legend>Acesso à plataforma</legend>

          <div class="form-grid">
            <div class="field">
              <label for="password">Senha <span>*</span></label>
              <div class="password-field">
                <input
                  type="password" id="password" name="password"
                  placeholder="Mínimo 8 caracteres" minlength="8"
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

            <div class="field">
              <label for="password_confirmation">Confirmar senha <span>*</span></label>
              <div class="password-field">
                <input
                  type="password" id="password_confirmation" name="password_confirmation"
                  placeholder="Repita a senha" minlength="8"
                  required>
                <button type="button" class="password-toggle" data-password-toggle="password_confirmation" aria-label="Mostrar senha" aria-pressed="false">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7Z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                  </svg>
                </button>
              </div>
            </div>

            <div class="field field--full">
              <label for="termos" style="display:flex; align-items:flex-start; gap:10px; font-weight:400;">
                <input type="checkbox" id="termos" name="termos" style="width:auto; height:auto; margin-top:3px; accent-color: var(--color-red);" required>
                <span>Li e concordo com os <a href="#" style="color: var(--color-red); font-weight:600;">Termos de Uso</a> e a <a href="#" style="color: var(--color-red); font-weight:600;">Política de Privacidade</a>.</span>
              </label>
              <span class="field__error">@error('termos'){{ $message }}@enderror</span>
            </div>
          </div>
        </fieldset>

        <p class="form-required">Campos marcados com <span style="color: var(--color-red);">*</span> são obrigatórios.</p>

        <button type="submit" class="btn btn--primary registration__submit">Criar minha conta</button>

        <p class="registration__login">
          Já tem uma conta? <a href="{{ route('login') }}">Entrar</a>
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
    // Alterna visibilidade dos campos de senha
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