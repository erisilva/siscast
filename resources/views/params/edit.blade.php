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
    </div>

    <div class="container">
        <x-flash-message status='success' message='message' />

        <form method="POST" action="{{ route('params.update', $param->id) }}">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-12">
                    <label for="value">Valor</label>
                    <textarea class="form-control @error('value') is-invalid @enderror" name="value" id="value"
                        rows="3">{{ old('value') ?? $param->value }}</textarea>
                    @error('value')
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

    <x-btn-back route="params.index" />
@endsection
