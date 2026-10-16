<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class StudentMaterialController extends Controller
{
    /**
     * Lista os materiais liberados para o aluno logado.
     */
    public function index(Request $request): View
    {
        $materials = Material::where('user_id', $request->user()->id)
            ->latest()
            ->get();

        return view('materiais', compact('materials'));
    }

    /**
     * Abre o PDF. Só o admin ou o aluno dono do material podem acessar.
     */
    public function download(Request $request, Material $material)
    {
        $user = $request->user();

        abort_unless($user->role === 'admin' || $material->user_id === $user->id, 403);
        abort_unless(Storage::exists($material->file_path), 404);

        return Storage::response(
            $material->file_path,
            $material->original_name,
            ['Content-Type' => 'application/pdf']
        );
    }
}