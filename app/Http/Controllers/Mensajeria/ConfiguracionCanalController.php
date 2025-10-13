<?php

namespace App\Http\Controllers\Mensajeria;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConfiguracionCanalController extends Controller
{
    public function whatsapp(){ return view('mensajeria.configuracion-canal.whatsapp'); }
    public function email(){ return view('mensajeria.configuracion-canal.email'); }
    public function sms(){ return view('mensajeria.configuracion-canal.sms'); }
}
