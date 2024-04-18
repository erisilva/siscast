@extends('layouts.app')

@section('title', 'Pedidos')

@section('content')
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('pedidos.index') }}">
                        Pedidos
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ __('Show') }}
                </li>
            </ol>
        </nav>
    </div>

    <div class="container">
        <form action="#" method="post">


            <div class="row g-3">

                <div class="col-md-2">
                    <label for="codigo" class="form-label">Cód.</label>
                    <input type="text" class="form-control" name="codigo" id="codigo" value="{{ $pedido->codigo }}"
                        maxlength="180" readonly disabled>
                </div>

                <div class="col-md-2">
                    <label for="ano" class="form-label">Ano</label>
                    <input type="text" class="form-control" name="ano" id="ano" value="{{ $pedido->ano }}"
                        maxlength="180" readonly disabled>
                </div>

                <div class="col-md-2">
                    <label for="datacadastro" class="form-label">Data</label>
                    <input type="text" class="form-control" name="datacadastro" id="datacadastro" value="{{ date('d/m/Y', strtotime($pedido->created_at)) }}"
                        maxlength="180" readonly disabled>
                </div>

                <div class="col-md-2">
                    <label for="horacadastro" class="form-label">Hora</label>
                    <input type="text" class="form-control" name="horacadastro" id="horacadastro" value="{{ date('h:m', strtotime($pedido->created_at)) }}"
                        maxlength="180" readonly disabled>
                </div>

                <div class="col-md-4">
                    <label for="situacao" class="form-label">Situação</label>
                    <input type="text" class="form-control" name="situacao" id="situacao" value="{{ $pedido->situacao->nome }}"
                        maxlength="180" readonly disabled>
                </div>

                <div class="col-md-5">
                    <label for="nome" class="form-label">{{ __('Name') }}</label>
                    <input type="text" class="form-control" name="nome" id="nome" value="{{ $pedido->nome }}"
                        maxlength="180" readonly disabled>
                </div>

                <div class="col-md-2">
                    <label for="nascimento" class="form-label">Nascimento</label>
                    <input type="text" class="form-control" name="nascimento" id='nascimento'
                        value="{{ date('d/m/Y', strtotime($pedido->nascimento)) }}" readonly disabled>
                </div>

                <div class="col-md-2">
                    <label for="cpf" class="form-label">CPF</label>
                    <input type="text" class="form-control" name="cpf" id="cpf" value="{{ $pedido->cpf }}"
                        readonly disabled>
                </div>

                <div class="col-md-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="text" class="form-control" name="email" id="email" value="{{ $pedido->email }}"
                        readonly disabled>
                </div>

                <div class="col-md-2">
                    <label for="cel" class="form-label">Celular</label>
                    <input type="text" class="form-control" name="cel" id="cel" value="{{ $pedido->cel }}"
                        maxlength="20" readonly disabled>
                </div>

                <div class="col-md-2">
                    <label for="tel" class="form-label">Telefone</label>
                    <input type="text" class="form-control" name="tel" id="tel" value="{{ $pedido->tel }}"
                        maxlength="20" readonly disabled>
                </div>

                <div class="col-md-2">
                    <label for="cep" class="form-label">CEP</label>
                    <input type="text" class="form-control" name="cep" id="cep" value="{{ $pedido->cep }}"
                        readonly disabled>
                </div>

                <div class="col-md-4">
                    <label for="logradouro" class="form-label">Logradouro</label>
                    <input type="text" class="form-control" name="logradouro" id="logradouro"
                        value="{{ $pedido->logradouro }}" maxlength="100" readonly disabled>
                </div>

                <div class="col-md-2">
                    <label for="numero" class="form-label">Número</label>
                    <input type="text" class="form-control" name="numero" id="numero" value="{{ $pedido->numero }}"
                        maxlength="10" readonly disabled>
                </div>

                <div class="col-md-4">
                    <label for="complemento" class="form-label">Complemento<strong
                            class="text-info">(Opcional)</strong></label>
                    <input type="text" class="form-control" name="complemento" id="complemento"
                        value="{{ $pedido->complemento }}" maxlength="100" readonly disabled>
                </div>

                <div class="col-md-3">
                    <label for="bairro" class="form-label">Bairro</label>
                    <input type="text" class="form-control" name="bairro" id="bairro"
                        value="{{ $pedido->bairro }}" maxlength="80" readonly disabled>
                </div>

                <div class="col-md-3">
                    <label for="cidade" class="form-label">Cidade</label>
                    <input type="text" class="form-control" name="cidade" id="cidade"
                        value="{{ $pedido->cidade }}" maxlength="80" readonly disabled>
                </div>

                <div class="col-md-2">
                    <label for="uf" class="form-label">UF</label>
                    <input type="text" class="form-control" name="uf" id="uf"
                        value="{{ $pedido->uf }}" maxlength="2" readonly disabled>
                </div>

                <div class="col-md-3">
                    <label for="cns" class="form-label">Cartão Nacional de Saúde</label>
                    <input type="text" class="form-control" name="cns" value="{{ $pedido->cns }}"
                        id="cns" maxlength="15" readonly disabled>
                </div>

                <div class="col-md-2">
                    <label for="beneficio" class="form-label">Possui benefício?</label>
                    <input type="text" class="form-control" name="beneficio" value="{{ $pedido->beneficio }}"
                        id="beneficio" maxlength="2" readonly disabled>
                </div>

                <div class="col-md-7">
                    <label for="beneficioQual" class="form-label">Se sim, qual(is)?</label>
                    <input type="text" class="form-control" name="beneficioQual" id="beneficioQual"
                        value="{{ $pedido->beneficioQual }}" maxlength="100" readonly disabled>
                </div>

                <div class="co-12">
                    <p class="text-center bg-primary text-white">
                        <strong>Informações do Animal</strong>
                    </p>
                </div>

                <div class="col-md-3">
                    <label for="nomeAnimal" class="form-label">Nome do Animal</label>
                    <input type="text" class="form-control" name="nomeAnimal" id="nomeAnimal"
                        value="{{ $pedido->nomeAnimal }}" maxlength="100" readonly disabled>
                </div>

                <div class="col-md-2">
                    <label for="genero" class="form-label">Sexo</label>
                    <input type="text" class="form-control" name="genero" id="genero"
                        value="{{ $pedido->genero }}" maxlength="10" readonly disabled>
                </div>

                <div class="col-md-2">
                    <label for="porte" class="form-label">Porte</label>
                    <input type="text" class="form-control" name="porte" id="porte"
                        value="{{ $pedido->porte }}" maxlength="10" readonly disabled>
                </div>

                <div class="col-md-3">
                    <label for="idade" class="form-label">Idade do Animal
                    </label>
                    <input type="number" class="form-control" name="idade" id="idade"
                        value="{{ $pedido->idade }}" readonly disabled>
                </div>

                <div class="col-md-2">
                    <label for="idadeEm" class="form-label">Idade em</label>
                    <input type="text" class="form-control" name="idadeEm" id="idadeEm"
                        value="{{ $pedido->idadeEm }}" maxlength="10" readonly disabled>
                </div>

                <div class="col-md-3">
                    <label for="cor" class="form-label">Cor(es) do Animal</label>
                    <input type="text" class="form-control" name="cor" id="cor"
                        value="{{ $pedido->cor }}" maxlength="80" readonly disabled>
                </div>

                <div class="col-md-3">
                    <label for="especie" class="form-label">Espécie</label>
                    <input type="text" class="form-control" name="especie" id="especie"
                        value="{{ $pedido->especie }}" maxlength="100" readonly disabled>
                </div>

                <div class="col-md-3">
                    <label for="raca" class="form-label">Raça</label>
                    <input type="text" class="form-control" name="raca" id="raca"
                        value="{{ $pedido->raca->nome }}" maxlength="150" readonly disabled>
                </div>

                <div class="col-md-3">
                    <label for="procedencia" class="form-label">Origem</label>
                    <input type="text" class="form-control" name="procedencia" id="procedencia"
                        value="{{ $pedido->procedencia }}" maxlength="150" readonly disabled>
                </div>

                <div class="co-12">
                    <p class="text-center bg-primary text-white">
                        <strong>Agendamento</strong>
                    </p>
                </div>

                <div class="col-md-4">
                    <label for="primeiraTentativa" class="form-label">Primeira Tentativa </label>
                    <input type="text" class="form-control" name="primeiraTentativa" id="primeiraTentativa"
                        value="{{ $pedido->primeiraTentativa }}" maxlength="150" readonly disabled>
                </div>

                <div class="col-md-4">
                    <label for="primeiraTentativaQuando" class="form-label">Data</label>
                    <input type="text" class="form-control" name="primeiraTentativaQuando"
                        id="primeiraTentativaQuando" value="{{ isset($pedido->primeiraTentativaQuando) ? date('d/m/Y', strtotime($pedido->primeiraTentativaQuando)) : '' }}" readonly disabled>
                </div>

                <div class="col-md-4">
                    <label for="primeiraTentativaHora" class="form-label">Hora</label>
                    <input type="text" class="form-control" name="primeiraTentativaHora" id="primeiraTentativaHora"
                        value="{{ $pedido->primeiraTentativaHora }}" maxlength="5" readonly disabled>
                </div>

                <div class="col-md-4">
                    <label for="segundaTentativa" class="form-label">Segunda Tentativa </label>
                    <input type="text" class="form-control" name="segundaTentativa" id="segundaTentativa"
                        value="{{ $pedido->segundaTentativa }}" maxlength="150" readonly disabled>
                </div>

                <div class="col-md-4">
                    <label for="segundaTentativaQuando" class="form-label">Data</label>
                    <input type="text" class="form-control" name="segundaTentativaQuando" id="segundaTentativaQuando"
                        value="{{ isset($pedido->segundaTentativaQuando) ? date('d/m/Y', strtotime($pedido->segundaTentativaQuando)) : '' }}" readonly disabled>
                </div>

                <div class="col-md-4">
                    <label for="segundaTentativaHora" class="form-label">Hora</label>
                    <input type="text" class="form-control" name="segundaTentativaHora" id="segundaTentativaHora"
                        value="{{ $pedido->segundaTentativaHora }}" maxlength="5" readonly disabled>
                </div>

                <div class="col-12">
                    <label for="nota">Notas</label>
                    <textarea class="form-control" name="nota" id="nota" rows="3" readonly disabled>{{ $pedido->nota }}</textarea>
                </div>

                <div class="col-md-4">
                    <label for="agendaQuando" class="form-label">Data do Agendamento</label>
                    <input type="text" class="form-control" name="agendaQuando" id="agendaQuando"
                        value="{{ isset($pedido->agendaQuando) ? date('d/m/Y', strtotime($pedido->agendaQuando)) : '' }}" readonly disabled>
                </div>

                <div class="col-md-4">
                    <label for="agendaTurno" class="form-label">Turno</label>
                    <input type="text" class="form-control" name="agendaTurno" id="agendaTurno"
                        value="{{ $pedido->agendaTurno }}" maxlength="80" readonly disabled>
                </div>

                <div class="col-12">
                    <label for="motivoNaoAgendado">Motivo do não agendamento</label>
                    <textarea class="form-control" name="motivoNaoAgendado" id="motivoNaoAgendado" rows="3" readonly disabled>{{ $pedido->motivoNaoAgendado }}</textarea>
                </div>

        </form>

    </div>




    @can('pedido-delete')
        <x-btn-trash />
    @endcan

    <x-btn-back route="pedidos.index" />

    @can('pedido-delete')
        <x-modal-trash class="modal-sm">
            <form method="post" action="{{ route('pedidos.destroy', $pedido->id) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <x-icon icon='trash' /> {{ __('Delete this record?') }}
                </button>
            </form>
        </x-modal-trash>
    @endcan

@endsection
