<?php

namespace App\Http\Controllers;

use App\Models\Param;
use App\Models\Perpage;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Log;

class ParamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : View
    {
        $this->authorize('param-index');

        if(request()->has('perpage')) {
            session(['perPage' => request('perpage')]);
        }

        return view('params.index', [
            'params' => Param::orderBy('id', 'asc')->paginate(session('perPage', '5'))->withPath(env('APP_URL', null) .  '/params'),
            'perpages' => Perpage::orderBy('valor')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
    {
        $this->authorize('param-create');

        return view('params.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : RedirectResponse
    {
        $this->authorize('param-create');

        $request->validate([
            'value' => 'required'
        ]);

        $new_raca = Param::create($request->all());

        // LOG
        Log::create([
            'model_id' => $new_raca->id,
            'model' => 'Param',
            'action' => 'store',
            'changes' => json_encode($new_raca),
            'user_id' => auth()->id(),            
        ]);

        return redirect()->route('params.index')->with('message', 'Raça cadastrada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Param $param) : View
    {
        $this->authorize('param-show');

        return view('params.show', compact('param'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Param $param) : View
    {
        $this->authorize('param-edit');

        return view('params.edit', compact('param'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Param $param) : RedirectResponse
    {
        $this->authorize('param-edit');

        $request->validate([
            'value' => 'required'
        ]);

        $param->update($request->all());

        // LOG
        Log::create([
            'model_id' => $param->id,
            'model' => 'Param',
            'action' => 'update',
            'changes' => json_encode($param->getChanges()),
            'user_id' => auth()->id(),            
        ]);
        

        return redirect()->route('params.index')->with('message', 'Raça atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Param $param) : RedirectResponse
    {
        $this->authorize('param-delete');

        // LOG
        Log::create([
            'model_id' => $param->id,
            'model' => 'Param',
            'action' => 'destroy',
            'changes' => json_encode($param),
            'user_id' => auth()->id(),            
        ]);

        $param->delete();

        return redirect()->route('params.index')->with('message', 'Raça excluída com sucesso!');
    }
}
