<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reportventas2 extends Model
{
    use HasFactory;
    public $table = "report_performance_ventas_2";

    protected $fillable = [
        'fecha',
        'user_id',
        'ventas'
    ];
}

