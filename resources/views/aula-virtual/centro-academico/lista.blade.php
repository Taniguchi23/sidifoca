
<div class="bg-white border border-slate-200 rounded-2xl">
    <!-- Header -->
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between px-4 sm:px-6 py-4 border-b border-slate-100">
        <div class="min-w-0">
            <div class="flex flex-wrap items-center gap-2 text-slate-500 text-xs sm:text-sm">
                <a class="hover:text-slate-700" href="#">Año</a><span>›</span>
                <a class="hover:text-slate-700" href="#">2025</a><span>›</span>
                <a class="hover:text-slate-700" href="#">Periodo 1</a><span>›</span>
                <span class="text-slate-700 font-medium">Categorías</span>
            </div>
            <h1 class="mt-2 text-base sm:text-lg font-semibold text-slate-800 truncate">Curso: </h1>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <button class="inline-flex items-center gap-2 rounded-lg bg-green-600 text-white px-4 py-2 text-sm hover:bg-green-700 focus:outline-none focus:ring-4 focus:ring-green-200">
                <svg class="h-4 w-4 text-white" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M5 3h14v4H5zM5 9h14v12H5zM8 12h8v2H8zM8 16h8v2H8z"/>
                </svg>
                Descargar reporte
            </button>
        </div>
    </div>

    <!-- Contenido -->
    <div class="p-4 sm:p-6">
        <!-- Controles de tabs -->
        <div class="flex items-center justify-between gap-3 flex-wrap">
            <div class="flex p-1 bg-slate-100 rounded-full text-sm" role="tablist" aria-label="Secciones de reporte">
                <button data-tab-target="recursos" role="tab" aria-selected="true"
                        class="tab-btn px-3 py-1.5 rounded-full font-medium text-slate-900 bg-white shadow-sm ring-1 ring-slate-200">
                    Recursos/Actividades
                </button>
                <button data-tab-target="participantes" role="tab" aria-selected="false"
                        class="tab-btn px-3 py-1.5 rounded-full font-medium text-slate-600 hover:text-slate-900">
                    Participantes
                </button>
            </div>
        </div>

        <!-- TAB: RECURSOS -->
        <section id="tab-recursos" data-tab-panel="recursos" role="tabpanel" class="mt-4">
            <!-- Filtros Recursos -->
            <!-- Filtros (compacto + Lucide) -->
            <div class="mb-4">
                <!-- GRID compacto -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">

                    <!-- Buscar -->
                    <div class="lg:col-span-2">
                        <label for="f-r-q" class="mb-1 block text-[11px] font-medium text-slate-600">Buscar recurso</label>
                        <div class="relative">
                            <input id="f-r-q" type="search" placeholder="Escribe un nombre o palabra clave"
                                   class="h-9 w-full rounded-md border border-slate-200 ps-9 pe-3 text-sm placeholder-slate-400
                      focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100" />
                            <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                        </div>
                    </div>

                    <!-- Sección -->
                    <div>
                        <label for="f-r-seccion" class="mb-1 block text-[11px] font-medium text-slate-600">Sección</label>
                        <div class="relative">
                            <select id="f-r-seccion"
                                    class="h-9 w-full appearance-none rounded-md border border-slate-200 px-3 pr-8 text-sm text-slate-700
                       focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100">
                                <option value="">Todas</option>
                                <option>Sección A (Mañana)</option>
                                <option>Sección B (Tarde)</option>
                            </select>
                            <i data-lucide="chevron-down" class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                        </div>
                    </div>

                    <!-- Módulo -->
                    <div>
                        <label for="f-r-mod" class="mb-1 block text-[11px] font-medium text-slate-600">Módulo</label>
                        <div class="relative">
                            <select id="f-r-mod"
                                    class="h-9 w-full appearance-none rounded-md border border-slate-200 px-3 pr-8 text-sm text-slate-700
                       focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100">
                                <option value="">Todos</option>
                                <option>Módulo 1</option>
                                <option>Módulo 2</option>
                            </select>
                            <i data-lucide="chevron-down" class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                        </div>
                    </div>

                    <!-- Fecha publicación (Flowbite Datepicker) -->
                    <div>
                        <label for="f-r-fecha" class="mb-1 block text-[11px] font-medium text-slate-600">Fecha publicación</label>
                        <div class="relative">
                            <input id="f-r-fecha" type="text" placeholder="Selecciona una fecha"
                                   data-datepicker
                                   class="h-9 w-full rounded-md border border-slate-200 ps-9 pe-3 text-sm text-slate-700
                      focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100" />
                            <i data-lucide="calendar" class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                        </div>
                    </div>
                </div>

                <!-- Fila 2 de filtros -->
                <div class="mt-3 flex flex-wrap items-end gap-3">
                    <div class="grid grid-cols-2 sm:auto-cols-max sm:grid-flow-col gap-3">
                        <!-- Tipo -->
                        <div>
                            <label for="f-r-tipo" class="mb-1 block text-[11px] font-medium text-slate-600">Tipo de recurso</label>
                            <div class="relative">
                                <select id="f-r-tipo"
                                        class="h-9 w-full appearance-none rounded-md border border-slate-200 px-3 pr-8 text-sm text-slate-700
                         focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100">
                                    <option value="">Todos</option>
                                    <option>Tarea</option>
                                    <option>Foro</option>
                                    <option>Encuesta</option>
                                    <option>Cuestionario</option>
                                    <option>Video</option>
                                </select>
                                <i data-lucide="chevron-down" class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                            </div>
                        </div>

                        <!-- Estado -->
                        <div>
                            <label for="f-r-estado" class="mb-1 block text-[11px] font-medium text-slate-600">Estado</label>
                            <div class="relative">
                                <select id="f-r-estado"
                                        class="h-9 w-full appearance-none rounded-md border border-slate-200 px-3 pr-8 text-sm text-slate-700
                         focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100">
                                    <option value="">Todos</option>
                                    <option>Publicado</option>
                                    <option>Cerrado</option>
                                    <option>Borrador</option>
                                </select>
                                <i data-lucide="chevron-down" class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="ms-auto flex gap-2">
                        <button
                            class="inline-flex h-9 items-center gap-2 rounded-md bg-slate-900 px-3 text-sm text-white
               hover:bg-slate-800 focus:outline-none focus:ring-4 focus:ring-slate-300">
                            <i data-lucide="search" class="h-4 w-4"></i>
                            Buscar
                        </button>
                        <button
                            class="inline-flex h-9 items-center gap-2 rounded-md border border-slate-200 px-3 text-sm
               hover:bg-slate-50">
                            <i data-lucide="eraser" class="h-4 w-4"></i>
                            Limpiar
                        </button>
                    </div>
                </div>
            </div>



            <div class="overflow-hidden rounded-2xl border border-slate-200">
                <div class="overflow-x-auto">
                    <table class="min-w-[980px] w-full text-sm">
                        <thead class="bg-slate-50 text-slate-600">
                        <tr>
                            <th class="text-left font-medium px-4 py-2">Sección</th>
                            <th class="text-left font-medium px-4 py-2">Módulo</th>
                            <th class="text-left font-medium px-4 py-2">Tipo</th>
                            <th class="text-left font-medium px-4 py-2">Nombre</th>
                            <th class="text-left font-medium px-4 py-2">Estado</th>
                            <th class="text-left font-medium px-4 py-2">Fecha publicación</th>
                            <th class="text-left font-medium px-4 py-2">Fecha límite/cierre</th>
                            <th class="text-left font-medium px-4 py-2">Último acceso</th>
                            <th class="text-left font-medium px-4 py-2">Calificación/Resultado</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">

                        <!-- Actividad 1 -->
                        <tr class="hover:bg-slate-50/60">
                            <td class="px-4 py-2">Sección A</td>
                            <td class="px-4 py-2">Módulo 1: Fundamentos de la Evaluación Formativa</td>
                            <td class="px-4 py-2"><span class="inline-flex items-center gap-1 rounded-full bg-amber-50 text-amber-700 px-2 py-0.5">Tarea</span></td>
                            <td class="px-4 py-2">Tarea 1: Análisis de prácticas evaluativas en el aula</td>
                            <td class="px-4 py-2"><span class="inline-flex rounded-full bg-emerald-50 text-emerald-700 px-2 py-0.5">Publicado</span></td>
                            <td class="px-4 py-2">2025-03-04 08:00</td>
                            <td class="px-4 py-2">2025-03-10 23:59</td>
                            <td class="px-4 py-2">2025-03-08 14:25</td>
                            <td class="px-4 py-2">89 / 100</td>
                        </tr>

                        <!-- Foro 1 -->
                        <tr class="hover:bg-slate-50/60">
                            <td class="px-4 py-2">Sección A</td>
                            <td class="px-4 py-2">Módulo 1: Fundamentos de la Evaluación Formativa</td>
                            <td class="px-4 py-2"><span class="inline-flex items-center gap-1 rounded-full bg-sky-50 text-sky-700 px-2 py-0.5">Foro</span></td>
                            <td class="px-4 py-2">Foro: ¿Por qué evaluar para aprender y no solo del aprendizaje?</td>
                            <td class="px-4 py-2"><span class="inline-flex rounded-full bg-emerald-50 text-emerald-700 px-2 py-0.5">Publicado</span></td>
                            <td class="px-4 py-2">2025-03-05 09:00</td>
                            <td class="px-4 py-2">2025-03-17 23:59</td>
                            <td class="px-4 py-2">2025-03-12 16:20</td>
                            <td class="px-4 py-2">Participó (3 aportes)</td>
                        </tr>

                        <!-- Video -->
                        <tr class="hover:bg-slate-50/60">
                            <td class="px-4 py-2">Sección A</td>
                            <td class="px-4 py-2">Módulo 2: Estrategias de Retroalimentación</td>
                            <td class="px-4 py-2"><span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 text-emerald-700 px-2 py-0.5">Video</span></td>
                            <td class="px-4 py-2">Video: La retroalimentación como herramienta de mejora</td>
                            <td class="px-4 py-2"><span class="inline-flex rounded-full bg-emerald-50 text-emerald-700 px-2 py-0.5">Publicado</span></td>
                            <td class="px-4 py-2">2025-03-10 08:00</td>
                            <td class="px-4 py-2">—</td>
                            <td class="px-4 py-2">2025-03-13 09:45</td>
                            <td class="px-4 py-2">Visto (100%)</td>
                        </tr>

                        <!-- Cuestionario -->
                        <tr class="hover:bg-slate-50/60">
                            <td class="px-4 py-2">Sección B</td>
                            <td class="px-4 py-2">Módulo 2: Estrategias de Retroalimentación</td>
                            <td class="px-4 py-2"><span class="inline-flex items-center gap-1 rounded-full bg-indigo-50 text-indigo-700 px-2 py-0.5">Cuestionario</span></td>
                            <td class="px-4 py-2">Quiz: Tipos de retroalimentación</td>
                            <td class="px-4 py-2"><span class="inline-flex rounded-full bg-emerald-50 text-emerald-700 px-2 py-0.5">Publicado</span></td>
                            <td class="px-4 py-2">2025-03-11 10:00</td>
                            <td class="px-4 py-2">2025-03-18 23:59</td>
                            <td class="px-4 py-2">2025-03-15 17:03</td>
                            <td class="px-4 py-2">17 / 20</td>
                        </tr>

                        <!-- Rúbrica -->
                        <tr class="hover:bg-slate-50/60">
                            <td class="px-4 py-2">Sección B</td>
                            <td class="px-4 py-2">Módulo 3: Instrumentos de Evaluación Formativa</td>
                            <td class="px-4 py-2"><span class="inline-flex items-center gap-1 rounded-full bg-fuchsia-50 text-fuchsia-700 px-2 py-0.5">Rúbrica</span></td>
                            <td class="px-4 py-2">Rúbrica: Elaboración de lista de cotejo</td>
                            <td class="px-4 py-2"><span class="inline-flex rounded-full bg-emerald-50 text-emerald-700 px-2 py-0.5">Publicado</span></td>
                            <td class="px-4 py-2">2025-03-14 08:30</td>
                            <td class="px-4 py-2">2025-03-21 23:59</td>
                            <td class="px-4 py-2">2025-03-19 19:40</td>
                            <td class="px-4 py-2">Aprobado (100%)</td>
                        </tr>

                        <!-- Encuesta de autoevaluación -->
                        <tr class="hover:bg-slate-50/60">
                            <td class="px-4 py-2">Sección C</td>
                            <td class="px-4 py-2">Módulo 3: Instrumentos de Evaluación Formativa</td>
                            <td class="px-4 py-2"><span class="inline-flex items-center gap-1 rounded-full bg-violet-50 text-violet-700 px-2 py-0.5">Encuesta</span></td>
                            <td class="px-4 py-2">Autoevaluación: uso de criterios de evaluación</td>
                            <td class="px-4 py-2"><span class="inline-flex rounded-full bg-emerald-50 text-emerald-700 px-2 py-0.5">Publicado</span></td>
                            <td class="px-4 py-2">2025-03-16 10:00</td>
                            <td class="px-4 py-2">2025-03-23 23:59</td>
                            <td class="px-4 py-2">2025-03-21 13:15</td>
                            <td class="px-4 py-2">Completada</td>
                        </tr>

                        <!-- Tarea final -->
                        <tr class="hover:bg-slate-50/60">
                            <td class="px-4 py-2">Sección C</td>
                            <td class="px-4 py-2">Módulo 4: Evaluación y toma de decisiones</td>
                            <td class="px-4 py-2"><span class="inline-flex items-center gap-1 rounded-full bg-amber-50 text-amber-700 px-2 py-0.5">Tarea</span></td>
                            <td class="px-4 py-2">Tarea final: Diseño de un plan de evaluación formativa</td>
                            <td class="px-4 py-2"><span class="inline-flex rounded-full bg-rose-50 text-rose-700 px-2 py-0.5">Cerrado</span></td>
                            <td class="px-4 py-2">2025-03-20 08:00</td>
                            <td class="px-4 py-2">2025-03-27 23:59</td>
                            <td class="px-4 py-2">2025-03-27 21:47</td>
                            <td class="px-4 py-2">96 / 100</td>
                        </tr>

                        <!-- Lectura complementaria -->
                        <tr class="hover:bg-slate-50/60">
                            <td class="px-4 py-2">Sección D</td>
                            <td class="px-4 py-2">Módulo 4: Evaluación y toma de decisiones</td>
                            <td class="px-4 py-2"><span class="inline-flex items-center gap-1 rounded-full bg-slate-100 text-slate-700 px-2 py-0.5">Lectura</span></td>
                            <td class="px-4 py-2">Lectura: Black & Wiliam (1998) “Inside the Black Box”</td>
                            <td class="px-4 py-2"><span class="inline-flex rounded-full bg-emerald-50 text-emerald-700 px-2 py-0.5">Publicado</span></td>
                            <td class="px-4 py-2">2025-03-22 08:00</td>
                            <td class="px-4 py-2">—</td>
                            <td class="px-4 py-2">2025-03-24 11:50</td>
                            <td class="px-4 py-2">Visto (65%)</td>
                        </tr>

                        </tbody>
                    </table>

                </div>

                <!-- Footer tabla -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 px-3 py-2 bg-white border-t border-slate-100">
                    <div class="flex items-center gap-2">
                        <button class="rounded-md border border-slate-200 px-2 py-1 text-sm hover:bg-slate-50" aria-label="Anterior">
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M12.7 5.3a1 1 0 0 1 0 1.4L9.41 10l3.3 3.3a1 1 0 1 1-1.42 1.4l-4-4a1 1 0 0 1 0-1.4l4-4a1 1 0 0 1 1.42 0z"/></svg>
                        </button>
                        <span class="text-xs text-slate-600">1 / 3</span>
                        <button class="rounded-md border border-slate-200 px-2 py-1 text-sm hover:bg-slate-50" aria-label="Siguiente">
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M7.3 14.7a1 1 0 0 1 0-1.4L10.59 10l-3.3-3.3a1 1 0 1 1 1.42-1.4l4 4a1 1 0 0 1 0 1.4l-4 4a1 1 0 0 1-1.42 0z"/></svg>
                        </button>
                    </div>
                    <div class="text-xs text-slate-600">24 por página</div>
                </div>
            </div>
        </section>

        <!-- TAB: PARTICIPANTES -->
        <section id="tab-participantes" data-tab-panel="participantes" role="tabpanel" class="mt-4 hidden">
            <!-- Filtros Participantes -->
            <!-- Filtros de Participantes -->
            <div class="mb-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
                    <!-- Rol -->
                    <div>
                        <label for="f-p-rol" class="mb-1 block text-[11px] font-medium text-slate-600">Rol</label>
                        <div class="relative">
                            <select id="f-p-rol"
                                    class="h-9 w-full appearance-none rounded-md border border-slate-200 px-3 pr-8 text-sm text-slate-700
                       focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100">
                                <option value="">Todos</option>
                                <option>Alumno</option>
                                <option>Profesor</option>
                                <option>Asistente</option>
                            </select>
                            <i data-lucide="chevron-down" class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                        </div>
                    </div>

                    <!-- Buscar persona -->
                    <div class="lg:col-span-2">
                        <label for="f-p-q" class="mb-1 block text-[11px] font-medium text-slate-600">Buscar persona</label>
                        <div class="relative">
                            <input id="f-p-q" type="search" placeholder="Escribe nombre o correo..."
                                   class="h-9 w-full rounded-md border border-slate-200 ps-9 pe-3 text-sm placeholder-slate-400
                      focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100" />
                            <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                        </div>
                    </div>

                    <!-- Estado -->
                    <div>
                        <label for="f-p-status" class="mb-1 block text-[11px] font-medium text-slate-600">Estado</label>
                        <div class="relative">
                            <select id="f-p-status"
                                    class="h-9 w-full appearance-none rounded-md border border-slate-200 px-3 pr-8 text-sm text-slate-700
                       focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100">
                                <option value="">Todos</option>
                                <option>Activo</option>
                                <option>Condicional</option>
                                <option>Retirado</option>
                            </select>
                            <i data-lucide="chevron-down" class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                        </div>
                    </div>

                    <!-- Sección -->
                    <div>
                        <label for="f-p-seccion" class="mb-1 block text-[11px] font-medium text-slate-600">Sección</label>
                        <div class="relative">
                            <select id="f-p-seccion"
                                    class="h-9 w-full appearance-none rounded-md border border-slate-200 px-3 pr-8 text-sm text-slate-700
                       focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100">
                                <option value="">Todas</option>
                                <option>Sección A</option>
                                <option>Sección B</option>
                            </select>
                            <i data-lucide="chevron-down" class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                        </div>
                    </div>
                </div>

                <!-- Botones -->
                <div class="mt-3 flex flex-wrap items-end justify-end gap-2">
                    <button class="inline-flex h-9 items-center gap-2 rounded-md bg-slate-900 px-3 text-sm text-white
                   hover:bg-slate-800 focus:outline-none focus:ring-4 focus:ring-slate-300">
                        <i data-lucide="search" class="h-4 w-4"></i>
                        Buscar
                    </button>
                    <button class="inline-flex h-9 items-center gap-2 rounded-md border border-slate-200 px-3 text-sm
                   hover:bg-slate-50">
                        <i data-lucide="eraser" class="h-4 w-4"></i>
                        Limpiar
                    </button>
                </div>
            </div>


            <!-- Tabla Participantes -->
            <div class="overflow-hidden rounded-2xl border border-slate-200">
                <div class="overflow-x-auto">

                    <table class="min-w-[700px] w-full text-sm">
                        <thead class="bg-slate-50 text-slate-600">
                        <tr>
                            <th class="text-left font-medium px-4 py-2">Rol</th>
                            <th class="text-left font-medium px-4 py-2">Nombre</th>
                            <th class="text-left font-medium px-4 py-2">Correo</th>
                            <th class="text-left font-medium px-4 py-2">Estado</th>
                            <th class="text-left font-medium px-4 py-2">Sección</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                        <tr class="hover:bg-slate-50/60">
                            <td class="px-4 py-2">
                                <span class="tag role-alumno"><i data-lucide="graduation-cap" class="h-3.5 w-3.5"></i>Alumno</span>
                            </td>
                            <td class="px-4 py-2">María López</td>
                            <td class="px-4 py-2">maria.lopez@example.edu</td>
                            <td class="px-4 py-2">
                                <span class="tag st-act"><i data-lucide="check-circle-2" class="h-3.5 w-3.5"></i>Activo</span>
                            </td>
                            <td class="px-4 py-2">Sección A</td>
                        </tr>

                        <tr class="hover:bg-slate-50/60">
                            <td class="px-4 py-2">
                                <span class="tag role-alumno"><i data-lucide="graduation-cap" class="h-3.5 w-3.5"></i>Alumno</span>
                            </td>
                            <td class="px-4 py-2">Luis Vega</td>
                            <td class="px-4 py-2">luis.vega@example.edu</td>
                            <td class="px-4 py-2">
                                <span class="tag st-cond"><i data-lucide="clock-3" class="h-3.5 w-3.5"></i>Condicional</span>
                            </td>
                            <td class="px-4 py-2">Sección B</td>
                        </tr>

                        <tr class="hover:bg-slate-50/60">
                            <td class="px-4 py-2">
                                <span class="tag role-prof"><i data-lucide="notebook-pen" class="h-3.5 w-3.5"></i>Profesor</span>
                            </td>
                            <td class="px-4 py-2">Carla Ríos</td>
                            <td class="px-4 py-2">c.rios@example.edu</td>
                            <td class="px-4 py-2">
                                <span class="tag st-act"><i data-lucide="check-circle-2" class="h-3.5 w-3.5"></i>Activo</span>
                            </td>
                            <td class="px-4 py-2">—</td>
                        </tr>

                        <tr class="hover:bg-slate-50/60">
                            <td class="px-4 py-2">
                                <span class="tag role-asist"><i data-lucide="life-buoy" class="h-3.5 w-3.5"></i>Asistente</span>
                            </td>
                            <td class="px-4 py-2">Jorge Salas</td>
                            <td class="px-4 py-2">j.salas@example.edu</td>
                            <td class="px-4 py-2">
                                <span class="tag st-act"><i data-lucide="check-circle-2" class="h-3.5 w-3.5"></i>Activo</span>
                            </td>
                            <td class="px-4 py-2">Sección A</td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Footer tabla -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 px-3 py-2 bg-white border-t border-slate-100">
                    <div class="flex items-center gap-2">
                        <button class="rounded-md border border-slate-200 px-2 py-1 text-sm hover:bg-slate-50" aria-label="Anterior">
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M12.7 5.3a1 1 0 0 1 0 1.4L9.41 10l3.3 3.3a1 1 0 1 1-1.42 1.4l-4-4a1 1 0 0 1 0-1.4l4-4a1 1 0 0 1 1.42 0z"/></svg>
                        </button>
                        <span class="text-xs text-slate-600">1 / 5</span>
                        <button class="rounded-md border border-slate-200 px-2 py-1 text-sm hover:bg-slate-50" aria-label="Siguiente">
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M7.3 14.7a1 1 0 0 1 0-1.4L10.59 10l-3.3-3.3a1 1 0 1 1 1.42-1.4l4 4a1 1 0 0 1 0 1.4l-4 4a1 1 0 0 1-1.42 0z"/></svg>
                        </button>
                    </div>
                    <div class="text-xs text-slate-600">20 por página</div>
                </div>
            </div>
        </section>
    </div>
</div>
