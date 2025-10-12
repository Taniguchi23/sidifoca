<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class CourseController extends Controller
{
    protected $dre_gre;
    protected $ugel;

    public function __construct()
    {
        $this->dre_gre = config('constants.tipo_entidad.dre_gre');
        $this->ugel = config('constants.tipo_entidad.ugel');
    }

    public function index()
    {
        return view('course.index');
    }

    public function reporte(Request $request)
    {
        $params = $request->only([
            'fecha_inicio',
            'fecha_fin'
        ]);
        $time_start = microtime(true); 
        $filename = $this->consolidado($params);
        $time_end = microtime(true);
        $execution_time = ($time_end - $time_start)/60;
        return response()->json([
            'filename' => $filename,
            'now' => date('d-m-Y'),
            'execution_time' => number_format($execution_time, 2, ',', ' ')
        ]);
    }

    public function exportar(Request $request)
    {
        $filename = sys_get_temp_dir() . DIRECTORY_SEPARATOR . basename($request->input('filename'), '.xlsx') . '.xlsx';
        header('Content-Description: File Transfer');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        //header('Content-Disposition: attachment; filename="'.basename($filename).'"');
        header('Content-Disposition: attachment; filename="consolidado' . Carbon::now()->format('d-m-Y') . '.xlsx"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filename));
        header('Set-Cookie: fileDownload=true; path=/');
        readfile($filename);
        exit;
    }

    public function fullname($user)
    {
        $fullname = $user->apellido_paterno;
        if ($user->apellido_materno) {
            $fullname .= ' ' . $user->apellido_materno;
        }
        return $fullname;
    }

    public function consolidado(array $params)
    {
        $consolidado = DB::Connection('chamilo')->select('call sp_consolidado(:fecha_inicio, :fecha_fin)', $params);
        $courses = DB::Connection('chamilo')->select('select distinct
            id, 
            title,
            creation_date,
            expiration_date
            from course 
            WHERE creation_date
            BETWEEN str_to_date(:fecha_inicio, "%d/%m/%Y") 
            AND str_to_date(:fecha_fin, "%d/%m/%Y")', $params);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('consolidado');
        $sheet->setCellValueByColumnAndRow(1,  1, 'DNI RENIEC');
        $sheet->setCellValueByColumnAndRow(2,  1, 'NOMBRE');
        $sheet->setCellValueByColumnAndRow(3,  1, 'APELLIDOS');
        $sheet->setCellValueByColumnAndRow(4,  1, 'SEXO');
        $sheet->setCellValueByColumnAndRow(5,  1, 'FECHA_NACIMIENTO');
        $sheet->setCellValueByColumnAndRow(6,  1, 'NOMBRE_IGED');
        $sheet->setCellValueByColumnAndRow(7,  1, 'CODIGO_IGED');
        $sheet->setCellValueByColumnAndRow(8,  1, 'REGION');
        $sheet->setCellValueByColumnAndRow(9,  1, 'CELULAR1');
        $sheet->setCellValueByColumnAndRow(10, 1, 'AREA');
        $sheet->setCellValueByColumnAndRow(11, 1, 'DATOS_PUESTO');
        $sheet->setCellValueByColumnAndRow(12, 1, 'PUESTO_HOMOLOGADO');
        foreach ($courses as $key => $course) {
            $sheet->setCellValueByColumnAndRow($key + 13, 1, $course->title);
        }
        foreach ($consolidado as $x => $user) {
            $_user = $this->user($user->official_code);
            $sheet->setCellValueByColumnAndRow(1,  $x + 2,  $_user->DNI);
            $sheet->setCellValueByColumnAndRow(2,  $x + 2,  $_user->NOMBRE);
            $sheet->setCellValueByColumnAndRow(3,  $x + 2,  $_user->APELLIDOS);
            $sheet->setCellValueByColumnAndRow(4,  $x + 2,  $_user->SEXO);
            $sheet->setCellValueByColumnAndRow(5,  $x + 2,  $_user->FECHA_NACIMIENTO);
            $sheet->setCellValueByColumnAndRow(6,  $x + 2,  $_user->NOMBRE_IGED);
            $sheet->setCellValueByColumnAndRow(7,  $x + 2,  $_user->CODIGO_IGED);
            $sheet->setCellValueByColumnAndRow(8,  $x + 2,  $_user->REGION);
            $sheet->setCellValueByColumnAndRow(9,  $x + 2,  $_user->CELULAR1);
            $sheet->setCellValueByColumnAndRow(10, $x + 2,  $_user->AREA);
            $sheet->setCellValueByColumnAndRow(11, $x + 2,  $_user->DATOS_PUESTO);
            $sheet->setCellValueByColumnAndRow(12, $x + 2,  $_user->PUESTO_HOMOLOGADO);
            foreach ($courses as $j => $course) {
                $sheet->setCellValueByColumnAndRow($j + 13, $x + 2, $user->{$course->id});
            }
        }
        $writer = new Xlsx($spreadsheet);
        $filename =  uniqid() . '.xlsx';
        $writer->save(sys_get_temp_dir() . DIRECTORY_SEPARATOR . $filename);
        return $filename;
    }

    public function user($nro_documento)
    {
        $item = [
            'DNI' => $nro_documento,
            'NOMBRE' => '',
            'APELLIDOS' => '',
            'SEXO' => '',
            'FECHA_NACIMIENTO' => '',
            'NOMBRE_IGED' => '',
            'CODIGO_IGED' => '',
            'REGION' => '',
            'CELULAR1' => '',
            'AREA' => '',
            'DATOS_PUESTO' => '',
            'PUESTO_HOMOLOGADO' => ''
        ];
        if ($nro_documento) {
            $arr_user = DB::select('call sp_usuario(:nro_documento)', ['nro_documento' => $nro_documento]);
            if ($arr_user) {
                $user = $arr_user[0];
                $item['DNI'] = $user->nro_documento;
                $item['NOMBRE'] = $user->nombres;
                $item['APELLIDOS'] = $this->fullname($user);
                $item['SEXO'] = $user->genero;
                $item['FECHA_NACIMIENTO']= $user->fecha_nacimiento;
                $item['CELULAR1'] = $user->telefono_celular;
                $item['NOMBRE_IGED'] = $user->id_iged;
                $item['CODIGO_IGED'] = $user->iged;
                $item['REGION'] = $user->region;
                $item['AREA'] = $user->area;
                $item['DATOS_PUESTO'] = $user->puesto;
                $item['PUESTO_HOMOLOGADO'] = $user->nivel_puesto;
            }
        }
        return (object)$item;
    }
}
