<?php

namespace App\Http\Controllers\AulaVirtual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuditoriaController extends Controller
{
    public function accesosUsuarios(){

        return view('aula-virtual.auditoria.acceso-usuario');
    }
    public function logSistema(){

        return view('aula-virtual.auditoria.log-sistema');
    }
}
