<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agentes_por_hora extends Model
{
    use HasFactory;
    public $table = "agentes_por_hora";
    protected $fillable =   [     'id'
                                , 'i_hora'
                                , 'vc_usuario'
                                , 'vc_ip'
                                , 'dt_fecha'
                                , 'b_status'
                            ];

    public $timestamps = false;
}
