<ul class="metismenu" id="side-menu">

    <li>
        <a href="{{ route('dashboard') }}">
            <i class="fas fa-home"></i>
            <span> Dashboard </span>
        </a>
    </li>

    <li>
        <a href="javascript: void(0);">
            <i class="fas fa-user-friends"></i>
            <span> Empleados </span>
            <span class="menu-arrow"></span>
        </a>
        <ul class="nav-second-level" aria-expanded="false">
            <li>
                <a href="{{ route('dashboard.administrativos') }}">Administrativos</a>
            </li>
            <li>
                <a href="{{ route('dashboard.entrenadores') }}">Entrenadores</a>
            </li>
        </ul>
    </li>

    <li>
        <a href="javascript: void(0);">
            <i class="fas fa-users"></i>
            <span> Clientes </span>
            <span class="menu-arrow"></span>
        </a>
        <ul class="nav-second-level" aria-expanded="false">
            <li>
                <a href="layouts-sidebar-sm.html">Agregar Cliente</a>
            </li>
            <li>
                <a href="layouts-light-sidebar.html">Lista de Clientes</a>
            </li>
        </ul>
    </li>

    <li>
        <a href="javascript: void(0);">
            <i class="fas fa-book"></i>
            <span> Inscripciones </span>
            <span class="menu-arrow"></span>
        </a>
        <ul class="nav-second-level" aria-expanded="false">
            <li>
                <a href="email-inbox.html">Realizar Inscripción</a>
            </li>
            <li>
                <a href="email-read.html">Lista de Inscripciones</a>
            </li>
        </ul>
    </li>

    <li>
        <a class="link-underline-opacity-0" href="javascript: void(0);">
            <i class="fas fa-clipboard"></i>
            <span> Alquileres </span>
            <span class="menu-arrow"></span>
        </a>
        <ul class="nav-second-level" aria-expanded="false">
            <li>
                <a href="email-inbox.html">Realizar Alquiler</a>
            </li>
            <li>
                <a href="email-read.html">Lista de Alquileres</a>
            </li>
        </ul>
    </li>

    <li>
        <a href="javascript: void(0);">
            <i class="far fa-money-bill-alt"></i>
            <span> Pagos </span>
            <span class="menu-arrow"></span>
        </a>
        <ul class="nav-second-level" aria-expanded="false">
            <li>
                <a href="pages-starter.html">Agregar Pago</a>
            </li>
            <li>
                <a href="pages-login.html">Lista de Pagos</a>
            </li>
        </ul>
    </li>

    <li>
        <a href="javascript: void(0);">
            <i class="fas fa-file-alt"></i>
            <span> Facturas </span>
            <span class="menu-arrow"></span>
        </a>
        <ul class="nav-second-level" aria-expanded="false">
            <li>
                <a href="pages-starter.html">Lista de Facturas</a>
            </li>
        </ul>
    </li>

    <li>
        <a href="javascript: void(0);">
            <i class="fas fa-id-card-alt"></i>
            <span> Asistencia </span>
        </a>
    </li>

    <li>
        <a href="javascript: void(0);">
            <i class="fas fa-dumbbell"></i>
            <span> Disciplinas </span>
            <span class="menu-arrow"></span>
        </a>
        <ul class="nav-second-level" aria-expanded="false">
            <li>
                <a href="{{ route('dashboard.disciplinas') }}">Lista de Disciplinas</a>
            </li>
            <li>
                <a href="{{ route('dashboard.grupos') }}">Grupos</a>
            </li>
            <li>
                <a href="{{ route('dashboard.horarios') }}">Horarios</a>
            </li>
        </ul>
    </li>

    <li>
        <a href="javascript: void(0);">
            <i class="fas fa-archive"></i>
            {{-- <i class="fas fa-gift"></i> --}}
            <span> Paquetes </span>
            <span class="menu-arrow"></span>
        </a>
        <ul class="nav-second-level" aria-expanded="false">
            <li>
                <a href="#">Lista de Paquetes</a>
            </li>
            <li>
                <a href="#">Duraciones</a>
            </li>
        </ul>
    </li>

    <li>
        <a href="javascript: void(0);">
            {{-- <i class="fas fa-warehouse"></i> --}}
            <i class="fas fa-th-list"></i>
            <span> Secciones </span>
            <span class="menu-arrow"></span>
        </a>
        <ul class="nav-second-level" aria-expanded="false">
            <li>
                <a href="{{ route('dashboard.secciones') }}">Lista de Secciones</a>
            </li>
            <li>
                <a href="{{ route('dashboard.maquinas') }}">Máquinas o Equipos</a>
            </li>
        </ul>
    </li>

    <li>
        <a href="javascript: void(0);">
            {{-- <i class="fas fa-cube"></i> --}}
            <i class="fas fa-dice-d6"></i>
            <span> Casilleros </span>
            <span class="menu-arrow"></span>
        </a>
        <ul class="nav-second-level" aria-expanded="false">
            <li>
                <a href="extras-profile.html">Agregar Casillero</a>
            </li>
            <li>
                <a href="extras-timeline.html">Lista de Casilleros</a>
            </li>
        </ul>
    </li>

    <li>
        <a href="javascript: void(0);">
            <i class="fas fa-file-pdf"></i>
            <span> Reportes </span>
            <span class="menu-arrow"></span>
        </a>
        <ul class="nav-second-level" aria-expanded="false">
            <li>
                <a href="extras-profile.html">Facturas por Fechas</a>
            </li>
            <li>
                <a href="extras-profile.html">Pagos por Fechas</a>
            </li>
            <li>
                <a href="extras-timeline.html">Reporte de Inscripciones</a>
            </li>
            <li>
                <a href="extras-timeline.html">Reporte de Alquileres</a>
            </li>
        </ul>
    </li>

</ul>