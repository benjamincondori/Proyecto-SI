<div>

    @if ($vistaCrear)
        <livewire:duracion.create>
    @elseif ($vistaEditar)
        <livewire:duracion.edit>
    @else
        <div class="table-responsive">
            <div class="mb-2 d-flex justify-content-between">

                <div class="form-group d-none d-lg-flex align-items-center">
                    <span>Mostrar</span>
                    <select wire:model="cant" class="form-control px-1 mx-1">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <span>entradas</span>
                </div>

                <div class="form-group w-50 d-flex">
                    <input type="text" wire:model="buscar" class="form-control" placeholder="Buscar...">
                    <button class="btn text-secondary" type="button" disabled>
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                
                <div class="form-group">
                    <button type="button" wire:click="agregarNuevo" class="btn btn-primary waves-effect waves-light">
                        <i class="fas fa-plus-circle"></i>&nbsp;
                        Nueva Duración
                    </button>
                </div>

            </div>

            <table class="table table-bordered mb-0">
                <thead class="bg-light">
                    <tr style="cursor: pointer">
                        <th scope="col" style="width: 60px;" wire:click="order('id')">ID
                            @if ($sort == 'id')
                                @if ($direction == 'asc')
                                    <i class="fas fa-sort-alpha-down float-right" style="margin-top: 4px"></i>
                                @else
                                    <i class="fas fa-sort-alpha-up float-right" style="margin-top: 4px"></i> 
                                @endif
                            @else
                                <i class="fas fa-sort float-right" style="margin-top: 4px"></i>
                            @endif
                        </th>
                        <th scope="col" wire:click="order('nombre')">Nombre
                            @if ($sort == 'nombre')
                                @if ($direction == 'asc')
                                    <i class="fas fa-sort-alpha-down float-right" style="margin-top: 4px"></i>
                                @else
                                    <i class="fas fa-sort-alpha-up float-right" style="margin-top: 4px"></i> 
                                @endif
                            @else
                                <i class="fas fa-sort float-right" style="margin-top: 4px"></i>
                            @endif
                        </th>
                        <th scope="col" wire:click="order('dias_duracion')">Días de duración
                            @if ($sort == 'dias_duracion')
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
                    @if ($duraciones->count())
                        @foreach ($duraciones as $duracion)
                            <tr class="text-wrap text-center">
                                <th scope="row" class="align-middle">{{ $duracion->id }}</th>
                                <td class="align-middle text-left">{{ $duracion->nombre }}</td>
                                <td class="align-middle">{{ $duracion->dias_duracion }}</td>
                                <td class="text-nowrap align-middle">
                                    <button type="button" title="Editar"
                                        wire:click="seleccionarPaquete({{ $duracion->id }}, 'editar')"
                                        class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                                    <button type="button"title="Eliminar"
                                        wire:click="$emit('eliminarRegistro', {{ $duracion->id }})"
                                        class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="text-center">
                            <td colspan="4">No existe ningún registro coincidente.</td>
                        </tr>
                    @endif
                </tbody>
            </table>

            @if ($duraciones->hasPages())
                <div class="d-flex justify-content-end justify-content-sm-between pt-3 pb-0">
                    <div class="text-muted d-none d-sm-block pt-1">
                        Mostrando {{ $duraciones->firstItem() }} a {{ $duraciones->lastItem() }} de {{ $duraciones->total() }} resultados
                    </div>
                    <div class="pagination-links">
                        {{ $duraciones->links() }}
                    </div>
                </div>
            @endif

        </div>
    @endif

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            livewire.on('alert', function(accion) {

                var msj2 = accion.charAt(0).toUpperCase() + accion.slice(1);

                Swal.fire(
                    '¡' + msj2 + '!',
                    'La duración ha sido ' + accion + ' correctamente.',
                    'success'
                )
            });

            livewire.on('eliminarRegistro', duracionId => {
                Swal.fire({
                    title: '¿Está seguro?',
                    text: "¡Se eliminará la duración definitivamente!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '¡Sí, eliminar!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {

                        livewire.emitTo('duracion.show', 'eliminarDuracion', duracionId);

                        Swal.fire(
                            '¡Eliminado!',
                            'La duración ha sido eliminado.',
                            'success'
                        )
                    }
                })
            });
        </script>
    @endpush

</div>

