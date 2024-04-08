@extends('layouts.app')

@section('title', 'Pedidos')

@section('css-header')
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
@endsection

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
                    {{ __('Edit') }}
                </li>
            </ol>
        </nav>
    </div>

    <div class="container">
        <x-flash-message status='success' message='message' />

        <form method="POST" action="{{ route('pedidos.update', $pedido->id) }}">
            @csrf
            @method('PUT')
            <div class="row g-3">

                <div class="col-md-1">
                    <label for="codigo" class="form-label">Cód.</label>
                    <input type="text" class="form-control" name="codigo" id="codigo" value="{{ $pedido->codigo }}"
                        maxlength="180" readonly disabled>
                </div>

                <div class="col-md-1">
                    <label for="ano" class="form-label">Ano</label>
                    <input type="text" class="form-control" name="ano" id="ano" value="{{ $pedido->ano }}"
                        maxlength="180" readonly disabled>
                </div>

                <div class="col-md-2">
                    <label for="datacadastro" class="form-label">Data</label>
                    <input type="text" class="form-control" name="datacadastro" id="datacadastro"
                        value="{{ date('d/m/Y', strtotime($pedido->created_at)) }}" maxlength="180" readonly disabled>
                </div>

                <div class="col-md-2">
                    <label for="horacadastro" class="form-label">Hora</label>
                    <input type="text" class="form-control" name="horacadastro" id="horacadastro"
                        value="{{ date('h:m', strtotime($pedido->created_at)) }}" maxlength="180" readonly disabled>
                </div>

                <div class="col-md-6">
                    <label for="situacao_id" class="form-label">Raça <strong class="text-danger">(*)</strong></label>
                    <select class="form-select" id="situacao_id" name="situacao_id">
                        <option value="{{ $pedido->situacao_id }}" selected="true">
                            &rarr; {{ $pedido->situacao->nome }}
                        </option>
                        @foreach ($situacaos as $situacao)
                            <option value="{{ $situacao->id }}" @selected(old('situacao_id') == $situacao->id)>
                                {{ $situacao->nome }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('situacao_id'))
                        <div class="text-danger">
                            {{ $errors->first('situacao_id') }}
                        </div>
                    @endif
                </div>


                <div class="col-md-5">
                    <label for="nome" class="form-label">{{ __('Name') }} <strong
                            class="text-danger">(*)</strong></label>
                    <input type="text" class="form-control @error('nome') is-invalid @enderror" name="nome"
                        id="nome" value="{{ old('cep') ?? $pedido->nome }}" maxlength="180">
                    @error('nome')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-2">
                    <label for="nascimento" class="form-label">Nascimento <strong class="text-danger">(*)</strong></label>
                    <input type="text" class="form-control @error('nascimento') is-invalid @enderror" name="nascimento"
                        id='nascimento'
                        value="{{ old('nascimento') ?? (isset($pedido->nascimento) ? date('d/m/Y', strtotime($pedido->nascimento)) : '') }}">
                    @error('nascimento')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-2">
                    <label for="cpf" class="form-label">CPF <strong class="text-danger">(*)</strong></label>
                    <input type="text" class="form-control @error('cpf') is-invalid @enderror" name="cpf"
                        id="cpf" value="{{ old('cpf') ?? $pedido->cpf }}">
                    @error('cpf')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label for="email" class="form-label">E-mail <strong class="text-danger">(*)</strong></label>
                    <input type="text" class="form-control @error('email') is-invalid @enderror" name="email"
                        id="email" value="{{ old('email') ?? $pedido->email }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-2">
                    <label for="cel" class="form-label">Celular <strong class="text-danger">(*)</strong></label>
                    <input type="text" class="form-control @error('cel') is-invalid @enderror" name="cel"
                        id="cel" value="{{ old('cel') ?? $pedido->cel }}" maxlength="20">
                    @error('cel')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-2">
                    <label for="tel" class="form-label">Telefone <strong
                            class="text-info">(Opcional)</strong></label>
                    <input type="text" class="form-control" name="tel" id="tel"
                        value="{{ old('tel') ?? $pedido->tel }}" maxlength="20">
                </div>

                <div class="col-md-2">
                    <label for="cep" class="form-label">CEP <strong class="text-danger">(*)</strong></label>
                    <input type="text" class="form-control @error('cep') is-invalid @enderror" name="cep"
                        id="cep" value="{{ old('cep') ?? $pedido->cep }}">
                    @error('cep')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="logradouro" class="form-label">Logradouro <strong
                            class="text-danger">(*)</strong></label>
                    <input type="text" class="form-control @error('logradouro') is-invalid @enderror"
                        name="logradouro" id="logradouro" value="{{ old('logradouro') ?? $pedido->logradouro }}"
                        maxlength="100">
                    @error('logradouro')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-2">
                    <label for="numero" class="form-label">Número <strong class="text-danger">(*)</strong></label>
                    <input type="text" class="form-control @error('numero') is-invalid @enderror" name="numero"
                        id="numero" value="{{ old('numero') ?? $pedido->numero }}" maxlength="10">
                    @error('numero')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="complemento" class="form-label">Complemento <strong
                            class="text-info">(Opcional)</strong></label>
                    <input type="text" class="form-control" name="complemento" id="complemento"
                        value="{{ old('complemento') ?? $pedido->complemento }}" maxlength="100">
                </div>

                <div class="col-md-3">
                    <label for="bairro" class="form-label">Bairro <strong class="text-danger">(*)</strong></label>
                    <input type="text" class="form-control @error('bairro') is-invalid @enderror" name="bairro"
                        id="bairro" value="{{ old('bairro') ?? $pedido->bairro }}" maxlength="80">
                    @error('bairro')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label for="cidade" class="form-label">Cidade <strong class="text-danger">(*)</strong></label>
                    <input type="text" class="form-control @error('cidade') is-invalid @enderror" name="cidade"
                        id="cidade" value="{{ old('cidade') ?? $pedido->cidade }}" maxlength="80">
                    @error('cidade')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-2">
                    <label for="uf" class="form-label">UF <strong class="text-danger">(*)</strong></label>
                    <input type="text" class="form-control @error('uf') is-invalid @enderror" name="uf"
                        id="uf" value="{{ old('uf') ?? $pedido->uf }}" maxlength="2">
                    @error('uf')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label for="cns" class="form-label">Cartão Nacional de Saúde <strong
                            class="text-info">(Opcional)</strong></label>
                    <input type="text" class="form-control" name="cns" value="{{ old('cns') ?? $pedido->cns }}"
                        id="cns" maxlength="15">
                </div>

                <div class="col-md-2">
                    <label for="beneficio" class="form-label">Possui Benefício <strong
                            class="text-danger">(*)</strong></label>
                    <select class="form-select" id="beneficio" name="beneficio">
                        <option value="{{ $pedido->beneficio }}" selected="true">
                            &rarr; {{ $pedido->beneficio == 'S' ? 'Sim' : 'Não' }}
                        </option>
                        <option value="S" @selected(old('beneficio') == 'S')>Sim</option>
                        <option value="N" @selected(old('beneficio') == 'N')>Não</option>
                    </select>
                    @if ($errors->has('beneficio'))
                        <div class="text-danger">
                            {{ $errors->first('beneficio') }}
                        </div>
                    @endif
                </div>

                <div class="col-md-7">
                    <label for="beneficioQual" class="form-label">Se sim, qual(is)? <strong
                            class="text-info">(Opcional)</strong></label>
                    <input type="text" class="form-control" name="beneficioQual" id="beneficioQual"
                        value="{{ old('beneficioQual') ?? $pedido->beneficioQual }}" maxlength="100">
                </div>

                <div class="co-12">
                    <p class="text-center bg-primary text-white">
                        <strong>Informações do Animal</strong>
                    </p>
                </div>

                <div class="col-md-3">
                    <label for="nomeAnimal" class="form-label">Nome do Animal <strong
                            class="text-danger">(*)</strong></label>
                    <input type="text" class="form-control @error('nomeAnimal') is-invalid @enderror"
                        name="nomeAnimal" id="nomeAnimal" value="{{ old('nomeAnimal') ?? $pedido->nomeAnimal }}"
                        maxlength="100">
                    @error('nomeAnimal')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-2">
                    <label for="genero" class="form-label">Sexo <strong class="text-danger">(*)</strong></label>
                    <select class="form-select" id="genero" name="genero">
                        <option value="{{ $pedido->genero }}" selected="true">
                            &rarr; {{ $pedido->genero == 'M' ? 'Macho' : 'Fêmea' }}
                        </option>
                        <option value="M" @selected(old('genero') == 'M')>Macho</option>
                        <option value="F" @selected(old('genero') == 'F')>Fêmea</option>
                    </select>
                    @if ($errors->has('genero'))
                        <div class="text-danger">
                            {{ $errors->first('genero') }}
                        </div>
                    @endif
                </div>

                <div class="col-md-2">
                    <label for="porte" class="form-label">Porte <strong class="text-danger">(*)</strong></label>
                    <select class="form-select" id="porte" name="porte">
                        <option value="{{ $pedido->porte }}" selected="true">
                            &rarr;
                            {{ $pedido->porte == 'pequeno' ? 'Pequeno' : ($pedido->porte == 'medio' ? 'Médido' : 'Grande') }}
                        </option>
                        <option value="pequeno" @selected(old('porte') == 'pequeno')>Pequeno</option>
                        <option value="medio" @selected(old('porte') == 'medio')>Médio</option>
                        <option value="grande" @selected(old('porte') == 'grande')>Grande</option>
                    </select>
                    @if ($errors->has('porte'))
                        <div class="text-danger">
                            {{ $errors->first('porte') }}
                        </div>
                    @endif
                </div>

                <div class="col-md-3">
                    <label for="idade" class="form-label">Idade do Animal <strong class="text-danger">(*)</strong>
                    </label>
                    <input type="number" class="form-control @error('idade') is-invalid @enderror" name="idade"
                        id="idade" value="{{ old('idade') ?? $pedido->idade }}">
                    @error('idade')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-2">
                    <label for="idadeEm" class="form-label">Idade em <strong class="text-danger">(*)</strong></label>
                    <select class="form-select" id="idadeEm" name="idadeEm">
                        <option value="{{ $pedido->idadeEm }}" selected="true">
                            &rarr; {{ $pedido->idadeEm == 'ano' ? 'Ano' : 'Meses' }}
                        </option>
                        <option value="mes" @selected(old('idadeEm') == 'mes')>Anos</option>
                        <option value="ano" @selected(old('idadeEm') == 'ano')>Meses</option>
                    </select>
                    @if ($errors->has('idadeEm'))
                        <div class="text-danger">
                            {{ $errors->first('idadeEm') }}
                        </div>
                    @endif
                </div>

                <div class="col-md-3">
                    <label for="cor" class="form-label">Cor(es) do Animal <strong
                            class="text-danger">(*)</strong></label>
                    <input type="text" class="form-control @error('cor') is-invalid @enderror" name="cor"
                        id="cor" value="{{ old('cor') ?? $pedido->cor }}" maxlength="80">
                    @error('cor')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label for="especie" class="form-label">Espécie <strong class="text-danger">(*)</strong></label>
                    <select class="form-select" id="especie" name="especie">
                        <option value="{{ $pedido->especie }}" selected="true">
                            &rarr; {{ $pedido->especie == 'felino' ? 'Felino' : 'Canino' }}
                        </option>
                        <option value="felino" @selected(old('especie') == 'felino')>Felino</option>
                        <option value="canino" @selected(old('especie') == 'canino')>Canino</option>
                    </select>
                    @if ($errors->has('especie'))
                        <div class="text-danger">
                            {{ $errors->first('especie') }}
                        </div>
                    @endif
                </div>

                <div class="col-md-3">
                    <label for="raca_id" class="form-label">Raça <strong class="text-danger">(*)</strong></label>
                    <select class="form-select" id="raca_id" name="raca_id">
                        <option value="{{ $pedido->raca_id }}" selected="true">
                            &rarr; {{ $pedido->raca->nome }}
                        </option>
                        @foreach ($racas as $raca)
                            <option value="{{ $raca->id }}" @selected(old('raca_id') == $raca->id)>
                                {{ $raca->nome }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('raca_id'))
                        <div class="text-danger">
                            {{ $errors->first('raca_id') }}
                        </div>
                    @endif
                </div>

                <div class="col-md-3">
                    <label for="procedencia" class="form-label">Origem <strong
                            class="text-danger">(*)</strong></label>
                    <select class="form-select" id="procedencia" name="procedencia">
                        <option value="{{ $pedido->procedencia }}" selected="true">
                            &rarr; {{ $pedido->procedencia }}
                        </option>
                        <option value="Vive na rua / comunitário" @selected(old('procedencia') == 'Vive na rua / comunitário')>Vive na rua / comunitário
                        </option>
                        <option value="Resgatado" @selected(old('procedencia') == 'Resgatado')>Resgatado</option>
                        <option value="Adotado" @selected(old('procedencia') == 'Adotado')>Adotado</option>
                        <option value="Comprado" @selected(old('Comprado') == 'canino')>Comprado</option>
                        <option value="ONG" @selected(old('procedencia') == 'ONG')>ONG</option>
                    </select>
                    @if ($errors->has('procedencia'))
                        <div class="text-danger">
                            {{ $errors->first('procedencia') }}
                        </div>
                    @endif
                </div>

                <div class="co-12">
                    <p class="text-center bg-primary text-white">
                        <strong>Agendamento</strong>
                    </p>
                </div>

                <div class="col-md-4">
                    <label for="primeiraTentativa" class="form-label">Primeira Tentativa <strong
                            class="text-danger">(*)</strong></label>
                    <select class="form-select" id="primeiraTentativa" name="primeiraTentativa">
                        <option value="{{ $pedido->primeiraTentativa }}" selected="true">
                            &rarr; {{ $pedido->primeiraTentativa == 'S' ? 'Sim' : 'Não' }}
                        </option>
                        <option value="N" @selected(old('primeiraTentativa') == 'N')>Não</option>
                        <option value="S" @selected(old('primeiraTentativa') == 'S')>Sim</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="primeiraTentativaQuando" class="form-label">Data <strong
                            class="text-info">(Opcional)</strong></label>
                    <input type="text" class="form-control" name="primeiraTentativaQuando"
                        id="primeiraTentativaQuando"
                        value="{{ old('primeiraTentativaQuando') ?? (isset($pedido->primeiraTentativaQuando) ? date('d/m/Y', strtotime($pedido->primeiraTentativaQuando)) : '') }}">
                </div>

                <div class="col-md-4">
                    <label for="primeiraTentativaHora" class="form-label">Hora <strong
                            class="text-info">(Opcional)</strong></label>
                    <input type="text" class="form-control" name="primeiraTentativaHora" id="primeiraTentativaHora"
                        value="{{ old('primeiraTentativaHora') ?? $pedido->primeiraTentativaHora }}" maxlength="5">
                </div>

                <div class="col-md-4">
                    <label for="segundaTentativa" class="form-label">Segunda Tentativa <strong
                            class="text-danger">(*)</strong></label>
                    <select class="form-select" id="segundaTentativa" name="segundaTentativa">
                        <option value="{{ $pedido->segundaTentativa }}" selected="true">
                            &rarr; {{ $pedido->segundaTentativa == 'S' ? 'Sim' : 'Não' }}
                        </option>
                        <option value="N" @selected(old('segundaTentativa') == 'N')>Não</option>
                        <option value="S" @selected(old('segundaTentativa') == 'S')>Sim</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="segundaTentativaQuando" class="form-label">Data <strong
                            class="text-info">(Opcional)</strong></label>
                    <input type="text" class="form-control" name="segundaTentativaQuando" id="segundaTentativaQuando"
                        value="{{ old('segundaTentativaQuando') ?? (isset($pedido->segundaTentativaQuando) ? date('d/m/Y', strtotime($pedido->segundaTentativaQuando)) : '') }}">
                </div>

                <div class="col-md-4">
                    <label for="segundaTentativaHora" class="form-label">Hora <strong
                            class="text-info">(Opcional)</strong></label>
                    <input type="text" class="form-control" name="segundaTentativaHora" id="segundaTentativaHora"
                        value="{{ old('segundaTentativaHora') ?? $pedido->segundaTentativaHora }}" maxlength="5">
                </div>

                <div class="col-12">
                    <label for="nota">Notas</label>
                    <textarea class="form-control" name="nota" id="nota" rows="3">{{ old('nota') ?? $pedido->nota }}</textarea>
                </div>

                <div class="col-md-4">
                    <label for="agendaQuando" class="form-label">Data Agendamento<strong
                            class="text-info">(Opcional)</strong></label>
                    <input type="text" class="form-control" name="agendaQuando" id="agendaQuando"
                        value="{{ old('agendaQuando') ?? (isset($pedido->agendaQuando) ? date('d/m/Y', strtotime($pedido->agendaQuando)) : '') }}"
                        maxlength="80">
                </div>

                <div class="col-md-4">
                    <label for="agendaTurno" class="form-label">Turno <strong class="text-danger">(*)</strong></label>
                    <select class="form-select" id="agendaTurno" name="agendaTurno">
                        <option value="{{ $pedido->agendaTurno }}" selected="true">
                            &rarr;
                            {{ $pedido->agendaTurno == 'nenhum' ? 'Nenhum' : ($pedido->agendaTurno == 'manha' ? 'Manhã' : 'Tarde') }}
                        </option>
                        <option value="nenhum" @selected(old('agendaTurno') == 'nenhum')>Nenhum</option>
                        <option value="manha" @selected(old('agendaTurno') == 'manha')>Manhã</option>
                        <option value="tarde" @selected(old('agendaTurno') == 'tarde')>Tarde</option>
                    </select>
                </div>

                <div class="col-12">
                    <label for="motivoNaoAgendado">Motivo do não agendamento</label>
                    <textarea class="form-control" name="motivoNaoAgendado" id="motivoNaoAgendado" rows="3">{{ old('motivoNaoAgendado') ?? $pedido->motivoNaoAgendado }}</textarea>
                </div>


                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <x-icon icon='pencil-square' />{{ __('Edit') }}
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="container py-4">
        <div class="float-sm-end">
            <a href="{{ route('pedidos.create') }}" class="btn btn-primary btn-lg" role="button">
                <x-icon icon='file-earmark' />
                {{ __('New') }}
            </a>
            <a href="{{ route('pedidos.index') }}" class="btn btn-secondary btn-lg" role="button">
                <x-icon icon='arrow-left-square' />
                {{ __('Back') }}
            </a>
        </div>
    </div>
