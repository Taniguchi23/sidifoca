@extends('layout.app')
@section('content')
    <section class="min-w-0 flex-1">
        <div class="bg-white border border-slate-200 rounded-2xl">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between px-4 sm:px-6 py-4 border-b border-slate-100">
                <div class="min-w-0">
                    <div class="flex items-center gap-2 text-slate-500 text-xs sm:text-sm">
                        <a class="hover:text-slate-700" href="#">Mi perfil</a><span>›</span>
                        <span class="text-slate-700 font-medium">Mis certificados</span>
                    </div>
                    <h1 class="mt-2 text-base sm:text-lg font-semibold text-slate-800 truncate">Mis certificados</h1>
                </div>
                <div class="flex items-center gap-2">
                    <button class="inline-flex items-center gap-2 rounded-lg bg-slate-900 text-white px-3 py-2 text-sm hover:bg-slate-800 focus:outline-none focus:ring-4 focus:ring-slate-300">
                        <i data-lucide="file-spreadsheet" class="h-4 w-4"></i> Descargar Excel
                    </button>
                    <button class="inline-flex items-center gap-2 rounded-lg border border-slate-200 px-3 py-2 text-sm hover:bg-slate-50">
                        <i data-lucide="folder-down" class="h-4 w-4"></i> Descargar todo (ZIP)
                    </button>
                </div>
            </div>

            <!-- Contenido -->
            <div class="p-4 sm:p-6">

                <!-- Filtros -->
                <div class="mb-3">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-3">
                        <!-- Buscar -->
                        <div class="lg:col-span-2">
                            <label class="mb-1 block text-[11px] font-medium text-slate-600">Buscar</label>
                            <div class="relative">
                                <input type="search" placeholder="Curso, código o emisor..."
                                       class="h-9 w-full rounded-md border border-slate-200 ps-9 pe-10 text-sm placeholder-slate-400 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100">
                                <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                                <button type="button" class="absolute right-2 top-1/2 -translate-y-1/2 p-1 rounded hover:bg-slate-100">
                                    <i data-lucide="x" class="h-4 w-4 text-slate-400"></i>
                                </button>
                            </div>
                        </div>
                        <!-- Estado -->
                        <div>
                            <label class="mb-1 block text-[11px] font-medium text-slate-600">Estado</label>
                            <div class="relative">
                                <select class="h-9 w-full appearance-none rounded-md border border-slate-200 px-3 pr-8 text-sm text-slate-700 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100">
                                    <option>Todos</option>
                                    <option>Vigente</option>
                                    <option>Expirado</option>
                                    <option>Pendiente</option>
                                </select>
                                <i data-lucide="chevron-down" class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                            </div>
                        </div>
                        <!-- Año -->
                        <div>
                            <label class="mb-1 block text-[11px] font-medium text-slate-600">Año</label>
                            <div class="relative">
                                <select class="h-9 w-full appearance-none rounded-md border border-slate-200 px-3 pr-8 text-sm text-slate-700 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100">
                                    <option>Todos</option>
                                    <option>2025</option>
                                    <option>2024</option>
                                    <option>2023</option>
                                </select>
                                <i data-lucide="chevron-down" class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                            </div>
                        </div>
                        <!-- Emisor -->
                        <div>
                            <label class="mb-1 block text-[11px] font-medium text-slate-600">Emisor</label>
                            <div class="relative">
                                <select class="h-9 w-full appearance-none rounded-md border border-slate-200 px-3 pr-8 text-sm text-slate-700 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100">
                                    <option>Todos</option>
                                    <option>Edutalentos</option>
                                    <option>Chamilo</option>
                                    <option>DRE Lima Metropolitana</option>
                                    <option>UGEL 03</option>
                                    <option>UGEL Chiclayo</option>
                                </select>
                                <i data-lucide="chevron-down" class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                            </div>
                        </div>
                        <!-- Ordenar -->
                        <div>
                            <label class="mb-1 block text-[11px] font-medium text-slate-600">Ordenar por</label>
                            <div class="relative">
                                <select class="h-9 w-full appearance-none rounded-md border border-slate-200 px-3 pr-8 text-sm text-slate-700 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100">
                                    <option>Fecha emisión (reciente)</option>
                                    <option>Fecha emisión (antiguo)</option>
                                    <option>Curso (A–Z)</option>
                                    <option>Emisor (A–Z)</option>
                                </select>
                                <i data-lucide="chevron-down" class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Buscar / Limpiar -->
                    <div class="mt-3 flex flex-wrap items-end justify-end gap-2">
                        <button class="inline-flex h-9 items-center gap-2 rounded-md bg-slate-900 px-3 text-sm text-white hover:bg-slate-800 focus:outline-none focus:ring-4 focus:ring-slate-300">
                            <i data-lucide="search" class="h-4 w-4"></i> Buscar
                        </button>
                        <button class="inline-flex h-9 items-center gap-2 rounded-md border border-slate-200 px-3 text-sm hover:bg-slate-50">
                            <i data-lucide="eraser" class="h-4 w-4"></i> Limpiar
                        </button>
                    </div>
                </div>

                <!-- Tabla -->
                <div class="overflow-hidden rounded-2xl border border-slate-200">
                    <div class="overflow-x-auto">
                        <table class="min-w-[1100px] w-full text-sm">
                            <thead class="bg-slate-50 text-slate-600">
                            <tr>
                                <th class="text-left font-medium px-4 py-2">Certificado</th>
                                <th class="text-left font-medium px-4 py-2">Curso</th>
                                <th class="text-left font-medium px-4 py-2">Emisor</th>
                                <th class="text-left font-medium px-4 py-2">Estado</th>
                                <th class="text-left font-medium px-4 py-2">Fecha emisión</th>
                                <th class="text-left font-medium px-4 py-2">Vigencia</th>
                                <th class="text-left font-medium px-4 py-2">Código</th>
                                <th class="text-left font-medium px-4 py-2"></th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">

                            <!-- helpers (tags) -->
                            <style>
                                .tag{display:inline-flex;align-items:center;gap:.375rem;padding:.125rem .5rem;border-radius:9999px;font-size:12px;font-weight:500}
                                .t-diploma{background:#eef2ff;color:#4f46e5}
                                .t-const{background:#e0f2fe;color:#0369a1}
                                .st-vig{background:#ecfdf5;color:#047857}
                                .st-exp{background:#fff1f2;color:#be123c}
                                .st-pen{background:#fffbeb;color:#b45309}
                            </style>

                            <!-- Row 1 -->
                            <tr class="hover:bg-slate-50/60">
                                <td class="px-4 py-2">
                                    <div class="flex items-center gap-2">
                                        <i data-lucide="award" class="h-4 w-4 text-indigo-600"></i>
                                        <div>
                                            <div class="font-medium text-slate-800">Diploma</div>
                                            <div class="text-xs text-slate-500">Evaluación Formativa</div>
                                        </div>
                                        <span class="tag t-diploma ms-auto">Diploma</span>
                                    </div>
                                </td>
                                <td class="px-4 py-2">Evaluación Formativa</td>
                                <td class="px-4 py-2">Edutalentos</td>
                                <td class="px-4 py-2"><span class="tag st-vig"><i data-lucide="check-circle-2" class="h-3.5 w-3.5"></i>Vigente</span></td>
                                <td class="px-4 py-2">2025-03-28</td>
                                <td class="px-4 py-2">Hasta 2027-03-28</td>
                                <td class="px-4 py-2 font-mono">ET-2025-000184</td>
                                <td class="px-4 py-2 text-right">
                                    <div class="flex items-center justify-end gap-1">
                                        <button class="p-1 rounded hover:bg-slate-100" title="Descargar PDF"><i data-lucide="file-down" class="h-4 w-4"></i></button>
                                        <button class="p-1 rounded hover:bg-slate-100" title="Compartir enlace"><i data-lucide="link-2" class="h-4 w-4"></i></button>
                                        <button class="p-1 rounded hover:bg-slate-100" title="Verificar" data-open-verify data-code="ET-2025-000184"><i data-lucide="qr-code" class="h-4 w-4"></i></button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Row 2 -->
                            <tr class="hover:bg-slate-50/60">
                                <td class="px-4 py-2">
                                    <div class="flex items-center gap-2">
                                        <i data-lucide="file-badge-2" class="h-4 w-4 text-sky-700"></i>
                                        <div>
                                            <div class="font-medium text-slate-800">Constancia</div>
                                            <div class="text-xs text-slate-500">Gestión de Aula Inclusiva</div>
                                        </div>
                                        <span class="tag t-const ms-auto">Constancia</span>
                                    </div>
                                </td>
                                <td class="px-4 py-2">Gestión de Aula Inclusiva</td>
                                <td class="px-4 py-2">UGEL 03</td>
                                <td class="px-4 py-2"><span class="tag st-vig"><i data-lucide="check-circle-2" class="h-3.5 w-3.5"></i>Vigente</span></td>
                                <td class="px-4 py-2">2024-12-15</td>
                                <td class="px-4 py-2">Hasta 2026-12-15</td>
                                <td class="px-4 py-2 font-mono">UG-2024-10392</td>
                                <td class="px-4 py-2 text-right">
                                    <div class="flex items-center justify-end gap-1">
                                        <button class="p-1 rounded hover:bg-slate-100" title="Descargar PDF"><i data-lucide="file-down" class="h-4 w-4"></i></button>
                                        <button class="p-1 rounded hover:bg-slate-100" title="Compartir enlace"><i data-lucide="link-2" class="h-4 w-4"></i></button>
                                        <button class="p-1 rounded hover:bg-slate-100" title="Verificar" data-open-verify data-code="UG-2024-10392"><i data-lucide="qr-code" class="h-4 w-4"></i></button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Row 3 -->
                            <tr class="hover:bg-slate-50/60">
                                <td class="px-4 py-2">
                                    <div class="flex items-center gap-2">
                                        <i data-lucide="file-badge-2" class="h-4 w-4 text-sky-700"></i>
                                        <div>
                                            <div class="font-medium text-slate-800">Constancia</div>
                                            <div class="text-xs text-slate-500">Competencias Digitales Docentes (Intermedio)</div>
                                        </div>
                                        <span class="tag t-const ms-auto">Constancia</span>
                                    </div>
                                </td>
                                <td class="px-4 py-2">Competencias Digitales Docentes</td>
                                <td class="px-4 py-2">Chamilo</td>
                                <td class="px-4 py-2"><span class="tag st-exp"><i data-lucide="alert-octagon" class="h-3.5 w-3.5"></i>Expirado</span></td>
                                <td class="px-4 py-2">2023-08-05</td>
                                <td class="px-4 py-2">Hasta 2024-08-05</td>
                                <td class="px-4 py-2 font-mono">CH-2023-55012</td>
                                <td class="px-4 py-2 text-right">
                                    <div class="flex items-center justify-end gap-1">
                                        <button class="p-1 rounded hover:bg-slate-100" title="Descargar PDF"><i data-lucide="file-down" class="h-4 w-4"></i></button>
                                        <button class="p-1 rounded hover:bg-slate-100" title="Verificar" data-open-verify data-code="CH-2023-55012"><i data-lucide="qr-code" class="h-4 w-4"></i></button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Row 4 -->
                            <tr class="hover:bg-slate-50/60">
                                <td class="px-4 py-2">
                                    <div class="flex items-center gap-2">
                                        <i data-lucide="award" class="h-4 w-4 text-indigo-600"></i>
                                        <div>
                                            <div class="font-medium text-slate-800">Diploma</div>
                                            <div class="text-xs text-slate-500">Alfabetización Digital Básica</div>
                                        </div>
                                        <span class="tag t-diploma ms-auto">Diploma</span>
                                    </div>
                                </td>
                                <td class="px-4 py-2">Alfabetización Digital Básica</td>
                                <td class="px-4 py-2">Edutalentos</td>
                                <td class="px-4 py-2"><span class="tag st-vig"><i data-lucide="check-circle-2" class="h-3.5 w-3.5"></i>Vigente</span></td>
                                <td class="px-4 py-2">2025-02-10</td>
                                <td class="px-4 py-2">—</td>
                                <td class="px-4 py-2 font-mono">ET-2025-000097</td>
                                <td class="px-4 py-2 text-right">
                                    <div class="flex items-center justify-end gap-1">
                                        <button class="p-1 rounded hover:bg-slate-100" title="Descargar PDF"><i data-lucide="file-down" class="h-4 w-4"></i></button>
                                        <button class="p-1 rounded hover:bg-slate-100" title="Compartir enlace"><i data-lucide="link-2" class="h-4 w-4"></i></button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Row 5 -->
                            <tr class="hover:bg-slate-50/60">
                                <td class="px-4 py-2">
                                    <div class="flex items-center gap-2">
                                        <i data-lucide="file-badge-2" class="h-4 w-4 text-sky-700"></i>
                                        <div>
                                            <div class="font-medium text-slate-800">Constancia</div>
                                            <div class="text-xs text-slate-500">Didáctica de Matemática Inicial</div>
                                        </div>
                                        <span class="tag t-const ms-auto">Constancia</span>
                                    </div>
                                </td>
                                <td class="px-4 py-2">Didáctica de Matemática Inicial</td>
                                <td class="px-4 py-2">Chamilo</td>
                                <td class="px-4 py-2"><span class="tag st-exp"><i data-lucide="alert-octagon" class="h-3.5 w-3.5"></i>Expirado</span></td>
                                <td class="px-4 py-2">2022-11-01</td>
                                <td class="px-4 py-2">Hasta 2023-11-01</td>
                                <td class="px-4 py-2 font-mono">CH-2022-22041</td>
                                <td class="px-4 py-2 text-right">
                                    <div class="flex items-center justify-end gap-1">
                                        <button class="p-1 rounded hover:bg-slate-100" title="Descargar PDF"><i data-lucide="file-down" class="h-4 w-4"></i></button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Row 6 -->
                            <tr class="hover:bg-slate-50/60">
                                <td class="px-4 py-2">
                                    <div class="flex items-center gap-2">
                                        <i data-lucide="file-badge-2" class="h-4 w-4 text-sky-700"></i>
                                        <div>
                                            <div class="font-medium text-slate-800">Constancia</div>
                                            <div class="text-xs text-slate-500">Seguridad y Protección de Datos</div>
                                        </div>
                                        <span class="tag t-const ms-auto">Constancia</span>
                                    </div>
                                </td>
                                <td class="px-4 py-2">Seguridad y Protección de Datos</td>
                                <td class="px-4 py-2">DRE Lima Metropolitana</td>
                                <td class="px-4 py-2"><span class="tag st-vig"><i data-lucide="check-circle-2" class="h-3.5 w-3.5"></i>Vigente</span></td>
                                <td class="px-4 py-2">2025-03-10</td>
                                <td class="px-4 py-2">Hasta 2026-03-10</td>
                                <td class="px-4 py-2 font-mono">DRELM-2025-00944</td>
                                <td class="px-4 py-2 text-right">
                                    <div class="flex items-center justify-end gap-1">
                                        <button class="p-1 rounded hover:bg-slate-100" title="Descargar PDF"><i data-lucide="file-down" class="h-4 w-4"></i></button>
                                        <button class="p-1 rounded hover:bg-slate-100" title="Verificar" data-open-verify data-code="DRELM-2025-00944"><i data-lucide="qr-code" class="h-4 w-4"></i></button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Row 7 -->
                            <tr class="hover:bg-slate-50/60">
                                <td class="px-4 py-2">
                                    <div class="flex items-center gap-2">
                                        <i data-lucide="award" class="h-4 w-4 text-indigo-600"></i>
                                        <div>
                                            <div class="font-medium text-slate-800">Diploma</div>
                                            <div class="text-xs text-slate-500">Evaluación por Competencias</div>
                                        </div>
                                        <span class="tag t-diploma ms-auto">Diploma</span>
                                    </div>
                                </td>
                                <td class="px-4 py-2">Evaluación por Competencias</td>
                                <td class="px-4 py-2">Edutalentos</td>
                                <td class="px-4 py-2"><span class="tag st-pen"><i data-lucide="clock-3" class="h-3.5 w-3.5"></i>Pendiente</span></td>
                                <td class="px-4 py-2">2025-03-22</td>
                                <td class="px-4 py-2">En verificación</td>
                                <td class="px-4 py-2 font-mono">ET-2025-000171</td>
                                <td class="px-4 py-2 text-right">
                                    <div class="flex items-center justify-end gap-1">
                                        <button class="p-1 rounded hover:bg-slate-100" title="Compartir enlace"><i data-lucide="link-2" class="h-4 w-4"></i></button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Row 8 -->
                            <tr class="hover:bg-slate-50/60">
                                <td class="px-4 py-2">
                                    <div class="flex items-center gap-2">
                                        <i data-lucide="file-badge-2" class="h-4 w-4 text-sky-700"></i>
                                        <div>
                                            <div class="font-medium text-slate-800">Constancia</div>
                                            <div class="text-xs text-slate-500">Tutoría y Convivencia Escolar</div>
                                        </div>
                                        <span class="tag t-const ms-auto">Constancia</span>
                                    </div>
                                </td>
                                <td class="px-4 py-2">Tutoría y Convivencia Escolar</td>
                                <td class="px-4 py-2">UGEL Chiclayo</td>
                                <td class="px-4 py-2"><span class="tag st-vig"><i data-lucide="check-circle-2" class="h-3.5 w-3.5"></i>Vigente</span></td>
                                <td class="px-4 py-2">2024-05-20</td>
                                <td class="px-4 py-2">Hasta 2026-05-20</td>
                                <td class="px-4 py-2 font-mono">UGCH-2024-44210</td>
                                <td class="px-4 py-2 text-right">
                                    <div class="flex items-center justify-end gap-1">
                                        <button class="p-1 rounded hover:bg-slate-100" title="Descargar PDF"><i data-lucide="file-down" class="h-4 w-4"></i></button>
                                        <button class="p-1 rounded hover:bg-slate-100" title="Verificar" data-open-verify data-code="UGCH-2024-44210"><i data-lucide="qr-code" class="h-4 w-4"></i></button>
                                    </div>
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
                            <span class="text-xs text-slate-600">1 / 6</span>
                            <button class="rounded-md border border-slate-200 px-2 py-1 text-sm hover:bg-slate-50" aria-label="Siguiente">
                                <i data-lucide="chevron-right" class="h-4 w-4"></i>
                            </button>
                        </div>
                        <div class="text-xs text-slate-600">20 por página</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Drawer de verificación (demo) -->
        <aside id="cert-verify" class="fixed top-0 right-0 h-full w-[420px] max-w-[92vw] translate-x-full transition-transform duration-200 bg-white border-l border-slate-200 shadow-xl z-40">
            <div class="flex items-center justify-between px-4 py-3 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <i data-lucide="qr-code" class="h-5 w-5 text-slate-600"></i>
                    <h3 class="text-sm font-semibold text-slate-800">Verificación de certificado</h3>
                </div>
                <button id="verify-close" class="p-1 rounded hover:bg-slate-100"><i data-lucide="x" class="h-5 w-5"></i></button>
            </div>
            <div class="p-4 space-y-4 text-sm">
                <div>
                    <div class="text-[11px] text-slate-500">Código</div>
                    <div id="v-code" class="font-mono text-slate-800">—</div>
                </div>
                <div>
                    <div class="text-[11px] text-slate-500">URL de verificación</div>
                    <a id="v-url" href="#" target="_blank" class="text-sky-600 hover:underline">—</a>
                </div>
                <div>
                    <div class="text-[11px] text-slate-500 mb-2">QR</div>
                    <div class="aspect-square w-40 bg-slate-100 rounded-md flex items-center justify-center text-[10px] text-slate-500">QR placeholder</div>
                </div>
                <div class="pt-3 border-t border-slate-100">
                    <button class="inline-flex items-center gap-2 rounded-md bg-slate-900 text-white px-3 py-1.5 hover:bg-slate-800">
                        <i data-lucide="external-link" class="h-4 w-4"></i> Abrir verificación
                    </button>
                </div>
            </div>
        </aside>
    </section>
@endsection
