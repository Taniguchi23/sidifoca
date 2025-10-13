<?php

namespace App\Http\Controllers\Mensajeria;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProgramacionEnvioController extends Controller
{
    public function index(){ return view('mensajeria.programacion-envio.index'); }
}
