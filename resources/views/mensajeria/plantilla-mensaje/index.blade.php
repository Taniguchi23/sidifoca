@extends('layout.app')
@section('content')
    <!-- Lucide (omite si ya lo cargas global) -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <section id="mensajeria-plantillas" class="min-w-0 flex-1">
        <div class="bg-white border border-slate-200 rounded-2xl">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between px-4 sm:px-6 py-4 border-b border-slate-100">
                <div class="min-w-0">
                    <div class="flex items-center gap-2 text-slate-500 text-xs sm:text-sm">
                        <a class="hover:text-slate-700" href="#">Mensajería</a><span>›</span>
                        <span class="text-slate-700 font-medium">Plantillas</span>
                    </div>
                    <h1 class="mt-2 text-base sm:text-lg font-semibold text-slate-800 truncate">Plantillas de mensajes automáticos</h1>
                </div>
                <div class="flex items-center gap-2">
                    <button id="btn-new" class="inline-flex items-center gap-2 rounded-lg bg-slate-900 text-white px-3 py-2 text-sm hover:bg-slate-800 focus:outline-none focus:ring-4 focus:ring-slate-300">
                        <i data-lucide="plus" class="h-4 w-4"></i> Nueva plantilla
                    </button>
                </div>
            </div>

            <!-- Contenido -->
            <div class="p-4 sm:p-6">
                <!-- Filtros -->
                <div class="mb-4">
                    <div class="grid grid-cols-1 sm:grid-cols-12 lg:grid-cols-12 gap-x-3 gap-y-3 items-end">
                        <!-- Buscar -->
                        <div class="sm:col-span-6 lg:col-span-4 min-w-0">
                            <label for="flt-q" class="mb-1 block text-[11px] font-medium text-slate-600">Buscar</label>
                            <div class="relative">
                                <input id="flt-q" type="search" placeholder="Nombre, asunto, contenido..."
                                       class="h-9 w-full rounded-md border border-slate-200 ps-9 pe-3 text-sm placeholder-slate-400 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100">
                                <i data-lucide="search" class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                            </div>
                        </div>
                        <!-- Canal -->
                        <div class="sm:col-span-3 lg:col-span-2 min-w-0">
                            <label for="flt-canal" class="mb-1 block text-[11px] font-medium text-slate-600">Canal</label>
                            <div class="relative">
                                <select id="flt-canal" class="h-9 w-full appearance-none rounded-md border border-slate-200 px-3 pr-8 text-sm text-slate-700 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100">
                                    <option value="">Todos</option>
                                    <option>Email</option>
                                    <option>WhatsApp</option>
                                    <option>SMS</option>
                                </select>
                                <i data-lucide="chevron-down" class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                            </div>
                        </div>
                        <!-- Evento -->
                        <div class="sm:col-span-3 lg:col-span-2 min-w-0">
                            <label for="flt-evento" class="mb-1 block text-[11px] font-medium text-slate-600">Evento</label>
                            <div class="relative">
                                <select id="flt-evento" class="h-9 w-full appearance-none rounded-md border border-slate-200 px-3 pr-8 text-sm text-slate-700 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100">
                                    <option value="">Todos</option>
                                    <option>Actividad por vencer</option>
                                    <option>Actividad vencida</option>
                                    <option>Recordatorio general</option>
                                </select>
                                <i data-lucide="chevron-down" class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                            </div>
                        </div>
                        <!-- Estado -->
                        <div class="sm:col-span-3 lg:col-span-2 min-w-0">
                            <label for="flt-estado" class="mb-1 block text-[11px] font-medium text-slate-600">Estado</label>
                            <div class="relative">
                                <select id="flt-estado" class="h-9 w-full appearance-none rounded-md border border-slate-200 px-3 pr-8 text-sm text-slate-700 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100">
                                    <option value="">Todos</option>
                                    <option>Activo</option>
                                    <option>Inactivo</option>
                                </select>
                                <i data-lucide="chevron-down" class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                            </div>
                        </div>
                        <!-- Acciones filtros -->
                        <div class="sm:col-span-12 lg:col-span-2 flex items-end justify-end gap-2 ms-auto shrink-0 min-w-[240px]">
                            <button id="btn-search" class="inline-flex h-9 items-center gap-2 rounded-md bg-slate-900 px-3 text-sm text-white hover:bg-slate-800 focus:outline-none focus:ring-4 focus:ring-slate-300">
                                <i data-lucide="search" class="h-4 w-4"></i> Buscar
                            </button>
                            <button id="btn-clear" class="inline-flex h-9 items-center gap-2 rounded-md border border-slate-200 px-3 text-sm hover:bg-slate-50">
                                <i data-lucide="eraser" class="h-4 w-4"></i> Limpiar
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Tabla -->
                <div class="overflow-hidden rounded-2xl border border-slate-200">
                    <div class="overflow-x-auto">
                        <table class="min-w-[980px] w-full text-sm">
                            <thead class="bg-slate-50 text-slate-600">
                            <tr>
                                <th class="text-left font-medium px-4 py-2">Nombre</th>
                                <th class="text-left font-medium px-4 py-2">Canal</th>
                                <th class="text-left font-medium px-4 py-2">Asunto/Resumen</th>
                                <th class="text-left font-medium px-4 py-2">Últ. edición</th>
                                <th class="text-left font-medium px-4 py-2">Estado</th>
                                <th class="text-left font-medium px-4 py-2">Acciones</th>
                            </tr>
                            </thead>
                            <tbody id="tpl-tbody" class="divide-y divide-slate-100">
                            <!-- filas renderizadas por JS -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Footer tabla -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 px-3 py-2 bg-white border-t border-slate-100">
                        <div class="text-xs text-slate-600"><span id="tpl-count">0</span> resultados</div>
                        <div class="flex items-center gap-2">
                            <button class="rounded-md border border-slate-200 px-2 py-1 text-sm hover:bg-slate-50" aria-label="Anterior">
                                <i data-lucide="chevron-left" class="h-4 w-4"></i>
                            </button>
                            <span class="text-xs text-slate-600">1 / 1</span>
                            <button class="rounded-md border border-slate-200 px-2 py-1 text-sm hover:bg-slate-50" aria-label="Siguiente">
                                <i data-lucide="chevron-right" class="h-4 w-4"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal: Crear/Editar plantilla -->
    <div id="tpl-modal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>

        <div class="relative mx-auto my-8 max-w-5xl px-3 sm:px-0">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xl overflow-hidden">
                <!-- Header -->
                <div class="flex items-center justify-between px-4 sm:px-6 py-3 border-b border-slate-100">
                    <h2 id="tpl-modal-title" class="text-base font-semibold text-slate-800">Nueva plantilla</h2>
                    <button id="tpl-close" class="p-2 rounded-md hover:bg-slate-50">
                        <i data-lucide="x" class="h-5 w-5 text-slate-500"></i>
                    </button>
                </div>

                <!-- Body -->
                <div class="p-4 sm:p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                        <!-- Formulario -->
                        <form id="tpl-form" class="lg:col-span-2 space-y-4">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <!-- Nombre -->
                                <div>
                                    <label class="mb-1 block text-[11px] font-medium text-slate-600">Nombre</label>
                                    <input id="f-nombre" type="text"
                                           class="h-9 w-full rounded-md border border-slate-200 px-3 text-sm focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100"
                                           placeholder="Ej: Recordatorio 24h antes">
                                </div>
                                <!-- Canal -->
                                <div>
                                    <label class="mb-1 block text-[11px] font-medium text-slate-600">Canal</label>
                                    <div class="relative">
                                        <select id="f-canal"
                                                class="h-9 w-full appearance-none rounded-md border border-slate-200 px-3 pr-8 text-sm text-slate-700 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100">
                                            <option>Email</option>
                                            <option>WhatsApp</option>
                                            <option>SMS</option>
                                        </select>
                                        <i data-lucide="chevron-down"
                                           class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Asunto (solo Email) -->
                            <div id="grp-asunto">
                                <label class="mb-1 block text-[11px] font-medium text-slate-600">Asunto (Email)</label>
                                <input id="f-asunto" type="text"
                                       class="h-9 w-full rounded-md border border-slate-200 px-3 text-sm focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100"
                                       placeholder="Ej: ⏰ ActividadNombre vence en 45 días">
                            </div>

                            <!-- Cuerpo -->
                            <div>
                                <div class="flex items-center justify-between">
                                    <label class="mb-1 block text-[11px] font-medium text-slate-600">Cuerpo del mensaje</label>
                                    <div id="sms-counter" class="text-[11px] text-slate-500 hidden">0 / 160</div>
                                </div>
                                <textarea id="f-cuerpo" rows="8"
                                          class="w-full rounded-md border border-slate-200 px-3 py-2 text-sm focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100"
                                          placeholder="Hola usuario.nombres, recuerda que actividad.nombre vence el actividad.fecha_limite."></textarea>
                            </div>

                            <!-- Vista previa -->
                            <details class="rounded-lg border border-slate-200 p-3">
                                <summary class="cursor-pointer text-sm font-medium text-slate-800 flex items-center gap-2">
                                    <i data-lucide="eye" class="h-4 w-4 text-slate-500"></i> Vista previa
                                </summary>
                                <div id="preview" class="mt-3 text-sm text-slate-700 bg-slate-50 rounded-md p-3 whitespace-pre-wrap"></div>
                            </details>
                        </form>

                        <!-- Variables (barra lateral) -->
                        <aside class="lg:col-span-1">
                            <div class="lg:sticky lg:top-6 rounded-xl border border-slate-200 p-3">
                                <div class="flex items-center gap-2">
                                    <i data-lucide="braces" class="h-4 w-4 text-slate-500"></i>
                                    <h3 class="text-sm font-semibold text-slate-800">Variables disponibles</h3>
                                </div>
                                <p class="mt-1 text-[11px] text-slate-500">Haz clic para insertar en el cursor.</p>

                                <!-- Grupos -->
                                <div class="mt-3 space-y-3 text-sm">
                                    <div>
                                        <div class="text-[11px] font-medium text-slate-600 mb-1">Usuario</div>
                                        <div class="flex flex-wrap gap-2">
                                            <button type="button" class="var-chip"> usuario.nombres </button>
                                            <button type="button" class="var-chip"> usuario.apellidos </button>
                                            <button type="button" class="var-chip"> usuario.documento </button>
                                        </div>
                                    </div>

                                    <div>
                                        <div class="text-[11px] font-medium text-slate-600 mb-1">Curso / Docente</div>
                                        <div class="flex flex-wrap gap-2">
                                            <button type="button" class="var-chip"> curso.nombre </button>
                                            <button type="button" class="var-chip"> docente.nombre </button>
                                        </div>
                                    </div>

                                    <div>
                                        <div class="text-[11px] font-medium text-slate-600 mb-1">Actividad</div>
                                        <div class="flex flex-wrap gap-2">
                                            <button type="button" class="var-chip"> actividad.nombre </button>
                                            <button type="button" class="var-chip"> actividad.fecha_limite </button>
                                            <button type="button" class="var-chip"> dias_restantes </button>
                                            <button type="button" class="var-chip"> enlace_actividad </button>
                                        </div>
                                    </div>

                                    <div>
                                        <div class="text-[11px] font-medium text-slate-600 mb-1">Plataforma</div>
                                        <div class="flex flex-wrap gap-2">
                                            <button type="button" class="var-chip"> plataforma.nombre </button>
                                            <button type="button" class="var-chip"> plataforma.url </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <style>
                                .var-chip{padding:.2rem .5rem;border-radius:.375rem;border:1px solid rgb(226 232 240);background:#fff}
                                .var-chip:hover{background:rgb(248 250 252)}
                                .var-chip{font-size:.75rem}
                            </style>
                        </aside>
                    </div>
                </div>

                <!-- Footer -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 px-4 sm:px-6 py-3 border-t border-slate-100">
                    <div class="flex items-center gap-2">
                        <input id="f-prueba" type="text" class="h-9 w-56 rounded-md border border-slate-200 px-3 text-sm" placeholder="Correo / Teléfono de prueba">
                        <button id="btn-test" class="inline-flex h-9 items-center gap-2 rounded-md border border-slate-200 px-3 text-sm hover:bg-slate-50">
                            <i data-lucide="send" class="h-4 w-4"></i> Enviar prueba
                        </button>
                    </div>
                    <div class="flex items-center gap-2 ms-auto">
                        <button id="tpl-cancel" class="inline-flex h-9 items-center gap-2 rounded-md border border-slate-200 px-3 text-sm hover:bg-slate-50">Cancelar</button>
                        <button id="tpl-save" class="inline-flex h-9 items-center gap-2 rounded-md bg-slate-900 px-3 text-sm text-white hover:bg-slate-800 focus:outline-none focus:ring-4 focus:ring-slate-300">
                            <i data-lucide="save" class="h-4 w-4"></i> Guardar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
