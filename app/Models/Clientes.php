<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Clientes extends Model
{
    use HasFactory;
    public $table = "clientes";
    protected $fillable =   [     'id'
                                , 'vc_cliente'
                                , 'vc_correo'
                                , 'vc_telefono'
                                , 'id_medio_contacto'
                                , 'id_red_social'
                                , 'id_tipificacion'
                                , 'id_subtipificacion'
                                , 'guia_o_id_envio'
                                , 'id_carrier'g
                                , 'id_tipo_envio'
                                , 'vc_path_upload'
                                , 'vc_comentarios'
                                , 'id_status_interaccion'
                                , 'id_user'
                                , 'id_cliente'
                                , 'b_status'
                            ];

    public $timestamps = false;
}
