<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class GradeController extends Controller
{
    /**
     * Lista os alunos com um resumo do boletim de cada um.
     */
    public function index(Request $request): View
    {
        $query = User::where('role', 'student')
            ->with('studentProfile')
            ->orderBy('name');

        if ($search = $request->get('busca')) {
            $query->where('name', 'like', "%{$search}%");
        }

        $students = $query->paginate(15)->withQueryString();
        $ids = $students->pluck('id');

        // Quantidade de boletins e média das provas por aluno.
        $stats = Grade::whereIn('student_id', $ids)
            ->selectRaw('student_id, count(*) as total, avg(exam_score) as media')
            ->groupBy('student_id')
            ->get()
            ->keyBy('student_id');

        // Boletim mais recente de cada aluno.
        $latest = Grade::whereIn('student_id', $ids)
            ->orderByDesc('assessed_on')
            ->orderByDesc('id')
            ->get()
            ->groupBy('student_id')
            ->map->first();

        return view('admin.grades.index', compact('students', 'stats', 'latest'));
    }

    /**
     * Boletim de um aluno + formulário para lançar uma nova avaliação.
     */
    public function show(User $student): View
    {
        abort_if($student->role !== 'student', 404);

        $grades = Grade::where('student_id', $student->id)
            ->orderByDesc('assessed_on')
            ->orderByDesc('id')
            ->get();

        $average = $grades->isNotEmpty() ? $grades->avg('exam_score') : null;

        return view('admin.grades.show', compact('student', 'grades', 'average'));
    }

    public function store(Request $request, User $student): RedirectResponse
    {
        abort_if($student->role !== 'student', 404);

        Grade::create($this->validated($request) + ['student_id' => $student->id]);

        return redirect()
            ->route('admin.grades.show', $student)
            ->with('status', 'Boletim lançado.');
    }

    public function edit(Grade $grade): View
    {
        $grade->load('student');

        return view('admin.grades.edit', compact('grade'));
    }

    public function update(Request $request, Grade $grade): RedirectResponse
    {
        $grade->update($this->validated($request));

        return redirect()
            ->route('admin.grades.show', $grade->student_id)
            ->with('status', 'Boletim atualizado.');
    }

    public function destroy(Grade $grade): RedirectResponse
    {
        $studentId = $grade->student_id;

        $grade->delete();

        return redirect()
            ->route('admin.grades.show', $studentId)
            ->with('status', 'Boletim removido.');
    }

    /**
     * Regras compartilhadas entre lançar e editar.
     */
    private function validated(Request $request): array
    {
        $conceito = ['required', Rule::in(array_keys(Grade::CONCEPTS))];

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'assessed_on' => 'required|date',
            'reading' => $conceito,
            'writing' => $conceito,
            'speaking' => $conceito,
            'listening' => $conceito,
            'exam_score' => 'required|numeric|between:0,100',
            'comments' => 'nullable|string|max:1000',
        ], [
            'exam_score.between' => 'A nota da prova deve ficar entre 0 e 100.',
            'exam_score.numeric' => 'A nota da prova deve ser um número.',
        ]);

        $data['comments'] = $data['comments'] ?? null;

        return $data;
    }
}