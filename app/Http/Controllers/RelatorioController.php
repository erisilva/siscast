<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Exports\ReportPorSituacaoExport;
use Maatwebsite\Excel\Facades\Excel;

class RelatorioController extends Controller
{
    /**
     * Mostra a página para acesso aos relatórios adicionais do sistema
     *
     */
    public function index()
    {
        return view('relatorio.index');
    }

    /**
     * Exibe uma página com um relatório de TRs por situação, filtrados por período
     *
     */
    public function porSituacao()
    {       
        if (request()->has('dataInicial') && request()->has('dataFinal')) {
            $dataInicial = Carbon::createFromFormat('d/m/Y', request('dataInicial'))->format('Y-m-d 00:00:00');
            $dataFinal = Carbon::createFromFormat('d/m/Y', request('dataFinal'))->format('Y-m-d 23:59:59');
        } else {
            $dataInicial = date('Y-m-d 00:00:00', strtotime('-30 days'));
            $dataFinal = date('Y-m-d 23:59:59');
        }

        # get data
        $porSituacao = DB::table('pedidos')
            ->join('situacaos', 'situacaos.id', '=', 'pedidos.situacao_id')
            ->select('situacaos.nome', DB::raw('count(pedidos.id) as total'))
            ->where('pedidos.created_at', '>=', $dataInicial)
            ->where('pedidos.created_at', '<=', $dataFinal)
            ->groupBy('pedidos.situacao_id', 'situacaos.nome')
            ->orderBy('situacaos.nome')
            ->get();

        // # get total of pedidos
        $counterTr = DB::table('pedidos')
            ->where('pedidos.created_at', '>=', $dataInicial)
            ->where('pedidos.created_at', '<=', $dataFinal)
            ->count();

        return view('relatorio.porsituacao', [
            'porSituacao' => $porSituacao,
            'counterTr' => $counterTr
        ]);
    }

    /**
     * Exportação para XLS do relatório de TRs por situação, filtrados por período
     *
     */
    public function porSituacaoExportXLSX()
    {
        # validate and set dates
        if (request()->has('dataInicial') && request()->has('dataFinal')) {
            $dataInicial = Carbon::createFromFormat('d/m/Y', request('dataInicial'))->format('Y-m-d 00:00:00');
            $dataFinal = Carbon::createFromFormat('d/m/Y', request('dataFinal'))->format('Y-m-d 23:59:59');
        } else {
            $dataInicial = date('Y-m-d 00:00:00', strtotime('-30 days'));
            $dataFinal = date('Y-m-d 23:59:59');
        }

        return Excel::download(new ReportPorSituacaoExport($dataInicial, $dataFinal), 'Relatorio_pedidos_por_situacao' .  date("Y-m-d H:i:s") . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);    
    }

    /**
     * Exportação para XLS do relatório de TRs por situação, filtrados por período
     *
     */
    public function porSituacaoExportCSV()
    {
        # validate and set dates
        if (request()->has('dataInicial') && request()->has('dataFinal')) {
            $dataInicial = Carbon::createFromFormat('d/m/Y', request('dataInicial'))->format('Y-m-d 00:00:00');
            $dataFinal = Carbon::createFromFormat('d/m/Y', request('dataFinal'))->format('Y-m-d 23:59:59');
        } else {
            $dataInicial = date('Y-m-d 00:00:00', strtotime('-30 days'));
            $dataFinal = date('Y-m-d 23:59:59');
        }

        return Excel::download(new ReportPorSituacaoExport($dataInicial, $dataFinal), 'Relatorio_pedidos_por_situacao' .  date("Y-m-d H:i:s") . '.csv', \Maatwebsite\Excel\Excel::CSV);
    }    
}
