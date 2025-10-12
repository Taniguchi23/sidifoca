<?php

namespace App\Http\Controllers\AulaVirtual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CentroAcademicoController extends Controller
{
    public function index(){

        return view('aula-virtual.centro-academico.index');
    }

    public function lista(){

        return view('aula-virtual.centro-academico.lista');
    }
}
