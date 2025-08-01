<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ImageController extends Controller
{
    public function store(Request $request)
    {
        // 1. Verificar si el usuario está autenticado
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no autenticado. Por favor, inicia sesión.'
            ], 401);
        }

        try {
            // 2. Validar la imagen
            $request->validate([
                'image' => 'required|image|mimes:jpg,jpeg,png|max:2048', // 2MB máximo
            ]);

            // 3. Obtener el archivo y guardarlo
            $file = $request->file('image');
            $path = $file->store('profile_photos', 'public');

            // 4. Eliminar la foto anterior del usuario si existe
            if ($user->photo) {
                if (Storage::disk('public')->exists($user->photo) && !str_contains($user->photo, 'img/')) {
                    Storage::disk('public')->delete($user->photo);
                }
            }

            // 5. Actualizar la ruta de la nueva foto del usuario
            $user->photo = $path;
            
            // OPCIONES PARA CORREGIR EL ERROR DE SAVE:
            
            // OPCIÓN 1: Usar update() en lugar de save()
            $user->Auth::update(['photo' => $path]);
            
            // OPCIÓN 2: Usar save() con verificación adicional
            // if (!$user->save()) {
            //     throw new \Exception('No se pudo guardar la imagen en la base de datos');
            // }
            
            // OPCIÓN 3: Usar fill() y save()
            // $user->fill(['photo' => $path]);
            // $user->save();

            // 6. Devolver una respuesta JSON de éxito
            return response()->json([
                'success' => true,
                'message' => 'Imagen actualizada exitosamente',
                'path' => $path,
                'url' => Storage::url($path) // URL pública para mostrar la imagen
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Error de validación al subir la imagen para el usuario ' . ($user ? $user->id : 'N/A') . ': ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error de validación: ' . $e->getMessage(),
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error('Error al subir la imagen para el usuario ' . ($user ? $user->id : 'N/A') . ': ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor al subir la imagen. Por favor, inténtalo de nuevo.'
            ], 500);
        }
    }
}