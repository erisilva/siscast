<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class ReportPorSituacaoExport implements FromQuery, WithHeadings
{
    use Exportable;

    private $dataInicio;
    private $dataFinal;

    /**
    * @return \Illuminate\Support\Collection
    * 
    * php artisan make:export ReportPorSituacaoExport --model=Permission
    * 
    * https://laravel-excel.com/
    * 
    *
    */

    public function __construct($dataInicio, $dataFinal)
    {
        $this->dataInicio = $dataInicio;
        $this->dataFinal = $dataFinal;
    }

    public function query()
    {
        # get data
        $porSituacao = DB::table('pedidos')
            ->join('situacaos', 'situacaos.id', '=', 'pedidos.situacao_id')
            ->select('situacaos.nome', DB::raw('count(pedidos.id) as total'))
            ->where('pedidos.created_at', '>=', $this->dataInicio)
            ->where('pedidos.created_at', '<=', $this->dataFinal)
            ->groupBy('pedidos.situacao_id', 'situacaos.nome')
            ->orderBy('situacaos.nome');  

        return $porSituacao;
    }

    public function headings(): array
    {
        return ["Situação", "Total"];
    }
}
