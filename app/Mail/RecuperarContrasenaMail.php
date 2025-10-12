<?php

namespace App\Mail;

use App\ResetContrasena;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RecuperarContrasenaMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $reset_contrasena;

    public function __construct(ResetContrasena $reset_contrasena)
    {
        $this->reset_contrasena = $reset_contrasena;
    }

    public function build()
    {
        return $this->subject('Edutalentos.pe')->view('emails.recuperar-contrasena');
    }
}
