<?php

namespace App\Http\Controllers\Mensajeria;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PlantillaMensajeController extends Controller
{
    public function index(){ return view('mensajeria.plantilla-mensaje.index'); }
}
