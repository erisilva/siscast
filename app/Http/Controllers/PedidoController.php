<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Perpage;
use App\Models\Raca;
use App\Models\Situacao;

use App\Rules\Cpf; // validação de um cpf

use Illuminate\Http\Request;
use App\Models\Log;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : View
    {
        $this->authorize('pedido-index');

        if(request()->has('perpage')) {
            session(['perPage' => request('perpage')]);
        }

// 'codigo' => '','ano' => '','situacao_id' => '','dataAgendaInicio' => '','dataAgendaFim' => '','nome' => '','cpf' => '','nomeAnimal' => '','especie' => '','genero' => '','porte' => '','idadeMinima' => '','idadeMaxima' => '','idadeEm' => '','procedencia' => '','dataCadastroInicio' => '','dataCadastroFim' => ''

        return view('pedidos.index', [
            'pedidos' => Pedido::orderBy('id', 'desc')
                ->filter(request(['codigo','ano','situacao_id','dataAgendaInicio','dataAgendaFim','nome','cpf','nomeAnimal','especie','genero','porte','idadeMinima','idadeMaxima','idadeEm','procedencia','dataCadastroInicio','dataCadastroFim']))
                ->paginate(session('perPage', '5'))
                ->appends(request(['codigo','ano','situacao_id','dataAgendaInicio','dataAgendaFim','nome','cpf','nomeAnimal','especie','genero','porte','idadeMinima','idadeMaxima','idadeEm','procedencia','dataCadastroInicio','dataCadastroFim'])),
            'perpages' => Perpage::orderBy('valor')->get(),
            'situacaos'=> Situacao::orderBy('nome','asc')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
    {
        $this->authorize('pedido-create');

        return view('pedidos.create', [
            'racas' => Raca::orderBy('nome')->get(),
            'situacaos' => Situacao::orderBy('nome')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : RedirectResponse
    {
        $this->authorize('pedido-create');

        $request->validate([
            'cpf' => ['required', 'max:15', new Cpf],
            'nome' => 'required|max:80',
            'nascimento' => 'required|date_format:d/m/Y',
            'logradouro' => 'required|max:100',
            'complemento'=> 'max:100', // 'complemento is nullable
            'numero' => 'required|max:10',
            'bairro' => 'required|max:80',
            'cidade' => 'required|max:80',
            'uf' => 'required|max:2',
            'cep' => 'required|max:20',
            'email' => 'required|max:190|email',
            'cel' => 'required|max:20',
            'nomeAnimal' => 'required|max:100',
            'genero' => 'required|in:M,F',
            'porte' => 'required|in:pequeno,medio,grande',
            'idade' => 'required|integer',
            'idadeEm' => 'required|in:mes,ano',
            'cor' => 'required|max:80',
            'especie' => 'required|in:felino,canino',
            'procedencia' => 'required|max:100',
            'raca_id' => 'required|exists:racas,id|integer',
            'cns' => 'max:20',
            'beneficio' => 'required|max:100',
        ]);

        $request->merge(['situacao_id' => 1]);

        $request->merge(['nascimento' => date('Y-m-d', strtotime(str_replace('/', '-', $request->nascimento)))]);

        $request->merge(['cpf' => preg_replace('/[^0-9]/', '', $request->cpf)]);

        $newPedido = Pedido::create($request->all());

        //LOG
        Log::create([
            'model_id' => $newPedido->id,
            'model' => 'Role',
            'action' => 'store',
            'changes' => json_encode($newPedido),
            'user_id' => auth()->id(),            
        ]);

        return redirect()->route('pedidos.edit', $newPedido)->with('message', 'Pedido cadastrado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pedido $pedido) : View
    {
        $this->authorize('pedido-show');

        return view('pedidos.show', [
            'pedido' => $pedido
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pedido $pedido) : View
    {
        $this->authorize('pedido-edit');

        return view('pedidos.edit', [
            'pedido' => $pedido,
            'racas' => Raca::orderBy('nome')->get(),
            'situacaos' => Situacao::orderBy('nome')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pedido $pedido) : RedirectResponse
    {
        $this->authorize('pedido-edit');

        $request->validate([
            'cpf' => ['required', 'max:15', new Cpf],
            'nome' => 'required|max:80',
            'nascimento' => 'required|date_format:d/m/Y',
            'logradouro' => 'required|max:100',
            'complemento'=> 'max:100', // 'complemento is nullable
            'numero' => 'required|max:10',
            'bairro' => 'required|max:80',
            'cidade' => 'required|max:80',
            'uf' => 'required|max:2',
            'cep' => 'required|max:20',
            'email' => 'required|max:190|email',
            'cel' => 'required|max:20',
            'nomeAnimal' => 'required|max:100',
            'genero' => 'required|in:M,F',
            'porte' => 'required|in:pequeno,medio,grande',
            'idade' => 'required|integer',
            'idadeEm' => 'required|in:mes,ano',
            'cor' => 'required|max:80',
            'especie' => 'required|in:felino,canino',
            'procedencia' => 'required|max:100',
            'raca_id' => 'required|exists:racas,id|integer',
            'cns'=> 'max:20',
            'beneficio' => 'required|max:100',
        ]);

        $request->merge(['nascimento' => date('Y-m-d', strtotime(str_replace('/', '-', $request->nascimento)))]);

        if ($request->has('primeiraTentativaQuando')) {
            $request->merge(['primeiraTentativaQuando' => date('Y-m-d', strtotime(str_replace('/', '-', $request->primeiraTentativaQuando)))]);    
        }

        if ($request->has('segundaTentativaQuando')) {
            $request->merge(['segundaTentativaQuando' => date('Y-m-d', strtotime(str_replace('/', '-', $request->segundaTentativaQuando)))]);    
        }

        if ($request->has('agendaQuando')) {
            $request->merge(['agendaQuando' => date('Y-m-d', strtotime(str_replace('/', '-', $request->agendaQuando)))]);    
        }

        $request->merge(['cpf' => preg_replace('/[^0-9]/', '', $request->cpf)]);

        $pedido->update($request->all());

        Log::create([
            'model_id' => $pedido->id,
            'model' => 'Pedido',
            'action' => 'Update',
            'changes' => json_encode($pedido->getChanges()),
            'user_id' => auth()->id(),            
        ]);

        return redirect()->route('pedidos.edit', $pedido)->with('message', 'Pedido atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pedido $pedido) : RedirectResponse
    {
        $this->authorize('pedido-delete'); 

        Log::create([
            'model_id' => $pedido->id,
            'model' => 'Pedido',
            'action' => 'Delete',
            'changes' => $pedido->toJson(),
            'user_id' => auth()->id(),
        ]);

        $pedido->delete();

        return redirect()->route('pedidos.index')->with('message', 'Pedido excluído com sucesso.');

    }     
}
