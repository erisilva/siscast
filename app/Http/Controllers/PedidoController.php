<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Raca;
use App\Models\Situacao;
use App\Models\Perpage;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Exports\PedidosExport;
use Maatwebsite\Excel\Facades\Excel;

use Barryvdh\DomPDF\Facade\Pdf;

class PedidoController extends Controller
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
        $this->authorize('pedido-index');
        
        // atualiza perPage se necessário
        if(request()->has('perpage')) {
            session(['perPage' => request('perpage')]);
        }
        
        return view('pedidos.index', [
            'pedidos' => Pedido::orderBy('id', 'desc')->filter(request(['codigo', 'ano', 'cpf', 'nome']))->paginate(session('perPage', '5'))->appends(request(['codigo', 'ano', 'cpf', 'nome'])),
            'racas' => Raca::orderBy('descricao')->get(),
            'situacoes' => Situacao::orderBy('nome')->get(),
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
        $this->authorize('pedido-create');
        
        return view('pedidos.create', [
            'racas' => Raca::orderBy('descricao')->get(),
            'situacoes' => Situacao::orderBy('nome')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pedido = $request->validate([
          'cpf' => 'required',
          'nome' => 'required',
          'raca_id' => 'required',
          'situacao_id' => 'required',
        ]);
        
        Pedido::create($pedido);
        
        return redirect(route('pedidos.index'))->with('message', 'Pedido cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function show(Pedido $pedido)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function edit(Pedido $pedido)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pedido $pedido)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pedido $pedido)
    {
        //
    }
}
