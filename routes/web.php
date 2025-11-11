<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DespesaController;


Route::get('/', function () {
    return redirect()->route('dashboard');
});


// Autenticação geradas pela instalação do Breeze


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        //  criar view dashboard separada
        return view('dashboard');
    })->name('dashboard');


    Route::resource('despesas', DespesaController::class);
});


require __DIR__ . '/auth.php';
