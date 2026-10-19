<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cronogramas | Learn English with Fernanda Ceciliato</title>
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
        <a href="{{ route('admin.grades.index') }}" class="nav__link">Boletins</a>
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
        <h1 style="font-size: 1.6rem;">Cronogramas</h1>
        <p style="color: var(--color-gray-text);">Escolha um aluno para ver e alterar o cronograma dele: aulas e tarefas de casa.</p>
      </div>

      @if (session('status'))
        <div class="form-status" style="margin-bottom: 20px;">{{ session('status') }}</div>
      @endif

      <!-- BUSCA -->
      <form method="GET" action="{{ route('admin.schedules.index') }}" style="margin-bottom: 24px; max-width: 360px;">
        <input type="text" name="busca" value="{{ request('busca') }}" placeholder="Buscar aluno por nome"
          style="width:100%; height:44px; padding:0 14px; border:1.5px solid var(--color-border); border-radius:var(--radius-sm); font:inherit;">
      </form>

      <!-- TABELA -->
      <div class="highlight-card" style="padding: 0; overflow-x: auto;">
        <table style="width:100%; border-collapse: collapse; min-width: 720px;">
          <thead>
            <tr style="border-bottom: 1px solid var(--color-border); text-align:left;">
              <th style="padding: 16px 20px; font-size: 0.82rem; text-transform:uppercase; letter-spacing:0.4px; color: var(--color-gray-text);">Aluno</th>
              <th style="padding: 16px 20px; font-size: 0.82rem; text-transform:uppercase; letter-spacing:0.4px; color: var(--color-gray-text);">Nível</th>
              <th style="padding: 16px 20px; font-size: 0.82rem; text-transform:uppercase; letter-spacing:0.4px; color: var(--color-gray-text);">Próximo item</th>
              <th style="padding: 16px 20px; font-size: 0.82rem; text-transform:uppercase; letter-spacing:0.4px; color: var(--color-gray-text);">Itens futuros</th>
              <th style="padding: 16px 20px; font-size: 0.82rem; text-transform:uppercase; letter-spacing:0.4px; color: var(--color-gray-text);">Ação</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($students as $student)
              @php
                $proximo = $next[$student->id] ?? null;
                $total = $counts[$student->id] ?? 0;
              @endphp
              <tr style="border-bottom: 1px solid var(--color-border);">
                <td style="padding: 14px 20px; font-weight: 600;">{{ $student->name }}</td>
                <td style="padding: 14px 20px; text-transform:capitalize;">{{ $student->studentProfile->english_level ?? '—' }}</td>
                <td style="padding: 14px 20px;">
                  @if ($proximo)
                    <span style="font-weight:600;">{{ $proximo->title }}</span>
                    <div style="color: var(--color-gray-text); font-size: 0.85rem;">
                      {{ $proximo->isTask() ? 'Tarefa' : 'Aula' }} ·
                      {{ $proximo->date->format('d/m/Y') }}{{ $proximo->startLabel() ? ' às '.$proximo->startLabel() : '' }}
                    </div>
                  @else
                    <span style="color: var(--color-gray-text);">Nada agendado</span>
                  @endif
                </td>
                <td style="padding: 14px 20px;">{{ $total }}</td>
                <td style="padding: 14px 20px; white-space:nowrap;">
                  <a href="{{ route('admin.schedules.show', $student) }}" class="btn btn--primary" style="padding: 8px 16px; font-size: 0.85rem;">Ver / editar</a>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" style="padding: 32px 20px; text-align:center; color: var(--color-gray-text);">
                  Nenhum aluno encontrado.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div style="margin-top: 24px;">
        {{ $students->links() }}
      </div>

    </div>
  </section>

  <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>