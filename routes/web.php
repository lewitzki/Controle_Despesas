<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DespesaController;
use App\Http\Controllers\ProfileController;


Route::get('/', function () {
    return redirect()->route('dashboard');
});


// Autenticação geradas pela instalação do Breeze


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        //  criar view dashboard separada
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('despesas', DespesaController::class);
});

require __DIR__ . '/auth.php';
