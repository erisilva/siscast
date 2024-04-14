<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style media="screen">
            @page {
                margin: 0cm 0cm;
            }

            body {
                margin-top: 2cm;
                margin-left: 1cm;
                margin-right: 1cm;
                margin-bottom: 2cm;
            }

            header {
                position: fixed;
                top: 0cm;
                left: 0cm;
                right: 0cm;
                height: 2cm;
                background-color: rgb(179, 179, 179);
                color: white;
                text-align: center;
                line-height: 1.5cm;
                font-family: Helvetica, Arial, sans-serif;
            }

            /** Define the footer rules **/
            footer {
                position: fixed; 
                bottom: 0cm; 
                left: 0cm; 
                right: 0cm;
                height: 2cm;
                background-color: rgb(179, 179, 179);
                color: white;
                text-align: center;
                line-height: 1.5cm;
            }

            footer .page-number:after { content: counter(page); }

            .bordered td {
                border-color: #959594;
                border-style: solid;
                border-width: 1px;
            }

            table {
                border-collapse: collapse;
            }

            .page_break { page-break-before: always; }
    </style>
</head>
    <body>
        <header>
            Pedidos
        </header>

        <footer>
          <span>{{ date('d/m/Y H:i:s') }} - </span><span class="page-number">Página </span>         
        </footer>

        <main>
            @foreach($dataset as $row)
            <table  class="bordered" width="100%">

              <tbody>
                

                <tr>
                    <td colspan="2">
                        <label for="codigo"><strong>Código</strong></label>
                        <div id="codigo">{{ $row->codigo }}</div>
                    </td>
                    <td colspan="2">
                        <label for="ano"><strong>Ano</strong></label>
                        <div id="ano">{{ $row->ano }}</div>
                    </td>
                    <td colspan="2">
                        <label for="datacadastro"><strong>Data Cadastro</strong></label>
                        <div id="datacadastro">{{ date('d/m/Y', strtotime($row->created_at)) }}</div>
                    </td>
                    <td colspan="6">
                        <label for="situacao"><strong>Situação</strong></label>
                        <div id="situacao">{{ $row->situacao->nome }}</div>
                    </td>
                </tr>

                <tr>
                    <td colspan="6">
                        <label for="nome"><strong>Nome</strong></label>
                        <div id="nome">{{ $row->nome }}</div>
                    </td>
                    <td colspan="3">
                        <label for="tel"><strong>Nascimento</strong></label>
                        <div id="tel">{{ date('d/m/Y', strtotime($row->nascimento)) }}</div>
                    </td>
                    </td>
                    <td colspan="3">
                        <label for="cpf"><strong>CPF</strong></label>
                        <div id="cpf">{{ Str::substr($row->cpf, 0, 3) . '.' . Str::substr($row->cpf, 3, 3) . '.' . Str::substr($row->cpf, 6, 3) . '-' . Str::substr($row->cpf, 9, 2) }}</div>
                    </td>                    
                </tr>

                <tr>
                    <td colspan="6">
                        <label for="email"><strong>E-mail</strong></label>
                        <div id="email">{{ $row->email }}</div>
                    </td>
                    <td colspan="2">
                        <label for="cel"><strong>CEL</strong></label>
                        <div id="cel">{{ $row->cel }}</div>
                    </td>
                    <td colspan="2">
                        <label for="tel"><strong>TEL</strong></label>
                        <div id="tel">{{ $row->tel }}</div>
                    </td>
                    <td colspan="2">
                        <label for="cep"><strong>CEP</strong></label>
                        <div id="cep">{{ substr($row->cep, 0, 2) . '.' . substr($row->cep, 2, 3) . '-' . substr($row->cep, 5, 2) }}</div>
                    </td>
                    </td>
                </tr>

                <tr>
                    <td colspan="4">
                        <label for="logradouro"><strong>Logradouro</strong></label>
                        <div id="logradouro">{{ $row->logradouro }}</div>
                    </td>
                    <td colspan="2">
                        <label for="numero"><strong>Nº</strong></label>
                        <div id="numero">{{ $row->numero }}</div>
                    </td> 
                    <td colspan="2">
                        <label for="complemento"><strong>Complemento</strong></label>
                        <div id="complemento">{{ $row->complemento }}</div>
                    </td>
                    <td colspan="4">
                        <label for="bairro"><strong>Bairro</strong></label>
                        <div id="bairro">{{ $row->bairro }}</div>
                    </td>
                </tr>

                <tr>
                    
                    <td colspan="6">
                        <label for="cidade"><strong>Cidade</strong></label>
                        <div id="cidade">{{ $row->cidade }}</div>
                    </td>
                    <td colspan="3">
                        <label for="uf"><strong>UF</strong></label>
                        <div id="uf">{{ $row->uf }}</div>
                    </td>

                    <td colspan="3">
                        <label for="cns"><strong>CNS</strong></label>
                        <div id="cns">{{ $row->cns }}</div>
                    </td>                    
                </tr>

                <tr>
                    <td colspan="2">
                        <label for="beneficio"><strong>Possui Benéficio</strong></label>
                        <div id="beneficio">{{ $row->beneficio }}</div>
                    </td>
                    <td colspan="10">
                        <label for="beneficioQual"><strong>Qual?</strong></label>
                        <div id="beneficioQual">{{ $row->beneficioQual }}</div>
                    </td>
                </tr>

                <tr>
                    <td colspan="3">
                        <label for="nomeAnimal"><strong>Nome do Animal</strong></label>
                        <div id="nomeAnimal">{{ $row->nomeAnimal }}</div>
                    </td>
                    <td colspan="2">
                        <label for="especie"><strong>Espécie</strong></label>
                        <div id="especie">{{ $row->especie }}</div>
                    </td>
                    <td colspan="2">
                        <label for="genero"><strong>Sexo</strong></label>
                        <div id="genero">{{ $row->genero == 'M' ? 'Macho' : 'Fêmea' }}</div>
                    </td>
                    <td colspan="2">
                        <label for="porte"><strong>Porte</strong></label>
                        <div id="porte">{{ $row->porte == 'pequeno' ? 'Pequeno' : ($row->porte == 'medio' ? 'Médio' : 'Grande') }}</div>
                    </td>
                    <td colspan="3">
                        <label for="idade"><strong>Idade</strong></label>
                        <div id="idade">{{ $row->idade . ' ' . ($row->idadeEm == 'mes' ? 'Mes(es)' : 'Ano(s)') }}</div>
                    </td>
                </tr>

                <tr>                    
                    <td colspan="4">
                        <label for="raca"><strong>Raça</strong></label>
                        <div id="raca">{{ $row->raca->nome }}</div>
                    </td>
                    <td colspan="4">
                        <label for="cor"><strong>Cor</strong></label>
                        <div id="cor">{{ $row->cor }}</div>
                    </td>
                    <td colspan="4">
                        <label for="procedencia"><strong>Origem</strong></label>
                        <div id="procedencia">{{ $row->procedencia }}</div>
                    </td>
                </tr>

                <tr>
                    <td colspan="12">
                        <label for="observacao"><strong>Observação</strong></label>
                        <div id="observacao">{{ $row->nota }}</div>
                    </td>
                </tr>
                
              </tbody>
            </table>
            <br>
            <table  class="bordered" width="100%">
                <tbody>
                    <tr>                    
                        <td colspan="2">
                            <label for="primeiraTentativa"><strong>Primeira Tentativa</strong></label>
                            <div id="primeiraTentativa">{{ ($row->primeiraTentativa == 'S') ? 'Sim' : 'Não' }}</div>
                        </td>
                        <td colspan="2">
                            <label for="primeiraTentativaQuando"><strong>Data</strong></label>
                            <div id="primeiraTentativaQuando">{{ $row->primeiraTentativaQuando ? date('d/m/Y', strtotime($row->primeiraTentativaQuando)) : '-'}}</div>
                        </td>
                        <td colspan="2">
                            <label for="primeiraTentativaHora"><strong>Hora</strong></label>
                            <div id="primeiraTentativaHora">{{ $row->primeiraTentativaHora }}</div>
                        </td>
                        <td colspan="2">
                            <label for="segundaTentativa"><strong>Segunda Tentativa</strong></label>
                            <div id="segundaTentativa">{{ ($row->segundaTentativa == 'S') ? 'Sim' : 'Não' }}</div>
                        </td>
                        <td colspan="2">
                            <label for="segundaTentativaQuando"><strong>Data</strong></label>
                            <div id="segundaTentativaQuando">{{ $row->segundaTentativaQuando ? date('d/m/Y', strtotime($row->segundaTentativaQuando)) : '-'}}</div>
                        </td>
                        <td colspan="2">
                            <label for="segundaTentativaHora"><strong>Hora</strong></label>
                            <div id="segundaTentativaHora">{{ $row->segundaTentativaHora }}</div>
                        </td>
                    </tr>
    
                    <tr>
                        <td colspan="12">
                            <label for="observacao"><strong>Observação</strong></label>
                            <div id="observacao">{{ $row->nota }}</div>
                        </td>
                    </tr>
                </tbody>

            </table>

            <br>
            <table  class="bordered" width="100%">
                <tbody>
                    <tr>                    
                        <td colspan="3">
                            <label for="agendaQuando"><strong>Data Agenda</strong></label>
                            <div id="agendaQuando">{{ $row->agendaQuando ? date('d/m/Y', strtotime($row->agendaQuando)) : '-'}}</div>
                        </td>
                        <td colspan="3">
                            <label for="agendaTurno"><strong>Turno</strong></label>
                            <div id="agendaTurno">{{ $row->agendaTurno == 'nenhum' ? 'Nenhum' : ($row->agendaTurno == 'manha' ? 'Manhã' : 'Tarde') }}</div>
                        </td>
                        <td colspan="6">
                            <label for="motivoNaoAgendado"><strong>Motivo do não agendamento</strong></label>
                            <div id="motivoNaoAgendado">{{ $row->motivoNaoAgendado }}</div>
                        </td>
                    </tr>
    
                    <tr>
                        <td colspan="12">
                            <label for="observacao"><strong>Notas</strong></label>
                            <div id="observacao">{{ $row->nota }}</div>
                        </td>
                    </tr>
                </tbody>

            </table>

            @if (!$loop->last)
            <div class="page_break"></div>
            @endif
            
            @endforeach
        </main>
    </body>
</html>