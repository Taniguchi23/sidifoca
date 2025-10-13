@extends('layout.app')
@section('content')

    <section id="dash-mensajeria" class="min-w-0 flex-1">
        <div class="bg-white border border-slate-200 rounded-2xl">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between px-4 sm:px-6 py-4 border-b border-slate-100">
                <div class="min-w-0">
                    <div class="flex items-center gap-2 text-slate-500 text-xs sm:text-sm">
                        <a class="hover:text-slate-700" href="#">Mensajería</a><span>›</span>
                        <span class="text-slate-700 font-medium">Dashboard</span>
                    </div>
                    <h1 class="mt-2 text-base sm:text-lg font-semibold text-slate-800 truncate">Resumen de envíos y bolsa por canal</h1>
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
                        <div class="lg:col-span-2">
                            <label class="mb-1 block text-[11px] font-medium text-slate-600">Desde</label>
                            <div class="relative">
                                <input id="f-desde" type="text" placeholder="YYYY-MM-DD" class="h-9 w-full rounded-md border border-slate-200 ps-9 pe-3 text-sm focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100">
                                <i data-lucide="calendar" class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                            </div>
                        </div>
                        <div class="lg:col-span-2">
                            <label class="mb-1 block text-[11px] font-medium text-slate-600">Hasta</label>
                            <div class="relative">
                                <input id="f-hasta" type="text" placeholder="YYYY-MM-DD" class="h-9 w-full rounded-md border border-slate-200 ps-9 pe-3 text-sm focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100">
                                <i data-lucide="calendar" class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                            </div>
                        </div>
                        <div class="lg:col-span-2">
                            <label class="mb-1 block text-[11px] font-medium text-slate-600">Canal</label>
                            <div class="relative">
                                <select id="f-canal" class="h-9 w-full rounded-md border border-slate-200 px-3 pr-8 text-sm focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100">
                                    <option value="">Todos</option>
                                    <option value="whatsapp">WhatsApp</option>
                                    <option value="sms">SMS</option>
                                    <option value="email">Correo</option>
                                </select>
                                <i data-lucide="chevron-down" class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                            </div>
                        </div>
                        <div class="lg:col-span-2">
                            <label class="mb-1 block text-[11px] font-medium text-slate-600">Proveedor</label>
                            <div class="relative">
                                <select id="f-prov" class="h-9 w-full rounded-md border border-slate-200 px-3 pr-8 text-sm focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100">
                                    <option value="">Todos</option>
                                    <option>Meta</option><option>Twilio</option><option>SendGrid</option>
                                    <option>Mailgun</option><option>SES</option><option>Postmark</option>
                                </select>
                                <i data-lucide="chevron-down" class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                            </div>
                        </div>
                        <div class="lg:col-span-2">
                            <label class="mb-1 block text-[11px] font-medium text-slate-600">Buscar</label>
                            <input id="f-q" type="search" placeholder="Plantilla, asunto o destino" class="h-9 w-full rounded-md border border-slate-200 px-3 text-sm">
                        </div>
                        <div class="sm:col-span-2 lg:col-span-2">
                            <div class="flex justify-end gap-2">
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

                <!-- KPIs simples -->
                <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-3">
                    <div class="rounded-xl border border-slate-200 p-3">
                        <div class="flex items-center justify-between text-[11px] text-slate-500">
                            <span>Enviados</span><i data-lucide="send" class="h-4 w-4 text-slate-400"></i>
                        </div>
                        <div class="mt-1 text-xl font-semibold text-slate-800">3,842</div>
                        <div class="mt-2 h-2 w-full rounded bg-slate-100"><div class="h-2 w-[78%] rounded bg-emerald-500"></div></div>
                    </div>
                    <div class="rounded-xl border border-slate-200 p-3">
                        <div class="flex items-center justify-between text-[11px] text-slate-500">
                            <span>En cola</span><i data-lucide="clock" class="h-4 w-4 text-slate-400"></i>
                        </div>
                        <div class="mt-1 text-xl font-semibold text-slate-800">624</div>
                        <div class="mt-2 h-2 w-full rounded bg-slate-100"><div class="h-2 w-[38%] rounded bg-amber-500"></div></div>
                    </div>
                    <div class="rounded-xl border border-slate-200 p-3">
                        <div class="flex items-center justify-between text-[11px] text-slate-500">
                            <span>Fallidos</span><i data-lucide="x-circle" class="h-4 w-4 text-slate-400"></i>
                        </div>
                        <div class="mt-1 text-xl font-semibold text-slate-800">112</div>
                        <div class="mt-2 h-2 w-full rounded bg-slate-100"><div class="h-2 w-[12%] rounded bg-rose-500"></div></div>
                    </div>
                    <div class="rounded-xl border border-slate-200 p-3">
                        <div class="flex items-center justify-between text-[11px] text-slate-500">
                            <span>Direcciones inválidas</span><i data-lucide="alert-triangle" class="h-4 w-4 text-slate-400"></i>
                        </div>
                        <div class="mt-1 text-xl font-semibold text-slate-800">73</div>
                        <div class="mt-2 h-2 w-full rounded bg-slate-100"><div class="h-2 w-[7%] rounded bg-slate-500"></div></div>
                    </div>
                </div>

                <!-- Tráfico por canal (barras simples) -->
                <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-3">
                    <div class="rounded-xl border border-slate-200 p-3">
                        <div class="flex items-center gap-2">
                            <i data-lucide="messages-square" class="h-5 w-5 text-emerald-600"></i>
                            <div class="text-sm font-semibold text-slate-800">WhatsApp</div>
                        </div>
                        <div class="mt-3 space-y-2 text-sm">
                            <div class="flex items-center justify-between"><span>Enviados</span><span class="text-slate-600">1,820</span></div>
                            <div class="h-2 w-full rounded bg-slate-100"><div class="h-2 rounded bg-emerald-500" style="width:70%"></div></div>
                            <div class="flex items-center justify-between"><span>En cola</span><span class="text-slate-600">220</span></div>
                            <div class="h-2 w-full rounded bg-slate-100"><div class="h-2 rounded bg-amber-500" style="width:20%"></div></div>
                            <div class="flex items-center justify-between"><span>Fallidos</span><span class="text-slate-600">44</span></div>
                            <div class="h-2 w-full rounded bg-slate-100"><div class="h-2 rounded bg-rose-500" style="width:10%"></div></div>
                        </div>
                    </div>

                    <div class="rounded-xl border border-slate-200 p-3">
                        <div class="flex items-center gap-2">
                            <i data-lucide="smartphone" class="h-5 w-5 text-sky-600"></i>
                            <div class="text-sm font-semibold text-slate-800">SMS</div>
                        </div>
                        <div class="mt-3 space-y-2 text-sm">
                            <div class="flex items-center justify-between"><span>Enviados</span><span class="text-slate-600">980</span></div>
                            <div class="h-2 w-full rounded bg-slate-100"><div class="h-2 rounded bg-sky-500" style="width:58%"></div></div>
                            <div class="flex items-center justify-between"><span>En cola</span><span class="text-slate-600">180</span></div>
                            <div class="h-2 w-full rounded bg-slate-100"><div class="h-2 rounded bg-amber-500" style="width:30%"></div></div>
                            <div class="flex items-center justify-between"><span>Fallidos</span><span class="text-slate-600">33</span></div>
                            <div class="h-2 w-full rounded bg-slate-100"><div class="h-2 rounded bg-rose-500" style="width:8%"></div></div>
                        </div>
                    </div>

                    <div class="rounded-xl border border-slate-200 p-3">
                        <div class="flex items-center gap-2">
                            <i data-lucide="mail" class="h-5 w-5 text-indigo-600"></i>
                            <div class="text-sm font-semibold text-slate-800">Correo</div>
                        </div>
                        <div class="mt-3 space-y-2 text-sm">
                            <div class="flex items-center justify-between"><span>Enviados</span><span class="text-slate-600">1,042</span></div>
                            <div class="h-2 w-full rounded bg-slate-100"><div class="h-2 rounded bg-indigo-500" style="width:62%"></div></div>
                            <div class="flex items-center justify-between"><span>En cola</span><span class="text-slate-600">224</span></div>
                            <div class="h-2 w-full rounded bg-slate-100"><div class="h-2 rounded bg-amber-500" style="width:28%"></div></div>
                            <div class="flex items-center justify-between"><span>Fallidos</span><span class="text-slate-600">35</span></div>
                            <div class="h-2 w-full rounded bg-slate-100"><div class="h-2 rounded bg-rose-500" style="width:9%"></div></div>
                        </div>
                    </div>
                </div>

                <!-- Calidad de direcciones -->
                <div class="mt-4 grid grid-cols-1 lg:grid-cols-12 gap-3">
                    <div class="lg:col-span-7 rounded-xl border border-slate-200 p-4">
                        <div class="flex items-center gap-2">
                            <i data-lucide="shield-alert" class="h-5 w-5 text-slate-600"></i>
                            <div class="text-sm font-semibold text-slate-800">Direcciones inválidas o con formato incorrecto</div>
                        </div>
                        <div class="mt-3 grid grid-cols-1 sm:grid-cols-3 gap-3 text-sm">
                            <div class="rounded-lg border border-slate-200 p-3">
                                <div class="text-[11px] text-slate-500">WhatsApp / Teléfono</div>
                                <div class="mt-1 text-lg font-semibold text-slate-800">41</div>
                                <div class="mt-2 h-2 w-full rounded bg-slate-100"><div class="h-2 rounded bg-emerald-500" style="width:32%"></div></div>
                                <div class="mt-2 text-[12px] text-slate-600">Ej.: longitud inválida, sin prefijo +51</div>
                            </div>
                            <div class="rounded-lg border border-slate-200 p-3">
                                <div class="text-[11px] text-slate-500">SMS / Teléfono</div>
                                <div class="mt-1 text-lg font-semibold text-slate-800">19</div>
                                <div class="mt-2 h-2 w-full rounded bg-slate-100"><div class="h-2 rounded bg-sky-500" style="width:15%"></div></div>
                                <div class="mt-2 text-[12px] text-slate-600">Ej.: caracteres no numéricos</div>
                            </div>
                            <div class="rounded-lg border border-slate-200 p-3">
                                <div class="text-[11px] text-slate-500">Correo / Email</div>
                                <div class="mt-1 text-lg font-semibold text-slate-800">13</div>
                                <div class="mt-2 h-2 w-full rounded bg-slate-100"><div class="h-2 rounded bg-indigo-500" style="width:10%"></div></div>
                                <div class="mt-2 text-[12px] text-slate-600">Ej.: dominio inválido, sin @</div>
                            </div>
                        </div>

                        <div class="mt-3 flex flex-wrap items-center justify-between gap-2 text-sm">
                            <div class="text-slate-600">Última validación: 2025-03-21 18:40</div>
                            <div class="flex items-center gap-2">
                                <button id="btn-desc-invalidos" class="inline-flex h-9 items-center gap-2 rounded-md border border-slate-200 px-3 hover:bg-slate-50">
                                    <i data-lucide="download" class="h-4 w-4"></i> CSV inválidos
                                </button>
                                <button id="btn-revalidar" class="inline-flex h-9 items-center gap-2 rounded-md bg-slate-900 px-3 text-white hover:bg-slate-800">
                                    <i data-lucide="refresh-ccw" class="h-4 w-4"></i> Revalidar
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Estados globales (barra segmentada) -->
                    <div class="lg:col-span-5 rounded-xl border border-slate-200 p-4">
                        <div class="flex items-center gap-2">
                            <i data-lucide="bar-chart-2" class="h-5 w-5 text-slate-600"></i>
                            <div class="text-sm font-semibold text-slate-800">Estados globales</div>
                        </div>
                        <div class="mt-3">
                            <div class="text-[12px] text-slate-600">Distribución</div>
                            <div class="mt-2 h-3 w-full rounded bg-slate-100 overflow-hidden flex">
                                <div class="h-3 bg-emerald-500" style="width:65%" title="Entregado"></div>
                                <div class="h-3 bg-violet-500" style="width:18%" title="Leído/Apertura"></div>
                                <div class="h-3 bg-sky-500" style="width:8%" title="Click"></div>
                                <div class="h-3 bg-rose-500" style="width:5%" title="Fallido/Rebotado"></div>
                                <div class="h-3 bg-amber-500" style="width:4%" title="En cola"></div>
                            </div>
                            <div class="mt-3 grid grid-cols-2 sm:grid-cols-5 gap-2 text-[12px] text-slate-700">
                                <span class="inline-flex items-center gap-1"><i class="h-3 w-3 rounded-sm bg-emerald-500"></i>Entregado</span>
                                <span class="inline-flex items-center gap-1"><i class="h-3 w-3 rounded-sm bg-violet-500"></i>Leído</span>
                                <span class="inline-flex items-center gap-1"><i class="h-3 w-3 rounded-sm bg-sky-500"></i>Click</span>
                                <span class="inline-flex items-center gap-1"><i class="h-3 w-3 rounded-sm bg-rose-500"></i>Fallido</span>
                                <span class="inline-flex items-center gap-1"><i class="h-3 w-3 rounded-sm bg-amber-500"></i>En cola</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Resumen por canal (tabla simple) -->
                <div class="mt-4 overflow-hidden rounded-2xl border border-slate-200">
                    <div class="overflow-x-auto">
                        <table class="min-w-[900px] w-full text-sm">
                            <thead class="bg-slate-50 text-slate-600">
                            <tr>
                                <th class="text-left font-medium px-4 py-2">Canal</th>
                                <th class="text-left font-medium px-4 py-2">Enviados</th>
                                <th class="text-left font-medium px-4 py-2">Entregados</th>
                                <th class="text-left font-medium px-4 py-2">Leído / Apertura</th>
                                <th class="text-left font-medium px-4 py-2">Clicks</th>
                                <th class="text-left font-medium px-4 py-2">Fallidos</th>
                                <th class="text-left font-medium px-4 py-2">En cola</th>
                                <th class="text-left font-medium px-4 py-2">Inválidos</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                            <tr class="hover:bg-slate-50/60">
                                <td class="px-4 py-2"><span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 text-emerald-700 px-2 py-0.5"><i data-lucide="messages-square" class="h-3.5 w-3.5"></i> WhatsApp</span></td>
                                <td class="px-4 py-2">1,820</td>
                                <td class="px-4 py-2">1,735</td>
                                <td class="px-4 py-2">1,210</td>
                                <td class="px-4 py-2">260</td>
                                <td class="px-4 py-2">44</td>
                                <td class="px-4 py-2">220</td>
                                <td class="px-4 py-2">41</td>
                            </tr>
                            <tr class="hover:bg-slate-50/60">
                                <td class="px-4 py-2"><span class="inline-flex items-center gap-1.5 rounded-full bg-sky-50 text-sky-700 px-2 py-0.5"><i data-lucide="smartphone" class="h-3.5 w-3.5"></i> SMS</span></td>
                                <td class="px-4 py-2">980</td>
                                <td class="px-4 py-2">913</td>
                                <td class="px-4 py-2">—</td>
                                <td class="px-4 py-2">—</td>
                                <td class="px-4 py-2">33</td>
                                <td class="px-4 py-2">180</td>
                                <td class="px-4 py-2">19</td>
                            </tr>
                            <tr class="hover:bg-slate-50/60">
                                <td class="px-4 py-2"><span class="inline-flex items-center gap-1.5 rounded-full bg-indigo-50 text-indigo-700 px-2 py-0.5"><i data-lucide="mail" class="h-3.5 w-3.5"></i> Correo</span></td>
                                <td class="px-4 py-2">1,042</td>
                                <td class="px-4 py-2">988</td>
                                <td class="px-4 py-2">742</td>
                                <td class="px-4 py-2">164</td>
                                <td class="px-4 py-2">35</td>
                                <td class="px-4 py-2">224</td>
                                <td class="px-4 py-2">13</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Footer -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 px-3 py-2 bg-white border-t border-slate-100">
                        <div class="text-xs text-slate-600">Actualizado: 2025-03-21 18:45</div>
                        <div class="flex items-center gap-2">
                            <a hx-get="reporte-envios.php" hx-target="#content-html" hx-swap="innerHTML" class="inline-flex h-9 items-center gap-2 rounded-md border border-slate-200 px-3 text-sm hover:bg-slate-50">
                                <i data-lucide="list" class="h-4 w-4"></i> Ver detalle de envíos
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>try{lucide.createIcons()}catch(e){}</script>

@endsection
