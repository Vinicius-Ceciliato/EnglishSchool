<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cronograma de {{ $student->name }} | Learn English with Fernanda Ceciliato</title>
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
    <div class="container" style="max-width: 980px;">

      <div style="margin-bottom: 24px;">
        <a href="{{ route('admin.schedules.index') }}" style="color: var(--color-gray-text); font-size: 0.9rem;">&larr; Todos os cronogramas</a>
        <h1 style="font-size: 1.6rem; margin-top: 8px;">Cronograma de {{ $student->name }}</h1>
        <p style="color: var(--color-gray-text);">Adicione aulas e tarefas de casa. O aluno vê tudo isso na área dele.</p>
      </div>

      @if (session('status'))
        <div class="form-status" style="margin-bottom: 20px;">{{ session('status') }}</div>
      @endif

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

      <!-- NOVO ITEM -->
      <form method="POST" action="{{ route('admin.schedules.store', $student) }}" class="registration" style="margin-bottom: 40px;">
        @csrf

        <fieldset>
          <legend>Novo item</legend>
          <div class="form-grid">
            <div class="field">
              <label for="type">Tipo</label>
              <select id="type" name="type" required>
                <option value="aula" {{ old('type', 'aula') === 'aula' ? 'selected' : '' }}>Aula</option>
                <option value="tarefa" {{ old('type') === 'tarefa' ? 'selected' : '' }}>Tarefa de casa</option>
              </select>
            </div>
            <div class="field">
              <label for="title">Título</label>
              <input type="text" id="title" name="title" value="{{ old('title') }}" placeholder="Ex.: Aula 5 - Past Simple" required>
            </div>
            <div class="field">
              <label for="date">Data <span id="dateHint" style="color: var(--color-gray-text); font-weight:400;">(dia da aula)</span></label>
              <input type="date" id="date" name="date" value="{{ old('date') }}" required>
            </div>
            <div class="field">
              <label for="start_time">Início (opcional)</label>
              <input type="time" id="start_time" name="start_time" value="{{ old('start_time') }}">
            </div>
            <div class="field">
              <label for="end_time">Término (opcional)</label>
              <input type="time" id="end_time" name="end_time" value="{{ old('end_time') }}">
            </div>
          </div>
          <div class="field" style="margin-top: 14px;">
            <label for="description">Detalhes (opcional)</label>
            <textarea id="description" name="description" rows="3" maxlength="1000"
              placeholder="Ex.: Fazer os exercícios 1 a 5 da página 42"
              style="width:100%; padding:12px 14px; border:1.5px solid var(--color-border); border-radius:var(--radius-sm); font:inherit;">{{ old('description') }}</textarea>
          </div>
        </fieldset>

        <div style="margin-top: 10px;">
          <button type="submit" class="btn btn--primary">Adicionar ao cronograma</button>
        </div>
      </form>

      <!-- LISTA -->
      <h2 style="font-size: 1.25rem; margin-bottom: 16px;">Itens do cronograma</h2>

      <div class="highlight-card" style="padding: 0; overflow-x: auto;">
        <table style="width:100%; border-collapse: collapse; min-width: 720px;">
          <thead>
            <tr style="border-bottom: 1px solid var(--color-border); text-align:left;">
              <th style="padding: 16px 20px; font-size: 0.82rem; text-transform:uppercase; letter-spacing:0.4px; color: var(--color-gray-text);">Data</th>
              <th style="padding: 16px 20px; font-size: 0.82rem; text-transform:uppercase; letter-spacing:0.4px; color: var(--color-gray-text);">Tipo</th>
              <th style="padding: 16px 20px; font-size: 0.82rem; text-transform:uppercase; letter-spacing:0.4px; color: var(--color-gray-text);">Título</th>
              <th style="padding: 16px 20px; font-size: 0.82rem; text-transform:uppercase; letter-spacing:0.4px; color: var(--color-gray-text);">Ações</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($entries as $entry)
              @php $passou = $entry->date->lt(today()); @endphp
              <tr style="border-bottom: 1px solid var(--color-border); {{ $passou ? 'opacity: 0.55;' : '' }}">
                <td style="padding: 14px 20px; white-space:nowrap;">
                  <strong>{{ $entry->date->format('d/m/Y') }}</strong>
                  <div style="color: var(--color-gray-text); font-size: 0.85rem;">
                    {{ $entry->date->locale('pt_BR')->isoFormat('dddd') }}
                    @if ($entry->startLabel())
                      · {{ $entry->startLabel() }}{{ $entry->endLabel() ? '–'.$entry->endLabel() : '' }}
                    @endif
                  </div>
                </td>
                <td style="padding: 14px 20px;">
                  @if ($entry->isTask())
                    <span style="display:inline-block; padding:4px 10px; border-radius:999px; font-size:0.78rem; font-weight:700; background: rgba(242,134,39,0.12); color: var(--color-orange-dark);">Tarefa</span>
                  @else
                    <span style="display:inline-block; padding:4px 10px; border-radius:999px; font-size:0.78rem; font-weight:700; background: rgba(191,51,38,0.1); color: var(--color-red);">Aula</span>
                  @endif
                </td>
                <td style="padding: 14px 20px;">
                  <strong>{{ $entry->title }}</strong>
                  @if ($entry->description)
                    <div style="color: var(--color-gray-text); font-size: 0.85rem; white-space: pre-line;">{{ $entry->description }}</div>
                  @endif
                </td>
                <td style="padding: 14px 20px; white-space:nowrap;">
                  <a href="{{ route('admin.schedules.edit', $entry) }}" style="color: var(--color-ink); font-weight:600; margin-right: 14px;">Editar</a>
                  <form method="POST" action="{{ route('admin.schedules.destroy', $entry) }}" style="display:inline;"
                    onsubmit="return confirm('Remover este item do cronograma?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="background:none; border:none; color: var(--color-red); font-weight:600; cursor:pointer; padding:0;">Remover</button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="4" style="padding: 32px 20px; text-align:center; color: var(--color-gray-text);">
                  Nenhum item ainda. Use o formulário acima para adicionar a primeira aula.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

    </div>
  </section>

  <script src="{{ asset('js/script.js') }}"></script>
  <script>
    var tipo = document.getElementById('type');
    var dica = document.getElementById('dateHint');
    function atualizaDica() { dica.textContent = tipo.value === 'tarefa' ? '(data de entrega)' : '(dia da aula)'; }
    tipo.addEventListener('change', atualizaDica);
    atualizaDica();
  </script>
</body>
</html>