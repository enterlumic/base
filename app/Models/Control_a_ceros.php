<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Control_a_ceros extends Model
{
    use HasFactory;
    public $table = "control_a_ceros";
    protected $fillable =   [     'id'
                                , 'IdTrab'
                                , 'Gestor'
                                , 'Ingreso'
                                , 'Baja'
                                , 'Ant'
                                , 'Turno'
                                , 'Rol'
                                , 'Descripcion'
                                , 'Departamento'
                                , 'Uso'
                                , 'Avg'
                                , 'b_status'
                            ];

    public $timestamps = false;
}
