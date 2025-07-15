<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(Request $request): View
    {
        return view('auth.reset-password', [
            'request' => $request,
            'token' => $request->route('token'),
            'email' => $request->email
        ]);
    }

    /**
     * Handle an incoming new password request.
     */
    public function store(Request $request)
    {
        // Lógica para procesar el restablecimiento de contraseña
        // Este método procesará el formulario cuando el usuario envíe la nueva contraseña
        // Aquí puedes validar la solicitud y actualizar la contraseña del usuario
        // Por ejemplo:
        // $request->valient 
        // $request->validate({})
        // $user = User::where('email', $request->email)



    }
}