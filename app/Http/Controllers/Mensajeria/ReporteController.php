<?php

namespace App\Http\Controllers\Mensajeria;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function estadistica(){ return view('mensajeria.reporte.estadistica'); }
    public function envioRealizado(){ return view('mensajeria.reporte.envio-realizado'); }
}
