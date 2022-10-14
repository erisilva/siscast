@extends('layouts.app')

@section('css-header')
<link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
@endsection

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('pedidos.index') }}">Lista de Pedidos</a></li>
      <li class="breadcrumb-item active" aria-current="page">Alterar Registro</li>
    </ol>
  </nav>
</div>
<div class="container">
  
  <x-flash-message />
  
  <form method="POST" action="{{ route('pedidos.update', $pedido) }}">
    @csrf
    @method('PUT')
    <div class="form-group">
      <label for="numeroano">Pedido Nº/Ano e Status</label>
        <input type="text" class="form-control" name="numeroano" value="{{ $pedido->codigo }}/{{ $pedido->ano }} - {{ $pedido->situacao->descricao }}" readonly>  
    </div>

    <div class="form-group py-1">
      <div class="container bg-warning text-dark">
        <p class="text-center"><strong>Informações Sobre o Tutor</strong></p>
      </div>
    </div>    

    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="nome">Nome</label>
        <input type="text" class="form-control  @error('nome') is-invalid @enderror" name="nome" value="{{ old('nome') ?? $pedido->nome }}"  maxlength="180">
        @error('nome')
        <div class="text-danger">
          <small>{{ $message }}</small>
        </div>
        @enderror
      </div>
      <div class="form-group col-md-3">
        <label for="nascimento">Nascimento</label>
        <input type="text" class="form-control @error('nascimento') is-invalid @enderror" name="nascimento" id="nascimento" value="{{ old('nascimento') ?? $pedido->nascimento->format('d/m/Y') }}" autocomplete="off">
        @error('nascimento')
        <div class="text-danger">
          <small>{{ $message }}</small>
        </div>
        @enderror
      </div>
      <div class="form-group col-md-3">
        <label for="cpf">CPF</label>
        <input type="text" class="form-control @error('cpf') is-invalid @enderror" name="cpf" id="cpf" value="{{ old('cpf') ?? preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $pedido->cpf) }}"  maxlength="14">
        @error('cpf')
        <div class="text-danger">
          <small>{{ $message }}</small>
        </div>
        @enderror
      </div>
    </div>
    
    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="email">E-mail</label>
        <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{ old('email') ?? $pedido->email }}" maxlength="150">
        @error('email')
        <div class="text-danger">
          <small>{{ $message }}</small>
        </div>
        @enderror  
      </div>
      <div class="form-group col-md-4">
        <label for="cel">Celular</label>
        <input type="text" class="form-control @error('cel') is-invalid @enderror" name="cel" id="cel" value="{{ old('cel') ?? $pedido->cel }}" maxlength="15">
        @error('cel')
        <div class="text-danger">
          <small>{{ $message }}</small>
        </div>
        @enderror
      </div>
      <div class="form-group col-md-4">
        <label for="tel">Telefone</label>
        <input type="text" class="form-control" name="tel" id="tel" value="{{ old('tel') ?? $pedido->tel }}" maxlength="15">
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-2">
        <label for="cep">CEP</label>
        <input type="text" class="form-control @error('cep') is-invalid @enderror" name="cep" id="cep" value="{{ old('cep') ?? $pedido->cep }}" maxlength="9">
        @error('cep')
        <div class="text-danger">
          <small>{{ $message }}</small>
        </div>
        @enderror
      </div>
      <div class="form-group col-md-5">
        <label for="endereco">Endereço</label>
        <input type="text" class="form-control @error('endereco') is-invalid @enderror" name="endereco" id="endereco" value="{{ old('endereco') ?? $pedido->endereco }}" maxlength="100">
        @error('endereco')
        <div class="text-danger">
          <small>{{ $message }}</small>
        </div>
        @enderror
      </div>
      <div class="form-group col-md-2">
        <label for="numero">Número</label>
        <input type="text" class="form-control @error('numero') is-invalid @enderror" name="numero" id="numero" value="{{ old('numero') ?? $pedido->numero }}"  maxlength="10">
        @error('numero')
        <div class="text-danger">
          <small>{{ $message }}</small>
        </div>
        @enderror
      </div>
      <div class="form-group col-md-3">
        <label for="complemento">Complemento</label>
        <input type="text" class="form-control" name="complemento" id="complemento" value="{{ old('complemento') ?? $pedido->complemento }}" maxlength="100">
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="bairro">Bairro</label>
        <input type="text" class="form-control @error('bairro') is-invalid @enderror" name="bairro" id="bairro" value="{{ old('bairro') ?? $pedido->bairro }}" maxlength="80">
        @error('bairro')
        <div class="text-danger">
          <small>{{ $message }}</small>
        </div>
        @enderror
      </div>
      <div class="form-group col-md-6">
        <label for="cidade">Cidade</label>
        <input type="text" class="form-control @error('cidade') is-invalid @enderror" name="cidade" id="cidade" value="{{ old('cidade') ?? $pedido->cidade }}" maxlength="80">
        @error('cidade')
        <div class="text-danger">
          <small>{{ $message }}</small>
        </div>
        @enderror
      </div>
      <div class="form-group col-md-2">
        <label for="uf">UF</label>
        <input type="text" class="form-control @error('uf') is-invalid @enderror" name="uf" id="uf" value="{{ old('uf') ?? $pedido->uf }}"  maxlength="2">
        @error('uf')
        <div class="text-danger">
          <small>{{ $message }}</small>
        </div>
        @enderror
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="cns">Cartão Nacional de Saúde</label>
        <input type="text" class="form-control @error('cns') is-invalid @enderror" name="cns" id="cns" value="{{ old('cns') ?? $pedido->cns }}"  maxlength="15">
        @error('cns')
        <div class="text-danger">
          <small>{{ $message }}</small>
        </div>
        @enderror
      </div>
      <div class="form-group col-md-4">
        <label for="beneficio">Possui benefício?<strong class="text-danger">(*)</strong></label>
        <select class="form-control  @error('beneficio') is-invalid @enderror" name="beneficio" id="beneficio">
          <option value="{{$pedido->beneficio}}" selected="true">&rarr; {{$pedido->beneficio_descricao}}</option>       
          <option value="S" {{ old("beneficio") == "S" ? "selected": "" }}>Sim</option>
          <option value="N" {{ old("beneficio") == "N" ? "selected": "" }}>Não</option>
        </select>
        @error('beneficio')
        <div class="text-danger">
          <small>{{ $message }}</small>
        </div>
        @enderror
      </div>
      <div class="form-group col-md-4">
        <label for="beneficioQual">Qual(is) Benéficio(s)?</label>
        <input type="text" class="form-control" name="beneficioQual" id="beneficioQual" value="{{ old('beneficioQual') ?? $pedido->beneficioQual }}" maxlength="100">
      </div>
    </div>

    <div class="form-group py-2">
      <div class="container bg-warning text-dark">
        <p class="text-center"><strong>Informações Sobre o Animal</strong></p>
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="nomeAnimal">Nome do Animal <strong class="text-danger">(*)</strong></label>
        <input type="text" class="form-control @error('nomeAnimal') is-invalid @enderror" name="nomeAnimal" id="nomeAnimal" value="{{ old('nomeAnimal') ?? $pedido->nomeAnimal }}" maxlength="100">
        @error('nomeAnimal')
        <div class="text-danger">
          <small>{{ $message }}</small>
        </div>
        @enderror
      </div>
      <div class="form-group col-md-4">
        <label for="especie">Espécie <strong class="text-danger">(*)</strong></label>
        <select class="form-control  @error('especie') is-invalid @enderror" name="especie" id="especie">
          <option value="{{$pedido->especie}}" selected="true">&rarr; {{$pedido->especie_descricao}}</option>
          <option value="felino" {{ old("especie") == "felino" ? "selected": "" }}>Felino</option>
          <option value="canino" {{ old("especie") == "canino" ? "selected": "" }}>Canino</option>
        </select>
        @error('especie')
        <div class="text-danger">
          <small>{{ $message }}</small>
        </div>
        @enderror  
      </div>
      <div class="form-group col-md-4">
        <label for="genero">Gênero<strong class="text-danger">(*)</strong></label>
        <select class="form-control  @error('genero') is-invalid @enderror" name="genero" id="genero">
          <option value="{{$pedido->genero}}" selected="true">&rarr; {{$pedido->genero_descricao}}</option>       
          <option value="M" {{ old("genero") == "M" ? "selected": "" }}>Macho</option>
          <option value="F" {{ old("genero") == "F" ? "selected": "" }}>Fêmea</option>
        </select>
        @error('genero')
        <div class="text-danger">
          <small>{{ $message }}</small>
        </div>
        @enderror
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="raca_id">Raça <strong  class="text-danger">(*)</strong></label>
        <select class="form-control" id="raca_id" name="raca_id">
            <option value="{{$pedido->raca_id}}" selected>&rarr; {{ $pedido->raca->descricao }}</option> 
            @foreach($racas as $raca)
            <option value="{{$raca->id}}" {{ old("raca_id") == $raca->id ? "selected": "" }}>{{$raca->descricao}}</option>
            @endforeach
        </select>
       @error('raca_id')
        <div class="text-danger">
          <small>{{ $message }}</small>
        </div>
        @enderror
      </div>
      <div class="form-group col-md-4">
        <label for="porte">Porte <strong class="text-danger">(*)</strong></label>
        <select class="form-control  @error('porte') is-invalid @enderror" name="porte" id="porte">
          <option value="{{$pedido->porte}}" selected="true">&rarr; {{$pedido->porte_descricao}}</option>       
          <option value="pequeno" {{ old("porte") == "pequeno" ? "selected": "" }}>pequeno</option>
          <option value="medio" {{ old("porte") == "medio" ? "selected": "" }}>Médio</option>
          <option value="grande" {{ old("porte") == "grande" ? "selected": "" }}>Grande</option>
        </select>
        @error('porte')
        <div class="text-danger">
          <small>{{ $message }}</small>
        </div>
        @enderror
      </div>
      <div class="form-group col-md-4">
        <label for="cor">Cor(es) <strong class="text-danger">(*)</strong></label>
        <input type="text" class="form-control @error('cor') is-invalid @enderror" name="cor" id="cor" value="{{ old('cor') ?? $pedido->cor }}"  maxlength="80">
        @error('cor')
        <div class="text-danger">
          <small>{{ $message }}</small>
        </div>
        @enderror
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="idade">Idade <strong class="text-danger">(*)</strong></label>
        <input type="text" class="form-control @error('idade') is-invalid @enderror" name="idade" id="idade" value="{{ old('idade') ?? $pedido->idade }}">
        @error('idade')
        <div class="text-danger">
          <small>{{ $message }}</small>
        </div>
        @enderror
      </div>
      <div class="form-group col-md-4">
        <label for="idadeEm">Idade em<strong class="text-danger">(*)</strong></label>
        <select class="form-control  @error('idadeEm') is-invalid @enderror" name="idadeEm" id="idadeEm" maxlength="2">
          <option value="{{$pedido->idadeEm}}" selected="true">&rarr; {{($pedido->idadeEm == 'ano') ? 'Ano(s)' : 'Mês(es)'}}</option>       
          <option value="mes" {{ old("idadeEm") == "mes" ? "selected": "" }}>Mês(es)</option>
          <option value="ano" {{ old("idadeEm") == "ano" ? "selected": "" }}>Ano(s)</option>
        </select>
        @error('idadeEm')
            <div class="text-danger">
              <small>{{ $message }}</small>
            </div>
        @enderror  
      </div>
      <div class="form-group col-md-4">
        <label for="procedencia">Origem do animal<strong class="text-danger">(*)</strong></label>
        <select class="form-control  @error('procedencia') is-invalid @enderror" name="procedencia" id="procedencia">
          <option value="{{$pedido->procedencia}}" selected="true">&rarr; {{$pedido->procedencia}}</option>       
          <option value="vive na rua / comunitario" {{ old("procedencia") == "vive na rua / comunitario" ? "selected": "" }}>Vive na rua ou comunitário</option>
          <option value="resgatado" {{ old("procedencia") == "resgatado" ? "selected": "" }}>Resgatado</option>
          <option value="adotado" {{ old("procedencia") == "adotado" ? "selected": "" }}>Adotado</option>
          <option value="comprado" {{ old("procedencia") == "comprado" ? "selected": "" }}>Comprado</option>
          <option value="ONG" {{ old("procedencia") == "ONG" ? "selected": "" }}>ONG</option>
          <option value="CCZ" {{ old("procedencia") == "CCZ" ? "selected": "" }}>CCZ</option>
        </select>
        @error('procedencia')
        <div class="text-danger">
          <small>{{ $message }}</small>
        </div>
        @enderror
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
        <select class="form-control  @error('primeiraTentativa') is-invalid @enderror" name="primeiraTentativa" id="primeiraTentativa">
          <option value="{{$pedido->primeiraTentativa}}" selected="true">&rarr; {{ ($pedido->primeiraTentativa == 'S') ? 'Sim' : 'Não' }}</option>       
          <option value="S" {{ old("primeiraTentativa") == "S" ? "selected": "" }}>Sim</option>
          <option value="N" {{ old("primeiraTentativa") == "N" ? "selected": "" }}>Não</option>
        </select>
        @error('primeiraTentativa')
        <div class="text-danger">
          <small>{{ $message }}</small>
        </div>
        @enderror        
      </div>
      <div class="form-group col-md-4">
        <label for="primeiraTentativaQuando">Quando</label>
        <input type="text" class="form-control @error('primeiraTentativaQuando') is-invalid @enderror" name="primeiraTentativaQuando" id="primeiraTentativaQuando" value="{{ old('primeiraTentativaQuando') ?? (isset($pedido->primeiraTentativaQuando) ? $pedido->primeiraTentativaQuando->format('d/m/Y') : '') }}">
        @error('primeiraTentativaQuando')
        <div class="text-danger">
          <small>{{ $message }}</small>
        </div>
        @enderror
      </div>
      <div class="form-group col-md-4">
        <label for="primeiraTentativaHora">Horas</label>
        <input type="text" class="form-control @error('primeiraTentativaHora') is-invalid @enderror" name="primeiraTentativaHora" id="primeiraTentativaHora" value="{{ old('primeiraTentativaHora') ?? $pedido->primeiraTentativaHora }}" maxlength="5">
        @error('primeiraTentativaHora')
        <div class="text-danger">
          <small>{{ $message }}</small>
        </div>
        @enderror  
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="segundaTentativa">Segunda Tentativa</label>
        <select class="form-control  @error('segundaTentativa') is-invalid @enderror" name="segundaTentativa" id="segundaTentativa">
          <option value="{{$pedido->segundaTentativa}}" selected="true">&rarr; {{ ($pedido->segundaTentativa == 'S') ? 'Sim' : 'Não' }}</option>       
          <option value="S" {{ old("segundaTentativa") == "S" ? "selected": "" }}>Sim</option>
          <option value="N" {{ old("segundaTentativa") == "N" ? "selected": "" }}>Não</option>
        </select>
        @error('segundaTentativa')
        <div class="text-danger">
          <small>{{ $message }}</small>
        </div>
        @enderror      
      </div>
      <div class="form-group col-md-4">
        <label for="segundaTentativaQuando">Quando</label>
        <input type="text" class="form-control @error('segundaTentativaQuando') is-invalid @enderror" name="segundaTentativaQuando" id="segundaTentativaQuando" value="{{ old('segundaTentativaQuando') ?? (isset($pedido->segundaTentativaQuando) ? $pedido->segundaTentativaQuando->format('d/m/Y') : '') }}">
        @error('segundaTentativaQuando')
        <div class="text-danger">
          <small>{{ $message }}</small>
        </div>
        @enderror
      </div>
      <div class="form-group col-md-4">
        <label for="segundaTentativaHora">Horas</label>
        <input type="text" class="form-control @error('segundaTentativaHora') is-invalid @enderror" name="segundaTentativaHora" id="segundaTentativaHora" value="{{ old('segundaTentativaHora') ?? $pedido->segundaTentativaHora }}" maxlength="5">
        @error('segundaTentativaHora')
        <div class="text-danger">
          <small>{{ $message }}</small>
        </div>
        @enderror  
      </div>
    </div>

    <div class="form-group">
      <label for="nota">Anotações do Agendamento </label>
      <textarea class="form-control" name="nota" id="nota" rows="5">{{ old('nota') ?? $pedido->nota }}</textarea>
    </div>

    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="agendaQuando">Data de Agendamento</label>
        <input type="text" class="form-control @error('agendaQuando') is-invalid @enderror" name="agendaQuando" id="agendaQuando" value="{{ old('agendaQuando') ?? (isset($pedido->segundaTentativaQuando) ? $pedido->agendaQuando->format('d/m/Y') : '') }}" autocomplete="off">
        @error('agendaQuando')
        <div class="text-danger">
          <small>{{ $message }}</small>
        </div>
        @enderror   
      </div>
      <div class="form-group col-md-6">
        <label for="agendaTurno">Truno do Agendamento</label>
        <select class="form-control" name="agendaTurno" id="agendaTurno">
          <option value="{{$pedido->agendaTurno}}" selected>&rarr; {{$pedido->turno_descricao}}</option>           
          <option value="manha" {{ old("agendaTurno") == "manha" ? "selected": "" }}>Manhã</option>
          <option value="tarde" {{ old("agendaTurno") == "tarde" ? "selected": "" }}>Tarde</option>
          <option value="nenhum" {{ old("agendaTurno") == "nenhum" ? "selected": "" }}>Nenhum</option>
        </select>  
      </div>
    </div>

    <div class="form-group">
      <label for="motivoNaoAgendado">Motivo do Não Agendamento</label>
      <textarea class="form-control" name="motivoNaoAgendado" id="motivoNaoAgendado" rows="5">{{ old('motivoNaoAgendado') ?? $pedido->motivoNaoAgendado }}</textarea>
    </div>

    <div class="form-group py-2">
      <div class="container bg-warning text-dark">
        <p class="text-center"><strong>Situação do Pedido</strong></p>
      </div>
    </div>

    <div class="form-group">
      <label for="situacao_id">Situação do Pedido <strong  class="text-danger">(*)</strong></label>
      <select class="form-control" id="situacao_id" name="situacao_id">
        <option value="{{$pedido->situacao_id}}" selected>&rarr; {{ $pedido->situacao->descricao }}</option> 
          @foreach($situacoes as $situacao)
          <option value="{{$situacao->id}}" {{ old("situacao_id") == $situacao->id ? "selected":"" }}>{{$situacao->descricao}}</option>
          @endforeach
      </select>
      @error('situacao_id')
        <div class="text-danger">
          <small>{{ $message }}</small>
        </div>
      @enderror 
    </div>

    <button type="submit" class="btn btn-primary"><i class="bi bi-pencil-square"></i> Alterar Dados do Pedido</button>
  </form>

  <div class="form-group py-2">
    <div class="container bg-warning text-dark">
      <p class="text-center"><strong>Outros Pedidos</strong></p>
    </div>
  </div>

