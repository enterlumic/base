<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cortes_por_hora extends Model
{
    use HasFactory;
    public $table = "cortes_por_hora";
    protected $fillable =   [     'id'
                                , 'event_date'
                                , 'interval_hour'
                                , 'agenttime_time'
                                , 'sales'
                                , 'SPH'
                                , 'b_status'
                            ];

    public $timestamps = false;
}
