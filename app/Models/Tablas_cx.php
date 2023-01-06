<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tablas_cx extends Model
{
    use HasFactory;
    public $table = "tablas_cx";
    protected $fillable =   [     'id'
                                , 'vc_table'
                                , 'b_status'
                            ];

    public $timestamps = false;
}
