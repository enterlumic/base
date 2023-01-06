<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cat_status_interaccion extends Model
{
    use HasFactory;
    public $table = "cat_status_interaccion";
    protected $fillable =   [     'id'
                                , 'vc_status'
                                , 'vc_icono'
                                , 'b_status'
                            ];

    public $timestamps = false;
}
