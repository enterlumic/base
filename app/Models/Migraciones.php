<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Migraciones extends Model
{
    use HasFactory;
    public $table = "migrations";
    protected $fillable =   [     'id'
                                , 'migrations'
                                , 'batch'
                            ];

    public $timestamps = false;
}
