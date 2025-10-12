<?php

namespace App\Services;

use App\Mail\BienvenidaMail;
use App\Mail\NotificacionRegistroMail;
use App\Mail\RecuperarContrasenaMail;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotificacionService
{
    public function notificar($usuario, $random)
    {
        try {
            $notificacion = new NotificacionRegistroMail($usuario, $random);
            Mail::to($usuario->email)->send($notificacion);
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }

    public function bienvenida($usuario)
    {
        try {
            $notificacion = new BienvenidaMail($usuario);
            Mail::to($usuario->email)->send($notificacion);
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }

    public function contrasena($reset_contrasena)
    {
        try {
            $notificacion = new RecuperarContrasenaMail($reset_contrasena);
            Mail::to($reset_contrasena->email)->send($notificacion);
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
