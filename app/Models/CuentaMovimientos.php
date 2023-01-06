<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuentaMovimientos extends Model
{
    use HasFactory;
    public $table = "cuenta_movimientos";
    protected $fillable =   [ 'id'
                            , 'id_cliente'
                            , 'id_paypal'
                            , 'id_movimiento'
                            , 'tipo_movimiento'
                            , 'saldo_anterior'
                            , 'saldo_nuevo'
                            , 'importe'
                            , 'monto_total'
                            , 'titular_cuenta'
                            , 'refvc'
                            , 'id_concepto'
                            , 'descripcion'
                            , 'fecha_movimiento'
                            , 'creado_por'
                            , 'refInt'
                            , 'refInt2'
                            , 'modificado'
                            , 'activo'
                            ];

    public $timestamps = false;
}


