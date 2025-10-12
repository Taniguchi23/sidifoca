<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificacionRegistroMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $usuario;
    public $random;

    public function __construct(User $usuario, $random)
    {
        $this->usuario = $usuario;
        $this->random = $random;
    }

    public function build()
    {
        return $this->subject('Edutalentos.pe')->view('emails.notificacion-registro');
    }
}
