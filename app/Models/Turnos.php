<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turnos extends Model
{
    use HasFactory;
    public $table = "turnos";
    protected $fillable =   [     'id'
                                , 'IdTrab'
                                , 'Gestor'
                                , 'Ingreso'
                                , 'Descripcion'
                                , 'Descripcion'
                                , 'Rol'
                                , 'Departamento'
                                , 'Puesto'
                                , 'Centro_Costo'
                                , 'b_status'
                            ];

    public $timestamps = false;
}
