<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Console_gt extends Model
{
    use HasFactory;
    public $table = "console_gt";
    protected $fillable =   [     'id'
                                , 'vc_proyecto'
                                , 'vc_nombre_api'
                                , 'vc_name'
                                , 'vc_info'
                                , 'b_status'
                            ];

    public $timestamps = false;
}
