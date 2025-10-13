@extends('layout.app')
@section('content')
    <section id="mensajeria-sms-config" class="min-w-0 flex-1">
        <div class="bg-white border border-slate-200 rounded-2xl">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between px-4 sm:px-6 py-4 border-b border-slate-100">
                <div class="min-w-0">
                    <div class="flex items-center gap-2 text-slate-500 text-xs sm:text-sm">
                        <a class="hover:text-slate-700" href="#">Mensajería</a><span>›</span>
                        <a class="hover:text-slate-700" href="#">Config. de canales</a><span>›</span>
                        <span class="text-slate-700 font-medium">SMS</span>
                    </div>
                    <h1 class="mt-2 text-base sm:text-lg font-semibold text-slate-800 truncate">Configuración de SMS</h1>
                </div>
                <div class="flex items-center gap-2">
                    <label class="inline-flex items-center gap-2 text-sm">
                        <input id="sms-enabled" type="checkbox" class="h-4 w-4 rounded border-slate-300"> Habilitar
                    </label>
                    <button id="sms-btn-save" class="inline-flex items-center gap-2 rounded-lg bg-slate-900 text-white px-3 py-2 text-sm hover:bg-slate-800">
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
                                <i data-lucide="smartphone" class="h-5 w-5 text-sky-600"></i>
                                <div class="text-sm font-semibold text-slate-800">Conexión</div>
                            </div>

                            <div class="p-4 space-y-4">
                                <!-- Proveedor -->
                                <div>
                                    <label class="mb-1 block text-[11px] font-medium text-slate-600">Proveedor</label>
                                    <div class="relative">
                                        <select id="sms-sel-prov" class="h-9 w-full rounded-md border border-slate-200 px-3 pr-8 text-sm focus:border-indigo-300 focus:ring-2 focus:ring-indigo-100">
                                            <option value="twilio">Twilio</option>
                                            <option value="vonage">Vonage (Nexmo)</option>
                                            <option value="infobip">Infobip</option>
                                            <option value="generic">Webhook genérico</option>
                                        </select>
                                        <i data-lucide="chevron-down" class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                                    </div>
                                </div>

                                <!-- Twilio -->
                                <div data-provider-fields="twilio" class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label class="mb-1 block text-[11px] font-medium text-slate-600">Account SID</label>
                                        <input id="sms-twilio-sid" type="text" class="h-9 w-full rounded-md border border-slate-200 px-3 text-sm" placeholder="ACxxxxxxxx">
                                    </div>
                                    <div>
                                        <label class="mb-1 block text-[11px] font-medium text-slate-600">Auth Token</label>
                                        <input id="sms-twilio-token" type="password" class="h-9 w-full rounded-md border border-slate-200 px-3 text-sm">
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label class="mb-1 block text-[11px] font-medium text-slate-600">Remitente (From)</label>
                                        <input id="sms-twilio-from" type="text" class="h-9 w-full rounded-md border border-slate-200 px-3 text-sm" placeholder="+51999999999 / alfanumérico">
                                    </div>
                                </div>

                                <!-- Vonage -->
                                <div data-provider-fields="vonage" class="grid grid-cols-1 sm:grid-cols-2 gap-3 hidden">
                                    <div>
                                        <label class="mb-1 block text-[11px] font-medium text-slate-600">API Key</label>
                                        <input id="sms-vonage-key" type="text" class="h-9 w-full rounded-md border border-slate-200 px-3 text-sm">
                                    </div>
                                    <div>
                                        <label class="mb-1 block text-[11px] font-medium text-slate-600">API Secret</label>
                                        <input id="sms-vonage-secret" type="password" class="h-9 w-full rounded-md border border-slate-200 px-3 text-sm">
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label class="mb-1 block text-[11px] font-medium text-slate-600">Remitente (From)</label>
                                        <input id="sms-vonage-from" type="text" class="h-9 w-full rounded-md border border-slate-200 px-3 text-sm" placeholder="EDUTAL / +51999999999">
                                    </div>
                                </div>

                                <!-- Infobip -->
                                <div data-provider-fields="infobip" class="grid grid-cols-1 sm:grid-cols-2 gap-3 hidden">
                                    <div class="sm:col-span-2">
                                        <label class="mb-1 block text-[11px] font-medium text-slate-600">Base URL</label>
                                        <input id="sms-infobip-base" type="text" class="h-9 w-full rounded-md border border-slate-200 px-3 text-sm" placeholder="https://xxxx.api.infobip.com">
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label class="mb-1 block text-[11px] font-medium text-slate-600">API Key</label>
                                        <input id="sms-infobip-key" type="password" class="h-9 w-full rounded-md border border-slate-200 px-3 text-sm">
                                    </div>
                                </div>

                                <!-- Genérico -->
                                <div data-provider-fields="generic" class="grid grid-cols-1 sm:grid-cols-2 gap-3 hidden">
                                    <div class="sm:col-span-2">
                                        <label class="mb-1 block text-[11px] font-medium text-slate-600">Endpoint de envío</label>
                                        <input id="sms-gen-url" type="text" class="h-9 w-full rounded-md border border-slate-200 px-3 text-sm" placeholder="POST https://tu-api/sms/send">
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label class="mb-1 block text-[11px] font-medium text-slate-600">API Key / Token</label>
                                        <input id="sms-gen-token" type="password" class="h-9 w-full rounded-md border border-slate-200 px-3 text-sm">
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
                                    <span id="sms-status" class="inline-flex items-center gap-1 bg-slate-100 text-slate-600 rounded-full px-2 py-0.5"><i data-lucide="dot" class="h-4 w-4"></i> —</span>
                                </div>
                                <div class="flex items-center justify-between rounded-md border border-slate-200 px-3 py-2">
                                    <span>Webhook</span>
                                    <span id="sms-webhook-status" class="inline-flex items-center gap-1 bg-slate-100 text-slate-600 rounded-full px-2 py-0.5"><i data-lucide="dot" class="h-4 w-4"></i> —</span>
                                </div>
                            </div>

                            <div class="mt-4">
                                <label class="mb-1 block text-[11px] font-medium text-slate-600">Enviar prueba</label>
                                <div class="flex flex-col sm:flex-row gap-2">
                                    <input id="sms-test-dest" type="text" class="h-9 w-full rounded-md border border-slate-200 px-3 text-sm" placeholder="+51987654321">
                                    <button id="sms-btn-test" class="inline-flex h-9 items-center gap-2 rounded-md bg-slate-900 px-3 text-sm text-white hover:bg-slate-800">
                                        <i data-lucide="send" class="h-4 w-4"></i> Probar
                                    </button>
                                </div>
                                <textarea id="sms-test-body" rows="3" class="mt-2 w-full rounded-md border border-slate-200 p"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
