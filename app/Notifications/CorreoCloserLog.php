<?php

namespace App\Notifications;
use App\Lib\LibCore;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;


class CorreoCloserLog extends Notification{
    use Queueable;

    protected $path_reporte;
    public $LibCore;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($path_reporte){
        $this->path_reporte = $path_reporte;
        $this->LibCore = new LibCore();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable){
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable){
        $mail=  (new MailMessage)
                ->subject('Reporte: $Vicidial Log' )
                ->attach($this->path_reporte)
                ->cc('agovea@tecsa.mx')
                ->bcc('gmartinez@tecsa.mx')
                ->bcc('gustavo.gnu87@gmail.com')
                ->view('crontab.closer_log', [ 'path_reporte' => $this->path_reporte ] );

        $this->LibCore->setSkynet( ['vc_evento'=> 'cron_toMail' , 'vc_info' => json_encode($mail) ] );

        return $mail;
    }
}

