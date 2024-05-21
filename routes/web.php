<?php
use App\Http\Controllers\ChirpController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Chirp;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //rutas con nombre
    Route::get('/chirps',[ChirpController::class,'index'] )->name('chirps.index');
    //ruta para guardar con metodo post
    Route::post('/chirps', [ChirpController::class,'store'])->name('chirps.store');

    Route::get('/chirps/{chirp}/edit',[ChirpController::class,'edit'])
        ->name('chirps.edit');
    //ruta para actualizar
    Route::put('/chirps/{chirp}/edit',[ChirpController::class,'update'])
        ->name('chirps.update');
    //ruta para borrar
    Route::delete('/chirps/{chirp}/edit',[ChirpController::class,'destroy'])
        ->name('chirps.destroy');
});

require __DIR__.'/auth.php';
