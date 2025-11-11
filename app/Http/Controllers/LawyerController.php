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
    /**
     * Mapeo de campos frontend a backend
     */
    private const FIELD_MAP = [
        'numeroDocumento' => 'numero_documento',
        'numero_documento' => 'numero_documento',
        'correo' => 'correo',
        'telefono' => 'telefono',
        'nombre' => 'nombre',
        'apellido' => 'apellido'
    ];

    /**
     * Mensajes de duplicados por campo
     */
    private const DUPLICATE_MESSAGES = [
        'numero_documento' => 'El número de documento ya está registrado',
        'correo' => 'El correo electrónico ya está registrado',
        'telefono' => 'El número de teléfono ya está registrado'
    ];

    /**
     * Verificar si existe un campo específico
     */
    public function checkField(Request $request)
    {
        try {
            $field = $request->input('field');
            $value = $request->input('value');
            $currentId = $request->input('current_id');

            // Validación de entrada
            if (!$field || $value === null || trim($value) === '') {
                return response()->json([
                    'exists' => false,
                    'message' => 'Datos incompletos'
                ]);
            }

            // Verificar que el campo sea válido
            if (!isset(self::FIELD_MAP[$field])) {
                Log::warning('Campo no válido recibido', [
                    'field' => $field,
                    'ip' => $request->ip()
                ]);
                
                return response()->json([
                    'exists' => false,
                    'message' => 'Campo no válido'
                ]);
            }

            $dbField = self::FIELD_MAP[$field];
            $exists = $this->fieldExists($dbField, $value, $currentId);

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
                'line' => $e->getLine()
            ]);
            
            return response()->json([
                'exists' => false,
                'error' => 'Error del servidor'
            ], 500);
        }
    }

    /**
     * Verificar múltiples campos por duplicados
     */
    public function checkDuplicates(Request $request)
    {
        try {
            $duplicates = [];
            $fieldsToCheck = ['numero_documento', 'correo', 'telefono'];
            $currentId = $request->input('current_id');

            foreach ($fieldsToCheck as $field) {
                $value = $request->input($field);
                
                if ($value && $this->fieldExists($field, $value, $currentId)) {
                    $duplicates[] = [
                        'field' => $field,
                        'value' => $value,
                        'message' => self::DUPLICATE_MESSAGES[$field] ?? 'El campo ya está registrado'
                    ];
                }
            }

            return response()->json([
                'success' => true,
                'duplicates' => $duplicates,
                'has_duplicates' => !empty($duplicates)
            ]);

        } catch (\Exception $e) {
            Log::error('Error en checkDuplicates', [
                'message' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => 'Error del servidor'
            ], 500);
        }
    }

    /**
     * Helper: Verificar si un campo existe en la BD
     */
    private function fieldExists(string $field, $value, $currentId = null): bool
    {
        $query = Lawyer::where($field, $value);
        
        if ($currentId && is_numeric($currentId)) {
            $query->where('id', '!=', $currentId);
        }
        
        return $query->exists();
    }

    /**
     * Crear nuevo abogado
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
                'correo' => 'required|email|max:255|unique:lawyers,correo|unique:users,email',
                'telefono' => 'nullable|string|max:20',
                'especialidad' => 'nullable|string|max:255',
            ], [
                'numeroDocumento.unique' => 'El número de documento ya existe',
                'correo.unique' => 'El correo electrónico ya existe',
                'nombre.required' => 'El nombre es obligatorio',
                'apellido.required' => 'El apellido es obligatorio',
                'tipoDocumento.required' => 'El tipo de documento es obligatorio',
            ]);

            // Crear usuario
            $user = User::create([
                'name' => trim($validated['nombre']) . ' ' . trim($validated['apellido']),
                'email' => trim(strtolower($validated['correo'])),
                'password' => Hash::make($validated['numeroDocumento']),
                'role_id' => 2,
                'numero_documento' => trim($validated['numeroDocumento']),
            ]);

            // Crear abogado
            $lawyer = Lawyer::create([
                'nombre' => trim($validated['nombre']),
                'apellido' => trim($validated['apellido']),
                'tipo_documento' => $validated['tipoDocumento'],
                'numero_documento' => trim($validated['numeroDocumento']),
                'correo' => trim(strtolower($validated['correo'])),
                'telefono' => $validated['telefono'] ?? null,
                'especialidad' => $validated['especialidad'] ?? null,
                'user_id' => $user->id,
            ]);

            DB::commit();

            // Enviar credenciales por correo (fuera de la transacción)
            $this->sendCredentials($validated['correo'], $user, $validated['numeroDocumento'], $lawyer->id);

            return $this->successResponse(
                $request,
                'Abogado creado correctamente y credenciales enviadas.',
                ['lawyer' => $lawyer],
                201,
                'dashboard'
            );

        } catch (ValidationException $e) {
            DB::rollBack();
            return $this->validationErrorResponse($request, $e);

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Error al crear abogado', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return $this->errorResponse(
                $request,
                'Error al crear abogado',
                $e->getMessage()
            );
        }
    }

    /**
     * Actualizar abogado existente
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
                'correo' => 'required|email|max:255|unique:lawyers,correo,' . $lawyer->id . '|unique:users,email,' . ($lawyer->user_id ?? 'NULL'),
                'telefono' => 'nullable|string|max:20',
                'especialidad' => 'nullable|string|max:255',
            ], [
                'numeroDocumento.unique' => 'El número de documento ya existe',
                'correo.unique' => 'El correo electrónico ya existe',
            ]);

            // Actualizar abogado
            $lawyer->update([
                'nombre' => trim($validated['nombre']),
                'apellido' => trim($validated['apellido']),
                'tipo_documento' => $validated['tipoDocumento'],
                'numero_documento' => trim($validated['numeroDocumento']),
                'correo' => trim(strtolower($validated['correo'])),
                'telefono' => $validated['telefono'] ?? null,
                'especialidad' => $validated['especialidad'] ?? null,
            ]);

            // Actualizar usuario asociado
            if ($lawyer->user) {
                $lawyer->user->update([
                    'name' => trim($validated['nombre']) . ' ' . trim($validated['apellido']),
                    'email' => trim(strtolower($validated['correo'])),
                    'numero_documento' => trim($validated['numeroDocumento']),
                ]);
            }

            DB::commit();

            return $this->successResponse(
                $request,
                'Abogado actualizado correctamente.',
                ['lawyer' => $lawyer->fresh()->load('user')],
                200,
                'lawyers.index'
            );

        } catch (ValidationException $e) {
            DB::rollBack();
            return $this->validationErrorResponse($request, $e);

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Error al actualizar abogado', [
                'lawyer_id' => $lawyer->id,
                'message' => $e->getMessage()
            ]);

            return $this->errorResponse(
                $request,
                'Error al actualizar abogado',
                $e->getMessage()
            );
        }
    }

    /**
     * Eliminar abogado
     */
    public function destroy(Request $request, Lawyer $lawyer)
    {
        DB::beginTransaction();
        
        try {
            $lawyerName = $lawyer->nombre . ' ' . $lawyer->apellido;
            $lawyerId = $lawyer->id;
            
            // Eliminar usuario asociado
            if ($lawyer->user_id) {
                $user = User::find($lawyer->user_id);
                $user?->delete();
            }

            $lawyer->delete();
            DB::commit();

            Log::info('Abogado eliminado', [
                'lawyer_id' => $lawyerId,
                'name' => $lawyerName,
                'deleted_by' => auth()->user()->email ?? 'unknown'
            ]);

            return $this->successResponse(
                $request,
                'Abogado eliminado exitosamente.',
                [],
                200,
                'dashboard'
            );

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Error al eliminar abogado', [
                'lawyer_id' => $lawyer->id,
                'message' => $e->getMessage()
            ]);

            return $this->errorResponse(
                $request,
                'Error al eliminar abogado',
                $e->getMessage()
            );
        }
    }

    /**
     * Exportar listado a PDF
     */
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
                'message' => $e->getMessage()
            ]);
            
            return back()->with('error', 'Error al generar el PDF');
        }
    }

    // ========== MÉTODOS HELPERS ==========

    /**
     * Enviar credenciales por correo
     */
    private function sendCredentials(string $email, User $user, string $password, int $lawyerId): void
    {
        try {
            Mail::to($email)->send(new SendCredentialsToLawyer($user, $password));
        } catch (\Exception $e) {
            Log::warning('Error al enviar correo, pero abogado creado', [
                'lawyer_id' => $lawyerId,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Respuesta exitosa genérica
     */
    private function successResponse(Request $request, string $message, array $data = [], int $status = 200, string $route = null)
    {
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(array_merge([
                'success' => true,
                'message' => $message
            ], $data), $status);
        }

        return redirect()->route($route ?? 'dashboard')->with('success', $message);
    }

    /**
     * Respuesta de error de validación
     */
    private function validationErrorResponse(Request $request, ValidationException $e)
    {
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        }
        
        return back()->withErrors($e->errors())->withInput();
    }

    /**
     * Respuesta de error genérica
     */
    private function errorResponse(Request $request, string $message, string $error = null, int $status = 500)
    {
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => $message,
                'error' => config('app.debug') ? $error : 'Error interno del servidor'
            ], $status);
        }
        
        return back()->with('error', $message . ($error ? ': ' . $error : ''))->withInput();
    }
}