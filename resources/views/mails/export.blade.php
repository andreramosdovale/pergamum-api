<h2>Olá {{$data['name']}}</h2>
<p>Segue os itens selecionados do site do Pergamum</p>

<ul>
  @foreach ($data['message'] as $data)
      <li>{{ $data }}</li>
  @endforeach
</ul>