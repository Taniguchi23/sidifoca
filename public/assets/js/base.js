// Drawer móvil
const btnOpenDrawer = document.getElementById('btn-open-drawer');
const drawer = document.getElementById('mobile-drawer');
const closeEls = drawer.querySelectorAll('[data-drawer="close"]');

btnOpenDrawer?.addEventListener('click', () => {
    // Clona el nav desktop dentro del móvil (una sola fuente)
    const desktopNav = document.querySelector('aside nav');
    const mobileNav = document.getElementById('mobile-nav');
    if (mobileNav && desktopNav && !mobileNav.hasChildNodes()) {
        mobileNav.appendChild(desktopNav.cloneNode(true));
    }
    drawer.classList.remove('hidden');
});
closeEls.forEach(el => el.addEventListener('click', () => drawer.classList.add('hidden')));

// Acordeones (sidebar)
function setupAccordions(root = document) {
    root.querySelectorAll('[data-accordion="toggle"]').forEach(btn => {
        btn.addEventListener('click', () => {
            const expanded = btn.getAttribute('aria-expanded') === 'true';
            btn.setAttribute('aria-expanded', String(!expanded));
            const panel = document.getElementById(btn.getAttribute('aria-controls'));
            if (panel) panel.classList.toggle('hidden', expanded);
        });
    });
}
setupAccordions(document);
// Si clonamos nav al móvil, también activamos acordeones dentro del clon
const mobileNavContainer = document.getElementById('mobile-nav');
const observer = new MutationObserver(() => setupAccordions(mobileNavContainer));
observer.observe(mobileNavContainer, { childList: true });

// User menu (header)
const userMenu = document.getElementById('user-menu');
const btnUser = userMenu.querySelector('[data-menu="button"]');
const menuItems = userMenu.querySelector('[data-menu="items"]');
btnUser.addEventListener('click', () => {
    const open = menuItems.classList.contains('hidden');
    btnUser.setAttribute('aria-expanded', String(open));
    menuItems.classList.toggle('hidden');
});
document.addEventListener('click', (e) => {
    if (!userMenu.contains(e.target)) {
        menuItems.classList.add('hidden');
        btnUser.setAttribute('aria-expanded', 'false');
    }
});

// Estado activo por hash (demo)
function setActiveByHash() {
    const links = document.querySelectorAll('aside a[href^="#"], #mobile-nav a[href^="#"]');
    links.forEach(a => a.setAttribute('aria-current', 'false'));
    const active = document.querySelectorAll(`a[href="${location.hash || '#'}"]`);
    active.forEach(a => a.setAttribute('aria-current', 'page'));
}
window.addEventListener('hashchange', setActiveByHash);
setActiveByHash();



