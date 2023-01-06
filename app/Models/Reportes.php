<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reportes extends Model
{
    use HasFactory;
    public $table = "reportes";
    protected $fillable =   [     'id'
                                , 'vCampo1_reportes'
                                , 'vCampo2_reportes'
                                , 'vCampo3_reportes'
                                , 'vCampo4_reportes'
                                , 'vCampo5_reportes'
                                , 'vCampo6_reportes'
                                , 'vCampo7_reportes'
                                , 'vCampo8_reportes'
                                , 'vCampo9_reportes'
                                , 'vCampo10_reportes'
                                , 'vCampo11_reportes'
                                , 'vCampo12_reportes'
                                , 'vCampo13_reportes'
                                , 'vCampo14_reportes'
                                , 'vCampo15_reportes'
                                , 'vCampo16_reportes'
                                , 'vCampo17_reportes'
                                , 'vCampo18_reportes'
                                , 'vCampo19_reportes'
                                , 'vCampo20_reportes'
                                , 'vCampo21_reportes'
                                , 'vCampo22_reportes'
                                , 'vCampo23_reportes'
                                , 'vCampo24_reportes'
                                , 'vCampo25_reportes'
                                , 'vCampo26_reportes'
                                , 'vCampo27_reportes'
                                , 'vCampo28_reportes'
                                , 'vCampo29_reportes'
                                , 'vCampo30_reportes'
                                , 'b_status'
                            ];

    public $timestamps = false;
}
