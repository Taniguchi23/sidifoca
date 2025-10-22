@extends('layout.app')
@section('link')
    <link href="https://unpkg.com/gridjs/dist/theme/mermaid.min.css" rel="stylesheet" />
@endsection
@section('content')
    <div class="h-screen flex gap-4">
        <!-- Árbol / segundo menú -->
        <aside id="eduta-nav" data-collapsed="false"
               class="relative w-65 shrink-0 bg-white border border-slate-200 rounded-2xl p-3 flex flex-col transition-all duration-200 overflow-hidden">

            <!-- Contenido completo -->
            <div class="content flex flex-col">
                <div class="flex items-center gap-2 px-2 pb-3 border-b border-slate-100">
                    <i data-lucide="menu" class="w-5 h-5 text-slate-500"></i>
                    <h2 class="text-sm font-semibold">Navegación</h2>
                </div>

                <div class="mt-3">
                    <label class="sr-only" for="tree-search">Buscar</label>
                    <input id="tree-search" type="search" placeholder="Buscar..."
                           class="w-full h-9 rounded-sm border border-slate-200 px-3 text-sm placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-sky-100 focus:border-sky-300">
                </div>

                <style>
                    summary::-webkit-details-marker { display: none; }
                    #eduta-nav:not([data-collapsed="true"]) details[open] > summary .arrow { transform: rotate(90deg); }
                    .arrow { transition: transform .2s ease; }

                    /* Estado colapsado */
                    #eduta-nav[data-collapsed="true"] {
                        width: 3.25rem;
                        padding: .25rem;
                    }
                    #eduta-nav[data-collapsed="true"] .content { display: none; }

                    /* Posición botón */
                    #eduta-nav .collapse-btn { position: absolute; top: .5rem; right: .5rem; }
                    #eduta-nav[data-collapsed="true"] .collapse-btn {
                        top: 50%; left: 50%; right: auto; transform: translate(-50%, -50%);
                    }
                </style>

                <nav class="mt-3 flex-1 overflow-y-auto pr-1 text-sm text-slate-700" aria-label="Contenidos" id="lista">
                    @foreach($listas as $key => $categorias)
                    <details {{$key == date('Y')? 'open' : ''}} class="year">

                            <summary class="flex items-center justify-between px-2 py-2 rounded-md cursor-pointer hover:bg-slate-50">
                          <span class="flex items-center gap-2">
                            <i data-lucide="chevron-right" class="arrow w-4 h-4 text-slate-500"></i>
                            <span>{{$key}}</span>
                          </span>
                                <span class="text-[11px] text-slate-500 bg-slate-100 rounded-full px-2 py-0.5">{{count($categorias)}} categorías</span>
                            </summary>
                            <div class="ml-5 mt-1 space-y-2">
                                @foreach($categorias as $key1 => $categoria)
                                <details>
                                    <summary class="flex items-center gap-2 cursor-pointer rounded-md px-2 py-1.5 hover:bg-slate-50">
                                        <i data-lucide="chevron-right" class="arrow w-4 h-4 text-slate-500"></i>
                                        {{$key1}}
                                    </summary>
                                    <ul class="ml-5 mt-1 space-y-1">
                                        @foreach($categoria as $curso)
                                            <li><a class="block px-2 py-1.5 rounded-md hover:bg-slate-50 cursoSelector" data-id="{{$curso['id']}}" data-anio="{{$key}}" data-categoria="{{$key1}}" data-title="{{ $curso['curso'] }}" title="{{ $curso['curso'] }}">
                                                    {{ \Illuminate\Support\Str::limit($curso['curso'], 30) }}</a></li>
                                        @endforeach
                                    </ul>
                                </details>
                                @endforeach

                            </div>


                    </details>
                    @endforeach
                </nav>
            </div>

            <!-- Botón -->
            <button id="eduta-toggle" type="button" aria-label="Colapsar navegación"
                    class="collapse-btn p-2 rounded-full hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-sky-200">
                <i data-lucide="chevrons-left" class="w-5 h-5 text-slate-700"></i>
            </button>
        </aside>


        <section class="min-w-0 flex-1" id="content-centro">
            <div id="grid-actividades" class="overflow-hidden rounded-2xl border border-slate-200"></div>
        </section>
    </div>
