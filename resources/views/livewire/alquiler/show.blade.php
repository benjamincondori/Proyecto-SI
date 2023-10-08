<div>

    @if ($vistaVer)
        <livewire:alquiler.view>
    @elseif($vistaCrear)
        <livewire:alquiler.create>
    @elseif ($vistaEditar)
        <livewire:alquiler.edit>
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
                @if (verificarPermiso('Alquiler_Buscar'))
                    <input type="text" wire:model="buscar" class="form-control" 
                    placeholder="Buscar...">
                    <button class="btn text-secondary" type="button" disabled>
                        <i class="fas fa-search"></i>
                    </button>
                @endif
            </div>
            
            <div class="form-group">
                <button type="button" wire:click="agregarNuevo" class="btn btn-primary waves-effect waves-light">
                    <i class="fas fa-plus-circle"></i>&nbsp;
                    Nuevo Alquiler
                </button>
            </div>

        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0">
                <thead class="bg-dark text-white text-nowrap">
                    <tr style="cursor: pointer">
                        <th scope="col" wire:click="order('id')">ID
                            @if ($sort == 'id')
                                @if ($direction == 'asc')
                                    <i class="fas fa-sort-alpha-down" style="margin-top: 4px; margin-left: 10px"></i>
                                @else
                                    <i class="fas fa-sort-alpha-up " style="margin-top: 4px; margin-left: 10px"></i> 
                                @endif
                            @else
                                <i class="fas fa-sort " style="margin-top: 4px; margin-left: 10px"></i>
                            @endif
                        </th>
                        <th scope="col" wire:click="order('fecha_alquiler')">Fecha Alquiler
                            @if ($sort == 'fecha_alquiler')
                                @if ($direction == 'asc')
                                    <i class="fas fa-sort-alpha-down" style="margin-top: 4px; margin-left: 10px"></i>
                                @else
                                    <i class="fas fa-sort-alpha-up" style="margin-top: 4px; margin-left: 10px"></i> 
                                @endif
                            @else
                                <i class="fas fa-sort" style="margin-top: 4px; margin-left: 10px"></i>
                            @endif
                        </th>
                        <th scope="col" wire:click="order('fecha_inicio')">Fecha Inicio
                            @if ($sort == 'fecha_inicio')
                                @if ($direction == 'asc')
                                    <i class="fas fa-sort-alpha-down" style="margin-top: 4px; margin-left: 10px"></i>
                                @else
                                    <i class="fas fa-sort-alpha-up" style="margin-top: 4px; margin-left: 10px"></i> 
                                @endif
                            @else
                                <i class="fas fa-sort" style="margin-top: 4px; margin-left: 10px"></i>
                            @endif
                        </th>
                        <th scope="col" wire:click="order('fecha_fin')">Fecha Fin
                            @if ($sort == 'fecha_fin')
                                @if ($direction == 'asc')
                                    <i class="fas fa-sort-alpha-down" style="margin-top: 4px; margin-left: 10px"></i>
                                @else
                                    <i class="fas fa-sort-alpha-up" style="margin-top: 4px; margin-left: 10px"></i> 
                                @endif
                            @else
                                <i class="fas fa-sort" style="margin-top: 4px; margin-left: 10px"></i>
                            @endif
                        </th>
                        <th scope="col" wire:click="order('dias_duracion')">Duración
                            @if ($sort == 'dias_duracion')
                                @if ($direction == 'asc')
                                    <i class="fas fa-sort-alpha-down" style="margin-top: 4px; margin-left: 10px"></i>
                                @else
                                    <i class="fas fa-sort-alpha-up" style="margin-top: 4px; margin-left: 10px"></i> 
                                @endif
                            @else
                                <i class="fas fa-sort" style="margin-top: 4px; margin-left: 10px"></i>
                            @endif
                        </th>
                        <th scope="col" wire:click="order('id_cliente')">Cliente
                            @if ($sort == 'id_cliente')
                                @if ($direction == 'asc')
                                    <i class="fas fa-sort-alpha-down float-right" style="margin-top: 4px"></i>
                                @else
                                    <i class="fas fa-sort-alpha-up float-right" style="margin-top: 4px"></i> 
                                @endif
                            @else
                                <i class="fas fa-sort float-right" style="margin-top: 4px"></i>
                            @endif
                        </th>
                        <th scope="col" wire:click="order('id_administrativo')">Administrativo
                            @if ($sort == 'id_administrativo')
                                @if ($direction == 'asc')
                                    <i class="fas fa-sort-alpha-down float-right" style="margin-top: 4px"></i>
                                @else
                                    <i class="fas fa-sort-alpha-up float-right" style="margin-top: 4px"></i> 
                                @endif
                            @else
                                <i class="fas fa-sort float-right" style="margin-top: 4px"></i>
                            @endif
                        </th>
                        <th scope="col" wire:click="order('estado')">Estado
                            @if ($sort == 'estado')
                                @if ($direction == 'asc')
                                    <i class="fas fa-sort-alpha-down float-right" style="margin-top: 4px"></i>
                                @else
                                    <i class="fas fa-sort-alpha-up float-right" style="margin-top: 4px"></i> 
                                @endif
                            @else
                                <i class="fas fa-sort float-right" style="margin-top: 4px"></i>
                            @endif
                        </th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($alquileres->count())
                        @foreach ($alquileres as $alquiler)
                            <tr class="text-nowrap text-center">
                                <th scope="row" class="align-middle">{{ $alquiler->id }}</th>
                                <td class="align-middle">
                                    {{ $this->obtenerFechaAlquiler($alquiler->id) }}</td>
                                <td class="align-middle">
                                    {{ $this->formatoFecha($alquiler->fecha_inicio) }}</td>
                                <td class="align-middle">
                                    {{ $this->formatoFecha($alquiler->fecha_fin) }}</td>
                                <td class="align-middle">
                                    {{ $alquiler->dias_duracion }} días</td>
                                <td class="align-middle text-left">
                                    {{ $alquiler->cliente->nombres }} 
                                    {{ $alquiler->cliente->apellidos }}</td>
                                <td class="align-middle text-left">
                                    {{ $alquiler->administrativo->empleado->nombres }}
                                    {{ $alquiler->administrativo->empleado->apellidos }}</td>
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
                                <td class="align-middle text-nowrap">
                                    <button type="button" title="Ver"
                                        wire:click="seleccionarAlquiler({{ $alquiler->id }}, 'ver')"
                                        class="btn btn-sm btn-warning"><i class="fas fa-eye"></i></button>
                                    <button type="button" title="Editar"
                                        wire:click="seleccionarAlquiler({{ $alquiler->id }}, 'editar')"
                                        @if (!is_null($alquiler->estado))
                                            disabled
                                        @endif
                                        class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                                    <button type="button"title="Eliminar"
                                        wire:click="$emit('eliminarRegistro', {{ $alquiler->id }}, {{ $this->verificarPermiso }})"
                                        @if (!is_null($alquiler->estado))
                                            disabled
                                        @endif
                                        class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
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

        <div class="d-flex justify-content-end justify-content-sm-between pt-3 pb-0">
            <div class="text-muted d-none d-sm-block pt-1">
                Mostrando del {{ ($alquileres->firstItem()) ? $alquileres->firstItem() : 0 }} al {{ ($alquileres->lastItem()) ? $alquileres->lastItem() : 0 }} de {{ $alquileres->total() }} registros
            </div>
            @if ($alquileres->hasPages())
                <div class="pagination-links">
                    {{ $alquileres->links() }}
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

            // livewire.on('cupo', function(nombreGrupo) {
            //     Swal.fire({
            //         icon: 'info',
            //         title: '¡Cupo no Disponible!',
            //         text: 'El grupo "' + nombreGrupo + '" no tiene cupos. Por favor, elija otro grupo.'          
            //     })
            // });

            livewire.on('alert', function(accion) {
                var msj2 = accion.charAt(0).toUpperCase() + accion.slice(1);
                Swal.fire(
                    '¡' + msj2 + '!',
                    'El alquiler ha sido ' + accion + ' correctamente.',
                    'success'
                )
            });


            livewire.on('eliminarRegistro', function(alquilerId, tienePermiso) {
                if (tienePermiso) {
                    Swal.fire({
                        title: '¿Está seguro?',
                        text: "¡Se eliminará el alquiler definitivamente!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: '¡Sí, eliminar!',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {

                            livewire.emitTo('alquiler.show', 'eliminarAlquiler', alquilerId);

                            Swal.fire(
                                '¡Eliminado!',
                                'El alquiler ha sido eliminado.',
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


