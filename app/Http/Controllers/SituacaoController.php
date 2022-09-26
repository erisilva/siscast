<?php

namespace App\Http\Controllers;

use App\Models\Situacao;
use App\Models\Perpage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Exports\SituacaosExport;
use Maatwebsite\Excel\Facades\Excel;

use Barryvdh\DomPDF\Facade\Pdf;

class SituacaoController extends Controller
{
    public function __construct() 
    {
        $this->middleware(['middleware' => 'auth']);
        $this->middleware(['middleware' => 'hasaccess']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('Situacao-index');

        // atualiza perPage se necessário
        if(request()->has('perpage')) {
            session(['perPage' => request('perpage')]);
        }

        return view('Situacaos.index', [
            'Situacaos' => Situacao::orderBy('id', 'asc')->paginate(session('perPage', '5')),
            'perpages' => Perpage::orderBy('valor')->get()
        ]);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('Situacao-create');

        return view('Situacaos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $Situacao = $request->validate([
          'descricao' => 'required',
        ]);

        Situacao::create($Situacao);

        return redirect(route('Situacaos.index'))->with('message', 'Situação do pedido cadastrada com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Situacao  $Situacao
     * @return \Illuminate\Http\Response
     */
    public function show(Situacao $Situacao)
    {
        $this->authorize('Situacao-show');

        return view('Situacaos.show', [
            'Situacao' => $Situacao
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Situacao  $Situacao
     * @return \Illuminate\Http\Response
     */
    public function edit(Situacao $Situacao)
    {
        $this->authorize('Situacao-edit');

        return view('Situacaos.edit', [
            'Situacao' => $Situacao
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Situacao  $Situacao
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Situacao $Situacao)
    {
        $Situacao->update($request->validate([
          'descricao' => 'required',
        ]));

        return redirect(route('Situacaos.index'))->with('message', 'Situação do pedido atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Situacao  $Situacao
     * @return \Illuminate\Http\Response
     */
    public function destroy(Situacao $Situacao)
    {
        $this->authorize('Situacao-delete');

        $Situacao->delete();

        return redirect(route('Situacaos.index'))->with('message', 'Situação do pedido excluída com sucesso!');
    }

    public function exportcsv()
    {
        $this->authorize('Situacao-export');

        return Excel::download(new SituacaosExport(), 'Situacaos_' .  date("Y-m-d H:i:s") . '.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    public function exportxls()
    {
        $this->authorize('Situacao-export');

        return Excel::download(new SituacaosExport(), 'Situacaos_' .  date("Y-m-d H:i:s") . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    public function exportpdf()
    {
        $this->authorize('Situacao-export');
        
        return PDF::loadView('Situacaos.report', [
            'dataset' => Situacao::orderBy('id', 'asc')->get()
        ])->download('Situacaos_' .  date("Y-m-d H:i:s") . '.pdf');
    }

}
