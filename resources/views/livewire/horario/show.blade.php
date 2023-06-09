<div>

    @if ($vistaCrear)
        <livewire:horario.create>
    @elseif ($vistaEditar)
        <livewire:horario.edit>
    @else

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
                    Nuevo Horario
                </button>
            </div>

        </div>

        <div class="table-responsive">
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
                        <th scope="col" wire:click="order('descripcion')">Descripción
                            @if ($sort == 'descripcion')
                                @if ($direction == 'asc')
                                    <i class="fas fa-sort-alpha-down float-right" style="margin-top: 4px"></i>
                                @else
                                    <i class="fas fa-sort-alpha-up float-right" style="margin-top: 4px"></i> 
                                @endif
                            @else
                                <i class="fas fa-sort float-right" style="margin-top: 4px"></i>
                            @endif
                        </th>
                        <th scope="col" wire:click="order('hora_inicio')">Hora de inicio
                            @if ($sort == 'hora_inicio')
                                @if ($direction == 'asc')
                                    <i class="fas fa-sort-alpha-down float-right" style="margin-top: 4px"></i>
                                @else
                                    <i class="fas fa-sort-alpha-up float-right" style="margin-top: 4px"></i> 
                                @endif
                            @else
                                <i class="fas fa-sort float-right" style="margin-top: 4px"></i>
                            @endif
                        </th>
                        <th scope="col" wire:click="order('hora_fin')">Hora de fin
                            @if ($sort == 'hora_fin')
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
                    @if ($horarios->count())
                        @foreach ($horarios as $horario)
                            <tr class="text-wrap text-center">
                                <th scope="row" class="align-middle">{{ $horario->id }}</th>
                                <td class="align-middle text-left">{{ $horario->descripcion }}</td>
                                <td class="align-middle">{{ $horario->hora_inicio }}</td>
                                <td class="align-middle">{{ $horario->hora_fin }}</td>
                                <td class="align-middle text-nowrap">
                                    <button type="button" title="Editar" wire:click="seleccionarHorario({{ $horario->id }})" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                                    <button type="button" title="Eliminar" wire:click="$emit('eliminarRegistro', {{ $horario->id }})" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="text-center">
                            <td colspan="5">No existe ningún registro coincidente.</td>
                        </tr>
                    @endif
                </tbody>
            </table>

            @if ($horarios->hasPages())
                <div class="d-flex justify-content-end justify-content-sm-between pt-3 pb-0">
                    <div class="text-muted d-none d-sm-block pt-1">
                        Mostrando {{ $horarios->firstItem() }} a {{ $horarios->lastItem() }} de {{ $horarios->total() }} resultados
                    </div>
                    <div class="pagination-links">
                        {{ $horarios->links() }}
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
                    'El horario ha sido ' + accion + ' correctamente.',
                    'success'
                )
            });

            livewire.on('eliminarRegistro', horarioId => {
                Swal.fire({
                    title: '¿Está seguro?',
                    text: "¡Se eliminará el horario definitivamente!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '¡Sí, eliminar!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {

                        livewire.emitTo('horario.show', 'eliminarHorario', horarioId);

                        Swal.fire(
                            '¡Eliminado!',
                            'El horario ha sido eliminado.',
                            'success'
                        )
                    }
                })
            });
        </script>
    @endpush

</div>
