<div>

    <style>
        .nav-pills .nav-link.active {
            background-color: #3C444D; 
            color: #ffffff; 
        }
    </style>

    <div class="card-box p-1 mb-2">
        <div class="d-flex justify-content-between align-items-center">
            {{-- <h4 class="header-title m-0 px-2">Perfil de Cliente</h4> --}}
            <div class="page-title-right">
                <ol class="breadcrumb m-0 px-2 py-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active">{{ $subtitle }}</li>
                </ol>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="javascript:void(0);" class="dropdown-item notify-item" onclick="this.closest('form').submit()">
                    <i class="fe-log-out"></i>
                    <span>Cerrar Sesión</span>
                </a>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3 col-xl-3">
            <div class="card-box">
                <div class="row justify-content-center">
                    <img src="{{ asset('assets/images/users/user-3.jpg') }}" class="rounded-circle avatar-lg img-thumbnail" style="width: 120px; height: 120px;" alt="profile-image">
                </div>
                <div class="row text-center w-100">
                    <h4 class="mb-0 w-100"><b>{{ $nombreCompleto }}</b></h4>
                </div>

                <hr>

                <div class="row">
                    <ul class="nav nav-pills navtab-bg w-100 px-2 py-1">
                        <li class="nav-item w-100">
                            <a href="#informacion" wire:click="changeTabs('informacion', 'Información Personal')" 
                            {{-- wire:click="$set('activeTab', 'informacion')"  --}}
                            data-toggle="tab" aria-expanded="true" class="nav-link {{ $activeTab === 'informacion' ? 'active' : '' }}">
                                <i class="fas fa-user mr-2"></i>Información Personal
                            </a>
                        </li>
                        <li class="nav-item w-100 mt-1">
                            <a href="#inscripcion" wire:click="changeTabs('inscripcion', 'Inscripciones')" 
                            data-toggle="tab" aria-expanded="true" class="nav-link {{ $activeTab === 'inscripcion' ? 'active' : '' }}">
                                <i class="fas fa-book mr-2"></i>Inscripciones
                            </a>
                        </li>
                        <li class="nav-item w-100 mt-1">
                            <a href="#alquiler" wire:click="changeTabs('alquiler', 'Alquileres')" 
                            data-toggle="tab" aria-expanded="true" class="nav-link {{ $activeTab === 'alquiler' ? 'active' : '' }}">
                                <i class="fas fa-clipboard-list mr-2"></i>Alquileres
                            </a>
                        </li>
                        <li class="nav-item w-100 mt-1">
                            <a href="#pagos" wire:click="changeTabs('pagos', 'Pagos')" 
                            data-toggle="tab" aria-expanded="true" class="nav-link {{ $activeTab === 'pagos' ? 'active' : '' }}">
                                <i class="fas fa-wallet mr-2"></i>Pagos
                            </a>
                        </li>
                        <li class="nav-item w-100 mt-1">
                            <a href="#asistencia" wire:click="changeTabs('asistencia', 'Asistencias')" 
                            data-toggle="tab" aria-expanded="true" class="nav-link {{ $activeTab === 'asistencia' ? 'active' : '' }}">
                                <i class="far fa-calendar-alt mr-2"></i>Asistencias
                            </a>
                        </li>
                        <li class="nav-item w-100 mt-1">
                            <a href="#configuracion" wire:click="changeTabs('configuracion', 'Configuración')" 
                            {{-- wire:click="$set('activeTab', 'configuracion')"  --}}
                            data-toggle="tab" aria-expanded="true" class="nav-link {{ $activeTab === 'configuracion' ? 'active' : '' }}">
                                <i class="fas fa-cog mr-2"></i>Configuración
                            </a>
                        </li>
                    </ul>
                </div>

            </div> 
        </div> 

        <div class="col-lg-9 col-xl-9">
            <div class="card-box">
                <div class="tab-content p-0">
                    
                    <div class="tab-pane show {{ $activeTab === 'informacion' ? 'active' : '' }}" id="informacion">
                            <h5 class="mb-3 text-uppercase text-white bg-dark p-2 rounded-lg"><i class="fas fa-user-circle mr-1"></i><b> Información Personal </b></h5>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">ID del Cliente :</label>
                                        <input wire:model="id_cliente" class="form-control" 
                                        @if (!$editar)
                                            style="background: transparent"
                                        @endif
                                        readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Nombres :</label>
                                        <input wire:model="nombre" class="form-control" 
                                        style="background: transparent" 
                                        @if (!$editar)
                                            readonly
                                        @endif>
                                        @error('nombre')
                                            <span class="error text-danger" >* {{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Apellidos :</label>
                                        <input wire:model="apellido" class="form-control" style="background: transparent" 
                                        @if (!$editar)
                                            readonly
                                        @endif>
                                        @error('apellido')
                                            <span class="error text-danger" >* {{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                    
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Email :</label>
                                        <input wire:model="email" class="form-control" 
                                        style="background: transparent" 
                                        @if (!$editar)
                                            readonly
                                        @endif>
                                        @error('email')
                                            <span class="error text-danger" >* {{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                    
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Cédula de Identidad :</label>
                                        <input wire:model="ci" class="form-control" 
                                        @if (!$editar)
                                            style="background: transparent"
                                        @endif
                                        readonly>
                                    </div>
                                </div>
                            
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Número Telefónico :</label>
                                        <input wire:model="telefono" class="form-control" style="background: transparent" 
                                        @if (!$editar)
                                            readonly
                                        @endif>
                                        @error('telefono')
                                            <span class="error text-danger" >* {{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                    
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Fecha de Nacimiento :</label>
                                        <input value="{{ $this->formatoFechaTexto($fechaNacimiento) }}" class="form-control" 
                                        @if (!$editar)
                                            style="background: transparent"
                                        @endif 
                                        readonly>
                                    </div>
                                </div>
                            
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Genero :</label>
                                        <input value="{{ ($genero == 'M') ? 'Masculino' : 'Femenino' }}" class="form-control" 
                                        @if (!$editar)
                                            style="background: transparent"
                                        @endif
                                        readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="text-right">
                                @if (!$editar)
                                    <button type="button" wire:click="$set('editar', true)" class="btn btn-primary waves-effect waves-light mt-2"><i class="fas fa-pencil-alt mr-1"></i> Editar</button>
                                @endif

                                @if ($editar)
                                    <button type="button" wire:click="cancelar" class="btn btn-danger waves-effect waves-light mt-2"><i class="fas fa-times mr-1"></i> Cancelar</button>
                                    <button type="button" wire:click="actualizarDatos" class="btn btn-success waves-effect waves-light mt-2"><i class="fas fa-save mr-1"></i> Actualizar</button>
                                @endif
                            </div>
                    </div>

                    <div class="tab-pane {{ $activeTab === 'inscripcion' ? 'active' : '' }}" id="inscripcion">
                        <h5 class="mb-3 text-uppercase text-white bg-dark p-2 rounded-lg"><i class="fas fa-book mr-1"></i> Inscripciones </h5>
                        
                        <div class="row">
                            <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="bg-dark text-white text-center text-nowrap">
                                        <tr style="cursor: pointer">
                                            <th scope="col">ID</th>
                                            <th scope="col">Fecha Inscripción</th>
                                            <th scope="col">Fecha Inicio</th>
                                            <th scope="col">Fecha Vencimiento</th>
                                            <th scope="col">Paquete</th>
                                            <th scope="col">Duración</th>
                                            <th scope="col">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($inscripciones->count())
                                            @foreach ($inscripciones as $inscripcion)
                                                <tr class="text-nowrap text-center">
                                                    <th scope="row" class="align-middle">{{ $inscripcion->id }}</th>
                                                    <td class="align-middle">
                                                        {{ $this->formatoFecha($inscripcion->fecha_inscripcion) }}</td>
                                                    <td class="align-middle">
                                                        {{ $this->formatoFecha($inscripcion->detalle->fecha_incio) }}</td>
                                                    <td class="align-middle">
                                                        {{ $this->formatoFecha($inscripcion->detalle->fecha_vencimiento) }}</td>
                                                    <td class="align-middle">
                                                        {{ $inscripcion->paquete->nombre }}</td>
                                                    <td class="align-middle">
                                                        {{ $inscripcion->duracion->nombre }}</td>
                                                    <td class="align-middle">
                                                        @if (is_null($inscripcion->detalle->estado))
                                                            <span class="text-warning py-1 px-2 rounded-lg d-inline-block"
                                                            style="background-color: #ffeeba; width: 90px">Pendiente</span>
                                                        @elseif ($inscripcion->detalle->estado === 0)
                                                            <span class="text-danger py-1 px-2 rounded-lg d-inline-block" style="background-color: #f8d7da; width: 90px">Vencida</span>
                                                        @elseif ($inscripcion->detalle->estado === 1)
                                                            <span class="text-success py-1 px-2 rounded-lg d-inline-block" style="background-color: #c3e6cb; width: 90px">Activa</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr class="text-center">
                                                <td colspan="9">No existe ningún registro.</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            </div>
                        </div> 
                    </div>

                    <div class="tab-pane {{ $activeTab === 'alquiler' ? 'active' : '' }}" id="alquiler">
                        <h5 class="mb-3 text-uppercase text-white bg-dark p-2 rounded-lg"><i class="fas fa-clipboard-list mr-1"></i> Alquileres </h5>
                        
                        <div class="row">
                            <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="bg-dark text-white text-center text-nowrap">
                                        <tr style="cursor: pointer">
                                            <th scope="col">ID</th>
                                            <th scope="col">Fecha Alquiler</th>
                                            <th scope="col">Fecha Inicio</th>
                                            <th scope="col">Fecha Vencimiento</th>
                                            <th scope="col">Dias Duración</th>
                                            <th scope="col">Nro Casillero</th>
                                            <th scope="col">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($alquileres->count())
                                            @foreach ($alquileres as $alquiler)
                                                <tr class="text-nowrap text-center">
                                                    <th scope="row" class="align-middle">{{ $alquiler->id }}</th>
                                                    <td class="align-middle">
                                                        {{ $this->formatoFecha($alquiler->fecha_alquiler) }}</td>
                                                    <td class="align-middle">
                                                        {{ $this->formatoFecha($alquiler->fecha_incio) }}</td>
                                                    <td class="align-middle">
                                                        {{ $this->formatoFecha($alquiler->fecha_fin) }}</td>
                                                    <td class="align-middle">
                                                        {{ $alquiler->dias_duracion }}</td>
                                                    <td class="align-middle">
                                                        {{ $alquiler->casillero->nro }}</td>
                                                    <td class="align-middle">
                                                        @if (is_null($alquiler->estado))
                                                            <span class="text-warning py-1 px-2 rounded-lg d-inline-block"
                                                            style="background-color: #ffeeba; width: 90px">Pendiente</span>
                                                        @elseif ($alquiler->estado === 0)
                                                            <span class="text-danger py-1 px-2 rounded-lg d-inline-block" style="background-color: #f8d7da; width: 90px">Vencida</span>
                                                        @elseif ($alquiler->estado === 1)
                                                            <span class="text-success py-1 px-2 rounded-lg d-inline-block" style="background-color: #c3e6cb; width: 90px">Activa</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr class="text-center">
                                                <td colspan="9">No existe ningún registro.</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            </div>
                        </div> 
                    </div>

                    <div class="tab-pane {{ $activeTab === 'pagos' ? 'active' : '' }}" id="pagos">
                        <h5 class="mb-3 text-uppercase text-white bg-dark p-2 rounded-lg"><i class="fas fa-wallet mr-1"></i> Pagos </h5>
                        
                        <div class="row">
                            <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="bg-dark text-white text-center text-nowrap">
                                        <tr style="cursor: pointer">
                                            <th scope="col">ID</th>
                                            <th scope="col">Fecha Pago</th>
                                            <th scope="col">Concepto</th>
                                            <th scope="col">Monto</th>
                                            <th scope="col">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($pagos->count())
                                            @foreach ($pagos as $pago)
                                                <tr class="text-nowrap text-center">
                                                    <th scope="row" class="align-middle">{{ $pago->id }}</th>
                                                    <td class="align-middle">
                                                        {{ $this->formatoFecha($pago->fecha) }}</td>
                                                    <td class="align-middle">
                                                        {{ $pago->concepto }}</td>
                                                    <td class="align-middle">
                                                        {{ 'Bs '.number_format($pago->monto, 2) }}</td>
                                                    <td class="align-middle">
                                                        @if (is_null($pago->estado))
                                                            <span class="text-warning py-1 px-2 rounded-lg d-inline-block"
                                                            style="background-color: #f8d7da; width: 90px">Sin Pagar</span>
                                                        @elseif ($pago->estado === 0)
                                                            <span class="text-danger py-1 px-2 rounded-lg d-inline-block" style="background-color: #ffeeba; width: 90px">Pendiente</span>
                                                        @elseif ($pago->estado === 1)
                                                            <span class="text-success py-1 px-2 rounded-lg d-inline-block" style="background-color: #c3e6cb; width: 90px">Pagado</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr class="text-center">
                                                <td colspan="9">No existe ningún registro.</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            </div>
                        </div> 
                    </div>

                    <div class="tab-pane {{ $activeTab === 'asistencia' ? 'active' : '' }}" id="asistencia">
                        <h5 class="mb-3 text-uppercase text-white bg-dark p-2 rounded-lg"><i class="far fa-calendar-alt mr-1"></i> Asistencias </h5>
                        
                        <div class="row">
                            <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="bg-dark text-white text-center text-nowrap">
                                        <tr style="cursor: pointer">
                                            <th scope="col">ID</th>
                                            <th scope="col">Fecha de Ingreso</th>
                                            <th scope="col">Hora de Ingreso</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($asistencias->count())
                                            @foreach ($asistencias as $asistencia)
                                                <tr class="text-nowrap text-center">
                                                    <th scope="row" class="align-middle">{{ $asistencia->id }}</th>
                                                    <td class="align-middle">
                                                        {{ $this->formatoFecha($asistencia->fecha_de_ingreso) }}</td>
                                                    <td class="align-middle">
                                                        {{ $this->formatoHora($asistencia->hora_de_ingreso) }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr class="text-center">
                                                <td colspan="3">No existe ningún registro.</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            </div>
                        </div> 
                    </div>

                    <div class="tab-pane {{ $activeTab === 'configuracion' ? 'active' : '' }}" id="configuracion">
                            <h5 class="mb-3 text-uppercase rounded-lg text-white bg-dark p-2"><i class="fas fa-lock mr-1"></i> Cambiar Contraseña </h5>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Clave Actual <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="{{ $showPassword1 ? 'text' : 'password' }}" class="form-control" wire:model="passwordActual" placeholder="Contraseña actual" style="border-right: none">
                                            <div class="input-group-append">
                                                <span class="input-group-text" style="background: transparent; cursor: pointer; border-left: none;" wire:click="$toggle('showPassword1')">
                                                    <i class="fas {{ $showPassword1 ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                                </span>
                                            </div>
                                        </div>
                                        @error('passwordActual')
                                            <span class="error text-danger" >* {{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Nueva Contraseña <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="{{ $showPassword2 ? 'text' : 'password' }}" class="form-control" wire:model="passwordNuevo" placeholder="Nueva contraseña" style="border-right: none;">
                                            <div class="input-group-append">
                                                <span class="input-group-text" style="background: transparent; cursor: pointer; border-left: none;" wire:click="$toggle('showPassword2')">
                                                    <i class="fas {{ $showPassword2 ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                                </span>
                                            </div>
                                        </div>
                                        @error('passwordNuevo')
                                            <span class="error text-danger" >* {{ $message }}</span>
                                        @enderror
                                    </div>
                                </div> 
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Confirmar Contraseña <span class="text-danger">*</span> </label>
                                        <div class="input-group">
                                            <input type="{{ $showPassword3 ? 'text' : 'password' }}" class="form-control" wire:model="passwordConfirmar" placeholder="Confirmar contraseña" style="border-right: none;">
                                            <div class="input-group-append">
                                                <span class="input-group-text" style="background: transparent; cursor: pointer; border-left: none;" wire:click="$toggle('showPassword3')">
                                                    <i class="fas {{ $showPassword3 ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                                </span>
                                            </div>
                                        </div>
                                        @error('passwordConfirmar')
                                            <span class="error text-danger" >* {{ $message }}</span>
                                        @enderror
                                    </div>
                                </div> 
                            </div> 

                            <div class="text-right">
                                <button type="button" wire:click="cambiarContraseña" class="btn btn-success waves-effect waves-light mt-2"><i class="fas fa-save mr-1"></i> Cambiar Contraseña</button>
                            </div>
                    </div>

                </div> 
            </div> 
        </div> 
    </div>

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            livewire.on('error', function(message) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Ha ocurrido un error. Por favor, intenta nuevamente.'           
                })
                console.error(message);
            });

            
            livewire.on('alert', function(accion) {
                var msj2 = accion.charAt(0).toUpperCase() + accion.slice(1);
                Swal.fire(
                    '¡' + msj2 + '!',
                    'Su información personal a sido ' + accion + ' correctamente.',
                    'success'
                )
            });

            livewire.on('password', function() {
                Swal.fire(
                    '¡Actualizado!',
                    'Su contraseña se actualizó correctamente.',
                    'success'
                )
            });
            
        </script>
    @endpush

</div>

