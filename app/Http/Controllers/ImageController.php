<?php

// app/Http/Controllers/ImageController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function guardar(Request $request)
    {
        // 1. Validar el archivo
        $request->validate([
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // max 2MB
        ]);

        // 2. Guardar la imagen en storage/app/public/imagenes
        // El método store() genera un nombre único para evitar colisiones
        $rutaImagen = $request->file('imagen')->store('imagenes', 'public');

        // 3. (Opcional) Guardar la ruta en la base de datos
        // Por ejemplo, si un usuario sube su foto de perfil:
        // auth()->user()->update(['profile_photo_path' => $rutaImagen]);

        return back()->with('success', '¡Imagen subida correctamente!');
    }
}