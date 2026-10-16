<h2>Nova avaliação recebida</h2>
<p><strong>Nome:</strong> {{ $review->author_name }}</p>
<p><strong>Nota:</strong> {{ $review->rating }} / 5</p>
<p><strong>Comentário:</strong></p>
<p>{{ $review->comment }}</p>
<p>
  <a href="{{ route('admin.dashboard') }}">Acessar o painel administrativo</a>
  para aprovar ou recusar essa avaliação.
</p>