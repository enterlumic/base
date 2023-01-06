<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;
    public $table = "empleado";

    protected $fillable = [
        'IdTrab',
        'Nombre',
        'Paterno', 
        'Materno',
        'FechaIngreso', 
        'FechaBaja',
        'CentroCosto', 
        'Departamento', 
        'Puesto', 
        'Active', 
        'DateCreated', 
        'DateModified' 
    ];
}
