<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\WelcomeUserMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


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
