<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reportventas4 extends Model
{
    use HasFactory;
    public $table = "report_performance_ventas_4";

    protected $fillable = [ 'user_id',
                    'Nombre_Completo',
                              'Fecha',
                              'Turno',
                            'Entrada',
                             'Salida',
                       'Departamento',
                             'Puesto',
                           'Etiqueta',
                        'Descripcion',
                           'MEntrada',
                            'MSalida',
                       'IdMovimiento',
    ];
}
