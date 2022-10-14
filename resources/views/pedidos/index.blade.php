@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active"><a href="{{ route('pedidos.index') }}">Lista de Pedidos</a></li>
    </ol>
  </nav>

  <x-flash-message />

  <x-btn-group route="pedidos.create">
    <a class="dropdown-item" href="{{route('pedidos.export.xls', ['codigo' => request()->input('codigo'), 'ano' => request()->input('ano'), 'nome' => request()->input('nome'), 'cpf' => request()->input('cpf')])}}"><i class="bi bi-file-earmark-spreadsheet-fill"></i> Exportar Planilha Excel</a>
    <a class="dropdown-item" href="{{route('pedidos.export.csv', ['codigo' => request()->input('codigo'), 'ano' => request()->input('ano'), 'nome' => request()->input('nome'), 'cpf' => request()->input('cpf')])}}"><i class="bi bi-file-earmark-spreadsheet-fill"></i> Exportar Planilha CSV</a>
    <a class="dropdown-item" href="{{route('pedidos.export.pdf', ['codigo' => request()->input('codigo'), 'ano' => request()->input('ano'), 'nome' => request()->input('nome'), 'cpf' => request()->input('cpf')])}}"><i class="bi bi-file-pdf-fill"></i> Exportar PDF</a>
  </x-btn-group>

  <div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col">Cód/Ano</th>
                <th scope="col">Cadastro</th>
                <th scope="col">Status</th>
                <th scope="col">Agenda</th>
                <th scope="col">Solicitante</th>
                <th scope="col">Celular</th>
                <th scope="col">Cidade</th>
                <th scope="col">Nome do Animal</th>
                <th scope="col">Espécie</th>
                <th scope="col">Raça</th>
                <th scope="col">Gênero</th>
                <th scope="col">Porte</th>
                <th scope="col">Idade</th>
                
            </tr>
        </thead>
        <tbody>
            @foreach($pedidos as $pedido)
            <tr>
                <td>
                  <div class="btn-group" role="group">
                    <a href="{{route('pedidos.edit', $pedido)}}" class="btn btn-primary btn-sm" role="button"><i class="bi bi-pencil-square"></i></a>
                    <a href="{{route('pedidos.show', $pedido)}}" class="btn btn-secondary btn-sm" role="button"><i class="bi bi-trash"></i></a>
                </div>
                </td>
                <td class="text-nowrap"><strong>{{$pedido->codigo}}/{{$pedido->ano}}</strong></td>
                <td class="text-nowrap">{{date('d/m/Y', strtotime($pedido->created_at))}}</td>
                <td><strong>{{ $pedido->situacao->nome }}</strong></td>
                <td><strong>{{isset($pedido->agendaQuando) ?  date('d/m/Y', strtotime($pedido->agendaQuando)) : '-'}}</strong></td>
                <td>{{$pedido->nome}}</td>
                <td  class="text-nowrap">{{$pedido->cel}}</td>
                <td>{{$pedido->cidade}}</td>
                <td>{{$pedido->nomeAnimal}}</td>
                <td><strong>{{$pedido->especie_descricao}}</strong></td>
                <td>{{$pedido->raca->descricao}}</td>
                <td>{{$pedido->genero_descricao}}</td>
                <td>{{$pedido->porte_descricao}}</td>
                <td  class="text-nowrap">{{$pedido->idade}} {{($pedido->idadeEm == 'ano') ? 'Ano(s)' : 'Mês(es)'}}</td>
            </tr>    
            @endforeach                                                 
        </tbody>
    </table>
  </div>
  <p class="text-center">Página {{ $pedidos->currentPage() }} de {{ $pedidos->lastPage() }}. Total de registros: {{ $pedidos->total() }}.</p>
  <div class="container-fluid">
      {{ $pedidos->links() }}
  </div>
</div>

<x-modal-filter class="modal-lg" :perpages="$perpages" >
  <form method="GET" action="{{ route('pedidos.index') }}">
    @csrf
    <div class="form-row">
      <div class="for-group col-6">
        <label for="codigo">Código</label>
        <input type="text" class="form-control" id="codigo" name="codigo" value="{{ request()->input('codigo') }}">
      </div>
      <div class="for-group col-6">
        <label for="ano">Ano</label>
        <input type="text" class="form-control" id="ano" name="ano" value="{{ request()->input('ano') }}">
      </div>  
    </div>
    
    <div class="form-row">
      <div class="for-group col-6">
        <label for="nome">Nome</label>
        <input type="text" class="form-control" id="nome" name="nome" value="{{ request()->input('nome') }}">
      </div>
      <div class="for-group col-6">
        <label for="cpf">CPF</label>
        <input type="text" class="form-control" id="cpf" name="cpf" value="{{ request()->input('cpf') }}">
      </div>
    </div>

    <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-search"></i> Pesquisar</button>
    <a href="{{ route('pedidos.index') }}" class="btn btn-primary btn-sm" role="button">Limpar</a>
  </form>
</x-modal-filter>  

@endsection
@section('script-footer')
<script>
$(document).ready(function(){
    $('#perpage').on('change', function() {
        perpage = $(this).find(":selected").val();        
        window.open("{{ route('pedidos.index') }}" + "?perpage=" + perpage,"_self");
    });
});
</script>
@endsection