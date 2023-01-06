<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reportventas5 extends Model
{
    use HasFactory;
    public $table = "report_performance_ventas_5";

    protected $fillable = [ 'Fecha',
                            'User_Id',
                            'Calls',
                            'Interacciones',
                            'Uso'
    ];
}
