@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active"><a href="{{ route('situacaos.index') }}">Lista de Situações dos Pedidos</a></li>
    </ol>
  </nav>

  <x-flash-message />

  <x-btn-group route="situacaos.create">

    <a class="dropdown-item" href="{{route('situacaos.export.xls')}}"><i class="bi bi-file-earmark-spreadsheet-fill"></i> Exportar Planilha Excel</a>
    <a class="dropdown-item" href="{{route('situacaos.export.csv')}}"><i class="bi bi-file-earmark-spreadsheet-fill"></i> Exportar Planilha CSV</a>
    <a class="dropdown-item" href="{{route('situacaos.export.pdf')}}"><i class="bi bi-file-pdf-fill"></i> Exportar PDF</a>

  </x-btn-group>

  <div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Nome</th>
                <th scope="col">Descrição</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($situacaos as $situacao)
            <tr>
                <td>{{$situacao->nome}}</td>
                <td>{{$situacao->descricao}}</td>
                <td>
                  <div class="btn-group" role="group">
                    <a href="{{route('situacaos.edit', $situacao)}}" class="btn btn-primary btn-sm" role="button"><i class="bi bi-pencil-square"></i></a>
                    <a href="{{route('situacaos.show', $situacao)}}" class="btn btn-secondary btn-sm" role="button"><i class="bi bi-trash"></i></a>
                 </div>
                </td>
            </tr>    
            @endforeach                                                 
        </tbody>
    </table>
  </div>
  <p class="text-center">Página {{ $situacaos->currentPage() }} de {{ $situacaos->lastPage() }}. Total de registros: {{ $situacaos->total() }}.</p>
  <div class="container-fluid">
      {{ $situacaos->links() }}
  </div>
</div>

<x-modal-filter :perpages="$perpages" />

@endsection
@section('script-footer')
<script>
$(document).ready(function(){
    $('#perpage').on('change', function() {
        perpage = $(this).find(":selected").val();        
        window.open("{{ route('situacaos.index') }}" + "?perpage=" + perpage,"_self");
    });
});
</script>
@endsection