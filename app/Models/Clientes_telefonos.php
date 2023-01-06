<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clientes_telefonos extends Model
{
    use HasFactory;
    public $table = "clientes_telefonos";
    protected $fillable =   [     'id'
                                , 'id_cliente'
                                , 'vc_telefono'
                                , 'vc_alias'
                                , 'b_status'
                            ];

    public $timestamps = false;
}
