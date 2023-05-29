<div>

    @if ($vistaCrear)
        <livewire:tipo-maquina.create>
    @elseif ($vistaEditar)
        <livewire:tipo-maquina.edit>
    @else
        <div class="table-responsive">
            <div class="mb-2 d-flex justify-content-between">

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

            {{-- @if ($maquinas->count()) --}}
                <table class="table table-bordered mb-0">
                    <thead class="text-center">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($maquinas->count())
                            @foreach ($maquinas as $maquina)
                                <tr class="text-wrap">
                                    <th scope="row" class="align-middle">{{ $maquina->id }}</th>
                                    <td class="align-middle">{{ $maquina->nombre }}</td>
                                    <td class="align-middle">{{ $maquina->descripcion }}</td>
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
            
            <div class="d-flex justify-content-end justify-content-sm-between pt-2 pb-0">
                <div class="text-muted d-none d-sm-block pt-1">
                    Mostrando registros del {{ $maquinas->firstItem() }} al {{ $maquinas->lastItem() }} de un total de {{ $maquinas->total() }} registros
                </div>
                <div class="pagination-links">
                    {{ $maquinas->links() }}
                </div>
            </div>

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

