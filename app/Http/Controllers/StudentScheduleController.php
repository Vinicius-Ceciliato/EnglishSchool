<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentScheduleController extends Controller
{
    /**
     * Cronograma do aluno logado. Só mostra itens dele (não existe ID na URL).
     */
    public function index(Request $request): View
    {
        $base = fn () => Schedule::where('student_id', $request->user()->id);

        $classes = $base()->where('type', 'aula')
            ->whereDate('date', '>=', today())
            ->orderBy('date')->orderBy('start_time')->get();

        $tasks = $base()->where('type', 'tarefa')
            ->whereDate('date', '>=', today())
            ->orderBy('date')->orderBy('start_time')->get();

        $past = $base()->whereDate('date', '<', today())
            ->orderByDesc('date')->orderByDesc('start_time')->limit(30)->get();

        return view('cronograma', compact('classes', 'tasks', 'past'));
    }
}