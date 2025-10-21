@extends('layout.app')
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
                                            <li><a class="block px-2 py-1.5 rounded-md hover:bg-slate-50 cursoSelector" data-id="{{$curso['id']}}"  title="{{ $curso['curso'] }}">
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
            <div class="min-h-screen flex items-center justify-center p-4">
                <div class="max-w-xl text-center">
                    <i data-lucide="graduation-cap" class="mx-auto h-20 w-20 text-slate-400"></i>
                    <h1 class="mt-4 text-xl font-semibold text-slate-800">Selecciona un curso</h1>
                    <p class="mt-2 text-sm text-slate-600">
                        Elige un curso en el <strong>árbol de navegación</strong> de la izquierda para ver los
                        <strong>datos completos del curso</strong> y el listado de participantes.
                    </p>
                    <div class="mt-4 inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs text-slate-600">
                        <i data-lucide="hand" class="h-4 w-4"></i>
                        <span>Año  → Categoría → <em>Curso</em></span>
                    </div>
                </div>
            </div>
        </section>
        <!-- Panel derecho -->
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            const $content = $('#content-centro'); // donde se reemplaza todo

            $('#lista').on('click', '.cursoSelector', function (e) {
                console.log(666)
                e.preventDefault();
                const cursoId = $(this).data('id');
                const cursoNombre = $(this).text().trim();

                $content.html(`
      <div class="bg-white border border-slate-200 rounded-2xl">
        <div class="flex justify-between px-6 py-4 border-b border-slate-100">
          <h1 class="text-lg font-semibold text-slate-800">Curso: ${escapeHtml(cursoNombre)}</h1>
          <button id="btn-descargar" class="inline-flex items-center gap-2 rounded-lg bg-green-600 text-white px-4 py-2 text-sm hover:bg-green-700">
            <i data-lucide="download" class="h-4 w-4"></i> Descargar reporte
          </button>
        </div>

        <div class="p-4 sm:p-6">
          <!-- Filtro -->
          <div class="flex justify-between items-center mb-3">
            <input id="buscar" type="search" placeholder="Buscar actividad..."
                   class="h-9 w-full sm:w-80 rounded-md border border-slate-200 ps-9 pe-3 text-sm placeholder-slate-400 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100" />
            <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
          </div>

          <!-- Tabla -->
          <div class="overflow-hidden rounded-2xl border border-slate-200">
            <div class="overflow-x-auto">
              <table id="tabla-actividades" class="min-w-[900px] w-full text-sm">
                <thead class="bg-slate-50 text-slate-600">
                  <tr>
                    <th class="text-left px-4 py-2 font-medium">Alumno</th>
                    <th class="text-left px-4 py-2 font-medium">Tipo</th>
                    <th class="text-left px-4 py-2 font-medium">Título</th>
                    <th class="text-left px-4 py-2 font-medium">Estado</th>
                    <th class="text-left px-4 py-2 font-medium">Publicación</th>
                    <th class="text-left px-4 py-2 font-medium">Límite</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-slate-100"></tbody>
              </table>
            </div>

            <!-- Footer con paginación -->
            <div class="flex justify-between items-center px-4 py-2 border-t border-slate-100 text-xs text-slate-600">
              <div id="paginacion" class="flex items-center gap-2"></div>
              <div><span id="total-items">0</span> registros</div>
            </div>
          </div>
        </div>
      </div>
    `);

                lucide.createIcons(); // 🔹 refresca iconos

                // 2️⃣ Traer datos por AJAX
                $.getJSON(`/aula-virtual/centro-academico/cursos/${cursoId}/actividades`, function (resp) {
                    const data = resp.data || [];
                    initGrid(data);
                });
            });

            // 3️⃣ Función para renderizar la tabla con paginación y búsqueda local
            function initGrid(allData) {
                const $tbody = $('#tabla-actividades tbody');
                const $pager = $('#paginacion');
                const $buscar = $('#buscar');
                const $total = $('#total-items');
                let filtered = [...allData];
                let page = 1, perPage = 20;

                function render() {
                    const start = (page - 1) * perPage;
                    const end = start + perPage;
                    const rows = filtered.slice(start, end);

                    $tbody.empty();
                    rows.forEach(r => {
                        $tbody.append(`
          <tr class="hover:bg-slate-50/60">
            <td class="px-4 py-2">${escapeHtml(r.alumno)}</td>
            <td class="px-4 py-2">
              <span class="inline-flex rounded-full px-2 py-0.5 text-xs ${tipoColor(r.actividad_tipo)}">
                ${capitalize(r.actividad_tipo)}
              </span>
            </td>
            <td class="px-4 py-2 truncate" title="${escapeHtml(r.actividad_titulo)}">${escapeHtml(r.actividad_titulo)}</td>
            <td class="px-4 py-2">${estadoBadge(r.estado_publicacion)}</td>
            <td class="px-4 py-2">${r.fecha_publicacion_desde ?? '—'}</td>
            <td class="px-4 py-2">${r.fecha_limite ?? '—'}</td>
          </tr>
        `);
                    });

                    $total.text(filtered.length);
                    renderPagination();
                }

                function renderPagination() {
                    const pages = Math.ceil(filtered.length / perPage);
                    $pager.empty();

                    if (pages <= 1) return;
                    for (let i = 1; i <= pages; i++) {
                        $pager.append(`
          <button data-page="${i}" class="px-2 py-1 border rounded ${i===page?'bg-slate-900 text-white':'hover:bg-slate-50'}">${i}</button>
        `);
                    }
                }

                $pager.on('click', 'button', function () {
                    page = parseInt($(this).data('page'));
                    render();
                });

                $buscar.on('input', function () {
                    const q = $(this).val().toLowerCase();
                    filtered = allData.filter(r =>
                        r.alumno.toLowerCase().includes(q) ||
                        r.actividad_titulo.toLowerCase().includes(q) ||
                        r.actividad_tipo.toLowerCase().includes(q)
                    );
                    page = 1;
                    render();
                });

                render();
            }

            // 🔧 Helpers visuales
            function tipoColor(tipo) {
                const map = {
                    'quiz': 'bg-indigo-50 text-indigo-700',
                    'survey': 'bg-violet-50 text-violet-700',
                    'work': 'bg-amber-50 text-amber-700',
                    'forum': 'bg-sky-50 text-sky-700',
                };
                return map[tipo] || 'bg-slate-100 text-slate-700';
            }

            function estadoBadge(estado) {
                const map = {
                    'Publicado': 'bg-emerald-50 text-emerald-700',
                    'Expirado': 'bg-rose-50 text-rose-700',
                    'Oculto': 'bg-slate-100 text-slate-700',
                };
                const cls = map[estado] || 'bg-slate-50 text-slate-600';
                return `<span class="inline-flex rounded-full px-2 py-0.5 text-xs ${cls}">${estado}</span>`;
            }

            function capitalize(str){ return str.charAt(0).toUpperCase() + str.slice(1); }

            function escapeHtml(str) {
                return String(str ?? '').replace(/[&<>"']/g, s => ({
                    '&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;','\'':'&#39;'
                })[s]);
            }
        });

    </script>
@endsection
