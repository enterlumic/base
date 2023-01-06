<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perfil_usuario extends Model
{
    use HasFactory;
    public $table = "users";
    protected $fillable =   [     'id'
                                , 'name'
                                , 'photo'
                                , 'email'
                                , 'phone'
                            ];
    public $timestamps = false;
}
