@extends('layout.app')
@section('content')
    <!-- Lucide -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <section class="min-w-0 flex-1">
        <div class="bg-white border border-slate-200 rounded-2xl">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between px-4 sm:px-6 py-4 border-b border-slate-100">
                <div class="min-w-0">
                    <div class="flex items-center gap-2 text-slate-500 text-xs sm:text-sm">
                        <a class="hover:text-slate-700" href="#">Administración</a><span>›</span>
                        <span class="text-slate-700 font-medium">Gestión de usuarios</span>
                    </div>
                    <h1 class="mt-2 text-base sm:text-lg font-semibold text-slate-800 truncate">Usuarios del sistema</h1>
                </div>
                <div class="flex items-center gap-2">
                    <button class="inline-flex items-center gap-2 rounded-lg bg-green-500 text-white px-3 py-2 text-sm hover:bg-slate-800 focus:outline-none focus:ring-4 focus:ring-slate-300">
                        <i data-lucide="file-spreadsheet" class="h-4 w-4"></i> Descargar Excel
                    </button>
                </div>
            </div>

            <!-- Contenido -->
            <div class="p-4 sm:p-6">
                <!-- Filtros -->
                <div class="mb-3">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
                        <!-- Buscar -->
                        <div class="lg:col-span-2">
                            <label for="f-u-q" class="mb-1 block text-[11px] font-medium text-slate-600">Buscar usuario</label>
                            <div class="relative">
                                <input id="f-u-q" type="search" placeholder="Nombre, usuario o correo"
                                       class="h-9 w-full rounded-md border border-slate-200 ps-9 pe-10 text-sm placeholder-slate-400 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100">
                                <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                                <!-- clear quick -->
                                <button type="button" class="absolute right-2 top-1/2 -translate-y-1/2 p-1 rounded hover:bg-slate-100">
                                    <i data-lucide="x" class="h-4 w-4 text-slate-400"></i>
                                </button>
                            </div>
                        </div>
                        <!-- Rol -->
                        <div>
                            <label class="mb-1 block text-[11px] font-medium text-slate-600">Rol</label>
                            <div class="relative">
                                <select class="h-9 w-full appearance-none rounded-md border border-slate-200 px-3 pr-8 text-sm text-slate-700 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100">
                                    <option>Todos</option><option>Alumno</option><option>Profesor</option><option>Tutor</option><option>Administrador</option>
                                </select>
                                <i data-lucide="chevron-down" class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                            </div>
                        </div>
                        <!-- Estado -->
                        <div>
                            <label class="mb-1 block text-[11px] font-medium text-slate-600">Estado</label>
                            <div class="relative">
                                <select class="h-9 w-full appearance-none rounded-md border border-slate-200 px-3 pr-8 text-sm text-slate-700 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100">
                                    <option>Todos</option><option>Activo</option><option>Pendiente</option><option>Suspenso</option><option>Retirado</option>
                                </select>
                                <i data-lucide="chevron-down" class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                            </div>
                        </div>
                        <!-- Origen -->
                        <div>
                            <label class="mb-1 block text-[11px] font-medium text-slate-600">Origen</label>
                            <div class="relative">
                                <select class="h-9 w-full appearance-none rounded-md border border-slate-200 px-3 pr-8 text-sm text-slate-700 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100">
                                    <option>Todos</option><option>Chamilo</option><option>Edutalentos</option><option>SSO</option>
                                </select>
                                <i data-lucide="chevron-down" class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Botones Buscar / Limpiar -->
                    <div class="mt-3 flex flex-wrap items-end justify-end gap-2">
                        <button class="inline-flex h-9 items-center gap-2 rounded-md bg-slate-900 px-3 text-sm text-white hover:bg-slate-800 focus:outline-none focus:ring-4 focus:ring-slate-300">
                            <i data-lucide="search" class="h-4 w-4"></i> Buscar
                        </button>
                        <button class="inline-flex h-9 items-center gap-2 rounded-md border border-slate-200 px-3 text-sm hover:bg-slate-50">
                            <i data-lucide="eraser" class="h-4 w-4"></i> Limpiar
                        </button>
                    </div>
                </div>

                <!-- Acciones masivas -->
                <div class="flex flex-wrap items-center gap-2 mb-4">
                    <button class="inline-flex items-center gap-2 rounded-md border border-slate-200 px-3 py-1.5 text-sm hover:bg-slate-50">
                        <i data-lucide="toggle-right" class="h-4 w-4"></i> Activar
                    </button>
                    <button class="inline-flex items-center gap-2 rounded-md border border-slate-200 px-3 py-1.5 text-sm hover:bg-slate-50">
                        <i data-lucide="toggle-left" class="h-4 w-4"></i> Desactivar
                    </button>
                    <button class="inline-flex items-center gap-2 rounded-md border border-slate-200 px-3 py-1.5 text-sm hover:bg-slate-50">
                        <i data-lucide="key-round" class="h-4 w-4"></i> Reset clave
                    </button>
                </div>

                <!-- Tabla -->
                <div class="overflow-hidden rounded-2xl border border-slate-200">
                    <div class="overflow-x-auto">
                        <table class="min-w-[1120px] w-full text-sm">
                            <thead class="bg-slate-50 text-slate-600">
                            <tr>
                                <th class="px-4 py-2"><input type="checkbox" class="h-4 w-4 accent-slate-700"></th>
                                <th class="text-left font-medium px-4 py-2">Usuario</th>
                                <th class="text-left font-medium px-4 py-2">Nombre completo</th>
                                <th class="text-left font-medium px-4 py-2">Correo</th>
                                <th class="text-left font-medium px-4 py-2">Rol</th>
                                <th class="text-left font-medium px-4 py-2">Estado</th>
                                <th class="text-left font-medium px-4 py-2">Origen</th>
                                <th class="text-left font-medium px-4 py-2">DRE/UGEL</th>
                                <th class="text-left font-medium px-4 py-2">Último acceso</th>
                                <th class="text-left font-medium px-4 py-2"></th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">

                            <!-- helpers badge -->
                            <style>
                                .tag{display:inline-flex;align-items:center;gap:.375rem;padding:.125rem .5rem;border-radius:9999px;font-size:12px;font-weight:500}
                                .role-alumno{background:#e6f0ff;color:#1d4ed8}
                                .role-prof{background:#f3e8ff;color:#7c3aed}
                                .role-tutor{background:#fce7f3;color:#be185d}
                                .role-admin{background:#e7fee7;color:#047857}
                                .st-act{background:#ecfdf5;color:#047857}
                                .st-pend{background:#fffbeb;color:#b45309}
                                .st-susp{background:#fff1f2;color:#be123c}
                                .st-ret{background:#f1f5f9;color:#334155}
                                .org-cham{background:#eff6ff;color:#1d4ed8}
                                .org-edu{background:#eef2ff;color:#4f46e5}
                            </style>

                            <!-- Fila 1 -->
                            <tr class="hover:bg-slate-50/60">
                                <td class="px-4 py-2"><input type="checkbox" class="h-4 w-4"></td>
                                <td class="px-4 py-2 font-medium">mlopez</td>
                                <td class="px-4 py-2">María López</td>
                                <td class="px-4 py-2">maria.lopez@ugel03.edu.pe</td>
                                <td class="px-4 py-2"><span class="tag role-alumno"><i data-lucide="graduation-cap" class="h-3.5 w-3.5"></i>Alumno</span></td>
                                <td class="px-4 py-2"><span class="tag st-act"><i data-lucide="check-circle-2" class="h-3.5 w-3.5"></i>Activo</span></td>
                                <td class="px-4 py-2"><span class="tag org-edu"><i data-lucide="school" class="h-3.5 w-3.5"></i>Edutalentos</span></td>
                                <td class="px-4 py-2">UGEL 03</td>
                                <td class="px-4 py-2">2025-03-24 11:12</td>
                                <td class="px-4 py-2 text-right"><button class="p-1 rounded hover:bg-slate-100" title="Ver"><i data-lucide="eye" class="h-4 w-4 text-slate-500"></i></button></td>
                            </tr>

                            <!-- Fila 2 -->
                            <tr class="hover:bg-slate-50/60">
                                <td class="px-4 py-2"><input type="checkbox"></td>
                                <td class="px-4 py-2 font-medium">lvega</td>
                                <td class="px-4 py-2">Luis Vega</td>
                                <td class="px-4 py-2">luis.vega@dre-lima.gob.pe</td>
                                <td class="px-4 py-2"><span class="tag role-prof"><i data-lucide="notebook-pen" class="h-3.5 w-3.5"></i>Profesor</span></td>
                                <td class="px-4 py-2"><span class="tag st-pend"><i data-lucide="clock-3" class="h-3.5 w-3.5"></i>Pendiente</span></td>
                                <td class="px-4 py-2"><span class="tag org-cham"><i data-lucide="library" class="h-3.5 w-3.5"></i>Chamilo</span></td>
                                <td class="px-4 py-2">DRE Lima</td>
                                <td class="px-4 py-2">2025-03-20 09:01</td>
                                <td class="px-4 py-2 text-right"><button class="p-1 rounded hover:bg-slate-100" title="Ver"><i data-lucide="eye" class="h-4 w-4 text-slate-500"></i></button></td>
                            </tr>

                            <!-- Fila 3 -->
                            <tr class="hover:bg-slate-50/60">
                                <td class="px-4 py-2"><input type="checkbox"></td>
                                <td class="px-4 py-2 font-medium">crios</td>
                                <td class="px-4 py-2">Carla Ríos</td>
                                <td class="px-4 py-2">c.rios@ugel-chiclayo.edu.pe</td>
                                <td class="px-4 py-2"><span class="tag role-tutor"><i data-lucide="user-round-cog" class="h-3.5 w-3.5"></i>Tutor</span></td>
                                <td class="px-4 py-2"><span class="tag st-susp"><i data-lucide="slash" class="h-3.5 w-3.5"></i>Suspenso</span></td>
                                <td class="px-4 py-2"><span class="tag org-edu"><i data-lucide="school" class="h-3.5 w-3.5"></i>Edutalentos</span></td>
                                <td class="px-4 py-2">UGEL Chiclayo</td>
                                <td class="px-4 py-2">2025-02-28 18:47</td>
                                <td class="px-4 py-2 text-right"><button class="p-1 rounded hover:bg-slate-100"><i data-lucide="eye" class="h-4 w-4 text-slate-500"></i></button></td>
                            </tr>

                            <!-- Fila 4 -->
                            <tr class="hover:bg-slate-50/60">
                                <td class="px-4 py-2"><input type="checkbox"></td>
                                <td class="px-4 py-2 font-medium">rvaldez</td>
                                <td class="px-4 py-2">Rosa Valdez</td>
                                <td class="px-4 py-2">rosa.valdez@drepiura.gob.pe</td>
                                <td class="px-4 py-2"><span class="tag role-alumno"><i data-lucide="graduation-cap" class="h-3.5 w-3.5"></i>Alumno</span></td>
                                <td class="px-4 py-2"><span class="tag st-act"><i data-lucide="check-circle-2" class="h-3.5 w-3.5"></i>Activo</span></td>
                                <td class="px-4 py-2"><span class="tag org-cham"><i data-lucide="library" class="h-3.5 w-3.5"></i>Chamilo</span></td>
                                <td class="px-4 py-2">DRE Piura</td>
                                <td class="px-4 py-2">2025-03-18 14:10</td>
                                <td class="px-4 py-2 text-right"><button class="p-1 rounded hover:bg-slate-100"><i data-lucide="eye" class="h-4 w-4 text-slate-500"></i></button></td>
                            </tr>

                            <!-- Fila 5 -->
                            <tr class="hover:bg-slate-50/60">
                                <td class="px-4 py-2"><input type="checkbox"></td>
                                <td class="px-4 py-2 font-medium">jramirez</td>
                                <td class="px-4 py-2">José Ramírez</td>
                                <td class="px-4 py-2">jose.ramirez@ugel04.edu.pe</td>
                                <td class="px-4 py-2"><span class="tag role-prof"><i data-lucide="notebook-pen" class="h-3.5 w-3.5"></i>Profesor</span></td>
                                <td class="px-4 py-2"><span class="tag st-act"><i data-lucide="check-circle-2" class="h-3.5 w-3.5"></i>Activo</span></td>
                                <td class="px-4 py-2"><span class="tag org-edu"><i data-lucide="school" class="h-3.5 w-3.5"></i>Edutalentos</span></td>
                                <td class="px-4 py-2">UGEL 04</td>
                                <td class="px-4 py-2">2025-03-22 16:31</td>
                                <td class="px-4 py-2 text-right"><button class="p-1 rounded hover:bg-slate-100"><i data-lucide="eye" class="h-4 w-4 text-slate-500"></i></button></td>
                            </tr>

                            <!-- Fila 6 -->
                            <tr class="hover:bg-slate-50/60">
                                <td class="px-4 py-2"><input type="checkbox"></td>
                                <td class="px-4 py-2 font-medium">lhuaman</td>
                                <td class="px-4 py-2">Lucía Huamán</td>
                                <td class="px-4 py-2">lucia.huaman@dre-cusco.gob.pe</td>
                                <td class="px-4 py-2"><span class="tag role-admin"><i data-lucide="shield-check" class="h-3.5 w-3.5"></i>Administrador</span></td>
                                <td class="px-4 py-2"><span class="tag st-act"><i data-lucide="check-circle-2" class="h-3.5 w-3.5"></i>Activo</span></td>
                                <td class="px-4 py-2"><span class="tag org-cham"><i data-lucide="library" class="h-3.5 w-3.5"></i>Chamilo</span></td>
                                <td class="px-4 py-2">DRE Cusco</td>
                                <td class="px-4 py-2">2025-03-25 08:05</td>
                                <td class="px-4 py-2 text-right"><button class="p-1 rounded hover:bg-slate-100"><i data-lucide="eye" class="h-4 w-4 text-slate-500"></i></button></td>
                            </tr>

                            <!-- Fila 7 -->
                            <tr class="hover:bg-slate-50/60">
                                <td class="px-4 py-2"><input type="checkbox"></td>
                                <td class="px-4 py-2 font-medium">pcondori</td>
                                <td class="px-4 py-2">Pedro Condori</td>
                                <td class="px-4 py-2">pcondori@ugel-arequipa.gob.pe</td>
                                <td class="px-4 py-2"><span class="tag role-tutor"><i data-lucide="user-round-cog" class="h-3.5 w-3.5"></i>Tutor</span></td>
                                <td class="px-4 py-2"><span class="tag st-pend"><i data-lucide="clock-3" class="h-3.5 w-3.5"></i>Pendiente</span></td>
                                <td class="px-4 py-2"><span class="tag org-edu"><i data-lucide="school" class="h-3.5 w-3.5"></i>Edutalentos</span></td>
                                <td class="px-4 py-2">UGEL Arequipa</td>
                                <td class="px-4 py-2">2025-03-19 19:12</td>
                                <td class="px-4 py-2 text-right"><button class="p-1 rounded hover:bg-slate-100"><i data-lucide="eye" class="h-4 w-4 text-slate-500"></i></button></td>
                            </tr>

                            <!-- Fila 8 -->
                            <tr class="hover:bg-slate-50/60">
                                <td class="px-4 py-2"><input type="checkbox"></td>
                                <td class="px-4 py-2 font-medium">eflores</td>
                                <td class="px-4 py-2">Elena Flores</td>
                                <td class="px-4 py-2">elena.flores@dre-loreto.gob.pe</td>
                                <td class="px-4 py-2"><span class="tag role-alumno"><i data-lucide="graduation-cap" class="h-3.5 w-3.5"></i>Alumno</span></td>
                                <td class="px-4 py-2"><span class="tag st-ret"><i data-lucide="archive" class="h-3.5 w-3.5"></i>Retirado</span></td>
                                <td class="px-4 py-2"><span class="tag org-cham"><i data-lucide="library" class="h-3.5 w-3.5"></i>Chamilo</span></td>
                                <td class="px-4 py-2">DRE Loreto</td>
                                <td class="px-4 py-2">2025-01-28 08:25</td>
                                <td class="px-4 py-2 text-right"><button class="p-1 rounded hover:bg-slate-100"><i data-lucide="eye" class="h-4 w-4 text-slate-500"></i></button></td>
                            </tr>

                            <!-- Fila 9 -->
                            <tr class="hover:bg-slate-50/60">
                                <td class="px-4 py-2"><input type="checkbox"></td>
                                <td class="px-4 py-2 font-medium">gquispe</td>
                                <td class="px-4 py-2">Gabriel Quispe</td>
                                <td class="px-4 py-2">gabriel.quispe@ugel07.edu.pe</td>
                                <td class="px-4 py-2"><span class="tag role-alumno"><i data-lucide="graduation-cap" class="h-3.5 w-3.5"></i>Alumno</span></td>
                                <td class="px-4 py-2"><span class="tag st-act"><i data-lucide="check-circle-2" class="h-3.5 w-3.5"></i>Activo</span></td>
                                <td class="px-4 py-2"><span class="tag org-edu"><i data-lucide="school" class="h-3.5 w-3.5"></i>Edutalentos</span></td>
                                <td class="px-4 py-2">UGEL 07</td>
                                <td class="px-4 py-2">2025-03-26 10:44</td>
                                <td class="px-4 py-2 text-right"><button class="p-1 rounded hover:bg-slate-100"><i data-lucide="eye" class="h-4 w-4 text-slate-500"></i></button></td>
                            </tr>

                            <!-- Fila 10 -->
                            <tr class="hover:bg-slate-50/60">
                                <td class="px-4 py-2"><input type="checkbox"></td>
                                <td class="px-4 py-2 font-medium">ymamani</td>
                                <td class="px-4 py-2">Yolanda Mamani</td>
                                <td class="px-4 py-2">ymamani@ugel-puno.edu.pe</td>
                                <td class="px-4 py-2"><span class="tag role-prof"><i data-lucide="notebook-pen" class="h-3.5 w-3.5"></i>Profesor</span></td>
                                <td class="px-4 py-2"><span class="tag st-act"><i data-lucide="check-circle-2" class="h-3.5 w-3.5"></i>Activo</span></td>
                                <td class="px-4 py-2"><span class="tag org-cham"><i data-lucide="library" class="h-3.5 w-3.5"></i>Chamilo</span></td>
                                <td class="px-4 py-2">UGEL Puno</td>
                                <td class="px-4 py-2">2025-03-25 18:21</td>
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
                        <div class="text-xs text-slate-600">50 por página</div>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection
