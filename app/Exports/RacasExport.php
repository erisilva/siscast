<?php

namespace App\Exports;

use App\Models\Raca;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RacasExport implements FromQuery, WithHeadings
{
    use Exportable;

    /**
    * @return \Illuminate\Support\Collection
    * 
    * php artisan make:export RacasExport --model=Raca
    * 
    * https://laravel-excel.com/
    * 
    *
    */

    public function query()
    {
        return Raca::query()->select('id', 'descricao')->orderBy('id', 'asc');
    }

    public function headings(): array
    {
        return ["id", "Descrição"];
    }
}
