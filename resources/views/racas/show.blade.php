@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('racas.index') }}">Lista de Raças</a></li>
      <li class="breadcrumb-item active" aria-current="page">Exibir Registro</li>
    </ol>
  </nav>
</div>

<x-card title="Permissões">
  <ul class="list-group list-group-flush">
    <li class="list-group-item">Descrição: {{$raca->descricao}}</li>
  </ul>
</x-card>

<x-btn-back route="racas.index" />

<x-modal-trash>
  <form method="post" action="{{route('racas.destroy', $raca)}}">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i> Apagar Registro</button>
  </form>  
</x-modal-trash>

@endsection
