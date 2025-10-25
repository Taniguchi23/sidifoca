@extends('layout.app')
@section('link')
    <link href="https://unpkg.com/gridjs/dist/theme/mermaid.min.css" rel="stylesheet" />
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection
@section('content')
    <div class="h-screen flex gap-4">
        <!-- Árbol / segundo menú -->
        <aside id="eduta-nav" data-collapsed="false"
               class="relative w-64 shrink-0 bg-white border border-slate-200 rounded-2xl p-3 flex flex-col transition-all duration-200 overflow-hidden">

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
                        <details {{$key == $anioActual? 'open' : ''}} class="year">

                            <summary class="flex items-center justify-between px-2 py-2 rounded-md cursor-pointer hover:bg-slate-50">
                          <span class="flex items-center gap-2">
                            <i data-lucide="chevron-right" class="arrow w-4 h-4 text-slate-500"></i>
                            <span>{{$key}}</span>
                          </span>
                                <span class="text-[11px] text-slate-500 bg-slate-100 rounded-full px-2 py-0.5">{{count($categorias)}} categorías</span>
                            </summary>
                            <div class="ml-5 mt-1 space-y-2">
                                @foreach($categorias as $key1 => $categoria)
                                    <details {{$key1 == $categoriaActual? 'open' : ''}}>
                                        <summary class="flex items-center gap-2 cursor-pointer rounded-md px-2 py-1.5 hover:bg-slate-50">
                                            <i data-lucide="chevron-right" class="arrow w-4 h-4 text-slate-500"></i>
                                            {{$key1}}
                                        </summary>
                                        <ul class="ml-5 mt-1 space-y-1">
                                            @foreach($categoria as $curso)
                                                <li><a href="{{ route('aula-virtual.centro-academico.curso', ['id' => $curso['id']]) }}" class="block px-2 py-1.5 rounded-md hover:bg-slate-50 " title="{{ $curso['curso'] }}">
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
            <div class="bg-white border rounded-2xl" x-data="{
                  dropdowns: [
                    { name: 'tipo', label: 'Tipo', items: [
                      { value: 'quiz',   label: 'Quiz'   },
                      { value: 'survey', label: 'Survey' },
                      { value: 'work',   label: 'Work'   },
                      { value: 'forum',  label: 'Forum'  }
                    ]},
                    { name: 'estado', label: 'Estado', items: [
                      { value: 'Publicado',    label: 'Publicado' },
                      { value: 'No publicado', label: 'No publicado' },
                      { value: 'Expirado',     label: 'Expirado' },
                      { value: 'Oculto',       label: 'Oculto' }
                    ]}
                  ],
                  getUrlParams(name) {
                    const params = new URLSearchParams(window.location.search);
                    const values = params.getAll(name + '[]');
                    return values.length > 0 ? values : [];
                  },
                  getSelectedItems(dropdown) {
                    return this.$refs[dropdown.name]
                      ? dropdown.items.filter(item => this.$refs[dropdown.name].selected.includes(item.value))
                      : [];
                  }
                }">

                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between px-4 sm:px-6 py-4 border-b border-slate-100">
                    <div class="min-w-0">
                        <div class="flex flex-wrap items-center gap-2 text-slate-500 text-xs sm:text-sm">
                            <a class="hover:text-slate-700" href="#">Año</a><span>›</span>
                            <a class="hover:text-slate-700" href="#">{{$anioActual}}</a><span>›</span>
                            <span class="text-slate-700 font-medium">{{$categoriaActual}}</span>
                        </div>
                        <h1 class="mt-2 text-base sm:text-lg font-semibold text-slate-800 truncate">Curso: {{$cursoActual->curso}}</h1>
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


                        <div class="">
                            <label class="mb-1 block text-[11px] font-medium text-slate-600">Tipo de recurso</label>

                            <!-- Grid interno: 1 col en móvil, 2 col en sm+ -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">

                                <template x-for="dropdown in dropdowns" :key="dropdown.name">
                                    <div
                                        x-data="{
          open: false,
          search: '',
          selected: getUrlParams(dropdown.name), // lee ?tipo[]=... & estado[]=...
          get filteredItems() {
            return dropdown.items.filter(item =>
              item.label.toLowerCase().includes(this.search.toLowerCase())
            )
          },
          get selectedLabel() {
            if (this.selected.length === 0) return dropdown.label;
            return `${dropdown.label}: ${this.selected.length}`;
          },
          toggle(v) {
            const i = this.selected.indexOf(v);
            if (i >= 0) this.selected.splice(i, 1);
            else this.selected.push(v);
          },
          clear() { this.selected = []; this.search = ''; },
          close() { this.open = false; this.search = ''; }
        }"
                                        class="relative w-full"
                                        :x-ref="dropdown.name">

                                        <!-- Inputs ocultos (para querystring tipo[]/estado[]) -->
                                        <template x-for="value in selected" :key="value">
                                            <input type="hidden" :name="dropdown.name + '[]'" :value="value" aria-label="dropdown">
                                        </template>

                                        <!-- Botón (mismo look que input h-9) -->
                                        <div class="relative">
                                            <button type="button"
                                                    @click="open = !open; $nextTick(() => { if (open) $refs[dropdown.name + '-search']?.focus() })"
                                                    class="h-9 w-full inline-flex items-center justify-between rounded-md border border-slate-200 bg-white pe-8 px-3 text-sm text-slate-700
                         hover:border-slate-300 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100 transition">
                                                <span class="truncate" x-text="selectedLabel"></span>
                                            </button>
                                            <i data-lucide="chevron-down"
                                               class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                                        </div>

                                        <!-- Menú -->
                                        <div x-show="open" x-transition.origin.top.left @click.away="close()"
                                             class="absolute z-20 w-full mt-2 rounded-md shadow-lg bg-white ring-1 ring-slate-200 overflow-hidden">

                                            <!-- Buscador -->
                                            <div class="relative">
                                                <input x-model="search" :x-ref="dropdown.name + '-search'"
                                                       class="h-9 w-full px-3 text-sm text-slate-800 border-b border-slate-100 focus:outline-none"
                                                       type="text" :placeholder="'Buscar ' + dropdown.label.toLowerCase()" @click.stop>
                                                <i data-lucide="search"
                                                   class="absolute right-2 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                                            </div>

                                            <!-- Ítems -->
                                            <div class="max-h-56 overflow-y-auto divide-y divide-slate-100">
                                                <template x-for="item in filteredItems" :key="item.value">
                                                    <label
                                                        @click.stop="toggle(item.value)"
                                                        class="px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 cursor-pointer flex items-center gap-2 transition"
                                                        :class="{ 'bg-indigo-50 text-indigo-700': selected.includes(item.value) }">

                                                        <input type="checkbox"
                                                               :checked="selected.includes(item.value)"
                                                               class="rounded text-indigo-600 focus:ring-indigo-300 flex-shrink-0"
                                                               @click.stop="toggle(item.value)">
                                                        <span class="truncate" x-text="item.label"></span>
                                                    </label>
                                                </template>

                                                <!-- Vacío -->
                                                <div x-show="filteredItems.length === 0" class="px-3 py-3 text-sm text-slate-500">
                                                    Sin resultados
                                                </div>
                                            </div>

                                            <!-- Footer -->
                                            <div class="flex items-center justify-between gap-2 px-3 py-2 bg-slate-50">
                                                <button type="button" class="text-xs px-2 py-1 rounded border border-slate-200 hover:bg-white"
                                                        @click.stop="clear()">
                                                    Limpiar
                                                </button>
                                                <button type="button" class="text-xs px-2 py-1 rounded border border-slate-200 hover:bg-white"
                                                        @click.stop="close()">
                                                    Cerrar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </template>

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
        </section>
    </div>
