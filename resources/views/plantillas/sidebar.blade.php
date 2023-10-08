<div class="slimscroll-menu">

    <!--- Sidemenu -->
    <div id="sidebar-menu">

        <ul class="metismenu" id="side-menu">

            <li>
                <a href="{{ route('dashboard') }}">
                    <i class="fas fa-home"></i>
                    <span> Dashboard </span>
                </a>
            </li>

            @if (verificarPermiso('Usuario_Listado'))
                <li>
                    <a href="{{ route('dashboard.usuarios') }}">
                        <i class="fas fa-user-cog"></i>
                        <span> Usuarios </span>
                    </a>
                </li>
            @endif
            
            @if (verificarPermiso('Rol_Listado'))
                <li>
                    <a href="javascript: void(0);">
                        <i class="fas fa-key"></i>
                        <span> Roles y Permisos </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li>
                            <a href="{{ route('dashboard.roles') }}">Roles</a>
                        </li>
                        @if (verificarPermiso('Permiso_Listado'))
                            <li>
                                <a href="{{ route('dashboard.permisos') }}">Permisos</a>
                            </li>
                        @endif
                        @if (verificarPermiso('AsignarPermiso_Listado'))
                            <li>
                                <a href="{{ route('dashboard.asignarPermiso') }}">Asignar Permisos</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            @if (verificarPermiso('Empleado_Listado'))
                <li>
                    <a href="javascript: void(0);">
                        <i class="fas fa-user-friends"></i>
                        <span> Empleados </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level" aria-expanded="false">
                        @if (verificarPermiso('Administrativo_Listado'))
                            <li>
                                <a href="{{ route('dashboard.administrativos') }}">Administrativos</a>
                            </li>
                        @endif
                        @if (verificarPermiso('Entrenador_Listado'))
                            <li>
                                <a href="{{ route('dashboard.entrenadores') }}">Entrenadores</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            
            @if (verificarPermiso('Cliente_Listado'))
                <li>
                    <a href="javascript: void(0);">
                        <i class="fas fa-users"></i>
                        <span> Clientes </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li>
                            <a href="{{ route('dashboard.clientes') }}">Lista de Clientes</a>
                        </li>
                        @if (verificarPermiso('CondicionFisica_Listado'))
                            <li>
                                <a href="{{ route('dashboard.condicionFisica') }}">Registrar Condición Física</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            @if (verificarPermiso('Inscripcion_Listado'))
                <li>
                    <a href="{{ route('dashboard.inscripciones') }}">
                        <i class="fas fa-book"></i>
                        <span> Inscripciones </span>
                    </a>
                </li>
            @endif

            @if (verificarPermiso('Alquiler_Listado'))
                <li>
                    <a href="{{ route('dashboard.alquileres') }}">
                        <i class="fas fa-clipboard"></i>
                        <span> Alquileres </span>
                    </a>
                </li>
            @endif

            @if (verificarPermiso('Pago_Listado'))
                <li>
                    <a href="{{ route('dashboard.pagos') }}">
                        <i class="far fa-money-bill-alt"></i>
                        <span> Pagos </span>
                    </a>
                </li>
            @endif

            @if (verificarPermiso('Asistencia_Listado'))
                <li>
                    <a href="{{ route('dashboard.asistencia') }}">
                        <i class="fas fa-id-card-alt"></i>
                        <span> Asistencia </span>
                    </a>
                </li>
            @endif

            @if (verificarPermiso('Disciplina_Listado'))
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
                        @if (verificarPermiso('Grupo_Listado'))
                            <li>
                                <a href="{{ route('dashboard.grupos') }}">Grupos</a>
                            </li>
                        @endif
                        @if (verificarPermiso('Horario_Listado'))
                            <li>
                                <a href="{{ route('dashboard.horarios') }}">Horarios</a>
                            </li>
                        @endif
                        @if (verificarPermiso('AsignarInstructor_Listado'))
                            <li>
                                <a href="{{ route('dashboard.asignarInstructor') }}">Asignar Instructor</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            @if (verificarPermiso('Paquete_Listado'))
                <li>
                    <a href="javascript: void(0);">
                        <i class="fas fa-archive"></i>
                        <span> Paquetes </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li>
                            <a href="{{ route('dashboard.paquetes') }}">Lista de Paquetes</a>
                        </li>
                        @if (verificarPermiso('Duracion_Listado'))
                            <li>
                                <a href="{{ route('dashboard.duraciones') }}">Duraciones</a>
                            </li>
                        @endif
                        @if (verificarPermiso('AsignarDuracion_Listado'))
                            <li>
                                <a href="{{ route('dashboard.asignarDuracion') }}">Asignar Duración</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            @if (verificarPermiso('Seccion_Listado'))
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
                        @if (verificarPermiso('Maquina_Listado'))
                            <li>
                                <a href="{{ route('dashboard.maquinas') }}">Máquinas o Equipos</a>
                            </li>
                        @endif
                        @if (verificarPermiso('AsignarMaquina_Listado'))
                            <li>
                                <a href="{{ route('dashboard.asignarMaquina') }}">Asignar Máquinas</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            @if (verificarPermiso('Casillero_Listado'))
                <li>
                    <a href="{{ route('dashboard.casilleros') }}">
                        {{-- <i class="fas fa-cube"></i> --}}
                        <i class="fas fa-dice-d6"></i>
                        <span> Casilleros </span>
                    </a>
                </li>
            @endif

            @if (verificarPermiso('Reporte_Listado'))
                <li>
                    <a href="javascript: void(0);">
                        <i class="fas fa-file-pdf"></i>
                        <span> Reportes </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li>
                            <a href="{{ route('dashboard.reporteInscripcion') }}">Reporte de Inscripciones</a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.reporteAlquiler') }}">Reporte de Alquileres</a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.reportePago') }}">Reporte de Pagos</a>
                        </li>
                        {{-- <li>
                            <a href="{{ route('dashboard.reporteFactura') }}">Reporte de Facturas</a>
                        </li> --}}
                        <li>
                            <a href="{{ route('dashboard.reporteAsistencia') }}">Reporte de Asistencias</a>
                        </li>
                    </ul>
                </li>
            @endif

            @if (verificarPermiso('Bitacora_Listado'))
                <li>
                    <a href="{{ route('dashboard.bitacora') }}">
                        <i class="fas fa-history"></i>
                        <span> Registro de Actividad </span>
                    </a>
                </li>
            @endif

        </ul>

    </div>
    <!-- End Sidebar -->

    <div class="clearfix"></div>

</div>
<!-- Sidebar -left -->


