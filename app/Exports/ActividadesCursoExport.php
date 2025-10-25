<?php
namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ActividadesCursoExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
/** @var \Illuminate\Support\Collection */
protected $rows;

public function __construct($rows)
{

$this->rows = $rows instanceof Collection ? $rows : collect($rows);
}

public function collection()
{
return $this->rows;
}

public function headings(): array
{
return [
'Alumno',
'Código',
'Usuario',
'Tipo',
'Título',
'Estado publicación',
'Publicación desde',
'Publicación hasta',
'Fecha creación',
'Última modificación',
'Fecha límite',
'Estado alumno',
'Creador',
];
}

public function map($r): array
{
// $r es stdClass (DB::select) — accede como objeto
$fmt = function ($v) { return $v ?? '—'; };

return [
$fmt($r->alumno),
$fmt($r->alumno_codigo),
$fmt($r->username),
$fmt($r->actividad_tipo),
$fmt($r->actividad_titulo),
$fmt($r->estado_publicacion),
$fmt($r->fecha_publicacion_desde),
$fmt($r->fecha_publicacion_hasta),
$fmt($r->fecha_creacion_recurso),
$fmt($r->ultima_modificacion),
$fmt($r->fecha_limite),
$fmt($r->estado_alumno),
$fmt($r->creador_nombre),
];
}
}
