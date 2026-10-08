<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
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
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
{
    $request->validate([
        'name'      => ['required', 'string', 'min:3', 'max:120'],
        'email'     => ['required', 'string', 'lowercase', 'email', 'max:254', 'unique:'.User::class],
        'phone'     => ['required', 'string', 'max:25'],
        'birthdate' => ['required', 'date', 'before:today'],
        'level'     => ['required', 'in:unknown,A1,A2,B1,B2,C1,C2'],
        'password'  => ['required', 'confirmed', Rules\Password::min(8)->letters()->numbers()],
    ]);

    $user = DB::transaction(function () use ($request) {
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->studentProfile()->create([
            'phone'     => $request->phone,
            'birthdate' => $request->birthdate,
            'level'     => $request->level,
        ]);

        return $user;
    });

    event(new Registered($user));
    Auth::login($user);

    return redirect(route('dashboard', absolute: false));
}

}
