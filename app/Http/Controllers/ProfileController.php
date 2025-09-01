<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
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