<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB; // Agregar esta línea
class ProfileController extends Controller
{
    /**
     * Subir imagen de perfil
     */
    public function uploadImage(Request $request)
    {
        try {
            // Validar la imagen
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Máximo 2MB
            ]);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $user = Auth::user(); // Obtener usuario autenticado
                
                // Eliminar imagen anterior si existe
                if ($user->profile_photos && Storage::exists('public/uploads/' . $user->profile_photos)) {
                    Storage::delete('public/uploads/' . $user->profile_photos);
                }
                
                // Generar nombre único para el archivo
                $filename = 'profile_' . $user->id . '_' . time() . '.' . $image->getClientOriginalExtension();
                
                // Guardar la imagen
                $path = $image->storeAs('public/uploads', $filename);
                
                // MÉTODO ALTERNATIVO 1: Asignar directamente y guardar
                $user->profile_photos = $filename;
                //$user->save();
                
                // MÉTODO ALTERNATIVO 2: Usar DB directamente (descomenta si el anterior no funciona)
                /*
                DB::table('users')
                    ->where('id', $user->id)
                    ->update(['profile_photos' => $filename]);
                */
                
                // Obtener la URL pública
                $url = Storage::url('uploads/' . $filename);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Imagen de perfil actualizada exitosamente',
                    'url' => $url,
                    'filename' => $filename
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'No se encontró ninguna imagen'
            ], 400);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación: ' . implode(', ', $e->errors()['image'] ?? ['Error desconocido'])
            ], 422);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al subir la imagen: ' . $e->getMessage()
            ], 500);
        }
    }

    // Otros métodos...
    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        // También usar el método alternativo aquí si tienes problemas
        $user->name = $request->name;
        $user->email = $request->email;
        //$user->save();
        
        // O el método original: $user->update($request->only(['name', 'email']));

        return redirect()->back()->with('success', 'Perfil actualizado correctamente');
    }
}