@endsection
@section('script')
<script src="https://unpkg.com/gridjs/dist/gridjs.umd.js"></script>

<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.0/dist/flowbite.min.js"></script>
<script>
    const cursoId = {{$cursoActual->id}};
    $(document).ready(function () {

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
            const $fecha = $('#fecha');

            // recoge arrays desde <input type="hidden" name="tipo[]"> y "estado[]"
            const collectMulti = (name) =>
                Array.from(document.querySelectorAll(`input[name="${name}[]"]`))
                    .map(i => i.value)
                    .filter(Boolean);

            // aplicar filtros
            $('#btn-filtrar').off('click').on('click', () => {
                __qs = new URLSearchParams();

                const search = ($q.val() || '').trim();
                const fecha  = ($fecha.val() || '').trim();
                if (search) __qs.set('search', search);
                if (fecha)  __qs.set('fecha',  fecha);

                // múltiples (tipo[], estado[])
                for (const v of collectMulti('tipo'))   __qs.append('tipo[]', v);
                for (const v of collectMulti('estado')) __qs.append('estado[]', v);

                renderGrid(cursoId);
            });

            // enter en buscar
            $q.off('keydown').on('keydown', (e) => {
                if (e.key === 'Enter') $('#btn-filtrar').click();
            });

            // limpiar: borra query y resetea la selección Alpine si está accesible
            $('#btn-limpiar').off('click').on('click', () => {
                $q.val(''); $fecha.val('');
                __qs = new URLSearchParams();

                // reset visual de los dropdowns (vacía 'selected')
                document.querySelectorAll('[x-ref="tipo"],[x-ref="estado"]').forEach(el => {
                    if (el.__x && el.__x.$data && Array.isArray(el.__x.$data.selected)) {
                        el.__x.$data.selected = [];
                    }
                });

                renderGrid(cursoId);
            });
        }

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

        bindFilters(cursoId);
        renderGrid(cursoId);
    });
</script>
@endsection
