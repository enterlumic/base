<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientesAdjuntos extends Model
{
    use HasFactory;
    public $table = "clientes_adjuntos";
    protected $fillable =   [ 'id'
                            , 'id_cliente'
                            , 'title'
                            , 'file'
                            , 'type'
                            , 'size'
                            , 'index_img'
                            , 'is_main'
                            , 'date'
                            , 'created_at'
                            , 'updated_at'
                            , 'b_status'
                            ];
    public $timestamps = false;}
