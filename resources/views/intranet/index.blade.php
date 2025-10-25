@extends('layout.app')
@section('content')


    <section id="dashboard-plataforma" class="min-w-0 flex-1">
        <div class="bg-white border border-slate-200 rounded-2xl">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between px-4 sm:px-6 py-4 border-b border-slate-100">
                <div class="min-w-0">
                    <div class="flex items-center gap-2 text-slate-500 text-xs sm:text-sm">
                        <a class="hover:text-slate-700" href="#">Administración</a><span>›</span>
                        <span class="text-slate-700 font-medium">Dashboard de la plataforma (Chamilo)</span>
                    </div>
                    <h1 class="mt-2 text-base sm:text-lg font-semibold text-slate-800 truncate">Indicadores globales</h1>
                </div>
                <div class="flex items-center gap-2">
                    <button class="inline-flex items-center gap-2 rounded-lg bg-slate-900 text-white px-3 py-2 text-sm hover:bg-slate-800 focus:outline-none focus:ring-4 focus:ring-slate-300">
                        <i data-lucide="file-spreadsheet" class="h-4 w-4"></i> Ir a Chamilo
                    </button>
                </div>
            </div>

            <!-- Contenido -->
            <div class="p-4 sm:p-6">

                <!-- KPIs (globales de plataforma) -->
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-3">
                    <!-- Usuarios totales -->
                    <div class="rounded-xl border border-slate-200 p-4">
                        <div class="flex items-center justify-between">
                            <div class="text-xs font-medium text-slate-500">Usuarios totales</div>
                            <i data-lucide="user-round" class="h-4 w-4 text-slate-500"></i>
                        </div>
                        <div class="mt-2 text-2xl font-semibold text-slate-900">4,286</div>
                        <div class="mt-2 text-[11px] text-slate-500">Fuente: tabla <code>user</code></div>
                    </div>

                    <!-- Usuarios activos (30d) -->
                    <div class="rounded-xl border border-slate-200 p-4">
                        <div class="flex items-center justify-between">
                            <div class="text-xs font-medium text-slate-500">Usuarios activos (30d)</div>
                            <i data-lucide="users" class="h-4 w-4 text-slate-500"></i>
                        </div>
                        <div class="mt-2 flex items-end gap-2">
                            <div class="text-2xl font-semibold text-slate-900">1,132</div>
                            <div class="text-xs text-emerald-600 inline-flex items-center gap-1"><i data-lucide="trending-up" class="h-3.5 w-3.5"></i>+5%</div>
                        </div>
                        <div class="mt-2 text-[11px] text-slate-500">Fuente: <code>track_e_login</code>, <code>track_e_online</code></div>
                    </div>

                    <!-- DAU (ayer) -->
                    <div class="rounded-xl border border-slate-200 p-4">
                        <div class="flex items-center justify-between">
                            <div class="text-xs font-medium text-slate-500">DAU (ayer)</div>
                            <i data-lucide="activity" class="h-4 w-4 text-slate-500"></i>
                        </div>
                        <div class="mt-2 text-2xl font-semibold text-slate-900">356</div>
                        <div class="mt-2 text-[11px] text-slate-500">Fuente: <code>track_e_login</code> (distintos)</div>
                    </div>

                    <!-- Cursos activos (30d) -->
                    <div class="rounded-xl border border-slate-200 p-4">
                        <div class="flex items-center justify-between">
                            <div class="text-xs font-medium text-slate-500">Cursos activos (30d)</div>
                            <i data-lucide="book-open" class="h-4 w-4 text-slate-500"></i>
                        </div>
                        <div class="mt-2 text-2xl font-semibold text-slate-900">82</div>
                        <div class="mt-2 text-[11px] text-slate-500">Fuente: <code>track_e_course_access</code> / <code>track_e_access</code></div>
                    </div>

                    <!-- Logins (30d) -->
                    <div class="rounded-xl border border-slate-200 p-4">
                        <div class="flex items-center justify-between">
                            <div class="text-xs font-medium text-slate-500">Logins (30d)</div>
                            <i data-lucide="log-in" class="h-4 w-4 text-slate-500"></i>
                        </div>
                        <div class="mt-2 text-2xl font-semibold text-slate-900">9,472</div>
                        <div class="mt-2 text-[11px] text-slate-500">Fuente: <code>track_e_login</code></div>
                    </div>

                    <!-- % Entrega de tareas (30d) -->
                    <div class="rounded-xl border border-slate-200 p-4">
                        <div class="flex items-center justify-between">
                            <div class="text-xs font-medium text-slate-500">% Entrega de tareas (30d)</div>
                            <i data-lucide="file-check-2" class="h-4 w-4 text-slate-500"></i>
                        </div>
                        <div class="mt-2 text-2xl font-semibold text-slate-900">78%</div>
                        <div class="mt-2 text-[11px] text-slate-500">Fuente: <code>c_work</code> / <code>c_student_publication</code></div>
                    </div>

                    <!-- Intentos de cuestionarios (7d) -->
                    <div class="rounded-xl border border-slate-200 p-4">
                        <div class="flex items-center justify-between">
                            <div class="text-xs font-medium text-slate-500">Intentos de cuestionarios (7d)</div>
                            <i data-lucide="edit-3" class="h-4 w-4 text-slate-500"></i>
                        </div>
                        <div class="mt-2 text-2xl font-semibold text-slate-900">2,183</div>
                        <div class="mt-2 text-[11px] text-slate-500">Fuente: <code>track_e_default</code> (tool=exercise) / tablas de quiz</div>
                    </div>

                    <!-- Tasa de finalización promedio -->
                    <div class="rounded-xl border border-slate-200 p-4">
                        <div class="flex items-center justify-between">
                            <div class="text-xs font-medium text-slate-500">Tasa de finalización promedio</div>
                            <i data-lucide="check-circle-2" class="h-4 w-4 text-slate-500"></i>
                        </div>
                        <div class="mt-2 text-2xl font-semibold text-slate-900">64%</div>
                        <div class="mt-2 text-[11px] text-slate-500">Fuente: <code>gradebook_result</code> / criterios del curso</div>
                    </div>
                </div>

                <!-- Gráficas / Distribuciones -->
                <div class="mt-4 grid grid-cols-1 xl:grid-cols-3 gap-3">
                    <!-- Logins vs Activos (14d) -->
                    <div class="rounded-xl border border-slate-200 p-4 xl:col-span-2">
                        <div class="flex items-center justify-between">
                            <div class="text-sm font-semibold text-slate-800">Logins y usuarios activos (últimos 14 días)</div>
                            <i data-lucide="chart-line" class="h-4 w-4 text-slate-500"></i>
                        </div>
                        <div class="mt-3 h-48 bg-slate-50 rounded-md p-2">
                            <svg viewBox="0 0 100 48" class="w-full h-full">
                                <polyline fill="none" stroke="currentColor" stroke-width="2" class="text-indigo-500" points="0,35 7,32 14,30 21,31 28,28 35,26 42,27 49,25 56,24 63,23 70,22 77,21 84,20 91,18 100,17"/>
                                <polyline fill="none" stroke="currentColor" stroke-width="2" class="text-emerald-500" points="0,40 7,39 14,37 21,36 28,34 35,33 42,32 49,31 56,30 63,29 70,29 77,28 84,28 91,27 100,26"/>
                            </svg>
                        </div>
                        <div class="mt-2 text-[11px] text-slate-500">Logins (indigo) vs Activos únicos (verde). Fuente: <code>track_e_login</code> / <code>track_e_online</code></div>
                    </div>

                    <!-- Usuarios por rol (distribución) -->
                    <div class="rounded-xl border border-slate-200 p-4">
                        <div class="flex items-center justify-between">
                            <div class="text-sm font-semibold text-slate-800">Distribución por rol</div>
                            <i data-lucide="pie-chart" class="h-4 w-4 text-slate-500"></i>
                        </div>
                        <div class="mt-3 space-y-2 text-sm">
                            <div class="flex items-center justify-between">
                                <span class="text-slate-700">Alumnos</span>
                                <span class="text-slate-600">68%</span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-2"><div class="h-2 rounded-full bg-indigo-500" style="width:68%"></div></div>

                            <div class="flex items-center justify-between mt-2">
                                <span class="text-slate-700">Profesores</span>
                                <span class="text-slate-600">22%</span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-2"><div class="h-2 rounded-full bg-emerald-500" style="width:22%"></div></div>

                            <div class="flex items-center justify-between mt-2">
                                <span class="text-slate-700">Administradores</span>
                                <span class="text-slate-600">10%</span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-2"><div class="h-2 rounded-full bg-sky-500" style="width:10%"></div></div>
                        </div>
                        <div class="mt-2 text-[11px] text-slate-500">Fuente: <code>user</code> + relaciones <code>course_rel_user</code> (Rol)</div>
                    </div>
                </div>

                <!-- Tablas -->
                <div class="mt-4 grid grid-cols-1 xl:grid-cols-2 gap-3">
                    <!-- Top cursos por participación -->
                    <div class="rounded-xl border border-slate-200 overflow-hidden">
                        <div class="flex items-center justify-between px-4 py-3 border-b border-slate-100">
                            <div class="text-sm font-semibold text-slate-800">Top cursos por participación (30d)</div>
                            <i data-lucide="bar-chart-3" class="h-4 w-4 text-slate-500"></i>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-[560px] w-full text-sm">
                                <thead class="bg-slate-50 text-slate-600">
                                <tr>
                                    <th class="text-left font-medium px-4 py-2">Curso</th>
                                    <th class="text-left font-medium px-4 py-2">Usuarios activos</th>
                                    <th class="text-left font-medium px-4 py-2">% Entrega tareas</th>
                                    <th class="text-left font-medium px-4 py-2">% Finalización</th>
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                <tr class="hover:bg-slate-50/60"><td class="px-4 py-2">Evaluación formativa</td><td class="px-4 py-2">142</td><td class="px-4 py-2">85%</td><td class="px-4 py-2">76%</td></tr>
                                <tr class="hover:bg-slate-50/60"><td class="px-4 py-2">Proyectos innovadores</td><td class="px-4 py-2">97</td><td class="px-4 py-2">74%</td><td class="px-4 py-2">69%</td></tr>
                                <tr class="hover:bg-slate-50/60"><td class="px-4 py-2">TIC en el aula</td><td class="px-4 py-2">79</td><td class="px-4 py-2">71%</td><td class="px-4 py-2">63%</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Riesgo: inactivos -->
                    <div class="rounded-xl border border-slate-200 overflow-hidden">
                        <div class="flex items-center justify-between px-4 py-3 border-b border-slate-100">
                            <div class="text-sm font-semibold text-slate-800">Usuarios con >7 días sin acceso</div>
                            <i data-lucide="bell-ring" class="h-4 w-4 text-slate-500"></i>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-[560px] w-full text-sm">
                                <thead class="bg-slate-50 text-slate-600">
                                <tr>
                                    <th class="text-left font-medium px-4 py-2">Usuario</th>
                                    <th class="text-left font-medium px-4 py-2">Último acceso</th>
                                    <th class="text-left font-medium px-4 py-2">Curso más reciente</th>
                                    <th class="text-left font-medium px-4 py-2">Días</th>
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                <tr class="hover:bg-slate-50/60"><td class="px-4 py-2">María López</td><td class="px-4 py-2">2025-03-10</td><td class="px-4 py-2">Evaluación formativa</td><td class="px-4 py-2">9</td></tr>
                                <tr class="hover:bg-slate-50/60"><td class="px-4 py-2">Luis Vega</td><td class="px-4 py-2">2025-03-12</td><td class="px-4 py-2">Proyectos innovadores</td><td class="px-4 py-2">7</td></tr>
                                <tr class="hover:bg-slate-50/60"><td class="px-4 py-2">Rosa Valdez</td><td class="px-4 py-2">2025-03-08</td><td class="px-4 py-2">TIC en el aula</td><td class="px-4 py-2">11</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Sistema / Errores -->
                <div class="mt-4 grid grid-cols-1 xl:grid-cols-3 gap-3">
                    <div class="rounded-xl border border-slate-200 p-4 xl:col-span-1">
                        <div class="flex items-center justify-between">
                            <div class="text-sm font-semibold text-slate-800">Eventos de sistema (7d)</div>
                            <i data-lucide="server-cog" class="h-4 w-4 text-slate-500"></i>
                        </div>
                        <ul class="mt-3 space-y-2 text-sm">
                            <li class="flex items-center justify-between"><span class="inline-flex items-center gap-2 text-slate-700"><i data-lucide="alert-triangle" class="h-4 w-4 text-rose-500"></i>Errores (HTTP 5xx)</span><span class="rounded-full bg-rose-50 text-rose-700 text-xs px-2 py-0.5">12</span></li>
                            <li class="flex items-center justify-between"><span class="inline-flex items-center gap-2 text-slate-700"><i data-lucide="shield-alert" class="h-4 w-4 text-amber-600"></i>Intentos fallidos de login</span><span class="rounded-full bg-amber-50 text-amber-700 text-xs px-2 py-0.5">73</span></li>
                            <li class="flex items-center justify-between"><span class="inline-flex items-center gap-2 text-slate-700"><i data-lucide="database-backup" class="h-4 w-4 text-slate-500"></i>Backups OK</span><span class="rounded-full bg-emerald-50 text-emerald-700 text-xs px-2 py-0.5">7</span></li>
                        </ul>
                        <div class="mt-2 text-[11px] text-slate-500">Fuente: <code>app.log</code> / <code>track_e_default</code></div>
                    </div>

                    <!-- Horas pico de acceso (24h) -->
                    <div class="rounded-xl border border-slate-200 p-4 xl:col-span-2">
                        <div class="flex items-center justify-between">
                            <div class="text-sm font-semibold text-slate-800">Accesos por hora (24h)</div>
                            <i data-lucide="clock-8" class="h-4 w-4 text-slate-500"></i>
                        </div>
                        <div class="mt-3 grid grid-cols-24 gap-1">
                            <!-- Barras simples; ajusta alturas inline según tus datos -->
                            <!-- 0..23 -->
                            <div class="h-24 bg-slate-50 rounded p-1 col-span-24 grid grid-cols-24 items-end gap-1">
                                <!-- ejemplo random -->
                                <div class="w-full bg-slate-300 rounded" style="height:15%"></div>
                                <div class="w-full bg-slate-300 rounded" style="height:10%"></div>
                                <div class="w-full bg-slate-300 rounded" style="height:8%"></div>
                                <div class="w-full bg-slate-300 rounded" style="height:12%"></div>
                                <div class="w-full bg-slate-300 rounded" style="height:18%"></div>
                                <div class="w-full bg-slate-300 rounded" style="height:22%"></div>
                                <div class="w-full bg-slate-300 rounded" style="height:30%"></div>
                                <div class="w-full bg-slate-300 rounded" style="height:42%"></div>
                                <div class="w-full bg-slate-300 rounded" style="height:60%"></div>
                                <div class="w-full bg-slate-300 rounded" style="height:70%"></div>
                                <div class="w-full bg-slate-300 rounded" style="height:85%"></div>
                                <div class="w-full bg-slate-300 rounded" style="height:90%"></div>
                                <div class="w-full bg-slate-300 rounded" style="height:88%"></div>
                                <div class="w-full bg-slate-300 rounded" style="height:82%"></div>
                                <div class="w-full bg-slate-300 rounded" style="height:75%"></div>
                                <div class="w-full bg-slate-300 rounded" style="height:68%"></div>
                                <div class="w-full bg-slate-300 rounded" style="height:55%"></div>
                                <div class="w-full bg-slate-300 rounded" style="height:40%"></div>
                                <div class="w-full bg-slate-300 rounded" style="height:32%"></div>
                                <div class="w-full bg-slate-300 rounded" style="height:26%"></div>
                                <div class="w-full bg-slate-300 rounded" style="height:20%"></div>
                                <div class="w-full bg-slate-300 rounded" style="height:16%"></div>
                                <div class="w-full bg-slate-300 rounded" style="height:12%"></div>
                                <div class="w-full bg-slate-300 rounded" style="height:10%"></div>
                            </div>
                        </div>
                        <div class="mt-2 text-[11px] text-slate-500">Fuente: <code>track_e_login</code> / <code>track_e_access</code> (agregado por hora)</div>
                    </div>
                </div>

                <!-- Cómo se calcula -->
                <details class="mt-4 rounded-xl border border-slate-200 p-4">
                    <summary class="cursor-pointer text-sm font-semibold text-slate-800 flex items-center gap-2">
                        <i data-lucide="info" class="h-4 w-4 text-slate-500"></i> ¿Cómo se calculan estos indicadores?
                    </summary>
                    <div class="mt-3 text-[13px] leading-6 text-slate-700 space-y-2">
                        <p><strong>Usuarios totales:</strong> conteo en <code>user</code> (opcional filtro por estado).</p>
                        <p><strong>Usuarios activos (30d):</strong> usuarios con ≥1 login o actividad en los últimos 30 días. Fuente: <code>track_e_login</code>, <code>track_e_online</code>.</p>
                        <p><strong>DAU (ayer):</strong> usuarios únicos con login ayer. Fuente: <code>track_e_login</code>.</p>
                        <p><strong>Cursos activos (30d):</strong> cursos con ≥1 acceso/actividad. Fuente: <code>track_e_course_access</code> o <code>track_e_access</code> (agregado por curso).</p>
                        <p><strong>Logins (30d):</strong> conteo de filas en <code>track_e_login</code> en el rango.</p>
                        <p><strong>% Entrega de tareas (30d):</strong> entregas / matriculados (promedio o ponderado por curso). Fuente: <code>c_work</code> y/o <code>c_student_publication</code> + <code>course_rel_user</code>.</p>
                        <p><strong>Intentos de cuestionarios (7d):</strong> eventos del tool <em>exercise</em> en <code>track_e_default</code> o tablas del módulo de quiz.</p>
                        <p><strong>Tasa de finalización:</strong> % usuarios que cumplen criterios de finalización; consolidado desde <code>gradebook_result</code> y reglas de cada curso.</p>
                        <p><strong>Inactivos &gt;7d:</strong> últimos accesos desde <code>track_e_login</code> / <code>track_e_access</code>; diferencia en días &gt; 7.</p>
                        <p><strong>Eventos de sistema:</strong> parseo de <code>app.log</code> y/o severidades en <code>track_e_default</code>; agrupar HTTP 5xx, logins fallidos, jobs/cron, backups.</p>
                    </div>
                </details>
            </div>
        </div>
    </section>



@endsection
