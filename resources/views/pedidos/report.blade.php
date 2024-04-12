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
                    <td colspan="4">
                        <label for="nome"><strong>Nome</strong></label>
                        <div id="nome">{{ $row->nome }}</div>
                    </td>
                    <td colspan="2">
                        <label for="tel"><strong>Nascimento</strong></label>
                        <div id="tel">{{ date('d/m/Y', strtotime($row->nascimento)) }}</div>
                    </td>
                    </td>
                    <td colspan="3">
                        <label for="cpf"><strong>CPF</strong></label>
                        <div id="cpf">{{ $row->cpf }}</div>
                    </td>
                    <td colspan="3">
                        <label for="email"><strong>E-mail</strong></label>
                        <div id="email">{{ $row->email }}</div>
                    </td>
                </tr>

                <tr>
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
                        <div id="cep">{{ $row->cep }}</div>
                    </td>
                    <td colspan="3">
                        <label for="logradouro"><strong>Logradouro</strong></label>
                        <div id="logradouro">{{ $row->logradouro }}</div>
                    </td>                    
                </tr>

                <tr>
                    <td colspan="2">
                        <label for="numero"><strong>Nº</strong></label>
                        <div id="numero">{{ $row->numero }}</div>
                    </td>
                    <td colspan="2">
                        <label for="complemento"><strong>Complemento</strong></label>
                        <div id="complemento">{{ $row->complemento }}</div>
                    </td>

                    <td colspan="3">
                        <label for="bairro"><strong>Bairro</strong></label>
                        <div id="bairro">{{ $row->bairro }}</div>
                    </td>
                    <td colspan="3">
                        <label for="cidade"><strong>Cidade</strong></label>
                        <div id="cidade">{{ $row->cidade }}</div>
                    </td>
                    <td colspan="2">
                        <label for="uf"><strong>UF</strong></label>
                        <div id="uf">{{ $row->uf }}</div>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <label for="cns"><strong>CNS</strong></label>
                        <div id="cns">{{ $row->cns }}</div>
                    </td>
                    <td colspan="2">
                        <label for="beneficio"><strong>Possui Benéficio</strong></label>
                        <div id="beneficio">{{ $row->beneficio }}</div>
                    </td>
                    <td colspan="4">
                        <label for="beneficioQual"><strong>Qual?</strong></label>
                        <div id="beneficioQual">{{ $row->beneficioQual }}</div>
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
            @endforeach
        </main>
        </main>
    </body>
</html>