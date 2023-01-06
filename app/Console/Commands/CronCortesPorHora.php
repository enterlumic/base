<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Lib\LibCore;

use App\Http\Controllers\Cortes_por_horaController;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Throwable;

class CronCortesPorHora extends Command{
    /*
    |--------------------------------------------------------------------------
    | Declaración de variables
    |--------------------------------------------------------------------------
    |
    */
    public $LibCore;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notificar:CronCortesPorHora';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(){
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(){
        $request = new \Illuminate\Http\Request();
        $request->merge(['fecha' => date('Y-m-d', strtotime('-1 days')) ]);

        $class= new Cortes_por_horaController();
        $class->cronCortesPorHora($request);
    }

}
