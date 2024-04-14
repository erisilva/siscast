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
        <form method="POST" action="{{ route('params.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-12">
                    <label for="value">Valor</label>
                    <textarea class="form-control @error('value') is-invalid @enderror" name="value" id="value"
                        rows="3">{{ old('value') ?? '' }}</textarea>
                    @error('value')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary"><x-icon icon='plus-circle' />
                        {{ __('Save') }}</button>
                </div>
            </div>
        </form>
    </div>

    <x-btn-back route="params.index" />
@endsection
