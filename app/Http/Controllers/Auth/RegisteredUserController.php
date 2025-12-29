<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Routing\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    /**
     * Muestra la vista de registro.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Procesa un nuevo registro de usuario.
     */
    public function store(Request $request)
    {
        // Validación de datos
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => [
                'required',
                'string',
                'min:11',              // mínimo 11 caracteres
                'regex:/[A-Z]/',      // al menos una mayúscula
                'regex:/[a-z]/',      // al menos una minúscula
                'regex:/[0-9]/',      // al menos un número
                'regex:/[@$!%*?&]/',  // al menos un carácter especial
                'confirmed',          // debe coincidir con password_confirmation
            ],
        ], [
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',    
            'password.regex' => 'La contraseña debe contener al menos una mayúscula, una minúscula, un número y un carácter especial.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'email.unique' => 'El correo electrónico ya está registrado.',
        ]);

        // Crear el usuario 
        $user = User::create([  
            'name' => $request->name,
            'email' => $request->email, 
            'password' => Hash::make($request->password),   
        ]);

        // Evento de registro
        event(new Registered($user));

        // Inicia sesión automáticamente
        Auth::login($user);

        // Redirigir al dashboard o donde quieras
        return redirect()->route('dashboard')->with('success', 'Registro exitoso. ¡Bienvenido!');
    }
}
