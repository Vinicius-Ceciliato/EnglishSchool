<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ScheduleController extends Controller
{
    /**
     * Lista todos os alunos com um resumo do cronograma de cada um.
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

        // Quantos itens futuros cada aluno da página tem.
        $counts = Schedule::whereIn('student_id', $students->pluck('id'))
            ->whereDate('date', '>=', today())
            ->selectRaw('student_id, count(*) as total')
            ->groupBy('student_id')
            ->pluck('total', 'student_id');

        // Próximo item de cada aluno da página (uma consulta só).
        $next = Schedule::whereIn('student_id', $students->pluck('id'))
            ->whereDate('date', '>=', today())
            ->orderBy('date')
            ->orderBy('start_time')
            ->get()
            ->groupBy('student_id')
            ->map->first();

        return view('admin.schedules.index', compact('students', 'next', 'counts'));
    }

    /**
     * Cronograma de um aluno + formulário para adicionar itens.
     */
    public function show(User $student): View
    {
        abort_if($student->role !== 'student', 404);

        $entries = Schedule::where('student_id', $student->id)
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();

        return view('admin.schedules.show', compact('student', 'entries'));
    }

    /**
     * Adiciona uma aula ou tarefa ao cronograma do aluno.
     */
    public function store(Request $request, User $student): RedirectResponse
    {
        abort_if($student->role !== 'student', 404);

        $data = $this->validated($request);

        Schedule::create($data + ['student_id' => $student->id]);

        return redirect()
            ->route('admin.schedules.show', $student)
            ->with('status', 'Item adicionado ao cronograma.');
    }

    public function edit(Schedule $schedule): View
    {
        $schedule->load('student');

        return view('admin.schedules.edit', compact('schedule'));
    }

    public function update(Request $request, Schedule $schedule): RedirectResponse
    {
        $schedule->update($this->validated($request));

        return redirect()
            ->route('admin.schedules.show', $schedule->student_id)
            ->with('status', 'Item atualizado.');
    }

    public function destroy(Schedule $schedule): RedirectResponse
    {
        $studentId = $schedule->student_id;

        $schedule->delete();

        return redirect()
            ->route('admin.schedules.show', $studentId)
            ->with('status', 'Item removido do cronograma.');
    }

    /**
     * Regras de validação compartilhadas entre criar e editar.
     */
    private function validated(Request $request): array
    {
        $data = $request->validate([
            'type' => ['required', Rule::in(['aula', 'tarefa'])],
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'date' => 'required|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => [
                'nullable',
                'date_format:H:i',
                Rule::when($request->filled('start_time'), ['after:start_time']),
            ],
        ], [
            'end_time.after' => 'O horário de término precisa ser depois do início.',
        ]);

        // Campos vazios viram null.
        $data['description'] = $data['description'] ?? null;
        $data['start_time'] = $data['start_time'] ?? null;
        $data['end_time'] = $data['end_time'] ?? null;

        return $data;
    }
}