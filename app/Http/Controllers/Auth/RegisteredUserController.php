<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Lawyer;
use App\Mail\PasswordGenerated;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;


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
        // Generar una contraseña aleatoria de 4 caracteres
        $password = Str::random(4);

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

         // Enviar correo con la contraseña
        Mail::to($user->email)->send(new PasswordGenerated($user, $password));

        Auth::login($user);

        // Redirigir según rol
        if ($user->role_id == 2) {
            return redirect()->route('dashboard.abogado');
        }

        return redirect()->route('dashboard');
        return redirect(route('dashboard', absolute: false));
            $request->validate([
        'avatar' => 'required|image|max:2048', // Máx 2MB
    ]);

    $user = Auth::user();

    // Elimina el avatar anterior si existe
    if ($user->avatar) {
        Storage::disk('public')->delete('avatars/' . $user->avatar);
    }

    // Guarda el nuevo
    $file = $request->file('avatar');
    $filename = uniqid() . '.' . $file->getClientOriginalExtension();
    $file->storeAs('public/avatars', $filename);

    $user->avatar = $filename;
    $user->save();

    return back()->with('success', 'Avatar actualizado');
    
    // Verificar si el usuario ya existe por correo
    $existingUser = User::where('email', $request->email)->first();
    }

    public function validarRegistro(Request $request)
{
    // Validar el formato
    $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    // Buscar al usuario
    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return back()->withErrors(['email' => 'Este correo no está registrado.'])->withInput();
    }

    // Verificar contraseña
    if (!Hash::check($request->password, $user->password)) {
        return back()->withErrors(['password' => 'Contraseña incorrecta.'])->withInput();
    }

    // Todo bien, loguear
    Auth::login($user);

    return redirect()->route('dashboard')->with('success', 'Bienvenido de nuevo');
}


}