document.body.addEventListener('htmx:afterSwap', (event) => {
    const url = event.detail.xhr.responseURL;

    if (url.indexOf('centroacademico/lista.php') > 0) {

        // Inicializa íconos y estado persistente
        const side = document.getElementById('eduta-nav');
        const btn  = document.getElementById('eduta-toggle');

        function setCollapsed(v) {
            side.dataset.collapsed = v ? 'true' : 'false';
            const collapsed = side.dataset.collapsed === 'true';
            btn.setAttribute('aria-pressed', collapsed);
            btn.setAttribute('aria-label', collapsed ? 'Expandir navegación' : 'Colapsar navegación');
            btn.innerHTML = `<i data-lucide="${collapsed ? 'chevrons-right' : 'chevrons-left'}" class="w-5 h-5 text-slate-600"></i>`;
            lucide.createIcons();
        }
        function activate(name) {

            panels.forEach(p => {
                p.classList.toggle('hidden', p.getAttribute('data-tab-panel') !== name);
            });
            tabButtons.forEach(btn => {
                const isActive = btn.getAttribute('data-tab-target') === name;
                btn.setAttribute('aria-selected', isActive ? 'true' : 'false');
                btn.classList.toggle('bg-white', isActive);
                btn.classList.toggle('text-slate-900', isActive);
                btn.classList.toggle('shadow-sm', isActive);
                btn.classList.toggle('ring-1', isActive);
                btn.classList.toggle('ring-slate-200', isActive);
                btn.classList.toggle('text-slate-600', !isActive);
            });
        }

        // Eventos
        btn.addEventListener('click', () => setCollapsed(!(side.dataset.collapsed === 'true')));


        const tabButtons = document.querySelectorAll('.tab-btn');
        const panels = document.querySelectorAll('[data-tab-panel]');

        tabButtons.forEach(btn => {
            btn.addEventListener('click', () => activate(btn.getAttribute('data-tab-target')));
        });
        // Estado inicial
        activate('recursos');



    }
    if (url.indexOf('calificaciones/lista.php') > 0) {

        lucide.createIcons();
        const $ = s=>document.querySelector(s);
        const $$ = s=>document.querySelectorAll(s);

        const tbl = $('#tbl-tasks');
        const btnDownload = $('#btn-download');
        const selCount = $('#sel-count');

        function updateDownloadState(){
            const selected = $$('.row-chk:checked').length;
            selCount.textContent = selected;
            btnDownload.disabled = selected === 0;
            btnDownload.classList.toggle('text-white', selected>0);
            btnDownload.classList.toggle('text-white/60', selected===0);
        }

        // Maestro en thead
        $('#chk-table-all').addEventListener('change', (e)=>{
            $$('.row-chk:not(:disabled)').forEach(chk => { chk.checked = e.target.checked; });
            updateDownloadState();
        });

        // Per-row change
        tbl.addEventListener('change', (e)=>{
            if(e.target.classList.contains('row-chk')) updateDownloadState();
        });

        // Filtros
        function applyFilters(){
            const code = $('#f-cod').value.trim().toUpperCase();
            const task = $('#f-task').value;
            $$('#tbl-tasks tbody tr').forEach(tr=>{
                const matchesTask = tr.getAttribute('data-task') === task;
                const matchesCode = !code || tr.getAttribute('data-task')?.includes(code);
                tr.classList.toggle('hidden', !(matchesTask && matchesCode));
                if (tr.classList.contains('hidden')) tr.querySelector('.row-chk')?.checked && (tr.querySelector('.row-chk').checked = false);
            });
            $('#chk-table-all').checked = false;
            updateDownloadState();
        }
        $('#btn-search').addEventListener('click', applyFilters);
        $('#f-task').addEventListener('change', applyFilters);
        $('#btn-clear').addEventListener('click', ()=>{ $('#f-cod').value=''; $('#f-task').selectedIndex=0; applyFilters(); });

        // Descargar paquete seleccionado (demo)
        btnDownload.addEventListener('click', ()=>{
            const items = [];
            $$('.row-chk:checked').forEach(chk=>{
                const tr = chk.closest('tr');
                items.push({task: tr.dataset.task, user: tr.dataset.user});
            });
            alert(`Preparando ZIP de ${items.length} envíos…`);
            console.log('ZIP seleccionado:', items);
        });

        // Acciones por fila: descargar / subir corrección
        const modalOne = $('#modal-upload-one');
        const u1File = $('#u1-file'), u1Send = $('#u1-send');
        function openUploadOne({name, task, user}){
            $('#u1-student').textContent = name;
            $('#u1-task').textContent = task;
            u1File.value = '';
            u1Send.disabled = true;
            modalOne.classList.remove('hidden');
            lucide.createIcons();
        }
        function closeUploadOne(){ modalOne.classList.add('hidden'); }

        // Delegación de eventos en tabla
        tbl.addEventListener('click', (e)=>{
            const btn = e.target.closest('button[data-action]');
            if(!btn) return;
            const tr = btn.closest('tr');
            const payload = { user: tr.dataset.user, name: tr.dataset.name, task: tr.dataset.task };

            if(btn.dataset.action === 'download'){
                // Aquí llamas tu endpoint para descargar el envío individual
                alert(`Descargar envío de ${payload.name} (${payload.user}) · ${payload.task}`);
                console.log('Descargar individual', payload);
            }
            if(btn.dataset.action === 'upload'){
                // Abrir modal de corrección individual
                openUploadOne(payload);
            }
        });

        // Modal individual: UX
        const u1Drop = $('#u1-drop');
        const clickInput = ()=>u1File.click();
        u1Drop.addEventListener('click', clickInput);
        ;['dragenter','dragover'].forEach(evt=>u1Drop.addEventListener(evt, e=>{e.preventDefault(); e.stopPropagation(); u1Drop.classList.add('ring-2','ring-indigo-200');}));
        ;['dragleave','drop'].forEach(evt=>u1Drop.addEventListener(evt, e=>{e.preventDefault(); e.stopPropagation(); u1Drop.classList.remove('ring-2','ring-indigo-200');}));
        u1Drop.addEventListener('drop', e=>{
            const f = e.dataTransfer.files?.[0]; if(f){ u1File.files = e.dataTransfer.files; u1Send.disabled = false; }
        });
        u1File.addEventListener('change', ()=>{ u1Send.disabled = !(u1File.files.length); });
        $('#u1-close').addEventListener('click', closeUploadOne);
        $('#u1-cancel').addEventListener('click', closeUploadOne);
        $('#u1-send').addEventListener('click', ()=>{
            const file = u1File.files[0]?.name || '(sin archivo)';
            const who = $('#u1-student').textContent, task = $('#u1-task').textContent;
            alert(`Subiendo corrección "${file}" para ${who} · ${task}`);
            // POST formData aquí…
            closeUploadOne();
        });

        // Modal ZIP masivo (se mantiene)
        const modalZip = $('#modal-upload'), dz = $('#drop-zone'), fzip = $('#file-zip');
        const openZip = ()=>{ modalZip.classList.remove('hidden'); lucide.createIcons(); };
        const closeZip = ()=>{ modalZip.classList.add('hidden'); fzip.value=''; $('#upload-send').disabled=true; };
        $('#btn-upload').addEventListener('click', openZip);
        $('#upload-close').addEventListener('click', closeZip);
        $('#upload-cancel').addEventListener('click', closeZip);
        ;['dragenter','dragover'].forEach(evt=>dz.addEventListener(evt, e=>{e.preventDefault(); e.stopPropagation(); dz.classList.add('ring-2','ring-indigo-200');}));
        ;['dragleave','drop'].forEach(evt=>dz.addEventListener(evt, e=>{e.preventDefault(); e.stopPropagation(); dz.classList.remove('ring-2','ring-indigo-200');}));
        dz.addEventListener('click', ()=>fzip.click());
        dz.addEventListener('drop', e=>{ const f=e.dataTransfer.files?.[0]; if(f && f.name.toLowerCase().endsWith('.zip')){ fzip.files=e.dataTransfer.files; $('#upload-send').disabled=false; }});
        fzip.addEventListener('change', ()=>{ $('#upload-send').disabled = !(fzip.files.length && fzip.files[0].name.toLowerCase().endsWith('.zip')); });
        $('#upload-send').addEventListener('click', ()=>{ const file=fzip.files[0]?.name||'correcciones.zip'; alert(`Subiendo ZIP: ${file}`); closeZip(); });

        // Carga inicial (primer option)
        applyFilters();


    }



    if (url.indexOf("mensajeria/plantillas.php") > 0){


        // --------- Demo data (in-memory) ----------
        const templates = [
            {
                id: 'tpl-1',
                nombre: 'Recordatorio 48h (Email)',
                canal: 'Email',
                asunto: '⏰ {{actividad.nombre}} vence en {{dias_restantes}} días',
                cuerpo: 'Hola {{usuario.nombres}},\nNo olvides entregar {{actividad.nombre}} antes del {{actividad.fecha_limite}}.\nIr a la actividad: {{enlace_actividad}}',
                estado: 'Activo',
                updated: '2025-03-15 10:21'
            },
            {
                id: 'tpl-2',
                nombre: 'Recordatorio 24h (WhatsApp)',
                canal: 'WhatsApp',
                asunto: '',
                cuerpo: '👋 Hola {{usuario.nombres}}, te recordamos que {{actividad.nombre}} vence el {{actividad.fecha_limite}}. Enlace: {{enlace_actividad}}',
                estado: 'Activo',
                updated: '2025-03-16 09:02'
            },
            {
                id: 'tpl-3',
                nombre: 'Día de vencimiento (SMS)',
                canal: 'SMS',
                asunto: '',
                cuerpo: 'Recordatorio: {{actividad.nombre}} vence hoy {{actividad.fecha_limite}}. {{enlace_actividad}}',
                estado: 'Inactivo',
                updated: '2025-03-12 18:44'
            },
            {
                id: 'tpl-4',
                nombre: 'Atraso 24h (Email)',
                canal: 'Email',
                asunto: '⚠️ {{actividad.nombre}} venció hace {{dias_restantes}} días',
                cuerpo: 'Estimado/a {{usuario.nombres}},\nLa actividad {{actividad.nombre}} venció el {{actividad.fecha_limite}}.\nContacta a {{docente.nombre}} si necesitas apoyo.',
                estado: 'Activo',
                updated: '2025-03-10 12:10'
            }
        ];

        // --------- Elements ----------
        const tbody = document.getElementById('tpl-tbody');
        const countEl = document.getElementById('tpl-count');
        const btnNew = document.getElementById('btn-new');
        const modal = document.getElementById('tpl-modal');
        const modalTitle = document.getElementById('tpl-modal-title');
        const btnClose = document.getElementById('tpl-close');
        const btnCancel = document.getElementById('tpl-cancel');
        const btnSave = document.getElementById('tpl-save');
        const btnTest = document.getElementById('btn-test');

        const fNombre = document.getElementById('f-nombre');
        const fCanal = document.getElementById('f-canal');
        const fEvento = document.getElementById('f-evento');
        const fValor = document.getElementById('f-valor');
        const fUnidad = document.getElementById('f-unidad');
        const fEstado = document.getElementById('f-estado');
        const fAsunto = document.getElementById('f-asunto');
        const grpAsunto = document.getElementById('grp-asunto');
        const fCuerpo = document.getElementById('f-cuerpo');
        const smsCounter = document.getElementById('sms-counter');
        const preview = document.getElementById('preview');
        const fPrueba = document.getElementById('f-prueba');

        const fltQ = document.getElementById('flt-q');
        const fltCanal = document.getElementById('flt-canal');
        const fltEvento = document.getElementById('flt-evento');
        const fltEstado = document.getElementById('flt-estado');
        const btnSearch = document.getElementById('btn-search');
        const btnClear = document.getElementById('btn-clear');

        let editingId = null;

        // --------- Helpers ----------
        const norm = s => (s||'').toLowerCase().normalize('NFD').replace(/\p{Diacritic}/gu,'');
        function renderTable(list){
            tbody.innerHTML = list.map(t => {
                const canalTag = t.canal === 'Email' ? 'bg-indigo-50 text-indigo-700' :
                    t.canal === 'WhatsApp' ? 'bg-emerald-50 text-emerald-700' :
                        'bg-sky-50 text-sky-700';
                const estadoTag = t.estado === 'Activo' ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-700';
                const resumen = t.canal === 'Email' ? (t.asunto || '—') : (t.cuerpo?.slice(0,60) + (t.cuerpo?.length>60?'…':''));
                return `
        <tr class="hover:bg-slate-50/60" data-id="${t.id}">
          <td class="px-4 py-2">${t.nombre}</td>
          <td class="px-4 py-2"><span class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 ${canalTag}">
            ${t.canal}
          </span></td>
          <td class="px-4 py-2">${resumen}</td>
          <td class="px-4 py-2">${t.updated}</td>
          <td class="px-4 py-2"><span class="inline-flex rounded-full px-2 py-0.5 ${estadoTag}">${t.estado}</span></td>
          <td class="px-4 py-2">
            <div class="inline-flex items-center gap-2">
              <button class="btn-edit p-1 rounded-md hover:bg-slate-100" title="Editar"><i data-lucide="square-pen" class="h-4 w-4 text-slate-600"></i></button>
              <button class="btn-clone p-1 rounded-md hover:bg-slate-100" title="Clonar"><i data-lucide="copy" class="h-4 w-4 text-slate-600"></i></button>
              <button class="btn-delete p-1 rounded-md hover:bg-slate-100" title="Eliminar"><i data-lucide="trash-2" class="h-4 w-4 text-slate-600"></i></button>
            </div>
          </td>
        </tr>`;
            }).join('');
            countEl.textContent = list.length;
            lucide.createIcons();
        }

        function currentFilters(){
            return {
                q: norm(fltQ.value),
                canal: fltCanal.value,
                evento: fltEvento.value,
                estado: fltEstado.value
            };
        }

        function applyFilters(){
            const f = currentFilters();
            const out = templates.filter(t => {
                if (f.canal && t.canal !== f.canal) return false;
                if (f.evento && t.evento !== f.evento) return false;
                if (f.estado && t.estado !== f.estado) return false;
                const hay = `${t.nombre} ${t.asunto} ${t.cuerpo}`.toLowerCase();
                return !f.q || norm(hay).includes(f.q);
            });
            renderTable(out);
        }

        function openModal(data){
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');

            if (data){
                editingId = data.id;
                modalTitle.textContent = 'Editar plantilla';
                fNombre.value = data.nombre || '';
                fCanal.value = data.canal || 'Email';
                fEvento.value = data.evento || 'Actividad por vencer';
                fValor.value = data.valor ?? 24;
                fUnidad.value = data.unidad || 'horas';
                fEstado.value = data.estado || 'Activo';
                fAsunto.value = data.asunto || '';
                fCuerpo.value = data.cuerpo || '';
            } else {
                editingId = null;
                modalTitle.textContent = 'Nueva plantilla';
                fNombre.value = '';
                fCanal.value = 'Email';
                fEvento.value = 'Actividad por vencer';
                fValor.value = 24;
                fUnidad.value = 'horas';
                fEstado.value = 'Activo';
                fAsunto.value = '⏰ {{actividad.nombre}} vence en {{dias_restantes}} días';
                fCuerpo.value = 'Hola {{usuario.nombres}}, recuerda que {{actividad.nombre}} vence el {{actividad.fecha_limite}}.\nIr a la actividad: {{enlace_actividad}}';
            }
            onCanalChange();
            updatePreview();
            lucide.createIcons();
        }

        function closeModal(){
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        function onCanalChange(){
            const canal = fCanal.value;
            // Asunto solo para Email
            grpAsunto.classList.toggle('hidden', canal !== 'Email');
            // SMS contador
            smsCounter.classList.toggle('hidden', canal !== 'SMS');
            if (canal === 'SMS') updateSmsCounter();
        }

        function sampleData() {
            return {
                'usuario.nombres': 'María',
                'usuario.apellidos': 'López',
                'usuario.documento': '12345678',
                'curso.nombre': 'Evaluación formativa',
                'actividad.nombre': 'Tarea 1',
                'actividad.fecha_limite': '2025-03-28 23:59',
                'dias_restantes': '1',
                'enlace_actividad': 'https://edutalentos.edu/a/xyz',
                'docente.nombre': 'Carla Ríos',
                'plataforma.nombre': 'Edutalentos',
                'plataforma.url': 'https://edutalentos.edu'
            };
        }

        function renderTemplate(str, dict){
            return (str||'').replace(/\{\{\s*([^\}]+)\s*\}\}/g, (_, key) => dict[key.trim()] ?? `{{${key}}}`);
        }

        function updatePreview(){
            const dict = sampleData();
            const canal = fCanal.value;
            const asunto = renderTemplate(fAsunto.value, dict);
            const cuerpo = renderTemplate(fCuerpo.value, dict);
            if (canal === 'Email'){
                preview.innerHTML = `Asunto: <strong>${asunto || '—'}</strong>\n\n${cuerpo || ''}`;
            } else {
                preview.textContent = cuerpo || '';
            }
        }

        function updateSmsCounter(){
            const len = (fCuerpo.value || '').length;
            smsCounter.textContent = `${len} / 160`;
            smsCounter.classList.toggle('text-rose-600', len > 160);
        }

        // Insert variable chip en cursor
        document.querySelectorAll('.var-chip').forEach(btn => {
            btn.addEventListener('click', () => {
                const v = btn.textContent.trim();
                const el = fCuerpo;
                const start = el.selectionStart, end = el.selectionEnd;
                const before = el.value.slice(0, start);
                const after = el.value.slice(end);
                el.value = before + v + after;
                el.focus();
                el.selectionStart = el.selectionEnd = start + v.length;
                updatePreview();
                if (fCanal.value === 'SMS') updateSmsCounter();
            });
        });

        // Events
        btnNew.addEventListener('click', () => openModal(null));
        btnClose.addEventListener('click', closeModal);
        btnCancel.addEventListener('click', closeModal);
        modal.addEventListener('click', (e)=>{ if(e.target===modal) closeModal(); });

        fCanal.addEventListener('change', onCanalChange);
        fAsunto.addEventListener('input', updatePreview);
        fCuerpo.addEventListener('input', () => { updatePreview(); if (fCanal.value==='SMS') updateSmsCounter(); });

        btnSave.addEventListener('click', (e)=>{
            e.preventDefault();
            const data = {
                id: editingId || `tpl-${Date.now()}`,
                nombre: fNombre.value.trim(),
                canal: fCanal.value,
                evento: fEvento.value,
                valor: Number(fValor.value || 0),
                unidad: fUnidad.value,
                estado: fEstado.value,
                asunto: fAsunto.value,
                cuerpo: fCuerpo.value,
                updated: new Date().toISOString().slice(0,16).replace('T',' ')
            };
            if (!data.nombre) { alert('Ingresa un nombre'); return; }

            if (editingId){
                const idx = templates.findIndex(t=>t.id===editingId);
                if (idx>-1) templates[idx] = data;
            } else {
                templates.unshift(data);
            }

            applyFilters();
            closeModal();

            // TODO: Reemplazar por HTMX / fetch a tu API
            // htmx.ajax('POST','/api/plantillas', {values: data})
        });

        btnTest.addEventListener('click', (e)=>{
            e.preventDefault();
            const canal = fCanal.value;
            const destino = fPrueba.value.trim();
            if (!destino) { alert('Ingresa correo o teléfono de prueba'); return; }
            // TODO: Integrar envío de prueba
            alert(`(Demo) Enviando prueba por ${canal} a: ${destino}`);
        });

        // acciones tabla (delegation)
        tbody.addEventListener('click', (e)=>{
            const row = e.target.closest('tr');
            if (!row) return;
            const id = row.dataset.id;
            const tpl = templates.find(t=>t.id===id);
            if (!tpl) return;

            if (e.target.closest('.btn-edit')) {
                openModal(tpl);
            } else if (e.target.closest('.btn-clone')) {
                const clone = {...tpl, id: `tpl-${Date.now()}`, nombre: tpl.nombre + ' (copia)', updated: new Date().toISOString().slice(0,16).replace('T',' ')};
                templates.unshift(clone);
                applyFilters();
            } else if (e.target.closest('.btn-delete')) {
                if (confirm('¿Eliminar plantilla?')) {
                    const idx = templates.findIndex(t=>t.id===id);
                    if (idx>-1) templates.splice(idx,1);
                    applyFilters();
                }
            }
        });

        // filtros
        function doSearch(){ applyFilters(); }
        btnSearch.addEventListener('click', doSearch);
        [fltQ, fltCanal, fltEvento, fltEstado].forEach(el => el.addEventListener('change', doSearch));
        fltQ.addEventListener('keydown', (e)=>{ if(e.key==='Enter'){ e.preventDefault(); doSearch(); }});
        btnClear.addEventListener('click', ()=>{
            fltQ.value=''; fltCanal.value=''; fltEvento.value=''; fltEstado.value='';
            applyFilters();
        });

        // inicial
        applyFilters();
    }




    try { lucide.createIcons(); } catch(e){}



    (function () {
        const nav = document.getElementById('eduta-nav');
        const search = document.getElementById('tree-search');
        const tree = nav.querySelector('nav');

        // Guarda el estado inicial de 'open' para restaurarlo al limpiar
        const allDetails = Array.from(tree.querySelectorAll('details'));
        allDetails.forEach(d => d.dataset.initialOpen = d.open ? '1' : '0');

        // Mensaje "Sin resultados"
        const empty = document.createElement('div');
        empty.id = 'tree-empty';
        empty.className = 'hidden text-center text-xs text-slate-500 py-3';
        empty.textContent = 'Sin resultados';
        tree.appendChild(empty);

        // Normaliza texto (quita acentos y baja a minúsculas)
        const norm = s => (s || '')
            .toLowerCase()
            .normalize('NFD')
            .replace(/\p{Diacritic}/gu, '')
            .trim();

        // Filtrado
        let timer;
        function runFilter() {
            const q = norm(search.value);

            const lis = Array.from(tree.querySelectorAll('ul > li'));
            const details = Array.from(tree.querySelectorAll('details'));
            const links = Array.from(tree.querySelectorAll('a'));
            const summaries = Array.from(tree.querySelectorAll('summary'));

            // Reset
            lis.forEach(li => li.classList.remove('hidden'));
            details.forEach(d => {
                d.classList.remove('hidden');
                d.open = d.dataset.initialOpen === '1';
            });
            empty.classList.add('hidden');

            if (!q) {
                try { lucide.createIcons(); } catch(e){}
                return;
            }

            // Oculta todo; luego iremos revelando lo que coincida
            lis.forEach(li => li.classList.add('hidden'));
            details.forEach(d => d.classList.add('hidden'));

            let found = 0;

            // 1) Coincidencias en <a> (cursos/hojas)
            links.forEach(a => {
                if (norm(a.textContent).includes(q)) {
                    found++;
                    const li = a.closest('li');
                    if (li) li.classList.remove('hidden');

                    // Muestra y abre ancestros <details>
                    let d = a.closest('details');
                    while (d) {
                        d.classList.remove('hidden');
                        d.open = true;
                        d = d.parentElement?.closest('details');
                    }
                }
            });

            // 2) Coincidencias en <summary> (años, periodos, categorías)
            summaries.forEach(sum => {
                if (norm(sum.textContent).includes(q)) {
                    const d = sum.closest('details');
                    if (d) {
                        found++;
                        d.classList.remove('hidden');
                        d.open = true;
                        // Muestra todo su subárbol
                        d.querySelectorAll('li').forEach(li => li.classList.remove('hidden'));
                        // Y muestra/abre sus ancestros
                        let p = d.parentElement?.closest('details');
                        while (p) {
                            p.classList.remove('hidden');
                            p.open = true;
                            p = p.parentElement?.closest('details');
                        }
                    }
                }
            });

            if (!found) empty.classList.remove('hidden');
            try { lucide.createIcons(); } catch(e){}
        }

        // Debounce para tecleo
        search.addEventListener('input', () => {
            clearTimeout(timer);
            timer = setTimeout(runFilter, 120);
        });

        // ESC limpia el buscador
        search.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                search.value = '';
                runFilter();
            }
        });
    })();












});
