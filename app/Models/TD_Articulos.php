<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class TD_Articulos extends Model
{
    use HasFactory;
    public $table = "TD_Articulos";
    protected $fillable =   [     'IdArticulo'
                                , 'Orden'
                            ];

    public $timestamps = false;
}
