<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function updatePhoto(Request $request)
{
    Log::info('Request completo:', $request->all());
    Log::info('Tiene archivo:', ['tiene' => $request->hasFile('profile_photo')]);
    Log::info('Archivo:', ['file' => $request->file('profile_photo')]);

    $request->validate([
        'profile_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $user = $request->user();

    if (!empty($user->foto_perfil)) {
        Storage::disk('public')->delete($user->foto_perfil);
    }

    $path = $request->file('profile_photo')->store('profile_photos', 'public');

    $user->foto_perfil = $path;
    $user->save();

    return response()->json([
        'success' => true,
        'url' => Storage::url($path),
        'message' => 'Foto actualizada correctamente'
    ]);
}
}
