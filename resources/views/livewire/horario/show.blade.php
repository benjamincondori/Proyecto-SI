<div>

    @if ($vistaCrear)
        <livewire:horario.create>
    @elseif ($vistaEditar)
        <livewire:horario.edit>
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
                    Nuevo Horario
                </button>

            </div>

            <table class="table table-bordered mb-0">
                <thead class="text-center">
                    <tr>
                        <th>ID</th>
                        <th>Descripción</th>
                        <th>Hora de inicio</th>
                        <th>Hora de fin</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($horarios as $horario)
                        <tr class="text-wrap">
                            <th scope="row" class="align-middle text-center">{{ $horario->id }}</th>
                            <td class="align-middle">{{ $horario->descripcion }}</td>
                            <td class="align-middle text-center">{{ $horario->hora_inicio }}</td>
                            <td class="align-middle text-center">{{ $horario->hora_fin }}</td>
                            <td class="align-middle text-center text-nowrap">
                                <button type="button" title="Editar" wire:click="seleccionarHorario({{ $horario->id }})" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                                <button type="button" title="Eliminar" wire:click="$emit('eliminarRegistro', {{ $horario->id }})" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
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