</div>

<x-btn-back route="pedidos.index" />
@endsection

@section('script-footer')
<script src="{{ asset('js/jquery.inputmask.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('locales/bootstrap-datepicker.pt-BR.min.js') }}"></script>
<script>
  $(document).ready(function(){

      $('#nascimento, #primeiraTentativaQuando, #segundaTentativaQuando, #agendaQuando').datepicker({
          format: "dd/mm/yyyy",
          todayBtn: "linked",
          clearBtn: true,
          language: "pt-BR",
          autoclose: true,
          todayHighlight: true
      });

      $("#cpf").inputmask({
        mask: ['999.999.999-99'],
        keepStatic: true
      });

      $("#cep").inputmask({
        mask: ['99999-999'],
        keepStatic: true
      });

      $("#cel").inputmask({
        mask: ['(99) 99999-9999'],
        keepStatic: true
      });

      $("#tel").inputmask({
        mask: ['(99) 9999-9999'],
        keepStatic: true
      });

      $("#cep").blur(function () {
          var cep = $(this).val().replace(/\D/g, '');
          if (cep != "") {
              var validacep = /^[0-9]{8}$/;
              if(validacep.test(cep)) {
                  $("#endereco").val("...");
                  $("#bairro").val("...");
                  $("#cidade").val("...");
                  $("#uf").val("...");
                  $.ajax({
                      dataType: "json",
                      url: "http://srvsmsphp01.brazilsouth.cloudapp.azure.com:9191/cep/?value=" + cep,
                      type: "GET",
                      success: function(json) {
                          if (json['erro']) {
                              limpa_formulario_cep();
                              console.log('cep inválido');
                          } else {
                              $("#bairro").val(json[0]['bairro']);
                              $("#cidade").val(json[0]['cidade']);
                              $("#uf").val(json[0]['uf'].toUpperCase());
                              $("#endereco").val(json[0]['rua']);
                          }
                      }
                  });
              } else {
                  limpa_formulario_cep();
              }
          } else {
              limpa_formulario_cep();
          }
      });

      $('#fillccz').click(function(){
        if($(this).is(':checked')){
          $('#nome').val('CCZ');
          $('#cpf').val('797.875.780-35');
          $('#nascimento').val('18/11/1985');
          $('#email').val('cczcontagem@yahoo.com.br');
          $('#cep').val('32010-000');
          $('#endereco').val('João César de Oliveira');
          $('#numero').val('4665');
          $('#bairro').val('Cinco');
          $('#cidade').val('Contagem');
          $('#uf').val('MG');
          $('#tel').val('(31) 3351-3751');
          $('#cel').val('(31) 99999-9999');
          $('#cns').val('111111111111111');
          $('#beneficio').val('N');
        }else{
          $('#nome').val('');
          $('#cpf').val('');
          $('#nascimento').val('');
          $('#email').val('');
          $('#cep').val('');
          $('#endereco').val('');
          $('#numero').val('');
          $('#bairro').val('');
          $('#cidade').val('');
          $('#uf').val('');
          $('#tel').val('');
          $('#cel').val('');
          $('#cns').val('');
          $('#beneficio').val('');
        }
      });

  });
</script>

@endsection

