@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item" aria-current="page"><a href="{{ route('pedidos.index') }}">Pedidos</a></li>
      <li class="breadcrumb-item active"><a href="{{ route('relatorio.index') }}">Mais relatórios</a></li>
    </ol>
  </nav>
</div>
<div class="container">
  <div class="table-responsive-md">
    <table class="table table-striped">
      <thead>
        <tr>
            <th scope="col"><strong>#</strong></th>
            <th scope="col">Nome do Relatório</th>
            <th scope="col">Descrição</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th scope="row">1</th>
          <td><a href="{{ route('relatorio.porsituacao') }}">Pedidos Cadastrados por Status (Situação do Pedido) e Período</a></td>
          <td>Este relatório apresenta a quantidade de TRs agrupadas pela situação do pedido. O período de análise se baseia na data de criação do relatório, exibindo, por padrão, os dados relativos ao último mês. O filtro é aplicado com base na data de cadastro dos pedidos no formulário web. Os dados podem ser exportados em formatos de planilhas e arquivos PDF.</td>
        </tr>         
      </tbody>
    </table>     
  </div>    
</div>

<div class="container py-2 text-right">
  <a href="{{ route('pedidos.index') }}" class="btn btn-primary" role="button"><i class="bi bi-arrow-left"></i> Voltar</a>
</div>

@endsection
