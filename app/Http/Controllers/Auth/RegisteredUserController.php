<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Lawyer;
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
     * Muestra la vista de registro
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Procesa el registro de un nuevo usuario
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'numero_documento' => ['required', 'string'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Verifica si el abogado ya está registrado por el admin
        $lawyer = Lawyer::where('correo', $request->email)
            ->where('numero_documento', $request->numero_documento)
            ->first();

        if (!$lawyer) {
            return back()->withErrors([
                'email' => 'Este correo no está registrado como abogado.'
            ])->withInput();
        }

        // Crear el usuario con rol de abogado
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 2, // Abogado
        ]);

        // Relacionar al abogado con el nuevo usuario
        $lawyer->user_id = $user->id;
        $lawyer->save();

        event(new Registered($user));

        Auth::login($user);

        // Redirigir según rol
        if ($user->role_id == 2) {
            return redirect()->route('dashboard.abogado');
        }

        return redirect()->route('dashboard');
    }
}
