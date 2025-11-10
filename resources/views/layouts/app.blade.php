@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Dashboard</h1>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div class="bg-white p-4 shadow rounded">
        <h2 class="font-semibold">Resumo rápido</h2>
        <p class="mt-2">
            Total de despesas (mês atual):
            <strong>
                R$
                {{ number_format(
                    \App\Models\Despesa::where('user_id', auth()->id())
                        ->whereYear('data', now()->year)
                        ->whereMonth('data', now()->month)
                        ->sum('valor'),
                    2,
                    ',',
                    '.'
                ) }}
            </strong>
        </p>
        <a href="{{ route('despesas.index') }}" class="inline-block mt-4 bg-blue-500 text-white px-4 py-2 rounded">
            Ver despesas
        </a>
    </div>

    <div class="bg-white p-4 shadow rounded">
        <h2 class="font-semibold">Gráfico por categoria (mês atual)</h2>
        <canvas id="chartCategorias" class="mt-3"></canvas>
    </div>
</div>

@php
    $dataChart = \App\Models\Despesa::selectRaw('categoria, SUM(valor) as total')
        ->where('user_id', auth()->id())
        ->whereYear('data', now()->year)
        ->whereMonth('data', now()->month)
        ->groupBy('categoria')
        ->get();
@endphp

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('chartCategorias').getContext('2d');
        const labels = @json($dataChart->pluck('categoria'));
        const values = @json($dataChart->pluck('total'));

        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Despesas por categoria',
                    data: values,
                    backgroundColor: [
                        '#36A2EB',
                        '#FF6384',
                        '#FFCE56',
                        '#4BC0C0',
                        '#9966FF'
                    ],
                }]
            },
        });
    });
</script>
@endpush
@endsection