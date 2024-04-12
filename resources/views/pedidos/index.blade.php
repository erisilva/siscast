@extends('layouts.app')

@section('title', 'Pedidos')

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
            </ol>
        </nav>

        <x-flash-message status='success' message='message' />

        <x-btn-group label='MenuPrincipal' class="py-1">

            @can('pedido-create')
                <a class="btn btn-primary" href="{{ route('pedidos.create') }}" role="button"><x-icon icon='file-earmark' />
                    {{ __('New') }}</a>
            @endcan

            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalFilter"><x-icon
                    icon='funnel' /> {{ __('Filters') }}
            </button>

            @can('pedido-export')
                <x-dropdown-menu title='Reports' icon='printer'>

                    <li>
                        <a class="dropdown-item"
                            href="{{ route('pedidos.export.xls', ['codigo' => request()->input('codigo'),'ano' => request()->input('ano'),'situacao_id' => request()->input('situacao_id'),'dataAgendaInicio' => request()->input('dataAgendaInicio'),'dataAgendaFim' => request()->input('dataAgendaFim'),'nome' => request()->input('nome'),'cpf' => request()->input('cpf'),'nomeAnimal' => request()->input('nomeAnimal'),'especie' => request()->input('especie'),'genero' => request()->input('genero'),'porte' => request()->input('porte'),'idadeMinima' => request()->input('idadeMinima'),'idadeMaxima' => request()->input('idadeMaxima'),'idadeEm' => request()->input('IdadeEm'),'procedencia' => request()->input('procedencia'),'dataCadastroInicio' => request()->input('dataCadastroInicio'),'dataCadastroFim' => request()->input('dataCadastroFim'),'raca_id' => request()->input('raca_id')]) }}"><x-icon
                                icon='file-earmark-spreadsheet-fill' /> {{ __('Export') . ' XLS' }}</a>
                    </li>
                    <li>
                        <a class="dropdown-item"
                            href="{{ route('pedidos.export.csv', ['codigo' => request()->input('codigo'),'ano' => request()->input('ano'),'situacao_id' => request()->input('situacao_id'),'dataAgendaInicio' => request()->input('dataAgendaInicio'),'dataAgendaFim' => request()->input('dataAgendaFim'),'nome' => request()->input('nome'),'cpf' => request()->input('cpf'),'nomeAnimal' => request()->input('nomeAnimal'),'especie' => request()->input('especie'),'genero' => request()->input('genero'),'porte' => request()->input('porte'),'idadeMinima' => request()->input('idadeMinima'),'idadeMaxima' => request()->input('idadeMaxima'),'idadeEm' => request()->input('IdadeEm'),'procedencia' => request()->input('procedencia'),'dataCadastroInicio' => request()->input('dataCadastroInicio'),'dataCadastroFim' => request()->input('dataCadastroFim'),'raca_id' => request()->input('raca_id')]) }}"><x-icon
                                icon='file-earmark-spreadsheet-fill' /> {{ __('Export') . ' CSV' }}</a>
                    </li>
                    <li>
                        <a class="dropdown-item"
                            href="{{ route('pedidos.export.pdf', ['codigo' => request()->input('codigo'),'ano' => request()->input('ano'),'situacao_id' => request()->input('situacao_id'),'dataAgendaInicio' => request()->input('dataAgendaInicio'),'dataAgendaFim' => request()->input('dataAgendaFim'),'nome' => request()->input('nome'),'cpf' => request()->input('cpf'),'nomeAnimal' => request()->input('nomeAnimal'),'especie' => request()->input('especie'),'genero' => request()->input('genero'),'porte' => request()->input('porte'),'idadeMinima' => request()->input('idadeMinima'),'idadeMaxima' => request()->input('idadeMaxima'),'idadeEm' => request()->input('IdadeEm'),'procedencia' => request()->input('procedencia'),'dataCadastroInicio' => request()->input('dataCadastroInicio'),'dataCadastroFim' => request()->input('dataCadastroFim'),'raca_id' => request()->input('raca_id')]) }}"><x-icon
                                icon='file-pdf-fill' /> {{ __('Export') . ' PDF' }}</a>
                    </li>

                </x-dropdown-menu>
            @endcan

        </x-btn-group>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Cod.</th>
                        <th scope="col">Ano</th>
                        <th scope="col">Data Pedido</th>
                        <th scope="col">Situação</th>
                        <th scope="col">Agendado em</th>
                        <th scope="col">Nome</th>
                        <th scope="col">CPF</th>
                        <th scope="col">Nome do Animal</th>
                        <th scope="col">Espécie</th>
                        <th scope="col">Raça</th>
                        <th scope="col">Sexo</th>
                        <th scope="col">Porte</th>
                        <th scope="col">Idade</th>
                        <th scope="col">Origem</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pedidos as $pedido)
                        <tr>
                            <td class="text-nowrap">
                                {{ $pedido->codigo }}
                            </td>

                            <td class="text-nowrap">
                                {{ $pedido->ano }}
                            </td>

                            <td class="text-nowrap">
                                {{ date('d/m/Y', strtotime($pedido->created_at)) }}
                            </td>

                            <td>
                                <h5><span class="badge text-bg-{{ $pedido->situacao->cor }}"><x-icon
                                            icon='{{ $pedido->situacao->icone }}' /> {{ $pedido->situacao->nome }}</span>
                                </h5>
                            </td>

                            <td>
                                {{ $pedido->agendaQuando ? date('d/m/Y', strtotime($pedido->agendaQuando)) : '-' }}
                            </td>

                            <td>
                                {{ $pedido->nome }}
                            </td>

                            <td>
                                {{ Str::substr($pedido->cpf, 0, 3) . '.' . Str::substr($pedido->cpf, 3, 3) . '.' . Str::substr($pedido->cpf, 6, 3) . '-' . Str::substr($pedido->cpf, 9, 2) }}
                            </td>

                            <td>
                                {{ $pedido->nomeAnimal }}
                            </td>

                            <td>
                                {{ $pedido->especie == 'canino' ? 'Canino' : 'Felino' }}
                            </td>

                            <td>
                                {{ $pedido->raca->nome }}
                            </td>

                            <td>
                                {{ $pedido->genero == 'M' ? 'Macho' : 'Fêmea' }}
                            </td>

                            <td>
                                {{ $pedido->porte == 'pequeno' ? 'Pequeno' : ($pedido->porte == 'medio' ? 'Médio' : 'Grande') }}
                            </td>

                            <td>
                                {{ $pedido->idade . ' ' . ($pedido->idadeEm == 'mes' ? 'Mes(es)' : 'Ano(s)') }}
                            </td>

                            <td>
                                {{ $pedido->procedencia }}
                            </td>

                            <td class="text-nowrap">

                                <x-btn-group label='Opções'>

                                    @can('pedido-edit')
                                        <a href="{{ route('pedidos.edit', $pedido->id) }}" class="btn btn-primary btn-sm"
                                            role="button"><x-icon icon='pencil-square' /></a>
                                    @endcan

                                    @can('pedido-show')
                                        <a href="{{ route('pedidos.show', $pedido->id) }}" class="btn btn-info btn-sm"
                                            role="button"><x-icon icon='eye' /></a>
                                    @endcan

                                </x-btn-group>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <x-pagination :query="$pedidos" />

    </div>

    <x-modal-filter class="modal-xl" :perpages="$perpages" icon='funnel' title='Filters'>

        <div class="container">
            <form method="GET" action="{{ route('pedidos.index') }}">
                <div class="row g-3">
                    <div class="col-md-2">
                        <label for="codigo" class="form-label">Código</label>
                        <input type="text" class="form-control" id="codigo" name="codigo"
                            value="{{ session()->get('pedido_codigo') }}">
                    </div>

                    <div class="col-md-2">
                        <label for="ano" class="form-label">Ano</label>
                        <input type="text" class="form-control" id="ano" name="ano"
                            value="{{ session()->get('pedido_ano') }}">
                    </div>

                    <div class="col-md-4">
                        <label for="situacao_id" class="form-label">Situação do Pedido</label>
                        <select class="form-select" id="situacao_id" name="situacao_id">
                            <option value="" selected="true">Mostrar Todos ...</option>
                            @foreach ($situacaos as $situacao)
                                <option value="{{ $situacao->id }}" @selected(session()->get('pedido_situacao_id') == $situacao->id)>
                                    {{ $situacao->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label for="dataAgendaInicio" class="form-label">Data Agenda Início</label>
                        <input type="text" class="form-control" id="dataAgendaInicio" name="dataAgendaInicio"
                            value="{{ session()->get('pedido_dataAgendaInicio') }}">
                    </div>

                    <div class="col-md-2">
                        <label for="dataAgendaFim" class="form-label">Data Agenda Fim</label>
                        <input type="text" class="form-control" id="dataAgendaFim" name="dataAgendaFim"
                            value="{{ session()->get('pedido_dataAgendaFim') }}">
                    </div>

                    <div class="col-md-4">
                        <label for="nome" class="form-label">Nome do Tutor</label>
                        <input type="text" class="form-control" id="nome" name="nome"
                            value="{{ session()->get('pedido_nome') }}">
                    </div>

                    <div class="col-md-2">
                        <label for="cpf" class="form-label">CPF</label>
                        <input type="text" class="form-control" id="cpf" name="cpf"
                            value="{{ session()->get('pedido_cpf') }}">
                    </div>

                    <div class="col-md-4">
                        <label for="nomeAnimal" class="form-label">Nome do Animal</label>
                        <input type="text" class="form-control" id="nomeAnimal" name="nomeAnimal"
                            value="{{ session()->get('pedido_nomeAnimal') }}">
                    </div>

                    <div class="col-md-2">
                        <label for="especie" class="form-label">Espécie </label>
                        <select class="form-select" id="especie" name="especie">
                            <option value="" selected="true">Mostrar Todos ...</option>
                            <option value="felino" @selected(session()->get('pedido_especie') == 'felino')>Felino</option>
                            <option value="canino" @selected(session()->get('pedido_especie') == 'canino')>Canino</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label for="raca_id" class="form-label">Raça</label>
                        <select class="form-select" id="raca_id" name="raca_id">
                            <option value="" selected="true">Mostrar Todos ...</option>
                            @foreach ($racas as $raca)
                                <option value="{{ $raca->id }}" @selected(session()->get('pedido_raca_id') == $raca->id)>
                                    {{ $raca->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label for="genero" class="form-label">Sexo </label>
                        <select class="form-select" id="genero" name="genero">
                            <option value="" selected="true">Mostrar Todos ...</option>
                            <option value="M" @selected(session()->get('pedido_genero') == 'M')>Macho</option>
                            <option value="F" @selected(session()->get('pedido_genero') == 'F')>Fêmea</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label for="porte" class="form-label">Porte </label>
                        <select class="form-select" id="genero" name="porte">
                            <option value="" selected="true">Mostrar Todos ...</option>
                            <option value="pequeno" @selected(session()->get('pedido_porte') == 'pequeno')>Pequeno</option>
                            <option value="medio" @selected(session()->get('pedido_porte') == 'medio')>Médio</option>
                            <option value="grande" @selected(session()->get('pedido_porte') == 'grande')>Grande</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label for="idadeMinima" class="form-label">Idade Mínima</label>
                        <input type="number" class="form-control" id="idadeMinima" name="idadeMinima"
                            value="{{ session()->get('pedido_idadeMinima') }}">
                    </div>

                    <div class="col-md-2">
                        <label for="idadeMaxima" class="form-label">Idade Máxima</label>
                        <input type="number" class="form-control" id="idadeMaxima" name="idadeMaxima"
                            value="{{ session()->get('pedido_idadeMaxima') }}">
                    </div>

                    <div class="col-md-2">
                        <label for="idadeEm" class="form-label">Idade em </label>
                        <select class="form-select" id="idadeEm" name="idadeEm">
                            <option value="" selected="true">Mostrar Todos ...</option>
                            <option value="mes" @selected(session()->get('pedido_idadeEm') == 'mes')>Meses</option>
                            <option value="ano" @selected(session()->get('pedido_idadeEm') == 'ano')>Anos</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="procedencia" class="form-label">Origem</label>
                        <input type="text" class="form-control" id="procedencia" name="procedencia"
                            value="{{ session()->get('pedido_procedencia') }}">
                    </div>

                    <div class="col-md-2">
                        <label for="dataCadastroInicio" class="form-label">Data Cadastro Início</label>
                        <input type="text" class="form-control" id="dataCadastroInicio" name="dataCadastroInicio"
                            value="{{ session()->get('pedido_dataCadastroInicio') }}">
                    </div>

                    <div class="col-md-2">
                        <label for="dataCadastroFim" class="form-label">Data Cadastro Início</label>
                        <input type="text" class="form-control" id="dataCadastroFim" name="dataCadastroFim"
                            value="{{ session()->get('pedido_dataCadastroFim') }}">
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-sm"><x-icon icon='search' />
                            {{ __('Search') }}</button>

                        {{-- Reset the Filter --}}
                        <a href="{{ route('pedidos.index', ['codigo' => '', 'ano' => '', 'situacao_id' => '', 'dataAgendaInicio' => '', 'dataAgendaFim' => '', 'nome' => '', 'cpf' => '', 'nomeAnimal' => '', 'especie' => '', 'raca_id' => '', 'genero' => '', 'porte' => '', 'idadeMinima' => '', 'idadeMaxima' => '', 'idadeEm' => '', 'procedencia' => '', 'dataCadastroInicio' => '', 'dataCadastroFim' => '']) }}"
                            class="btn btn-secondary btn-sm" role="button"><x-icon icon='stars' />
                            {{ __('Reset') }}</a>
                    </div>
                </div>
            </form>
        </div>

    </x-modal-filter>

@endsection
@section('script-footer')
@section('script-footer')
    <script src="{{ asset('js/jquery-3.6.4.min.js') }}"></script>
    <script src="{{ asset('js/jquery.inputmask.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('locales/bootstrap-datepicker.pt-BR.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            $("#cpf").inputmask({
                "mask": "999.999.999-99"
            });

            $('#dataAgendaInicio').datepicker({
                format: "dd/mm/yyyy",
                todayBtn: "linked",
                clearBtn: true,
                language: "pt-BR",
                autoclose: true,
                todayHighlight: true
            });

            $('#dataAgendaFim').datepicker({
                format: "dd/mm/yyyy",
                todayBtn: "linked",
                clearBtn: true,
                language: "pt-BR",
                autoclose: true,
                todayHighlight: true
            });

            $('#dataCadastroFim').datepicker({
                format: "dd/mm/yyyy",
                todayBtn: "linked",
                clearBtn: true,
                language: "pt-BR",
                autoclose: true,
                todayHighlight: true
            });

            $('#dataCadastroInicio').datepicker({
                format: "dd/mm/yyyy",
                todayBtn: "linked",
                clearBtn: true,
                language: "pt-BR",
                autoclose: true,
                todayHighlight: true
            });

        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var perpage = document.getElementById('perpage');
            perpage.addEventListener('change', function() {
                perpage = this.options[this.selectedIndex].value;
                window.open("{{ route('pedidos.index') }}" + "?perpage=" + perpage, "_self");
            });
        });
    </script>
@endsection
