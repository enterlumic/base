<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users_menu extends Model
{
    use HasFactory;
    public $table = "users_menu";
    protected $fillable =   [     'id'
                                , 'id_user'
                                , 'id_menu'
                                , 'dt_fecha_limite'
                                , 'b_status'
                            ];

    public $timestamps = false;
}
