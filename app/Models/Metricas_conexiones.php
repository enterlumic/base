<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Metricas_conexiones extends Model
{
    use HasFactory;
    public $table = "metricas_conexiones";
    protected $fillable =   [     'id'
                                , 'server_ip'
                                , 'fecha'
                                , 'user'
                                , 'campaign_id'
                                , 'user_group'
                                , 'calls'
                                , 'agent_time'
                                , 'wait'
                                , 'talk'
                                , 'dispo'
                                , 'pausa'
                                , 'ba'
                                , 'brk'
                                , 'caling'
                                , 'b_status'
                            ];

    public $timestamps = false;
}
