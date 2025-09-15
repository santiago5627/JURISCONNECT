<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lawyer;

class AdminController extends Controller
{
    public function index()
    {
        $lawyers = Lawyer::paginate(10);
        return view('dashboard', compact('lawyers'));
    }
}

