<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar boletim | Learn English with Fernanda Ceciliato</title>
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>

  <!-- HEADER -->
  <header class="header">
    <div class="container header__inner">
      <a href="{{ route('admin.dashboard') }}" class="logo"><img src="{{ asset('images/logo.jpeg') }}" alt="Logo" width="120"></a>

      <nav class="nav" id="nav">
        <a href="{{ route('admin.dashboard') }}" class="nav__link">Painel</a>
        <a href="{{ route('admin.students.index') }}" class="nav__link">Alunos</a>
        <a href="{{ route('admin.materials.index') }}" class="nav__link">Materiais</a>
        <a href="{{ route('admin.schedules.index') }}" class="nav__link">Cronograma</a>
        <a href="{{ route('admin.grades.index') }}" class="nav__link nav__link--active">Boletins</a>
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

  <section class="highlights">
    <div class="container" style="max-width: 760px;">

      <div style="margin-bottom: 24px;">
        <a href="{{ route('admin.grades.show', $grade->student_id) }}" style="color: var(--color-gray-text); font-size: 0.9rem;">&larr; Voltar ao boletim de {{ $grade->student->name ?? 'aluno' }}</a>
        <h1 style="font-size: 1.6rem; margin-top: 8px;">Editar boletim</h1>
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

      <form method="POST" action="{{ route('admin.grades.update', $grade) }}" class="registration">
        @csrf
        @method('PUT')

        <fieldset>
          <legend>Avaliação</legend>
          <div class="form-grid">
            <div class="field">
              <label for="title">Título</label>
              <input type="text" id="title" name="title" value="{{ old('title', $grade->title) }}" required>
            </div>
            <div class="field">
              <label for="assessed_on">Data</label>
              <input type="date" id="assessed_on" name="assessed_on" value="{{ old('assessed_on', $grade->assessed_on->format('Y-m-d')) }}" required>
            </div>
            <div class="field">
              <label for="exam_score">Nota da prova (0 a 100 %)</label>
              <input type="number" id="exam_score" name="exam_score" min="0" max="100" step="0.1" value="{{ old('exam_score', $grade->exam_score) }}" required>
            </div>
          </div>
        </fieldset>

        <fieldset>
          <legend>Conceitos por habilidade</legend>
          <div class="form-grid">
            @foreach (\App\Models\Grade::SKILLS as $skillKey => $skillLabel)
              @php $atual = old($skillKey, $grade->{$skillKey}); @endphp
              <div class="field">
                <label for="{{ $skillKey }}">{{ $skillLabel }}</label>
                <select id="{{ $skillKey }}" name="{{ $skillKey }}" required>
                  @foreach (\App\Models\Grade::CONCEPTS as $conceptKey => $conceptLabel)
                    <option value="{{ $conceptKey }}" {{ $atual === $conceptKey ? 'selected' : '' }}>{{ $conceptLabel }}</option>
                  @endforeach
                </select>
              </div>
            @endforeach
          </div>

          <div class="field" style="margin-top: 14px;">
            <label for="comments">Observações (opcional)</label>
            <textarea id="comments" name="comments" rows="4" maxlength="1000"
              style="width:100%; padding:12px 14px; border:1.5px solid var(--color-border); border-radius:var(--radius-sm); font:inherit;">{{ old('comments', $grade->comments) }}</textarea>
          </div>
        </fieldset>

        <div style="display:flex; gap:14px; margin-top: 10px;">
          <button type="submit" class="btn btn--primary">Salvar alterações</button>
          <a href="{{ route('admin.grades.show', $grade->student_id) }}" class="btn btn--outline">Cancelar</a>
        </div>
      </form>

    </div>
  </section>

  <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>