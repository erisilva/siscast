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
  <form method="POST" action="{{ route('situacaos.store') }}">
    @csrf
    <div class="row g-3">
      <div class="col-md-6">
          <label for="nome" class="form-label">{{ __('Name') }}</label>
          <input type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ old('nome') ?? '' }}">
          @error('nome')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror      
      </div>

      <div class="col-md-6">
        <label for="descricao" class="form-label">Descrição</label>
        <input type="text" class="form-control @error('descricao') is-invalid @enderror" name="descricao" value="{{ old('descricao') ?? '' }}">
        @error('descricao')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror      
      </div>

      <div class="col-md-6">
        <label for="cor" class="form-label">Cor do Componente</label>
        <input type="text" class="form-control @error('cor') is-invalid @enderror" name="cor" value="{{ old('cor') ?? '' }}">
        @error('cor')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror      
      </div>

      <div class="col-md-6">
        <label for="icone" class="form-label">Ícone do Componente</label>
        <input type="text" class="form-control @error('icone') is-invalid @enderror" name="icone" value="{{ old('icone') ?? '' }}">
        @error('icone')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="col-12">
        <button type="submit" class="btn btn-primary"><x-icon icon='plus-circle' /> {{ __('Save') }}</button>  
      </div>
    </div>     
  </form>
</div>

<div class="container py-2">
  <div class="card">
    <div class="card-body">
          <div class="text-bg-primary p-3">btn-primary</div>
          <div class="text-bg-secondary p-3">btn-secondary</div>
          <div class="text-bg-success p-3">btn-success</div>
          <div class="text-bg-danger p-3">btn-danger</div>
          <div class="text-bg-warning p-3">btn-warning</div>
          <div class="text-bg-info p-3">btn-info</div>
          <div class="text-bg-light p-3">btn-light</div>
          <div class="text-bg-dark p-3">btn-dark</div>
    </div>
  </div>
</div>

<x-btn-back route="situacaos.index" />
@endsection
