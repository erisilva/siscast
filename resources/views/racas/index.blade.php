@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active"><a href="{{ route('racas.index') }}">Lista de Raças</a></li>
    </ol>
  </nav>

  <x-flash-message />

  <x-btn-group route="racas.create">

    <a class="dropdown-item" href="{{route('racas.export.xls')}}"><i class="bi bi-file-earmark-spreadsheet-fill"></i> Exportar Planilha Excel</a>
    <a class="dropdown-item" href="{{route('racas.export.csv')}}"><i class="bi bi-file-earmark-spreadsheet-fill"></i> Exportar Planilha CSV</a>
    <a class="dropdown-item" href="{{route('racas.export.pdf')}}"><i class="bi bi-file-pdf-fill"></i> Exportar PDF</a>

  </x-btn-group>

  <div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Descrição</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($racas as $raca)
            <tr>
                <td>{{$raca->descricao}}</td>
                <td>
                  <div class="btn-group" role="group">
                    <a href="{{route('racas.edit', $raca)}}" class="btn btn-primary btn-sm" role="button"><i class="bi bi-pencil-square"></i></a>
                    <a href="{{route('racas.show', $raca)}}" class="btn btn-secondary btn-sm" role="button"><i class="bi bi-trash"></i></a>
                 </div>
                </td>
            </tr>    
            @endforeach                                                 
        </tbody>
    </table>
  </div>
  <p class="text-center">Página {{ $racas->currentPage() }} de {{ $racas->lastPage() }}. Total de registros: {{ $racas->total() }}.</p>
  <div class="container-fluid">
      {{ $racas->links() }}
  </div>
</div>

<x-modal-filter :perpages="$perpages" />

@endsection
@section('script-footer')
<script>
$(document).ready(function(){
    $('#perpage').on('change', function() {
        perpage = $(this).find(":selected").val();        
        window.open("{{ route('racas.index') }}" + "?perpage=" + perpage,"_self");
    });
});
</script>
@endsection