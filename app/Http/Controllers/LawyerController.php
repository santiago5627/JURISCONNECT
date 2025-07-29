<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lawyer;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendCredentialsToLawyer;

class LawyerController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'tipoDocumento' => 'required|string|max:50',
            'numeroDocumento' => 'required|string|max:50|unique:lawyers,numero_documento',
            'correo' => 'required|email|unique:lawyers,correo|unique:users,email',
            'telefono' => 'nullable|string|max:20',
            'especialidad' => 'nullable|string|max:255',
        ]);

        // Crear abogado
        $lawyer = Lawyer::create([
            'nombre' => $validated['nombre'],
            'apellido' => $validated['apellido'],
            'tipo_documento' => $validated['tipoDocumento'],
            'numero_documento' => $validated['numeroDocumento'],
            'correo' => $validated['correo'],
            'telefono' => $validated['telefono'] ?? null,
            'especialidad' => $validated['especialidad'] ?? null,
        ]);

        // Crear usuario con mismo correo y contraseña = número de documento
        $user = User::create([
            'name' => $validated['nombre'] . ' ' . $validated['apellido'],
            'email' => $validated['correo'],
            'password' => Hash::make($validated['numeroDocumento']),
            'role_id' => 2, // Abogado
            'numero_documento' => $validated['numeroDocumento'],
        ]);

        // Asociar abogado con usuario
        $lawyer->user_id = $user->id;
        $lawyer->save();

        // Enviar correo con credenciales
        Mail::to($validated['correo'])->send(new SendCredentialsToLawyer($user, $validated['numeroDocumento']));

        return redirect()->back()->with('success', 'Abogado creado y credenciales enviadas.');
    }

    public function destroy(Lawyer $lawyer)
    {
        $lawyer->delete();
        return redirect()->back()->with('success', 'Abogado eliminado exitosamente.');
    }

    public function edit(Lawyer $lawyer)
    {
        return view('lawyers.edit', compact('lawyer'));
    }

    public function update(Request $request, Lawyer $lawyer)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'tipoDocumento' => 'required|string|max:50',
            'numeroDocumento' => 'required|string|max:50|unique:lawyers,numero_documento,' . $lawyer->id,
            'correo' => 'required|email|unique:lawyers,correo,' . $lawyer->id,
            'telefono' => 'nullable|string|max:20',
            'especialidad' => 'nullable|string|max:255',
        ]);

        $lawyer->update([
            'nombre' => $validated['nombre'],
            'apellido' => $validated['apellido'],
            'tipo_documento' => $validated['tipoDocumento'],
            'numero_documento' => $validated['numeroDocumento'],
            'correo' => $validated['correo'],
            'telefono' => $validated['telefono'] ?? null,
            'especialidad' => $validated['especialidad'] ?? null,
        ]);

        return redirect()->back()->with('success', 'Abogado actualizado correctamente.');
    }
}
