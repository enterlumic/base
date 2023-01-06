<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoEnvio extends Model
{
    use HasFactory;
    public $table = "tipoenvio";
    protected $fillable =   ['Id'
                            ,'Descripcion'
                            ,'IdProveedor'
                            ,'Imagen'
                            ,'Dias'
                            ,'Status'
                            ,'Activo'
                            ,'IdGrupo'
                            ,'label'
                            ,'tipo_cobertura'];

    public $timestamps = false;
}