<div>
    
    @if ($vistaFormulario)
        <livewire:disciplina.create>
    @elseif ($mostrarFormularioEditar)
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
                                <button type="button" wire:click="seleccionarDisciplina({{ $disciplina->id }})" class="btn btn-sm btn-primary ml-1 mr-1">Editar</button>
                                <button type="button" wire:click="eliminarRegistro({{ $disciplina->id }})" class="btn btn-sm btn-danger">Eliminar</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    @endif

</div>



