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

<div class="container">
    <x-flash-message status='success'  message='message' />

    <form method="POST" action="{{ route('situacaos.update', $situacao->id) }}">
    @csrf
    @method('PUT')
    <div class="row g-3">
      <div class="col-md-6">
        <label for="nome" class="form-label">{{ __('Name') }}</label>
        <input type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ old('nome') ?? $situacao->nome }}">
        @error('nome')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror 
      </div>
      <div class="col-md-6">
        <label for="descricao" class="form-label">Descrição</label>
        <input type="text" class="form-control @error('descricao') is-invalid @enderror" name="descricao" value="{{ old('descricao') ?? $situacao->descricao }}">
        @error('descricao')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror 
      </div>
      <div class="col-md-6">
        <label for="cor" class="form-label">Cor do Componente</label>
        <input type="text" class="form-control @error('cor') is-invalid @enderror" name="cor" value="{{ old('cor') ?? $situacao->cor }}">
        @error('cor')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror 
      </div>
      <div class="col-md-6">
        <label for="icone" class="form-label">Ícone do Componente</label>
        <input type="text" class="form-control @error('icone') is-invalid @enderror" name="icone" value="{{ old('icone') ?? $situacao->icone }}">
        @error('icone')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror 
      </div>
      <div class="col-12">
        <button type="submit" class="btn btn-primary">
          <x-icon icon='pencil-square' />{{ __('Edit') }}
        </button> 
      </div>  
    </div>
   </form>
</div>

<x-btn-back route="situacaos.index" />
@endsection
