<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Database\Eloquent\Model;
class UserController extends Controller
{
    public function updateAvatar(Request $request)
    {
        try {
            $request->validate([
                'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $user = Auth::user();

            $user = Auth::user();

            if (!$user instanceof \App\Models\User) {
                throw new Exception('Authenticated user is not an instance of the User model.');
            }
            if ($user->avatar && Storage::disk('public')->exists('avatars/' . $user->avatar)) {
                Storage::disk('public')->delete('avatars/' . $user->avatar);
            }

            // Subir y guardar nuevo avatar
            $file = $request->file('avatar');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('avatars', $filename, 'public');

            // Actualizar usuario usando update en lugar de save
            $user->avatar = $filename;
            $user->save();

            return back()->with('success', 'Avatar actualizado correctamente.');

        } catch (Exception $e) {
            // Log del error para debugging
            Log::error('Error al actualizar avatar: ' . $e->getMessage());
            
            return back()->with('error', 'Error al actualizar el avatar: ' . $e->getMessage());
        }
    }
}