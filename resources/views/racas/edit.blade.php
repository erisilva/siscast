@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('racas.index') }}">Lista de Raças</a></li>
      <li class="breadcrumb-item active" aria-current="page">Alterar Registro</li>
    </ol>
  </nav>
</div>
<div class="container">
  
  <x-flash-message />
  
  <form method="POST" action="{{ route('racas.update', $raca) }}">
    @csrf
    @method('PUT')
    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="descricao">Descrição</label>
        <input type="text" class="form-control @error('descricao') is-invalid @enderror" name="descricao" value="{{ old('descricao') ?? $raca->descricao }}">
        @error('descricao')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
    </div>  
    <button type="submit" class="btn btn-primary"><i class="bi bi-pencil-square"></i> Alterar Dados da Raça</button>
  </form>
</div>

<x-btn-back route="racas.index" />
@endsection
