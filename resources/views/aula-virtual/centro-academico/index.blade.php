@extends('layout.app')
@section('link')
    <link href="https://unpkg.com/gridjs/dist/theme/mermaid.min.css" rel="stylesheet" />
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
          ssssss
            <form method="get" action=""
                  class="max-w-6xl mx-auto p-6 bg-white rounded-2xl shadow-lg border border-slate-200"
                  x-data="{
    dropdowns: [
      { name: 'country', label: 'Country', items: [
        { value: 'usa', label: 'USA' }, { value: 'china', label: 'China' },
        { value: 'japan', label: 'Japan' }, { value: 'germany', label: 'Germany' },
        { value: 'uk', label: 'United Kingdom' }, { value: 'india', label: 'India' },
        { value: 'france', label: 'France' }, { value: 'italy', label: 'Italy' },
        { value: 'canada', label: 'Canada' }, { value: 'brazil', label: 'Brazil' }
      ]},
      { name: 'brand', label: 'Brand', items: [
        { value: 'moetchandon', label: 'Moët & Chandon' },
        { value: 'domperignon', label: 'Dom Pérignon' },
        { value: 'veuveclicquot', label: 'Veuve Clicquot' },
        { value: 'crystalroederer', label: 'Louis Roederer Cristal' },
        { value: 'kruger', label: 'Krug' }, { value: 'bollinger', label: 'Bollinger' },
        { value: 'taittinger', label: 'Taittinger' }, { value: 'perrierjouet', label: 'Perrier-Jouët' },
        { value: 'lafite', label: 'Château Lafite Rothschild' },
        { value: 'latour', label: 'Château Latour' },
        { value: 'margaux', label: 'Château Margaux' },
        { value: 'petrus', label: 'Château Pétrus' },
        { value: 'romanee', label: 'Domaine de la Romanée-Conti' }
      ]},
      { name: 'abv', label: 'ABV', items: [
        { value: '0-20', label: '0-20%' },
        { value: '20-40', label: '20-40%' },
        { value: '40-99', label: '40%+' }
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

                <!-- Encabezado -->
                <h2 class="text-2xl font-semibold text-slate-800 mb-6">🍾 Filter your selection</h2>

                <!-- Contenedor de filtros (estilo compacto + slate + indigo) -->
                <div class="flex flex-wrap items-start gap-3 mb-6">
                    <template x-for="dropdown in dropdowns" :key="dropdown.name">
                        <div
                            x-data="{
          open: false,
          search: '',
          selected: getUrlParams(dropdown.name),
          get filteredItems() {
            return dropdown.items.filter(item =>
              item.label.toLowerCase().includes(this.search.toLowerCase())
            )
          },
          get selectedLabel() {
            if (this.selected.length === 0) return dropdown.label;
            return `${dropdown.label}: ${this.selected.length}`;
          }
        }"
                            class="relative w-full md:w-56"
                            :x-ref="dropdown.name">

                            <!-- Inputs ocultos -->
                            <template x-for="value in selected" :key="value">
                                <input type="hidden" :name="dropdown.name + '[]'" :value="value" aria-label="dropdown">
                            </template>

                            <!-- Botón dropdown (mismo look que select h-9) -->
                            <div class="relative">
                                <button type="button"
                                        @click="open = !open; $nextTick(() => { if(open) $refs.searchInput.focus() })"
                                        class="h-9 w-full inline-flex items-center justify-between rounded-md border border-slate-200 bg-white pe-8 px-3 text-sm text-slate-700
                   hover:border-slate-300 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100 transition">
                                    <span x-text="selectedLabel" class="truncate"></span>
                                </button>
                                <i data-lucide="chevron-down"
                                   class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                            </div>

                            <!-- Menú -->
                            <div x-show="open" @click.away="open = false" x-transition
                                 class="absolute z-20 w-full mt-2 rounded-md shadow-lg bg-white ring-1 ring-slate-200 overflow-hidden">
                                <!-- Buscador -->
                                <div class="relative">
                                    <input x-model="search" x-ref="searchInput"
                                           class="h-9 w-full px-3 text-sm text-slate-800 border-b border-slate-100 focus:outline-none"
                                           type="text" :placeholder="'Buscar ' + dropdown.label.toLowerCase()" @click.stop>
                                    <i data-lucide="search"
                                       class="absolute right-2 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                                </div>

                                <!-- Ítems -->
                                <div class="max-h-56 overflow-y-auto divide-y divide-slate-100">
                                    <template x-for="item in filteredItems" :key="item.value">
                                        <div
                                            @click="selected.includes(item.value) ? selected = selected.filter(i => i !== item.value) : selected.push(item.value)"
                                            class="px-3 py-2 text-sm text-slate-700 hover:bg-slate-50 cursor-pointer flex items-center gap-2 transition"
                                            :class="{ 'bg-indigo-50 text-indigo-700': selected.includes(item.value) }">
                                            <input type="checkbox" :checked="selected.includes(item.value)"
                                                   class="rounded text-indigo-600 focus:ring-indigo-300 flex-shrink-0" @click.stop>
                                            <span x-text="item.label" class="truncate"></span>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </template>

                    <!-- Botón de aplicar (como tus acciones) -->
                    <button type="submit"
                            class="inline-flex h-9 items-center gap-2 rounded-md bg-slate-900 px-3 text-sm text-white
             hover:bg-slate-800 focus:outline-none focus:ring-4 focus:ring-slate-300">
                        <i data-lucide="search" class="h-4 w-4"></i>
                        Aplicar filtros
                    </button>
                </div>

                <!-- Filtros seleccionados (chips) -->
                <div class="flex flex-wrap gap-2">
                    <template x-for="dropdown in dropdowns" :key="dropdown.name">
                        <template x-if="$refs[dropdown.name] !== undefined">
                            <template x-for="item in getSelectedItems(dropdown)" :key="item.value">
          <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium
                       bg-slate-100 text-slate-700">
            <span x-text="item.label"></span>
            <button type="button"
                    @click="$refs[dropdown.name].selected = $refs[dropdown.name].selected.filter(i => i !== item.value)"
                    class="p-0.5 hover:bg-slate-200 rounded-full" aria-label="Quitar">
              <svg class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
              </svg>
            </button>
          </span>
                            </template>
                        </template>
                    </template>
                </div>
            </form>

            <!-- Si aún no lo tienes en tu layout: inicializa Lucide -->
            <script>
                document.addEventListener('alpine:init', () => {
                    if (window.lucide?.createIcons) {
                        window.lucide.createIcons();
                    } else {
                        // fallback por si no usas Alpine hook
                        requestAnimationFrame(() => window.lucide?.createIcons?.());
                    }
                });
            </script>



            ssss

            <div id="grid-actividades" class="overflow-hidden rounded-2xl border border-slate-200">

            </div>
        </section>
    </div>
@endsection
@section('script')
    <script src="https://unpkg.com/gridjs/dist/gridjs.umd.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.0/dist/flowbite.min.js"></script>
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
