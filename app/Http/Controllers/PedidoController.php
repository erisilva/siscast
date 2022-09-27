<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Raca;
use App\Models\Situacao;
use App\Models\Perpage;

use App\Rules\Cpf;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Carbon\Carbon;

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
        $this->validate($request, [
            'cpf' => ['required', 'string', 'max:14', new Cpf],           
            'nome' => 'required|string|max:180',
            'nascimento' => ['required','date_format:d/m/Y', 'before_or_equal:'. Carbon::now()->subYears(18)->format('Y-m-d')],
            'endereco' => 'required|string|max:100',
            'numero' => 'required|string|max:10',
            'bairro' => 'required|string|max:80',
            'complemento' => 'nullable|string|max:100',
            'cidade' => 'required|string|max:80',
            'uf' => 'required|string|max:2',
            'cep' => ['required', 'string', 'max:11', 'regex:/^(?:\d{5}-?\d{3})$/i'],
            'email' => 'required|string|max:150|email',
            'tel' => 'nullable|string|max:15',
            'cel' => 'required|string|max:15',
            'cns' => 'required|string|max:15',
            'beneficio' => 'required|in:S,N',
            'beneficioQual' => 'nullable|string|max:100',
            'nomeAnimal' => 'required|string|max:100',
            'genero' => 'required|in:M,F',
            'porte' => 'required|in:pequeno,medio,grande',
            'idade' => 'required|numeric',
            'idadeEm' => 'required|in:mes,ano',
            'cor' => 'required|string|max:80',
            'especie' => 'required|in:felino,canino',
            'raca_id' => 'required|numeric',
            'procedencia' => 'required|string|max:100',
            'situacao_id' => 'required|numeric',            
            'primeiraTentativa' => 'required|in:S,N',
            'primeiraTentativaQuando' => ['nullable','date_format:d/m/Y'],
            'primeiraTentativaHora' => 'nullable|string|max:5',
            'segundaTentativa' => 'required|in:S,N',
            'segundaTentativaQuando' => ['nullable','date_format:d/m/Y'],
            'segundaTentativaHora' => 'nullable|string|max:5',
            'agendaQuando' => ['nullable','date_format:d/m/Y'],
            'agendaTurno' => 'nullable|in:manha,tarde,nenhum',
        ],[
            'cpf.required' => 'O campo CPF é obrigatório.',
            'cpf.max' => 'O campo CPF deve ter no máximo 14 caracteres.',
            'nome.required' => 'O campo Nome é obrigatório.',
            'nome.max' => 'O campo Nome deve ter no máximo 180 caracteres.',
            'nascimento.required' => 'O campo Data de Nascimento é obrigatório.',
            'nascimento.date_format' => 'O campo Data de Nascimento deve estar no formato dd/mm/aaaa.',
            'nascimento.before_or_equal' => 'O tutor precisa ser maior de idadade.',
            'endereco.required' => 'O campo Endereço é obrigatório.',
            'endereco.max' => 'O campo Endereço deve ter no máximo 100 caracteres.',
            'numero.required' => 'O campo Número é obrigatório.',
            'numero.max' => 'O campo Número deve ter no máximo 10 caracteres.',
            'bairro.required' => 'O campo Bairro é obrigatório.',
            'bairro.max' => 'O campo Bairro deve ter no máximo 80 caracteres.',
            'complemento.max' => 'O campo Complemento deve ter no máximo 100 caracteres.',
            'cidade.required' => 'O campo Cidade é obrigatório.',
            'cidade.max' => 'O campo Cidade deve ter no máximo 80 caracteres.',
            'uf.required' => 'O campo UF é obrigatório.',
            'uf.max' => 'O campo UF deve ter no máximo 2 caracteres.',
            'cep.required' => 'O campo CEP é obrigatório.',
            'cep.string' => 'O campo CEP deve ter no máximo 11 caracteres.',
            'cep.regex' => 'O campo CEP deve estar no formato 99999-999.',
            'email.required' => 'O campo E-mail é obrigatório.',
            'email.max' => 'O campo E-mail deve ter no máximo 150 caracteres.',
            'email.email' => 'O campo E-mail está inválido.',
            'tel.max' => 'O campo Telefone deve ter no máximo 15 caracteres.',
            'cel.required' => 'O campo Celular é obrigatório.',
            'cel.max' => 'O campo Celular deve ter no máximo 15 caracteres.',
            'cns.max' => 'O campo CNS deve ter no máximo 15 caracteres.',
            'beneficio.required' => 'O campo Benefício é obrigatório.',
            'beneficio.in' => 'O campo Benefício deve ser Sim ou Não.',
            'beneficioQual.max' => 'A descrição do(s) benefício(s) devem ter no máximo 100 caracteres.',
            'nomeAnimal.required' => 'O campo Nome do Animal é obrigatório.',
            'nomeAnimal.max' => 'O campo Nome do Animal deve ter no máximo 100 caracteres.',
            'genero.required' => 'O campo Gênero é obrigatório.',
            'genero.in' => 'O campo Gênero deve ser Macho ou Fêmea.',
            'porte.required' => 'O campo Porte é obrigatório.',
            'porte.in' => 'O campo Porte deve ser Pequeno, Médio ou Grande.',
            'idade.required' => 'O campo Idade é obrigatório.',
            'idade.numeric' => 'O campo Idade deve ser um número.',
            'idadeEm.required' => 'Escolha se a Idade é em meses ou anos.',
            'idadeEm.in' => 'O campo Idade em deve ser Mês ou Ano.',
            'cor.required' => 'O campo Cor é obrigatório.',
            'cor.max' => 'O campo Cor deve ter no máximo 80 caracteres.',
            'especie.required' => 'O campo Espécie é obrigatório.',
            'especie.in' => 'O campo Espécie deve ser Felino ou Canino.',
            'raca_id.required' => 'Selecione na lista a Raça de seu animal.',
            'raca_id.numeric' => 'O campo Raça deve ser um número.',
            'procedencia.required' => 'O campo Procedência é obrigatório.',
            'procedencia.max' => 'O campo Procedência deve ter no máximo 100 caracteres.',
            'situacao_id.required' => 'O campo Situação é obrigatório.',
            'situacao_id.numeric' => 'O campo Situação deve ser um número.',
            'primeiraTentativa.required' => 'O campo Primeira Tentativa é obrigatório.',
            'primeiraTentativa.in' => 'O campo Primeira Tentativa deve ser Sim ou Não.',
            'primeiraTentativaQuando.date_format' => 'O campo Data da Primeira Tentativa deve estar no formato dd/mm/aaaa.',
            'primeiraTentativaHora.max' => 'O campo Hora da Primeira Tentativa deve ter no máximo 5 caracteres.',
            'segundaTentativa.required' => 'O campo Segunda Tentativa é obrigatório.',
            'segundaTentativa.in' => 'O campo Segunda Tentativa deve ser Sim ou Não.',
            'segundaTentativaQuando.date_format' => 'O campo Data da Segunda Tentativa deve estar no formato dd/mm/aaaa.',
            'segundaTentativaHora.max' => 'O campo Hora da Segunda Tentativa deve ter no máximo 5 caracteres.',
            'agendaQuando.date_format' => 'O campo Data de Agendamento deve estar no formato dd/mm/aaaa.',
            'agendaTurno.in' => 'O campo Agendar para qual turno deve ser Manhã ou Tarde.',
            'agendaTurno.required' => 'O campo Agendar para qual turno é obrigatório.',
        ]);

        $pedido = request()->all(); // pego todos os dados do formulário e coloco em um array

        $pedido['ip'] = $request->ip(); // pego o ip do usuário que está fazendo a requisição e coloco no array pedido

        $pedido['request'] = json_encode($request->except('_token')); // pego todos os dados do formulário e converto em json e coloco no array pedido

        $pedido['codigo'] = 0; // coloco o código como 0 para que o trigger gere um código para o pedido

        $pedido['ano'] = 0; // coloco o ano como 0 para que o trigger gere um ano para o pedido, ano atual

        $pedido['cpf'] = preg_replace('/[^0-9]/', '', $pedido['cpf'] ); // retiro os caracteres especiais do cpf

        $pedido['cep'] = preg_replace('/[^0-9]/', '', $pedido['cep'] ); // retiro os caracteres especiais do cep
        
        $datas_a_ajustar = ['nascimento', 'primeiraTentativaQuando', 'segundaTentativaQuando', 'agendaQuando']; // datas que precisam ser ajustadas
        
        # ajusto as datas para o formato do banco de dados
        foreach ($datas_a_ajustar as $data) {
            if (isset($pedido[$data])) {
                $pedido[$data] = implode('-', array_reverse(explode('/', $pedido[$data]))); // ajusto a data para o formato do banco de dados
            }
        }

        Pedido::create($pedido);
        
        // atualizar no futuro pra abrir a edição
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
        $this->authorize('pedido-show');

        return view('pedidos.show', [
            'pedido' => $pedido
        ]);
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
