<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\StudentProfile;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'telefone' => 'required|string|max:20',
            'idade' => 'required|integer|min:4|max:99',
            'nivel' => 'required|string|in:iniciante,basico,intermediario,avancado,nao-sei',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'termos' => 'required|accepted',
        ]);

        // Cria o usuário (sempre como "student" neste formulário público)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'student',
        ]);

        // Cria o perfil de aluno vinculado
        StudentProfile::create([
            'user_id' => $user->id,
            'phone' => $request->telefone,
            'age' => $request->idade,
            'english_level' => $request->nivel,
            'payment_up_to_date' => false,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}