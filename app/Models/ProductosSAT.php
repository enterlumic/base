<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductosSAT extends Model
{
    use HasFactory;
    public $table = "productos_sat_clientes";
    protected $fillable =   ['id'
                            , 'id_cliente'
                            , 'contenido'
                            , 'clave_producto'
                            , 'descripcion_producto'
                            , 'rfc'
                            , 'creado'
                            , 'creado_por'
                            , 'modificado'
                            , 'modificado_por'
    ];

    public $timestamps = false;
}
