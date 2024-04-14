@extends('layouts.app')

@section('title', 'Raças')

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="{{ route('params.index') }}">
          Parâmetros
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
    <a class="btn btn-primary" href="{{ route('params.create') }}" role="button"><x-icon icon='file-earmark'/> {{ __('New') }}</a>
    @endcan
     
    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalFilter"><x-icon icon='funnel'/> {{ __('Filters') }}</button>

  </x-btn-group>
  
  <div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Value</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($params as $param)
            <tr>
                <td class="text-nowrap">
                  {{$param->id}}
                </td>
                <td>
                  {{$param->value}}
                </td>
                <td>
                  <x-btn-group label='Opções'>

                    @can('param-edit')
                    <a href="{{route('params.edit', $param->id)}}" class="btn btn-primary btn-sm" role="button"><x-icon icon='pencil-square'/></a>
                    @endcan

                    @can('param-show')
                    <a href="{{route('params.show', $param->id)}}" class="btn btn-info btn-sm" role="button"><x-icon icon='eye'/></a>
                    @endcan

                  </x-btn-group>
                </td>
            </tr>    
            @endforeach                                                 
        </tbody>
    </table>
  </div>
  
  <x-pagination :query="$params" />

</div>

<x-modal-filter class="modal-lg" :perpages="$perpages" icon='funnel' title='Filters'>
</x-modal-filter>  

@endsection
@section('script-footer')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var perpage = document.getElementById('perpage');
    perpage.addEventListener('change', function() {
        perpage = this.options[this.selectedIndex].value;
        window.open("{{ route('params.index') }}" + "?perpage=" + perpage,"_self");
    });
});
</script>
@endsection