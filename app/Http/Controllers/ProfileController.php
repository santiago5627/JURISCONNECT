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
    }
}
