<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cat_red_social extends Model
{
    use HasFactory;
    public $table = "cat_red_social";
    protected $fillable =   [     'id'
                                , 'vc_red_social'
                                , 'vc_url'
                                , 'vc_icono'
                                , 'b_status'
                            ];

    public $timestamps = false;
}
