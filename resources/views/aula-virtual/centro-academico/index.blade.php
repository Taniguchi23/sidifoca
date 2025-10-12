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
                                        <li><a hx-get="{{route('centro-academico.lista')}}" hx-target="#content-centro" hx-swap="innerHTML" class="block px-2 py-1.5 rounded-md hover:bg-slate-50">Inducción</a></li>
                                        <li><a hx-get="{{route('centro-academico.lista')}}" hx-target="#content-centro" hx-swap="innerHTML" class="block px-2 py-1.5 rounded-md hover:bg-slate-50">Plan curricular</a></li>
                                        <li><a hx-get="{{route('centro-academico.lista')}}" hx-target="#content-centro" hx-swap="innerHTML" class="block px-2 py-1.5 rounded-md hover:bg-slate-50">Evaluación formativa</a></li>
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
                    <span>Año → Periodo → Categoría → <em>Curso</em></span>
                </div>
            </div>
        </div>
    </section>


    <!-- Panel derecho -->




</div>








