<div>

    @if ($vistaCrear)
        <livewire:casillero.create>
    @elseif ($vistaEditar)
        <livewire:casillero.edit>
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
                @if (verificarPermiso('Casillero_Buscar'))                  
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
                    Nuevo Casillero
                </button>
            </div>

        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0">
                <thead class="bg-dark text-white text-nowrap">
                    <tr style="cursor: pointer">
                        <th scope="col" style="width: 100px;" wire:click="order('nro')">Nro
                            @if ($sort == 'nro')
                                @if ($direction == 'asc')
                                    <i class="fas fa-sort-alpha-down float-md-right" style="margin-top: 4px"></i>
                                @else
                                    <i class="fas fa-sort-alpha-up float-md-right" style="margin-top: 4px"></i> 
                                @endif
                            @else
                                <i class="fas fa-sort float-md-right" style="margin-top: 4px"></i>
                            @endif
                        </th>
                        <th scope="col" wire:click="order('tamaño')">Tamaño
                            @if ($sort == 'tamaño')
                                @if ($direction == 'asc')
                                    <i class="fas fa-sort-alpha-down float-md-right" style="margin-top: 4px"></i>
                                @else
                                    <i class="fas fa-sort-alpha-up float-md-right" style="margin-top: 4px"></i> 
                                @endif
                            @else
                                <i class="fas fa-sort float-md-right" style="margin-top: 4px"></i>
                            @endif
                        </th>
                        <th scope="col" wire:click="order('precio')">Precio
                            @if ($sort == 'precio')
                                @if ($direction == 'asc')
                                    <i class="fas fa-sort-alpha-down float-md-right" style="margin-top: 4px"></i>
                                @else
                                    <i class="fas fa-sort-alpha-up float-md-right" style="margin-top: 4px"></i> 
                                @endif
                            @else
                                <i class="fas fa-sort float-md-right" style="margin-top: 4px"></i>
                            @endif
                        </th>
                        <th scope="col" wire:click="order('estado')">Estado
                            @if ($sort == 'estado')
                                @if ($direction == 'asc')
                                    <i class="fas fa-sort-alpha-down float-md-right" style="margin-top: 4px"></i>
                                @else
                                    <i class="fas fa-sort-alpha-up float-md-right" style="margin-top: 4px"></i> 
                                @endif
                            @else
                                <i class="fas fa-sort float-md-right" style="margin-top: 4px"></i>
                            @endif
                        </th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($casilleros->count())
                        @foreach ($casilleros as $casillero)
                            <tr class="text-wrap text-center">
                                <th scope="row" class="align-middle">{{ $casillero->nro }}</th>
                                <td class="align-middle text-left">{{ $casillero->tamaño }}</td>
                                <td class="align-middle">{{ $casillero->precio }}</td>
                                <td class="align-middle">
                                    @if ($casillero->estado)
                                        <span class="text-success py-1 px-2 rounded-lg" style="background-color: #c3e6cb">Disponible</span>
                                    @else
                                        <span class="text-danger py-1 px-2 rounded-lg" style="background-color: #f8d7da">Ocupado</span>
                                    @endif
                                </td>
                                <td class="align-middle text-nowrap">
                                    <button type="button" title="Editar" wire:click="seleccionarCasillero({{ $casillero->id }})" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                                    <button type="button" title="Eliminar" wire:click="$emit('eliminarRegistro', {{ $casillero->id }}, {{ $this->verificarPermiso }})" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
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
                Mostrando del  {{ ($casilleros->firstItem()) ? $casilleros->firstItem() : 0 }} al {{ ($casilleros->lastItem()) ? $casilleros->lastItem() : 0 }} de {{ $casilleros->total() }} registros
            </div>
            @if ($casilleros->hasPages())
                <div class="pagination-links">
                    {{ $casilleros->links() }}
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
                    'El casillero ha sido ' + accion + ' correctamente.',
                    'success'
                )
            });


            livewire.on('eliminarRegistro', function(casilleroId, tienePermiso) {
                if (tienePermiso) {
                    Swal.fire({
                        title: '¿Está seguro?',
                        text: "¡Se eliminará el casillero definitivamente!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: '¡Sí, eliminar!',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {

                            livewire.emitTo('casillero.show', 'eliminarCasillero', casilleroId);

                            Swal.fire(
                                '¡Eliminado!',
                                'El casillero ha sido eliminado.',
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

