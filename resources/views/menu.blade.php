
<ul class="metismenu" id="menu">
    <li class="menu-label">SIDIFOCA</li>
    @foreach (Session::get('arr_menu', collect()) as $index => $parent)
        @if($parent->children->isNotEmpty())
            <li>
                <a class="has-arrow" href="javascript:;">
                    <div class="parent-icon icon-color-{{$index+1}}"><i class="{{ $parent->icono }}"></i>
                    </div>
                    <div class="menu-title">{{ $parent->descripcion }}</div>
                </a>
                <ul>
                    @foreach ($parent->children as $menu)
                    <li> <a href="{{ route($menu->ruta) }}"><i class="bx bx-right-arrow-alt"></i>{{ $menu->descripcion }}</a>
                    </li>
                    @endforeach
                </ul>
            </li>
        @else
            <li>
                <a href="{{ route($parent->ruta) }}">
                    <div class="parent-icon icon-color-{{$index+1}}"> <i class="{{ $parent->icono }}"></i>
                    </div>
                    <div class="menu-title">{{ $parent->descripcion }}</div>
                </a>
            </li>
        @endif
    @endforeach
    @if(Auth::user()->flg_usu_admin)
        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon icon-color-3"><i class="bx bx-lock"></i>
                </div>
                <div class="menu-title">Configuración</div>
            </a>
            <ul>
                <li> <a href="{{ route('modulo') }}"><i class="bx bx-right-arrow-alt"></i>Modulos</a>
                </li>
                <li> <a href="{{ route('permiso') }}"><i class="bx bx-right-arrow-alt"></i>Permisos</a>
                </li>
                <li> <a href="{{ route('menu') }}"><i class="bx bx-right-arrow-alt"></i>Menus</a>
                </li>
            </ul>
        </li>
    @endif
</ul>






{{--<div class="navmenu navmenu-inverse navmenu-fixed-left offcanvas-sm">--}}
{{--    <a class="navmenu-brand visible-md visible-lg" href="{{ route('intranet') }}">--}}
{{--        <img src="{{ asset('images/header-logo-custom1.png') }}" alt="" width="100%">--}}
{{--    </a>--}}

{{--    <ul class="nav navmenu-nav" id="metismenu">--}}


{{--        <li>--}}
{{--            <a href="{{ route('intranet.cerrar_sesion') }}"><i class="fa fa-power-off fa-fw"></i> Cerrar la sesión</a>--}}
{{--        </li>--}}
{{--    </ul>--}}
{{--    <a class="navmenu-brand visible-md visible-lg" href="http://aula.edutalentos.pe/" target="_blank">--}}
{{--        <img src="{{ asset('images/chamilo.png') }}" alt="Aula virtual" class="img-responsive img-thumbnail" title="Aula virtual">--}}
{{--    </a>--}}
{{--</div>--}}
