@extends('layout.app')
@section('content')
    <!-- Lucide (omite si ya lo cargas global) -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <section class="min-w-0 flex-1">
        <div class="bg-white border border-slate-200 rounded-2xl">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between px-4 sm:px-6 py-4 border-b border-slate-100">
                <div class="min-w-0">
                    <div class="flex items-center gap-2 text-slate-500 text-xs sm:text-sm">
                        <a class="hover:text-slate-700" href="#">Auditoría</a><span>›</span>
                        <span class="text-slate-700 font-medium">Logs de sistema</span>
                    </div>
                    <h1 class="mt-2 text-base sm:text-lg font-semibold text-slate-800 truncate">Logs de sistema</h1>
                </div>
                <div class="flex items-center gap-2">
                    <button class="inline-flex items-center gap-2 rounded-lg bg-slate-900 text-white px-3 py-2 text-sm hover:bg-slate-800 focus:outline-none focus:ring-4 focus:ring-slate-300">
                        <i data-lucide="file-spreadsheet" class="h-4 w-4"></i> Descargar Excel
                    </button>
                </div>
            </div>

            <!-- Contenido -->
            <div class="p-4 sm:p-6">
                <!-- Filtros (acciones a la derecha en la MISMA fila) -->
                <div class="mb-3">
                    <div class="grid grid-cols-1 sm:grid-cols-6 lg:grid-cols-12 gap-x-3 gap-y-3 items-end">
                        <!-- Desde -->
                        <div class="sm:col-span-3 lg:col-span-2 min-w-0">
                            <label class="mb-1 block text-[11px] font-medium text-slate-600">Desde</label>
                            <div class="relative z-0">
                                <input type="text" placeholder="YYYY-MM-DD"
                                       class="h-9 w-full rounded-md border border-slate-200 ps-9 pe-3 text-sm placeholder-slate-400 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100">
                                <i data-lucide="calendar" class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                            </div>
                        </div>

                        <!-- Hasta -->
                        <div class="sm:col-span-3 lg:col-span-2 min-w-0">
                            <label class="mb-1 block text-[11px] font-medium text-slate-600">Hasta</label>
                            <div class="relative z-0">
                                <input type="text" placeholder="YYYY-MM-DD"
                                       class="h-9 w-full rounded-md border border-slate-200 ps-9 pe-3 text-sm placeholder-slate-400 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100">
                                <i data-lucide="calendar" class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                            </div>
                        </div>

                        <!-- Módulo -->
                        <div class="sm:col-span-3 lg:col-span-3 min-w-0">
                            <label class="mb-1 block text-[11px] font-medium text-slate-600">Módulo</label>
                            <div class="relative z-0">
                                <select class="h-9 w-full appearance-none rounded-md border border-slate-200 px-3 pr-8 text-sm text-slate-700 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100">
                                    <option>Todos</option><option>Accesos</option><option>Cursos</option><option>Sesiones</option><option>Recursos</option><option>Sistema</option>
                                </select>
                                <i data-lucide="chevron-down" class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                            </div>
                        </div>

                        <!-- Acción -->
                        <div class="sm:col-span-3 lg:col-span-3 min-w-0">
                            <label class="mb-1 block text-[11px] font-medium text-slate-600">Acción</label>
                            <div class="relative z-0">
                                <select class="h-9 w-full appearance-none rounded-md border border-slate-200 px-3 pr-8 text-sm text-slate-700 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100">
                                    <option>Todas</option><option>Login</option><option>Logout</option><option>Acceso curso</option><option>Heartbeat</option><option>Crear</option><option>Actualizar</option><option>Eliminar</option>
                                </select>
                                <i data-lucide="chevron-down" class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                            </div>
                        </div>

                        <!-- Acciones -->
                        <div class="sm:col-span-6 lg:col-span-2 flex items-end justify-end gap-2 ms-auto shrink-0 min-w-[260px] z-10">
                            <button class="inline-flex h-9 items-center gap-2 rounded-md bg-slate-900 px-3 text-sm text-white hover:bg-slate-800 focus:outline-none focus:ring-4 focus:ring-slate-300">
                                <i data-lucide="search" class="h-4 w-4"></i> Buscar
                            </button>
                            <button class="inline-flex h-9 items-center gap-2 rounded-md border border-slate-200 px-3 text-sm hover:bg-slate-50">
                                <i data-lucide="eraser" class="h-4 w-4"></i> Limpiar
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Tabla -->
                <div class="overflow-hidden rounded-2xl border border-slate-200">
                    <div class="overflow-x-auto">
                        <table class="min-w-[1220px] w-full text-sm">
                            <thead class="bg-slate-50 text-slate-600">
                            <tr>
                                <th class="text-left font-medium px-4 py-2" style="min-width:155px">Fecha / Hora</th>
                                <th class="text-left font-medium px-4 py-2">Origen</th>
                                <th class="text-left font-medium px-4 py-2">Módulo</th>
                                <th class="text-left font-medium px-4 py-2">Acción</th>
                                <th class="text-left font-medium px-4 py-2">Usuario</th>
                                <th class="text-left font-medium px-4 py-2">Curso / Objeto</th>
                                <th class="text-left font-medium px-4 py-2">Sesión</th>
                                <th class="text-left font-medium px-4 py-2">IP</th>
                                <th class="text-left font-medium px-4 py-2">User Agent</th>
                                <th class="text-left font-medium px-4 py-2">Resultado</th>
                                <th class="text-left font-medium px-4 py-2">Severidad</th>
                                <th class="text-left font-medium px-4 py-2">Detalle</th>
                                <th class="text-left font-medium px-4 py-2"></th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                            <!-- helpers -->
                            <style>
                                .tag{display:inline-flex;align-items:center;gap:.375rem;padding:.125rem .5rem;border-radius:9999px;font-size:12px;font-weight:500}
                                .tb-login{background:#e6f0ff;color:#1d4ed8}
                                .tb-access{background:#e0f2fe;color:#0369a1}
                                .tb-course{background:#fef9c3;color:#854d0e}
                                .tb-online{background:#f1f5f9;color:#334155}
                                .tb-default{background:#eef2ff;color:#4f46e5}
                                .tb-app{background:#fee2e2;color:#b91c1c}
                                .res-ok{background:#ecfdf5;color:#047857}
                                .res-fail{background:#fff1f2;color:#be123c}
                                .res-block{background:#ffe4e6;color:#9f1239}
                                .sev-info{background:#eff6ff;color:#1d4ed8}
                                .sev-warn{background:#fffbeb;color:#b45309}
                                .sev-err{background:#fee2e2;color:#b91c1c}
                            </style>

                            <!-- track_e_login OK -->
                            <tr class="hover:bg-slate-50/60">
                                <td class="px-4 py-2">2025-03-26 10:44</td>
                                <td class="px-4 py-2"><span class="tag tb-login"><i data-lucide="log-in" class="h-3.5 w-3.5"></i>track_e_login</span></td>
                                <td class="px-4 py-2">Accesos</td>
                                <td class="px-4 py-2">Login</td>
                                <td class="px-4 py-2 font-medium">gquispe</td>
                                <td class="px-4 py-2">—</td>
                                <td class="px-4 py-2">0</td>
                                <td class="px-4 py-2 font-mono">190.43.12.88</td>
                                <td class="px-4 py-2 truncate" title="Windows 11; Chrome/122.0">Windows 11; Chrome/122.0</td>
                                <td class="px-4 py-2"><span class="tag res-ok"><i data-lucide="check-circle-2" class="h-3.5 w-3.5"></i>Exitoso</span></td>
                                <td class="px-4 py-2"><span class="tag sev-info">info</span></td>
                                <td class="px-4 py-2">Inicio de sesión correcto</td>
                                <td class="px-4 py-2 text-right"><button class="p-1 rounded hover:bg-slate-100" title="Ver detalle"><i data-lucide="eye" class="h-4 w-4 text-slate-500"></i></button></td>
                            </tr>

                            <!-- track_e_login Fallido -->
                            <tr class="hover:bg-slate-50/60">
                                <td class="px-4 py-2">2025-03-24 10:57</td>
                                <td class="px-4 py-2"><span class="tag tb-login"><i data-lucide="log-in" class="h-3.5 w-3.5"></i>track_e_login</span></td>
                                <td class="px-4 py-2">Accesos</td>
                                <td class="px-4 py-2">Login</td>
                                <td class="px-4 py-2 font-medium">mlopez</td>
                                <td class="px-4 py-2">—</td>
                                <td class="px-4 py-2">0</td>
                                <td class="px-4 py-2 font-mono">152.67.120.201</td>
                                <td class="px-4 py-2 truncate" title="macOS; Chrome/121.0">macOS; Chrome/121.0</td>
                                <td class="px-4 py-2"><span class="tag res-fail"><i data-lucide="alert-octagon" class="h-3.5 w-3.5"></i>Fallido</span></td>
                                <td class="px-4 py-2"><span class="tag sev-warn">warn</span></td>
                                <td class="px-4 py-2">Contraseña incorrecta</td>
                                <td class="px-4 py-2 text-right"><button class="p-1 rounded hover:bg-slate-100"><i data-lucide="eye" class="h-4 w-4 text-slate-500"></i></button></td>
                            </tr>

                            <!-- track_e_access: acceso a curso -->
                            <tr class="hover:bg-slate-50/60">
                                <td class="px-4 py-2">2025-03-18 14:10</td>
                                <td class="px-4 py-2"><span class="tag tb-access"><i data-lucide="book-open" class="h-3.5 w-3.5"></i>track_e_access</span></td>
                                <td class="px-4 py-2">Cursos</td>
                                <td class="px-4 py-2">Acceso curso</td>
                                <td class="px-4 py-2 font-medium">rvaldez</td>
                                <td class="px-4 py-2">Curso ID 92</td>
                                <td class="px-4 py-2">0</td>
                                <td class="px-4 py-2 font-mono">179.6.77.2</td>
                                <td class="px-4 py-2 truncate" title="Android; Chrome/120.0">Android; Chrome/120.0</td>
                                <td class="px-4 py-2"><span class="tag res-ok">Exitoso</span></td>
                                <td class="px-4 py-2"><span class="tag sev-info">info</span></td>
                                <td class="px-4 py-2">Entró desde dashboard</td>
                                <td class="px-4 py-2 text-right"><button class="p-1 rounded hover:bg-slate-100"><i data-lucide="eye" class="h-4 w-4 text-slate-500"></i></button></td>
                            </tr>

                            <!-- track_e_course_access: curso en sesión -->
                            <tr class="hover:bg-slate-50/60">
                                <td class="px-4 py-2">2025-03-21 08:05</td>
                                <td class="px-4 py-2"><span class="tag tb-course"><i data-lucide="layers" class="h-3.5 w-3.5"></i>e_access</span></td>
                                <td class="px-4 py-2">Sesiones</td>
                                <td class="px-4 py-2">Acceso curso (sesión)</td>
                                <td class="px-4 py-2 font-medium">lhuaman</td>
                                <td class="px-4 py-2">Curso 92 · Sesión 33</td>
                                <td class="px-4 py-2">33</td>
                                <td class="px-4 py-2 font-mono">200.37.12.51</td>
                                <td class="px-4 py-2 truncate" title="Windows 10; Firefox/124">Windows 10; Firefox/124</td>
                                <td class="px-4 py-2"><span class="tag res-ok">Exitoso</span></td>
                                <td class="px-4 py-2"><span class="tag sev-info">info</span></td>
                                <td class="px-4 py-2">Ingreso por enlace de sesión</td>
                                <td class="px-4 py-2 text-right"><button class="p-1 rounded hover:bg-slate-100"><i data-lucide="eye" class="h-4 w-4 text-slate-500"></i></button></td>
                            </tr>

                            <!-- track_e_default: acción recurso (crear ejercicio) -->
                            <tr class="hover:bg-slate-50/60">
                                <td class="px-4 py-2">2025-03-22 16:31</td>
                                <td class="px-4 py-2"><span class="tag tb-default"><i data-lucide="file-plus-2" class="h-3.5 w-3.5"></i>track_e_default</span></td>
                                <td class="px-4 py-2">Recursos</td>
                                <td class="px-4 py-2">Crear</td>
                                <td class="px-4 py-2 font-medium">jramirez</td>
                                <td class="px-4 py-2">exercise#501 · Curso 92</td>
                                <td class="px-4 py-2">0</td>
                                <td class="px-4 py-2 font-mono">45.7.14.33</td>
                                <td class="px-4 py-2 truncate" title="Edge/121">Edge/121</td>
                                <td class="px-4 py-2"><span class="tag res-ok">Exitoso</span></td>
                                <td class="px-4 py-2"><span class="tag sev-info">info</span></td>
                                <td class="px-4 py-2">Quiz: Tipos de retroalimentación</td>
                                <td class="px-4 py-2 text-right"><button class="p-1 rounded hover:bg-slate-100"><i data-lucide="eye" class="h-4 w-4 text-slate-500"></i></button></td>
                            </tr>

                            <!-- track_e_online: heartbeat -->
                            <tr class="hover:bg-slate-50/60">
                                <td class="px-4 py-2">2025-03-21 08:07</td>
                                <td class="px-4 py-2"><span class="tag tb-online"><i data-lucide="activity" class="h-3.5 w-3.5"></i>track_e_online</span></td>
                                <td class="px-4 py-2">Sistema</td>
                                <td class="px-4 py-2">Heartbeat</td>
                                <td class="px-4 py-2 font-medium">lhuaman</td>
                                <td class="px-4 py-2">—</td>
                                <td class="px-4 py-2">—</td>
                                <td class="px-4 py-2 font-mono">200.37.12.51</td>
                                <td class="px-4 py-2 truncate" title="Windows 10; Firefox/124">Windows 10; Firefox/124</td>
                                <td class="px-4 py-2"><span class="tag res-ok">Exitoso</span></td>
                                <td class="px-4 py-2"><span class="tag sev-info">info</span></td>
                                <td class="px-4 py-2">Ping de sesión activa</td>
                                <td class="px-4 py-2 text-right"><button class="p-1 rounded hover:bg-slate-100"><i data-lucide="eye" class="h-4 w-4 text-slate-500"></i></button></td>
                            </tr>

                            <!-- app.log (Monolog): ERROR -->
                            <tr class="hover:bg-slate-50/60">
                                <td class="px-4 py-2">2025-03-25 12:55</td>
                                <td class="px-4 py-2"><span class="tag tb-app"><i data-lucide="terminal" class="h-3.5 w-3.5"></i>app.log</span></td>
                                <td class="px-4 py-2">Sistema</td>
                                <td class="px-4 py-2">Error</td>
                                <td class="px-4 py-2 font-medium">—</td>
                                <td class="px-4 py-2">—</td>
                                <td class="px-4 py-2">—</td>
                                <td class="px-4 py-2 font-mono">127.0.0.1</td>
                                <td class="px-4 py-2 truncate" title="PHP-FPM; Symfony">PHP-FPM; Symfony</td>
                                <td class="px-4 py-2"><span class="tag res-fail">Fallido</span></td>
                                <td class="px-4 py-2"><span class="tag sev-err">error</span></td>
                                <td class="px-4 py-2">SQLSTATE[HY000] timeout de conexión</td>
                                <td class="px-4 py-2 text-right"><button class="p-1 rounded hover:bg-slate-100"><i data-lucide="eye" class="h-4 w-4 text-slate-500"></i></button></td>
                            </tr>

                            </tbody>
                        </table>
                    </div>

                    <!-- Footer tabla -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 px-3 py-2 bg-white border-t border-slate-100">
                        <div class="flex items-center gap-2">
                            <button class="rounded-md border border-slate-200 px-2 py-1 text-sm hover:bg-slate-50" aria-label="Anterior">
                                <i data-lucide="chevron-left" class="h-4 w-4"></i>
                            </button>
                            <span class="text-xs text-slate-600">1 / 12</span>
                            <button class="rounded-md border border-slate-200 px-2 py-1 text-sm hover:bg-slate-50" aria-label="Siguiente">
                                <i data-lucide="chevron-right" class="h-4 w-4"></i>
                            </button>
                        </div>
                        <div class="text-xs text-slate-600">100 por página</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script> lucide.createIcons(); </script>

@endsection
