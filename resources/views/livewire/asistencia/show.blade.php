<div>

    @if ($vistaCrear)
        <livewire:asistencia.create>
    @elseif ($vistaEditar)
        <livewire:asistencia.edit>
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
                @if (verificarPermiso('Asistencia_Buscar'))
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
                    Registrar Asistencia
                </button>
            </div>

        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0">
                <thead class="bg-dark text-white text-nowrap">
                    <tr style="cursor: pointer">
                        <th scope="col" style="width: 70px" wire:click="order('id')">ID
                            @if ($sort == 'id')
                                @if ($direction == 'asc')
                                    <i class="fas fa-sort-alpha-down float-md-right" style="margin-top: 4px; margin-left: 10px"></i>
                                @else
                                    <i class="fas fa-sort-alpha-up float-md-right" style="margin-top: 4px; margin-left: 10px"></i> 
                                @endif
                            @else
                                <i class="fas fa-sort float-md-right" style="margin-top: 4px; margin-left: 10px"></i>
                            @endif
                        </th>
                        <th scope="col" wire:click="order('fecha_de_ingreso')">Fecha
                            @if ($sort == 'fecha_de_ingreso')
                                @if ($direction == 'asc')
                                    <i class="fas fa-sort-alpha-down float-md-right" style="margin-top: 4px; margin-left: 10px"></i>
                                @else
                                    <i class="fas fa-sort-alpha-up float-md-right" style="margin-top: 4px; margin-left: 10px"></i> 
                                @endif
                            @else
                                <i class="fas fa-sort float-md-right" style="margin-top: 4px; margin-left: 10px"></i>
                            @endif
                        </th>
                        <th scope="col" wire:click="order('hora_de_ingreso')">Hora
                            @if ($sort == 'hora_de_ingreso')
                                @if ($direction == 'asc')
                                    <i class="fas fa-sort-alpha-down float-md-right" style="margin-top: 4px; margin-left: 10px"></i>
                                @else
                                    <i class="fas fa-sort-alpha-up float-md-right" style="margin-top: 4px; margin-left: 10px"></i> 
                                @endif
                            @else
                                <i class="fas fa-sort float-md-right" style="margin-top: 4px; margin-left: 10px"></i>
                            @endif
                        </th>
                        <th scope="col" wire:click="order('id_cliente')">Cliente
                            @if ($sort == 'id_cliente')
                                @if ($direction == 'asc')
                                    <i class="fas fa-sort-alpha-down float-md-right" style="margin-top: 4px; margin-left: 10px"></i>
                                @else
                                    <i class="fas fa-sort-alpha-up float-md-right" style="margin-top: 4px; margin-left: 10px"></i> 
                                @endif
                            @else
                                <i class="fas fa-sort float-md-right" style="margin-top: 4px; margin-left: 10px"></i>
                            @endif
                        </th>
                        <th scope="col" wire:click="order('id_administrativo')">Administrativo
                            @if ($sort == 'id_administrativo')
                                @if ($direction == 'asc')
                                    <i class="fas fa-sort-alpha-down float-md-right" style="margin-top: 4px; margin-left: 10px"></i>
                                @else
                                    <i class="fas fa-sort-alpha-up float-md-right" style="margin-top: 4px; margin-left: 10px"></i> 
                                @endif
                            @else
                                <i class="fas fa-sort float-md-right" style="margin-top: 4px; margin-left: 10px"></i>
                            @endif
                        </th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($registros->count())
                        @foreach ($registros as $registro)
                            <tr class="text-nowrap text-center">
                                <th scope="row" class="align-middle">{{ $registro->id }}</th>
                                <td class="align-middle">
                                    {{ $this->formatoFecha($registro->fecha_de_ingreso) }}</td>
                                <td class="align-middle">
                                    {{ $this->formatoHora($registro->hora_de_ingreso) }}</td>
                                <td class="align-middle text-left">
                                    {{ $registro->cliente->nombres }} 
                                    {{ $registro->cliente->apellidos }}</td>
                                <td class="align-middle text-left">
                                    {{ $registro->administrativo->empleado->nombres }}
                                    {{ $registro->administrativo->empleado->apellidos }}</td>
                                <td class="align-middle text-nowrap">
                                    <button type="button" title="Editar"
                                        wire:click="seleccionarRegistro({{ $registro->id }})"
                                        class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                                    <button type="button"title="Eliminar"
                                        wire:click="$emit('eliminarRegistro', {{ $registro->id }}, {{ $this->verificarPermiso }})"
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
                Mostrando del {{ ($registros->firstItem()) ? $registros->firstItem() : 0 }} al {{ ($registros->lastItem()) ? $registros->lastItem() : 0 }} de {{ $registros->total() }} registros
            </div>
            @if ($registros->hasPages())
                <div class="pagination-links">
                    {{ $registros->links() }}
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

            livewire.on('noInscrito', function() {
                Swal.fire({
                    icon: 'info',
                    title: 'Oops...',
                    text: 'Al parecer el cliente no tiene una inscripción activa.'           
                })
            });


            livewire.on('asistenciaDoble', function() {
                Swal.fire({
                    icon: 'info',
                    title: 'Oops...',
                    text: 'Al parecer el cliente ya registro su asistencia el dia de hoy.'           
                })
            });


            livewire.on('alert', function(accion) {
                var msj2 = accion.charAt(0).toUpperCase() + accion.slice(1);
                Swal.fire(
                    '¡' + msj2 + '!',
                    'El registro ha sido ' + accion + ' correctamente.',
                    'success'
                )
            });


            livewire.on('eliminarRegistro', function(registroId, tienePermiso) {
                if (tienePermiso) {
                    Swal.fire({
                        title: '¿Está seguro?',
                        text: "¡Se eliminará el registro definitivamente!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: '¡Sí, eliminar!',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {

                            livewire.emitTo('asistencia.show', 'eliminarRegistro', registroId);

                            Swal.fire(
                                '¡Eliminado!',
                                'El registro ha sido eliminado.',
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