@endsection


@section('script-footer')
    <script src="{{ asset('js/jquery-3.6.4.min.js') }}"></script>
    <script src="{{ asset('js/jquery.inputmask.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('locales/bootstrap-datepicker.pt-BR.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            $("#cel").inputmask({
                "mask": "(99) 99999-9999"
            });
            $("#tel").inputmask({
                "mask": "(99) 9999-9999"
            });
            $("#cep").inputmask({
                "mask": "99.999-999"
            });
            $("#cpf").inputmask({
                "mask": "999.999.999-99"
            });
            $('#nascimento').datepicker({
                format: "dd/mm/yyyy",
                todayBtn: "linked",
                clearBtn: true,
                language: "pt-BR",
                autoclose: true,
                todayHighlight: true
            });
            $('#primeiraTentativaQuando').datepicker({
                format: "dd/mm/yyyy",
                todayBtn: "linked",
                clearBtn: true,
                language: "pt-BR",
                autoclose: true,
                todayHighlight: true
            });
            $("#primeiraTentativaHora").inputmask({
                "mask": "99:99"
            });
            $('#segundaTentativaQuando').datepicker({
                format: "dd/mm/yyyy",
                todayBtn: "linked",
                clearBtn: true,
                language: "pt-BR",
                autoclose: true,
                todayHighlight: true
            });
            $("#segundaTentativaHora").inputmask({
                "mask": "99:99"
            });
            $('#agendaQuando').datepicker({
                format: "dd/mm/yyyy",
                todayBtn: "linked",
                clearBtn: true,
                language: "pt-BR",
                autoclose: true,
                todayHighlight: true
            });

            function limpa_formulário_cep() {
                // Limpa valores do formulário de cep.
                $("#rua").val("");
                $("#bairro").val("");
                $("#cidade").val("");
                $("#uf").val("");
                $("#ibge").val("");
            }

            //Quando o campo cep perde o foco.
            $("#cep").blur(function() {

                //Nova variável "cep" somente com dígitos.
                var cep = $(this).val().replace(/\D/g, '');

                //Verifica se campo cep possui valor informado.
                if (cep != "") {

                    //Expressão regular para validar o CEP.
                    var validacep = /^[0-9]{8}$/;

                    //Valida o formato do CEP.
                    if (validacep.test(cep)) {

                        //Preenche os campos com "..." enquanto consulta webservice.
                        $("#logradouro").val("...");
                        $("#bairro").val("...");
                        $("#cidade").val("...");
                        $("#uf").val("...");

                        //Consulta o webservice viacep.com.br/
                        $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function(dados) {

                            if (!("erro" in dados)) {
                                //Atualiza os campos com os valores da consulta.
                                $("#logradouro").val(dados.logradouro);
                                $("#bairro").val(dados.bairro);
                                $("#cidade").val(dados.localidade);
                                $("#uf").val(dados.uf);
                            } //end if.
                            else {
                                //CEP pesquisado não foi encontrado.
                                limpa_formulário_cep();
                            }
                        });
                    } //end if.
                    else {
                        //cep é inválido.
                        limpa_formulário_cep();
                    }
                } //end if.
                else {
                    //cep sem valor, limpa formulário.
                    limpa_formulário_cep();
                }
            });
        });
    </script>

@endsection
