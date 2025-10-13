<?php

namespace App\Http\Controllers\AulaVirtual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CalificacionTareaController extends Controller
{
    public function index(){

        return view('aula-virtual.calificacion-tarea.index');
    }
}
