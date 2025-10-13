@extends('layout.app')
@section('content')
    <section id="mensajeria-mail-config" class="min-w-0 flex-1">
        <div class="bg-white border border-slate-200 rounded-2xl">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between px-4 sm:px-6 py-4 border-b border-slate-100">
                <div class="min-w-0">
                    <div class="flex items-center gap-2 text-slate-500 text-xs sm:text-sm">
                        <a class="hover:text-slate-700" href="#">Mensajería</a><span>›</span>
                        <a class="hover:text-slate-700" href="#">Config. de canales</a><span>›</span>
                        <span class="text-slate-700 font-medium">Correo</span>
                    </div>
                    <h1 class="mt-2 text-base sm:text-lg font-semibold text-slate-800 truncate">Configuración de Correo</h1>
                </div>
                <div class="flex items-center gap-2">
                    <label class="inline-flex items-center gap-2 text-sm">
                        <input id="em-enabled" type="checkbox" class="h-4 w-4 rounded border-slate-300"> Habilitar
                    </label>
                    <button id="em-btn-save" class="inline-flex items-center gap-2 rounded-lg bg-slate-900 text-white px-3 py-2 text-sm hover:bg-slate-800">
                        <i data-lucide="save" class="h-4 w-4"></i> Guardar
                    </button>
                </div>
            </div>

            <!-- Contenido -->
            <div class="p-4 sm:p-6">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-4">
                    <!-- Conexión -->
                    <div class="lg:col-span-7 space-y-4">
                        <div class="rounded-xl border border-slate-200">
                            <div class="flex items-center gap-2 px-4 py-3 border-b border-slate-100">
                                <i data-lucide="mail" class="h-5 w-5 text-indigo-600"></i>
                                <div class="text-sm font-semibold text-slate-800">Conexión</div>
                            </div>

                            <div class="p-4 space-y-4">
                                <!-- Proveedor -->
                                <div>
                                    <label class="mb-1 block text-[11px] font-medium text-slate-600">Proveedor</label>
                                    <div class="relative">
                                        <select id="em-sel-prov" class="h-9 w-full rounded-md border border-slate-200 px-3 pr-8 text-sm focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100">
                                            <option value="smtp">SMTP propio</option>
                                            <option value="sendgrid">SendGrid (API)</option>
                                            <option value="ses">Amazon SES (API)</option>
                                            <option value="mailgun">Mailgun (API)</option>
                                            <option value="postmark">Postmark (API)</option>
                                        </select>
                                        <i data-lucide="chevron-down" class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                                    </div>
                                </div>

                                <!-- Comunes -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label class="mb-1 block text-[11px] font-medium text-slate-600">Remitente (nombre)</label>
                                        <input id="em-from-name" type="text" class="h-9 w-full rounded-md border border-slate-200 px-3 text-sm" placeholder="Edutalentos Notificaciones">
                                    </div>
                                    <div>
                                        <label class="mb-1 block text-[11px] font-medium text-slate-600">Remitente (correo)</label>
                                        <input id="em-from-email" type="email" class="h-9 w-full rounded-md border border-slate-200 px-3 text-sm" placeholder="no-reply@tudominio.com">
                                    </div>
                                </div>

                                <!-- SMTP -->
                                <div data-provider-fields="smtp" class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label class="mb-1 block text-[11px] font-medium text-slate-600">Host SMTP</label>
                                        <input id="em-host" type="text" class="h-9 w-full rounded-md border border-slate-200 px-3 text-sm" placeholder="smtp.tudominio.com">
                                    </div>
                                    <div>
                                        <label class="mb-1 block text-[11px] font-medium text-slate-600">Puerto</label>
                                        <input id="em-port" type="number" class="h-9 w-full rounded-md border border-slate-200 px-3 text-sm" placeholder="587">
                                    </div>
                                    <div>
                                        <label class="mb-1 block text-[11px] font-medium text-slate-600">Usuario</label>
                                        <input id="em-user" type="text" class="h-9 w-full rounded-md border border-slate-200 px-3 text-sm">
                                    </div>
                                    <div>
                                        <label class="mb-1 block text-[11px] font-medium text-slate-600">Contraseña</label>
                                        <input id="em-pass" type="password" class="h-9 w-full rounded-md border border-slate-200 px-3 text-sm">
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label class="mb-1 block text-[11px] font-medium text-slate-600">Cifrado</label>
                                        <div class="relative">
                                            <select id="em-secure" class="h-9 w-full rounded-md border border-slate-200 px-3 pr-8 text-sm">
                                                <option value="tls">TLS</option>
                                                <option value="ssl">SSL</option>
                                                <option value="none">Sin cifrado</option>
                                            </select>
                                            <i data-lucide="chevron-down" class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- SendGrid -->
                                <div data-provider-fields="sendgrid" class="grid grid-cols-1 sm:grid-cols-2 gap-3 hidden">
                                    <div class="sm:col-span-2">
                                        <label class="mb-1 block text-[11px] font-medium text-slate-600">API Key</label>
                                        <input id="em-sg-key" type="password" class="h-9 w-full rounded-md border border-slate-200 px-3 text-sm">
                                    </div>
                                </div>

                                <!-- Amazon SES -->
                                <div data-provider-fields="ses" class="grid grid-cols-1 sm:grid-cols-2 gap-3 hidden">
                                    <div>
                                        <label class="mb-1 block text-[11px] font-medium text-slate-600">Access Key ID</label>
                                        <input id="em-ses-key" type="text" class="h-9 w-full rounded-md border border-slate-200 px-3 text-sm">
                                    </div>
                                    <div>
                                        <label class="mb-1 block text-[11px] font-medium text-slate-600">Secret Access Key</label>
                                        <input id="em-ses-secret" type="password" class="h-9 w-full rounded-md border border-slate-200 px-3 text-sm">
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label class="mb-1 block text-[11px] font-medium text-slate-600">Región</label>
                                        <input id="em-ses-region" type="text" class="h-9 w-full rounded-md border border-slate-200 px-3 text-sm" placeholder="us-east-1">
                                    </div>
                                </div>

                                <!-- Mailgun -->
                                <div data-provider-fields="mailgun" class="grid grid-cols-1 sm:grid-cols-2 gap-3 hidden">
                                    <div>
                                        <label class="mb-1 block text-[11px] font-medium text-slate-600">API Key</label>
                                        <input id="em-mg-key" type="password" class="h-9 w-full rounded-md border border-slate-200 px-3 text-sm">
                                    </div>
                                    <div>
                                        <label class="mb-1 block text-[11px] font-medium text-slate-600">Dominio</label>
                                        <input id="em-mg-domain" type="text" class="h-9 w-full rounded-md border border-slate-200 px-3 text-sm" placeholder="mg.tudominio.com">
                                    </div>
                                </div>

                                <!-- Postmark -->
                                <div data-provider-fields="postmark" class="grid grid-cols-1 sm:grid-cols-2 gap-3 hidden">
                                    <div class="sm:col-span-2">
                                        <label class="mb-1 block text-[11px] font-medium text-slate-600">Server Token</label>
                                        <input id="em-postmark-token" type="password" class="h-9 w-full rounded-md border border-slate-200 px-3 text-sm">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Estado / prueba / webhook -->
                    <div class="lg:col-span-5 space-y-4">
                        <div class="rounded-xl border border-slate-200 p-4">
                            <div class="flex items-center gap-2">
                                <i data-lucide="activity" class="h-5 w-5 text-slate-500"></i>
                                <div class="text-sm font-semibold text-slate-800">Estado & prueba</div>
                            </div>
                            <div class="mt-3 grid grid-cols-2 gap-3 text-sm">
                                <div class="flex items-center justify-between rounded-md border border-slate-200 px-3 py-2">
                                    <span>Conexión</span>
                                    <span id="em-status" class="inline-flex items-center gap-1 bg-slate-100 text-slate-600 rounded-full px-2 py-0.5">
                  <i data-lucide="dot" class="h-4 w-4"></i> —
                </span>
                                </div>
                                <div class="flex items-center justify-between rounded-md border border-slate-200 px-3 py-2">
                                    <span>Webhook</span>
                                    <span id="em-webhook-status" class="inline-flex items-center gap-1 bg-slate-100 text-slate-600 rounded-full px-2 py-0.5">
                  <i data-lucide="dot" class="h-4 w-4"></i> —
                </span>
                                </div>
                            </div>

                            <div class="mt-4">
                                <label class="mb-1 block text-[11px] font-medium text-slate-600">Enviar prueba</label>
                                <div class="flex flex-col sm:flex-row gap-2">
                                    <input id="em-test-dest" type="email" class="h-9 w-full rounded-md border border-slate-200 px-3 text-sm" placeholder="tu@correo.com">
                                    <button id="em-btn-test" class="inline-flex h-9 items-center gap-2 rounded-md bg-slate-900 px-3 text-sm text-white hover:bg-slate-800">
                                        <i data-lucide="send" class="h-4 w-4"></i> Probar
                                    </button>
                                </div>
                                <input id="em-test-subject" type="text" class="mt-2 h-9 w-full rounded-md border border-slate-200 px-3 text-sm" placeholder="Asunto de prueba">
                                <textarea id="em-test-body" rows="3" class="mt-2 w-full rounded-md border border-slate-200 px-3 py-2 text-sm" placeholder="Hola, este es un correo de prueba."></textarea>
                            </div>
                        </div>

                        <div class="rounded-xl border border-slate-200 p-4">
                            <div class="flex items-center gap-2">
                                <i data-lucide="webhook" class="h-5 w-5 text-slate-500"></i>
                                <div class="text-sm font-semibold text-slate-800">Webhook (rebotes/quejas)</div>
                            </div>
                            <div class="mt-3 space-y-3 text-sm">
                                <div>
                                    <label class="mb-1 block text-[11px] font-medium text-slate-600">URL</label>
                                    <div class="flex gap-2">
                                        <input id="em-webhook-url" type="text" readonly class="h-9 w-full rounded-md border border-slate-200 px-3 text-sm bg-slate-50" value="https://tudominio.com/api/webhooks/email">
                                        <button id="em-copy-webhook" class="inline-flex h-9 items-center gap-2 rounded-md border border-slate-200 px-3 text-sm hover:bg-slate-50">
                                            <i data-lucide="copy" class="h-4 w-4"></i> Copiar
                                        </button>
                                    </div>
                                </div>
                                <div>
                                    <label class="mb-1 block text-[11px] font-medium text-slate-600">Secreto / firma</label>
                                    <input id="em-webhook-secret" type="text" class="h-9 w-full rounded-md border border-slate-200 px-3 text-sm" placeholder="para verificar orígenes">
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
