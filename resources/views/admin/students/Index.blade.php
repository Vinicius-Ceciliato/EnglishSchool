<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Alunos | Painel do Administrador</title>
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>

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

  <!-- CONTEÚDO -->
  <section class="highlights">
    <div class="container">

      <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:16px; margin-bottom: 24px;">
        <div>
          <h1 style="font-size: 1.6rem;">Alunos</h1>
          <p style="color: var(--color-gray-text);">{{ $students->total() }} aluno(s) cadastrado(s).</p>
        </div>
        <a href="{{ route('admin.students.create') }}" class="btn btn--primary">+ Novo aluno</a>
      </div>

      @if (session('status'))
        <div class="form-status" style="margin-bottom: 20px;">{{ session('status') }}</div>
      @endif

      <!-- BUSCA -->
      <form method="GET" action="{{ route('admin.students.index') }}" style="margin-bottom: 24px; max-width: 360px;">
        <div class="field" style="margin-bottom: 0;">
          <input type="text" name="busca" value="{{ request('busca') }}" placeholder="Buscar por nome ou e-mail"
            style="width:100%; height:44px; padding:0 14px; border:1.5px solid var(--color-border); border-radius:var(--radius-sm); font:inherit;">
        </div>
      </form>

      <!-- TABELA -->
      <div class="highlight-card" style="padding: 0; overflow-x: auto;">
        <table style="width:100%; border-collapse: collapse; min-width: 720px;">
          <thead>
            <tr style="border-bottom: 1px solid var(--color-border); text-align:left;">
              <th style="padding: 16px 20px; font-size: 0.82rem; text-transform:uppercase; letter-spacing:0.4px; color: var(--color-gray-text);">Nome</th>
              <th style="padding: 16px 20px; font-size: 0.82rem; text-transform:uppercase; letter-spacing:0.4px; color: var(--color-gray-text);">E-mail</th>
              <th style="padding: 16px 20px; font-size: 0.82rem; text-transform:uppercase; letter-spacing:0.4px; color: var(--color-gray-text);">Idade</th>
              <th style="padding: 16px 20px; font-size: 0.82rem; text-transform:uppercase; letter-spacing:0.4px; color: var(--color-gray-text);">Nível</th>
              <th style="padding: 16px 20px; font-size: 0.82rem; text-transform:uppercase; letter-spacing:0.4px; color: var(--color-gray-text);">Mensalidade</th>
              <th style="padding: 16px 20px; font-size: 0.82rem; text-transform:uppercase; letter-spacing:0.4px; color: var(--color-gray-text);">Ações</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($students as $student)
              @php $profile = $student->studentProfile; @endphp
              <tr style="border-bottom: 1px solid var(--color-border);">
                <td style="padding: 14px 20px; font-weight: 600;">{{ $student->name }}</td>
                <td style="padding: 14px 20px; color: var(--color-gray-text);">{{ $student->email }}</td>
                <td style="padding: 14px 20px;">{{ $profile->age ?? '—' }}</td>
                <td style="padding: 14px 20px; text-transform:capitalize;">{{ $profile->english_level ?? '—' }}</td>
                <td style="padding: 14px 20px;">
                  <form method="POST" action="{{ route('admin.students.toggle-payment', $student) }}">
                    @csrf
                    @method('PATCH')
                    @php $emDia = $profile && $profile->payment_up_to_date; @endphp
                    <button type="submit" style="
                      display:inline-flex; align-items:center; gap:8px;
                      border:1.5px solid {{ $emDia ? '#2e7d32' : 'var(--color-orange)' }};
                      background: {{ $emDia ? 'rgba(46,125,50,0.08)' : 'rgba(242,134,39,0.1)' }};
                      color: {{ $emDia ? '#2e7d32' : 'var(--color-orange-dark)' }};
                      padding: 6px 12px; border-radius: 999px; font-size: 0.82rem; font-weight:700; cursor:pointer;">
                      {{ $emDia ? '✓ Em dia' : '⏳ Pendente' }}
                    </button>
                  </form>
                </td>
                <td style="padding: 14px 20px; white-space:nowrap;">
                  <a href="{{ route('admin.students.edit', $student) }}" style="color: var(--color-ink); font-weight:600; margin-right: 14px;">Editar</a>
                  <form method="POST" action="{{ route('admin.students.destroy', $student) }}" style="display:inline;"
                    onsubmit="return confirm('Remover {{ $student->name }}? Essa ação não pode ser desfeita.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="background:none; border:none; color: var(--color-red); font-weight:600; cursor:pointer; padding:0;">Remover</button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" style="padding: 32px 20px; text-align:center; color: var(--color-gray-text);">
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