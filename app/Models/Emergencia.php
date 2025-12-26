<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Emergencia extends Model
{
    // Campos que se pueden asignar en masa
    protected $fillable = [
        'paciente_id',
        'tipo_emergencia',
        'sintomas',
        'gravedad',
        'latitud',
        'longitud',
        'foto',
        'estado'
    ];

    // Relación: una emergencia pertenece a un paciente (usuario)
    public function paciente()
    {
        return $this->belongsTo(\App\Models\User::class, 'paciente_id');
    }
}