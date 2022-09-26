<?php

namespace App\Http\Controllers;

use App\Models\Raca;
use App\Models\Perpage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Exports\RacasExport;
use Maatwebsite\Excel\Facades\Excel;

use Barryvdh\DomPDF\Facade\Pdf;

class RacaController extends Controller
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
        $this->authorize('raca-index');

        // atualiza perPage se necessário
        if(request()->has('perpage')) {
            session(['perPage' => request('perpage')]);
        }

        return view('racas.index', [
            'racas' => Raca::orderBy('id', 'asc')->paginate(session('perPage', '5')),
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
        $this->authorize('raca-create');

        return view('racas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $raca = $request->validate([
          'descricao' => 'required',
        ]);

        Raca::create($raca);

        return redirect(route('racas.index'))->with('message', 'Raça cadastrada com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Raca  $raca
     * @return \Illuminate\Http\Response
     */
    public function show(Raca $raca)
    {
        $this->authorize('raca-show');

        return view('racas.show', [
            'raca' => $raca
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Raca  $raca
     * @return \Illuminate\Http\Response
     */
    public function edit(Raca $raca)
    {
        $this->authorize('raca-edit');

        return view('racas.edit', [
            'raca' => $raca
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Raca  $raca
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Raca $raca)
    {
        $raca->update($request->validate([
          'descricao' => 'required',
        ]));

        return redirect(route('racas.index'))->with('message', 'Raça atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Raca  $raca
     * @return \Illuminate\Http\Response
     */
    public function destroy(Raca $raca)
    {
        $this->authorize('raca-delete');

        $raca->delete();

        return redirect(route('racas.index'))->with('message', 'Raça excluída com sucesso!');
    }

    public function exportcsv()
    {
        $this->authorize('raca-export');

        return Excel::download(new RacasExport(), 'Racas_' .  date("Y-m-d H:i:s") . '.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    public function exportxls()
    {
        $this->authorize('raca-export');

        return Excel::download(new RacasExport(), 'Racas_' .  date("Y-m-d H:i:s") . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    public function exportpdf()
    {
        $this->authorize('raca-export');
        
        return PDF::loadView('racas.report', [
            'dataset' => Raca::orderBy('id', 'asc')->get()
        ])->download('Racas_' .  date("Y-m-d H:i:s") . '.pdf');
    }

}
