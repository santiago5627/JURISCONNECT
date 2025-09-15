<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function updatePhoto(Request $request)
    {
        // Validar archivo
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('profile_photo')) {
            // Guardar en storage/app/public/profile-photos
            $path = $request->file('profile_photo')->store('profile-photos', 'public');

            // Actualizar al usuario logueado
            /** @var \App\Models\User $user */
            $user = Auth::user();
            $user->profile_photo = $path; // se guarda la ruta relativa
            $user->save();

            // Retornar URL lista para mostrar en frontend
            return response()->json([
                'success' => true,
                'url' => Storage::url($path), // /storage/profile-photos/xxxx.jpg
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No se subió ninguna imagen'
        ]);

    /**
     * Actualiza la foto de perfil del usuario autenticado.
     */
    public function updatePhoto(Request $request)
    {
        // 1. Validar que el archivo sea una imagen válida.
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Límite de 2MB
        ]);

        $user = Auth::user();

        // 2. Si el usuario ya tiene una foto, eliminar la anterior para no acumular archivos.
        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }

        // 3. Guardar la nueva imagen en `storage/app/public/profile-photos`
        // El método store() genera un nombre de archivo único automáticamente.
        $path = $request->file('profile_photo')->store('profile-photos', 'public');

        // 4. Actualizar la base de datos con la nueva ruta de la imagen.
        //$user->forceFill([
          //  'profile_photo_path' => $path,
        //])->save();

        // 5. Redireccionar a la página anterior con un mensaje de éxito.
        return redirect()->back()->with('status', '¡Foto de perfil actualizada correctamente!');
    }
}