<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cat_tipificacion extends Model
{
    use HasFactory;
    public $table = "cat_tipificacion";
    protected $fillable =   [     'id'
                                , 'vc_tipificacion'
                                , 'vc_descripcion'
                                , 'b_status'
                            ];

    public $timestamps = false;
}
