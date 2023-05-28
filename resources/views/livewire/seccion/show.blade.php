<div>
    
    @if ($vistaCrear)
        <livewire:seccion.create>
    @elseif ($vistaEditar)
        <livewire:seccion.edit>
    @else
        <div class="table-responsive">
            <div class="mb-2 d-flex justify-content-between">
                <form class="app-search">
                    <div class="app-search-box">
                        <div class="input-group">
                            <input type="text" wire:model="buscar" class="form-control" placeholder="Buscar...">
                            <div class="input-group-append">
                                <button class="btn text-secondary" wire:click="buscar" type="button">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

                <button type="button" wire:click="agregarNuevo" class="btn btn-primary waves-effect waves-light">
                    <i class="fas fa-plus-circle"></i>&nbsp;
                    Nueva Sección
                </button>

            </div>

            <table class="table table-bordered mb-0">
                <thead class="text-center">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>capacidad</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($secciones as $seccion)
                        <tr class="text-wrap">
                            <th scope="row" class="align-middle">{{ $seccion->id }}</th>
                            <td class="align-middle">{{ $seccion->nombre }}</td>
                            <td class="align-middle">{{ $seccion->descripcion }}</td>
                            <td class="align-middle">{{ $seccion->capacidad }}</td>
                            <td class="align-middle text-nowrap">
                                <button type="button" title="Editar" wire:click="seleccionarSeccion({{ $seccion->id }})" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                                <button type="button" title="Eliminar" wire:click="$emit('eliminarRegistro', {{ $seccion->id }})" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    @endif

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            livewire.on('alert', function(accion) {

                var msj2 = accion.charAt(0).toUpperCase() + accion.slice(1);

                Swal.fire(
                    '¡' + msj2 + '!',
                    'La sección ha sido ' + accion + ' correctamente.',
                    'success'
                )
            });

            livewire.on('eliminarRegistro', seccionId => {
                Swal.fire({
                    title: '¿Está seguro?',
                    text: "¡Se eliminará la sección definitivamente!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '¡Sí, eliminar!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {

                        livewire.emitTo('seccion.show', 'eliminarSeccion', seccionId);

                        Swal.fire(
                            '¡Eliminado!',
                            'La sección ha sido eliminado.',
                            'success'
                        )
                    }
                })
            });
        </script>
    @endpush

</div>


