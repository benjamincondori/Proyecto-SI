<div>
    
    @if ($vistaCrear)
        <livewire:disciplina.create>
    @elseif ($vistaEditar)
        <livewire:disciplina.edit>
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
                    Nueva Disciplina
                </button>

            </div>

            <table class="table table-bordered mb-0">
                <thead class="text-center">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Seccion</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($disciplinas as $disciplina)
                        <tr class="text-wrap">
                            <th scope="row" class="align-middle">{{ $disciplina->id }}</th>
                            <td class="align-middle">{{ $disciplina->nombre }}</td>
                            <td class="align-middle">{{ $disciplina->descripcion }}</td>
                            <td class="align-middle">{{ $disciplina->precio }}</td>
                            <td class="align-middle">{{ $this->obtenerNombreSeccion($disciplina->id_seccion ) }}</td>
                            <td class="align-middle text-nowrap">
                                <button type="button" title="Editar" wire:click="seleccionarDisciplina({{ $disciplina->id }})" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                                <button type="button" title="Eliminar" wire:click="$emit('eliminarRegistro', {{ $disciplina->id }})" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
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
                    'La disciplina ha sido ' + accion + ' correctamente.',
                    'success'
                )
            });

            livewire.on('eliminarRegistro', disciplinaId => {
                Swal.fire({
                    title: '¿Está seguro?',
                    text: "¡Se eliminará la disciplina definitivamente!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '¡Sí, eliminar!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {

                        livewire.emitTo('disciplina.show', 'eliminarDisciplina', disciplinaId);

                        Swal.fire(
                            '¡Eliminado!',
                            'La disciplina ha sido eliminado.',
                            'success'
                        )
                    }
                })
            });
        </script>
    @endpush

</div>



