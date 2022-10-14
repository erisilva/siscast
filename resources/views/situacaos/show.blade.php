@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('situacaos.index') }}">Lista de Situações dos Pedidos</a></li>
      <li class="breadcrumb-item active" aria-current="page">Exibir Registro</li>
    </ol>
  </nav>
</div>

<x-card title="Situações dos Pedidos">
  <ul class="list-group list-group-flush">
    <li class="list-group-item">Nome: {{$situacao->NOME}}</li>
    <li class="list-group-item">Descrição: {{$situacao->descricao}}</li>
    <li class="list-group-item">Cor: {{$situacao->cor}}</li>
    <li class="list-group-item">Ícone: {{$situacao->icone}}</li>
    <li class="list-group-item">Desenho: <button type="button" class="btn {{$situacao->cor}}"><i class="{{$situacao->icone}}"></i> {{$situacao->nome}}</button></li>
  </ul>
</x-card>

<x-btn-back route="situacaos.index" />

<x-modal-trash>
  <form method="post" action="{{route('situacaos.destroy', $situacao)}}">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i> Apagar Registro</button>
  </form>  
</x-modal-trash>

@endsection
