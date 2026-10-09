<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Painel do aluno | English School</title>
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
  <h1>Painel do aluno</h1>
  <p>Bem-vindo, {{ auth()->user()->name }}!</p>
  <form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit">Sair</button>
  </form>
</body>
</html>