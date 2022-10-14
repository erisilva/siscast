@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('situacaos.index') }}">Lista de Situações dos Pedidos</a></li>
      <li class="breadcrumb-item active" aria-current="page">Novo Registro</li>
    </ol>
  </nav>
</div>
<div class="container">
  <form method="POST" action="{{ route('situacaos.store') }}">
    @csrf
    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="nome">Nome</label>
        <input type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ old('descricao') ?? '' }}">
        @error('nome')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
      <div class="form-group col-md-6">
        <label for="descricao">Descrição</label>
        <input type="text" class="form-control @error('descricao') is-invalid @enderror" name="descricao" value="{{ old('descricao') ?? '' }}">
        @error('descricao')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="icone">Ícone</label>
        <input type="text" class="form-control @error('icone') is-invalid @enderror" name="icone" value="{{ old('icone') ?? '' }}">
        @error('icone')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
      <div class="form-group col-md-6">
        <label for="cor">Cor</label>
        <input type="text" class="form-control @error('cor') is-invalid @enderror" name="cor" value="{{ old('cor') ?? '' }}">
        @error('cor')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
    </div>
    
    <button type="submit" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Incluir Situação</button>
  </form>
</div>

<div class="container py-2">
  <p>Links</p>
  <p><a href="https://icons.getbootstrap.com/" target="_blank">Icones</a></p>
  <p><a href="https://getbootstrap.com/docs/4.6/components/buttons/" target="_blank">Cores</a></p>
</div>

<x-btn-back route="situacaos.index" />
@endsection
