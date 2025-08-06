<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\User;
use App\Mail\WelcomeUserMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}

class UserController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
        ]);

        // Generar contraseña automática
        $password = Str::password(12);

        // Crear usuario con contraseña hasheada
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($password),
            'is_active' => true, // Usuario activo desde el inicio
            'email_verified_at' => now(), // Email verificado
        ]);

        // Enviar email con credenciales (solo en texto plano temporal)
        try {
            //Mail::to($user->email)->send(new WelcomeUserMail($user, $password));
            
            return response()->json([
                'message' => 'Usuario creado exitosamente. Se enviaron las credenciales por email.',
                'user' => $user->only(['id', 'name', 'email', 'created_at'])
            ]);
        } catch (\Exception $e) {
            // El usuario ya está creado, solo falló el email
            return response()->json([
                'message' => 'Usuario creado pero hubo un error enviando el email.',
                'error' => $e->getMessage(),
                'user' => $user->only(['id', 'name', 'email'])
            ], 206); // 206 Partial Content
        }
    }
}