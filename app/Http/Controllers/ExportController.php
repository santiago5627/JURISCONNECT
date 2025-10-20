<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Routing\Controller;

class ExportController extends Controller
{
    public function exportUsers()
    {
        return Excel::download(new UsersExport, 'usuarios.xlsx');//nombre del archivo
    }
}