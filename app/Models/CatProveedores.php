<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatProveedores extends Model
{
    use HasFactory;
    public $table = "cat_proveedores";
    protected $fillable =   ['id'
                            ,'proveedor'
                            ,'activo'
                            ,'creado'
                            ,'modificado'
                        ];

    public $timestamps = false;
}