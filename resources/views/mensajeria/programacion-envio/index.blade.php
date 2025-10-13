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

                <nav class="mt-3 flex-1 overflow-y-auto pr-1 text-sm text-slate-700" aria-label="Contenidos">
                    <!-- Año 2025 -->
                    <details open class="year">
                        <summary class="flex items-center justify-between px-2 py-2 rounded-md cursor-pointer hover:bg-slate-50">
          <span class="flex items-center gap-2">
            <i data-lucide="chevron-right" class="arrow w-4 h-4 text-slate-500"></i>
            <span>2025</span>
          </span>
                            <span class="text-[11px] text-slate-500 bg-slate-100 rounded-full px-2 py-0.5">4 periodos</span>
                        </summary>
                        <div class="ml-5 mt-1 space-y-2">

                            <!-- Periodo 1 -->
                            <details open>
                                <summary class="flex items-center gap-2 cursor-pointer rounded-md px-2 py-1.5 hover:bg-slate-50">
                                    <i data-lucide="chevron-right" class="arrow w-4 h-4 text-slate-500"></i>
                                    Periodo 1
                                </summary>
                                <div class="ml-5 mt-1 space-y-2">
                                    <details open>
                                        <summary class="flex items-center gap-2 cursor-pointer rounded-md px-2 py-1.5 hover:bg-slate-50">
                                            <i data-lucide="chevron-right" class="arrow w-4 h-4 text-slate-500"></i>
                                            Gestión Pedagógica
                                        </summary>
                                        <ul class="ml-5 mt-1 space-y-1">
                                            <li><a hx-get="pages/centroacademico/lista.php?curso=Inducción" hx-target="#content-centro" hx-swap="innerHTML" class="block px-2 py-1.5 rounded-md hover:bg-slate-50">Inducción</a></li>
                                            <li><a hx-get="pages/centroacademico/lista.php?curso=Plan curricular" hx-target="#content-centro" hx-swap="innerHTML" class="block px-2 py-1.5 rounded-md hover:bg-slate-50">Plan curricular</a></li>
                                            <li><a hx-get="pages/centroacademico/lista.php?curso=Evaluación formativa" hx-target="#content-centro" hx-swap="innerHTML" class="block px-2 py-1.5 rounded-md hover:bg-slate-50">Evaluación formativa</a></li>
                                        </ul>
                                    </details>

                                    <details>
                                        <summary class="flex items-center gap-2 cursor-pointer rounded-md px-2 py-1.5 hover:bg-slate-50">
                                            <i data-lucide="chevron-right" class="arrow w-4 h-4 text-slate-500"></i>
                                            Innovación Educativa
                                        </summary>
                                        <ul class="ml-5 mt-1 space-y-1">
                                            <li><a hx-get="pages/centroacademico/lista.php?curso=Proyectos innovadores" hx-target="#content-centro" hx-swap="innerHTML" class="block px-2 py-1.5 rounded-md hover:bg-slate-50">Proyectos innovadores</a></li>
                                            <li><a hx-get="pages/centroacademico/lista.php?curso=TIC en el aula" hx-target="#content-centro" hx-swap="innerHTML" class="block px-2 py-1.5 rounded-md hover:bg-slate-50">TIC en el aula</a></li>
                                        </ul>
                                    </details>

                                    <details>
                                        <summary class="flex items-center gap-2 cursor-pointer rounded-md px-2 py-1.5 hover:bg-slate-50">
                                            <i data-lucide="chevron-right" class="arrow w-4 h-4 text-slate-500"></i>
                                            Bienestar Docente
                                        </summary>
                                        <ul class="ml-5 mt-1 space-y-1">
                                            <li><a hx-get="pages/centroacademico/lista.php?curso=Autocuidado y autoestima" hx-target="#content-centro" hx-swap="innerHTML" class="block px-2 py-1.5 rounded-md hover:bg-slate-50">Autocuidado y autoestima</a></li>
                                            <li><a hx-get="pages/centroacademico/lista.php?curso=Manejo del estrés" hx-target="#content-centro" hx-swap="innerHTML" class="block px-2 py-1.5 rounded-md hover:bg-slate-50">Manejo del estrés</a></li>
                                        </ul>
                                    </details>
                                </div>
                            </details>

                            <!-- Periodos 2-4 -->
                            <details>
                                <summary class="flex items-center gap-2 cursor-pointer rounded-md px-2 py-1.5 hover:bg-slate-50">
                                    <i data-lucide="chevron-right" class="arrow w-4 h-4 text-slate-500"></i>
                                    Periodo 2
                                </summary>
                                <ul class="ml-5 mt-1 space-y-1">
                                    <li><a hx-get="pages/centroacademico/lista.php?curso=Acompañamiento pedagógico" hx-target="#content-centro" hx-swap="innerHTML" class="block px-2 py-1.5 rounded-md hover:bg-slate-50">Acompañamiento pedagógico</a></li>
                                    <li><a hx-get="pages/centroacademico/lista.php?curso=Evaluación docente" hx-target="#content-centro" hx-swap="innerHTML" class="block px-2 py-1.5 rounded-md hover:bg-slate-50">Evaluación docente</a></li>
                                </ul>
                            </details>

                            <details>
                                <summary class="flex items-center gap-2 cursor-pointer rounded-md px-2 py-1.5 hover:bg-slate-50">
                                    <i data-lucide="chevron-right" class="arrow w-4 h-4 text-slate-500"></i>
                                    Periodo 3
                                </summary>
                                <ul class="ml-5 mt-1 space-y-1">
                                    <li><a hx-get="pages/centroacademico/lista.php?curso=Liderazgo institucional"  hx-target="#content-centro" hx-swap="innerHTML" class="block px-2 py-1.5 rounded-md hover:bg-slate-50">Liderazgo institucional</a></li>
                                    <li><a hx-get="pages/centroacademico/lista.php?curso=Gestión de equipos" hx-target="#content-centro" hx-swap="innerHTML"  class="block px-2 py-1.5 rounded-md hover:bg-slate-50">Gestión de equipos</a></li>
                                </ul>
                            </details>

                            <details>
                                <summary class="flex items-center gap-2 cursor-pointer rounded-md px-2 py-1.5 hover:bg-slate-50">
                                    <i data-lucide="chevron-right" class="arrow w-4 h-4 text-slate-500"></i>
                                    Periodo 4
                                </summary>
                                <ul class="ml-5 mt-1 space-y-1">
                                    <li><a hx-get="pages/centroacademico/lista.php?curso=Evaluación final" hx-target="#content-centro" hx-swap="innerHTML" class="block px-2 py-1.5 rounded-md hover:bg-slate-50">Evaluación final</a></li>
                                    <li><a hx-get="pages/centroacademico/lista.php?curso=Cierre del año académico" hx-target="#content-centro" hx-swap="innerHTML" class="block px-2 py-1.5 rounded-md hover:bg-slate-50">Cierre del año académico</a></li>
                                </ul>
                            </details>
                        </div>
                    </details>

                    <!-- Año 2024 -->
                    <details class="year mt-2">
                        <summary class="flex items-center justify-between cursor-pointer rounded-md px-2 py-2 hover:bg-slate-50">
          <span class="flex items-center gap-2">
            <i data-lucide="chevron-right" class="arrow w-4 h-4 text-slate-500"></i>
            <span>2024</span>
          </span>
                            <span class="text-[11px] text-slate-500 bg-slate-100 rounded-full px-2 py-0.5">Histórico</span>
                        </summary>
                        <ul class="ml-5 mt-1 space-y-1">
                            <li><a hx-get="pages/centroacademico/lista.php?curso=Edutalentos 2024" hx-target="#content-centro" hx-swap="innerHTML"  class="block px-2 py-1.5 rounded-md hover:bg-slate-50">Edutalentos 2024</a></li>
                            <li><a hx-get="pages/centroacademico/lista.php?curso=Capacitaciones UGEL" hx-target="#content-centro" hx-swap="innerHTML"  class="block px-2 py-1.5 rounded-md hover:bg-slate-50">Capacitaciones UGEL</a></li>
                        </ul>
                    </details>

                    <!-- Año 2023 -->
                    <details class="year mt-2">
                        <summary class="flex items-center justify-between cursor-pointer rounded-md px-2 py-2 hover:bg-slate-50">
          <span class="flex items-center gap-2">
            <i data-lucide="chevron-right" class="arrow w-4 h-4 text-slate-500"></i>
            <span>2023</span>
          </span>
                            <span class="text-[11px] text-slate-500 bg-slate-100 rounded-full px-2 py-0.5">Archivo</span>
                        </summary>
                        <ul class="ml-5 mt-1 space-y-1">
                            <li><a href="#formacion2023" class="block px-2 py-1.5 rounded-md hover:bg-slate-50">Formación continua</a></li>
                            <li><a href="#virtual2023" class="block px-2 py-1.5 rounded-md hover:bg-slate-50">Cursos virtuales</a></li>
                        </ul>
                    </details>
                </nav>
            </div>

            <!-- Botón -->
            <button id="eduta-toggle" type="button" aria-label="Colapsar navegación"
                    class="collapse-btn p-2 rounded-full hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-sky-200">
                <i data-lucide="chevrons-left" class="w-5 h-5 text-slate-700"></i>
            </button>
        </aside>


        <section id="mensajeria-actividades" class="min-w-0 flex-1">
            <div class="bg-white border border-slate-200 rounded-2xl">
                <!-- Header -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between px-4 sm:px-6 py-4 border-b border-slate-100">
                    <div class="min-w-0">
                        <div class="flex items-center gap-2 text-slate-500 text-xs sm:text-sm">
                            <a class="hover:text-slate-700" href="#">Mensajería</a><span>›</span>
                            <span class="text-slate-700 font-medium">Actividades</span>
                        </div>
                        <h1 class="mt-2 text-base sm:text-lg font-semibold text-slate-800 truncate">Programar avisos automáticos</h1>
                    </div>
                    <div class="flex items-center gap-2">
                        <button id="btn-export-xlsx" class="inline-flex items-center gap-2 rounded-lg bg-slate-900 text-white px-3 py-2 text-sm hover:bg-slate-800">
                            <i data-lucide="download" class="h-4 w-4"></i> Descargar Excel
                        </button>
                    </div>
                </div>

                <!-- Contenido -->
                <div class="p-4 sm:p-6">
                    <!-- Filtros -->
                    <div class="rounded-xl border border-slate-200 p-3">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 items-end">
                            <!-- Desde -->
                            <div class="lg:col-span-2">
                                <label class="mb-1 block text-[11px] font-medium text-slate-600">Desde</label>
                                <div class="relative">
                                    <input id="f-desde" type="text" placeholder="YYYY-MM-DD" class="h-9 w-full rounded-md border border-slate-200 ps-9 pe-3 text-sm placeholder-slate-400 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100">
                                    <i data-lucide="calendar" class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                                </div>
                            </div>
                            <!-- Hasta -->
                            <div class="lg:col-span-2">
                                <label class="mb-1 block text-[11px] font-medium text-slate-600">Hasta</label>
                                <div class="relative">
                                    <input id="f-hasta" type="text" placeholder="YYYY-MM-DD" class="h-9 w-full rounded-md border border-slate-200 ps-9 pe-3 text-sm placeholder-slate-400 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100">
                                    <i data-lucide="calendar" class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                                </div>
                            </div>
                            <!-- Tipo -->
                            <div class="lg:col-span-2">
                                <label class="mb-1 block text-[11px] font-medium text-slate-600">Tipo</label>
                                <div class="relative">
                                    <select id="f-tipo" class="h-9 w-full appearance-none rounded-md border border-slate-200 px-3 pr-8 text-sm text-slate-700 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100">
                                        <option value="">Todos</option>
                                        <option>Tarea</option>
                                        <option>Cuestionario</option>
                                        <option>Encuesta</option>
                                        <option>Foro</option>
                                        <option>Recurso</option>
                                    </select>
                                    <i data-lucide="chevron-down" class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                                </div>
                            </div>
                            <!-- Estado -->
                            <div class="lg:col-span-2">
                                <label class="mb-1 block text-[11px] font-medium text-slate-600">Estado</label>
                                <div class="relative">
                                    <select id="f-estado" class="h-9 w-full appearance-none rounded-md border border-slate-200 px-3 pr-8 text-sm text-slate-700 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100">
                                        <option value="">Todos</option>
                                        <option>Publicado</option>
                                        <option>Cerrado</option>
                                        <option>Borrador</option>
                                    </select>
                                    <i data-lucide="chevron-down" class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                                </div>
                            </div>
                            <!-- Módulo -->
                            <div class="lg:col-span-2">
                                <label class="mb-1 block text-[11px] font-medium text-slate-600">Módulo</label>
                                <div class="relative">
                                    <select id="f-mod" class="h-9 w-full appearance-none rounded-md border border-slate-200 px-3 pr-8 text-sm text-slate-700 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100">
                                        <option value="">Todos</option>
                                        <option>Módulo 1</option>
                                        <option>Módulo 2</option>
                                        <option>Módulo 3</option>
                                        <option>Módulo 4</option>
                                    </select>
                                    <i data-lucide="chevron-down" class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                                </div>
                            </div>
                            <!-- Buscar -->
                            <div class="lg:col-span-2">
                                <label class="mb-1 block text-[11px] font-medium text-slate-600">Buscar</label>
                                <div class="relative">
                                    <input id="f-q" type="search" placeholder="Nombre de actividad…" class="h-9 w-full rounded-md border border-slate-200 ps-9 pe-3 text-sm">
                                    <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                                </div>
                            </div>

                            <!-- Acciones de filtros -->
                            <div class="sm:col-span-2 lg:col-span-12">
                                <div class="flex flex-wrap items-center justify-end gap-2">
                                    <button id="btn-buscar" class="inline-flex h-9 items-center gap-2 rounded-md bg-slate-900 px-3 text-sm text-white hover:bg-slate-800">
                                        <i data-lucide="search" class="h-4 w-4"></i> Buscar
                                    </button>
                                    <button id="btn-limpiar" class="inline-flex h-9 items-center gap-2 rounded-md border border-slate-200 px-3 text-sm hover:bg-slate-50">
                                        <i data-lucide="eraser" class="h-4 w-4"></i> Limpiar
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Acciones masivas -->
                        <div class="mt-3 flex flex-wrap items-center justify-between gap-2">
                            <div class="text-xs text-slate-600">
                                <span id="sel-count">0</span> actividades seleccionadas
                            </div>
                            <div class="flex flex-wrap items-center gap-2">
                                <button data-modal-open="#modal-programacion" class="inline-flex h-9 items-center gap-2 rounded-md bg-slate-900 px-3 text-sm text-white hover:bg-slate-800 disabled:opacity-50"
                                        disabled id="btn-programar-masivo">
                                    <i data-lucide="calendar-clock" class="h-4 w-4"></i> Programar envíos automáticos
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla -->
                    <div class="mt-4 overflow-hidden rounded-2xl border border-slate-200">
                        <div class="overflow-x-auto">
                            <table class="min-w-[1100px] w-full text-sm">
                                <thead class="bg-slate-50 text-slate-600">
                                <tr>
                                    <th class="w-10 px-4 py-2"></th>
                                    <th class="text-left font-medium px-4 py-2">Tipo</th>
                                    <th class="text-left font-medium px-4 py-2">Curso / Sección</th>
                                    <th class="text-left font-medium px-4 py-2">Módulo</th>
                                    <th class="text-left font-medium px-4 py-2">Actividad</th>
                                    <th class="text-left font-medium px-4 py-2">Estado</th>
                                    <th class="text-left font-medium px-4 py-2">Publicación</th>
                                    <th class="text-left font-medium px-4 py-2">Fecha límite</th>
                                    <th class="text-left font-medium px-4 py-2">Último acceso</th>
                                </tr>
                                </thead>
                                <tbody id="tbl-actividades" class="divide-y divide-slate-100">
                                <!-- Ejemplos -->
                                <tr class="hover:bg-slate-50/60">
                                    <td class="px-4 py-2">
                                        <input type="checkbox" class="h-4 w-4 border-slate-300 align-middle sel-row">
                                    </td>
                                    <td class="px-4 py-2"><span class="inline-flex items-center gap-1 rounded-full bg-amber-50 text-amber-700 px-2 py-0.5">Tarea</span></td>
                                    <td class="px-4 py-2">Evaluación formativa / Sección A</td>
                                    <td class="px-4 py-2">Módulo 2</td>
                                    <td class="px-4 py-2">Tarea: Retroalimentación efectiva</td>
                                    <td class="px-4 py-2"><span class="inline-flex rounded-full bg-emerald-50 text-emerald-700 px-2 py-0.5">Publicado</span></td>
                                    <td class="px-4 py-2">2025-03-10 08:00</td>
                                    <td class="px-4 py-2">2025-03-17 23:59</td>
                                    <td class="px-4 py-2">2025-03-12 14:22</td>
                                </tr>
                                <tr class="hover:bg-slate-50/60">
                                    <td class="px-4 py-2">
                                        <input type="checkbox" class="h-4 w-4 border-slate-300 align-middle sel-row">
                                    </td>
                                    <td class="px-4 py-2"><span class="inline-flex items-center gap-1 rounded-full bg-indigo-50 text-indigo-700 px-2 py-0.5">Cuestionario</span></td>
                                    <td class="px-4 py-2">Evaluación formativa / Sección B</td>
                                    <td class="px-4 py-2">Módulo 3</td>
                                    <td class="px-4 py-2">Quiz: Tipos de evidencias</td>
                                    <td class="px-4 py-2"><span class="inline-flex rounded-full bg-emerald-50 text-emerald-700 px-2 py-0.5">Publicado</span></td>
                                    <td class="px-4 py-2">2025-03-11 09:00</td>
                                    <td class="px-4 py-2">2025-03-18 23:59</td>
                                    <td class="px-4 py-2">2025-03-15 17:03</td>
                                </tr>
                                <tr class="hover:bg-slate-50/60">
                                    <td class="px-4 py-2">
                                        <input type="checkbox" class="h-4 w-4 border-slate-300 align-middle sel-row">
                                    </td>
                                    <td class="px-4 py-2"><span class="inline-flex items-center gap-1 rounded-full bg-violet-50 text-violet-700 px-2 py-0.5">Encuesta</span></td>
                                    <td class="px-4 py-2">Gestión pedagógica / Sección C</td>
                                    <td class="px-4 py-2">Módulo 1</td>
                                    <td class="px-4 py-2">Encuesta: Uso de criterios</td>
                                    <td class="px-4 py-2"><span class="inline-flex rounded-full bg-emerald-50 text-emerald-700 px-2 py-0.5">Publicado</span></td>
                                    <td class="px-4 py-2">2025-03-16 10:00</td>
                                    <td class="px-4 py-2">2025-03-23 23:59</td>
                                    <td class="px-4 py-2">2025-03-21 13:15</td>
                                </tr>
                                <tr class="hover:bg-slate-50/60">
                                    <td class="px-4 py-2">
                                        <input type="checkbox" class="h-4 w-4 border-slate-300 align-middle sel-row">
                                    </td>
                                    <td class="px-4 py-2"><span class="inline-flex items-center gap-1 rounded-full bg-sky-50 text-sky-700 px-2 py-0.5">Foro</span></td>
                                    <td class="px-4 py-2">Innovación educativa / Sección A</td>
                                    <td class="px-4 py-2">Módulo 2</td>
                                    <td class="px-4 py-2">Foro: Buenas prácticas</td>
                                    <td class="px-4 py-2"><span class="inline-flex rounded-full bg-slate-100 text-slate-700 px-2 py-0.5">Borrador</span></td>
                                    <td class="px-4 py-2">—</td>
                                    <td class="px-4 py-2">—</td>
                                    <td class="px-4 py-2">—</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Footer tabla -->
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 px-3 py-2 bg-white border-t border-slate-100">
                            <div class="text-xs text-slate-600"><span id="res-count">4</span> actividades</div>
                            <div class="flex items-center gap-2">
                                <button class="rounded-md border border-slate-200 px-2 py-1 text-sm hover:bg-slate-50" aria-label="Anterior">
                                    <i data-lucide="chevron-left" class="h-4 w-4"></i>
                                </button>
                                <span class="text-xs text-slate-600">1 / 3</span>
                                <button class="rounded-md border border-slate-200 px-2 py-1 text-sm hover:bg-slate-50" aria-label="Siguiente">
                                    <i data-lucide="chevron-right" class="h-4 w-4"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div> <!-- /p-6 -->
            </div>
        </section>





    </div>



    <!-- MODAL: Programación masiva -->
    <div id="modal-programacion" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true" aria-labelledby="prog-title">
        <div class="absolute inset-0 bg-slate-900/40"></div>
        <div class="relative mx-auto my-6 w-[94%] max-w-4xl">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xl">
                <!-- Header -->
                <div class="flex items-center justify-between px-4 sm:px-6 py-3 border-b border-slate-100">
                    <div>
                        <h2 id="prog-title" class="text-base font-semibold text-slate-800">Programar envíos automáticos</h2>
                        <p class="text-xs text-slate-500 mt-0.5">
                            Se aplicará a <span id="sel-count-modal" class="font-medium">0</span> actividades seleccionadas.
                        </p>
                    </div>
                    <button class="p-2 rounded-md hover:bg-slate-100" data-modal-close>
                        <i data-lucide="x" class="h-5 w-5 text-slate-600"></i>
                    </button>
                </div>

                <!-- Body -->
                <div class="px-4 sm:px-6 py-4">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4">
                        <!-- Columna izquierda: Configuración -->
                        <div class="lg:col-span-12 space-y-4">
                            <!-- Disparador -->
                            <div class="rounded-lg border border-slate-200 p-3">
                                <div class="text-sm font-medium text-slate-800 flex items-center gap-2">
                                    <i data-lucide="alarm-clock" class="h-4 w-4"></i> Disparador
                                </div>
                                <div class="mt-3 grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label class="text-[11px] font-medium text-slate-600">Tipo</label>
                                        <select id="m-trigger" class="mt-1 h-9 w-full rounded-md border border-slate-200 px-3 text-sm focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100">
                                            <option selected>Antes del cierre</option>
                                            <option>Antes de la publicación</option>
                                        </select>
                                    </div>
                                    <div class="grid grid-cols-3 gap-2">
                                        <div>
                                            <label class="text-[11px] font-medium text-slate-600">Antelación</label>
                                            <input id="m-offset" type="number" min="0" value="24" class="mt-1 h-9 w-full rounded-md border border-slate-200 px-3 text-sm">
                                        </div>
                                        <div>
                                            <label class="text-[11px] font-medium text-slate-600">Unidad</label>
                                            <select id="m-offset-unit" class="mt-1 h-9 w-full rounded-md border border-slate-200 px-3 text-sm">
                                                <option>Horas</option>
                                                <option>Días</option>
                                                <option>Minutos</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="text-[11px] font-medium text-slate-600">Días hábiles</label>
                                            <select id="m-business" class="mt-1 h-9 w-full rounded-md border border-slate-200 px-3 text-sm">
                                                <option value="true">Sí</option>
                                                <option value="false">No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Rango oficina -->
                                    <div class="sm:col-span-2">
                                        <label class="text-[11px] font-medium text-slate-600">Horario de oficina (envío permitido)</label>
                                        <div class="mt-1 grid grid-cols-2 gap-2">
                                            <div class="relative">
                                                <input id="m-office-from" type="time" value="08:00" class="h-9 w-full rounded-md border border-slate-200 px-3 text-sm">
                                                <span class="absolute right-2 top-1/2 -translate-y-1/2 text-[11px] text-slate-400">Desde</span>
                                            </div>
                                            <div class="relative">
                                                <input id="m-office-to" type="time" value="20:00" class="h-9 w-full rounded-md border border-slate-200 px-3 text-sm">
                                                <span class="absolute right-2 top-1/2 -translate-y-1/2 text-[11px] text-slate-400">Hasta</span>
                                            </div>
                                        </div>
                                        <p class="mt-1 text-[11px] text-slate-500">Si la hora cae fuera del rango, se ajustará al siguiente horario disponible.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Canales y plantillas -->
                            <div class="rounded-lg border border-slate-200 p-3">
                                <div class="text-sm font-medium text-slate-800 flex items-center gap-2">
                                    <i data-lucide="share-2" class="h-4 w-4"></i> Canales & Plantillas
                                </div>
                                <div class="mt-3 grid grid-cols-1 sm:grid-cols-3 gap-3">
                                    <!-- WhatsApp -->
                                    <div class="rounded-md border border-slate-200 p-2">
                                        <div class="flex items-center justify-between">
                                            <div class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-800">
                                                <i data-lucide="messages-square" class="h-4 w-4 text-emerald-600"></i> WhatsApp
                                            </div>
                                            <label class="inline-flex items-center gap-2 text-xs text-slate-600">
                                                <input id="ch-wa" type="checkbox" class="h-4 w-4 border-slate-300"> Usar
                                            </label>
                                        </div>
                                        <label class="mt-2 block text-[11px] font-medium text-slate-600">Plantilla</label>
                                        <select id="wa-template" class="mt-1 h-9 w-full rounded-md border border-slate-200 px-3 text-sm" disabled>
                                            <option value="">Selecciona…</option>
                                            <option>reminder_24h</option>
                                            <option>overdue_1d</option>
                                            <option>friendly_nudge</option>
                                        </select>
                                    </div>
                                    <!-- SMS -->
                                    <div class="rounded-md border border-slate-200 p-2">
                                        <div class="flex items-center justify-between">
                                            <div class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-800">
                                                <i data-lucide="smartphone" class="h-4 w-4 text-sky-600"></i> SMS
                                            </div>
                                            <label class="inline-flex items-center gap-2 text-xs text-slate-600">
                                                <input id="ch-sms" type="checkbox" class="h-4 w-4 border-slate-300"> Usar
                                            </label>
                                        </div>
                                        <label class="mt-2 block text-[11px] font-medium text-slate-600">Plantilla</label>
                                        <select id="sms-template" class="mt-1 h-9 w-full rounded-md border border-slate-200 px-3 text-sm" disabled>
                                            <option value="">Selecciona…</option>
                                            <option>Recordatorio vencimiento</option>
                                            <option>Aviso breve</option>
                                        </select>
                                    </div>
                                    <!-- Correo -->
                                    <div class="rounded-md border border-slate-200 p-2">
                                        <div class="flex items-center justify-between">
                                            <div class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-800">
                                                <i data-lucide="mail" class="h-4 w-4 text-indigo-600"></i> Correo
                                            </div>
                                            <label class="inline-flex items-center gap-2 text-xs text-slate-600">
                                                <input id="ch-mail" type="checkbox" class="h-4 w-4 border-slate-300"> Usar
                                            </label>
                                        </div>
                                        <label class="mt-2 block text-[11px] font-medium text-slate-600">Plantilla / Asunto</label>
                                        <select id="mail-template" class="mt-1 h-9 w-full rounded-md border border-slate-200 px-3 text-sm" disabled>
                                            <option value="">Selecciona…</option>
                                            <option>Tu actividad vence mañana</option>
                                            <option>Queda poco tiempo</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Reglas -->
                            <div class="rounded-lg border border-slate-200 p-3">
                                <div class="text-sm font-medium text-slate-800 flex items-center gap-2">
                                    <i data-lucide="settings-2" class="h-4 w-4"></i> Reglas & opciones
                                </div>
                                <div class="mt-3 grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label class="text-[11px] font-medium text-slate-600">Prioridad</label>
                                        <select id="m-priority" class="mt-1 h-9 w-full rounded-md border border-slate-200 px-3 text-sm">
                                            <option>Normal</option>
                                            <option>Alta</option>
                                            <option>Baja</option>
                                        </select>
                                    </div>
                                    <div class="grid grid-cols-2 gap-2">
                                        <div>
                                            <label class="text-[11px] font-medium text-slate-600">Reintentos máx.</label>
                                            <input id="m-retries" type="number" min="0" value="2" class="mt-1 h-9 w-full rounded-md border border-slate-200 px-3 text-sm">
                                        </div>
                                        <div>
                                            <label class="text-[11px] font-medium text-slate-600">Intervalo (min)</label>
                                            <input id="m-retry-gap" type="number" min="1" value="30" class="mt-1 h-9 w-full rounded-md border border-slate-200 px-3 text-sm">
                                        </div>
                                    </div>
                                    <div class="sm:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-2">
                                        <label class="inline-flex items-center gap-2 text-sm text-slate-700">
                                            <input id="m-skip-completed" type="checkbox" class="h-4 w-4 border-slate-300">
                                            Omitir si el alumno ya completó la actividad
                                        </label>
                                        <label class="inline-flex items-center gap-2 text-sm text-slate-700">
                                            <input id="m-avoid-dup" type="checkbox" class="h-4 w-4 border-slate-300" checked>
                                            Evitar duplicados por destinatario (24h)
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>

                <!-- Footer -->
                <div class="px-4 sm:px-6 py-3 border-t border-slate-100 flex items-center justify-end gap-2">
                    <button class="inline-flex h-9 items-center gap-2 rounded-md border border-slate-200 px-3 text-sm hover:bg-slate-50" data-modal-close>
                        <i data-lucide="x" class="h-4 w-4"></i> Cancelar
                    </button>
                    <button id="m-confirm" class="inline-flex h-9 items-center gap-2 rounded-md bg-slate-900 px-3 text-sm text-white hover:bg-slate-800">
                        <i data-lucide="check" class="h-4 w-4"></i> Programar ahora
                    </button>
                </div>
            </div>
        </div>
    </div>






    <script>
        try { lucide.createIcons(); } catch(e) {}

        // Hooks mínimos (puedes reemplazar con tu JS)
        const modal = document.querySelector('#modal-programacion');
        document.querySelectorAll('[data-modal-open]').forEach(btn=>{
            btn.addEventListener('click', e=>{
                const target = btn.getAttribute('data-modal-open');
                document.querySelector(target)?.classList.remove('hidden');
                updateSelCountModal();
            });
        });
        document.querySelectorAll('[data-modal-close]').forEach(btn=>{
            btn.addEventListener('click', ()=> modal.classList.add('hidden'));
        });
        modal?.addEventListener('click', (e)=>{ if(e.target===modal) modal.classList.add('hidden'); });

        // Habilitar selects por canal
        const chWa = document.getElementById('ch-wa'), waT = document.getElementById('wa-template');
        const chSms = document.getElementById('ch-sms'), smsT = document.getElementById('sms-template');
        const chMail = document.getElementById('ch-mail'), mailT = document.getElementById('mail-template');
        [ [chWa,waT], [chSms,smsT], [chMail,mailT] ].forEach(([chk,sel])=>{
            if (!chk || !sel) return;
            chk.addEventListener('change', ()=> sel.disabled = !chk.checked);
        });

        // Selección en tabla
        const selRows = ()=> Array.from(document.querySelectorAll('.sel-row:checked'));
        const selCount = document.getElementById('sel-count');
        const selCountModal = document.getElementById('sel-count-modal');
        const btnMass = document.getElementById('btn-programar-masivo');

        function updateSelCount() {
            const n = selRows().length;
            if(selCount) selCount.textContent = n;
            if(btnMass) btnMass.disabled = n===0;
        }
        function updateSelCountModal() {
            const n = selRows().length;
            if(selCountModal) selCountModal.textContent = n;
        }
        document.querySelectorAll('.sel-row').forEach(cb=> cb.addEventListener('change', updateSelCount));
    </script>

@endsection
