@extends('layouts.app')


@section('content')
<div class="flex justify-between items-center mb-4">
<h1 class="text-xl font-bold">Minhas Despesas</h1>
<a href="{{ route('despesas.create') }}" class="bg-green-500 text-white px-3 py-1 rounded">Nova Despesa</a>
</div>


<form method="GET" class="mb-4 flex gap-2">
<select name="mes" class="border p-1">
<option value="">Todos os meses</option>