@endsection
@section('script')
    <script src="https://unpkg.com/gridjs/dist/gridjs.umd.js"></script>
    <script>
        // ===================== Helpers =====================
        const cap = s => (s ?? '').charAt(0).toUpperCase() + (s ?? '').slice(1);
        const fmt = s => (s == null || s === '') ? '—' : s;
        const esc = s => String(s ?? '').replace(/[&<>"']/g, m => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[m]));
        function tipoColor(tipo) {
            const t = (tipo || '').toLowerCase();
            return ({
                quiz: 'bg-indigo-50 text-indigo-700',
                survey: 'bg-violet-50 text-violet-700',
                work: 'bg-amber-50 text-amber-700',
                forum:'bg-sky-50 text-sky-700'
            }[t]) || 'bg-slate-100 text-slate-700';
        }
        function estadoBadge(estado) {
            const cls = ({
                'Publicado':    'bg-emerald-50 text-emerald-700',
                'No publicado': 'bg-slate-100 text-slate-700',
                'Expirado':     'bg-rose-50 text-rose-700',
                'Oculto':       'bg-slate-100 text-slate-700'
            }[estado]) || 'bg-slate-50 text-slate-600';
            return `<span class="inline-flex rounded-full px-2 py-0.5 text-xs ${cls}">${esc(estado ?? '—')}</span>`;
        }
        // agrega/actualiza params a una URL relativa
        function withParams(prev, params) {
            const url = new URL(prev, window.location.origin);
            Object.entries(params).forEach(([k,v])=>{
                if (v === undefined || v === null || v === '') url.searchParams.delete(k);
                else url.searchParams.set(k,v);
            });
            return url.pathname + '?' + url.searchParams.toString();
        }

        // =============== Estado global ===============
        let __grid = null;
        let __qs = new URLSearchParams(); // filtros vigentes
        let __cursoId = null;

        // =============== Render del Grid ===============
        function renderGrid(cursoId) {
            __cursoId = cursoId;

            // construye la URL base con los filtros actuales
            const base = `/aula-virtual/centro-academico/cursos/${cursoId}/actividades?` + __qs.toString();

            // destruye instancia anterior si existe
            if (__grid) { try { __grid.destroy(); } catch(e){}; __grid = null; }

            __grid = new gridjs.Grid({
                className: { table: 'min-w-[980px]' },
                columns: [
                    'Alumno',
                    'Código',
                    { name: 'Tipo', formatter: (_, row) => gridjs.html(
                            `<span class="inline-flex rounded-full px-2 py-0.5 text-xs ${tipoColor(row.cells[2].data)}">${esc(cap(row.cells[2].data))}</span>`
                        )},
                    { name: 'Título', formatter: cell => gridjs.html(`<span title="${esc(cell)}">${esc(cell)}</span>`) },
                    { name: 'Estado', formatter: cell => gridjs.html(estadoBadge(cell)) },
                    'Publicación',

                    'Estado alumno'
                ],
                pagination: {
                    limit: 20,
                    server: {
                        // prev será exactamente "base" o el resultado anterior;
                        // aquí solo añadimos limit y offset
                        url: (prev, page, limit) => withParams(base, {
                            limit,
                            offset: page * limit
                        })
                    }
                },
                search: false, // usamos filtros propios
                sort: false,
                server: {
                    url: base, // importante: ya trae filtros
                    then: resp => (resp.data || []).map(r => [
                        r.alumno,
                        r.alumno_codigo,
                        r.actividad_tipo,
                        r.actividad_titulo,
                        r.estado_publicacion,
                        fmt(r.fecha_creacion_recurso),
                        fmt(r.estado_alumno)
                    ]),
                    total: resp => Number(resp.total || 0)
                },
                language: {
                    pagination: {
                        previous: 'Anterior',
                        next: 'Siguiente',
                        showing: 'Mostrando',
                        results: () => 'registros'
                    }
                }
            });

            __grid.render(document.getElementById('grid-actividades'));

            // botón Descargar con los mismos filtros
            const $btn = document.getElementById('btn-descargar');
            if ($btn) {
                $btn.onclick = () => {
                    const url = `/aula-virtual/centro-academico/cursos/${__cursoId}/actividades/export` +
                        (__qs.toString() ? `?${__qs.toString()}` : '');
                    window.location.href = url;
                };
            }
        }

        // =============== Filtros (buscar/tipo/estado) ===============
        function bindFilters(cursoId) {
            const $q = $('#filtro-buscar');
            const $tipo = $('#filtro-tipo');
            const $estado = $('#filtro-estado');
            const $fecha = $('#fecha');

            // aplicar
            $('#btn-filtrar').off('click').on('click', () => {
                const params = {
                    search: $q.val().trim(),
                    tipo: $tipo.val(),
                    estado: $estado.val(),
                    fecha: $fecha.val(),
                };
                __qs = new URLSearchParams();
                Object.entries(params).forEach(([k,v]) => { if (v) __qs.set(k,v); });
                renderGrid(cursoId);
            });

            // enter en buscar
            $q.off('keydown').on('keydown', (e) => {
                if (e.key === 'Enter') {
                    $('#btn-filtrar').click();
                }
            });

            // limpiar
            $('#btn-limpiar').off('click').on('click', () => {
                $q.val(''); $tipo.val(''); $estado.val('');
                __qs = new URLSearchParams(); // sin filtros
                renderGrid(cursoId);
            });
        }

        // =============== Activar card (cuando eligen curso) ===============
        $(document).on('click', '.cursoSelector', function (e) {
            e.preventDefault();
            const cursoId = $(this).data('id');
            const anio = $(this).data('anio');
            const categoria = $(this).data('categoria');
            const titulo = $(this).data('title');
            const cursoNombre = $(this).text().trim();


            // inyecta tu HTML (el que me mandaste) pero con el contenedor del grid
            $('#content-centro').html(`
    <div class="bg-white border border-slate-200 rounded-2xl">

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between px-4 sm:px-6 py-4 border-b border-slate-100">
            <div class="min-w-0">
            <div class="flex flex-wrap items-center gap-2 text-slate-500 text-xs sm:text-sm">
            <a class="hover:text-slate-700" href="#">Año</a><span>›</span>
            <a class="hover:text-slate-700" href="#">${anio}</a><span>›</span>
            <span class="text-slate-700 font-medium">${categoria}</span>
            </div>
            <h1 class="mt-2 text-base sm:text-lg font-semibold text-slate-800 truncate">Curso: ${titulo}</h1>
            </div>
            <div class="flex flex-wrap items-center gap-2">
            <button id="btn-descargar" class="inline-flex items-center gap-2 rounded-lg bg-green-600 text-white px-4 py-2 text-sm hover:bg-green-700 focus:outline-none focus:ring-4 focus:ring-green-200">
            <i data-lucide="download" class="h-4 w-4"></i> Descargar reporte
            </button>
            </div>
            </div>


            <div class="p-4 sm:p-6">

            <div class="mb-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">

            <div class="lg:col-span-2">
            <label for="filtro-buscar" class="mb-1 block text-[11px] font-medium text-slate-600">Buscar recurso</label>
            <div class="relative">
            <input id="filtro-buscar" type="search" placeholder="Escribe un nombre o palabra clave"
            class="h-9 w-full rounded-md border border-slate-200 ps-9 pe-3 text-sm placeholder-slate-400 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100" />
            <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
            </div>
            </div>


            <div>
            <label for="filtro-tipo" class="mb-1 block text-[11px] font-medium text-slate-600">Tipo de recurso</label>
            <div class="relative">
            <select id="filtro-tipo"
            class="h-9 w-full appearance-none rounded-md border border-slate-200 px-3 pr-8 text-sm text-slate-700 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100">
            <option value="">Todos</option>
            <option value="quiz">Quiz</option>
            <option value="survey">Encuesta</option>
            <option value="work">Tarea</option>
            <option value="forum">Foro</option>
            </select>
            <i data-lucide="chevron-down" class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
            </div>
            </div>


            <div>
            <label for="f-r-fecha" class="mb-1 block text-[11px] font-medium text-slate-600">Fecha publicación</label>
            <div class="relative">
            <input id="fecha" type="text" placeholder="Selecciona una fecha" data-datepicker
            class="h-9 w-full rounded-md border border-slate-200 ps-9 pe-3 text-sm text-slate-700 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100" />
            <i data-lucide="calendar" class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
            </div>
            </div>


            <div class="flex items-end gap-2">
            <button id="btn-filtrar" class="inline-flex h-9 items-center gap-2 rounded-md bg-slate-900 px-3 text-sm text-white hover:bg-slate-800">
            <i data-lucide="search" class="h-4 w-4"></i> Buscar
            </button>
            <button id="btn-limpiar" class="inline-flex h-9 items-center gap-2 rounded-md border border-slate-200 px-3 text-sm hover:bg-slate-50">
            <i data-lucide="eraser" class="h-4 w-4"></i> Limpiar
            </button>
            </div>
            </div>


            <div id="grid-actividades" class="overflow-hidden rounded-2xl border border-slate-200"></div>
            </div>
            </div>

            `);


  if (window.lucide) lucide.createIcons();

            setTimeout(() => {
                const el = document.getElementById('fecha');
                if (el && window.Datepicker) {
                    new Datepicker(el, {
                        autohide: true,
                        format: 'yyyy-mm-dd'
                    });
                }
            }, 50);

  // reset filtros cuando abres curso
  __qs = new URLSearchParams();

  bindFilters(cursoId);
  renderGrid(cursoId);
});
</script>





@endsection
