<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MaterialController extends Controller
{
    /**
     * Formulário de envio + lista de materiais já enviados.
     */
    public function index(Request $request): View
    {
        $students = User::where('role', 'student')->orderBy('name')->get(['id', 'name']);

        $query = Material::with('user:id,name')->latest();

        if ($alunoId = $request->get('aluno')) {
            $query->where('user_id', $alunoId);
        }

        $materials = $query->paginate(15)->withQueryString();

        return view('admin.materials.index', compact('students', 'materials'));
    }

    /**
     * Envia um PDF e libera para um ou mais alunos.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'students' => 'required|array|min:1',
            'students.*' => [Rule::exists('users', 'id')->where('role', 'student')],
            'file' => 'required|file|mimes:pdf|max:20480', // até 20 MB
        ], [
            'students.required' => 'Selecione pelo menos um aluno.',
            'file.mimes' => 'O arquivo precisa ser um PDF.',
            'file.max' => 'O PDF pode ter no máximo 20 MB.',
        ]);

        $file = $request->file('file');

        // Guarda uma única cópia, em disco PRIVADO (storage/app/private/materials).
        $path = $file->store('materials');

        foreach (array_unique($request->students) as $studentId) {
            Material::create([
                'user_id' => $studentId,
                'title' => $request->title,
                'description' => $request->description,
                'file_path' => $path,
                'original_name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
            ]);
        }

        return redirect()
            ->route('admin.materials.index')
            ->with('status', 'Material enviado com sucesso.');
    }

    /**
     * Remove o material de um aluno (e o arquivo, se ninguém mais o usa).
     */
    public function destroy(Material $material): RedirectResponse
    {
        $path = $material->file_path;

        $material->delete();

        if (! Material::where('file_path', $path)->exists()) {
            Storage::delete($path);
        }

        return back()->with('status', 'Material removido.');
    }
}