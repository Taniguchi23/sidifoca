<?php

return [
    'tipo_documento' => [
        'dni' => env('TIPO_DOCUMENTO_DNI', '1'),
        'carnet_ext' => env('TIPO_DOCUMENTO_CARNET_EXT', '4'),
        'ruc' => env('TIPO_DOCUMENTO_RUC', '6')
    ],
    'tipo_entidad' => [
        'dre_gre' => env('TIPO_ENTIDAD_DRE_GRE', '1'),
        'ugel' => env('TIPO_ENTIDAD_UGEL', '2'),
        'minedu' => env('TIPO_ENTIDAD_MINEDU', '3'),
        'externa' => env('TIPO_ENTIDAD_EXTERNA', '4')
    ],
    'modalidad' => [
        'individual' => env('MODALIDAD_INDIVIDUAL', '1'),
        'colectiva' => env('MODALIDAD_COLECTIVA', '2')
    ],
    'tipo_postulacion' => [
        'dre_gre' => env('DRE_GRE', '1'),
        'ugel' => env('UGEL', '2'),
        'dre_gre_ugeles' => env('DRE_GRE_UGELES', '3'),
        'ugeles' => env('UGELES', '4'),
        'ugeles_gobierno_local' => env('UGELES_GOBIERNO_LOCAL', '5'),
    ],
    'estado' => [
        'completo' => env('ESTADO_COMPLETO', '1'),
        'incompleto' => env('ESTADO_INCOMPLETO', '2'),
        'rechazado' => env('ESTADO_RECHAZADO', '3')
    ]
];