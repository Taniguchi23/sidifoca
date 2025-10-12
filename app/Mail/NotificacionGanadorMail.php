<?php

namespace App\Mail;

use App\Postulacion;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificacionGanadorMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $postulacion;

    public function __construct(Postulacion $postulacion)
    {
        $this->postulacion = $postulacion;
    }

    public function build()
    {
        return $this->subject('Fase de selección de finalistas')->view('emails.notificacion-ganador');
    }
}
