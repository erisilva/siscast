<?php

namespace App\Exports;

use App\Models\Situacao;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SituacaosExport implements FromQuery, WithHeadings
{
    use Exportable;

    /**
    * @return \Illuminate\Support\Collection
    * 
    * php artisan make:export SituacaosExport --model=Situacao
    * 
    * https://laravel-excel.com/
    * 
    *
    */

    public function query()
    {
        return Situacao::query()->select('id', 'descricao')->orderBy('id', 'asc');
    }

    public function headings(): array
    {
        return ["id", "Descrição"];
    }
}
