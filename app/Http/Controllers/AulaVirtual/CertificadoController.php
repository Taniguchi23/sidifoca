<?php

namespace App\Http\Controllers\AulaVirtual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CertificadoController extends Controller
{
    public function index(){

        return view('aula-virtual.certificado.index');
    }
}
