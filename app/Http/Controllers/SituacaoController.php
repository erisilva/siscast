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
        $this->authorize('situacao-index');

        // atualiza perPage se necessário
        if(request()->has('perpage')) {
            session(['perPage' => request('perpage')]);
        }

        return view('situacaos.index', [
            'situacaos' => Situacao::orderBy('id', 'asc')->paginate(session('perPage', '5')),
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
        $this->authorize('situacao-create');

        return view('situacaos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Situacao::create($request->validate([
            'nome' => 'required',
            'descricao' => 'required',
          ]));

        return redirect(route('situacaos.index'))->with('message', 'Situação cadastrada com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Situacao  $situacao
     * @return \Illuminate\Http\Response
     */
    public function show(Situacao $situacao)
    {
        $this->authorize('situacao-show');

        return view('situacaos.show', [
            'situacao' => $situacao
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Situacao  $situacao
     * @return \Illuminate\Http\Response
     */
    public function edit(Situacao $situacao)
    {
        $this->authorize('situacao-edit');

        return view('situacaos.edit', [
            'situacao' => $situacao
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Situacao  $situacao
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Situacao $situacao)
    {
        $situacao->update($request->validate([
          'nome' => 'required',
          'descricao' => 'required',
        ]));

        return redirect(route('situacaos.index'))->with('message', 'Situação atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Situacao  $situacao
     * @return \Illuminate\Http\Response
     */
    public function destroy(Situacao $situacao)
    {
        $this->authorize('situacao-delete');

        $situacao->delete();

        return redirect(route('situacaos.index'))->with('message', 'Situação excluída com sucesso!');
    }

    public function exportcsv()
    {
        $this->authorize('situacao-export');

        return Excel::download(new SituacaosExport(), 'Situacaos_' .  date("Y-m-d H:i:s") . '.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    public function exportxls()
    {
        $this->authorize('situacao-export');

        return Excel::download(new SituacaosExport(), 'Situacaos_' .  date("Y-m-d H:i:s") . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    public function exportpdf()
    {
        $this->authorize('situacao-export');
        
        return PDF::loadView('situacaos.report', [
            'dataset' => Situacao::orderBy('id', 'asc')->get()
        ])->download('Situacaos_' .  date("Y-m-d H:i:s") . '.pdf');
    }

}
