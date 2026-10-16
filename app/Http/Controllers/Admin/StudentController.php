<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudentProfile;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::where('role', 'student')->with('studentProfile');

        if ($search = $request->get('busca')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $students = $query->orderBy('name')->paginate(15)->withQueryString();

        return view('admin.students.index', compact('students'));
    }

    public function create(): View
    {
        return view('admin.students.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'telefone' => 'required|string|max:20',
            'idade' => 'required|integer|min:4|max:99',
            'nivel' => 'required|string|in:iniciante,basico,intermediario,avancado,nao-sei',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'student',
        ]);

        StudentProfile::create([
            'user_id' => $user->id,
            'phone' => $request->telefone,
            'age' => $request->idade,
            'english_level' => $request->nivel,
            'payment_up_to_date' => $request->boolean('payment_up_to_date'),
        ]);

        return redirect()->route('admin.students.index')->with('status', 'Aluno cadastrado com sucesso.');
    }

    public function edit(User $student): View
    {
        abort_if($student->role !== 'student', 404);

        $student->loadMissing('studentProfile');

        return view('admin.students.edit', compact('student'));
    }

    public function update(Request $request, User $student): RedirectResponse
    {
        abort_if($student->role !== 'student', 404);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $student->id,
            'telefone' => 'required|string|max:20',
            'idade' => 'required|integer|min:4|max:99',
            'nivel' => 'required|string|in:iniciante,basico,intermediario,avancado,nao-sei',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $student->update([
            'name' => $request->name,
            'email' => $request->email,
            ...($request->filled('password') ? ['password' => $request->password] : []),
        ]);

        $student->studentProfile()->updateOrCreate(
            ['user_id' => $student->id],
            [
                'phone' => $request->telefone,
                'age' => $request->idade,
                'english_level' => $request->nivel,
                'payment_up_to_date' => $request->boolean('payment_up_to_date'),
            ]
        );

        return redirect()->route('admin.students.index')->with('status', 'Dados do aluno atualizados.');
    }

    public function destroy(User $student): RedirectResponse
    {
        abort_if($student->role !== 'student', 404);

        $student->delete();

        return redirect()->route('admin.students.index')->with('status', 'Aluno removido.');
    }

    public function togglePayment(User $student): RedirectResponse
    {
        abort_if($student->role !== 'student', 404);

        $profile = $student->studentProfile;

        if ($profile) {
            $profile->update(['payment_up_to_date' => ! $profile->payment_up_to_date]);
        }

        return back()->with('status', 'Status de pagamento atualizado.');
    }
}