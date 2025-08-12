<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lawyer;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendCredentialsToLawyer;
use Barryvdh\DomPDF\Facade\Pdf; // Importar DomPDF
use Illuminate\Validation\ValidationException;

class LawyerController extends Controller
{
    public function index()
    {
        $lawyers = Lawyer::with('user')->get();
        return view('lawyers.index', compact('lawyers'));
    }

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

        $lawyer = Lawyer::create([
            'nombre' => $validated['nombre'],
            'apellido' => $validated['apellido'],
            'tipo_documento' => $validated['tipoDocumento'],
            'numero_documento' => $validated['numeroDocumento'],
            'correo' => $validated['correo'],
            'telefono' => $validated['telefono'] ?? null,
            'especialidad' => $validated['especialidad'] ?? null,
        ]);

        $user = User::create([
            'name' => $validated['nombre'] . ' ' . $validated['apellido'],
            'email' => $validated['correo'],
            'password' => Hash::make($validated['numeroDocumento']),
            'role_id' => 2,
            'numero_documento' => $validated['numeroDocumento'],
        ]);

        $lawyer->user_id = $user->id;
        $lawyer->save();

        Mail::to($validated['correo'])->sendNow(new SendCredentialsToLawyer($user, $validated['numeroDocumento']));

        return redirect()->route('dashboard')->with('success', 'Abogado creado y credenciales enviadas.');
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

        return redirect()->route('lawyers.index')->with('success', 'Abogado actualizado correctamente.');
    }

    public function destroy(Lawyer $lawyer)
    {
        if ($lawyer->user_id) {
            $user = User::find($lawyer->user_id);
            if ($user) {
                $user->delete();
            }
        }

        $lawyer->delete();
        return redirect()->route('dashboard')->with('success', 'Abogado eliminado exitosamente.');
    }

    // 🔹 Método para exportar a PDF y forzar descarga
public function exportPDF()
{
    $lawyers = Lawyer::orderBy('nombre')->get();
    $logoPath = public_path('img/LogoInsti.png'); // Ruta al logo

    $pdf = Pdf::loadView('exports.lawyers-pdf', compact('lawyers', 'logoPath'))
              ->setPaper('a4', 'portrait');

    return $pdf->download('listado_abogados.pdf');
}

}
