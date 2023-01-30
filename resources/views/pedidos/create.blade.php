@extends('layouts.app')

@section('css-header')
<link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
@endsection

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('pedidos.index') }}">Lista de Pedidos</a></li>
      <li class="breadcrumb-item active" aria-current="page">Novo Registro</li>
    </ol>
  </nav>
</div>
<div class="container py-3">
  @if($errors->any())
    {{ implode('', $errors->all('<div>:message</div>')) }}
  @endif
</div>
<div class="container">
  <form method="POST" action="{{ route('pedidos.store') }}">
    @csrf
    <div class="form-group py-1">
      <div class="container bg-warning text-dark">
        <p class="text-center"><strong>Informações Sobre o Tutor</strong></p>
      </div>
    </div>

    <div class="form-group py-1">
      <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" id="fillccz" name="fillccz">
        <label class="custom-control-label" for="fillccz">Preencher com os dados do CCZ</label>
      </div>
    </div>

    <div class="form-group">
      <div class="alert alert-info" role="alert">
        <p class="text-center">Campos marcado com * <strong>(asterístico)</strong> devem ser preenchidos obrigatoriamente.</p>
      </div>  
    </div>
    
    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="nome">Nome do Tutor <strong  class="text-danger">(*)</strong></label>
        <input type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" id="nome" value="{{ old('nome') ?? '' }}" maxlength="180">
        @error('nome')
          <div class="text-danger">
            <small>{{ $message }}</small>
          </div>
        @enderror
      </div>
      <div class="form-group col-md-3">
        <label for="nascimento">Nascimento <strong  class="text-danger">(*)</strong></label>
        <input type="text" class="form-control @error('nascimento') is-invalid @enderror" name="nascimento" id="nascimento" value="{{ old('nascimento') ?? '' }}" autocomplete="off">
        @error('nascimento')
          <div class="text-danger">
            <small>{{ $message }}</small>
          </div>
        @enderror
      </div>
      <div class="form-group col-md-3">
        <label for="cpf">CPF <strong  class="text-danger">(*)</strong></label>
        <input type="text" class="form-control @error('cpf') is-invalid @enderror" name="cpf" id="cpf" value="{{ old('cpf') ?? '' }}" maxlength="14">
        @error('cpf')
          <div class="text-danger">
            <small>{{ $message }}</small>
          </div>
        @enderror
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="email">E-mail <strong  class="text-danger">(*)</strong></label>
        <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{ old('email') ?? '' }}" maxlength="150">
        @error('email')
          <div class="text-danger">
            <small>{{ $message }}</small>
          </div>
        @enderror
      </div>
      <div class="form-group col-md-4">
        <label for="cel">Celular <strong  class="text-danger">(*)</strong></label>
        <input type="text" class="form-control @error('cel') is-invalid @enderror" name="cel" id="cel" value="{{ old('cel') ?? '' }}" maxlength="15">
        @error('cel')
          <div class="text-danger">
            <small>{{ $message }}</small>
          </div>
        @enderror  
      </div>
      <div class="form-group col-md-4">
        <label for="tel">Telefone</label>
        <input type="text" class="form-control @error('tel') is-invalid @enderror" name="tel" id="tel" value="{{ old('tel') ?? '' }}" maxlength="15">
        @error('tel')
          <div class="text-danger">
            <small>{{ $message }}</small>
          </div>
        @enderror 
      </div>      
    </div>

    <div class="form-row">
      <div class="form-group col-md-2">
        <label for="cep">CEP <strong class="text-danger">(*)</strong></label>  
        <input type="text" class="form-control @error('cep') is-invalid @enderror" name="cep" id="cep" value="{{ old('cep') ?? '' }}" maxlength="9">
        @error('cep')
          <div class="text-danger">
            <small>{{ $message }}</small>
          </div>
        @enderror
      </div>
      <div class="form-group col-md-5">  
        <label for="endereco">Endereço <strong class="text-danger">(*)</strong></label>  
        <input type="text" class="form-control  @error('endereco') is-invalid @enderror" name="endereco" id="endereco" value="{{ old('endereco') ?? '' }}" maxlength="100">
        @error('endereco')
          <div class="text-danger">
            <small>{{ $message }}</small>
          </div>
        @enderror 
      </div> 
      <div class="form-group col-md-2">  
        <label for="numero">Nº <strong class="text-danger">(*)</strong></label>  
        <input type="text" class="form-control @error('numero') is-invalid @enderror" name="numero" id="numero" value="{{ old('numero') ?? '' }}"  maxlength="10">
        @error('numero')
          <div class="text-danger">
            <small>{{ $message }}</small>
          </div>
        @enderror    
      </div>
      <div class="form-group col-md-3">  
        <label for="complemento">Complemento</label>  
        <input type="text" class="form-control" name="complemento" id="complemento" value="{{ old('complemento') ?? '' }}"  maxlength="100">
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="bairro">Bairro <strong class="text-danger">(*)</strong></label>  
        <input type="text" class="form-control  @error('bairro') is-invalid @enderror" name="bairro" id="bairro" value="{{ old('bairro') ?? '' }}" maxlength="80">
        @error('bairro')
          <div class="text-danger">
            <small>{{ $message }}</small>
          </div>
        @enderror
      </div>
      <div class="form-group col-md-6">  
        <label for="cidade">Cidade <strong class="text-danger">(*)</strong></label>  
        <input type="text" class="form-control @error('cidade') is-invalid @enderror" name="cidade" id="cidade" value="{{ old('cidade') ?? '' }}" maxlength="80">
        @error('cidade')
          <div class="text-danger">
            <small>{{ $message }}</small>
          </div>
        @enderror
      </div> 
      <div class="form-group col-md-2">  
        <label for="uf">UF <strong class="text-danger">(*)</strong></label>  
        <input type="text" class="form-control @error('uf') is-invalid @enderror" name="uf" id="uf" value="{{ old('uf') ?? '' }}"  maxlength="2">
        @error('uf')
          <div class="text-danger">
            <small>{{ $message }}</small>
          </div>
        @enderror
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-4">
        <label for="cns">Cartão Nacional de Saúde <strong class="text-danger">(*)</strong></label>
        <input type="text" class="form-control @error('cns') is-invalid @enderror" name="cns" id="cns" value="{{ old('cns') ?? '' }}" maxlength="15">
        @error('cns')
          <div class="text-danger">
            <small>{{ $message }}</small>
          </div>
        @enderror  
      </div>
      <div class="form-group col-8">
        <div class="alert alert-info" role="alert">
          O número do cartão nacional de saúde pode ser obtido em uma unidade de saúde mais próxima de sua residência.
        </div>  
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-8">
        <label for="beneficio">Possui benefício de algum programa social do governo? <strong class="text-danger">(*)</strong></label>
        <select class="form-control  @error('beneficio') is-invalid @enderror" name="beneficio" id="beneficio">
          <option value="" selected="true">Selecione...</option>        
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
        <label for="beneficioQual @error('beneficioQual') is-invalid @enderror">Se sim, qual(is)?</label>  
        <input type="text" class="form-control" name="beneficioQual" id="beneficioQual" value="{{ old('beneficioQual') ?? '' }}" maxlength="100" >
        @error('beneficioQual')
          <div class="text-danger">
            <small>{{ $message }}</small>
          </div>
        @enderror 
      </div>
    </div>

    <div class="form-group py-2">
      <div class="container bg-warning text-dark">
        <p class="text-center"><strong>Informações Sobre o Animal</strong></p>
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="nomeAnimal">Nome do Animal <strong  class="text-danger">(*)</strong></label>
        <input type="text" class="form-control @error('nomeAnimal') is-invalid @enderror" name="nomeAnimal" value="{{ old('nomeAnimal') ?? '' }}" maxlength="100">
        @error('nomeAnimal')
          <div class="text-danger">
            <small>{{ $message }}</small>
          </div>
        @enderror
      </div>
      <div class="form-group col-md-4">
        <label for="especie">Espécie<strong class="text-danger">(*)</strong></label>
        <select class="form-control  @error('especie') is-invalid @enderror" name="especie" id="especie">
          <option value="" selected="true">Selecione...</option>        
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
          <option value="" selected="true">Selecione...</option>        
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
        <label for="raca_id">Raça do Animal</label>
        <select class="form-control @error('raca_id') is-invalid @enderror" name="raca_id" id="raca_id">
          <option value="" selected="true">Selecione ...</option>        
          @foreach($racas as $raca)
          <option value="{{$raca->id}}"  {{ old("raca_id") == $raca->id ? "selected":"" }}>{{$raca->descricao}}</option>
          @endforeach
        </select>
        @error('raca_id')
          <div class="text-danger">
            <small>{{ $message }}</small>
          </div>
        @enderror
      </div>
      <div class="form-group col-md-4">
        <label for="porte">Porte(tamanho)<strong class="text-danger">(*)</strong></label>
        <select class="form-control  @error('porte') is-invalid @enderror" name="porte" id="porte">
          <option value="" selected="true">Selecione...</option>        
          <option value="pequeno" {{ old("porte") == "pequeno" ? "selected": "" }}>Pequeno</option>
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
        <label for="cor">Cor(es) do animal <strong  class="text-danger">(*)</strong></label>
        <input type="text" class="form-control @error('cor') is-invalid @enderror" name="cor" value="{{ old('cor') ?? '' }}" maxlength="80">
        @error('cor')
          <div class="text-danger">
            <small>{{ $message }}</small>
          </div>
        @enderror
      </div>
    </div>

    <div class="for-group">
      <div class="alert alert-info" role="alert">
        <p class="text-center">Para gatos escolha a raça do animal "Outros" e porte "Pequeno".</p>
      </div>
      <div class="alert alert-info" role="alert">
        <p class="text-center">Os cachorros pequenos são aqueles que podem chegar a medir até 40 cm – sendo esse tamanho calculado desde as patas até os ombros do cão. O peso da maioria desses pets chega a ser de 10 kg. Já cães de médio porte possuem tamanho aproximado de 60 cm, pesando entre 15 e 25 kg, cães acima de 60 cm e pesando mais de 25 Kg são considerados cães de grande porte.</p>
      </div>  
    </div>

    <div class="form-row">
      <div class="form-group col-md-4">
          <label for="idade">Idade do animal <strong  class="text-danger">(*)</strong></label>
          <input type="text" class="form-control @error('idade') is-invalid @enderror" name="idade" value="{{ old('idade') ?? '' }}" maxlength="2" id="idade">
          @error('idade')
            <div class="text-danger">
              <small>{{ $message }}</small>
            </div>
          @enderror
      </div>
      <div class="form-group col-md-4">
        <label for="idadeEm">Idade em <strong class="text-danger">(*)</strong></label>
        <select class="form-control  @error('idadeEm') is-invalid @enderror" name="idadeEm" id="idadeEm">
          <option value="" selected="true">Selecione...</option>        
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
        <label for="procedencia">Origem do animal <strong class="text-danger">(*)</strong></label>
        <select class="form-control  @error('procedencia') is-invalid @enderror" name="procedencia" id="procedencia">
          <option value="" selected="true">Selecione...</option>        
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
        <select class="form-control" name="primeiraTentativa" id="primeiraTentativa">
          <option value="N" selected="true">Selecione...</option>        
          <option value="S" {{ old("primeiraTentativa") == "S" ? "selected": "" }}>Sim</option>
          <option value="N" {{ old("primeiraTentativa") == "N" ? "selected": "" }}>Não</option>
        </select>
      </div>
      <div class="form-group col-md-4">
        <label for="primeiraTentativaQuando">Quando</label>
        <input type="text" class="form-control @error('primeiraTentativaQuando') is-invalid @enderror" name="primeiraTentativaQuando" id="primeiraTentativaQuando" value="{{ old('primeiraTentativaQuando') ?? '' }}" autocomplete="off">
        @error('primeiraTentativaQuando')
        <div class="text-danger">
          <small>{{ $message }}</small>
        </div>
        @enderror 
      </div>
      <div class="form-group col-md-4">
        <label for="primeiraTentativaHora">Horas</label>  
        <input type="text" class="form-control @error('primeiraTentativaHora') is-invalid @enderror" name="primeiraTentativaHora" id="primeiraTentativaHora" value="{{ old('primeiraTentativaHora') ?? '' }}"  maxlength="5">
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
        <select class="form-control" name="segundaTentativa" id="segundaTentativa">
          <option value="N" selected="true">Selecione...</option>        
          <option value="S" {{ old("segundaTentativa") == "S" ? "selected": "" }}>Sim</option>
          <option value="N" {{ old("segundaTentativa") == "N" ? "selected": "" }}>Não</option>
        </select>
      </div>
      <div class="form-group col-md-4">
        <label for="segundaTentativaQuando">Quando</label>
        <input type="text" class="form-control @error('segundaTentativaQuando') is-invalid @enderror" name="segundaTentativaQuando" id="segundaTentativaQuando" value="{{ old('segundaTentativaQuando') ?? '' }}" autocomplete="off"> 
        @error('segundaTentativaQuando')
          <div class="text-danger">
            <small>{{ $message }}</small>
          </div>
        @enderror 
      </div>
      <div class="form-group col-md-4">
        <label for="segundaTentativaHora">Horas</label>  
        <input type="text" class="form-control @error('segundaTentativaHora') is-invalid @enderror" name="segundaTentativaHora" id="segundaTentativaHora" value="{{ old('segundaTentativaHora') ?? '' }}" maxlength="5">
        @error('segundaTentativaHora')
        <div class="text-danger">
          <small>{{ $message }}</small>
        </div>
        @enderror
      </div>      
    </div>

    <div class="form-group">
      <label for="nota">Anotações do Agendamento </label>
      <textarea class="form-control" name="nota" id="nota" rows="5">{{ old('nota') ?? '' }}</textarea>
    </div>

    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="agendaQuando">Data de Agendamento</label>
        <input type="text" class="form-control @error('agendaQuando') is-invalid @enderror" name="agendaQuando" id="agendaQuando" value="{{ old('agendaQuando') ?? '' }}" autocomplete="off">
        @error('agendaQuando')
        <div class="text-danger">
          <small>{{ $message }}</small>
        </div>
        @enderror   
      </div>
      <div class="form-group col-md-6">
        <label for="agendaTurno">Turno do Agendamento</label>
        <select class="form-control" name="agendaTurno" id="agendaTurno">
          <option value="nenhum" selected="true">Selecione...</option>        
          <option value="manha" {{ old("agendaTurno") == "manha" ? "selected": "" }}>Manhã</option>
          <option value="tarde" {{ old("agendaTurno") == "tarde" ? "selected": "" }}>Tarde</option>
          <option value="nenhum" {{ old("agendaTurno") == "nenhum" ? "selected": "" }}>Nenhum</option>
        </select>  
      </div>
    </div>

    <div class="form-group">
      <label for="motivoNaoAgendado">Motivo do Não Agendamento</label>
      <textarea class="form-control" name="motivoNaoAgendado" id="motivoNaoAgendado" rows="5">{{ old('motivoNaoAgendado') ?? '' }}</textarea>
    </div>

    <div class="form-group py-2">
      <div class="container bg-warning text-dark">
        <p class="text-center"><strong>STATUS DO PEDIDO</strong></p>
      </div>
    </div>

    <div class="form-group">
      <label for="situacao_id">Situação do Pedido <strong  class="text-danger">(*)</strong></label>
      <select class="form-control" id="situacao_id" name="situacao_id">
          <option value="1" selected="true">&rarr; Em análise do pedido para agendamento</option> 
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
     
    <button type="submit" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Cadastrar Pedido</button>
  </form>
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
