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
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Máx 2MB
        ]);

        /** @var \App\Models\User $user */
        
        $user = Auth::user();

        // 2. Si el usuario ya tiene una foto, eliminar la anterior para no acumular archivos.
        if ($user->profile_photo) {
            Storage::disk('public')->delete('profile-photos/' . $user->profile_photo);
        }
        
        // 3. Guardar la nueva imagen en storage/app/public/profile-photos
        $fileName = time() . '_' . $request->file('profile_photo')->getClientOriginalName();
        $path = $request->file('profile_photo')->storeAs('profile-photos', $fileName, 'public');

        // 4. Guardar la ruta del archivo en la BD
        $user->profile_photo = $fileName;
        $user->save();

        // 5. Retornar éxito (puedes cambiar a JSON si usas AJAX)
        return redirect()->back()->with('status', '¡Foto de perfil actualizada correctamente!');
    }
}
