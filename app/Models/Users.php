<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;
    public $table = "users";
    protected $fillable =   [    'id'
                                ,'name'
                                ,'email'
                                ,'email_verified_at'
                                ,'phone'
                                ,'photo'
                                ,'password'
                                ,'remember_token'
                                ,'created_at'
                                ,'updated_at'
                                ,'guid'
                                ,'domain'
                                ];
    public $timestamps = false;    
}
