<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GradeController;
use App\Http\Controllers\Admin\MaterialController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentGradeController;
use App\Http\Controllers\StudentMaterialController;
use App\Http\Controllers\StudentScheduleController;
use Illuminate\Support\Facades\Route;

// ===== Páginas públicas =====
Route::get('/', function () {
    return view('welcome');
});

Route::view('/sobre', 'sobre')->name('sobre');
Route::view('/avaliacoes', 'avaliacoes')->name('avaliacoes');

// ===== Área do aluno =====
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Cronograma (cada aluno vê somente o seu)
    Route::get('/cronograma', [StudentScheduleController::class, 'index'])->name('cronograma.index');

    // Boletim (cada aluno vê somente o seu)
    Route::get('/boletim', [StudentGradeController::class, 'index'])->name('boletim.index');

    // Materiais (aluno vê os seus; admin também consegue abrir)
    Route::get('/materiais', [StudentMaterialController::class, 'index'])->name('materiais.index');
    Route::get('/materiais/{material}/arquivo', [StudentMaterialController::class, 'download'])->name('materiais.download');
});

// ===== Área do administrador =====
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Alunos
        Route::get('/students', [StudentController::class, 'index'])->name('students.index');
        Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
        Route::post('/students', [StudentController::class, 'store'])->name('students.store');
        Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');
        Route::put('/students/{student}', [StudentController::class, 'update'])->name('students.update');
        Route::delete('/students/{student}', [StudentController::class, 'destroy'])->name('students.destroy');
        Route::patch('/students/{student}/toggle-payment', [StudentController::class, 'togglePayment'])->name('students.toggle-payment');

        // Materiais
        Route::get('/materials', [MaterialController::class, 'index'])->name('materials.index');
        Route::post('/materials', [MaterialController::class, 'store'])->name('materials.store');
        Route::delete('/materials/{material}', [MaterialController::class, 'destroy'])->name('materials.destroy');

        // Cronograma (admin vê e altera o de todos os alunos)
        Route::get('/schedules', [ScheduleController::class, 'index'])->name('schedules.index');
        Route::get('/schedules/entries/{schedule}/edit', [ScheduleController::class, 'edit'])->name('schedules.edit');
        Route::put('/schedules/entries/{schedule}', [ScheduleController::class, 'update'])->name('schedules.update');
        Route::delete('/schedules/entries/{schedule}', [ScheduleController::class, 'destroy'])->name('schedules.destroy');
        Route::get('/schedules/{student}', [ScheduleController::class, 'show'])->name('schedules.show');
        Route::post('/schedules/{student}', [ScheduleController::class, 'store'])->name('schedules.store');

        // Boletim (admin vê e altera o de todos os alunos)
        Route::get('/grades', [GradeController::class, 'index'])->name('grades.index');
        Route::get('/grades/entries/{grade}/edit', [GradeController::class, 'edit'])->name('grades.edit');
        Route::put('/grades/entries/{grade}', [GradeController::class, 'update'])->name('grades.update');
        Route::delete('/grades/entries/{grade}', [GradeController::class, 'destroy'])->name('grades.destroy');
        Route::get('/grades/{student}', [GradeController::class, 'show'])->name('grades.show');
        Route::post('/grades/{student}', [GradeController::class, 'store'])->name('grades.store');
    });

require __DIR__.'/auth.php';