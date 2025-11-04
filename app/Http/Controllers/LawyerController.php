<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lawyer;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendCredentialsToLawyer;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Routing\Controller;

class LawyerController extends Controller
{
    public function checkDuplicates(Request $request)
    {
        try {
            $duplicates = [];

            // Verificar número de documento
            if ($request->has('numero_documento') && $request->numero_documento) {
                $query = Lawyer::where('numero_documento', $request->numero_documento);
                
                if ($request->has('current_id') && $request->current_id) {
                    $query->where('id', '!=', $request->current_id);
                }
                
                if ($query->exists()) {
                    $duplicates[] = [
                        'field' => 'numero_documento',
                        'value' => $request->numero_documento,
                        'message' => 'El número de documento ya está registrado'
                    ];
                }
            }

            // Verificar correo
            if ($request->has('correo') && $request->correo) {
                $query = Lawyer::where('correo', $request->correo);
                
                if ($request->has('current_id') && $request->current_id) {
                    $query->where('id', '!=', $request->current_id);
                }
                
                if ($query->exists()) {
                    $duplicates[] = [
                        'field' => 'correo',
                        'value' => $request->correo,
                        'message' => 'El correo electrónico ya está registrado'
                    ];
                }
            }

            // Verificar numero de telefono
            if ($request->has('telefono') && $request->telefono) {
                $query = Lawyer::where('telefono', $request->telefono);
                
                if ($request->has('current_id') && $request->current_id) {
                    $query->where('id', '!=', $request->current_id);
                }
                
                if ($query->exists()) {
                    $duplicates[] = [
                        'field' => 'telefono',
                        'value' => $request->telefono   ,
                        'message' => 'El correo electrónico ya está registrado'
                    ];
                }
            }

            return response()->json([
                'success' => true,
                'duplicates' => $duplicates,
                'has_duplicates' => count($duplicates) > 0
            ]);

        } catch (\Exception $e) {
            Log::error('Error en checkDuplicates', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => 'Error del servidor',
                'message' => config('app.debug') ? $e->getMessage() : 'Error interno del servidor'
            ], 500);
        }
    }

    public function checkField(Request $request)
    {
        try {
            $field = $request->input('field');
            $value = $request->input('value');
            $currentId = $request->input('current_id');

            // Log para debugging
            Log::info('checkField llamado', [
                'field' => $field,
                'value' => $value,
                'currentId' => $currentId,
                'ip' => $request->ip()
            ]);

            // Validación de entrada
            if (!$field || $value === null || trim($value) === '') {
                return response()->json([
                    'exists' => false,
                    'message' => 'Datos incompletos'
                ]);
            }

            // Mapeo de nombres de campos del frontend al backend
            $fieldMap = [
                'numeroDocumento' => 'numero_documento',
                'numero_documento' => 'numero_documento',
                'correo' => 'correo',
                'nombre' => 'nombre',
                'apellido' => 'apellido'
            ];

            // Verificar que el campo sea válido
            if (!isset($fieldMap[$field])) {
                Log::warning('Campo no válido recibido', [
                    'field' => $field,
                    'ip' => $request->ip()
                ]);
                
                return response()->json([
                    'exists' => false,
                    'message' => 'Campo no válido'
                ]);
            }

            $dbField = $fieldMap[$field];

            // Construir query
            $query = Lawyer::where($dbField, $value);
            
            // Si estamos editando, excluir el registro actual
            if ($currentId && is_numeric($currentId)) {
                $query->where('id', '!=', $currentId);
            }

            $exists = $query->exists();

            Log::info('Resultado de validación', [
                'field' => $field,
                'dbField' => $dbField,
                'exists' => $exists
            ]);

            return response()->json([
                'exists' => $exists,
                'field' => $field,
                'value' => $value
            ]);

        } catch (\Exception $e) {
            Log::error('Error en checkField', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'exists' => false,
                'error' => 'Error del servidor',
                'message' => config('app.debug') ? $e->getMessage() : 'Error interno'
            ], 500);
        }
    }

    /**
     * Crear nuevo abogado
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nombre' => 'required|string|max:255',
                'apellido' => 'required|string|max:255',
                'tipoDocumento' => 'required|string|max:50',
                'numeroDocumento' => 'required|string|max:50|unique:lawyers,numero_documento',
                'correo' => 'required|email|max:255|unique:lawyers,correo|unique:users,email',
                'telefono' => 'nullable|string|max:20',
                'especialidad' => 'nullable|string|max:255',
            ], [
                'numeroDocumento.unique' => 'El número de documento ya existe en el sistema',
                'correo.unique' => 'El correo electrónico ya existe en el sistema',
                'nombre.required' => 'El nombre es obligatorio',
                'apellido.required' => 'El apellido es obligatorio',
                'tipoDocumento.required' => 'El tipo de documento es obligatorio',
            ]);

            $lawyer = Lawyer::create([
                'nombre' => trim($validated['nombre']),
                'apellido' => trim($validated['apellido']),
                'tipo_documento' => $validated['tipoDocumento'],
                'numero_documento' => trim($validated['numeroDocumento']),
                'correo' => trim(strtolower($validated['correo'])),
                'telefono' => $validated['telefono'] ?? null,
                'especialidad' => $validated['especialidad'] ?? null,
            ]);

            $user = User::create([
                'name' => trim($validated['nombre']) . ' ' . trim($validated['apellido']),
                'email' => trim(strtolower($validated['correo'])),
                'password' => Hash::make($validated['numeroDocumento']),
                'role_id' => 2,
                'numero_documento' => trim($validated['numeroDocumento']),
            ]);
            
            $lawyer->user_id = $user->id;
            $lawyer->save();

            // Enviar credenciales por correo
            try {
                Mail::to($validated['correo'])->send(new SendCredentialsToLawyer($user, $validated['numeroDocumento']));
            } catch (\Exception $mailError) {
                Log::warning('Error al enviar correo, pero abogado creado', [
                    'lawyer_id' => $lawyer->id,
                    'error' => $mailError->getMessage()
                ]);
            }

            DB::commit();

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Abogado creado correctamente y credenciales enviadas.',
                    'lawyer' => $lawyer
                ], 201);
            }

            return redirect()->route('dashboard')->with('success', 'Abogado creado y credenciales enviadas.');

        } catch (ValidationException $e) {
            DB::rollBack();

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors' => $e->errors()
                ], 422);
            }
            
            return back()->withErrors($e->errors())->withInput();

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Error al crear abogado', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al crear abogado',
                    'error' => config('app.debug') ? $e->getMessage() : 'Error interno del servidor'
                ], 500);
            }
            
            return back()->with('error', 'Error al crear abogado: ' . $e->getMessage())->withInput();
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
     * Actualizar abogado existente
     */
    public function update(Request $request, Lawyer $lawyer)
    {
        try {
            $validated = $request->validate([
                'nombre' => 'required|string|max:255',
                'apellido' => 'required|string|max:255',
                'tipoDocumento' => 'required|string|max:50',
                'numeroDocumento' => 'required|string|max:50|unique:lawyers,numero_documento,' . $lawyer->id,
                'correo' => 'required|email|max:255|unique:lawyers,correo,' . $lawyer->id . '|unique:users,email,' . ($lawyer->user_id ?? 'NULL'),
                'telefono' => 'nullable|string|max:20',
                'especialidad' => 'nullable|string|max:255',
            ], [
                'numeroDocumento.unique' => 'El número de documento ya existe en el sistema',
                'correo.unique' => 'El correo electrónico ya existe en el sistema',
            ]);

            $lawyer->update([
                'nombre' => trim($validated['nombre']),
                'apellido' => trim($validated['apellido']),
                'tipo_documento' => $validated['tipoDocumento'],
                'numero_documento' => trim($validated['numeroDocumento']),
                'correo' => trim(strtolower($validated['correo'])),
                'telefono' => $validated['telefono'] ?? null,
                'especialidad' => $validated['especialidad'] ?? null,
            ]);

            // Actualizar también el usuario asociado
            if ($lawyer->user) {
                $lawyer->user->update([
                    'name' => trim($validated['nombre']) . ' ' . trim($validated['apellido']),
                    'email' => trim(strtolower($validated['correo'])),
                    'numero_documento' => trim($validated['numeroDocumento']),
                ]);
            }

            DB::commit();

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Abogado actualizado correctamente.',
                    'lawyer' => $lawyer->fresh()->load('user')
                ]);
            }

            return redirect()->route('lawyers.index')->with('success', 'Abogado actualizado correctamente.');

        } catch (ValidationException $e) {
            DB::rollBack();

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación',
                    'errors' => $e->errors()
                ], 422);
            }
            
            return back()->withErrors($e->errors())->withInput();

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Error al actualizar abogado', [
                'lawyer_id' => $lawyer->id,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar abogado',
                    'error' => config('app.debug') ? $e->getMessage() : 'Error interno del servidor'
                ], 500);
            }
            
            return back()->with('error', 'Error al actualizar abogado: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Request $request, Lawyer $lawyer)
    {
        try {
            $lawyerName = $lawyer->nombre . ' ' . $lawyer->apellido;
            
            if ($lawyer->user_id) {
                $user = User::find($lawyer->user_id);
                if ($user) {
                    $user->delete();
                }
            }

            $lawyer->delete();

            DB::commit();

            Log::info('Abogado eliminado', [
                'lawyer_id' => $lawyer->id,
                'name' => $lawyerName,
                'deleted_by' => auth()->Auth::classuser()->email ?? 'unknown'
            ]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Abogado eliminado exitosamente.'
                ]);
            }
 
            return redirect()->route('dashboard')->with('success', 'Abogado eliminado exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Error al eliminar abogado', [
                'lawyer_id' => $lawyer->id,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al eliminar abogado',
                    'error' => config('app.debug') ? $e->getMessage() : 'Error interno del servidor'
                ], 500);
            }
            
            return back()->with('error', 'Error al eliminar abogado: ' . $e->getMessage());
        }
    }

    public function exportPDF()
    {
        try {
            $lawyers = Lawyer::orderBy('nombre')->get();
            $logoPath = public_path('img/LogoInsti.png');

            $pdf = Pdf::loadView('exports.lawyers-pdf', compact('lawyers', 'logoPath'))
                ->setPaper('a4', 'portrait');

            return $pdf->download('listado_abogados_' . date('Y-m-d') . '.pdf');
            
        } catch (\Exception $e) {
            Log::error('Error al exportar PDF de abogados', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->with('error', 'Error al generar el PDF');
        }
    }
}