<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Boletim de {{ $student->name }} | Learn English with Fernanda Ceciliato</title>
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
    <div class="container" style="max-width: 1060px;">

      <div style="margin-bottom: 24px;">
        <a href="{{ route('admin.grades.index') }}" style="color: var(--color-gray-text); font-size: 0.9rem;">&larr; Todos os boletins</a>
        <h1 style="font-size: 1.6rem; margin-top: 8px;">Boletim de {{ $student->name }}</h1>
        <p style="color: var(--color-gray-text);">
          Média das provas: <strong style="color: {{ \App\Models\Grade::scoreColor($average) }};">{{ \App\Models\Grade::percent($average) }}</strong>
          · {{ $grades->count() }} avaliação(ões) lançada(s)
        </p>
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

      <!-- NOVO BOLETIM -->
      <form method="POST" action="{{ route('admin.grades.store', $student) }}" class="registration" style="margin-bottom: 40px;">
        @csrf

        <fieldset>
          <legend>Nova avaliação</legend>
          <div class="form-grid">
            <div class="field">
              <label for="title">Título</label>
              <input type="text" id="title" name="title" value="{{ old('title') }}" placeholder="Ex.: 1º bimestre, Unit 3 test" required>
            </div>
            <div class="field">
              <label for="assessed_on">Data</label>
              <input type="date" id="assessed_on" name="assessed_on" value="{{ old('assessed_on') }}" required>
            </div>
            <div class="field">
              <label for="exam_score">Nota da prova (0 a 100 %)</label>
              <input type="number" id="exam_score" name="exam_score" min="0" max="100" step="0.1" value="{{ old('exam_score') }}" required>
            </div>
          </div>
        </fieldset>

        <fieldset>
          <legend>Conceitos por habilidade</legend>
          <div class="form-grid">
            @foreach (\App\Models\Grade::SKILLS as $skillKey => $skillLabel)
              <div class="field">
                <label for="{{ $skillKey }}">{{ $skillLabel }}</label>
                <select id="{{ $skillKey }}" name="{{ $skillKey }}" required>
                  <option value="" disabled {{ old($skillKey) ? '' : 'selected' }}>Selecione</option>
                  @foreach (\App\Models\Grade::CONCEPTS as $conceptKey => $conceptLabel)
                    <option value="{{ $conceptKey }}" {{ old($skillKey) === $conceptKey ? 'selected' : '' }}>{{ $conceptLabel }}</option>
                  @endforeach
                </select>
              </div>
            @endforeach
          </div>

          <div class="field" style="margin-top: 14px;">
            <label for="comments">Observações (opcional)</label>
            <textarea id="comments" name="comments" rows="3" maxlength="1000"
              placeholder="Ex.: Evoluiu muito na pronúncia, precisa revisar o Past Simple."
              style="width:100%; padding:12px 14px; border:1.5px solid var(--color-border); border-radius:var(--radius-sm); font:inherit;">{{ old('comments') }}</textarea>
          </div>
        </fieldset>

        <div style="margin-top: 10px;">
          <button type="submit" class="btn btn--primary">Lançar boletim</button>
        </div>
      </form>

      <!-- HISTÓRICO -->
      <h2 style="font-size: 1.25rem; margin-bottom: 16px;">Histórico</h2>

      <div class="highlight-card" style="padding: 0; overflow-x: auto;">
        <table style="width:100%; border-collapse: collapse; min-width: 900px;">
          <thead>
            <tr style="border-bottom: 1px solid var(--color-border); text-align:left;">
              <th style="padding: 16px 16px; font-size: 0.78rem; text-transform:uppercase; letter-spacing:0.4px; color: var(--color-gray-text);">Avaliação</th>
              @foreach (\App\Models\Grade::SKILLS as $skillLabel)
                <th style="padding: 16px 12px; font-size: 0.78rem; text-transform:uppercase; letter-spacing:0.4px; color: var(--color-gray-text);">{{ $skillLabel }}</th>
              @endforeach
              <th style="padding: 16px 16px; font-size: 0.78rem; text-transform:uppercase; letter-spacing:0.4px; color: var(--color-gray-text);">Prova</th>
              <th style="padding: 16px 16px; font-size: 0.78rem; text-transform:uppercase; letter-spacing:0.4px; color: var(--color-gray-text);">Ações</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($grades as $grade)
              <tr style="border-bottom: 1px solid var(--color-border);">
                <td style="padding: 14px 16px;">
                  <strong>{{ $grade->title }}</strong>
                  <div style="color: var(--color-gray-text); font-size: 0.85rem;">{{ $grade->assessed_on->format('d/m/Y') }}</div>
                  @if ($grade->comments)
                    <div style="color: var(--color-gray-text); font-size: 0.82rem; margin-top: 4px; white-space: pre-line;">{{ $grade->comments }}</div>
                  @endif
                </td>
                @foreach (\App\Models\Grade::SKILLS as $skillKey => $skillLabel)
                  <td style="padding: 14px 12px;">
                    <span style="display:inline-block; padding:4px 10px; border-radius:999px; font-size:0.78rem; font-weight:700; white-space:nowrap; {{ \App\Models\Grade::conceptStyle($grade->{$skillKey}) }}">
                      {{ $grade->conceptLabel($skillKey) }}
                    </span>
                  </td>
                @endforeach
                <td style="padding: 14px 16px; font-weight:800; font-size: 1.05rem; color: {{ \App\Models\Grade::scoreColor($grade->exam_score) }};">
                  {{ $grade->scoreLabel() }}
                </td>
                <td style="padding: 14px 16px; white-space:nowrap;">
                  <a href="{{ route('admin.grades.edit', $grade) }}" style="color: var(--color-ink); font-weight:600; margin-right: 14px;">Editar</a>
                  <form method="POST" action="{{ route('admin.grades.destroy', $grade) }}" style="display:inline;"
                    onsubmit="return confirm('Remover este boletim?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="background:none; border:none; color: var(--color-red); font-weight:600; cursor:pointer; padding:0;">Remover</button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" style="padding: 32px 20px; text-align:center; color: var(--color-gray-text);">
                  Nenhum boletim lançado ainda. Use o formulário acima.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

    </div>
  </section>

  <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>