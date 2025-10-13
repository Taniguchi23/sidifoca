<?php

namespace App\Http\Controllers\AulaVirtual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GestionUsuarioController extends Controller
{
    public function index(){

        return view('aula-virtual.gestion-usuario.index');
    }
}
