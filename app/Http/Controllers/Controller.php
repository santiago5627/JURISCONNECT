<?php

namespace App\Http\Controllers;

use App\Models\User;


abstract class Controller

{
    public function index()
    {
        $users = User::all();

        // Verifica que compact esté correcto
        return view('users.index', compact('users'));

        // O alternativamente:
        // return view('users.index', ['users' => $users]);
    }
}
