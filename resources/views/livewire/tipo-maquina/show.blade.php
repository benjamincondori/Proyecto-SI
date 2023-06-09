<div>

    @if ($vistaCrear)
        <livewire:tipo-maquina.create>
    @elseif ($vistaEditar)
        <livewire:tipo-maquina.edit>
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
                    Nueva Máquina
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
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($maquinas->count())
                        @foreach ($maquinas as $maquina)
                            <tr class="text-wrap text-center">
                                <th scope="row" class="align-middle">{{ $maquina->id }}</th>
                                <td class="align-middle text-left">{{ $maquina->nombre }}</td>
                                <td class="align-middle text-left">{{ $maquina->descripcion }}</td>
                                <td class="align-middle text-nowrap">
                                    <button type="button" title="Editar" wire:click="seleccionarMaquina({{ $maquina }})" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                                    <button type="button" title="Eliminar" wire:click="$emit('eliminarRegistro', {{ $maquina->id }})" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
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
            
            @if ($maquinas->hasPages())
                <div class="d-flex justify-content-end justify-content-sm-between pt-3 pb-0">
                    <div class="text-muted d-none d-sm-block pt-1">
                        Mostrando {{ $maquinas->firstItem() }} a {{ $maquinas->lastItem() }} de {{ $maquinas->total() }} resultados
                    </div>
                    <div class="pagination-links">
                        {{ $maquinas->links() }}
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
                    'La máquina ha sido ' + accion + ' correctamente.',
                    'success'
                )
            });

            livewire.on('eliminarRegistro', maquinaId => {
                Swal.fire({
                    title: '¿Está seguro?',
                    text: "¡Se eliminará la máquina definitivamente!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '¡Sí, eliminar!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {

                        livewire.emitTo('tipo-maquina.show', 'eliminarMaquina', maquinaId);

                        Swal.fire(
                            '¡Eliminado!',
                            'La máquina ha sido eliminado.',
                            'success'
                        )
                    }
                })
            });
        </script>
    @endpush

</div>

