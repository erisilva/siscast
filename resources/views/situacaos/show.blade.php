@extends('layouts.app')

@section('title', 'Situações do Pedido')

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="{{ route('situacaos.index') }}">
          Situações do Pedido
        </a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
        {{ __('Show') }}
      </li>
    </ol>
  </nav>
</div>

<x-card title="Raça">
  <ul class="list-group list-group-flush">
    <li class="list-group-item">
      {{ __('Name') . ' : ' . $situacao->nome }}
    </li>
    <li class="list-group-item">
      {{  'Descrição : ' . $situacao->descricao }}
    </li>
    <li class="list-group-item">
      {{  'Cor : ' . $situacao->cor }}
    </li>
    <li class="list-group-item">
      {{  'Ícone : ' . $situacao->icone }}
    </li>
  </ul>
</x-card>

@can('situacao-delete')
<x-btn-trash />
@endcan

<x-btn-back route="situacaos.index" />

@can('situacao-delete')
<x-modal-trash class="modal-sm">
  <form method="post" action="{{route('situacaos.destroy', $situacao->id)}}">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">
      <x-icon icon='trash' /> {{ __('Delete this record?') }}
    </button>
  </form>
</x-modal-trash>
@endcan

@endsection
