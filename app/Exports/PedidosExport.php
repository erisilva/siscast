<?php

namespace App\Exports;

use App\Models\Pedido;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class PedidosExport implements FromQuery, WithHeadings
{
    use Exportable;

    /**
    * @return \Illuminate\Support\Collection
    * 
    * php artisan make:export PedidosExport --model=Pedido
    * 
    * https://laravel-excel.com/
    * 
    *
    */

    private $filter;

    public function __construct($filter)
    {
        $this->filter = $filter;
    }

    public function query()
    {
        return Pedido::query()->select( 'pedidos.codigo', 
                                        'pedidos.ano',
                                        DB::raw('DATE_FORMAT(pedidos.created_at, \'%d/%m/%Y\') AS data_cadastro'),
                                        'situacaos.nome as situacao',
                                        DB::raw('DATE_FORMAT(pedidos.agendaQuando, \'%d/%m/%Y\') AS data_agenda'),
                                        'pedidos.nome as nomePessoa',
                                        'pedidos.cpf',
                                        DB::raw('DATE_FORMAT(pedidos.nascimento, \'%d/%m/%Y\') AS data_nascimento'),
                                        'pedidos.logradouro',
                                        'pedidos.numero',
                                        'pedidos.bairro',
                                        'pedidos.complemento',
                                        'pedidos.cidade',
                                        'pedidos.uf',
                                        'pedidos.cep',
                                        'pedidos.email',
                                        'pedidos.tel',
                                        'pedidos.cel',
                                        'pedidos.cns',
                                        'pedidos.beneficio',
                                        'pedidos.beneficioQual',
                                        'pedidos.nomeAnimal',
                                        'pedidos.especie',
                                        'pedidos.genero',
                                        'pedidos.porte',
                                        'racas.nome as raca',
                                        'pedidos.idade',
                                        'pedidos.idadeEm',
                                        'pedidos.cor',
                                        'pedidos.procedencia',
                                        'pedidos.primeiraTentativa',
                                        //DB::raw('DATE_FORMAT(pedidos.primeiraTentativaQuando, \'%d/%m/%Y\') AS primeira_quando'),                                        
                                        'pedidos.primeiraTentativaHora',
                                        'pedidos.segundaTentativa',
                                        DB::raw('DATE_FORMAT(pedidos.segundaTentativaQuando, \'%d/%m/%Y\') AS segunda_quando'),
                                        'pedidos.segundaTentativaHora',
                                        'pedidos.nota',
                                        DB::raw('DATE_FORMAT(pedidos.agendaQuando, \'%d/%m/%Y\') AS data_agenda2'),                                        
                                        'pedidos.agendaTurno',
                                        'pedidos.motivoNaoAgendado',

                                       )
                              ->join('situacaos', 'pedidos.situacao_id', '=', 'situacaos.id')
                              ->join('racas', 'pedidos.raca_id', '=', 'racas.id')         
                              ->orderBy('pedidos.id', 'desc')
                              ->filter($this->filter);
    }

    public function headings(): array
    {
        return ["Código", 
                "Ano",
                "Data Cadastro",
                "Situação",
                "Data Agenda",
                "Nome Pessoa",
                "CPF",
                "Data Nascimento",
                "Logradouro",
                "Número",
                "Bairro",
                "Complemento",
                "Cidade",
                "UF",
                "CEP",
                "E-mail",
                "Telefone",
                "Celular",
                "CNS",
                "Benefício",
                "Qual Benefício",
                "Nome Animal",
                "Espécie",
                "Gênero",
                "Porte",
                "Raça",
                "Idade",
                "Idade Em",
                "Cor",
                "Procedência",
                "Primeira Tentativa",
                //"Data Primeira Tentativa",
                "Hora Primeira Tentativa",
                "Segunda Tentativa",
                "Data Segunda Tentativa",
                "Hora Segunda Tentativa",
                "Nota",
                "Data Agenda",
                "Turno",
                "Motivo Não Agendado",

                
                
            ];
    }
}
