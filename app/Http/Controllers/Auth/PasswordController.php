<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\Auth\Events\PasswordReset;

class PasswordController extends Controller
{
    /**
     * Mostrar el formulario de restablecimiento
     */
    public function create(Request $request, $token = null)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    /**
     * Procesar el restablecimiento
     */
    public function update(Request $request)
    {
        // 👇 Validación estricta de contraseña + confirmación
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => [
                'required',
                'confirmed', // obliga a que coincida con password_confirmation
                PasswordRule::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ],
        ], [
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min' => 'La contraseña debe tener al menos :min caracteres.',
            'password.letters' => 'La contraseña debe incluir al menos una letra.',
            'password.mixed_case' => 'Debe incluir mayúsculas y minúsculas.',
            'password.numbers' => 'Debe incluir al menos un número.',
            'password.symbols' => 'Debe incluir al menos un carácter especial.',
        ]);

        // 👇 Restablece la contraseña
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        // 👇 Respuesta
        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', 'Contraseña restablecida correctamente.');
        }

        return back()->withErrors(['email' => 'No se pudo restablecer la contraseña.']);
    }
}
