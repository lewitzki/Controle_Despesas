<?php

namespace App\Http\Controllers;

use App\Models\Despesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DespesaController extends Controller
{
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