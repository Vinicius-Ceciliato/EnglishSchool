<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentGradeController extends Controller
{
    /**
     * Boletim do aluno logado. Não existe ID na URL: só aparecem os dados dele.
     */
    public function index(Request $request): View
    {
        $grades = Grade::where('student_id', $request->user()->id)
            ->orderByDesc('assessed_on')
            ->orderByDesc('id')
            ->get();

        $average = $grades->isNotEmpty() ? $grades->avg('exam_score') : null;

        return view('boletim', compact('grades', 'average'));
    }
}