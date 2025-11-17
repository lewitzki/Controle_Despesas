@php
    $totalMes = \App\Models\Despesa::where('user_id', auth()->id())
        ->whereYear('data', now()->year)
        ->whereMonth('data', now()->month)
        ->sum('valor');

    $dataChart = \App\Models\Despesa::selectRaw('categoria, SUM(valor) as total')
        ->where('user_id', auth()->id())
        ->whereYear('data', now()->year)
        ->whereMonth('data', now()->month)
        ->groupBy('categoria')
        ->get();
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="bg-white p-6 shadow sm:rounded-lg">
            <h2 class="font-semibold text-lg text-gray-800">Resumo rápido</h2>
            <p class="mt-2 text-gray-600">
                Total de despesas (mês atual):
                <strong class="text-gray-900">
                    R$
                    {{ number_format($totalMes, 2, ',', '.') }}
                </strong>
            </p>
            <a href="{{ route('despesas.index') }}" class="inline-block mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                Ver despesas
            </a>
        </div>

        <div class="bg-white p-6 shadow sm:rounded-lg">
            <h2 class="font-semibold text-lg text-gray-800">Gráfico por categoria (mês atual)</h2>
            <div class="w-full flex justify-center mt-10">
                <div class="w-1/3">
                    <canvas class="w-full" id="chartCategorias"></canvas>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const ctx = document.getElementById('chartCategorias');
                if (!ctx) {
                    return;
                }

                const labels = @json($dataChart->pluck('categoria'));
                const values = @json($dataChart->pluck('total'));

                new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels,
                        datasets: [{
                            label: 'Despesas por categoria',
                            data: values,
                            backgroundColor: [
                                '#36A2EB',
                                '#FF6384',
                                '#FFCE56',
                                '#4BC0C0',
                                '#9966FF',
                                '#FF9F40',
                            ],
                        }],
                    },
                });
            });
        </script>
    @endpush
</x-app-layout>
