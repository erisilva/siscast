<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Perpage;
use App\Models\Raca;
use App\Models\Situacao;

use App\Rules\Cpf; // validação de um cpf
use App\Rules\LegalAgeRule; // validação de idade

use Illuminate\Http\Request;
use App\Models\Log;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

use Barryvdh\DomPDF\Facade\Pdf; // Export PDF

use App\Exports\PedidosExport;
use Maatwebsite\Excel\Facades\Excel; // Export Excel


class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $this->authorize('pedido-index');

        if (request()->has('perpage')) {
            session(['perPage' => request('perpage')]);
        }

        // 'codigo' => request()->input('codigo'),'ano' => request()->input('ano'),'situacao_id' => request()->input('situacao_id'),'dataAgendaInicio' => request()->input('dataAgendaInicio'),'dataAgendaFim' => request()->input('dataAgendaFim'),'nome' => request()->input('nome'),'cpf' => request()->input('cpf'),'nomeAnimal' => request()->input('nomeAnimal'),'especie' => request()->input('especie'),'genero' => request()->input('genero'),'porte' => request()->input('porte'),'idadeMinima' => request()->input('idadeMinima'),'idadeMaxima' => request()->input('idadeMaxima'),'idadeEm' => request()->input('IdadeEm'),'procedencia' => request()->input('procedencia'),'dataCadastroInicio' => request()->input('dataCadastroInicio'),'dataCadastroFim' => request()->input('dataCadastroFim'),'raca_id' => request()->input('raca_id')

        // 'description' => request()->input('description'), 'name' => request()->input('name')

        return view('pedidos.index', [
            'pedidos' => Pedido::orderBy('id', 'desc')
                ->filter(request(['codigo', 'ano', 'situacao_id', 'dataAgendaInicio', 'dataAgendaFim', 'nome', 'cpf', 'nomeAnimal', 'especie', 'raca_id', 'genero', 'porte', 'idadeMinima', 'idadeMaxima', 'idadeEm', 'procedencia', 'dataCadastroInicio', 'dataCadastroFim', 'turno', 'cidade']))
                ->paginate(session('perPage', '5'))
                ->appends(request(['codigo', 'ano', 'situacao_id', 'dataAgendaInicio', 'dataAgendaFim', 'nome', 'cpf', 'nomeAnimal', 'especie', 'raca_id', 'genero', 'porte', 'idadeMinima', 'idadeMaxima', 'idadeEm', 'procedencia', 'dataCadastroInicio', 'dataCadastroFim', 'turno', 'cidade']))
                ->withPath(env('APP_URL', null) .  '/pedidos'), // for linux server
            'perpages' => Perpage::orderBy('valor')->get(),
            'situacaos' => Situacao::orderBy('nome', 'asc')->get(),
            'racas' => Raca::orderBy('nome')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
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
    public function store(Request $request): RedirectResponse
    {
        $this->authorize('pedido-create');

        $request->validate([
            'cpf' => ['required', 'max:15', new Cpf],
            'nome' => 'required|max:80',
            'nascimento' => ['required', 'date_format:d/m/Y', new LegalAgeRule(18)],
            'logradouro' => 'required|max:100',
            'complemento' => 'max:100', // 'complemento is nullable
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
            'model' => 'Pedido',
            'action' => 'store',
            'changes' => json_encode($newPedido),
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('pedidos.edit', $newPedido)->with('message', 'Pedido cadastrado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pedido $pedido): View
    {
        $this->authorize('pedido-show');

        return view('pedidos.show', [
            'pedido' => $pedido
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pedido $pedido): View
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
    public function update(Request $request, Pedido $pedido): RedirectResponse
    {
        $this->authorize('pedido-edit');

        $request->validate([
            'cpf' => ['required', 'max:15', new Cpf],
            'nome' => 'required|max:80',
            'nascimento' => 'required|date_format:d/m/Y',
            'logradouro' => 'required|max:100',
            'complemento' => 'max:100', // 'complemento is nullable
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
    public function destroy(Pedido $pedido): RedirectResponse
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

    /**
     * Export the specified resource to PDF.
     */
    public function exportpdf(): \Illuminate\Http\Response
    {
        $this->authorize('pedido-export');

        return Pdf::loadView('pedidos.report', [
            'dataset' => Pedido::orderBy('id', 'desc')->filter(request(['codigo', 'ano', 'situacao_id', 'dataAgendaInicio', 'dataAgendaFim', 'nome', 'cpf', 'nomeAnimal', 'especie', 'raca_id', 'genero', 'porte', 'idadeMinima', 'idadeMaxima', 'idadeEm', 'procedencia', 'dataCadastroInicio', 'dataCadastroFim', 'turno', 'cidade']))->get()
        ])->download(__('Pedidos') . '_' . date("Y-m-d H:i:s") . '.pdf');
    }

    /**
     * Export the specified resource to Excel.
     */
    public function exportcsv(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $this->authorize('pedido-export');

        return Excel::download(new PedidosExport(request(['codigo', 'ano', 'situacao_id', 'dataAgendaInicio', 'dataAgendaFim', 'nome', 'cpf', 'nomeAnimal', 'especie', 'raca_id', 'genero', 'porte', 'idadeMinima', 'idadeMaxima', 'idadeEm', 'procedencia', 'dataCadastroInicio', 'dataCadastroFim', 'turno', 'cidade'])), __('Pedidos') . '_' . date("Y-m-d H:i:s") . '.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * Export the specified resource to Excel.
     */
    public function exportxls(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $this->authorize('pedido-export');

        return Excel::download(new PedidosExport(request(['codigo', 'ano', 'situacao_id', 'dataAgendaInicio', 'dataAgendaFim', 'nome', 'cpf', 'nomeAnimal', 'especie', 'raca_id', 'genero', 'porte', 'idadeMinima', 'idadeMaxima', 'idadeEm', 'procedencia', 'dataCadastroInicio', 'dataCadastroFim', 'turno', 'cidade'])),  'Pedidos_' .  date("Y-m-d H:i:s") . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
}
