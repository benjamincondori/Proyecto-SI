<div>

    @if ($vistaCrear)
        <livewire:usuario.create>
    @elseif ($vistaEditar)
        <livewire:usuario.edit>
    @else

        <div class="mb-2 d-flex justify-content-between">

            <div class="form-group d-none d-lg-flex align-items-center">
                <span>Mostrar</span>
                <select wire:model="cant" class="custom-select px-3 mx-1">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span>registros</span>
            </div>

            <div class="form-group w-50 d-flex">
                @if (verificarPermiso('Usuario_Buscar')) 
                    <input type="text" wire:model="buscar" class="form-control" 
                    placeholder="Buscar...">
                    <button class="btn text-secondary" type="button" disabled>
                        <i class="fas fa-search"></i>
                    </button>
                @endif
            </div>
            
            {{-- <div class="form-group">
                <button type="button" wire:click="agregarNuevo" class="btn btn-primary waves-effect waves-light">
                    <i class="fas fa-plus-circle"></i>&nbsp;
                    Nuevo Usuario
                </button>
            </div> --}}

        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0">
                <thead class="bg-dark text-white text-nowrap">
                    <tr style="cursor: pointer">
                        <th scope="col" style="width: 100px;" wire:click="order('id')">ID
                            @if ($sort == 'id')
                                @if ($direction == 'asc')
                                    <i class="fas fa-sort-alpha-down float-md-right" style="margin-top: 4px"></i>
                                @else
                                    <i class="fas fa-sort-alpha-up float-md-right" style="margin-top: 4px"></i> 
                                @endif
                            @else
                                <i class="fas fa-sort float-md-right" style="margin-top: 4px"></i>
                            @endif
                        </th>
                        <th scope="col" wire:click="order('nombres')">Nombre del Usuario
                            @if ($sort == 'nombres')
                                @if ($direction == 'asc')
                                    <i class="fas fa-sort-alpha-down float-md-right" style="margin-top: 4px"></i>
                                @else
                                    <i class="fas fa-sort-alpha-up float-md-right" style="margin-top: 4px"></i> 
                                @endif
                            @else
                                <i class="fas fa-sort float-md-right" style="margin-top: 4px"></i>
                            @endif
                        </th>
                        <th scope="col" wire:click="order('email')">Email
                            @if ($sort == 'email')
                                @if ($direction == 'asc')
                                    <i class="fas fa-sort-alpha-down float-md-right" style="margin-top: 4px"></i>
                                @else
                                    <i class="fas fa-sort-alpha-up float-md-right" style="margin-top: 4px"></i> 
                                @endif
                            @else
                                <i class="fas fa-sort float-md-right" style="margin-top: 4px"></i>
                            @endif
                        </th>
                        <th scope="col">Rol</th>
                        <th scope="col" style="width: 160px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($empleados->count())
                        @foreach ($empleados as $empleado)
                            <tr class="text-wrap text-center">
                                <th scope="row" class="align-middle">{{ $empleado->usuario->id }}</th>
                                <td class="align-middle text-left">
                                    {{ $empleado->nombres }} {{ $empleado->apellidos }}
                                </td>
                                <td class="align-middle text-left"> 
                                    {{ $empleado->email }}
                                </td>
                                <td class="align-middle">
                                    @php
                                        $rol = $empleado->usuario->rol->nombre;
                                    @endphp
                                    @if ($rol === 'Recepcionista')
                                        <span class="text-warning py-1 px-2 rounded-lg d-inline-block"
                                        style="background-color: #ffeeba; width: 120px">{{ $rol }}</span>
                                    @elseif ($rol === 'Administrador')
                                        <span class="text-success py-1 px-2 rounded-lg d-inline-block" style="background-color: #c3e6cb; width: 120px">{{ $rol }}</span>
                                    @else
                                    <span class="text-info py-1 px-2 rounded-lg d-inline-block" style="background-color: #cde9fb; width: 120px">{{ $rol }}</span>
                                    @endif
                                </td>
                                <td class="align-middle text-nowrap">
                                    <button type="button" title="Editar" wire:click="seleccionarUsuario({{ $empleado->usuario->id }})" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                                    <button type="button" title="Eliminar" wire:click="$emit('eliminarRegistro', {{ $empleado->usuario->id }}, {{ $this->verificarPermiso }})" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="text-center">
                            <td colspan="5">No existe ningún registro.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end justify-content-sm-between pt-3 pb-0">
            <div class="text-muted d-none d-sm-block pt-1">
                Mostrando del {{ ($empleados->firstItem()) ? $empleados->firstItem() : 0 }} al {{ ($empleados->lastItem()) ? $empleados->lastItem() : 0 }} de {{ $empleados->total() }} registros
            </div>
            @if ($empleados->hasPages())
                <div class="pagination-links">
                    {{ $empleados->links() }}
                </div>
            @endif   
        </div>

    @endif

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
                    'El usuario ha sido ' + accion + ' correctamente.',
                    'success'
                )
            });


            livewire.on('eliminarRegistro', function(usuarioId, tienePermiso) {
                if (tienePermiso) {
                    Swal.fire({
                        title: '¿Está seguro?',
                        text: "¡Se eliminará el usuario definitivamente!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: '¡Sí, eliminar!',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {

                            livewire.emitTo('usuario.show', 'eliminarUsuario', usuarioId);

                            Swal.fire(
                                '¡Eliminado!',
                                'El usuario ha sido eliminado.',
                                'success'
                            )
                        }
                    })
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: '¡Acceso Denegado!',
                        text: 'No tiene los permisos necesarios.'           
                    })
                }
            });
        </script>
    @endpush

</div>


