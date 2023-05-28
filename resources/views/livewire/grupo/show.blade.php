<div>

    @if ($vistaCrear)
        <livewire:grupo.create>
    @elseif ($vistaEditar)
        <livewire:grupo.edit>
    @else
        <div class="table-responsive">
            <div class="mb-2 d-flex justify-content-between">
                <form class="app-search">
                    <div class="app-search-box">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Buscar...">
                            <div class="input-group-append">
                                <button class="btn text-secondary" type="">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

                <button type="button" wire:click="agregarNuevo" class="btn btn-primary waves-effect waves-light">
                    <i class="fas fa-plus-circle"></i>&nbsp;
                    Nuevo Grupo
                </button>

            </div>

            <table class="table table-bordered mb-0">
                <thead class="text-center">
                    <tr>
                        <th>ID</th>
                        <th>Grupo</th>
                        <th>Nro de integrantes</th>
                        <th>Disciplina</th>
                        <th>Entrenador</th>
                        <th>Horario</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($grupos as $grupo)
                        <tr class="text-wrap">
                            <th scope="row" class="align-middle">{{ $grupo->id }}</th>
                            <td class="align-middle">{{ $grupo->nombre }}</td>
                            <td class="align-middle">{{ $grupo->nro_integrantes }}</td>
                            <td class="align-middle">{{ $this->obtenerNombreDisciplina($grupo->id_disciplina) }}</td>
                            <td class="align-middle">{{ $this->obtenerNombreEntrenador($grupo->id_entrenador) }}</td>
                            <td class="align-middle">{{ $this->obtenerNombreHorario($grupo->id_horario) }}</td>
                            <td class="align-middle text-nowrap">
                                <button type="button" title="Editar" wire:click="seleccionarGrupo({{ $grupo->id }})" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                                <button type="button" title="Eliminar" wire:click="$emit('eliminarRegistro', {{ $grupo->id }})" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
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
                    'El grupo ha sido ' + accion + ' correctamente.',
                    'success'
                )
            });

            livewire.on('eliminarRegistro', grupoId => {
                Swal.fire({
                    title: '¿Está seguro?',
                    text: "¡Se eliminará el grupo definitivamente!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '¡Sí, eliminar!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {

                        livewire.emitTo('grupo.show', 'eliminarGrupo', grupoId);

                        Swal.fire(
                            '¡Eliminado!',
                            'El grupo ha sido eliminado.',
                            'success'
                        )
                    }
                })
            });
        </script>
    @endpush

</div>
