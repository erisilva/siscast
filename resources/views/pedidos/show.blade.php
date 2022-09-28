@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('pedidos.index') }}">Lista de Pedidos</a></li>
      <li class="breadcrumb-item active" aria-current="page">Exibir Registro</li>
    </ol>
  </nav>
</div>

<x-card title="Pedido Nº {{ $pedido->codigo }}/{{ $pedido->ano }} - {{ $pedido->situacao->descricao }}">
  <form>
    <div class="form-group py-1">
      <div class="container bg-warning text-dark">
        <p class="text-center"><strong>Informações Sobre o Tutor</strong></p>
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="nome">Nome</label>
        <input type="text" class="form-control" name="nome" value="{{ $pedido->nome }}" readonly>
      </div>
      <div class="form-group col-md-3">
        <label for="nascimento">Nascimento</strong></label>
        <input type="text" class="form-control" name="nascimento" value="{{ $pedido->nascimento->format('d/m/Y') }}" readonly>
      </div>
      <div class="form-group col-md-3">
        <label for="cpf">CPF</label>
        <input type="text" class="form-control" name="cpf" value="{{ preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $pedido->cpf) }}" readonly>
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="email">E-mail</label>
        <input type="text" class="form-control" name="email" value="{{ $pedido->email }}" readonly>
      </div>
      <div class="form-group col-md-4">
        <label for="cel">Celular</label>
        <input type="text" class="form-control" name="cel" value="{{ $pedido->cel }}" readonly>
      </div>
      <div class="form-group col-md-4">
        <label for="tel">Telefone</label>
        <input type="text" class="form-control" name="tel" value="{{ $pedido->tel }}" readonly> 
      </div>      
    </div>

    <div class="form-row">
      <div class="form-group col-md-2">
        <label for="cep">CEP</label>
        <input type="text" class="form-control" name="cep" value="{{ preg_replace("/(\d{5})(\d{3})/", "\$1-\$2", $pedido->cep) }}" readonly>        
      </div>
      <div class="form-group col-md-5">
        <label for="endereco">Endereço</label>
        <input type="text" class="form-control" name="endereco" value="{{ $pedido->endereco }}" readonly>        
      </div>
      <div class="form-group col-md-2">
        <label for="numero">Número</label>
        <input type="text" class="form-control" name="numero" value="{{ $pedido->numero }}" readonly>
      </div>
      <div class="form-group col-md-3">
        <label for="complemento">Complemento</label>
        <input type="text" class="form-control" name="complemento" value="{{ $pedido->complemento }}" readonly>        
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="bairro">Bairro</label>
        <input type="text" class="form-control" name="bairro" value="{{ $pedido->bairro }}" readonly>
      </div>
      <div class="form-group col-md-6">
        <label for="cidade">Cidade</label>
        <input type="text" class="form-control" name="cidade" value="{{ $pedido->cidade }}" readonly>
      </div>
      <div class="form-group col-md-2">
        <label for="uf">UF</label>
        <input type="text" class="form-control" name="uf" value="{{ $pedido->uf }}" readonly>
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="cns">Cartão Nacional de Saúde</label>
        <input type="text" class="form-control" name="cns" value="{{ $pedido->cns }}" readonly>
      </div>
      <div class="form-group col-md-4">
        <label for="beneficio">Possui Benéficio?</label>
        <input type="text" class="form-control" name="beneficio" value="{{ ($pedido->beneficio == 'S') ? 'Sim' : 'Não' }}" readonly>
      </div>
      <div class="form-group col-md-4">
        <label for="beneficioQual">Qual(is) Benéficio(s)?</label>
        <input type="text" class="form-control" name="beneficioQual" value="{{ $pedido->beneficioQual }}" readonly>
      </div>
    </div>

    <div class="form-group py-2">
      <div class="container bg-warning text-dark">
        <p class="text-center"><strong>Informações Sobre o Animal</strong></p>
      </div>
    </div>

    <div class="form-row">
      <div class="for-group col-md-4">
        <label for="nomeAnimal">Nome</label>
        <input type="text" class="form-control" name="nomeAnimal" value="{{ $pedido->nomeAnimal }}" readonly>
      </div>
      <div class="for-group col-md-4">
        <label for="especie">Espécie</label>
        <input type="text" class="form-control" name="especie" value="{{ $pedido->especie }}" readonly>
      </div>
      <div class="for-group col-md-4">
        <label for="genero">Gênero</label>
        <input type="text" class="form-control" name="genero" value="{{ ($pedido->genero == 'F') ? 'Fêmea' : 'Macho' }}" readonly>
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="raca">Raça</label>
        <input type="text" class="form-control" name="raca" value="{{ $pedido->raca->descricao }}" readonly>
      </div>
      <div class="form-group col-md-4">
        <label for="porte">Porte</label>
        <input type="text" class="form-control" name="porte" value="{{ $pedido->porte }}" readonly>
      </div>
      <div class="form-group col-md-4">
        <label for="cor">Cor(es)</label>
        <input type="text" class="form-control" name="cor" value="{{ $pedido->cor }}" readonly>  
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="idade">Idade</label>
        <input type="text" class="form-control" name="idade" value="{{ $pedido->idade }}" readonly>  
      </div>
      <div class="form-group col-md-4">
        <label for="idadeEm">Idade em</label>
        <input type="text" class="form-control" name="idadeEm" value="{{ ($pedido->idadeEm == 'M') ? 'Mês(es)' : 'Ano(s)' }}" readonly>
      </div>
      <div class="form-group col-md-4">
        <label for="procedencia">Origem do animal</label>
        <input type="text" class="form-control" name="procedencia" value="{{ $pedido->procedencia }}" readonly>   
      </div>
    </div>

    <div class="form-group py-2">
      <div class="container bg-warning text-dark">
        <p class="text-center"><strong>Agendamento do Pedido (Opcional)</strong></p>
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="primeiraTentativa">Primeira Tentativa</label>
        <input type="text" class="form-control" name="primeiraTentativa" value="{{ ($pedido->primeiraTentativa == 'S') ? 'Sim' : 'Não' }}" readonly>
      </div>
      <div class="form-group col-md-4">
        <label for="primeiraTentativaQuando">Quando</label>
        <input type="text" class="form-control" name="primeiraTentativaQuando" value="@isset($pedido->primeiraTentativaQuando) {{ $pedido->primeiraTentativaQuando->format('d/m/Y') }} @endisset" readonly>
      </div>
      <div class="form-group col-md-4">
        <label for="primeiraTentativaHora">Horário</label>
        <input type="text" class="form-control" name="primeiraTentativaHora" value="{{ $pedido->primeiraTentativaHora }}" readonly>
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="segundaTentativa">Segunda Tentativa</label>
        <input type="text" class="form-control" name="segundaTentativa" value="{{ ($pedido->segundaTentativa == 'S') ? 'Sim' : 'Não' }}" readonly>
      </div>
      <div class="form-group col-md-4">
        <label for="segundaTentativaQuando">Quando</label>
        <input type="text" class="form-control" name="segundaTentativaQuando" value="@isset($pedido->segundaTentativaQuando) {{ $pedido->segundaTentativaQuando->format('d/m/Y') }} @endisset" readonly>
      </div>
      <div class="form-group col-md-4">
        <label for="segundaTentativaHora">Horário</label>
        <input type="text" class="form-control" name="segundaTentativaHora" value="{{ $pedido->segundaTentativaHora }}" readonly>
      </div>
    </div>

    <div class="form-group">
      <label for="nota">Anotações do Agendamento </label>
      <textarea class="form-control" name="nota" rows="3" readonly>{{ $pedido->nota }}</textarea>
    </div>

    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="dataAgendamento">Data do Agendamento</label>
        <input type="text" class="form-control" name="dataAgendamento" value="@isset($pedido->dataAgendamento) $pedido->dataAgendamento->format('d/m/Y') @endisset" readonly>
      </div>
      <div class="form-group col-md-6">
        <label for="agendaTurno">Horário do Agendamento</label>
        <input type="text" class="form-control" name="agendaTurno" value="{{ $pedido->agendaTurno }}" readonly>      
      </div>      
    </div>

    <div class="form-group">
      <label for="motivoNaoAgendado">Motivo do Não Agendamento</label>
      <textarea class="form-control" name="motivoNaoAgendado" id="motivoNaoAgendado" rows="3" readonly>{{ $pedido->motivoNaoAgendado }}</textarea>
    </div>

    <div class="form-group py-2">
      <div class="container bg-warning text-dark">
        <p class="text-center"><strong>STATUS DO PEDIDO</strong></p>
      </div>
    </div>

    <div class="form-group">
      <div class="container bg-info text-dark">
        <h3 class="text-center"><strong>{{ $pedido->situacao->descricao }}</strong></h3>
      </div>
    </div>

  </form>
</x-card>

<x-btn-back route="pedidos.index" />

<x-modal-trash>
  <form method="post" action="{{route('pedidos.destroy', $pedido->id)}}">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i> Apagar Registro</button>
  </form>  
</x-modal-trash>

@endsection
