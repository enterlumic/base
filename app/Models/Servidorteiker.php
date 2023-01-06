<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servidorteiker extends Model
{
    use HasFactory;
    public $table = "servidorteiker";
    protected $fillable =   [     'id'
                                , 'vc_url_api_teiker'
                                , 'vc_db_host_teiker'
                                , 'vc_db_port_teiker'
                                , 'vc_db_database_teiker'
                                , 'vc_db_username_teiker'
                                , 'vc_db_password_teiker'
                                , 'b_status'
                            ];

    public $timestamps = false;
}
