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
                        <span class="text-slate-700 font-medium">Accesos de usuarios</span>
                    </div>
                    <h1 class="mt-2 text-base sm:text-lg font-semibold text-slate-800 truncate">Accesos de usuarios</h1>
                </div>
                <div class="flex items-center gap-2">
                    <button class="inline-flex items-center gap-2 rounded-lg bg-slate-900 text-white px-3 py-2 text-sm hover:bg-slate-800 focus:outline-none focus:ring-4 focus:ring-slate-300">
                        <i data-lucide="file-spreadsheet" class="h-4 w-4"></i> Descargar Excel
                    </button>
                </div>
            </div>

            <!-- Contenido -->
            <div class="p-4 sm:p-6">
                <!-- Filtros (con acciones a la derecha en la MISMA fila) -->
                <div class="mb-3">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-3 items-end">
                        <!-- Desde -->
                        <div>
                            <label class="mb-1 block text-[11px] font-medium text-slate-600">Desde</label>
                            <div class="relative">
                                <input type="text" placeholder="YYYY-MM-DD"
                                       class="h-9 w-full rounded-md border border-slate-200 ps-9 pe-3 text-sm placeholder-slate-400 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100">
                                <i data-lucide="calendar" class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                            </div>
                        </div>
                        <!-- Hasta -->
                        <div>
                            <label class="mb-1 block text-[11px] font-medium text-slate-600">Hasta</label>
                            <div class="relative">
                                <input type="text" placeholder="YYYY-MM-DD"
                                       class="h-9 w-full rounded-md border border-slate-200 ps-9 pe-3 text-sm placeholder-slate-400 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100">
                                <i data-lucide="calendar" class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                            </div>
                        </div>
                        <!-- Usuario/correo -->
                        <div>
                            <label class="mb-1 block text-[11px] font-medium text-slate-600">Usuario / Correo</label>
                            <div class="relative">
                                <input type="search" placeholder="usuario o correo..."
                                       class="h-9 w-full rounded-md border border-slate-200 ps-9 pe-10 text-sm placeholder-slate-400 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100">
                                <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                                <button type="button" class="absolute right-2 top-1/2 -translate-y-1/2 p-1 rounded hover:bg-slate-100">
                                    <i data-lucide="x" class="h-4 w-4 text-slate-400"></i>
                                </button>
                            </div>
                        </div>
                        <!-- Resultado -->
                        <div>
                            <label class="mb-1 block text-[11px] font-medium text-slate-600">Resultado</label>
                            <div class="relative">
                                <select class="h-9 w-full appearance-none rounded-md border border-slate-200 px-3 pr-8 text-sm text-slate-700 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100">
                                    <option>Todos</option>
                                    <option>Exitoso</option>
                                    <option>Fallido</option>
                                    <option>Bloqueado</option>
                                </select>
                                <i data-lucide="chevron-down" class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                            </div>
                        </div>
                        <!-- Fuente de autenticación -->
                        <div>
                            <label class="mb-1 block text-[11px] font-medium text-slate-600">Autenticación</label>
                            <div class="relative">
                                <select class="h-9 w-full appearance-none rounded-md border border-slate-200 px-3 pr-8 text-sm text-slate-700 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100">
                                    <option>Todos</option>
                                    <option>Local</option>
                                    <option>LDAP</option>
                                    <option>SSO</option>
                                </select>
                                <i data-lucide="chevron-down" class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                            </div>
                        </div>

                        <!-- Acciones (misma fila, a la derecha) -->
                        <div class="flex items-end justify-end gap-2 lg:col-span-1">
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
                        <table class="min-w-[1100px] w-full text-sm">
                            <thead class="bg-slate-50 text-slate-600">
                            <tr>
                                <th class="text-left font-medium px-4 py-2">Fecha / Hora</th>
                                <th class="text-left font-medium px-4 py-2">Usuario</th>
                                <th class="text-left font-medium px-4 py-2">Correo</th>
                                <th class="text-left font-medium px-4 py-2">IP</th>
                                <th class="text-left font-medium px-4 py-2">Navegador (UA)</th>
                                <th class="text-left font-medium px-4 py-2">Autenticación</th>
                                <th class="text-left font-medium px-4 py-2">Resultado</th>
                                <th class="text-left font-medium px-4 py-2">Detalle</th>
                                <th class="text-left font-medium px-4 py-2"></th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                            <!-- helpers tags -->
                            <style>
                                .tag{display:inline-flex;align-items:center;gap:.375rem;padding:.125rem .5rem;border-radius:9999px;font-size:12px;font-weight:500}
                                .res-ok{background:#ecfdf5;color:#047857}
                                .res-fail{background:#fff1f2;color:#be123c}
                                .res-block{background:#ffe4e6;color:#9f1239}
                                .auth-local{background:#f1f5f9;color:#334155}
                                .auth-ldap{background:#e6f0ff;color:#1d4ed8}
                                .auth-sso{background:#e0f2fe;color:#0369a1}
                            </style>

                            <!-- Exitoso -->
                            <tr class="hover:bg-slate-50/60">
                                <td class="px-4 py-2">2025-03-26 10:44</td>
                                <td class="px-4 py-2 font-medium text-slate-800">gquispe</td>
                                <td class="px-4 py-2">gabriel.quispe@ugel07.edu.pe</td>
                                <td class="px-4 py-2 font-mono">190.43.12.88</td>
                                <td class="px-4 py-2 truncate" title="Windows 11; Chrome/122.0">Windows 11; Chrome/122.0</td>
                                <td class="px-4 py-2"><span class="tag auth-local"><i data-lucide="badge-check" class="h-3.5 w-3.5"></i>Local</span></td>
                                <td class="px-4 py-2"><span class="tag res-ok"><i data-lucide="check-circle-2" class="h-3.5 w-3.5"></i>Exitoso</span></td>
                                <td class="px-4 py-2">Inicio de sesión correcto</td>
                                <td class="px-4 py-2 text-right">
                                    <button class="p-1 rounded hover:bg-slate-100" title="Ver detalle"><i data-lucide="eye" class="h-4 w-4 text-slate-500"></i></button>
                                </td>
                            </tr>

                            <!-- Fallido (contraseña) -->
                            <tr class="hover:bg-slate-50/60">
                                <td class="px-4 py-2">2025-03-24 10:57</td>
                                <td class="px-4 py-2 font-medium text-slate-800">mlopez</td>
                                <td class="px-4 py-2">maria.lopez@ugel03.edu.pe</td>
                                <td class="px-4 py-2 font-mono">152.67.120.201</td>
                                <td class="px-4 py-2 truncate" title="macOS; Chrome/121.0">macOS; Chrome/121.0</td>
                                <td class="px-4 py-2"><span class="tag auth-local">Local</span></td>
                                <td class="px-4 py-2"><span class="tag res-fail"><i data-lucide="alert-octagon" class="h-3.5 w-3.5"></i>Fallido</span></td>
                                <td class="px-4 py-2">Contraseña incorrecta</td>
                                <td class="px-4 py-2 text-right">
                                    <button class="p-1 rounded hover:bg-slate-100" title="Ver detalle"><i data-lucide="eye" class="h-4 w-4 text-slate-500"></i></button>
                                </td>
                            </tr>

                            <!-- SSO exitoso -->
                            <tr class="hover:bg-slate-50/60">
                                <td class="px-4 py-2">2025-03-22 16:31</td>
                                <td class="px-4 py-2 font-medium text-slate-800">jramirez</td>
                                <td class="px-4 py-2">jose.ramirez@ugel04.edu.pe</td>
                                <td class="px-4 py-2 font-mono">45.7.14.33</td>
                                <td class="px-4 py-2 truncate" title="Windows 10; Edge/121.0">Windows 10; Edge/121.0</td>
                                <td class="px-4 py-2"><span class="tag auth-sso"><i data-lucide="key-round" class="h-3.5 w-3.5"></i>SSO</span></td>
                                <td class="px-4 py-2"><span class="tag res-ok">Exitoso</span></td>
                                <td class="px-4 py-2">Autenticación federada correcta</td>
                                <td class="px-4 py-2 text-right">
                                    <button class="p-1 rounded hover:bg-slate-100" title="Ver detalle"><i data-lucide="eye" class="h-4 w-4 text-slate-500"></i></button>
                                </td>
                            </tr>

                            <!-- Bloqueado (política / múltiples intentos) -->
                            <tr class="hover:bg-slate-50/60">
                                <td class="px-4 py-2">2025-03-20 09:01</td>
                                <td class="px-4 py-2 font-medium text-slate-800">lvega</td>
                                <td class="px-4 py-2">luis.vega@dre-lima.gob.pe</td>
                                <td class="px-4 py-2 font-mono">191.98.12.77</td>
                                <td class="px-4 py-2 truncate" title="Ubuntu; Firefox/124.0">Ubuntu; Firefox/124.0</td>
                                <td class="px-4 py-2"><span class="tag auth-local">Local</span></td>
                                <td class="px-4 py-2"><span class="tag res-block"><i data-lucide="ban" class="h-3.5 w-3.5"></i>Bloqueado</span></td>
                                <td class="px-4 py-2">Cuenta bloqueada por intentos fallidos</td>
                                <td class="px-4 py-2 text-right">
                                    <button class="p-1 rounded hover:bg-slate-100" title="Ver detalle"><i data-lucide="eye" class="h-4 w-4 text-slate-500"></i></button>
                                </td>
                            </tr>

                            <!-- LDAP fallido -->
                            <tr class="hover:bg-slate-50/60">
                                <td class="px-4 py-2">2025-03-18 14:10</td>
                                <td class="px-4 py-2 font-medium text-slate-800">rvaldez</td>
                                <td class="px-4 py-2">rosa.valdez@drepiura.gob.pe</td>
                                <td class="px-4 py-2 font-mono">179.6.77.2</td>
                                <td class="px-4 py-2 truncate" title="Android; Chrome/120.0">Android; Chrome/120.0</td>
                                <td class="px-4 py-2"><span class="tag auth-ldap"><i data-lucide="server" class="h-3.5 w-3.5"></i>LDAP</span></td>
                                <td class="px-4 py-2"><span class="tag res-fail">Fallido</span></td>
                                <td class="px-4 py-2">Usuario no encontrado en directorio</td>
                                <td class="px-4 py-2 text-right">
                                    <button class="p-1 rounded hover:bg-slate-100" title="Ver detalle"><i data-lucide="eye" class="h-4 w-4 text-slate-500"></i></button>
                                </td>
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
                            <span class="text-xs text-slate-600">1 / 8</span>
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

    <script> lucide.createIcons(); </script>

@endsection
