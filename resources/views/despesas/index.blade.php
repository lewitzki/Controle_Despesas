<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Minhas Despesas') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if (session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-3 rounded shadow">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                <div>
                    <p class="text-sm text-gray-500">Total no período filtrado</p>
                    <p class="text-2xl font-semibold text-gray-900">
                        R$ {{ number_format($totalPeriodo ?? 0, 2, ',', '.') }}
                    </p>
                </div>

                <a href="{{ route('despesas.create') }}"
                   class="inline-flex items-center justify-center px-4 py-2 bg-green-600 text-white font-semibold rounded hover:bg-green-700 transition">
                    Nova Despesa
                </a>
            </div>

            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div>
                    <label for="mes" class="block text-sm font-medium text-gray-700 mb-1">Mês</label>
                    <select id="mes" name="mes" class="w-full border-gray-300 rounded shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Todos</option>
                        @foreach ($meses as $numero => $nomeMes)
                            <option value="{{ $numero }}" @selected((string) $mesSelecionado === (string) $numero)>
                                {{ $nomeMes }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="categoria" class="block text-sm font-medium text-gray-700 mb-1">Categoria</label>
                    <input id="categoria"
                           type="text"
                           name="categoria"
                           value="{{ old('categoria', $categoriaSelecionada) }}"
                           class="w-full border-gray-300 rounded shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                           placeholder="Ex.: Alimentação" />
                </div>

                <div class="md:col-span-2">
                    <label for="busca" class="block text-sm font-medium text-gray-700 mb-1">Buscar descrição</label>
                    <div class="flex gap-2">
                        <input id="busca"
                               type="text"
                               name="busca"
                               value="{{ old('busca', $busca) }}"
                               class="w-full border-gray-300 rounded shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                               placeholder="Digite parte da descrição" />

                        <button type="submit"
                                class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded hover:bg-indigo-700 transition">
                            Filtrar
                        </button>

                        <a href="{{ route('despesas.index') }}"
                           class="px-4 py-2 bg-gray-200 text-gray-800 font-semibold rounded hover:bg-gray-300 transition">
                            Limpar
                        </a>
                    </div>
                </div>
            </form>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descrição</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoria</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Valor</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($despesas as $despesa)
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-900">{{ $despesa->descricao }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $despesa->categoria }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">
                                    {{ \Carbon\Carbon::parse($despesa->data)->format('d/m/Y') }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900 text-right font-semibold">
                                    R$ {{ number_format($despesa->valor, 2, ',', '.') }}
                                </td>
                                <td class="px-4 py-3 text-sm text-center">
                                    <a href="{{ route('despesas.edit', $despesa) }}"
                                       class="text-indigo-600 hover:text-indigo-900 font-semibold mr-3">
                                        Editar
                                    </a>
                                    <form action="{{ route('despesas.destroy', $despesa) }}" method="POST" class="inline-block"
                                          onsubmit="return confirm('Deseja realmente excluir esta despesa?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">
                                            Excluir
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-sm text-gray-500">
                                    Nenhuma despesa encontrada para os filtros selecionados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $despesas->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
