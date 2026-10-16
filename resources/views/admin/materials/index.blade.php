<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Materiais | Painel do Administrador</title>
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
        <a href="{{ route('admin.materials.index') }}" class="nav__link nav__link--active">Materiais</a>
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

  <section class="highlights">
    <div class="container">

      <div style="margin-bottom: 24px;">
        <h1 style="font-size: 1.6rem;">Materiais</h1>
        <p style="color: var(--color-gray-text);">Envie PDFs e escolha quais alunos vão poder ver cada um.</p>
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

      <!-- ENVIAR MATERIAL -->
      <form method="POST" action="{{ route('admin.materials.store') }}" enctype="multipart/form-data" class="registration" style="margin-bottom: 40px;">
        @csrf

        <fieldset>
          <legend>Novo material</legend>
          <div class="form-grid">
            <div class="field">
              <label for="title">Título</label>
              <input type="text" id="title" name="title" value="{{ old('title') }}" required>
            </div>
            <div class="field">
              <label for="file">Arquivo PDF (até 20 MB)</label>
              <input type="file" id="file" name="file" accept="application/pdf" required>
            </div>
          </div>
          <div class="field" style="margin-top: 14px;">
            <label for="description">Descrição (opcional)</label>
            <input type="text" id="description" name="description" value="{{ old('description') }}" maxlength="500">
          </div>
        </fieldset>

        <fieldset>
          <legend>Quem pode ver</legend>

          @if ($students->isEmpty())
            <p style="color: var(--color-gray-text);">Nenhum aluno cadastrado ainda.</p>
          @else
            <label style="display:flex; align-items:center; gap:10px; font-weight:600; margin-bottom: 12px;">
              <input type="checkbox" id="selectAll" style="width:auto;"> Selecionar todos os alunos
            </label>

            <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 8px 16px;">
              @foreach ($students as $student)
                <label style="display:flex; align-items:center; gap:10px; font-weight:500;">
                  <input type="checkbox" name="students[]" value="{{ $student->id }}" class="student-check" style="width:auto;"
                    {{ in_array($student->id, old('students', [])) ? 'checked' : '' }}>
                  {{ $student->name }}
                </label>
              @endforeach
            </div>
          @endif
        </fieldset>

        <div style="margin-top: 10px;">
          <button type="submit" class="btn btn--primary">Enviar material</button>
        </div>
      </form>

      <!-- LISTA -->
      <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:16px; margin-bottom: 16px;">
        <h2 style="font-size: 1.25rem;">Materiais enviados</h2>

        <form method="GET" action="{{ route('admin.materials.index') }}">
          <select name="aluno" onchange="this.form.submit()"
            style="height:44px; padding:0 14px; border:1.5px solid var(--color-border); border-radius:var(--radius-sm); font:inherit;">
            <option value="">Todos os alunos</option>
            @foreach ($students as $student)
              <option value="{{ $student->id }}" {{ (string) request('aluno') === (string) $student->id ? 'selected' : '' }}>{{ $student->name }}</option>
            @endforeach
          </select>
        </form>
      </div>

      <div class="highlight-card" style="padding: 0; overflow-x: auto;">
        <table style="width:100%; border-collapse: collapse; min-width: 720px;">
          <thead>
            <tr style="border-bottom: 1px solid var(--color-border); text-align:left;">
              <th style="padding: 16px 20px; font-size: 0.82rem; text-transform:uppercase; letter-spacing:0.4px; color: var(--color-gray-text);">Título</th>
              <th style="padding: 16px 20px; font-size: 0.82rem; text-transform:uppercase; letter-spacing:0.4px; color: var(--color-gray-text);">Aluno</th>
              <th style="padding: 16px 20px; font-size: 0.82rem; text-transform:uppercase; letter-spacing:0.4px; color: var(--color-gray-text);">Tamanho</th>
              <th style="padding: 16px 20px; font-size: 0.82rem; text-transform:uppercase; letter-spacing:0.4px; color: var(--color-gray-text);">Enviado em</th>
              <th style="padding: 16px 20px; font-size: 0.82rem; text-transform:uppercase; letter-spacing:0.4px; color: var(--color-gray-text);">Ações</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($materials as $material)
              <tr style="border-bottom: 1px solid var(--color-border);">
                <td style="padding: 14px 20px;">
                  <strong>{{ $material->title }}</strong>
                  @if ($material->description)
                    <div style="color: var(--color-gray-text); font-size: 0.85rem;">{{ $material->description }}</div>
                  @endif
                </td>
                <td style="padding: 14px 20px;">{{ $material->user->name ?? '—' }}</td>
                <td style="padding: 14px 20px; color: var(--color-gray-text);">{{ number_format($material->size / 1048576, 2, ',', '.') }} MB</td>
                <td style="padding: 14px 20px; color: var(--color-gray-text);">{{ $material->created_at->format('d/m/Y') }}</td>
                <td style="padding: 14px 20px; white-space:nowrap;">
                  <a href="{{ route('materiais.download', $material) }}" target="_blank" style="color: var(--color-ink); font-weight:600; margin-right: 14px;">Abrir</a>
                  <form method="POST" action="{{ route('admin.materials.destroy', $material) }}" style="display:inline;"
                    onsubmit="return confirm('Remover este material de {{ $material->user->name ?? 'aluno' }}?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="background:none; border:none; color: var(--color-red); font-weight:600; cursor:pointer; padding:0;">Remover</button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" style="padding: 32px 20px; text-align:center; color: var(--color-gray-text);">
                  Nenhum material enviado ainda.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div style="margin-top: 24px;">
        {{ $materials->links() }}
      </div>

    </div>
  </section>

  <script src="{{ asset('js/script.js') }}"></script>
  <script>
    var all = document.getElementById('selectAll');
    if (all) {
      all.addEventListener('change', function () {
        document.querySelectorAll('.student-check').forEach(function (c) { c.checked = all.checked; });
      });
    }
  </script>
</body>
</html>