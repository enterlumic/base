<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacto_cron extends Model
{
    use HasFactory;
    public $table = "contacto_cron";
    protected $fillable =   [     'id'
                                , 'vc_nombre'
                                , 'vc_correo'
                                , 'b_status'
                            ];

    public $timestamps = false;
}
