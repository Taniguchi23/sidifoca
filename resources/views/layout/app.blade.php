<!doctype html>
<html lang="es" class="h-full">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Edutalentos - MINEDU</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Config Tailwind (colores & fuente opcional)
        tailwind.config = {
            theme: {
                borderRadius: {
                    none: '0',
                    sm:   '0.25rem',  // 2px
                    DEFAULT: '1.25rem',// 4px
                    md:   '0.375rem',  // 6px
                    lg:   '0.5rem',    // 8px
                    xl:   '0.625rem',  // 10px
                    '2xl':'0.75rem',   // 12px
                    full: '9999px'
                },
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'Apple Color Emoji', 'Segoe UI Emoji']
                    }
                }
            }
        }
    </script>

    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- Flowbite (CSS opcional, la UI es con utilidades Tailwind) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.5.1/flowbite.min.css"/>

    <!-- Flowbite (JS) -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite-datepicker@1.3.2/dist/js/datepicker-full.min.js"></script>


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>

        a {cursor: pointer}
        /* Scrollbar sutil para el sidebar */
        .thin-scroll::-webkit-scrollbar { width: 8px; }
        .thin-scroll::-webkit-scrollbar-thumb { background: #334155; border-radius: 9999px; }
        .thin-scroll { scrollbar-width: thin; scrollbar-color: #334155 transparent; }

        summary::-webkit-details-marker { display: none; }
        details[open] > summary .arrow { transform: rotate(90deg); }


        .tag{display:inline-flex;align-items:center;gap:.375rem;padding:.125rem .5rem;border-radius:9999px;font-size:12px;font-weight:500}
        /* Roles */
        .role-alumno{background:#e6f0ff;color:#1d4ed8}
        .role-prof{background:#f3e8ff;color:#7c3aed}
        .role-asist{background:#e0f2fe;color:#0369a1}
        /* Estados */
        .st-act{background:#ecfdf5;color:#047857}
        .st-cond{background:#fffbeb;color:#b45309}
    </style>
    @yield('link')
</head>
<body class="h-full bg-slate-50 text-slate-800">
<!-- App wrapper -->
<div class="flex h-screen overflow-hidden">

    <!-- Sidebar (desktop) -->
    <aside id="sidebar"
           class="hidden lg:flex lg:flex-col w-[265px] flex-none bg-slate-900 text-slate-200 border-r border-slate-800"
           aria-label="Barra lateral de navegación">
        <!-- Logo -->
        <div class="flex items-center gap-3 h-16 px-4 border-b border-slate-800 shrink-0">
            <img src="/images/logo-t.png" alt="">
        </div>

        <!-- Nav scroll -->
        <!-- estilos opcionales para el caret -->
        <style>
            .caret { transition: transform .15s ease; }
            [data-accordion="toggle"][aria-expanded="true"] .caret { transform: rotate(180deg); }
        </style>

        <nav class="flex-1 overflow-y-auto thin-scroll p-3">
            <!-- Grupo: AULA VIRTUAL -->
            <p class="px-3 py-2 text-xs font-semibold uppercase tracking-wider text-slate-400">Aula Virtual</p>
            <ul class="space-y-1 mb-6">
                <li>
                    <a href="#"
                       class="group flex items-center gap-3 px-3 py-2 rounded-md hover:bg-slate-800/80 aria-[current=page]:bg-slate-800" aria-current="false">
                        <i data-lucide="layout-dashboard" class="h-5 w-5 text-slate-400 group-hover:text-slate-200"></i>
                        <span class="text-sm">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('aula-virtual.centro-academico.index')}}"
                       class="group flex items-center gap-3 px-3 py-2 rounded-md hover:bg-slate-800/80 aria-[current=page]:bg-slate-800" aria-current="false">
                        <i data-lucide="graduation-cap" class="h-5 w-5 text-slate-400 group-hover:text-slate-200"></i>
                        <span class="text-sm">Centro Académico</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('aula-virtual.gestion-usuario.index')}}"
                       class="group flex items-center gap-3 px-3 py-2 rounded-md hover:bg-slate-800/80">
                        <i data-lucide="user-cog" class="h-5 w-5 text-slate-400 group-hover:text-slate-200"></i>
                        <span class="text-sm">Gestión de usuarios</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('aula-virtual.certificado.index')}}"
                       class="group flex items-center gap-3 px-3 py-2 rounded-md hover:bg-slate-800/80">
                        <i data-lucide="award" class="h-5 w-5 text-slate-400 group-hover:text-slate-200"></i>
                        <span class="text-sm">Mis certificados</span>
                    </a>
                </li>

                <li>
                    <button class="w-full flex items-center justify-between gap-3 px-3 py-2 rounded-md hover:bg-slate-800/80"
                            data-accordion="toggle" aria-expanded="false" aria-controls="grp-auditoria">
        <span class="flex items-center gap-3">
          <i data-lucide="file-search" class="h-5 w-5 text-slate-400"></i>
          <span class="text-sm">Auditoría</span>
        </span>
                        <i data-lucide="chevron-down" class="h-4 w-4 text-slate-400 caret"></i>
                    </button>
                    <ul id="grp-auditoria" class="mt-1 hidden pl-11 space-y-1" role="region">
                        <li>
                            <a href="{{route('aula-virtual.auditoria.accesos-usuarios')}}"
                               class="flex items-center gap-2 px-3 py-2 rounded-md hover:bg-slate-800/80 text-sm">
                                <i data-lucide="log-in" class="h-4 w-4 text-slate-400"></i> Accesos de usuarios
                            </a>
                        </li>
                        <li>
                            <a href="{{route('aula-virtual.auditoria.log-sistema')}}"
                               class="flex items-center gap-2 px-3 py-2 rounded-md hover:bg-slate-800/80 text-sm">
                                <i data-lucide="scroll-text" class="h-4 w-4 text-slate-400"></i> Log de sistemas
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="{{route('aula-virtual.calificacion-tarea.index')}}"
                       class="group flex items-center gap-3 px-3 py-2 rounded-md hover:bg-slate-800/80">
                        <i data-lucide="clipboard-check" class="h-5 w-5 text-slate-400 group-hover:text-slate-200"></i>
                        <span class="text-sm">Calificación de tareas</span>
                    </a>
                </li>
            </ul>

            <!-- Grupo: MENSAJERÍA -->
            <p class="px-3 py-2 text-xs font-semibold uppercase tracking-wider text-slate-400">Mensajería</p>
            <ul class="space-y-1 mb-6">
                <li>
                    <a href="{{route('mensajeria.programacion-envio.index')}}" class="group flex items-center gap-3 px-3 py-2 rounded-md hover:bg-slate-800/80">
                        <i data-lucide="calendar-clock" class="h-5 w-5 text-slate-400 group-hover:text-slate-200"></i>
                        <span class="text-sm">Programación de envíos</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('mensajeria.plantilla-mensaje.index')}}" class="group flex items-center gap-3 px-3 py-2 rounded-md hover:bg-slate-800/80">
                        <i data-lucide="file-text" class="h-5 w-5 text-slate-400 group-hover:text-slate-200"></i>
                        <span class="text-sm">Plantillas de mensajes</span>
                    </a>
                </li>

                <li>
                    <button class="w-full flex items-center justify-between gap-3 px-3 py-2 rounded-md hover:bg-slate-800/80"
                            data-accordion="toggle" aria-expanded="false" aria-controls="grp-canales">
        <span class="flex items-center gap-3">
          <i data-lucide="settings-2" class="h-5 w-5 text-slate-400"></i>
          <span class="text-sm">Config. de canales</span>
        </span>
                        <i data-lucide="chevron-down" class="h-4 w-4 text-slate-400 caret"></i>
                    </button>
                    <ul id="grp-canales" class="mt-1 hidden pl-11 space-y-1" role="region">
                        <li><a href="{{route('mensajeria.configuracion-canal.whatsapp.index')}}" class="flex items-center gap-2 px-3 py-2 rounded-md hover:bg-slate-800/80 text-sm"><i data-lucide="message-circle" class="h-4 w-4 text-slate-400"></i> WhatsApp</a></li>
                        <li><a href="{{route('mensajeria.configuracion-canal.email.index')}}" class="flex items-center gap-2 px-3 py-2 rounded-md hover:bg-slate-800/80 text-sm"><i data-lucide="mail" class="h-4 w-4 text-slate-400"></i> Correo electrónico</a></li>
                        <li><a href="{{route('mensajeria.configuracion-canal.sms.index')}}" class="flex items-center gap-2 px-3 py-2 rounded-md hover:bg-slate-800/80 text-sm"><i data-lucide="message-square" class="h-4 w-4 text-slate-400"></i> SMS</a></li>
                    </ul>
                </li>

                <li>
                    <button class="w-full flex items-center justify-between gap-3 px-3 py-2 rounded-md hover:bg-slate-800/80"
                            data-accordion="toggle" aria-expanded="false" aria-controls="grp-reportes">
        <span class="flex items-center gap-3">
          <i data-lucide="bar-chart-3" class="h-5 w-5 text-slate-400"></i>
          <span class="text-sm">Reportes</span>
        </span>
                        <i data-lucide="chevron-down" class="h-4 w-4 text-slate-400 caret"></i>
                    </button>
                    <ul id="grp-reportes" class="mt-1 hidden pl-11 space-y-1" role="region">
                        <li><a href="{{route('mensajeria.reporte.estadistica')}}" class="flex items-center gap-2 px-3 py-2 rounded-md hover:bg-slate-800/80 text-sm"><i data-lucide="pie-chart" class="h-4 w-4 text-slate-400"></i> Estadísticas</a></li>
                        <li><a href="{{route('mensajeria.reporte.envios-realizado')}}" class="flex items-center gap-2 px-3 py-2 rounded-md hover:bg-slate-800/80 text-sm"><i data-lucide="hourglass" class="h-4 w-4 text-slate-400"></i> Envíos realizados</a></li>
                    </ul>
                </li>
            </ul>

            <!-- Grupo: SIDIFICA -->
            <p class="px-3 py-2 text-xs font-semibold uppercase tracking-wider text-slate-400">Sidifoca</p>
            <ul class="space-y-1">
                <li>
                    <button class="w-full flex items-center justify-between gap-3 px-3 py-2 rounded-md hover:bg-slate-800/80"
                            data-accordion="toggle" aria-expanded="false" aria-controls="grp-admin">
        <span class="flex items-center gap-3">
          <i data-lucide="shield-check" class="h-5 w-5 text-slate-400"></i>
          <span class="text-sm">Gestión administrador</span>
        </span>
                        <i data-lucide="chevron-down" class="h-4 w-4 text-slate-400 caret"></i>
                    </button>
                    <ul id="grp-admin" class="mt-1 hidden pl-11 space-y-1" role="region">
                        <li><a href="#administrados" class="flex items-center gap-2 px-3 py-2 rounded-md hover:bg-slate-800/80 text-sm"><i data-lucide="users" class="h-4 w-4 text-slate-400"></i> Administrados</a></li>
                        <li><a href="#perfil" class="flex items-center gap-2 px-3 py-2 rounded-md hover:bg-slate-800/80 text-sm"><i data-lucide="id-card" class="h-4 w-4 text-slate-400"></i> Perfil</a></li>
                    </ul>
                </li>

                <li>
                    <button class="w-full flex items-center justify-between gap-3 px-3 py-2 rounded-md hover:bg-slate-800/80"
                            data-accordion="toggle" aria-expanded="false" aria-controls="grp-fases">
        <span class="flex items-center gap-3">
          <i data-lucide="workflow" class="h-5 w-5 text-slate-400"></i>
          <span class="text-sm">Fases</span>
        </span>
                        <i data-lucide="chevron-down" class="h-4 w-4 text-slate-400 caret"></i>
                    </button>
                    <ul id="grp-fases" class="mt-1 hidden pl-11 space-y-1" role="region">
                        <li><a href="#admision" class="flex items-center gap-2 px-3 py-2 rounded-md hover:bg-slate-800/80 text-sm"><i data-lucide="user-plus" class="h-4 w-4 text-slate-400"></i> Admisión (Fase 1)</a></li>
                        <li><a href="#preseleccion" class="flex items-center gap-2 px-3 py-2 rounded-md hover:bg-slate-800/80 text-sm"><i data-lucide="list-checks" class="h-4 w-4 text-slate-400"></i> Pre Selección (Fase 2)</a></li>
                        <li><a href="#finalista" class="flex items-center gap-2 px-3 py-2 rounded-md hover:bg-slate-800/80 text-sm"><i data-lucide="trophy" class="h-4 w-4 text-slate-400"></i> Finalista (Fase 3)</a></li>
                    </ul>
                </li>

                <li>
                    <a href="#mantenimientos" class="group flex items-center gap-3 px-3 py-2 rounded-md hover:bg-slate-800/80">
                        <i data-lucide="wrench" class="h-5 w-5 text-slate-400 group-hover:text-slate-200"></i>
                        <span class="text-sm">Mantenimientos</span>
                    </a>
                </li>

                <li>
                    <a href="#reporte-postulacion" class="group flex items-center gap-3 px-3 py-2 rounded-md hover:bg-slate-800/80">
                        <i data-lucide="clipboard-list" class="h-5 w-5 text-slate-400 group-hover:text-slate-200"></i>
                        <span class="text-sm">Reporte de postulación</span>
                    </a>
                </li>

                <li>
                    <button class="w-full flex items-center justify-between gap-3 px-3 py-2 rounded-md hover:bg-slate-800/80"
                            data-accordion="toggle" aria-expanded="false" aria-controls="grp-reportesaula">
        <span class="flex items-center gap-3">
          <i data-lucide="book-open" class="h-5 w-5 text-slate-400"></i>
          <span class="text-sm">Reportes Aula</span>
        </span>
                        <i data-lucide="chevron-down" class="h-4 w-4 text-slate-400 caret"></i>
                    </button>
                    <ul id="grp-reportesaula" class="mt-1 hidden pl-11 space-y-1" role="region">
                        <li><a href="#reporte-estrategias" class="flex items-center gap-2 px-3 py-2 rounded-md hover:bg-slate-800/80 text-sm"><i data-lucide="target" class="h-4 w-4 text-slate-400"></i> Reporte de estrategias</a></li>
                        <li><a href="#reporte-foros" class="flex items-center gap-2 px-3 py-2 rounded-md hover:bg-slate-800/80 text-sm"><i data-lucide="messages-square" class="h-4 w-4 text-slate-400"></i> Reporte de foros</a></li>
                    </ul>
                </li>

                <li>
                    <a href="#configuracion" class="group flex items-center gap-3 px-3 py-2 rounded-md hover:bg-slate-800/80">
                        <i data-lucide="settings" class="h-5 w-5 text-slate-400 group-hover:text-slate-200"></i>
                        <span class="text-sm">Configuración</span>
                    </a>
                </li>
            </ul>
        </nav>


        <!-- Footer sidebar (opcional) -->
        <div class="p-3 border-t border-slate-800 text-xs text-slate-400">
            v2.0 · © MINEDU
        </div>
    </aside>

    <!-- Sidebar móvil (drawer) -->
    <div id="mobile-drawer" class="fixed inset-0 z-40 hidden" aria-hidden="true">
        <!-- backdrop -->
        <div class="absolute inset-0 bg-slate-900/50" data-drawer="close"></div>
        <!-- panel -->
        <div class="absolute inset-y-0 left-0 w-72 bg-slate-900 text-slate-200 border-r border-slate-800 p-3 flex flex-col">
            <div class="flex items-center justify-between h-14 px-1">
                <div class="flex items-center gap-2">
                    <div class="h-9 w-9 rounded-md bg-indigo-500/20 ring-1 ring-indigo-500/30 flex items-center justify-center">
                        <svg class="h-5 w-5 text-indigo-300" viewBox="0 0 24 24" fill="currentColor"><path d="M11 3a1 1 0 0 1 2 0v8h8a1 1 0 1 1 0 2h-8v8a1 1 0 1 1-2 0v-8H3a1 1 0 1 1 0-2h8V3z"/></svg>
                    </div>
                    <span class="font-semibold">Plataforma</span>
                </div>
                <button class="p-2 rounded-sm hover:bg-slate-800" data-drawer="close" aria-label="Cerrar menú">

                    <a href="{{ route('intranet.cerrar_sesion') }}"><svg class="h-5 w-5 text-slate-300" viewBox="0 0 24 24" fill="currentColor"><path d="M6 18 18 6M6 6l12 12"/></svg></a>
                </button>
            </div>
            <div class="mt-2 flex-1 overflow-y-auto thin-scroll">
                <!-- Clonaremos el contenido del nav desktop por JS para mantener una sola fuente -->
                <nav id="mobile-nav"></nav>
            </div>
        </div>
    </div>

    <!-- Main (header + content) -->
    <section class="flex-1 flex flex-col min-w-0">
        <!-- Header -->
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 sm:px-6">
            <div class="flex items-center gap-2">
                <!-- Hamburguesa (móvil) -->
                <button id="btn-open-drawer" class="lg:hidden p-2 rounded-sm hover:bg-slate-100" aria-label="Abrir menú">
                    <svg class="h-6 w-6 text-slate-700" viewBox="0 0 24 24" fill="currentColor"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <div class="min-w-0">
                    <h1 class="text-sm font-semibold text-slate-700 hidden sm:block">Panel principal</h1>
                    <nav class="text-xs text-slate-500">
                        <ol class="flex items-center gap-1">
                            <li><a class="hover:text-slate-700" href="#">Inicio</a></li>
                            <li>/</li>
                            <li class="text-slate-700">Dashboard</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <!-- Acciones derecha -->
            <div class="flex items-center gap-2">
                <!-- Notificaciones -->
                <button class="relative p-2 rounded-sm hover:bg-slate-100" aria-label="Notificaciones">
                    <svg class="h-5 w-5 text-slate-700" viewBox="0 0 24 24" fill="currentColor"><path d="M12 22a2 2 0 0 0 2-2H10a2 2 0 0 0 2 2Zm6-6V11a6 6 0 1 0-12 0v5L4 18v1h16v-1l-2-2Z"/></svg>
                    <span class="absolute -top-0.5 -right-0.5 h-2 w-2 rounded-full bg-indigo-500 ring-2 ring-white"></span>
                </button>

                <!-- Usuario (dropdown) -->
                <div class="relative" id="user-menu">
                    <button class="flex items-center gap-2 rounded-full pl-1 pr-3 py-1 hover:bg-slate-100" data-menu="button" aria-expanded="false" aria-haspopup="menu">
                        <img class="h-8 w-8 rounded-full ring-2 ring-white" src="https://i.pravatar.cc/80?img=5" alt="Avatar usuario" />
                        <span class="hidden sm:block text-sm font-medium text-slate-700">{{Auth::user()->nombres}}</span>
                        <svg class="h-4 w-4 text-slate-500" viewBox="0 0 20 20" fill="currentColor"><path d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.24a.75.75 0 0 1-1.06 0L5.21 8.29a.75.75 0 0 1 .02-1.08z"/></svg>
                    </button>
                    <div class="hidden absolute right-0 mt-2 w-56 bg-white rounded-md shadow-lg ring-1 ring-black/5 p-1 z-10" role="menu" aria-label="Menú de usuario" data-menu="items">
                        <a href="#ver-perfil" role="menuitem" class="flex items-center gap-2 px-3 py-2 rounded-md hover:bg-slate-50">
                            <svg class="h-5 w-5 text-slate-600" viewBox="0 0 24 24" fill="currentColor"><path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5Zm0 2c-4 0-8 2-8 5v1h16v-1c0-3-4-5-8-5Z"/></svg>
                            Ver perfil
                        </a>
                        <a href="#preferencias" role="menuitem" class="flex items-center gap-2 px-3 py-2 rounded-md hover:bg-slate-50">
                            <svg class="h-5 w-5 text-slate-600" viewBox="0 0 24 24" fill="currentColor"><path d="M12 8a4 4 0 1 1-4 4 4 4 0 0 1 4-4Zm8 4a8 8 0 1 1-8-8 8 8 0 0 1 8 8Z"/></svg>
                            Preferencias
                        </a>
                        <div class="my-1 h-px bg-slate-100"></div>
                        <a href="#cerrar-sesion" role="menuitem" class="flex items-center gap-2 px-3 py-2 rounded-md hover:bg-rose-50 text-rose-600">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M16 13v-2H7V7l-5 5 5 5v-4h9Zm3-10h-8a2 2 0 0 0-2 2v3h2V5h8v14h-8v-3H9v3a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2Z"/></svg>
                            Cerrar sesión
                        </a>

                    </div>
                </div>
            </div>
        </header>

        <!-- Contenido -->
        <main class="flex-1 overflow-y-auto p-4 sm:p-3" id="content-html">
            @yield('content')
        </main>
    </section>
