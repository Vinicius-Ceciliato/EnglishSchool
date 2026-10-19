<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Aluno | Painel do Administrador</title>
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>

  @php $profile = $student->studentProfile; @endphp

  <!-- HEADER -->
  <header class="header">
    <div class="container header__inner">
      <a href="{{ route('admin.dashboard') }}" class="logo"><img src="{{ asset('images/logo.jpeg') }}" alt="Logo" width="120"></a>

      <nav class="nav" id="nav">
        <a href="{{ route('admin.dashboard') }}" class="nav__link">Painel</a>
        <a href="{{ route('admin.students.index') }}" class="nav__link nav__link--active">Alunos</a>
        <a href="{{ route('admin.materials.index') }}" class="nav__link">Materiais</a>
        <a href="#" class="nav__link">Cronograma</a>
        <a href="#" class="nav__link">Boletins</a>
      </nav>

      <div class="header__actions">
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

  <!-- FORMULÁRIO -->
  <section class="highlights">
    <div class="container" style="max-width: 760px;">

      <div style="margin-bottom: 24px;">
        <a href="{{ route('admin.students.index') }}" style="color: var(--color-gray-text); font-size: 0.9rem;">&larr; Voltar para Alunos</a>
        <h1 style="font-size: 1.6rem; margin-top: 8px;">Editar aluno</h1>
        <p style="color: var(--color-gray-text);">{{ $student->name }}</p>
      </div>

      @if ($errors->any())
        <div class="form-status" style="margin-bottom: 20px;">
          <strong>Verifique os campos abaixo:</strong>
          <ul style="margin: 8px 0 0 18px;">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form method="POST" action="{{ route('admin.students.update', $student) }}" class="registration">
        @csrf
        @method('PUT')

        <fieldset>
          <legend>Dados pessoais</legend>
          <div class="form-grid">
            <div class="field">
              <label for="name">Nome completo</label>
              <input type="text" id="name" name="name" value="{{ old('name', $student->name) }}" required aria-invalid="{{ $errors->has('name') ? 'true' : 'false' }}">
              @error('name') <span class="field__error">{{ $message }}</span> @enderror
            </div>
            <div class="field">
              <label for="email">E-mail</label>
              <input type="email" id="email" name="email" value="{{ old('email', $student->email) }}" required aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}">
              @error('email') <span class="field__error">{{ $message }}</span> @enderror
            </div>
            <div class="field">
              <label for="telefone">Telefone</label>
              <input type="text" id="telefone" name="telefone" value="{{ old('telefone', $profile->phone ?? '') }}" required aria-invalid="{{ $errors->has('telefone') ? 'true' : 'false' }}">
              @error('telefone') <span class="field__error">{{ $message }}</span> @enderror
            </div>
          </div>
        </fieldset>

        <fieldset>
          <legend>Dados do curso</legend>
          <div class="form-grid">
            <div class="field">
              <label for="idade">Idade</label>
              <input type="number" id="idade" name="idade" min="4" max="99" value="{{ old('idade', $profile->age ?? '') }}" required aria-invalid="{{ $errors->has('idade') ? 'true' : 'false' }}">
              @error('idade') <span class="field__error">{{ $message }}</span> @enderror
            </div>
            <div class="field">
              <label for="nivel">Nível de inglês</label>
              @php $nivelAtual = old('nivel', $profile->english_level ?? ''); @endphp
              <select id="nivel" name="nivel" required aria-invalid="{{ $errors->has('nivel') ? 'true' : 'false' }}">
                <option value="" disabled {{ $nivelAtual ? '' : 'selected' }}>Selecione</option>
                <option value="iniciante" {{ $nivelAtual === 'iniciante' ? 'selected' : '' }}>Iniciante</option>
                <option value="basico" {{ $nivelAtual === 'basico' ? 'selected' : '' }}>Básico</option>
                <option value="intermediario" {{ $nivelAtual === 'intermediario' ? 'selected' : '' }}>Intermediário</option>
                <option value="avancado" {{ $nivelAtual === 'avancado' ? 'selected' : '' }}>Avançado</option>
                <option value="nao-sei" {{ $nivelAtual === 'nao-sei' ? 'selected' : '' }}>A definir</option>
              </select>
              @error('nivel') <span class="field__error">{{ $message }}</span> @enderror
            </div>
          </div>

          <div class="field" style="margin-top: 14px;">
            <label style="display:flex; align-items:center; gap:10px; font-weight: 500;">
              <input type="checkbox" name="payment_up_to_date" value="1" {{ old('payment_up_to_date', $profile->payment_up_to_date ?? false) ? 'checked' : '' }} style="width:auto;">
              Mensalidade em dia
            </label>
          </div>
        </fieldset>

        <fieldset>
          <legend>Acesso à plataforma</legend>
          <div class="form-grid">
            <div class="field password-field">
              <label for="password">Nova senha</label>
              <input type="password" id="password" name="password" minlength="8" data-password-input aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}">
              <button type="button" class="password-toggle" data-password-toggle="password">Mostrar</button>
              @error('password') <span class="field__error">{{ $message }}</span> @enderror
            </div>
            <div class="field password-field">
              <label for="password_confirmation">Confirmar nova senha</label>
              <input type="password" id="password_confirmation" name="password_confirmation" minlength="8" data-password-input aria-invalid="false">
              <button type="button" class="password-toggle" data-password-toggle="password_confirmation">Mostrar</button>
            </div>
          </div>
          <p style="color: var(--color-gray-text); font-size: 0.85rem; margin-top: 10px;">
            Deixe em branco para manter a senha atual.
          </p>
        </fieldset>

        <div style="display:flex; gap:14px; margin-top: 10px;">
          <button type="submit" class="btn btn--primary">Salvar alterações</button>
          <a href="{{ route('admin.students.index') }}" class="btn btn--outline">Cancelar</a>
        </div>
      </form>

    </div>
  </section>

  <script src="{{ asset('js/script.js') }}"></script>
  <script>
    document.querySelectorAll('[data-password-toggle]').forEach(function (btn) {
      btn.addEventListener('click', function () {
        var input = document.querySelector('[data-password-input]#' + btn.getAttribute('data-password-toggle'));
        if (!input) return;
        var isPassword = input.type === 'password';
        input.type = isPassword ? 'text' : 'password';
        btn.textContent = isPassword ? 'Ocultar' : 'Mostrar';
      });
    });
  </script>
</body>
</html>