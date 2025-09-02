<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    /**
     * Actualizar la foto de perfil del usuario
     */
    public function updateProfilePhoto(Request $request)
    {
        try {
            // Log para debug
            Log::info('Intentando subir foto de perfil', [
                'user_id' => Auth::id(),
                'file_present' => $request->hasFile('profile_photo')
            ]);

            // Validar el archivo
            $request->validate([
                'profile_photo' => [
                    'required',
                    'file',
                    'image',
                    'mimes:jpeg,jpg,png',
                    'max:2048', // 2MB máximo
                ],
            ], [
                'profile_photo.required' => 'Debe seleccionar una imagen.',
                'profile_photo.file' => 'El archivo debe ser una imagen válida.',
                'profile_photo.image' => 'El archivo debe ser una imagen.',
                'profile_photo.mimes' => 'Solo se permiten archivos JPG, JPEG y PNG.',
                'profile_photo.max' => 'La imagen no debe ser mayor a 2MB.',
            ]);

            $user = Auth::user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no autenticado.'
                ], 401);
            }

            // Verificar que el directorio existe
            if (!Storage::disk('public')->exists('profile-photos')) {
                Storage::disk('public')->makeDirectory('profile-photos');
            }

            // Eliminar la foto anterior si existe
            if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
                Storage::disk('public')->delete($user->profile_photo_path);
                Log::info('Foto anterior eliminada', ['path' => $user->profile_photo_path]);
            }

            // Guardar la nueva foto
            $file = $request->file('profile_photo');
            $filename = 'profile_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('profile-photos', $filename, 'public');
            
            Log::info('Nueva foto guardada', ['path' => $path]);

            // Actualizar el usuario
            $user->profile_photo_path = $path;
            $user->Auth::save();

            $photoUrl = Storage::url($path);

            Log::info('Foto de perfil actualizada correctamente', [
                'user_id' => $user->id,
                'path' => $path,
                'url' => $photoUrl
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Imagen de perfil actualizada correctamente.',
                'url' => $photoUrl
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Error de validación al subir foto', ['errors' => $e->errors()]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error de validación.',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error('Error al subir foto de perfil', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor: ' . $e->getMessage()
            ], 500);
        }
    }
}