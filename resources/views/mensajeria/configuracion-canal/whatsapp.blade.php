@extends('layout.app')
@section('content')

    <section id="mensajeria-wa-config" class="min-w-0 flex-1">
        <div class="bg-white border border-slate-200 rounded-2xl">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between px-4 sm:px-6 py-4 border-b border-slate-100">
                <div class="min-w-0">
                    <div class="flex items-center gap-2 text-slate-500 text-xs sm:text-sm">
                        <a class="hover:text-slate-700" href="#">Mensajería</a><span>›</span>
                        <a class="hover:text-slate-700" href="#">Config. de canales</a><span>›</span>
                        <span class="text-slate-700 font-medium">WhatsApp</span>
                    </div>
                    <h1 class="mt-2 text-base sm:text-lg font-semibold text-slate-800 truncate">Configuración de WhatsApp</h1>
                </div>
                <div class="flex items-center gap-2">
                    <label class="inline-flex items-center gap-2 text-sm">
                        <input id="wa-enabled" type="checkbox" class="h-4 w-4 rounded border-slate-300">
                        Habilitar
                    </label>
                    <button id="btn-save" class="inline-flex items-center gap-2 rounded-lg bg-slate-900 text-white px-3 py-2 text-sm hover:bg-slate-800 focus:outline-none focus:ring-4 focus:ring-slate-300">
                        <i data-lucide="save" class="h-4 w-4"></i> Guardar
                    </button>
                </div>
            </div>

            <!-- Contenido -->
            <div class="p-4 sm:p-6">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-4">
                    <!-- Columna izquierda: conexión (resumida) -->
                    <div class="lg:col-span-7 space-y-4">
                        <div class="rounded-xl border border-slate-200">
                            <div class="flex items-center gap-2 px-4 py-3 border-b border-slate-100">
                                <i data-lucide="message-circle" class="h-5 w-5 text-emerald-600"></i>
                                <div class="text-sm font-semibold text-slate-800">Conexión</div>
                            </div>

                            <div class="p-4 space-y-4">
                                <!-- Proveedor + básicos -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div class="sm:col-span-2">
                                        <label class="mb-1 block text-[11px] font-medium text-slate-600">Proveedor</label>
                                        <div class="relative">
                                            <select id="sel-prov" class="h-9 w-full appearance-none rounded-md border border-slate-200 px-3 pr-8 text-sm focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100">
                                                <option value="meta">Meta Cloud API (oficial)</option>
                                                <option value="twilio">Twilio WhatsApp</option>
                                                <option value="generic">Webhook genérico</option>
                                            </select>
                                            <i data-lucide="chevron-down" class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="mb-1 block text-[11px] font-medium text-slate-600">Nombre remitente (opcional)</label>
                                        <input id="f-display" type="text" class="h-9 w-full rounded-md border border-slate-200 px-3 text-sm" placeholder="Edutalentos Notif.">
                                    </div>
                                    <div>
                                        <label class="mb-1 block text-[11px] font-medium text-slate-600">Prefijo país por defecto</label>
                                        <input id="f-default-cc" type="text" class="h-9 w-full rounded-md border border-slate-200 px-3 text-sm" placeholder="+51">
                                    </div>
                                </div>

                                <!-- META CLOUD (campos mínimos) -->
                                <div data-provider-fields="meta" class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label class="mb-1 block text-[11px] font-medium text-slate-600">Access Token</label>
                                        <input id="f-access-token" type="password" class="h-9 w-full rounded-md border border-slate-200 px-3 text-sm" placeholder="EAAG...">
                                    </div>
                                    <div>
                                        <label class="mb-1 block text-[11px] font-medium text-slate-600">Phone Number ID</label>
                                        <input id="f-phone-id" type="text" class="h-9 w-full rounded-md border border-slate-200 px-3 text-sm" placeholder="xxxxxxxxxxxxxxx">
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label class="mb-1 block text-[11px] font-medium text-slate-600">Webhook Verify Token</label>
                                        <input id="f-verify-token" type="text" class="h-9 w-full rounded-md border border-slate-200 px-3 text-sm" placeholder="token-verificacion">
                                    </div>
                                </div>

                                <!-- TWILIO (campos mínimos) -->
                                <div data-provider-fields="twilio" class="grid grid-cols-1 sm:grid-cols-2 gap-3 hidden">
                                    <div>
                                        <label class="mb-1 block text-[11px] font-medium text-slate-600">Account SID</label>
                                        <input id="f-twilio-sid" type="text" class="h-9 w-full rounded-md border border-slate-200 px-3 text-sm" placeholder="ACxxxxxxxx">
                                    </div>
                                    <div>
                                        <label class="mb-1 block text-[11px] font-medium text-slate-600">Auth Token</label>
                                        <input id="f-twilio-token" type="password" class="h-9 w-full rounded-md border border-slate-200 px-3 text-sm" placeholder="••••••">
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label class="mb-1 block text-[11px] font-medium text-slate-600">Número WhatsApp (E.164)</label>
                                        <input id="f-twilio-number" type="text" class="h-9 w-full rounded-md border border-slate-200 px-3 text-sm" placeholder="whatsapp:+51999999999">
                                    </div>
                                </div>

                                <!-- WEBHOOK GENÉRICO (campos mínimos) -->
                                <div data-provider-fields="generic" class="grid grid-cols-1 sm:grid-cols-2 gap-3 hidden">
                                    <div class="sm:col-span-2">
                                        <label class="mb-1 block text-[11px] font-medium text-slate-600">Endpoint de envío</label>
                                        <input id="f-gen-url" type="text" class="h-9 w-full rounded-md border border-slate-200 px-3 text-sm" placeholder="https://api.tu-pasarela/whatsapp/send">
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label class="mb-1 block text-[11px] font-medium text-slate-600">API Key / Token</label>
                                        <input id="f-gen-token" type="password" class="h-9 w-full rounded-md border border-slate-200 px-3 text-sm">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Columna derecha: estado / prueba / webhook (resumido) -->
                    <div class="lg:col-span-5 space-y-4">
                        <!-- Estado + prueba -->
                        <div class="rounded-xl border border-slate-200 p-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <i data-lucide="activity" class="h-5 w-5 text-slate-500"></i>
                                    <div class="text-sm font-semibold text-slate-800">Estado & prueba</div>
                                </div>
                                <button id="btn-refresh-status" class="inline-flex h-8 items-center gap-1 rounded-md border border-slate-200 px-2 text-xs hover:bg-slate-50">
                                    <i data-lucide="refresh-cw" class="h-3.5 w-3.5"></i> Actualizar
                                </button>
                            </div>

                            <div class="mt-3 grid grid-cols-2 gap-3 text-sm">
                                <div class="flex items-center justify-between rounded-md border border-slate-200 px-3 py-2">
                                    <span>Conexión API</span>
                                    <span id="wa-status-api" class="inline-flex items-center gap-1 text-slate-600 bg-slate-100 rounded-full px-2 py-0.5">
                  <i data-lucide="dot" class="h-4 w-4"></i> —
                </span>
                                </div>
                                <div class="flex items-center justify-between rounded-md border border-slate-200 px-3 py-2">
                                    <span>Webhook</span>
                                    <span id="wa-status-webhook" class="inline-flex items-center gap-1 text-slate-600 bg-slate-100 rounded-full px-2 py-0.5">
                  <i data-lucide="dot" class="h-4 w-4"></i> —
                </span>
                                </div>
                            </div>

                            <div class="mt-4">
                                <label class="mb-1 block text-[11px] font-medium text-slate-600">Mensaje de prueba</label>
                                <div class="flex flex-col sm:flex-row gap-2">
                                    <input id="wa-test-dest" type="text" class="h-9 w-full rounded-md border border-slate-200 px-3 text-sm" placeholder="+51987654321">
                                    <button id="btn-test-send" class="inline-flex h-9 items-center gap-2 rounded-md bg-slate-900 px-3 text-sm text-white hover:bg-slate-800">
                                        <i data-lucide="send" class="h-4 w-4"></i> Probar
                                    </button>
                                </div>
                                <textarea id="wa-test-body" rows="3" class="mt-2 w-full rounded-md border border-slate-200 px-3 py-2 text-sm" placeholder="Hola, este es un mensaje de prueba."></textarea>
                            </div>
                        </div>

                        <!-- Webhook (mínimo) -->
                        <div class="rounded-xl border border-slate-200 p-4">
                            <div class="flex items-center gap-2">
                                <i data-lucide="webhook" class="h-5 w-5 text-slate-500"></i>
                                <div class="text-sm font-semibold text-slate-800">Webhook</div>
                            </div>
                            <div class="mt-3 space-y-3 text-sm">
                                <div>
                                    <label class="mb-1 block text-[11px] font-medium text-slate-600">URL</label>
                                    <div class="flex gap-2">
                                        <input id="wa-webhook-url" type="text" readonly class="h-9 w-full rounded-md border border-slate-200 px-3 text-sm bg-slate-50" value="https://tudominio.com/api/webhooks/whatsapp">
                                        <button id="btn-copy-webhook" class="inline-flex h-9 items-center gap-2 rounded-md border border-slate-200 px-3 text-sm hover:bg-slate-50">
                                            <i data-lucide="copy" class="h-4 w-4"></i> Copiar
                                        </button>
                                    </div>
                                </div>
                                <div>
                                    <label class="mb-1 block text-[11px] font-medium text-slate-600">Verify Token</label>
                                    <input id="wa-webhook-verify" type="text" class="h-9 w-full rounded-md border border-slate-200 px-3 text-sm" placeholder="mismo que en Conexión">
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- /grid -->
            </div>
        </div>
    </section>

    <script>try{lucide.createIcons()}catch(e){}</script>

@endsection
