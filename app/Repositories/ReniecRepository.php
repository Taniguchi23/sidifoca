<?php

namespace App\Repositories;

use App\Libraries\AES256;
use App\User;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class ReniecRepository
{
    protected $url;
    protected $dni_consultante;
    protected $sub_consulta;
    protected $id_sistema;
    protected $llave_simetrica;
    protected $tipo_documento;
    
    public function __construct()
    {
        $this->url = config('reniec.url');
        $this->dni_consultante = config('reniec.dni_consultante');
        $this->sub_consulta = config('reniec.sub_consulta');
        $this->sistema = config('reniec.sistema');
        $this->llave_simetrica = config('reniec.llave_simetrica');
        $this->tipo_documento = config('constants.tipo_documento.dni');
    }

    private function errorReniec($error)
    {
        $arr_error = explode(':', $error);
        if (count($arr_error) > 1) {
            $new_error = $arr_error[1];
        } else {
            $new_error = $arr_error[0];
        }
        return $new_error;
    }

    public function consultar($nro_documento)
    {
        try {
            /**
             * AES256
             */
            $hextime = dechex(time());
            $dni_consultante = AES256::encrypt($hextime.$this->dni_consultante, $this->llave_simetrica);
            $sub_consulta = $this->sub_consulta;
            $dni = AES256::encrypt($hextime.$nro_documento, $this->llave_simetrica);
            $id_sistema = AES256::encrypt($hextime.$this->id_sistema, $this->llave_simetrica);
            /**
             * RENIEC API
             */
            $client = new Client([
                'headers' => [ 'Content-Type' => 'application/json' ]
            ]);
            $response = $client->request('POST', $this->url, [
                'body' => json_encode([
                    'dniConsultante' => $dni_consultante,
                    'subConsulta' => $sub_consulta,
                    'dni' => $dni,
                    'idSistema' => $id_sistema
                ])
            ]);
            $reniec =  json_decode($response->getBody());
            if ($reniec->success) {
                $usuario = new User();
                $fecha_nacimiento = Carbon::createFromFormat('Ymd', AES256::decrypt($reniec->data->fechaNacimiento, $this->llave_simetrica));
                $usuario->id_tipo_documento = $this->tipo_documento;
                $usuario->nro_documento = $nro_documento;
                $usuario->nro_dni = $nro_documento;
                $usuario->apellido_paterno = AES256::decrypt($reniec->data->apellidoPaterno, $this->llave_simetrica);
                $usuario->apellido_materno = AES256::decrypt($reniec->data->apellidoMaterno, $this->llave_simetrica);
                $usuario->nombres = AES256::decrypt($reniec->data->nombres, $this->llave_simetrica);
                $usuario->fecha_nacimiento = $fecha_nacimiento->format('d/m/Y');
                $usuario->direccion = AES256::decrypt($reniec->data->direccion, $this->llave_simetrica);
                $usuario->id_genero = AES256::decrypt($reniec->data->sexo, $this->llave_simetrica);
                $codigo_restriccion = $reniec->data->codigoRestriccion;
                if ($codigo_restriccion == 'A') {
                    return ['success' => false, 'status' => 0, 'errors' => ['nro_documento' => ['El n° de documento pertenece a una persona fallecida.'] ]];
                } 
                if ($fecha_nacimiento->age < 18) {
                    return ['success' => false, 'status' => 0, 'errors' => ['nro_documento' => ['El n° de documento pertenece a una persona menor de edad.'] ]];
                }
                return ['success' => true, 'status' => 0, 'data' => $usuario, 'msg' => 'Datos consultados desde RENIEC.'];
            } else {
                $errors = array_map(array($this, 'errorReniec'), $reniec->messages);
                $code = 0;
                if (in_array($reniec->code[0], ['9300', '9400', '9500', '9999'])) {
                    $code = 1;
                }
                return ['success' => false, 'status' => $code, 'errors' => ['nro_documento' => $errors ]];
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'status' => 1, 'errors' => ['nro_documento' => ['El servicio con Reniec se encuentra inactivo. Por favor proceda a registrar manualmente los datos.']]];
        }
    }

    public function consultar2($nro_dni)
    {
        try {
            /**
             * AES256
             */
            $hextime = dechex(time());
            $dni_consultante = AES256::encrypt($hextime.$this->dni_consultante, $this->llave_simetrica);
            $sub_consulta = $this->sub_consulta;
            $dni = AES256::encrypt($hextime.$nro_dni, $this->llave_simetrica);
            $id_sistema = AES256::encrypt($hextime.$this->id_sistema, $this->llave_simetrica);
            /**
             * RENIEC API
             */
            $client = new Client([
                'headers' => [ 'Content-Type' => 'application/json' ]
            ]);
            $response = $client->request('POST', $this->url, [
                'body' => json_encode([
                    'dniConsultante' => $dni_consultante,
                    'subConsulta' => $sub_consulta,
                    'dni' => $dni,
                    'idSistema' => $id_sistema
                ])
            ]);
            $reniec =  json_decode($response->getBody());
            if ($reniec->success) {
                $usuario = new User();
                $fecha_nacimiento = Carbon::createFromFormat('Ymd', AES256::decrypt($reniec->data->fechaNacimiento, $this->llave_simetrica));
                $usuario->id_tipo_documento = $this->tipo_documento;
                $usuario->nro_dni = $nro_dni;
                $usuario->nro_documento = $nro_dni;
                $usuario->apellido_paterno = AES256::decrypt($reniec->data->apellidoPaterno, $this->llave_simetrica);
                $usuario->apellido_materno = AES256::decrypt($reniec->data->apellidoMaterno, $this->llave_simetrica);
                $usuario->nombres = AES256::decrypt($reniec->data->nombres, $this->llave_simetrica);
                $usuario->fecha_nacimiento = $fecha_nacimiento->format('d/m/Y');
                $usuario->direccion = AES256::decrypt($reniec->data->direccion, $this->llave_simetrica);
                $usuario->id_genero = AES256::decrypt($reniec->data->sexo, $this->llave_simetrica);
                $codigo_restriccion = $reniec->data->codigoRestriccion;
                if ($codigo_restriccion == 'A') {
                    return ['success' => false, 'status' => 0, 'errors' => ['nro_dni' => ['El n° de documento pertenece a una persona fallecida.'] ]];
                } 
                if ($fecha_nacimiento->age < 18) {
                    return ['success' => false, 'status' => 0, 'errors' => ['nro_dni' => ['El n° de documento pertenece a una persona menor de edad.'] ]];
                }
                return ['success' => true, 'status' => 0, 'data' => $usuario, 'msg' => 'Datos consultados desde RENIEC.'];
            } else {
                $errors = array_map(array($this, 'errorReniec'), $reniec->messages);
                $code = 0;
                if (in_array($reniec->code[0], ['9300', '9400', '9500', '9999'])) {
                    $code = 1;
                }
                return ['success' => false, 'status' => $code, 'errors' => ['nro_dni' => $errors ]];
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'status' => 1, 'errors' => ['nro_dni' => ['El servicio con Reniec se encuentra inactivo. Por favor proceda a registrar manualmente los datos.']]];
        }
    }

    public function consultar3($nro_dni)
    {
        try {
            /**
             * AES256
             */
            $hextime = dechex(time());
            $dni_consultante = AES256::encrypt($hextime.$this->dni_consultante, $this->llave_simetrica);
            $sub_consulta = $this->sub_consulta;
            $dni = AES256::encrypt($hextime.$nro_dni, $this->llave_simetrica);
            $id_sistema = AES256::encrypt($hextime.$this->id_sistema, $this->llave_simetrica);
            /**
             * RENIEC API
             */
            $client = new Client([
                'headers' => [ 'Content-Type' => 'application/json' ]
            ]);
            $response = $client->request('POST', $this->url, [
                'body' => json_encode([
                    'dniConsultante' => $dni_consultante,
                    'subConsulta' => $sub_consulta,
                    'dni' => $dni,
                    'idSistema' => $id_sistema
                ])
            ]);
            $reniec =  json_decode($response->getBody());
            if ($reniec->success) {
                $usuario = new User();
                $fecha_nacimiento = Carbon::createFromFormat('Ymd', AES256::decrypt($reniec->data->fechaNacimiento, $this->llave_simetrica));
                $usuario->id_tipo_documento = $this->tipo_documento;
                $usuario->nro_dni = $nro_dni;
                $usuario->nro_documento = $nro_dni;
                $usuario->apellido_paterno = AES256::decrypt($reniec->data->apellidoPaterno, $this->llave_simetrica);
                $usuario->apellido_materno = AES256::decrypt($reniec->data->apellidoMaterno, $this->llave_simetrica);
                $usuario->nombres = AES256::decrypt($reniec->data->nombres, $this->llave_simetrica);
                $usuario->fecha_nacimiento = $fecha_nacimiento;
                $usuario->direccion = AES256::decrypt($reniec->data->direccion, $this->llave_simetrica);
                $usuario->id_genero = AES256::decrypt($reniec->data->sexo, $this->llave_simetrica);
                $usuario->codigo_restriccion = $reniec->data->codigoRestriccion;
                return $usuario;
            } else {
                return null;
            }
        } catch (Exception $e) {
            return null;
        }
    }
}
