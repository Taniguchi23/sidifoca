@extends('layout.app')
@section('content')
    <!-- Lucide (omite si ya está global) -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <section id="reporte-envios-enviados" class="min-w-0 flex-1">
        <div class="bg-white border border-slate-200 rounded-2xl">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between px-4 sm:px-6 py-4 border-b border-slate-100">
                <div class="min-w-0">
                    <div class="flex items-center gap-2 text-slate-500 text-xs sm:text-sm">
                        <a class="hover:text-slate-700" href="#">Mensajería</a><span>›</span>
                        <a class="hover:text-slate-700" href="#">Reportes</a><span>›</span>
                        <span class="text-slate-700 font-medium">Enviados</span>
                    </div>
                    <h1 class="mt-2 text-base sm:text-lg font-semibold text-slate-800 truncate">Reporte: Mensajes enviados</h1>
                </div>
                <div class="flex items-center gap-2">
                    <button id="btn-export-xlsx" class="inline-flex items-center gap-2 rounded-lg bg-slate-900 text-white px-3 py-2 text-sm hover:bg-slate-800 focus:outline-none focus:ring-4 focus:ring-slate-300">
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
                                <input id="f-desde" type="text" placeholder="YYYY-MM-DD"
                                       class="h-9 w-full rounded-md border border-slate-200 ps-9 pe-3 text-sm placeholder-slate-400 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100">
                                <i data-lucide="calendar" class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                            </div>
                        </div>
                        <!-- Hasta -->
                        <div class="lg:col-span-2">
                            <label class="mb-1 block text-[11px] font-medium text-slate-600">Hasta</label>
                            <div class="relative">
                                <input id="f-hasta" type="text" placeholder="YYYY-MM-DD"
                                       class="h-9 w-full rounded-md border border-slate-200 ps-9 pe-3 text-sm placeholder-slate-400 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100">
                                <i data-lucide="calendar" class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                            </div>
                        </div>
                        <!-- Canal -->
                        <div class="lg:col-span-2">
                            <label class="mb-1 block text-[11px] font-medium text-slate-600">Canal</label>
                            <div class="relative">
                                <select id="f-canal" class="h-9 w-full appearance-none rounded-md border border-slate-200 px-3 pr-8 text-sm text-slate-700 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100">
                                    <option value="">Todos</option>
                                    <option value="whatsapp">WhatsApp</option>
                                    <option value="sms">SMS</option>
                                    <option value="email">Correo</option>
                                </select>
                                <i data-lucide="chevron-down" class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                            </div>
                        </div>
                        <!-- Estado (solo estados de enviados) -->
                        <div class="lg:col-span-2">
                            <label class="mb-1 block text-[11px] font-medium text-slate-600">Estado</label>
                            <div class="relative">
                                <select id="f-estado" class="h-9 w-full appearance-none rounded-md border border-slate-200 px-3 pr-8 text-sm text-slate-700 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100">
                                    <option value="">Todos</option>
                                    <option>Entregado</option>
                                    <option>Leído/Apertura</option>
                                    <option>Click</option>
                                    <option>Rebotado</option>
                                    <option>Fallido</option>
                                </select>
                                <i data-lucide="chevron-down" class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                            </div>
                        </div>
                        <!-- Plantilla / Asunto -->
                        <div class="lg:col-span-2">
                            <label class="mb-1 block text-[11px] font-medium text-slate-600">Plantilla / Asunto</label>
                            <input id="f-plantilla" type="text" placeholder="Nombre de plantilla o asunto" class="h-9 w-full rounded-md border border-slate-200 px-3 text-sm">
                        </div>
                        <!-- Destinatario -->
                        <div class="lg:col-span-2">
                            <label class="mb-1 block text-[11px] font-medium text-slate-600">Destinatario</label>
                            <input id="f-dest" type="text" placeholder="correo@dominio.com / +5199..." class="h-9 w-full rounded-md border border-slate-200 px-3 text-sm">
                        </div>
                        <!-- Proveedor -->
                        <div class="lg:col-span-2">
                            <label class="mb-1 block text-[11px] font-medium text-slate-600">Proveedor</label>
                            <div class="relative">
                                <select id="f-prov" class="h-9 w-full appearance-none rounded-md border border-slate-200 px-3 pr-8 text-sm text-slate-700 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100">
                                    <option value="">Todos</option>
                                    <option>Meta</option>
                                    <option>Twilio</option>
                                    <option>SendGrid</option>
                                    <option>Mailgun</option>
                                    <option>SES</option>
                                    <option>Postmark</option>
                                </select>
                                <i data-lucide="chevron-down" class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                            </div>
                        </div>

                        <!-- Acciones filtros -->
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
                </div>

                <!-- Tabla -->
                <div class="mt-4 overflow-hidden rounded-2xl border border-slate-200">
                    <div class="overflow-x-auto">
                        <table class="min-w-[1180px] w-full text-sm">
                            <thead class="bg-slate-50 text-slate-600">
                            <tr>
                                <th class="text-left font-medium px-4 py-2">Canal</th>
                                <th class="text-left font-medium px-4 py-2">Plantilla/Asunto</th>
                                <th class="text-left font-medium px-4 py-2">Destinatario</th>
                                <th class="text-left font-medium px-4 py-2">Programado</th>
                                <th class="text-left font-medium px-4 py-2">Enviado</th>
                                <th class="text-left font-medium px-4 py-2">Estado</th>
                                <th class="text-left font-medium px-4 py-2">Resultados</th>
                                <th class="text-left font-medium px-4 py-2">Proveedor</th>
                                <th class="text-left font-medium px-4 py-2">ID mensaje</th>
                                <th class="text-left font-medium px-4 py-2">Acciones</th>
                            </tr>
                            </thead>

                            <tbody id="tbl-enviados" class="divide-y divide-slate-100">
                            <!-- WhatsApp -->
                            <tr class="hover:bg-slate-50/60">
                                <td class="px-4 py-2">
                  <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 text-emerald-700 px-2 py-0.5">
                    <i data-lucide="messages-square" class="h-3.5 w-3.5"></i> WhatsApp
                  </span>
                                </td>
                                <td class="px-4 py-2">reminder_24h</td>
                                <td class="px-4 py-2">+51 987 654 321</td>
                                <td class="px-4 py-2">2025-03-20 08:00</td>
                                <td class="px-4 py-2">2025-03-20 08:01</td>
                                <td class="px-4 py-2">
                                    <span class="inline-flex rounded-full bg-emerald-50 text-emerald-700 px-2 py-0.5">Entregado</span>
                                </td>
                                <td class="px-4 py-2 text-slate-600">Leído 09:12 · 1 clic</td>
                                <td class="px-4 py-2">Meta</td>
                                <td class="px-4 py-2 truncate" title="wamid.HBgMNT...">wamid.HBgMNT...</td>
                                <td class="px-4 py-2">
                                    <div class="flex items-center gap-1.5">
                                        <button class="p-1 rounded-md hover:bg-slate-100" title="Ver">
                                            <i data-lucide="eye" class="h-4 w-4 text-slate-600"></i>
                                        </button>
                                        <button class="p-1 rounded-md hover:bg-slate-100" title="Reenviar">
                                            <i data-lucide="send" class="h-4 w-4 text-slate-600"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- SMS -->
                            <tr class="hover:bg-slate-50/60">
                                <td class="px-4 py-2">
                  <span class="inline-flex items-center gap-1.5 rounded-full bg-sky-50 text-sky-700 px-2 py-0.5">
                    <i data-lucide="smartphone" class="h-3.5 w-3.5"></i> SMS
                  </span>
                                </td>
                                <td class="px-4 py-2">Recordatorio vencimiento</td>
                                <td class="px-4 py-2">+51 912 345 678</td>
                                <td class="px-4 py-2">2025-03-20 09:00</td>
                                <td class="px-4 py-2">2025-03-20 09:00</td>
                                <td class="px-4 py-2">
                                    <span class="inline-flex rounded-full bg-emerald-50 text-emerald-700 px-2 py-0.5">Entregado</span>
                                </td>
                                <td class="px-4 py-2 text-slate-600">0 clics · 0 respuestas</td>
                                <td class="px-4 py-2">Twilio</td>
                                <td class="px-4 py-2 truncate" title="SMxxxxxxxx...">SMxxxxxxxx...</td>
                                <td class="px-4 py-2">
                                    <div class="flex items-center gap-1.5">
                                        <button class="p-1 rounded-md hover:bg-slate-100" title="Ver">
                                            <i data-lucide="eye" class="h-4 w-4 text-slate-600"></i>
                                        </button>
                                        <button class="p-1 rounded-md hover:bg-slate-100" title="Reenviar">
                                            <i data-lucide="send" class="h-4 w-4 text-slate-600"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Correo -->
                            <tr class="hover:bg-slate-50/60">
                                <td class="px-4 py-2">
                  <span class="inline-flex items-center gap-1.5 rounded-full bg-indigo-50 text-indigo-700 px-2 py-0.5">
                    <i data-lucide="mail" class="h-3.5 w-3.5"></i> Correo
                  </span>
                                </td>
                                <td class="px-4 py-2">Asunto: “Tu actividad vence mañana”</td>
                                <td class="px-4 py-2">maria.lopez@example.edu</td>
                                <td class="px-4 py-2">2025-03-20 10:00</td>
                                <td class="px-4 py-2">2025-03-20 10:01</td>
                                <td class="px-4 py-2">
                                    <span class="inline-flex rounded-full bg-violet-50 text-violet-700 px-2 py-0.5">Apertura</span>
                                </td>
                                <td class="px-4 py-2 text-slate-600">Abrió 10:12 · 2 clics</td>
                                <td class="px-4 py-2">SendGrid</td>
                                <td class="px-4 py-2 truncate" title="SG_msg_8a...">SG_msg_8a...</td>
                                <td class="px-4 py-2">
                                    <div class="flex items-center gap-1.5">
                                        <button class="p-1 rounded-md hover:bg-slate-100" title="Ver">
                                            <i data-lucide="eye" class="h-4 w-4 text-slate-600"></i>
                                        </button>
                                        <button class="p-1 rounded-md hover:bg-slate-100" title="Reenviar">
                                            <i data-lucide="send" class="h-4 w-4 text-slate-600"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Correo - Rebotado -->
                            <tr class="hover:bg-slate-50/60">
                                <td class="px-4 py-2">
                  <span class="inline-flex items-center gap-1.5 rounded-full bg-indigo-50 text-indigo-700 px-2 py-0.5">
                    <i data-lucide="mail" class="h-3.5 w-3.5"></i> Correo
                  </span>
                                </td>
                                <td class="px-4 py-2">Asunto: “Recordatorio”</td>
                                <td class="px-4 py-2">luis.vega@example.edu</td>
                                <td class="px-4 py-2">2025-03-19 07:30</td>
                                <td class="px-4 py-2">2025-03-19 07:30</td>
                                <td class="px-4 py-2">
                                    <span class="inline-flex rounded-full bg-rose-50 text-rose-700 px-2 py-0.5">Rebotado</span>
                                </td>
                                <td class="px-4 py-2 text-slate-600">Mailbox full (5.2.2)</td>
                                <td class="px-4 py-2">Mailgun</td>
                                <td class="px-4 py-2 truncate" title="mg:2025_...">mg:2025_...</td>
                                <td class="px-4 py-2">
                                    <div class="flex items-center gap-1.5">
                                        <button class="p-1 rounded-md hover:bg-slate-100" title="Ver">
                                            <i data-lucide="eye" class="h-4 w-4 text-slate-600"></i>
                                        </button>
                                        <button class="p-1 rounded-md hover:bg-slate-100" title="Reenviar">
                                            <i data-lucide="send" class="h-4 w-4 text-slate-600"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>

                    <!-- Footer tabla -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 px-3 py-2 bg-white border-t border-slate-100">
                        <div class="text-xs text-slate-600"><span id="res-count">4</span> enviados</div>
                        <div class="flex items-center gap-2">
                            <button class="rounded-md border border-slate-200 px-2 py-1 text-sm hover:bg-slate-50" aria-label="Anterior">
                                <i data-lucide="chevron-left" class="h-4 w-4"></i>
                            </button>
                            <span class="text-xs text-slate-600">1 / 8</span>
                            <button class="rounded-md border border-slate-200 px-2 py-1 text-sm hover:bg-slate-50" aria-label="Siguiente">
                                <i data-lucide="chevron-right" class="h-4 w-4"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div> <!-- /p-6 -->
        </div>
    </section>

    <script>try{lucide.createIcons()}catch(e){}</script>

@endsection
