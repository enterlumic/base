<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cat_menu extends Model
{
    use HasFactory;
    public $table = "cat_menu";
    protected $fillable =   [     'id'
                                , 'vc_nombre'
                                , 'vc_class'
                                , 'vCampo3_cat_menu'
                                , 'vCampo4_cat_menu'
                                , 'vCampo5_cat_menu'
                                , 'vCampo6_cat_menu'
                                , 'vCampo7_cat_menu'
                                , 'vCampo8_cat_menu'
                                , 'vCampo9_cat_menu'
                                , 'vCampo10_cat_menu'
                                , 'vCampo11_cat_menu'
                                , 'vCampo12_cat_menu'
                                , 'vCampo13_cat_menu'
                                , 'vCampo14_cat_menu'
                                , 'vCampo15_cat_menu'
                                , 'vCampo16_cat_menu'
                                , 'vCampo17_cat_menu'
                                , 'vCampo18_cat_menu'
                                , 'vCampo19_cat_menu'
                                , 'vCampo20_cat_menu'
                                , 'vCampo21_cat_menu'
                                , 'vCampo22_cat_menu'
                                , 'vCampo23_cat_menu'
                                , 'vCampo24_cat_menu'
                                , 'vCampo25_cat_menu'
                                , 'vCampo26_cat_menu'
                                , 'vCampo27_cat_menu'
                                , 'vCampo28_cat_menu'
                                , 'vCampo29_cat_menu'
                                , 'vCampo30_cat_menu'
                                , 'b_status'
                            ];

    public $timestamps = false;
}
