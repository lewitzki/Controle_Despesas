<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Despesa') }}
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <form method="POST" action="{{ route('despesas.update', $despesa) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="descricao" class="block text-sm font-medium text-gray-700">
                        Descrição
                    </label>
                    <input id="descricao"
                           name="descricao"
                           type="text"
                           value="{{ old('descricao', $despesa->descricao) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                           required
                           maxlength="255" />
                    @error('descricao')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="valor" class="block text-sm font-medium text-gray-700">
                            Valor (R$)
                        </label>
                        <input id="valor"
                               name="valor"
                               type="number"
                               step="0.01"
                               min="0"
                               value="{{ old('valor', $despesa->valor) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                               required />
                        @error('valor')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="categoria" class="block text-sm font-medium text-gray-700">
                            Categoria
                        </label>
                        <input id="categoria"
                               name="categoria"
                               type="text"
                               value="{{ old('categoria', $despesa->categoria) }}"
                               maxlength="100"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                               required />
                        @error('categoria')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="data" class="block text-sm font-medium text-gray-700">
                        Data
                    </label>
                    <input id="data"
                           name="data"
                           type="date"
                           value="{{ old('data', \Carbon\Carbon::parse($despesa->data)->format('Y-m-d')) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                           required />
                    @error('data')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('despesas.index') }}"
                       class="px-4 py-2 rounded border border-gray-300 text-gray-700 hover:bg-gray-50">
                        Cancelar
                    </a>
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Atualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
