<div>
    
    @if ($vistaFormulario)
        <livewire:seccion.create>
    @elseif ($mostrarFormularioEditar)
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
                                <button type="button" wire:click="seleccionarSeccion({{ $seccion->id }})" class="btn btn-sm btn-primary ml-1 mr-1">Editar</button>
                                <button type="button" wire:click="eliminarRegistro({{ $seccion->id }})" class="btn btn-sm btn-danger">Eliminar</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    @endif

</div>


