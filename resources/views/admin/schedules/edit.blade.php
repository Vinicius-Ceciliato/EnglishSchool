<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar item | Learn English with Fernanda Ceciliato</title>
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
        <a href="{{ route('admin.schedules.index') }}" class="nav__link nav__link--active">Cronograma</a>
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

  <section class="highlights">
    <div class="container" style="max-width: 760px;">

      <div style="margin-bottom: 24px;">
        <a href="{{ route('admin.schedules.show', $schedule->student_id) }}" style="color: var(--color-gray-text); font-size: 0.9rem;">&larr; Voltar ao cronograma de {{ $schedule->student->name ?? 'aluno' }}</a>
        <h1 style="font-size: 1.6rem; margin-top: 8px;">Editar item</h1>
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

      <form method="POST" action="{{ route('admin.schedules.update', $schedule) }}" class="registration">
        @csrf
        @method('PUT')

        <fieldset>
          <legend>Dados do item</legend>
          @php $tipoAtual = old('type', $schedule->type); @endphp
          <div class="form-grid">
            <div class="field">
              <label for="type">Tipo</label>
              <select id="type" name="type" required>
                <option value="aula" {{ $tipoAtual === 'aula' ? 'selected' : '' }}>Aula</option>
                <option value="tarefa" {{ $tipoAtual === 'tarefa' ? 'selected' : '' }}>Tarefa de casa</option>
              </select>
            </div>
            <div class="field">
              <label for="title">Título</label>
              <input type="text" id="title" name="title" value="{{ old('title', $schedule->title) }}" required>
            </div>
            <div class="field">
              <label for="date">Data</label>
              <input type="date" id="date" name="date" value="{{ old('date', $schedule->date->format('Y-m-d')) }}" required>
            </div>
            <div class="field">
              <label for="start_time">Início (opcional)</label>
              <input type="time" id="start_time" name="start_time" value="{{ old('start_time', $schedule->startLabel()) }}">
            </div>
            <div class="field">
              <label for="end_time">Término (opcional)</label>
              <input type="time" id="end_time" name="end_time" value="{{ old('end_time', $schedule->endLabel()) }}">
            </div>
          </div>
          <div class="field" style="margin-top: 14px;">
            <label for="description">Detalhes (opcional)</label>
            <textarea id="description" name="description" rows="4" maxlength="1000"
              style="width:100%; padding:12px 14px; border:1.5px solid var(--color-border); border-radius:var(--radius-sm); font:inherit;">{{ old('description', $schedule->description) }}</textarea>
          </div>
        </fieldset>

        <div style="display:flex; gap:14px; margin-top: 10px;">
          <button type="submit" class="btn btn--primary">Salvar alterações</button>
          <a href="{{ route('admin.schedules.show', $schedule->student_id) }}" class="btn btn--outline">Cancelar</a>
        </div>
      </form>

    </div>
  </section>

  <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>