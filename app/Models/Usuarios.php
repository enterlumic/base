<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuarios extends Model
{
    use HasFactory;
    public $table = "usuarios";
    protected $fillable =   [     'id'
                                , 'name'
                                , 'email'
                                , 'email_verified_at'
                                , 'phone'
                                , 'photo'
                                , 'password'
                                , 'remember_token'
                                , 'created_at'
                                , 'updated_at'
                                , 'guid'
                                , 'domain'
                                , 'vCampo12_usuarios'
                                , 'vCampo13_usuarios'
                                , 'vCampo14_usuarios'
                                , 'vCampo15_usuarios'
                                , 'vCampo16_usuarios'
                                , 'vCampo17_usuarios'
                                , 'vCampo18_usuarios'
                                , 'vCampo19_usuarios'
                                , 'vCampo20_usuarios'
                                , 'vCampo21_usuarios'
                                , 'vCampo22_usuarios'
                                , 'vCampo23_usuarios'
                                , 'vCampo24_usuarios'
                                , 'vCampo25_usuarios'
                                , 'vCampo26_usuarios'
                                , 'vCampo27_usuarios'
                                , 'vCampo28_usuarios'
                                , 'vCampo29_usuarios'
                                , 'vCampo30_usuarios'
                                , 'b_status'
                            ];

    public $timestamps = false;
}
