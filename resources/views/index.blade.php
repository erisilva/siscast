@extends('layouts.app')

@section('title', __('Dashboard'))

@section('content')
<div class="container">
    <div class="row">
        <div class="text-center">
            <h1 class="text-primary">Bem Vindo!</h1>
        </div>    
    </div>
</div>

<div class="container">
    <div class="row py-5">
        <div class="col">
            <div class="text-center">
                <a class="nav-link" href="{{ route('pedidos.index') }}">
                    <i class="bi bi-file-earmark-medical fs-1 text-primary"></i>
                </a>
                <h2 class="py-2">Pedidos</h2>
            </div>
        </div>
    </div>
</div>  
@endsection
