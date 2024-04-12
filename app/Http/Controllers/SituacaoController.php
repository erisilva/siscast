<?php

namespace App\Http\Controllers;

use App\Models\Situacao;
use App\Models\Perpage;
use App\Models\Log;
use Illuminate\Http\Request;

class SituacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('situacao-index');

        if(request()->has('perpage')) {
            session(['perPage' => request('perpage')]);
        }

        return view('situacaos.index', [
            'situacaos' => Situacao::orderBy('id', 'asc')->filter(request(['nome']))->paginate(session('perPage', '5'))->appends(request(['nome'])),
            'perpages' => Perpage::orderBy('valor')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('situacao-create');

        return view('situacaos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('situacao-create');

        $request->validate([
            'nome' => 'required|unique:situacaos',
            'descricao' => 'required',
            'cor' => 'required',
            'icone' => 'required'
        ]);

        $new_situacao = Situacao::create($request->all());

        // LOG
        Log::create([
            'model_id' => $new_situacao->id,
            'model' => 'Situacao',
            'action' => 'store',
            'changes' => json_encode($new_situacao),
            'user_id' => auth()->id(),            
        ]);

        return redirect()->route('situacaos.index')->with('message', 'Situação cadastrada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Situacao $situacao)
    {
        $this->authorize('situacao-show');

        return view('situacaos.show', compact('situacao'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Situacao $situacao)
    {
        $this->authorize('situacao-edit');

        return view('situacaos.edit', compact('situacao'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Situacao $situacao)
    {
        $this->authorize('situacao-edit');

        $request->validate([
            'nome' => 'required|unique:situacaos,nome,' . $situacao->id,
            'descricao' => 'required',
            'cor' => 'required',
            'icone' => 'required'
        ]);

        // LOG
        Log::create([
            'model_id' => $situacao->id,
            'model' => 'Situacao',
            'action' => 'update',
            'changes' => json_encode($situacao),
            'user_id' => auth()->id(),            
        ]);

        $situacao->update($request->all());

        return redirect()->route('situacaos.index')->with('message', 'Situação atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Situacao $situacao)
    {
        $this->authorize('situacao-delete');

        // LOG
        Log::create([
            'model_id' => $situacao->id,
            'model' => 'Situacao',
            'action' => 'destroy',
            'changes' => json_encode($situacao),
            'user_id' => auth()->id(),            
        ]);

        $situacao->delete();

        return redirect()->route('situacaos.index')->with('message', 'Situação excluída com sucesso!');
    }
}
