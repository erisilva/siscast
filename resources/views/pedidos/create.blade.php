@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('pedidos.index') }}">Lista de Pedidos</a></li>
      <li class="breadcrumb-item active" aria-current="page">Novo Registro</li>
    </ol>
  </nav>
</div>
<div class="container">
  <form method="POST" action="{{ route('pedidos.store') }}">
    @csrf
    <div class="form-group py-1">
      <div class="container bg-warning text-dark">
        <p class="text-center"><strong>Informações Sobre o Tutor</strong></p>
      </div>
    </div>
    <div class="form-group">
      <div class="alert alert-info" role="alert">
        <p class="text-center">Campos marcado com * <strong>(asterístico)</strong> devem ser preenchidos obrigatoriamente.</p>
      </div>  
    </div>
    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="name">Nome <strong  class="text-danger">(*)</strong></label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? '' }}" maxlength="180">
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
      <div class="form-group col-md-3">
        <label for="nascimento">Nascimento <strong  class="text-danger">(*)</strong></label>
        <input type="text" class="form-control @error('nascimento') is-invalid @enderror" name="nascimento" id="nascimento" value="{{ old('description') ?? '' }}">
        @error('nascimento')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
      <div class="form-group col-md-3">
        <label for="cpf">CPF <strong  class="text-danger">(*)</strong></label>
        <input type="text" class="form-control @error('cpf') is-invalid @enderror" name="cpf" id="cpf" value="{{ old('description') ?? '' }}" maxlength="14">
        @error('cpf')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="email">E-mail <strong  class="text-danger">(*)</strong></label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ?? '' }}" maxlength="150">
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
      <div class="form-group col-md-4">
        <label for="celular">Celular <strong  class="text-danger">(*)</strong></label>
        <input type="text" class="form-control @error('celular') is-invalid @enderror" name="celular" id="celular" value="{{ old('description') ?? '' }}" maxlength="15">
        @error('celular')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror  
      </div>
      <div class="form-group col-md-4">
        <label for="telefone">Telefone</label>
        <input type="text" class="form-control @error('telefone') is-invalid @enderror" name="telefone" id="telefone" value="{{ old('description') ?? '' }}" maxlength="15">
        @error('telefone')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror 
      </div>      
    </div>

    <div class="form-row">
      <div class="form-group col-md-2">
        <label for="cep">CEP <strong class="text-danger">(*)</strong></label>  
        <input type="text" class="form-control @error('cep') is-invalid @enderror" name="cep" id="cep" value="{{ old('cep') ?? '' }}">
        @error('cep')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
      <div class="form-group col-md-5">  
        <label for="logradouro">Logradouro <strong class="text-danger">(*)</strong></label>  
        <input type="text" class="form-control  @error('logradouro') is-invalid @enderror" name="logradouro" id="logradouro" value="{{ old('logradouro') ?? '' }}">
        @error('logradouro')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror 
      </div> 
      <div class="form-group col-md-2">  
        <label for="numero">Nº <strong class="text-danger">(*)</strong></label>  
        <input type="text" class="form-control @error('numero') is-invalid @enderror" name="numero" id="numero" value="{{ old('numero') ?? '' }}">
        @error('numero')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror    
      </div>
      <div class="form-group col-md-3">  
        <label for="complemento">Complemento</label>  
        <input type="text" class="form-control" name="complemento" id="complemento" value="{{ old('complemento') ?? '' }}">
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="bairro">Bairro <strong class="text-danger">(*)</strong></label>  
        <input type="text" class="form-control  @error('bairro') is-invalid @enderror" name="bairro" id="bairro" value="{{ old('bairro') ?? '' }}">
        @error('bairro')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
      <div class="form-group col-md-6">  
        <label for="cidade">Cidade <strong class="text-danger">(*)</strong></label>  
        <input type="text" class="form-control @error('cidade') is-invalid @enderror" name="cidade" id="cidade" value="{{ old('cidade') ?? '' }}">
        @error('cidade')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div> 
      <div class="form-group col-md-2">  
        <label for="uf">UF <strong class="text-danger">(*)</strong></label>  
        <input type="text" class="form-control @error('uf') is-invalid @enderror" name="uf" id="uf" value="{{ old('uf') ?? '' }}">
        @error('uf')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-4">
        <label for="cns">Cartão Nacional de Saúde <strong class="text-danger">(*)</strong></label>
        <input type="password" class="form-control @error('cns') is-invalid @enderror" name="cns" id="cns" value="{{ old('cns') ?? '' }}" maxlength="20">
        @error('cns')
            <div class="invalid-feedback">{{ $message }}</div>
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
          <option value="S">Não</option>
          <option value="N">Sim</option>
        </select>
        @error('beneficio')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror 
      </div>
      <div class="form-group col-md-4">  
        <label for="beneficioQual">Se sim, qual(is)?</label>  
        <input type="text" class="form-control" name="beneficioQual" id="beneficioQual" value="{{ old('beneficioQual') ?? '' }}" maxlength="100" >
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
        <input type="text" class="form-control @error('name') is-invalid @enderror" name="nomeAnimal" value="{{ old('nomeAnimal') ?? '' }}" maxlength="180">
        @error('nomeAnimal')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
      <div class="form-group col-md-4">
        <label for="especie">Espécie<strong class="text-danger">(*)</strong></label>
        <select class="form-control  @error('especie') is-invalid @enderror" name="especie" id="especie">
          <option value="" selected="true">Selecione...</option>        
          <option value="felino">Felino</option>
          <option value="canino">Canino</option>
        </select>
        @error('especie')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror         
      </div>
      <div class="form-group col-md-4">
        <label for="genero">Gênero<strong class="text-danger">(*)</strong></label>
        <select class="form-control  @error('genero') is-invalid @enderror" name="genero" id="genero">
          <option value="" selected="true">Selecione...</option>        
          <option value="M">Macho</option>
          <option value="F">Fêmea</option>
        </select>
        @error('genero')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror  
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="raca_id">Raça do Animal</label>
        <select class="form-control @error('raca_id') is-invalid @enderror" name="raca_id" id="raca_id">
          <option value="" selected="true">Selecione ...</option>        
          @foreach($racas as $raca)
          <option value="{{$raca->id}}">{{$raca->descricao}}</option>
          @endforeach
        </select>
        @error('raca_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
      <div class="form-group col-md-4">
        <label for="porte">Porte(tamanho)<strong class="text-danger">(*)</strong></label>
        <select class="form-control  @error('porte') is-invalid @enderror" name="porte" id="porte">
          <option value="" selected="true">Selecione...</option>        
          <option value="pequeno">Pequeno</option>
          <option value="medio">Médio</option>
          <option value="grande">Grande</option>
        </select>
        @error('porte')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror     
      </div>
      <div class="form-group col-md-4">
        <label for="cor">Cor(es) do animal <strong  class="text-danger">(*)</strong></label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" name="cor" value="{{ old('cor') ?? '' }}" maxlength="80">
        @error('cor')
            <div class="invalid-feedback">{{ $message }}</div>
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
          <input type="text" class="form-control @error('name') is-invalid @enderror" name="idade" value="{{ old('idade') ?? '' }}" maxlength="2" id="idade">
          @error('idade')
              <div class="invalid-feedback">{{ $message }}</div>
          @enderror
      </div>
      <div class="form-group col-md-4">
        <label for="idadeEm">Idade em <strong class="text-danger">(*)</strong></label>
        <select class="form-control  @error('idadeEm') is-invalid @enderror" name="idadeEm" id="idadeEm">
          <option value="" selected="true">Selecione...</option>        
          <option value="mes">Mês(es)</option>
          <option value="ano">Ano(s)</option>
        </select>
        @error('idadeEm')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror   
      </div>
      <div class="form-group col-md-4">
        <label for="procedencia">Origem do animal <strong class="text-danger">(*)</strong></label>
        <select class="form-control  @error('procedencia') is-invalid @enderror" name="procedencia" id="procedencia">
          <option value="" selected="true">Selecione...</option>        
          <option value="vive na rua / comunitario">Vive na rua ou comunitário</option>
          <option value="resgatado">Resgatado</option>
          <option value="adotado">Adotado</option>
          <option value="comprado">Comprado</option>
          <option value="ONG">ONG</option>
          <option value="CCZ">CCZ</option>
        </select>
        @error('procedencia')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror   
      </div>
    </div>

    <div class="form-group py-2">
      <div class="container bg-warning text-dark">
        <p class="text-center"><strong>Agendamento do Pedido (Opcional)</strong></p>
      </div>
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

      $('#nascimento').datepicker({
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
        mask: ['99.999-999'],
        keepStatic: true
      });

      $("#celular").inputmask({
        mask: ['(99) 99999-9999'],
        keepStatic: true
      });

      $("#telefone").inputmask({
        mask: ['(99) 9999-9999'],
        keepStatic: true
      });

      $("#idade").inputmask({
        mask: ['99'],
        keepStatic: true
      });

      $("#cep").blur(function () {
          var cep = $(this).val().replace(/\D/g, '');
          if (cep != "") {
              var validacep = /^[0-9]{8}$/;
              if(validacep.test(cep)) {
                  $("#logradouro").val("...");
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
                              $("#logradouro").val(json[0]['rua']);
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

  });
</script>

@endsection
