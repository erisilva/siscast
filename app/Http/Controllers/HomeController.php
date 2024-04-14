<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('index', [
            'pedidos' => Pedido::orderBy('turno', 'asc')->orderBy('nome', 'asc')->filter(['dataAgendaInicio' => Carbon::today()->format('d/m/Y'), 'dataAgendaFim' =>  Carbon::today()->format('d/m/Y')])->get(),
        ]);
    }
}