</div>



<script>
    function initDatepickers(root = document) {
        lucide.createIcons();

        const nodes = root.querySelectorAll('[data-datepicker]:not([data-dp-inited="1"])');

        nodes.forEach((el) => {
            // Si hay otro datepicker (jQuery UI) destrúyelo
            if (window.jQuery && jQuery.fn.datepicker) {
                try { jQuery(el).datepicker('destroy'); } catch (e) {}
            }

            // Evita errores si la clase no existe aún
            if (typeof Datepicker === 'undefined') {
                console.error('Flowbite Datepicker no está cargado.');
                return;
            }

            // Inicializa (usa selector string en container)
            new Datepicker(el, {
                autohide: true,
                format: 'yyyy-mm-dd',
                container: 'body'
            });

            // Marca como inicializado
            el.setAttribute('data-dp-inited', '1');
        });
    }

    // 1) Inicial al cargar la página
    document.addEventListener('DOMContentLoaded', function () {
        initDatepickers(document);
    });

    // 2) Si usas HTMX: re-inicializa tras cada swap
    document.body.addEventListener('htmx:afterSwap', function (evt) {
        // evt.target es el contenedor donde HTMX hizo el swap
        initDatepickers(evt.target);
    });

    // 3) Si también usas jQuery AJAX clásico:
    if (window.jQuery) {
        jQuery(document).ajaxComplete(function (_evt, _xhr, _settings) {
            initDatepickers(document);
        });
    }

    // 4) (Opcional) Si insertas en modales Bootstrap:
    document.addEventListener('shown.bs.modal', function (evt) {
        initDatepickers(evt.target);
    });
</script>

<!-- JS mínimo para interacciones -->
<script src="/assets/js/base.js?<?php echo time();?>"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
@yield('script')
</body>
</html>
