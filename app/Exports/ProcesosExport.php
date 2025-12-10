<?php

namespace App\Exports;

use App\Models\Proceso;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProcesosExport implements FromCollection
{
    protected $user;

    // ✔ Recibimos el usuario logueado
    public function __construct($user)
    {
        $this->user = $user;
    }

    public function collection()
    {
        $query = Proceso::query();

        // ================================
        // 📌 Si el usuario es ABOGADO (role_id = 2)
        // ================================
        if ($this->user->role_id == 2) {
            $lawyer = \App\Models\Lawyer::where('user_id', $this->user->id)->first();

            if ($lawyer) {
                $query->where('lawyer_id', $lawyer->id);
            }
        }

        // ================================
        // 📌 Si el usuario es ASISTENTE (role_id = 3)
        // ================================
        if ($this->user->role_id == 3) {
            $assistant = $this->user->assistant;

            if ($assistant) {
                $lawyerIds = $assistant->lawyers()->pluck('lawyer_id');
                $query->whereIn('lawyer_id', $lawyerIds);
            }
        }

        return $query->select(
            'numero_radicado',
            'tipo_proceso',
            'demandante',
            'demandado',
            'estado',
            'created_at'
        )->get();
    }
}
