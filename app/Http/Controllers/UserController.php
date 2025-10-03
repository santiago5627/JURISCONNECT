<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Routing\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function updateAvatar(Request $request)
{
    // AGREGADO: Log para debug
    Log::info('Request recibido:', [
        'has_file' => $request->hasFile('foto_perfil'),
        'files' => $request->allFiles(),
        'all' => $request->all()
    ]);

    // Validación MEJORADA con manejo de errores
    try {
        $request->validate([
            'foto_perfil' => 'required|image|mimes:jpeg,jpg,png|max:2048'
        ]);
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error de validación: ' . json_encode($e->errors())
        ], 422);
    }

    // Verificar que el archivo existe
    if (!$request->hasFile('foto_perfil')) {
        return response()->json([
            'success' => false,
            'message' => 'No se recibió ningún archivo'
        ], 400);
    }

    $file = $request->file('foto_perfil');

    // Verificar que el archivo es válido
    if (!$file->isValid()) {
        return response()->json([
            'success' => false,
            'message' => 'El archivo no es válido'
        ], 400);
    }

    // Guardar el archivo
    $path = $file->store('avatars', 'public');

    // Actualizar usuario (ajusta según tu modelo)
    $user = User::find(Auth::id());
    if ($user) {
        $user->profile_photo_path = $path;
        $user->save();
    } else {
        return response()->json([
            'success' => false,
            'message' => 'Usuario no encontrado'
        ], 404);
    }

    return response()->json([
        'success' => true,
        'url' => asset('storage/' . $path),
        'message' => 'Avatar actualizado correctamente'
    ]);
}}