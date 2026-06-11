<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasutijumsController;
use App\Http\Controllers\AtsauksmeController;
use App\Models\Filiale;

//public
Route::get('/', function () { return view('welcome'); })->name('home');
Route::get('/cenradis', function () {
    $filiales = Filiale::all(); // Kursabiedrs varēs parādīt filiāles un cenas
    return view('pricelist', compact('filiales'));
})->name('pricelist');

//user
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

//login
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [PasutijumsController::class, 'dashboard'])->name('dashboard');
    
    //pasutijumi
    Route::get('/orders/create', [PasutijumsController::class, 'create'])->name('orders.create');
    Route::post('/orders', [PasutijumsController::class, 'store'])->name('orders.store');
    Route::get('/orders/{pasutijums}', [PasutijumsController::class, 'show'])->name('orders.show');
    
    //atsausksme + pasutijums
    Route::post('/orders/{pasutijums}/review', [AtsauksmeController::class, 'store'])->name('reviews.store');
});