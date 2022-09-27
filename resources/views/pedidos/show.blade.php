@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('pedidos.index') }}">Lista de Pedidos</a></li>
      <li class="breadcrumb-item active" aria-current="page">Exibir Registro</li>
    </ol>
  </nav>
</div>

<x-card title="Permissões">
  <form>
    <div class="form-group py-1">
      <div class="container bg-warning text-dark">
        <p class="text-center"><strong>Informações Sobre o Tutor</strong></p>
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="nome">Nome</label>
        <input type="text" class="form-control" name="nome" value="{{ $pedido->nome }}" readonly>
      </div>
      <div class="form-group col-md-3">
        <label for="nascimento">Nascimento</strong></label>
        <input type="text" class="form-control" name="nascimento" value="{{ $pedido->nascimento->format('d/m/Y') }}" readonly>
      </div>
      <div class="form-group col-md-3">
        <label for="cpf">CPF</label>
        <input type="text" class="form-control" name="cpf" value="{{ preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $pedido->cpf) }}" readonly>
      </div>
    </div>

  </form>
</x-card>

<x-btn-back route="pedidos.index" />

<x-modal-trash>
  <form method="post" action="{{route('pedidos.destroy', $pedido->id)}}">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i> Apagar Registro</button>
  </form>  
</x-modal-trash>

@endsection
