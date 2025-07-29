<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log; // Importar la fachada Log


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
            ], 401); // Código de estado 401 para "Unauthorized"
        }

        try {
            // 2. Validar la imagen
            $request->validate([
                'image' => 'required|image|mimes:jpg,jpeg,png|max:2048', // 2MB máximo
            ]);

            // 3. Obtener el archivo y guardarlo
            $file = $request->file('image');
            // 'profile_photos' es la carpeta dentro de 'storage/app/public'
            // 'public' indica que se guardará en el disco 'public' configurado en filesystems.php
            $path = $file->store('profile_photos', 'public');

            // 4. Eliminar la foto anterior del usuario si existe
            if ($user->photo) {
                // Asegúrate de que la ruta sea relativa al disco 'public'
                // y que no se intente borrar una imagen por defecto (como 'img/descarga.jpeg')
                if (Storage::disk('public')->exists($user->photo) && !str_contains($user->photo, 'img/')) {
                    Storage::disk('public')->delete($user->photo);
                }
            }

            // 5. Actualizar la ruta de la nueva foto del usuario
            $user->photo = $path;
            $user->Auth::save(); // Esta línea ahora debería ser segura si $user no es null

            // 6. Devolver una respuesta JSON de éxito
            return response()->json([
                'success' => true,
                'message' => 'Imagen actualizada exitosamente',
                'path' => $path // Devolvemos la ruta para que el JS pueda actualizar la imagen
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Capturar errores de validación específicos
            Log::error('Error de validación al subir la imagen para el usuario ' . ($user ? $user->id : 'N/A') . ': ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error de validación: ' . $e->getMessage(),
                'errors' => $e->errors()
            ], 422); // Código de estado 422 para errores de validación

        } catch (\Exception $e) {
            // Capturar cualquier otro error inesperado
            // Loguear el error para depuración
            // Usamos un operador ternario para acceder a $user->id de forma segura
            Log::error('Error al subir la imagen para el usuario ' . ($user ? $user->id : 'N/A') . ': ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor al subir la imagen. Por favor, inténtalo de nuevo.'
            ], 500); // Código de estado 500 para errores internos del servidor
        }
    }
}