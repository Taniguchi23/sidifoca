<?php

namespace App\Services;

use App\Mail\NotificacionGanadorMail;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class FinalistaService
{
    protected $mail_username;

    public function __construct()
    {
        $this->mail_username = env('MAIL_USERNAME');
    }

    public function notificar($postulacion)
    {
        try {
            /*$contacto_postulacion = $postulacion->contacto_postulacion;
            if ($postulacion->flg_ganador) {
                $notificacion = new NotificacionGanadorMail($postulacion);
                Mail::to($contacto_postulacion->email)->send($notificacion);
            } else {
                //SOLO GANADOR? AQUI CORREO PARA LOS Q NO GANARON
            }*/
            $notificacion = new NotificacionGanadorMail($postulacion);
            Mail::to($this->mail_username)->send($notificacion);
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
