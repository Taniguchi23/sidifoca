<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Http\Requests\ValidacionUsuario;
use App\Http\Requests\ValidacionContrato;
use App\Http\Requests\ValidacionReniec;
use App\Repositories\AreaRepository;
use App\Repositories\UsuarioRepository;
use App\Repositories\ContratoRepository;
use App\Repositories\DreGreRepository;
use App\Repositories\EntidadExternaRepository;
use App\Repositories\GeneroRepository;
use App\Repositories\NivelEducativoRepository;
use App\Repositories\NivelPuestoRepository;
use App\Repositories\PerfilRepository;
use App\Repositories\ProfesionRepository;
use App\Repositories\PuestoRepository;
use App\Repositories\RegimenLaboralRepository;
use App\Repositories\ReniecRepository;
use App\Repositories\TipoDocumentoRepository;
use App\Repositories\TipoEntidadRepository;
use App\Repositories\UgelRepository;
use App\Services\NotificacionService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class UsuarioController extends Controller
{
    protected $usuario;
    protected $contrato;
    protected $tipoDocumento;
    protected $genero;
    protected $tipoEntidad;
    protected $dreGre;
    protected $ugel;
    protected $entidadExterna;
    protected $nivelPuesto;
    protected $puesto;
    protected $area;
    protected $regimenLaboral;
    protected $nivelEducativo;
    protected $profesion;
    protected $reniec;
    protected $perfil;
    protected $notificacion;

    public function __construct(
        UsuarioRepository $usuario,
        ContratoRepository $contrato,
        TipoDocumentoRepository $tipoDocumento,
        GeneroRepository $genero,
        TipoEntidadRepository $tipoEntidad,
        DreGreRepository $dreGre,
        UgelRepository $ugel,
        EntidadExternaRepository $entidadExterna,
        NivelPuestoRepository $nivelPuesto,
        PuestoRepository $puesto,
        AreaRepository $area,
        RegimenLaboralRepository $regimenLaboral,
        NivelEducativoRepository $nivelEducativo,
        ProfesionRepository $profesion,
        ReniecRepository $reniec,
        PerfilRepository $perfil,
        NotificacionService $notificacion
    ) {
        $this->usuario = $usuario;
        $this->contrato = $contrato;
        $this->tipoDocumento = $tipoDocumento;
        $this->genero = $genero;
        $this->tipoEntidad = $tipoEntidad;
        $this->dreGre = $dreGre;
        $this->ugel = $ugel;
        $this->entidadExterna = $entidadExterna;
        $this->nivelPuesto = $nivelPuesto;
        $this->puesto = $puesto;
        $this->area = $area;
        $this->regimenLaboral = $regimenLaboral;
        $this->nivelEducativo = $nivelEducativo;
        $this->profesion = $profesion;
        $this->reniec = $reniec;
        $this->perfil = $perfil;
        $this->notificacion = $notificacion;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $rpta = $this->usuario->paginar($request->get('limit'), $request->only([
                'nombre_completo',
                'id_tipo_documento',
                'nro_documento',
                'flg_estado'
            ]));
            // ENCRIPTACION MANUAL
            return response()->json($rpta);
        }
        $arr_tipo_documento = $this->tipoDocumento->listar();
        return view('usuario.index')->with('arr_tipo_documento', $arr_tipo_documento);
    }

    public function crear()
    {
        $arr_tipo_documento = $this->tipoDocumento->listar();
        $arr_genero = $this->genero->listar();
        return view('usuario.crear')->with([
            'arr_tipo_documento' => $arr_tipo_documento,
            'arr_genero' => $arr_genero
        ]);
    }

    public function guardar(ValidacionUsuario $request)
    {
        if ($request->get('id_tipo_documento') == config('constants.tipo_documento.dni')) {
            $dataReniec = $this->reniec->consultar($request->get('nro_documento'));
            if ($dataReniec['success'] == false) {
                $dataReniec = null;
            }
        } else {
            $dataReniec = null;
        }
        $data = $request->only([
            'id_tipo_documento',
            'id_genero',
            'apellido_paterno',
            'apellido_materno',
            'nombres',
            'url_fotografia',
            'nro_documento',
            'fecha_nacimiento',
            'telefono_fijo',
            'telefono_celular',
            'email',
            'direccion',
            'flg_discapacidad',
            'url_carnet_conadis'
        ]);
        if (empty($dataReniec)) {
            $data += ['flg_reniec' => false ];
        } else {
            $data += ['flg_reniec' => true ];
            $data['id_tipo_documento'] = $dataReniec['data']->id_tipo_documento;
            $data['nro_documento'] = $dataReniec['data']->nro_documento;
            $data['apellido_paterno'] = $dataReniec['data']->apellido_paterno;
            $data['apellido_materno'] = $dataReniec['data']->apellido_materno;
            $data['nombres'] = $dataReniec['data']->nombres;
            $data['fecha_nacimiento'] = $dataReniec['data']->fecha_nacimiento;
            $data['direccion'] = $dataReniec['data']->direccion;
            $data['id_genero'] = $dataReniec['data']->id_genero;
        }
        $random = Str::random(8);
        $rpta = $this->usuario->insertar($data, $random);
        if ($rpta['success']) {
            $this->notificacion->notificar($rpta['data'], $random);
        }
        return response()->json($rpta);
    }

    public function detalles($id)
    {
        $usuario = $this->usuario->obtener($id);
        if (empty($usuario)) {
            abort(404);
        }
        return view('usuario.detalles')->with('usuario', $usuario);
    }

    public function editar($id)
    {
        $usuario = $this->usuario->obtener($id);
        if (empty($usuario)) {
            abort(404);
        }
        $usuario->flg_dni = $usuario->id_tipo_documento == config('constants.tipo_documento.dni');
        $usuario->flg_carnet_conadis = isset($usuario->url_carnet_conadis);
        $contrato = $this->contrato->vigente($id);
        $arr_tipo_documento = $this->tipoDocumento->listar();
        $arr_genero = $this->genero->listar();
        return view('usuario.editar')->with([
            'usuario' => $usuario,
            'contrato' => $contrato,
            'arr_tipo_documento' => $arr_tipo_documento,
            'arr_genero' => $arr_genero
        ]);
    }

    public function grabar(ValidacionUsuario $request, $id)
    {
        if ($request->get('id_tipo_documento') == config('constants.tipo_documento.dni')) {
            $dataReniec = $this->reniec->consultar($request->get('nro_documento'));
            if ($dataReniec['success'] == false) {
                $dataReniec = null;
            }
        } else {
            $dataReniec = null;
        }
        $data = $request->only([
            'id_tipo_documento',
            'id_genero',
            'apellido_paterno',
            'apellido_materno',
            'nombres',
            'url_fotografia',
            'nro_documento',
            'fecha_nacimiento',
            'telefono_fijo',
            'telefono_celular',
            'email',
            'direccion',
            'flg_discapacidad',
            'url_carnet_conadis',
            'flg_estado'
        ]);
        if (empty($dataReniec)) {
            $data += ['flg_reniec' => false ];
        } else {
            $data += ['flg_reniec' => true ];
            $data['id_tipo_documento'] = $dataReniec['data']->id_tipo_documento;
            $data['nro_documento'] = $dataReniec['data']->nro_documento;
            $data['apellido_paterno'] = $dataReniec['data']->apellido_paterno;
            $data['apellido_materno'] = $dataReniec['data']->apellido_materno;
            $data['nombres'] = $dataReniec['data']->nombres;
            $data['fecha_nacimiento'] = $dataReniec['data']->fecha_nacimiento;
            $data['direccion'] = $dataReniec['data']->direccion;
            $data['id_genero'] = $dataReniec['data']->id_genero;
        }
        $rpta = $this->usuario->editar($id, $data);
        return response()->json($rpta);
    }

    public function crearContrato($id)
    {
        $usuario = $this->usuario->obtener($id);
        $arr_tipo_entidad = $this->tipoEntidad->listar();
        $arr_dre_gre = $this->dreGre->listar();
        $arr_entidad_externa = $this->entidadExterna->listar();
        $arr_nivel_puesto = $this->nivelPuesto->listar();
        $arr_area = $this->area->listar();
        $arr_regimen_laboral = $this->regimenLaboral->listar();
        $arr_nivel_educativo = $this->nivelEducativo->listar();
        $arr_profesion = $this->profesion->listar();
        return view('usuario.crear-contrato')->with([
            'usuario' => $usuario,
            'arr_tipo_entidad' => $arr_tipo_entidad,
            'arr_dre_gre' => $arr_dre_gre,
            'arr_entidad_externa' => $arr_entidad_externa,
            'arr_nivel_puesto' => $arr_nivel_puesto,
            'arr_area' => $arr_area,
            'arr_regimen_laboral' => $arr_regimen_laboral,
            'arr_nivel_educativo' => $arr_nivel_educativo,
            'arr_profesion' => $arr_profesion
        ]);
    }

    public function guardarContrato(ValidacionContrato $request)
    {
        $rpta = $this->contrato->insertar($request->only([
            'id_usuario',
            'id_tipo_entidad',
            'id_dre_gre',
            'id_ugel',
            'id_entidad_externa',
            'id_nivel_puesto',
            'id_puesto',
            'id_area',
            'id_regimen_laboral',
            'id_nivel_educativo',
            'id_profesion',
            'fecha_inicio',
            'fecha_fin',
            'url_documento',
            'flg_ejerce_cargo'
        ]));
        return response()->json($rpta);
    }

    public function editarContrato($id)
    {
        $contrato = $this->contrato->obtener($id);
        if (empty($contrato)) {
            abort(404);
        }
        $arr_tipo_entidad = $this->tipoEntidad->listar();
        $arr_dre_gre = $this->dreGre->listar();
        $arr_ugel = $this->ugel->filtrarPorDreGre($contrato->id_dre_gre);
        $arr_entidad_externa = $this->entidadExterna->listar();
        $arr_nivel_puesto = $this->nivelPuesto->listar();
        $arr_area = $this->area->listar();
        $arr_puesto = $this->puesto->filtrarPorFiltro($contrato->id_tipo_entidad, $contrato->id_nivel_puesto);
        $arr_regimen_laboral = $this->regimenLaboral->listar();
        $arr_nivel_educativo = $this->nivelEducativo->listar();
        $arr_profesion = $this->profesion->listar();
        return view('usuario.editar-contrato')->with([
            'contrato' => $contrato,
            'arr_tipo_entidad' => $arr_tipo_entidad,
            'arr_dre_gre' => $arr_dre_gre,
            'arr_ugel' => $arr_ugel,
            'arr_entidad_externa' => $arr_entidad_externa,
            'arr_nivel_puesto' => $arr_nivel_puesto,
            'arr_area' => $arr_area,
            'arr_puesto' => $arr_puesto,
            'arr_regimen_laboral' => $arr_regimen_laboral,
            'arr_nivel_educativo' => $arr_nivel_educativo,
            'arr_profesion' => $arr_profesion
        ]);
    }

    public function grabarContrato(ValidacionContrato $request, $id)
    {
        $rpta = $this->contrato->editar($id, $request->only([
            'id_tipo_entidad',
            'id_dre_gre',
            'id_ugel',
            'id_entidad_externa',
            'id_nivel_puesto',
            'id_puesto',
            'id_area',
            'id_regimen_laboral',
            'id_nivel_educativo',
            'id_profesion',
            'fecha_inicio',
            'fecha_fin',
            'url_documento',
            'flg_ejerce_cargo'
        ]));
        return response()->json($rpta);
    }

    public function reniec(ValidacionReniec $request)
    {
        $rpta = $this->reniec->consultar($request->input('nro_documento'));
        if ($rpta['success']) {
            $pem = config('site_vars.pem');
            if (!$publicKey = openssl_pkey_get_public($pem)) {
                Log::error('Loading Public Key failed');
                die('Loading Public Key failed');
            }
            
            $encrypted_id_tipo_documento = "";
            $encrypted_nro_documento = "";
            $encrypted_apellido_paterno = "";
            $encrypted_apellido_materno = "";
            $encrypted_nombres = "";
            $encrypted_fecha_nacimiento = "";
            $encrypted_direccion = "";
            $encrypted_id_genero = "";
            
            try {
                openssl_public_encrypt($rpta['data']->id_tipo_documento, $encrypted_id_tipo_documento, $publicKey);
                openssl_public_encrypt($rpta['data']->nro_documento, $encrypted_nro_documento, $publicKey);
                openssl_public_encrypt($rpta['data']->apellido_paterno, $encrypted_apellido_paterno, $publicKey);
                openssl_public_encrypt($rpta['data']->apellido_materno, $encrypted_apellido_materno, $publicKey);
                openssl_public_encrypt($rpta['data']->nombres, $encrypted_nombres, $publicKey);
                openssl_public_encrypt($rpta['data']->fecha_nacimiento, $encrypted_fecha_nacimiento, $publicKey);
                openssl_public_encrypt($rpta['data']->direccion, $encrypted_direccion, $publicKey);
                openssl_public_encrypt($rpta['data']->id_genero, $encrypted_id_genero, $publicKey);
            } catch (Exception $e) {
                Log::error('Failed to encryp data' . $e);
                die('Failed to encryp data');
            }
            
            $encrypted_data = [];
            $encrypted_data['id_tipo_documento'] = base64_encode($encrypted_id_tipo_documento);
            $encrypted_data['nro_documento']     = base64_encode($encrypted_nro_documento);
            $encrypted_data['apellido_paterno']  = base64_encode($encrypted_apellido_paterno);
            $encrypted_data['apellido_materno']  = base64_encode($encrypted_apellido_materno);
            $encrypted_data['nombres']          = base64_encode($encrypted_nombres);
            $encrypted_data['fecha_nacimiento']  = base64_encode($encrypted_fecha_nacimiento);
            $encrypted_data['direccion']         = base64_encode($encrypted_direccion);
            $encrypted_data['id_genero']         = base64_encode($encrypted_id_genero);
            
            $rpta['data'] = $encrypted_data;
        }
        return response()->json($rpta);
    }

    public function listarUgel(Request $request)
    {
        $arr_ugel = $this->ugel->filtrarPorDreGre($request->get('id_dre_gre'));
        return response()->json($arr_ugel);
    }

    public function listarPuesto(Request $request)
    {
        $arr_puesto = $this->puesto->filtrarPorFiltro($request->get('id_tipo_entidad'), $request->get('id_nivel_puesto'));
        return response()->json($arr_puesto);
    }

    public function fotografia($id)
    {
        $fotografia = $this->usuario->fotografia($id);
        if (empty($fotografia)) {
            abort(404);
        }
        $ext = pathinfo($fotografia, PATHINFO_EXTENSION);
        return Storage::download($fotografia, 'fotografia.' . $ext);
    }

    public function carnetConadis($id)
    {
        $carnet_conadis = $this->usuario->carnetConadis($id);
        if (empty($carnet_conadis)) {
            abort(404);
        }
        $ext = pathinfo($carnet_conadis, PATHINFO_EXTENSION);
        return Storage::download($carnet_conadis, 'carnet-conadis.' . $ext);
    }

    public function documento($id)
    {
        $documento = $this->contrato->documento($id);
        if (empty($documento)) {
            abort(404);
        }
        $ext = pathinfo($documento, PATHINFO_EXTENSION);
        return Storage::download($documento, 'contrato.' . $ext);
    }

    public function privilegios($id)
    {
        $usuario = $this->usuario->obtener($id);
        if (empty($usuario)) {
            abort(404);
        }
        $arr_perfil = $this->perfil->listar();
        $arr_usuario_perfil = $this->usuario->perfiles($id);
        return view('usuario.privilegios')->with([
            'usuario' => $usuario,
            'arr_perfil' => $arr_perfil,
            'arr_usuario_perfil' => $arr_usuario_perfil
        ]);
    }

    public function grabarUsuarioPerfil(Request $request, $id_usuario, $id_perfil)
    {
        $rpta = $this->usuario->editarUsuarioPerfil($id_usuario, $id_perfil, $request->only([
            'flg_estado'
        ]));
        return response()->json($rpta);
    }

    public function exportar() 
    {
        $filename = 'administrados' . Carbon::now()->format('d-m-Y') . '.xlsx';
        return Excel::download(new UsersExport, $filename);
    }
}
