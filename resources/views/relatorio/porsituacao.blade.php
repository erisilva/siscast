@extends('layouts.app')

@section('css-header')
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
@endsection

@section('content')
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item" aria-current="page">
                    <a href="{{ route('pedidos.index') }}">
                        Pedidos
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('relatorio.index') }}">
                        Mais relatórios
                    </a>
                </li>
                <li class="breadcrumb-item active">
                    <a href="{{ route('relatorio.porsituacao') }}">
                        Pedidos Cadastrados por Status (Situação do Pedido) e Período
                    </a>
                </li>
            </ol>
        </nav>
    </div>
    <div class="container py-2">
        <form method="GET" action="{{ route('relatorio.porsituacao') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-3">
                    <label for="dataInicial" class='form-label'>Data Inicial <strong
                            class="text-danger">(*)</strong></label>
                    <input type="text" class="form-control" name="dataInicial" id="dataInicial"
                        value="{{ request()->input('dataInicial') ? request()->input('dataInicial') : now()->subDay(30)->format('d/m/Y') }}">
                </div>
                <div class="col-md-3">
                    <label for="dataFinal" class="form-label">Data Final <strong class="text-danger">(*)</strong></label>
                    <input type="text" class="form-control" name="dataFinal" id="dataFinal"
                        value="{{ request()->input('dataFinal') ? request()->input('dataFinal') : now()->format('d/m/Y') }}">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <x-icon icon='filter' />Filtrar
                    </button>
                </div>
            </div>

        </form>
    </div>
    </div>
    <div class="container">

        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Situação do Pedido</th>
                    <th scope="col">Quantidade</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($porSituacao as $situacao)
                    <tr>
                        <td>{{ $situacao->nome }}</td>
                        <td>{{ $situacao->total }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p class="text-center py-2"> Total de TRs: {{ $counterTr }} </p>
    </div>

    <div class="container bg-warning text-dark">
        <p class="text-center"><strong><i class="bi bi-bar-chart-line"></i> Gráfico</strong></p>
    </div>

    <div class="container">
        <div class="chart-container" style="height:70vh; width:100%">
            <canvas id="porSituacaoChart"></canvas>
        </div>
    </div>

    <div class="container bg-warning text-dark">
        <p class="text-center"><strong><i class="bi bi-file-arrow-down"></i> Exportar</strong></p>
    </div>

    <div class="container py-2 text-center">
        <a href="{{ route('relatorio.porsituacao.xls', [
            'dataInicial' => request()->input('dataInicial')
                ? request()->input('dataInicial')
                : now()->subDay(30)->format('d/m/Y'),
            'dataFinal' => request()->input('dataFinal') ? request()->input('dataFinal') : now()->format('d/m/Y'),
        ]) }}"
            class="btn btn-secondary" role="button">
            <i class="bi bi-file-earmark-spreadsheet-fill"></i> Planilha Excel
        </a>
        <a href="{{ route('relatorio.porsituacao.csv', ['dataInicial' => request()->input('dataInicial') ? request()->input('dataInicial') : now()->subDay(30)->format('d/m/Y'), 'dataFinal' => request()->input('dataFinal') ? request()->input('dataFinal') : now()->format('d/m/Y')]) }}"
            class="btn btn-secondary" role="button"><i class="bi bi-file-earmark-spreadsheet-fill"></i> Planilha CSV</a>
    </div>

    <div class="container py-2 text-right">
        <a href="{{ route('relatorio.index') }}" class="btn btn-primary" role="button"><i class="bi bi-arrow-left"></i>
            Voltar</a>
    </div>
@endsection

@section('script-footer')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/jquery-3.6.4.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('locales/bootstrap-datepicker.pt-BR.min.js') }}"></script>
    <script>
        var porSituacao = {{ Illuminate\Support\Js::from($porSituacao) }};
        var labels = porSituacao.map(function(e) {
            return e.nome;
        });
        var data = porSituacao.map(function(e) {
            return e.total;
        });

        const ctxSituacao = document.getElementById('porSituacaoChart');

        new Chart(ctxSituacao, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total de Pedidos/Situação',
                    data: data,
                    borderWidth: 1,
                    borderRadius: 10
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    },
                    x: {
                        grid: {
                            offset: true
                        }
                    }
                },
                indexAxis: 'y'
            }
        });

        $(document).ready(function() {

            $('#dataInicial').datepicker({
                format: 'dd/mm/yyyy',
                language: 'pt-BR',
                autoclose: true,
                todayHighlight: true,
                toggleActive: true,
                todayBtn: true,
                clearBtn: true,
                endDate: new Date()
            });

            $('#dataFinal').datepicker({
                format: 'dd/mm/yyyy',
                language: 'pt-BR',
                autoclose: true,
                todayHighlight: true,
                toggleActive: true,
                todayBtn: true,
                clearBtn: true,
                endDate: new Date()
            });
        });
    </script>
@endsection
