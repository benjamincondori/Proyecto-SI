<div>

    @if ($vistaFormulario)
        <livewire:grupo.create>
    @elseif ($mostrarFormularioEditar)
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
                            <td class="align-middle d-flex">
                                <button type="button" wire:click="seleccionarGrupo({{ $grupo->id }})" class="btn btn-sm btn-primary ml-1 mr-1">Editar</button>
                                <button type="button" wire:click="eliminarRegistro({{ $grupo->id }})" class="btn btn-sm btn-danger">Eliminar</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    @endif

</div>
