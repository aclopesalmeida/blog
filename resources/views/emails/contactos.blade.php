@if(!is_null($request['nome']))
    <h4>Nome: {{ $request['nome'] }}</h4>
@endif
<h4>Email: {{ $request['email'] }}</h4>
<p>Assunto: {{ $request['assunto'] }}</p>
<p>{{ $request['mensagem'] }}</p>