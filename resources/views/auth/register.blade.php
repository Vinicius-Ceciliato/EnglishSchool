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
  <section class="auth">
    <div class="container">
      <div class="auth__wrapper">

        <!-- Lado informativo -->
        <aside class="auth__side">
          <div>
            <h2>Comece sua jornada no inglês hoje mesmo.</h2>
            <p>Crie sua conta e tenha acesso ao seu cronograma individual, materiais exclusivos e acompanhamento completo da sua evolução.</p>
          </div>

          <div class="auth__side-list">
            <div class="auth__side-item">
              <span>📅</span> Cronograma de aulas personalizado
            </div>
            <div class="auth__side-item">
              <span>📄</span> Materiais em PDF por nível
            </div>
            <div class="auth__side-item">
              <span>📊</span> Boletim sempre atualizado
            </div>
          </div>
        </aside>

        <!-- Formulário -->
        <div class="auth__form">
          <h1>Criar conta de aluno</h1>
          <p class="auth__subtitle">Preencha seus dados para solicitar matrícula.</p>

          <form method="POST" action="{{ route('register') }}" novalidate>
            @csrf

            <div class="field @error('name') field--error @enderror">
              <label for="name">Nome completo</label>
              <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Seu nome completo" required autofocus>
              @error('name')
                <span class="field__error-msg">{{ $message }}</span>
              @enderror
            </div>

            <div class="form-row">
              <div class="field @error('email') field--error @enderror">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="voce@email.com" required>
                @error('email')
                  <span class="field__error-msg">{{ $message }}</span>
                @enderror
              </div>
              <div class="field @error('telefone') field--error @enderror">
                <label for="telefone">Telefone / WhatsApp</label>
                <input type="tel" id="telefone" name="telefone" value="{{ old('telefone') }}" placeholder="(00) 00000-0000" required>
                @error('telefone')
                  <span class="field__error-msg">{{ $message }}</span>
                @enderror
              </div>
            </div>

            <div class="form-row">
              <div class="field @error('idade') field--error @enderror">
                <label for="idade">Idade</label>
                <input type="number" id="idade" name="idade" value="{{ old('idade') }}" placeholder="Ex: 22" min="4" max="99" required>
                @error('idade')
                  <span class="field__error-msg">{{ $message }}</span>
                @enderror
              </div>
              <div class="field @error('nivel') field--error @enderror">
                <label for="nivel">Nível de inglês</label>
                <select id="nivel" name="nivel" required>
                  <option value="" disabled {{ old('nivel') ? '' : 'selected' }}>Selecione</option>
                  <option value="iniciante" {{ old('nivel') == 'iniciante' ? 'selected' : '' }}>Iniciante</option>
                  <option value="basico" {{ old('nivel') == 'basico' ? 'selected' : '' }}>Básico</option>
                  <option value="intermediario" {{ old('nivel') == 'intermediario' ? 'selected' : '' }}>Intermediário</option>
                  <option value="avancado" {{ old('nivel') == 'avancado' ? 'selected' : '' }}>Avançado</option>
                  <option value="nao-sei" {{ old('nivel') == 'nao-sei' ? 'selected' : '' }}>Não sei / nunca estudei</option>
                </select>
                @error('nivel')
                  <span class="field__error-msg">{{ $message }}</span>
                @enderror
              </div>
            </div>

            <div class="form-row">
              <div class="field @error('password') field--error @enderror">
                <label for="password">Senha</label>
                <input type="password" id="password" name="password" placeholder="Mínimo 8 caracteres" minlength="8" required>
                @error('password')
                  <span class="field__error-msg">{{ $message }}</span>
                @enderror
              </div>
              <div class="field">
                <label for="password_confirmation">Confirmar senha</label>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Repita a senha" minlength="8" required>
              </div>
            </div>

            <div class="field-check">
              <input type="checkbox" id="termos" name="termos" required>
              <label for="termos">Li e concordo com os <a href="#">Termos de Uso</a> e a <a href="#">Política de Privacidade</a>.</label>
            </div>

            <button type="submit" class="btn btn--primary btn--block">Criar minha conta</button>

            <p class="auth__footer-text">
              Já tem uma conta? <a href="{{ route('login') }}">Entrar</a>
            </p>
          </form>
        </div>

      </div>
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