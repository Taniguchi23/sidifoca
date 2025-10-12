<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidacionResetContrasena;
use App\Repositories\ResetContrasenaRepository;
use App\Repositories\UsuarioRepository;
use App\Services\NotificacionService;
use Illuminate\Http\Request;

class ResetContrasenaController extends Controller
{
    protected $resetContrasena;
    protected $notificacion;
    protected $usuario;

    public function __construct(
        ResetContrasenaRepository $resetContrasena,
        UsuarioRepository $usuario,
        NotificacionService $notificacion
    ) {
        $this->resetContrasena = $resetContrasena;
        $this->usuario = $usuario;
        $this->notificacion = $notificacion;
    }

    public function crear()
    {
        return view('reset-contrasena.crear');
    }

    public function guardar(ValidacionResetContrasena $request)
    {
        $rpta = $this->resetContrasena->insertar($request->only([
            'email'
        ]));
        if ($rpta['success']) {
            $this->notificacion->contrasena($rpta['data']);
        }
        return response()->json($rpta);
    }

    public function editar($id)
    {
        $reset_contrasena = $this->resetContrasena->obtener($id);
        if (empty($reset_contrasena)) {
            abort(404);
        }
        return view('reset-contrasena.editar')->with('reset_contrasena', $reset_contrasena);
    }

    public function grabar(ValidacionResetContrasena $request, $id)
    {
        $rpta = $this->resetContrasena->editar($id, $request->only([
            'password'
        ]));
        return response()->json($rpta);
    }
}
