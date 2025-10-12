const TipoDocEnum = {
    DNI: 1,
    CARNET_EXT: 4,
    RUC: 6,
    properties: {
        1: { name: "DNI", value: 1 },
        4: { name: "CARNET DE EXTRAJERIA", value: 4 },
        6: { name: "RUC", value: 6 }
    }
};

const TipoEntidadEnum = {
    DRE_GRE: 1,
    UGEL: 2,
    MINEDU: 3,
    EXTERNA: 4,
    properties: {
        1: { name: "DRE / GRE", value: 1 },
        2: { name: "UGEL", value: 2 },
        3: { name: "MINEDU", value: 3 },
        4: { name: "Externa", value: 4 }
    }
};

const BanderaEnum = {
    NO: 0,
    SI: 1,
    properties: {
        0: { name: "NO", value: 0 },
        1: { name: "SI", value: 1 }
    }
};

const ModalidadEnum = {
    INDIVIDUAL: 1,
    COLECTIVA: 2,
    properties: {
        1: { name: "MODALIDAD INDIVIDUAL", value: 1 },
        2: { name: "MODALIDAD COLECTIVA", value: 2 }
    }
};

const TipoPostulacionEnum = {
    DRE_GRE: 1,
    UGEL: 2,
    DRE_GRE_UGELES: 3,
    UGELES: 4,
    UGELES_GOBIERNO_LOCAL: 5,
    properties: {
        1: { name: "DRE / GRE", value: 1 },
        2: { name: "UGEL COLECTIVA", value: 2 },
        3: { name: "DRE / GRE + UGEL(es)", value: 3 },
        4: { name: "UGEL(es)", value: 4 },
        5: { name: "UGEL(es) + GOBIERNO LOCAL", value: 5 },
    }
};

const AyudaEnum = {
    DECLARACION_REPRESENTANTE: 1,
    DECLARACION_EQUIPO: 2,
    ACTA_MODALIDAD_COLECTIVA: 3,
    URL_DOCUMENTO_IMAGEN: 4,
    URL_VIDEO: 5,
    properties: {
        1: { name: "DECLARACIÓN DEL REPRESENTANTE", value: 1 },
        2: { name: "DECLARACIÓN DEL EQUIPO", value: 2 },
        3: { name: "ACTA MODALIDAD COLECTIVA", value: 3 },
        4: { name: "URL DE DOCUMENTOS Y/O IMAGENES", value: 4 },
        5: { name: "URL DEL VIDEO", value: 5 },
    }
};

const EstadoEnum = {
    COMPLETO: 1,
    INCOMPLETO: 2,
    RECHAZADO: 3,
    properties: {
        1: { name: "COMPLETO", value: 1 },
        2: { name: "INCOMPLETO", value: 2 },
        2: { name: "RECHAZADO", value: 3 }
    }
};