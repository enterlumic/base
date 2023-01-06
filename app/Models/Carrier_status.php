<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrier_status extends Model
{
    use HasFactory;
    public $table = "carrier_status";
    protected $fillable =   [     'id'
                                , 'servidor'
                                , 'call_date'
                                , 'campana'
                                , 'dialstatus'
                                , 'calls'
                                , 'id_user'
                                , 'id_request'
                                , 'b_status'
                            ];

    public $timestamps = false;
}
