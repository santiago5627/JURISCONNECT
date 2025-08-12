<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;



class ProfileController extends Controller
{
    public function upload(Request $request)
    {
        try {
            // Validar que venga la imagen
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            $user = Auth::user();

            // Guardar imagen
            $path = $request->file('image')->store('profiles', 'public');

            // Actualizar en la base de datos
            $user->profile_photos = $path;
            //$user->save();

            // Retornar la URL completa para mostrarla en el JS
            return response()->json([
                'success' => true,
                'url' => asset('storage/' . $path)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
