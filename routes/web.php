<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasutijumsController;
use App\Http\Controllers\AtsauksmeController;
use App\Http\Controllers\AdminController;
use App\Models\Filiale;
use App\Models\Materiali;

//public
Route::get('/', function () { return view('welcome'); })->name('home');
Route::get('/test', function () { return 'Hello World'; });
Route::get('/test2', function () { return view('auth.login'); });
Route::get('/test3', function () { return view('pricelist', ['filiales' => collect(), 'materiali' => collect()]); });
Route::get('/cenradis', function () {
    $filiales = Filiale::all();
    $materiali = Materiali::all();
    return view('pricelist', compact('filiales', 'materiali'));
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
    Route::post('/orders/{pasutijums}/materiali', [PasutijumsController::class, 'calculatePrice'])->name('orders.calculatePrice');
    Route::post('/orders/{pasutijums}/status', [PasutijumsController::class, 'updateStatus'])->name('orders.updateStatus');
    
    //atsausksme + pasutijums
    Route::post('/orders/{pasutijums}/review', [AtsauksmeController::class, 'store'])->name('reviews.store');

    // Admin — user management
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/admin/users/{user}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
});