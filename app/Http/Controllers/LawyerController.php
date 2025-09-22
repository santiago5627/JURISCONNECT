<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lawyer;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendCredentialsToLawyer;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class LawyerController
{
    /**
     * Verificar duplicados en correo y número de documento
     */
    public function checkDuplicates(Request $request)
    {
        $duplicates = [];

        if (Lawyer::where('numero_documento', $request->numero_documento)
                ->when($request->current_id, fn($q) => $q->where('id', '!=', $request->current_id))
                ->exists()) {
            $duplicates[] = ['field' => 'numero_documento', 'value' => $request->numero_documento];
        }

        if (Lawyer::where('correo', $request->correo)
                ->when($request->current_id, fn($q) => $q->where('id', '!=', $request->current_id))
                ->exists()) {
            $duplicates[] = ['field' => 'correo', 'value' => $request->correo];
        }

        return response()->json(['duplicates' => $duplicates]);
    }

    /**
     * Verificar si un campo específico ya existe
     */
    public function checkField(Request $request)
    {
        $allowed = ['numero_documento', 'correo'];
        if (!in_array($request->field, $allowed)) {
            return response()->json(['error' => 'Campo no válido'], 400);
        }

        $exists = Lawyer::where($request->field, $request->value)->exists();
        return response()->json(['exists' => $exists]);
    }

    /**
     * Listado de abogados con paginación
     */
    public function index(Request $request)
    {
        $lawyers = Lawyer::with('user')->paginate(10);
        return view('lawyers.index', compact('lawyers'));
    }

    /**
     * Crear nuevo abogado y usuario relacionado
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
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

            // Enviar credenciales por correo
            Mail::to($validated['correo'])->send(new SendCredentialsToLawyer($user, $validated['numeroDocumento']));

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Abogado creado correctamente y credenciales enviadas.',
                    'lawyer' => $lawyer->load('user')
                ], 201);
            }

            return redirect()->route('dashboard')->with('success', 'Abogado creado y credenciales enviadas.');

        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al crear abogado',
                    'error' => $e->getMessage()
                ], 500);
            }
            return back()->with('error', 'Error al crear abogado: ' . $e->getMessage());
        }
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(Lawyer $lawyer)
    {
        return view('lawyers.edit', compact('lawyer'));
    }

    /**
     * Actualizar abogado existente y su usuario relacionado
     */
    public function update(Request $request, Lawyer $lawyer)
    {
        DB::beginTransaction();

        try {
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

            // Actualizar también el usuario asociado
            if ($lawyer->user) {
                $lawyer->user->update([
                    'name' => $validated['nombre'] . ' ' . $validated['apellido'],
                    'email' => $validated['correo'],
                    'numero_documento' => $validated['numeroDocumento'],
                ]);
            }

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Abogado actualizado correctamente.',
                    'lawyer' => $lawyer->load('user')
                ]);
            }

            return redirect()->route('lawyers.index')->with('success', 'Abogado actualizado correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar abogado',
                    'error' => $e->getMessage()
                ], 500);
            }
            return back()->with('error', 'Error al actualizar abogado: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar abogado y su usuario relacionado
     */
    public function destroy(Request $request, Lawyer $lawyer)
    {
        DB::beginTransaction();

        try {
            if ($lawyer->user_id) {
                $user = User::find($lawyer->user_id);
                if ($user) {
                    $user->delete();
                }
            }

            $lawyer->delete();

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Abogado eliminado exitosamente.'
                ]);
            }

            return redirect()->route('dashboard')->with('success', 'Abogado eliminado exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al eliminar abogado',
                    'error' => $e->getMessage()
                ], 500);
            }
            return back()->with('error', 'Error al eliminar abogado: ' . $e->getMessage());
        }
    }

    /**
     * Exportar listado de abogados en PDF
     */
    public function exportPDF()
    {
        $lawyers = Lawyer::orderBy('nombre')->get();
        $logoPath = public_path('img/LogoInsti.png');

        $pdf = Pdf::loadView('exports.lawyers-pdf', compact('lawyers', 'logoPath'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('listado_abogados.pdf');
    }
}
