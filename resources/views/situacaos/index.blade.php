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

  <x-flash-message status='success'  message='message' />

  <x-btn-group label='MenuPrincipal' class="py-1">

    @can('permission-create')
    <a class="btn btn-primary" href="{{ route('situacaos.create') }}" role="button"><x-icon icon='file-earmark'/> {{ __('New') }}</a>
    @endcan
     
    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalFilter"><x-icon icon='funnel'/> {{ __('Filters') }}</button>


  </x-btn-group>
  
  <div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>{{ __('Name') }}</th>
                <th>Descrição</th>
                <th>Cor</th>
                <th>Ícone</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($situacaos as $situacao)
            <tr>
                <td class="text-nowrap">
                  {{ $situacao->nome }}
                </td>

                <td class="text-nowrap">
                  {{ $situacao->descricao }}
                </td>

                <td class="text-nowrap">
                  {{ $situacao->cor }}

                </td>

                <td class="text-nowrap">
                  {{ $situacao->icone }}
                </td>


                <td>
                  <x-btn-group label='Opções'>

                    @can('situacao-edit')
                    <a href="{{route('situacaos.edit', $situacao->id)}}" class="btn btn-primary btn-sm" role="button"><x-icon icon='pencil-square'/></a>
                    @endcan

                    @can('situacao-show')
                    <a href="{{route('situacaos.show', $situacao->id)}}" class="btn btn-info btn-sm" role="button"><x-icon icon='eye'/></a>
                    @endcan

                  </x-btn-group>
                </td>
            </tr>    
            @endforeach                                                 
        </tbody>
    </table>
  </div>
  
  <x-pagination :query="$situacaos" />

</div>

<x-modal-filter class="modal-lg" :perpages="$perpages" icon='funnel' title='Filters'>

  <form method="GET" action="{{ route('situacaos.index') }}">
    
    <div class="mb-3">
      <label for="nome" class="form-label">{{ __('Name') }}</label>
      <input type="text" class="form-control" id="nome" name="nome" value="{{ session()->get('permission_nome') }}">
    </div>
    
    
    <button type="submit" class="btn btn-primary btn-sm"><x-icon icon='search'/> {{ __('Search') }}</button>
    
    <a href="{{ route('situacaos.index', ['nome' => '']) }}" class="btn btn-secondary btn-sm" role="button"><x-icon icon='stars'/> {{ __('Reset') }}</a>

  </form>

</x-modal-filter>  

@endsection
@section('script-footer')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var perpage = document.getElementById('perpage');
    perpage.addEventListener('change', function() {
        perpage = this.options[this.selectedIndex].value;
        window.open("{{ route('situacaos.index') }}" + "?perpage=" + perpage,"_self");
    });
});
</script>
@endsection