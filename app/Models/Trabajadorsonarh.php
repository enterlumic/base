<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trabajadorsonarh extends Model
{
    use HasFactory;
    public $table = "trabajadorsonarh";
    protected $fillable =   [     'id'
                                , 'Nombre'
                                , 'Paterno'
                                , 'Materno'
                                , 'FechaIngreso'
                                , 'FechaBaja'
                                , 'Fecha'
                                , 'De'
                                , 'Nacimiento'
                                , 'Centro'
                                , 'Costo'
                                , 'Departamento'
                                , 'Puesto'
                                , 'Active'
                                , 'DateCreated'
                                , 'DateModified'
                                , 'vCampo16_trabajadorsonarh'
                                , 'vCampo17_trabajadorsonarh'
                                , 'vCampo18_trabajadorsonarh'
                                , 'vCampo19_trabajadorsonarh'
                                , 'vCampo20_trabajadorsonarh'
                                , 'vCampo21_trabajadorsonarh'
                                , 'vCampo22_trabajadorsonarh'
                                , 'vCampo23_trabajadorsonarh'
                                , 'vCampo24_trabajadorsonarh'
                                , 'vCampo25_trabajadorsonarh'
                                , 'vCampo26_trabajadorsonarh'
                                , 'vCampo27_trabajadorsonarh'
                                , 'vCampo28_trabajadorsonarh'
                                , 'vCampo29_trabajadorsonarh'
                                , 'vCampo30_trabajadorsonarh'
                                , 'b_status'
                            ];

    public $timestamps = false;
}
