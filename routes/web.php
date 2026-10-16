<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\MaterialController;
use App\Http\Controllers\StudentMaterialController;

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/students', [StudentController::class, 'index'])->name('students.index');
        Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
        Route::post('/students', [StudentController::class, 'store'])->name('students.store');
        Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');
        Route::put('/students/{student}', [StudentController::class, 'update'])->name('students.update');
        Route::delete('/students/{student}', [StudentController::class, 'destroy'])->name('students.destroy');
        Route::patch('/students/{student}/toggle-payment', [StudentController::class, 'togglePayment'])->name('students.toggle-payment');
        Route::get('/materials', [MaterialController::class, 'index'])->name('materials.index');
        Route::post('/materials', [MaterialController::class, 'store'])->name('materials.store');
        Route::delete('/materials/{material}', [MaterialController::class, 'destroy'])->name('materials.destroy');
    });

Route::middleware('auth')->group(function () {
    Route::get('/materiais', [StudentMaterialController::class, 'index'])->name('materiais.index');
    Route::get('/materiais/{material}/arquivo', [StudentMaterialController::class, 'download'])->name('materiais.download');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::view('/sobre', 'sobre')->name('sobre');
Route::view('/avaliacoes', 'avaliacoes')->name('avaliacoes');
use App\Http\Controllers\ReviewController;

Route::post('/avaliacoes', [ReviewController::class, 'store'])
    ->middleware('auth')
    ->name('avaliacoes.store');

require __DIR__.'/auth.php';
