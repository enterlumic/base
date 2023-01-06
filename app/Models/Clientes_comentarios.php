<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clientes_comentarios extends Model
{
    use HasFactory;
    public $table = "clientes_comentarios";
    protected $fillable =   [     'id'
                                , 'id_cliente'
                                , 'id_user'
                                , 'vc_comentarios'
                                , 'b_status'
                            ];

    public $timestamps = false;
}
