<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sql_server extends Model
{
    use HasFactory;
    public $table = "Cuentas";
    protected $fillable =   [ 'IdCuenta', 'IdCarga' ];

    public $timestamps = false;
}
