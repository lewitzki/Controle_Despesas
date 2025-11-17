<?php

namespace App\Http\Controllers;

use App\Models\Despesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DespesaController extends Controller
{
    /**
     * Listar despesas do usuário com filtros básicos.
     */
    public function index(Request $request)
    {
        $filters = $request->validate([
            'mes'       => 'nullable|integer|between:1,12',
            'categoria' => 'nullable|string|max:100',
            'busca'     => 'nullable|string|max:255',
        ]);

        $meses = [
            1  => 'Janeiro',
            2  => 'Fevereiro',
            3  => 'Março',
            4  => 'Abril',
            5  => 'Maio',
            6  => 'Junho',
            7  => 'Julho',
            8  => 'Agosto',
            9  => 'Setembro',
            10 => 'Outubro',
            11 => 'Novembro',
            12 => 'Dezembro',
        ];

        $query = Despesa::query()->where('user_id', Auth::id());

        if (!empty($filters['mes'])) {
            $query->whereMonth('data', $filters['mes']);
        }

        if (!empty($filters['categoria'])) {
            $query->where('categoria', 'like', '%' .  $filters['categoria'] . '%');
        }

        if (!empty($filters['busca'])) {
            $query->where('descricao', 'like', '%' . $filters['busca'] . '%');
        }

        $despesas = (clone $query)
            ->orderByDesc('data')
            ->paginate(10)
            ->withQueryString();

        $totalPeriodo = (clone $query)->sum('valor');

        return view('despesas.index', [
            'despesas'             => $despesas,
            'totalPeriodo'         => $totalPeriodo,
            'meses'                => $meses,
            'mesSelecionado'       => $filters['mes'] ?? null,
            'categoriaSelecionada' => $filters['categoria'] ?? null,
            'busca'                => $filters['busca'] ?? null,
        ]);
    }

    /**
     * Exibir formulário de criação de despesa.
     */
    public function create()
    {
        return view('despesas.create');
    }

    /**
     * Salvar nova despesa no banco
     */
    public function store(Request $request)
    {
        $request->validate([
            'descricao' => 'required|string|max:255',
            'valor' => 'required|numeric|min:0',
            'categoria' => 'required|string|max:100',
            'data' => 'required|date',
        ]);

        Despesa::create([
            'user_id' => Auth::id(),
            'descricao' => $request->descricao,
            'valor' => $request->valor,
            'categoria' => $request->categoria,
            'data' => $request->data,
        ]);

        return redirect()
            ->route('despesas.index')
            ->with('success', 'Despesa adicionada com sucesso!');
    }

    /**
     * Editar uma despesa existente
     */
    public function edit(Despesa $despesa)
    {
        $this->authorizeDespesa($despesa);
        return view('despesas.edit', compact('despesa'));
    }

    /**
     * Atualizar uma despesa existente
     */
    public function update(Request $request, Despesa $despesa)
    {
        $this->authorizeDespesa($despesa);

        $request->validate([
            'descricao' => 'required|string|max:255',
            'valor' => 'required|numeric|min:0',
            'categoria' => 'required|string|max:100',
            'data' => 'required|date',
        ]);

        $despesa->update($request->only(['descricao', 'valor', 'categoria', 'data']));

        return redirect()
            ->route('despesas.index')
            ->with('success', 'Despesa atualizada com sucesso!');
    }

    /**
     * Excluir uma despesa
     */
    public function destroy(Despesa $despesa)
    {
        $this->authorizeDespesa($despesa);
        $despesa->delete();

        return redirect()
            ->route('despesas.index')
            ->with('success', 'Despesa removida com sucesso!');
    }

    /**
     * Garantir que o usuário só possa alterar suas próprias despesas
     */
    private function authorizeDespesa(Despesa $despesa)
    {
        if ($despesa->user_id !== Auth::id()) {
            abort(403, 'Acesso negado');
        }
    }
}
