<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidacionIngresar;
use App\Http\Requests\ValidacionRegistroUsuario;
use App\Http\Requests\ValidacionReniec;
use App\Libraries\AES256;
use App\Repositories\AreaRepository;
use App\Repositories\UsuarioRepository;
use App\Repositories\ContratoRepository;
use App\Repositories\DreGreRepository;
use App\Repositories\EntidadExternaRepository;
use App\Repositories\GeneroRepository;
use App\Repositories\NivelPuestoRepository;
use App\Repositories\PuestoRepository;
use App\Repositories\RegimenLaboralRepository;
use App\Repositories\ReniecRepository;
use App\Repositories\ResetContrasenaRepository;
use App\Repositories\TipoDocumentoRepository;
use App\Repositories\TipoEntidadRepository;
use App\Repositories\UgelRepository;
use App\Services\NotificacionService;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class IntranetController extends Controller
{
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
    protected $reniec;
    protected $usuario;
    protected $contrato;
    protected $resetContrasena;
    protected $notificacion;
    
    public function __construct(
        TipoDocumentoRepository $tipoDocumento,
        GeneroRepository $genero,
        TipoEntidadRepository $tipoEntidad,
        DreGreRepository $dreGre,
        UgelRepository $ugel,
        EntidadExternaRepository $entidadExterna,
        NivelPuestoRepository $nivelPuesto,
        AreaRepository $area,
        PuestoRepository $puesto,
        RegimenLaboralRepository $regimenLaboral,
        ReniecRepository $reniec,
        UsuarioRepository $usuario,
        ContratoRepository $contrato,
        ResetContrasenaRepository $resetContrasena,
        NotificacionService $notificacion
    ) {
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
        $this->reniec = $reniec;
        $this->usuario = $usuario;
        $this->contrato = $contrato;
        $this->resetContrasena = $resetContrasena;
        $this->notificacion = $notificacion;
    }

    public function index()
    {
        $usuario = $this->usuario->auth();
        $arr_usuario_perfil = $this->usuario->misPerfiles();
        if (empty($usuario)) {
            abort(404);
        }
        $contrato = $this->contrato->vigente(auth()->id());
        return view('intranet.index')->with([
            'usuario' => $usuario,
            'contrato' => $contrato,
            'arr_usuario_perfil' => $arr_usuario_perfil
        ]);
    }

    public function ingresar()
    {
        if (Auth::id()) {
            return redirect()->route('intranet');
        }
        return view('intranet.ingresar');
    }

    public function authenticate(ValidacionIngresar $request)
    {
        $login_type = filter_var($request->input('username'), FILTER_VALIDATE_EMAIL)
            ? 'email'
            : 'username';
        $request->merge([
            $login_type => $request->input('username'),
            'flg_estado' => 1
        ]);
        if (Auth::attempt($request->only([$login_type, 'password', 'flg_estado']), $request->filled('remember'))) {
            Session::put($this->usuario->dataSesion());
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'errors' => ['*' => 'Usuario o contraseña incorrectas.']]);
    }

    public function cerrarSesion()
    {
        Auth::logout();
        Session::flush();
        return redirect()->route('login')->with('msg', 'Gracias por visitarnos.');
    }

    public function registrarse()
    {
        $arr_tipo_documento = $this->tipoDocumento->listar();
        $arr_genero = $this->genero->listar();
        $arr_tipo_entidad = $this->tipoEntidad->listar();
        $arr_dre_gre = $this->dreGre->listar();
        $arr_entidad_externa = $this->entidadExterna->listar();
        //$arr_nivel_puesto = $this->nivelPuesto->listar();
        $arr_area = $this->area->listar();
        $arr_regimen_laboral = $this->regimenLaboral->listar();
        return view('intranet.registrarse')->with([
            'arr_tipo_documento' => $arr_tipo_documento,
            'arr_genero' => $arr_genero,
            'arr_tipo_entidad' => $arr_tipo_entidad,
            'arr_dre_gre' => $arr_dre_gre,
            'arr_entidad_externa' => $arr_entidad_externa,
            //'arr_nivel_puesto' => $arr_nivel_puesto,
            'arr_area' => $arr_area,
            'arr_regimen_laboral' => $arr_regimen_laboral
        ]);
    }

    public function guardar(ValidacionRegistroUsuario $request)
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
            'nro_documento',
            'fecha_nacimiento',
            'telefono_celular',
            'telefono_fijo',
            'email',
            'direccion',
            'password',
            'password_confirmation',
            'id_tipo_entidad',
            'id_dre_gre',
            'id_ugel',
            'id_entidad_externa',
            'id_area',
            'id_nivel_puesto',
            'id_puesto',
            'id_regimen_laboral',
            'url_documento',
            'flg_ejerce_cargo'
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
        $rpta = $this->usuario->registrar($data);
        if ($rpta['success']) {
            $this->notificacion->bienvenida($rpta['data']);
            Auth::logout();
            if (Auth::attempt($request->only(['email', 'password']))) {
                Session::put($this->usuario->dataSesion());
            } else {
                Session::flush();
            }
        }
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

    public function captcha()
    {
        return response()->json(['success' => true, 'data' => captcha_src('flat')]);
    }

    public function listarUgel(Request $request)
    {
        $arr_ugel = $this->ugel->filtrarPorDreGre($request->get('id_dre_gre'));
        return response()->json($arr_ugel);
    }

    public function listarNivelPuesto(Request $request)
    {
        $arr_nivel_puesto = array();
        if ($request->get('id_tipo_entidad')) {
            $arr_nivel_puesto = $this->nivelPuesto->listar();
        }
        return response()->json($arr_nivel_puesto);
    }

    public function listarPuesto(Request $request)
    {
        $arr_puesto = $this->puesto->filtrarPorFiltro($request->get('id_tipo_entidad'), $request->get('id_nivel_puesto'));
        return response()->json($arr_puesto);
    }

    public function fotografia()
    {
        $fotografia = $this->usuario->fotografia(auth()->id());
        if (empty($fotografia)) {
            abort(404);
        }
        $ext = pathinfo($fotografia, PATHINFO_EXTENSION);
        return Storage::download($fotografia, 'fotografia.' . $ext);
    }

    public function carnetConadis()
    {
        $carnet_conadis = $this->usuario->carnetConadis(auth()->id());
        if (empty($carnet_conadis)) {
            abort(404);
        }
        $ext = pathinfo($carnet_conadis, PATHINFO_EXTENSION);
        return Storage::download($carnet_conadis, 'carnet-conadis.' . $ext);
    }

    public function documento()
    {
        // MODIFICAR EN CASO LOS USUARIOS PUEDEN MODIFICAR CONTRATOS PASADOS
        $contrato = $this->contrato->vigente(auth()->id());
        $documento = $this->contrato->documento($contrato->id_contrato);
        if (empty($documento)) {
            abort(404);
        }
        $ext = pathinfo($documento, PATHINFO_EXTENSION);
        return Storage::download($documento, 'contrato.' . $ext);
    }
}
