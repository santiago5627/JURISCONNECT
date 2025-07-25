<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lawyer;
use Illuminate\Validation\ValidationException;

class LawyerController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nombre' => 'required|string|max:255',
                'apellido' => 'required|string|max:255',
                'tipoDocumento' => 'required|string|max:50',
                'numeroDocumento' => 'required|string|max:50|unique:lawyers,numero_documento',
                'correo' => 'required|email|unique:lawyers,correo',
                'telefono' => 'required|string|max:20', // Ahora es obligatorio
                'especialidad' => 'required|string|max:255', // Ahora es obligatorio
            ], [
                // Mensajes personalizados para campos obligatorios
                'nombre.required' => 'El nombre es obligatorio.',
                'apellido.required' => 'El apellido es obligatorio.',
                'tipoDocumento.required' => 'El tipo de documento es obligatorio.',
                'numeroDocumento.required' => 'El número de documento es obligatorio.',
                'numeroDocumento.unique' => 'Ya existe un abogado registrado con este número de documento.',
                'correo.required' => 'El correo electrónico es obligatorio.',
                'correo.email' => 'El formato del correo electrónico no es válido.',
                'correo.unique' => 'Ya existe un abogado registrado con este correo electrónico.',
                'telefono.required' => 'El teléfono es obligatorio.',
                'especialidad.required' => 'La especialidad es obligatoria.',
                
                // Mensajes para longitud máxima
                'nombre.max' => 'El nombre no puede tener más de 255 caracteres.',
                'apellido.max' => 'El apellido no puede tener más de 255 caracteres.',
                'tipoDocumento.max' => 'El tipo de documento no puede tener más de 50 caracteres.',
                'numeroDocumento.max' => 'El número de documento no puede tener más de 50 caracteres.',
                'telefono.max' => 'El teléfono no puede tener más de 20 caracteres.',
                'especialidad.max' => 'La especialidad no puede tener más de 255 caracteres.',
            ]);

            // Verificar duplicados adicionales por si acaso
            $existingLawyer = Lawyer::where('numero_documento', $validated['numeroDocumento'])
                                   ->orWhere('correo', $validated['correo'])
                                   ->first();
            
            if ($existingLawyer) {
                if ($existingLawyer->numero_documento === $validated['numeroDocumento']) {
                    return response()->json([
                        'message' => 'Ya existe un abogado registrado con este número de documento.'
                    ], 422);
                }
                
                if ($existingLawyer->correo === $validated['correo']) {
                    return response()->json([
                        'message' => 'Ya existe un abogado registrado con este correo electrónico.'
                    ], 422);
                }
            }

            Lawyer::create([
                'nombre' => $validated['nombre'],
                'apellido' => $validated['apellido'],
                'tipo_documento' => $validated['tipoDocumento'],
                'numero_documento' => $validated['numeroDocumento'],
                'correo' => $validated['correo'],
                'telefono' => $validated['telefono'],
                'especialidad' => $validated['especialidad'],
            ]);

            return redirect()->back()->with('success', 'Abogado creado correctamente.');
            
        } catch (ValidationException $e) {
            // Obtener el primer error de validación
            $errors = $e->validator->errors();
            $firstError = $errors->first();
            
            return response()->json([
                'message' => $firstError
            ], 422);
            
        } catch (\Exception $e) {
            // Error general
            return response()->json([
                'message' => 'Error inesperado al crear el abogado. Por favor, inténtalo de nuevo.'
            ], 500);
        }
    }
    
    public function destroy(Lawyer $lawyer)
    {
        try {
            $lawyer->delete();
            return redirect()->back()->with('success', 'Abogado eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar el abogado.');
        }
    }

    public function edit(Lawyer $lawyer)
    {
        // Si usas modal, puedes omitir esta vista, pero es estándar en Laravel
        return view('lawyers.edit', compact('lawyer'));
    }

    public function update(Request $request, Lawyer $lawyer)
    {
        try {
            $validated = $request->validate([
                'nombre' => 'required|string|max:255',
                'apellido' => 'required|string|max:255',
                'tipoDocumento' => 'required|string|max:50',
                'numeroDocumento' => 'required|string|max:50|unique:lawyers,numero_documento,' . $lawyer->id,
                'correo' => 'required|email|unique:lawyers,correo,' . $lawyer->id,
                'telefono' => 'required|string|max:20', // Ahora es obligatorio
                'especialidad' => 'required|string|max:255', // Ahora es obligatorio
            ], [
                // Mensajes personalizados para la actualización
                'nombre.required' => 'El nombre es obligatorio.',
                'apellido.required' => 'El apellido es obligatorio.',
                'tipoDocumento.required' => 'El tipo de documento es obligatorio.',
                'numeroDocumento.required' => 'El número de documento es obligatorio.',
                'numeroDocumento.unique' => 'Ya existe otro abogado registrado con este número de documento.',
                'correo.required' => 'El correo electrónico es obligatorio.',
                'correo.email' => 'El formato del correo electrónico no es válido.',
                'correo.unique' => 'Ya existe otro abogado registrado con este correo electrónico.',
                'telefono.required' => 'El teléfono es obligatorio.',
                'especialidad.required' => 'La especialidad es obligatoria.',
                
                // Mensajes para longitud máxima
                'nombre.max' => 'El nombre no puede tener más de 255 caracteres.',
                'apellido.max' => 'El apellido no puede tener más de 255 caracteres.',
                'tipoDocumento.max' => 'El tipo de documento no puede tener más de 50 caracteres.',
                'numeroDocumento.max' => 'El número de documento no puede tener más de 50 caracteres.',
                'telefono.max' => 'El teléfono no puede tener más de 20 caracteres.',
                'especialidad.max' => 'La especialidad no puede tener más de 255 caracteres.',
            ]);

            // Verificación adicional de duplicados excluyendo el registro actual
            $existingLawyer = Lawyer::where('id', '!=', $lawyer->id)
                                   ->where(function($query) use ($validated) {
                                       $query->where('numero_documento', $validated['numeroDocumento'])
                                             ->orWhere('correo', $validated['correo']);
                                   })
                                   ->first();
            
            if ($existingLawyer) {
                if ($existingLawyer->numero_documento === $validated['numeroDocumento']) {
                    return response()->json([
                        'message' => 'Ya existe otro abogado registrado con este número de documento.'
                    ], 422);
                }
                
                if ($existingLawyer->correo === $validated['correo']) {
                    return response()->json([
                        'message' => 'Ya existe otro abogado registrado con este correo electrónico.'
                    ], 422);
                }
            }

            $lawyer->update([
                'nombre' => $validated['nombre'],
                'apellido' => $validated['apellido'],
                'tipo_documento' => $validated['tipoDocumento'],
                'numero_documento' => $validated['numeroDocumento'],
                'correo' => $validated['correo'],
                'telefono' => $validated['telefono'],
                'especialidad' => $validated['especialidad'],
            ]);

            return redirect()->back()->with('success', 'Abogado actualizado correctamente.');
            
        } catch (ValidationException $e) {
            // Obtener el primer error de validación
            $errors = $e->validator->errors();
            $firstError = $errors->first();
            
            return response()->json([
                'message' => $firstError
            ], 422);
            
        } catch (\Exception $e) {
            // Error general
            return response()->json([
                'message' => 'Error inesperado al actualizar el abogado. Por favor, inténtalo de nuevo.'
            ], 500);
        }
    }
}